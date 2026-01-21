<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	function __construct() 
    {
        parent::__construct();
        check_not_login();  
        // check_admin();      
        $this->load->model('setting_m');
    }

	public function index()
	{
		$data['row'] = $this->setting_m->get();
		$this->template->load('template', 'setting/setting_data', $data);
	}

    public function update() 
    {
        $post = $this->input->post(null, TRUE);
        if(isset($post['update_setting'])) {
            $this->setting_m->update($post);
            if($this->db->affected_rows() > 0) {
                $this->fungsi->log_activity('update', 'setting', 1, 'Edit data toko');
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
            }
            redirect('setting');
        }
    }
}