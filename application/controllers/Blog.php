<?php 
/**
 * Blog
 */
class Blog extends CI_Controller
{
  /**
   * Blog
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_blog');
  }

  function index()
  {
  	$data['listdata'] = $this->M_blog->show(null,null,null);
		$data['title'] = 'Blog';
		$data['subtitle'] = '';
		$data['br'] = '';
		$data['blog'] = 'class="active"';
		$data['js'] = 'blog/daftar';
		$data['page'] = 'blog/daftar';
  	$this->load->view('page', $data);
  }

  function tambah()
  {
    if ($this->input->post('simpan')) {
      $this->form_validation->set_rules('product', 'Produk', 'required');
      $this->form_validation->set_rules('diskripsi', 'Diskripsi', 'required');
      $this->form_validation->set_rules('userfile', 'Gambar');
      if ($this->form_validation->run()) {
        $arr_data['product'] = $this->input->post('product');
        $arr_data['diskripsi'] = $this->input->post('diskripsi');
        $file = $_FILES['userfile'];
        if (!empty($file)) {
          if ($_FILES['userfile']['tmp_name']) {
            $blob = addslashes(file_get_contents($_FILES['userfile']['tmp_name']));
            $prop = getimageSize($_FILES['userfile']['tmp_name']);
            $arr_data['img'] = $blob;
            $arr_data['mime'] = $prop['mime'];
          }
        }

        $this->M_blog->insert($arr_data);
        $this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
        redirect('blog');
      }
    }
    elseif ($this->input->post('batal')) redirect('blog');
    $data['title'] = 'Blog';
    $data['subtitle'] = '';
    $data['br'] = '';
    $data['blog'] = 'class="active"';
    $data['js'] = 'blog/blog';
    $data['page'] = 'blog/tambah';
    $this->load->view('page', $data);
  }
}