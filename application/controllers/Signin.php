<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Controler Sign in
*/
class Signin extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(is_login()) redirect('dashboard');
		$this->load->model('M_users');
		$this->load->helper('captcha');
		$this->coba = intval($this->session->userdata('try'));
		$this->load->model('M_lokasi');
	}

	public function index($value='')
	{
		if ($this->input->post('signin')) {
			$this->form_validation->set_rules('username','Username');
			$this->form_validation->set_rules('password','Password','callback_cek_pass');
			$this->form_validation->set_rules('id_lokasi','Lokasi', 'required');
			if($this->coba>2) $this->form_validation->set_rules('captcha','Captcha','callback_cek_captcha');
			if($this->form_validation->run()){
				$try=$this->session->unset_userdata('try');
	      redirect('');
			}
		}
		
		$vals = array(
      'img_height'    => 30,
      'expiration'    => 7200,
      'word_length'   => 8,
      'font_size'     => 16,
      'img_id'        => 'Imageid',
      'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		  'img_path'      => './assets/images/',
		  'img_url'       => base_url().'/assets/images/'
		);
		$cap = create_captcha($vals);
		$data = array(
		  'captcha_time'  => $cap['time'],
		  'ip_address'    => get_ip(),
		  'word'          => $cap['word']
		);

		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		$data['captchaIMG'] = $cap['image'];
		$data['lokasi'] = $this->M_lokasi->show(null,null,null);
		$this->load->view('signin',$data);
	}

	public function refresh(){
		$vals = array(
		  'img_height'    => 30,
      'expiration'    => 7200,
      'word_length'   => 8,
      'font_size'     => 16,
      'img_id'        => 'Imageid',
      'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		  'img_path'      => './assets/images/',
		  'img_url'       => base_url().'/assets/images/'
		);

		$cap = create_captcha($vals);
		$data = array(
		  'captcha_time'  => $cap['time'],
		  'ip_address'    => get_ip(),
		  'word'          => $cap['word']
		);

		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);
		echo $cap['image'];
	}

	public function cek_pass()
	{
		@session_start();
		$username=strtolower($this->input->post('username'));
		$password=keyup($this->input->post('password'));
		$get=$this->M_users->sigin($username,$password);
		$lokasi = $this->input->post('id_lokasi');
		// echo $this->db->last_query();
		// exit;
		if($get->result()!=NULL) {
			$user_data['id']=$get->row()->id_user;
			$user_data['username']=$get->row()->username;
			$user_data['nama']=$get->row()->nama;
			$user_data['level']=$get->row()->level;
			$user_data['status']=$get->row()->status;
			$user_data['photo']=$get->row()->photo;
			$user_data['lokasi']=$lokasi;
			$this->session->set_userdata('user_data',$user_data);
			
			$log['datetime'] = date('Y-m-d H:i:s');
			$log['id_user'] = $get->row()->id_user;
			$log['id_lokasi'] = $lokasi;
			$log['status'] = 'online';
			$log['ip'] = get_ip();
			$this->M_users->log_insert($log);

			return TRUE;
		}
		else {
			$this->coba++;
			$this->session->set_userdata('try',$this->coba);
			$this->form_validation->set_message('cek_pass', 'Username/ Password tidak tepat.');
			return FALSE;
		}
	}

	public function cek_captcha()
  {
  	if (!$_POST['captcha']) {
  		$this->form_validation->set_message('cek_captcha', 'Captcha Harus diisi.');
		  return FALSE;
  	}
  	$expiration = time() - 900; // Two hour limit
		$this->db->where('captcha_time < ', $expiration)
		        ->delete('captcha');

		// Then see if a captcha exists:
    date_default_timezone_set('Asia/Jakarta');
    $date = new DateTime("@$expiration");
		// echo $date->format('Y-m-d H:i:s');
		// exit;
		$sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
		$binds = array($_POST['captcha'], get_ip(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0) {
			$this->form_validation->set_message('cek_captcha', 'Captcha tidak benar');
		  return FALSE;
    }
    else {
      return TRUE;
    }
  }
}