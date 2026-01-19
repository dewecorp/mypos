<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category extends CI_Controller {

	function __construct() 
    {
        parent::__construct();
        check_not_login();  
        // check_admin();      
        $this->load->model('category_m');
      
    }

	public function index()
	{
		$data['row'] = $this->category_m->get();
		$this->template->load('template', 'product/category/category_data', $data);
	}

	public function add() {
		$category =  new stdClass();
		$category->category_id = null;
		$category->name = null;		
		$data = array(
			'page' => 'add',
			'row' => $category
		);
		$this->template->load('template', 'product/category/category_form', $data);
	}

	public function edit($id) 
	{	
		$query = $this->category_m->get($id);
		if($query->num_rows() > 0 ) {
			$category = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $category
			);
			$this->template->load('template', 'product/category/category_form', $data);
		} else {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('category');
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($_POST['add'])) {
			$this->category_m->add($post);
			$this->fungsi->log_activity('create', 'category', null, 'Tambah kategori');
		} else if(isset($_POST['edit'])) {
			$this->category_m->edit($post);
			$this->fungsi->log_activity('update', 'category', $post['id'], 'Edit kategori');
		}
		
		if($this->db->affected_rows() > 0) {
           $this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil disimpan');
        }
            redirect('category');
	}

	public function del($id) 
	{
		$this->category_m->del($id);
		$this->fungsi->log_activity('delete', 'category', $id, 'Hapus kategori');
		if($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', '<strong>Selamat,</strong> Data berhasil dihapus');
        }
        redirect('category');

	}
}
