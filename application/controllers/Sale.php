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
			echo json_encode(['success' => false, 'message' => 'Item kosong']);
			return;
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
			]);
		}
		$this->sale_m->add_sale_detail($detail);
		$this->db->trans_complete();
		if($this->db->trans_status()) {
			echo json_encode(['success' => true, 'sale_id' => $sale_id, 'invoice' => $header['invoice']]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Gagal simpan transaksi']);
		}
	}
}
