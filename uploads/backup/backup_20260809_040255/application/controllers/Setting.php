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
            $logo = null;
            if(!empty($_FILES['logo']['name'])) {
                $logo = $this->upload_logo();
                if($logo['status']) {
                    $logo = $logo['file'];
                } else {
                    $this->session->set_flashdata('error', $logo['message']);
                }
            }
            $this->setting_m->update($post);
            if(!empty($logo)) {
                $this->db->where('id', 1)->update('p_setting', ['logo' => $logo, 'updated' => date('Y-m-d H:i:s')]);
            }
            if($this->db->affected_rows() > 0 || !empty($logo)) {
                $this->fungsi->log_activity('update', 'setting', 1, 'Update pengaturan toko');
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
            }
            redirect('setting');
        }
    }

    private function upload_logo()
    {
        $dir = FCPATH.'uploads/logo';
        if(!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $config = array(
            'upload_path' => $dir,
            'allowed_types' => 'jpg|jpeg|png|svg|webp',
            'max_size' => 2048,
            'overwrite' => true,
            'file_name' => 'logo_' . time()
        );
        $this->load->library('upload', $config);
        if($this->upload->do_upload('logo')) {
            return ['status' => true, 'file' => $this->upload->data('file_name')];
        }
        return ['status' => false, 'message' => $this->upload->display_errors('', '')];
    }
}