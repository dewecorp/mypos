<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class unit extends CI_Controller {

	function __construct() 
    {
        parent::__construct();
        check_not_login();  
        // check_admin();      
        $this->load->model('unit_m');
      
    }

	public function index()
	{
		$data['row'] = $this->unit_m->get();
		$this->template->load('template', 'product/unit/unit_data', $data);
	}

	public function add() {
		$unit =  new stdClass();
		$unit->unit_id = null;
		$unit->name = null;		
		$data = array(
			'page' => 'add',
			'row' => $unit
		);
		$this->template->load('template', 'product/unit/unit_form', $data);
	}

	public function edit($id) 
	{	
		$query = $this->unit_m->get($id);
		if($query->num_rows() > 0 ) {
			$unit = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $unit
			);
			$this->template->load('template', 'product/unit/unit_form', $data);
		} else {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('unit');
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['add'])) {
			$this->unit_m->add($post);
			$this->fungsi->log_activity('create', 'unit', null, 'Tambah satuan');
		} else if(isset($_POST['edit'])) {
			$this->unit_m->edit($post);
			$this->fungsi->log_activity('update', 'unit', $post['id'], 'Edit satuan');
		}
		
		if($this->db->affected_rows() > 0) {
           $this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil disimpan');
        }
            redirect('unit');
	}

	public function del($id) 
	{
		$this->unit_m->del($id);
		$this->fungsi->log_activity('delete', 'unit', $id, 'Hapus satuan');
		if($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil dihapus');
        }
        redirect('unit');

	}
}
