<?php
/**
* Controler Home
*/
class Dashboard extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_users');
		$this->load->model('M_setting');
	}

	public function index()
	{
		$id_user = my_userid();

		$data['title'] = 'Dashboard';
		//$data['subtitle'] = 'Dashboard';
		$data['br'] = '';
		$data['set'] = $this->M_setting->show();
		$data['online'] = $this->M_users->user_status($id_user);
		$data['dashboard'] = 'class="active"';
		$data['page'] = 'dashboard/daftar';
		$this->load->view('page', $data);
	}
}