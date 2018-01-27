<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_users');
	}
	
	public function index()
	{
		$log['datetime'] = date('Y-m-d H:i:s');
		$log['id_user'] = my_userid();
		$log['id_lokasi'] = my_location();
		$log['status'] = 'offline';
		$log['ip'] = get_ip();

		$this->M_users->log_insert($log);
		$this->session->sess_destroy();
		redirect('signin');
	}
}
