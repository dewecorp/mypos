<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * @var User_m
	 */
	public $user_m;

	/**
	 * @var Fungsi
	 */
	public $fungsi;


	public function index()
	{
		$this->login();
	}

	public function login()
	{
		check_already_login();
		$this->load->view('login');
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
		if(isset($post['login'])) {
			$this->load->model('user_m');
			$query = $this->user_m->login($post);
			if($query->num_rows() > 0) {
				$row = $query->row();
				$params = array(
					'userid' => $row->user_id,
					'level' => $row->level
				);
				$this->session->set_userdata($params);
				$this->session->set_flashdata('success', 'Login berhasil');
				$this->fungsi->log_activity('login', 'user', $row->user_id, 'Login');
				redirect('sale');
				} else {
					$this->session->set_flashdata('error', 'Login gagal, username/password salah');
					redirect('auth/login');
				}
		}
	}

	public function logout()
	{
		$params = array('userid', 'level');
		$this->fungsi->log_activity('logout', 'user', $this->session->userdata('userid'), 'Logout');
		$this->session->unset_userdata($params);
		redirect('auth/login');
	}
}
