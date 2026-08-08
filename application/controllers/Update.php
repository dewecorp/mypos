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

    public function check()
    {
        $has = $this->updater->has_update();
        $show = false;
        if($has['ok'] && $has['has'] && !$this->session->userdata('update_notif_seen')) {
            $this->session->set_userdata('update_notif_seen', 1);
            $show = true;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('has' => $has, 'show_notif' => $show)));
    }

    public function run()
    {
        if(!$this->input->is_ajax_request() || strtoupper($this->input->method()) !== 'POST') {
            show_404();
            return;
        }
        // Hanya admin (check_admin di constructor). Tanpa verifikasi password tambahan.
        $res = $this->updater->run_update();
        $this->respond($res['status'], $res['message']);
    }

    private function respond($success, $message)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => (bool)$success, 'message' => $message)));
    }
}
