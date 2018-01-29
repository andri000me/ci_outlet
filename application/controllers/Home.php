<?php
/**
 * Home
 */
class Home extends CI_Controller
{
  /**
   * Home
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_blog');
  }

  function index()
  {
    $data['product'] = $this->M_blog->show(null, null, null);
  	$data['name'] = set()['nama'];
  	$data['address'] = set()['alamat'];
		$data['logo'] = set()['logo'];
		$data['telp'] = set()['telp'];
		$data['pin'] = set()['pin'];
		$data['ig'] = set()['ig'];
		$data['info'] = set()['keterangan'];
  	$this->load->view('home', $data);
  }
}