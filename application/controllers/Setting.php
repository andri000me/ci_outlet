<?php
/**
* 
*/
class Setting extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_setting');
	}

	public function index()
	{
		if ($this->input->post('simpan')) {
			$set['nama'] = $this->input->post('nama');
			$set['alamat'] = $this->input->post('alamat');
			$set['telp'] = $this->input->post('telp');
			$set['pin'] = $this->input->post('pin');
			$set['ig'] = $this->input->post('ig');
			$set['keterangan'] = $this->input->post('keterangan');
			$set['tips'] = $this->input->post('tips');
			$file = $_FILES['userfile'];
			if (!empty($file)) {
				if ($_FILES['userfile']['tmp_name']) {
					$blob = file_get_contents($_FILES['userfile']['tmp_name']);
					$set['logo'] = $blob;
				}
			}
			$this->M_setting->update($set);
			$this->session->set_flashdata('msg',msg_success('Setting berhasil dirubah.'));
			redirect('setting');
		}
		elseif ($this->input->post('batal')) redirect('dashboard');
		$data['listdata'] = $this->M_setting->show();
		$data['title'] = 'Setting';
		$data['br'] = '';
		$data['setting'] = 'class="active"';
		$data['js'] = 'setting';
		$data['page'] = 'setting';
		$this->load->view('page', $data);
	}
}
