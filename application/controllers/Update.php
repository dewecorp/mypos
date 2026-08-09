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
        if(!isset($_POST['run_update'])) { show_404(); return; }
        $ajax = ($this->input->post('ajax') === '1');
        $res = array('ok' => false, 'message' => '');
        try {
            $res = $this->updater->run_update();
        } catch(Exception $e) {
            $res = array('ok' => false, 'message' => 'Terjadi kesalahan: '.$e->getMessage());
        }
        if($ajax) {
            $this->output->set_content_type('application/json')
                ->set_output(json_encode($res));
            return;
        }
        if(!empty($res['ok'])) {
            $this->session->set_flashdata('success', $res['message']);
        } else {
            $this->session->set_flashdata('error', $res['message']);
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

    public function test()
    {
        $cur = $this->updater->current_version();
        $late = $this->updater->latest_version();
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(array(
                'ok'         => true,
                'current'    => $cur,
                'latest'     => $late,
                'tersedia'   => ($late !== null && version_compare($late, $cur, '>')),
                'writable'   => (is_writable(FCPATH) && is_writable(FCPATH.'version.txt')),
                'curl'       => function_exists('curl_init'),
                'waktu'      => date('Y-m-d H:i:s')
            )));
    }
}