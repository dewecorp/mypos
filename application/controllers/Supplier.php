<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function __construct() 
    {
        parent::__construct();
        check_not_login();  
        // check_admin();      
        $this->load->model('supplier_m');
      
    }

	public function index()
	{
		$data['row'] = $this->supplier_m->get();
		$this->template->load('template', 'supplier/supplier_data', $data);
	}

	public function add() {
		$supplier =  new stdClass();
		$supplier->supplier_id = null;
		$supplier->name = null;
		$supplier->phone = null;
		$supplier->address = null;
		$supplier->description = null;
		$data = array(
			'page' => 'add',
			'row' => $supplier
		);
		$this->template->load('template', 'supplier/supplier_form', $data);
	}

	public function edit($id) 
	{	
		$query = $this->supplier_m->get($id);
		if($query->num_rows() > 0 ) {
			$supplier = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $supplier
			);
			$this->template->load('template', 'supplier/supplier_form', $data);
		} else {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('supplier');
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['add'])) {
			$this->supplier_m->add($post);
			$this->fungsi->log_activity('create', 'supplier', null, 'Tambah supplier');
		} else if(isset($_POST['edit'])) {
			$this->supplier_m->edit($post);
			$this->fungsi->log_activity('update', 'supplier', $post['id'], 'Edit supplier');
		}
		
		if($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }
        redirect('supplier');
	}

	public function del($id) 
	{
		$this->supplier_m->del($id);
		$error = $this->db->error();
		if($error['code'] != 0) {
			$this->session->set_flashdata('error', 'Data tidak dapat dihapus (sudah berelasi)');
		}
		else {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
            $this->fungsi->log_activity('delete', 'supplier', $id, 'Hapus supplier');
        }
        redirect('supplier');

	}
}
