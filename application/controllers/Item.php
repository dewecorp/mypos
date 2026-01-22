<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class item extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['item_m']);

	}

	
	public function index()
	{
		$data['row'] = $this->item_m->get();
		$this->template->load('template', 'product/item/item_data', $data);
	}

	public function add() {
		$item =  new stdClass();
		$item->item_id = null;
        $item->barcode = null;
        $item->name = null;
		$item->price = null;
        $item->stock = null;

		$data = array(
			'page' => 'add',
            'row' => $item,
		);
		$this->template->load('template', 'product/item/item_form', $data);
	}

	public function edit($id)
	{
		$query = $this->item_m->get($id);
		if($query->num_rows() > 0 ) {
			$item = $query->row();

			$data = array(
				'page' => 'edit',
				'row' => $item,
			);
			$this->template->load('template', 'product/item/item_form', $data);
		} else {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('item');
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['add'])) {
			// Auto generate barcode if not provided
			if(empty($post['barcode'])) {
				$this->item_m->add($post);
				$this->fungsi->log_activity('create', 'item', null, 'Tambah barang');
				if($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil disimpan');
				}
				redirect('item');
			} else {
				if($this->item_m->check_barcode($post['barcode'])->num_rows() > 0) {
					$this->session->set_flashdata('error', "Barcode $post[barcode] sudah dipakai barang lain");
					redirect('item');
				} else {
					$this->item_m->add($post);
					$this->fungsi->log_activity('create', 'item', null, 'Tambah barang');
					if($this->db->affected_rows() > 0) {
						$this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil disimpan');
					}
					redirect('item');
				}
			}

		} else if(isset($_POST['edit'])) {
			$this->item_m->edit($post);
			$this->fungsi->log_activity('update', 'item', $post['id'], 'Edit barang');
			if($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil disimpan');
			}
			redirect('item');
		}
	}



	public function del($id)
	{
		$this->item_m->del($id);
		$this->fungsi->log_activity('delete', 'item', $id, 'Hapus barang');
		if($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil dihapus');
        }
            redirect('item');
	}

	public function download_template() {
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Nama Barang');
		$sheet->setCellValue('B1', 'Harga');
		
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$filename = 'template_barang.xlsx';
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');
	}

	public function import() {
		if(isset($_FILES['file']['name'])) {
			$path = $_FILES['file']['tmp_name'];
			try {
				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
				$sheet = $spreadsheet->getActiveSheet();
				$rows = $sheet->toArray();
				
				$count = 0;
				$success = 0;
				$failed = 0;

				foreach($rows as $key => $row) {
					if($key == 0) continue; // skip header
					
					$name = $row[0];
					$price = $row[1];
					
					if($name && $price) {
						$data = [
							'barcode' => null, // will be generated in model
							'product_name' => $name,
							'price' => $price
						];
						$this->item_m->add($data);
						$success++;
					}
				}
				
				if($success > 0) {
					$this->fungsi->log_activity('import', 'item', null, "Import $success barang");
				}
				echo json_encode(['success' => true, 'message' => "Berhasil import $success data. Gagal/Duplikat: $failed"]);
			} catch(Exception $e) {
				echo json_encode(['success' => false, 'message' => 'Gagal memproses file: ' . $e->getMessage()]);
			}
		} else {
			 echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
		}
	}

	function barcode_qrcode($id) {
		$data['row'] = $this->item_m->get($id)->row();
		$this->template->load('template', 'product/item/barcode_qrcode', $data);
	}

	function barcode_print($id) {
		$data['row'] = $this->item_m->get($id)->row();
		$this->load->view('product/item/barcode_print', $data);
	}

	function qrcode_print($id) {
		$data['row'] = $this->item_m->get($id)->row();
		$this->load->view('product/item/qrcode_print', $data);
	}

	function barcode_print_all() {
		$data['row'] = $this->item_m->get()->result();
		$this->load->view('product/item/barcode_print_all', $data);
	}

	function qrcode_print_all() {
		$data['row'] = $this->item_m->get()->result();
		$this->load->view('product/item/qrcode_print_all', $data);
	}
}
