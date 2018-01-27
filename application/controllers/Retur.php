<?php
/**
 * summary
 */
class Retur extends CI_Controller
{
	/**
	* summary
	*/
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_penjualan');
		$this->load->model('M_product');
		$this->load->model('M_retur');
		$this->load->model('M_lokasi');
		$this->load->model('M_users');
	}

	public function index($param)
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('id_lokasi');
		$this->session->unset_userdata('tgl_awal');
		$this->session->unset_userdata('tgl_akhir');
		redirect('retur/'.$param);
	}

	public function product($param1=null, $param2=null, $param3=null)
	{
		$tgl_awal = $this->session->userdata('tgl_awal');
		$tgl_akhir = $this->session->userdata('tgl_akhir');
		if (my_level()==null) $id_lokasi = $this->session->userdata('id_lokasi');
		else $id_lokasi = my_location();

		if (my_level()==null) $id_user = $this->session->userdata('id_user');
		else $id_user = null;

		$total_row=$this->M_retur->count($id_lokasi, $id_user, $tgl_awal, $tgl_akhir);
		$perpage=15;
		$uri_segment=3;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'retur/product/';
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
		$data['listdata'] = $this->M_retur->show($id_lokasi, $id_user, $tgl_awal, $tgl_akhir);
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['listuser'] = $this->M_users->show(null,null,null);
		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;
		$data['title'] = 'Retur';
		$data['subtitle'] = 'Product';
		$data['br'] = '';
		$data['retur'] = 'class="active"';
		$data['js'] = 'retur/daftar';
		$data['page'] = 'retur/daftar';
		$this->load->view('page', $data);
	}

	public function transaksi($param1=null, $param2=null, $param3=null)
	{
		$data['title'] = 'Retur';
		$data['subtitle'] = 'Product';
		$data['br'] = '';
		$data['retur'] = 'class="active"';
		$data['js'] = 'retur/transaksi';
		$data['page'] = 'retur/input';
		$this->load->view('page', $data);
	}

	/* Retur Satuan */
	public function satuan_faktur_scan()
	{
		$nofaktur = $this->input->post('nofaktur');
		$get = $this->M_penjualan->get_transaksiitem(null,$nofaktur);
		if ($get->result()) {
			if ($get->row()->status=='retur') {
				$arr_stn = array('msg'=>'retured');
			}
			else {
				foreach ($get->result() as $val) {
					$id_faktur = $val->id_faktur;
					$arr_stn = array(
						'id_faktur' => $val->id_faktur,
						'id_product' => $val->id_product,
						'no_faktur' => $val->no_faktur,
						'tanggal' => $val->tanggal,
						'totalitem' => $val->totalitem,
						'totalbelanja' => $val->totalbelanja_akhir,
						'kode_product' => $val->kode_product,
						'kode_stock' => $val->kode_stock,
						'product' => $val->nama_product,
						'harga_satuan' => $val->harga_satuan,
						'keterangan' => $val->keterangan
					);
				}
			}
		}
		else {
			$arr_stn = array('msg'=>'unlisted');
		}
		echo json_encode($arr_stn);
	}

	public function satuan_retur()
	{
		$no_faktur = $this->input->post('nofaktur');
		$get = $this->M_penjualan->get_transaksiitem(null,$no_faktur);
		$keterangan = $this->input->post('keterangan');	
		$arr_stock = array(); 
		if ($get->result()) {
			foreach ($get->result() as $val) {
				$arr_retur['id_user'] = $val->id_user;
				$arr_retur['id_lokasi'] = $val->id_lokasi;
				$arr_retur['id_product'] = $val->id_product;
				$arr_retur['transaksi'] = 'satuan';
				$arr_retur['no_faktur'] = $val->no_faktur;
				$arr_retur['tanggal_transaksi'] = $val->tanggal;
				$arr_retur['totalitem'] = $val->totalitem;
				$arr_retur['totalbelanja'] = $val->totalbelanja_akhir;
				$arr_retur['tanggal_retur'] = date('Y-m-d H:i:s');
				$arr_retur['kode_product'] = $val->kode_product;
				$arr_retur['kode_stock'] = $val->kode_stock;
				$arr_retur['product'] = $val->nama_product;
				$arr_retur['harga_satuan'] = $val->harga_satuan;
				$arr_retur['keterangan'] = $keterangan;
				
				$this->M_retur->insert($arr_retur);

				$stk['flag'] = '1';
				$stk['keterangan'] = $keterangan;
				$this->M_product->update_stock($stk, $val->kode_stock);

				$gsr['keterangan'] = $keterangan;
				$gsr['status'] = 'retur';
				$this->M_penjualan->update_transaksi_item($val->kode_stock, $gsr);
			}
			echo json_encode($arr_retur);
		}
	}

	
	// Retur Grosir
	public function grosir_list($no_faktur=null)
	{
    // $no_faktur = $this->input->post('nofaktur');
		$get = $this->M_retur->show_temp($no_faktur);
		$arr_retur = array(); 
		if ($get->result()) {
			foreach ($get->result() as $val) {
				$arr_retur[] = array(
					'id_user' => $val->id_user,
					'id_lokasi' => $val->id_lokasi,
					'id_product' => $val->id_product,
					'transaksi' => $val->transaksi,
					'no_faktur' => $val->no_faktur,
					'tanggal_transaksi' => $val->tanggal_transaksi,
					'totalitem' => $val->totalitem,
					'totalbelanja' => $val->totalbelanja,
					'tanggal_retur' => $val->tanggal_retur,
					'kode_product' => $val->kode_product,
					'kode_stock' => $val->kode_stock,
					'product' => $val->product,
					'harga_satuan' => $val->harga_satuan,
					'keterangan' => $val->keterangan
				);
			}
		}
		echo json_encode($arr_retur);
	}

	public function grosir_faktur_scan()
	{
		$nofaktur = $this->input->post('nofaktur');
		$get = $this->M_penjualan->get_transaksigrosir(null,$nofaktur);
		$arr_gsr = array(); $arr_dtl = array();
		if ($get->result()) {
			foreach ($get->result() as $val) {
				$id_faktur = $val->id_faktur;
				$detail = $this->M_penjualan->show_grosir_detail_grp($id_faktur);
				if ($detail->result()) {
					foreach ($detail->result() as $var) {
						$arr_dtl[] = array(
							// 'id_faktur' => $var->id_faktur,
							'id_product' => $var->id_product,
							'kode' => $var->kode,
							'jumlah' => $var->jumlah,
							'hargasatuan' => $var->hargasatuan,
							'product' => $var->product,
							'diskon' => $var->diskon,
							'total' => $var->total
						);
					}
				}
				$arr_gsr = array(
					'id_faktur' => $val->id_faktur,
					'id_user' => $val->id_user,
					'id_lokasi' => $val->id_lokasi,
					'kasir' => get_name_of_user($val->id_user),
					'tanggal' => $val->tanggal,
					'no_faktur' => $val->no_faktur,
					'total' => $val->total,
					'keterangan' => $val->keterangan,
					'bayar' => $val->bayar,
					'kembalian' => $val->kembalian,
					'detail' => $arr_dtl
				);
			}
		}
		else {
			$arr_gsr = array('msg'=>'unlisted');
		}
		echo json_encode($arr_gsr);
	}

	public function grosir_stock_scan()
	{
		$kode_stock = $this->input->post('grosir_barcode');
		$cek = $this->M_retur->getstock_temp($kode_stock);
		$arr_retur = array();
		if ($cek->result()) {
			$arr_retur['msg'] = 'listed';
		}
		else {
			$cek2 = $this->M_penjualan->get_grosir_item($kode_stock);
			if ($cek2->result()) {
				if ($cek2->row()->status=='retur') {
					$arr_retur['msg'] = 'retured';
				}
				else {
					$get = $this->M_retur->grosir_retur_tmp($kode_stock);
					$keterangan = '';	 
					if ($get->result()) {
						foreach ($get->result() as $val) {
							$arr_retur['id_user'] = $val->id_user;
							$arr_retur['id_lokasi'] = $val->id_lokasi;
							$arr_retur['id_product'] = $val->id_product;
							$arr_retur['transaksi'] = 'grosir';
							$arr_retur['no_faktur'] = $val->no_faktur;
							$arr_retur['tanggal_transaksi'] = $val->tanggal;
							$arr_retur['totalitem'] = $val->jumlah;
							$arr_retur['totalbelanja'] = $val->total;
							$arr_retur['tanggal_retur'] = date('Y-m-d H:i:s');
							$arr_retur['kode_product'] = $val->kode;
							$arr_retur['kode_stock'] = $val->kode_stock;
							$arr_retur['product'] = $val->product;
							$arr_retur['harga_satuan'] = $val->hargasatuan;
							$arr_retur['keterangan'] = $keterangan;

							$this->M_retur->insert_temp($arr_retur);
						}
					}
				}
			}
			else {
				$arr_retur['msg'] = 'unlisted';
			}
		}
		echo json_encode($arr_retur);
	}

	public function grosir_retur()
	{
		$no_faktur = $this->input->post('nofaktur');
		$get = $this->M_retur->show_temp($no_faktur);
		$keterangan = $this->input->post('keterangan');	
		$arr_stock = array(); 
		if ($get->result()) {
			foreach ($get->result() as $val) {
				$arr_retur['id_user'] = $val->id_user;
				$arr_retur['id_lokasi'] = $val->id_lokasi;
				$arr_retur['id_product'] = $val->id_product;
				$arr_retur['transaksi'] = 'grosir';
				$arr_retur['no_faktur'] = $val->no_faktur;
				$arr_retur['tanggal_transaksi'] = $val->tanggal_transaksi;
				$arr_retur['totalitem'] = $val->totalitem;
				$arr_retur['totalbelanja'] = $val->totalbelanja;
				$arr_retur['tanggal_retur'] = date('Y-m-d H:i:s');
				$arr_retur['kode_product'] = $val->kode_product;
				$arr_retur['kode_stock'] = $val->kode_stock;
				$arr_retur['product'] = $val->product;
				$arr_retur['harga_satuan'] = $val->harga_satuan;
				$arr_retur['keterangan'] = $keterangan;
				
				$this->M_retur->insert($arr_retur);

				$stk['flag'] = '1';
				$stk['keterangan'] = $keterangan;
				$this->M_product->update_stock($stk, $val->kode_stock);

				$gsr['keterangan'] = $keterangan;
				$gsr['status'] = 'retur';
				$this->M_penjualan->update_grosir_item($val->kode_stock, $gsr);
			}
			$this->M_retur->delete_temp($no_faktur);
			echo json_encode($arr_retur);
		}
	}

	public function grosir_hapus_tmp()
	{
		$kode_stock = $this->input->post('kodestock');
		$this->M_retur->delete_item_temp($kode_stock);
	}
}
?>