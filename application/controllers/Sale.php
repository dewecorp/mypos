<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {
	function __construct()
		{
				parent::__construct();
				check_not_login();
				$this->load->model('sale_m');
				$this->load->model('item_m');
				$this->load->model('stock_m');
		}

	public function index()
	{
		$this->load->model('customer_m');
		$customer = $this->customer_m->get()->result();
		$items = $this->item_m->get()->result();
		$data = array(
			'customer' => $customer,
			'invoice' => $this->sale_m->invoice_no(),
			'items' => $items,
		);
		$this->template->load('template', 'transaction/sale/sale_form', $data);
	}

	public function get_item()
	{
		$barcode = $this->input->get('barcode', TRUE);
		$q = $this->sale_m->get_item_by_barcode($barcode);
		if($q->num_rows() > 0) {
			$row = $q->row();
			echo json_encode([
				'success' => true,
				'item_id' => $row->item_id,
				'barcode' => $row->barcode,
				'name' => $row->name,
				'price' => (int)$row->price,
				'stock' => (int)$row->stock
			]);
		} else {
			echo json_encode(['success' => false]);
		}
	}

	public function process()
	{
		$post = $this->input->post(NULL, TRUE);
		$items = isset($post['items']) ? json_decode($post['items'], true) : [];
		if(empty($items)) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['success' => false, 'message' => 'Item kosong']));
			return;
		}
		// Validasi stok server-side
		foreach($items as $it) {
			$row = $this->item_m->get((int)$it['item_id'])->row();
			if(!$row) {
				$this->output->set_content_type('application/json')
					->set_output(json_encode(['success' => false, 'message' => 'Item tidak ditemukan']));
				return;
			}
			if((int)$row->stock < (int)$it['qty']) {
				$this->output->set_content_type('application/json')
					->set_output(json_encode(['success' => false, 'message' => 'Stok tidak cukup untuk '.$row->name]));
				return;
			}
		}
		$header = [
			'invoice' => $post['invoice'],
			'customer_id' => $post['customer'] === '' ? NULL : (int)$post['customer'],
			'total_price' => (int)$post['sub_total'],
			'discount' => (int)$post['discount'],
			'final_price' => (int)$post['grand_total'],
			'cash' => (int)$post['cash'],
			'remaining' => (int)$post['change'],
			'note' => $post['note'],
			'date' => $post['date'],
			'user_id' => $this->session->userdata('userid'),
		];
		$this->db->trans_start();
		$sale_id = $this->sale_m->add_sale($header);
		$detail = [];
		foreach($items as $it) {
			$detail[] = [
				'sale_id' => $sale_id,
				'item_id' => (int)$it['item_id'],
				'price' => (int)$it['price'],
				'qty' => (int)$it['qty'],
				'discount' => (int)$it['discount'],
				'total' => (int)$it['total'],
			];
			$this->item_m->update_stock_out([
				'item_id' => (int)$it['item_id'],
				'qty' => (int)$it['qty'],
			]);
			$this->stock_m->add_stock_out([
				'item_id' => (int)$it['item_id'],
				'detail' => 'sale '.$header['invoice'],
				'qty' => (int)$it['qty'],
				'date' => $header['date'],
				'supplier' => ''
			]);
		}
		$this->sale_m->add_sale_detail($detail);
		$this->db->trans_complete();
		if($this->db->trans_status()) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['success' => true, 'sale_id' => $sale_id, 'invoice' => $header['invoice']]));
			$this->fungsi->log_activity('create', 'sale', $sale_id, 'Transaksi '.$header['invoice']);
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['success' => false, 'message' => 'Gagal simpan transaksi']));
		}
	}

	public function invoice($sale_id)
	{
		$header = $this->sale_m->get_sale($sale_id)->row();
		$details = $this->sale_m->get_sale_details($sale_id)->result();
		$this->load->view('transaction/sale/invoice', ['header' => $header, 'details' => $details]);
	}

	public function report()
	{
		$start = $this->input->get('start', TRUE) ?: date('Y-m-01');
		$end = $this->input->get('end', TRUE) ?: date('Y-m-d');
		$data = $this->sale_m->get_sales_by_period($start, $end)->result();
		$this->template->load('template', 'transaction/sale/report', ['rows' => $data, 'start' => $start, 'end' => $end]);
	}

	public function delete($sale_id)
	{
		$header = $this->sale_m->get_sale($sale_id)->row();
		if(!$header) { show_404(); return; }
		$details = $this->sale_m->get_sale_details($sale_id)->result();
		$this->db->trans_start();
		foreach($details as $d) {
			$this->item_m->update_stock_in(['item_id' => $d->item_id, 'qty' => $d->qty]);
		}
		$this->stock_m->delete_by_detail('sale '.$header->invoice);
		$this->db->where('sale_id', $sale_id)->delete('t_sale_detail');
		$this->db->where('sale_id', $sale_id)->delete('t_sale');
		$this->db->trans_complete();
		if($this->db->trans_status()) {
			$this->session->set_flashdata('success', 'Transaksi dihapus');
			$this->fungsi->log_activity('delete', 'sale', $sale_id, 'Hapus transaksi '.$header->invoice);
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus transaksi');
		}
		redirect('sale/report');
	}

	public function delete_bulk()
	{
		// Support ids sent as array ids[] or ids
		$ids = $this->input->post('ids');
		if($ids === NULL) { $ids = $this->input->post('ids[]'); }
		if(is_string($ids)) { $ids = explode(',', $ids); }
		if(!is_array($ids)) { $ids = []; }
		$normalized = [];
		foreach($ids as $sid) {
			$sid = is_string($sid) ? trim($sid) : $sid;
			$normalized[] = (int)$sid;
		}
		$ids = $normalized;
		if(empty($ids)) {
			$this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'IDs kosong']));
			return;
		}
		$this->db->trans_start();
		$deleted = 0;
		foreach($ids as $sale_id) {
			$header = $this->sale_m->get_sale($sale_id)->row();
			if(!$header) { continue; }
			$details = $this->sale_m->get_sale_details($sale_id)->result();
			foreach($details as $d) {
				$this->item_m->update_stock_in(['item_id' => $d->item_id, 'qty' => $d->qty]);
			}
			$this->stock_m->delete_by_detail('sale '.$header->invoice);
			$this->db->where('sale_id', $sale_id)->delete('t_sale_detail');
			$this->db->where('sale_id', $sale_id)->delete('t_sale');
			$deleted++;
		}
		$this->db->trans_complete();
		$ok = $this->db->trans_status() && $deleted > 0;
		$response = $ok ? ['success' => true, 'deleted' => $deleted] : ['success' => false, 'message' => 'Tidak ada data dihapus'];
		if($ok) { $this->fungsi->log_activity('delete', 'sale', null, 'Hapus '.$deleted.' transaksi'); }
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function delete_one()
	{
		$id = (int)$this->input->post('id');
		if(!$id) {
			$this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'ID tidak valid']));
			return;
		}
		$header = $this->sale_m->get_sale($id)->row();
		if(!$header) {
			$this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Data tidak ditemukan']));
			return;
		}
		$details = $this->sale_m->get_sale_details($id)->result();
		$this->db->trans_start();
		foreach($details as $d) {
			$this->item_m->update_stock_in(['item_id' => $d->item_id, 'qty' => $d->qty]);
		}
		$this->stock_m->delete_by_detail('sale '.$header->invoice);
		$this->db->where('sale_id', $id)->delete('t_sale_detail');
		$this->db->where('sale_id', $id)->delete('t_sale');
		$this->db->trans_complete();
		$ok = $this->db->trans_status();
		$this->output->set_content_type('application/json')->set_output(json_encode($ok ? ['success' => true] : ['success' => false, 'message' => 'Gagal menghapus']));
	}

	public function purge_older_than_days($days = 30)
	{
		$days = (int)$days;
		if($days <= 0) $days = 30;
		$cutoff = date('Y-m-d', strtotime("-{$days} days"));

		$this->db->trans_start();
		$sales = $this->sale_m->get_sales_older_than($cutoff)->result();
		foreach($sales as $row) {
			$this->stock_m->delete_by_detail('sale '.$row->invoice);
			$this->db->where('sale_id', $row->sale_id)->delete('t_sale_detail');
			$this->db->where('sale_id', $row->sale_id)->delete('t_sale');
		}
		$this->stock_m->delete_older_than($cutoff);
		$this->db->trans_complete();

		if($this->input->is_ajax_request()) {
			$this->output->set_content_type('application/json')->set_output(json_encode(['success' => $this->db->trans_status(), 'cutoff' => $cutoff, 'deleted_sales' => count($sales)]));
			return;
		}
		if($this->db->trans_status()) {
			$this->session->set_flashdata('success', 'Data transaksi dan stok lebih lama dari '.$days.' hari telah dihapus');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus data lama');
		}
		redirect('sale/report');
	}
}
