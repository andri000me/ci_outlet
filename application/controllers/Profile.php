<?php
/**
 * summary
 */
class Profile extends CI_Controller
{
  /**
   * summary
   */
  public function __construct()
  {
    parent::__construct();
    if(!is_login()) redirect('signin');
    $this->load->model('M_users');
    $this->load->model('M_lokasi');
  }

  public function index()
	{
		$id_user = my_userid();
		if ($this->input->post('simpan')) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
			if ($this->input->post('password_new')) {
				$this->form_validation->set_rules('password_new', 'Password', 'required|min_length[5]');
				$this->form_validation->set_rules('re_password', 'Ulang Password', 'required|matches[password_new]');
			}
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			if ($this->form_validation->run()) {
				if ($this->input->post('password_new')) {
					$arr_data['password'] = keyup($this->input->post('password_new'));
				}
				$variable = array('username', 'id_lokasi', 'nama', 'alamat', 'telp1', 'telp2');
				foreach ($variable as $key) {
					$arr_data[$key] = $this->input->post($key);
				}
				$file = $_FILES['userfile'];
				if (!empty($file)) {
					$blob = file_get_contents($_FILES['userfile']['tmp_name']);
					$set['photo'] = $blob;
				}
				$this->M_users->update($arr_data, $id_user);
				$this->session->set_flashdata('msgg',msg_success('Data berhasil dirubah.'));
				redirect('profile');
			}
		}
		elseif ($this->input->post('batal')) redirect('dashboard');
		$data['listdata'] = $this->M_users->get($id_user);
		// $data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['title'] = 'Profile';
		$data['subtitle'] = 'User';
		$data['br'] = array();
		// $data['users'] = 'class="active"';
		$data['page'] = 'users/ubah';
		$this->load->view('page', $data);
	}
}
?>