<?php
/**
* Controller laporan
*/
class Laporan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_laporan');
		$this->load->model('M_product');
		$this->load->model('M_lokasi');
		$this->load->model('M_users');
		$this->load->model('M_penjualan');
		$this->load->model('M_setting');
	}

	public function index($param)
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('id_lokasi');
		$this->session->unset_userdata('tgl_awal');
		$this->session->unset_userdata('tgl_akhir');
		redirect('laporan/'.$param);
	}

	public function laporan_stock()
	{
		$tgl_awal = $this->session->userdata('tgl_awal');
		$tgl_akhir = $this->session->userdata('tgl_akhir');

		if (my_level()==null) $id_lokasi = $this->session->userdata('id_lokasi');
		else $id_lokasi = my_location();

		// if (my_level()==null) $id_user = $this->session->userdata('id_user');
		// else $id_user = null;

		$total_row=$this->M_laporan->count($id_lokasi, $tgl_awal, $tgl_akhir);
		$perpage=15;
		$uri_segment=3;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'laporan/laporan-stock/';
		$config['total_rows']  = $total_row;
		$config['per_page']    = $perpage;
		$config['uri_segment'] = $uri_segment;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();	
		$data['no']=$offset+1;
		$data['listdata'] = $this->M_laporan->show($id_lokasi, $tgl_awal, $tgl_akhir, $perpage, $offset);
		// echo $this->db->last_query();
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['listuser'] = $this->M_users->show(null,null,null);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$data['total_jual'] = $this->M_laporan->total_jual($id_lokasi, $tgl_awal, $tgl_akhir, null, null);
		$data['title'] = 'Laporan';
		$data['subtitle'] = 'Stock';
		$data['br'] = '';
		$data['laporan_stock'] = 'class="active"';
		$data['js'] = 'laporan/laporan_stock/daftar';
		$data['page'] = 'laporan/laporan-stock';
		$this->load->view('page', $data);
	}

	public function log_transaksi($param1=null, $param2=null, $param3=null)
	{
		// if ($param1=='detail') {
		// 	$data['title'] = 'Laporan';
		// 	$data['subtitle'] = 'Transaksi';
		// 	$data['br'] = '';
		// 	$data['log_transaksi'] = 'class="active"';
		// 	$data['js'] = 'laporan/log_transaksi/detail';
		// 	$data['page'] = 'laporan/log-transaksi';
		// }
		// else {
			if (my_level()=='Seles') $tgl_awal = date('Y-m-d');
			else $tgl_awal = $this->session->userdata('tgl_awal');
			$tgl_akhir = $this->session->userdata('tgl_akhir');

			if (my_level()==null) $id_lokasi = $this->session->userdata('id_lokasi');
			else $id_lokasi = my_location();

			if (my_level()==null) $id_user = $this->session->userdata('id_user');
			else $id_user = null;

			$total_row=$this->M_laporan->transcount($id_lokasi, $id_user, $tgl_awal, $tgl_akhir);
			$perpage=15;
			$uri_segment=3;
			$offset=intval($this->uri->segment($uri_segment));
			$config['base_url']    = base_url().'laporan/log-transaksi/';
			$config['total_rows']  = $total_row;
			$config['per_page']    = $perpage;
			$config['uri_segment'] = $uri_segment;
			$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = '<i class="fa fa-angle-right"></i>';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			// $data['pagination'] = $this->pagination->create_links();	
			$data['no']=$offset+1;
			// $data['listdata'] = $this->M_laporan->transaksi($id_lokasi, $id_user, $tgl_awal, $tgl_akhir, $perpage, $offset);
			$data['listdata'] = $this->M_laporan->transaksi($id_lokasi, $id_user, $tgl_awal, $tgl_akhir, null, null);
			// echo $this->db->last_query();
			$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
			$data['listuser'] = $this->M_users->show(null,null,null);
			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['title'] = 'Laporan';
			$data['subtitle'] = 'Transaksi';
			$data['br'] = '';
			$data['log_transaksi'] = 'class="active"';
			$data['js'] = 'laporan/log_transaksi/daftar';
			$data['page'] = 'laporan/log-transaksi';
		// }
		$this->load->view('page', $data);
	}

	public function log_grosir($param1=null, $param2=null, $param3=null)
	{
		if ($param1=='detail') {
			$id_faktur  = decrypts($param2);
			$data['listdata'] = $this->M_penjualan->show_grosir_detail($id_faktur,null);
			$data['transaksi'] = $this->M_penjualan->get_transaksigrosir($id_faktur, null);
			$data['title'] = 'Laporan';
			$data['subtitle'] = 'Detail Transaksi Grosir';
			$data['br'] = '';
			$data['log_grosir'] = 'class="active"';
			// $data['js'] = 'laporan/log_grosir/detail';
			$data['page'] = 'laporan/log-grosir-detail';
		}
		else {
			$tgl_awal = $this->session->userdata('tgl_awal');
			$tgl_akhir = $this->session->userdata('tgl_akhir');
			if (my_level()==null) $id_lokasi = $this->session->userdata('id_lokasi');
			else $id_lokasi = my_location();

			if (my_level()==null) $id_user = $this->session->userdata('id_user');
			else $id_user = null;

			$total_row=$this->M_laporan->grosir_transcount($id_lokasi, $id_user, $tgl_awal, $tgl_akhir);
			$perpage=15;
			$uri_segment=3;
			$offset=intval($this->uri->segment($uri_segment));
			$config['base_url']    = base_url().'laporan/log-grosir/';
			$config['total_rows']  = $total_row;
			$config['per_page']    = $perpage;
			$config['uri_segment'] = $uri_segment;
			$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = '<i class="fa fa-angle-right"></i>';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			// $data['pagination'] = $this->pagination->create_links();	
			$data['no']=$offset+1;
			// $data['listdata'] = $this->M_laporan->grosir($id_lokasi, $id_user, $tgl_awal, $tgl_akhir, $perpage, $offset);
			$data['listdata'] = $this->M_laporan->grosir($id_lokasi, $id_user, $tgl_awal, $tgl_akhir, null,null);
			$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
			$data['listuser'] = $this->M_users->show(null,null,null);
			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['title'] = 'Laporan';
			$data['subtitle'] = 'Transaksi Grosir';
			$data['br'] = '';
			$data['log_grosir'] = 'class="active"';
			$data['js'] = 'laporan/log_grosir/daftar';
			$data['page'] = 'laporan/log-grosir';
		}
		$this->load->view('page', $data);
	}

	public function print_faktur_pcs()
	{
		$id_faktur = $this->input->post('faktur');
		$detail_transaksi = $this->M_penjualan->detail_transaksi($id_faktur);
		$waktu_transaksi = $detail_transaksi->row()->tanggal;
		$data['id_faktur'] = $id_faktur;
		$data['no_faktur'] = $detail_transaksi->row()->no_faktur;
		$data['set'] = $this->M_setting->show();
		$data['waktu_transaksi'] = $waktu_transaksi;
		$data['listdata'] = $this->M_penjualan->detail_transaksi($id_faktur);
		$data['totalbelanja'] = $this->M_penjualan->total_detail_transaksi($id_faktur);
		$this->load->view('penjualan/print', $data);
		// echo json_encode($id_faktur);
	}

	public function print_faktur_grs()
	{
		$id_faktur = $this->input->post('faktur');
		$detail_transaksi = $this->M_penjualan->get_transaksigrosir($id_faktur,null);
		$waktu_transaksi = $detail_transaksi->row()->tanggal;
		$data['id_faktur'] = $detail_transaksi->row()->id_faktur;
		$data['no_faktur'] = $detail_transaksi->row()->no_faktur;
		$data['set'] = $this->M_setting->show();
		$data['waktu_transaksi'] = $waktu_transaksi;
		$data['listdata'] = $this->M_penjualan->show_grosir_detail_grp($detail_transaksi->row()->id_faktur);
		$data['total'] = $detail_transaksi->row()->total;
		$data['totalbelanja'] = $detail_transaksi->row()->total_akhir;
		$data['potongan'] = $detail_transaksi->row()->potongan;
		$data['bayar'] = $detail_transaksi->row()->bayar;
		$data['kembalian'] = $detail_transaksi->row()->kembalian;
		$this->load->view('penjualan/print2', $data);
	}

	public function tampilkan()
	{
		$id_user = $this->input->post('pid_user');
		$id_lokasi = $this->input->post('pid_lokasi');
		$tgl_awal = $this->input->post('ptgl_awal');
		$tgl_akhir = $this->input->post('ptgl_akhir');

		$this->session->set_userdata('id_user', $id_user);
		$this->session->set_userdata('id_lokasi', $id_lokasi);
		$this->session->set_userdata('tgl_awal',$tgl_awal);
		$this->session->set_userdata('tgl_akhir',$tgl_akhir);
	}
}