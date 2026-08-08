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
        if(!$this->input->is_ajax_request() || strtoupper($this->input->method()) !== 'POST') {
            show_404();
            return;
        }
        try {
            $res = $this->updater->run_update();
            $this->respond($res['status'], $res['message']);
        } catch(Exception $e) {
            $this->respond(false, 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    private function respond($success, $message)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => (bool)$success, 'message' => $message)));
    }
}