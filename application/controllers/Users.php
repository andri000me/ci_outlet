<?php
/**
* Controller Users
*/
class Users extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_users');
		$this->load->model('M_lokasi');
	}

	public function index($param1=null, $param2=null, $param3=null)
	{
		$total_row=$this->M_users->count();
		$perpage=15;
		$uri_segment=3;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'users/index/';
		$config['total_rows']  = $total_row;
		$config['per_page']    = $perpage;
		$config['uri_segment'] = $uri_segment;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';//'&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';//'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';//'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';//'&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();	
		$data['no']=$offset+1;
		$data['listdata'] = $this->M_users->show(null, $perpage, $offset);
		$data['title'] = 'Users';
		$data['subtitle'] = 'List Daftar User';
		$data['br'] = '';
		$data['users'] = 'class="active"';
		$data['js'] = 'users/daftar';
		$data['page'] = 'users/daftar';
		$this->load->view('page', $data);
	}

	public function tambah($param1=null, $param2=null, $param3=null)
	{
		if ($this->input->post('simpan')) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('password_new', 'Password', 'required|min_length[5]');
			$this->form_validation->set_rules('re_password', 'Password', 'required|matches[password_new]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			if ($this->form_validation->run()) {
				$arr_data['id_user'] = $this->M_users->newid();
				$arr_data['password'] = keyup($this->input->post('password_new'));
				$variable = array('username', 'level', 'nama', 'alamat', 'telp1', 'telp2');
				foreach ($variable as $key) {
					$arr_data[$key] = $this->input->post($key);
				}
				$file = $_FILES['userfile'];
				if (!empty($file)) {
					$blob = file_get_contents($_FILES['userfile']['tmp_name']);
					$set['photo'] = $blob;
				}
				$this->M_users->insert($arr_data);
				$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
				redirect('users');
			}
		}
		elseif ($this->input->post('batal')) redirect('users');
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['title'] = 'Users';
		$data['subtitle'] = 'Tambah User Baru';
		$data['br'] = array();
		$data['js'] = 'users/tambah';
		$data['users'] = 'class="active"';
		$data['page'] = 'users/tambah';
		$this->load->view('page', $data);
	}

	public function ubah($param1=null, $param2=null, $param3=null)
	{
		$id_user = decrypts($param1);
		if ($this->input->post('simpan')) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('password_new', 'Password', 'required|min_length[5]');
			$this->form_validation->set_rules('re_password', 'Password', 'required|matches[password_new]');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			if ($this->form_validation->run()) {
				$arr_data['password'] = keyup($this->input->post('password_new'));
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
				$this->session->set_flashdata('msg',msg_success('Data berhasil dirubah.'));
				redirect('users');
			}
		}
		elseif ($this->input->post('batal')) redirect('users');
		$data['listdata'] = $this->M_users->get($id_user);
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['title'] = 'Users';
		$data['subtitle'] = 'Ubah Data User';
		$data['br'] = array();
		$data['users'] = 'class="active"';
		$data['page'] = 'users/ubah';
		$this->load->view('page', $data);
	}

	public function detail($param1=null, $param2=null, $param3=null)
	{
		$id_user = decrypts($param1);
		$data['listdata'] = $this->M_users->get($id_user);
		$data['title'] = 'Users';
		$data['subtitle'] = 'Detail Data User';
		$data['br'] = array();
		$data['users'] = 'class="active"';
		$data['page'] = 'users/detail';
		$this->load->view('page', $data);
	}

	public function hapus($param1=null, $param2=null, $param3=null)
	{
		$id_user = decrypts($param1);
		$this->M_users->delete($id_user);
		$this->session->set_flashdata('msg',msg_success('Data berhasil dihapus.'));
		redirect('users');
	}

	public function ganti_password($param1=null, $param2=null, $param3=null)
	{
		$data['title'] = 'Users';
		$data['subtitle'] = 'Ganti Password';
		$data['br'] = '';
		$data['users'] = 'class="active"';
		$data['page'] = 'users/ganti_password';
		$this->load->view('page', $data);
	}
}