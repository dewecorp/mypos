<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->library('updater');
    }

    public function run()
    {
        if(empty($this->input->post('run_update'))) { show_404(); return; }
        try {
            $res = $this->updater->run_update();
            if(!empty($res['ok'])) {
                $this->session->set_flashdata('success', $res['message']);
            } else {
                $this->session->set_flashdata('error', $res['message']);
            }
        } catch(Exception $e) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
        $back = $this->input->server('HTTP_REFERER');
        if($back) { redirect($back); } else { redirect('dashboard'); }
    }

    public function check()
    {
        $current = $this->updater->current_version();
        $latest = $this->updater->latest_version();
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(array(
                'current' => $current,
                'latest' => $latest,
                'has' => ($latest !== null && version_compare($latest, $current, '>'))
            )));
    }
}