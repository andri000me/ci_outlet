<?php
/**
* Controller product
*/
class Product extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_product');
		$this->load->model('M_supplier');
		$this->load->model('M_jenis');
		$this->load->model('M_provider');
		$this->load->model('M_lokasi');
		$this->load->model('M_barang');
		$this->load->model('M_log_stock');
	}

	public function index($param1=null, $param2=null, $param3=null)
	{
		if (my_level()==null || my_level()=='Admin') {
		$total_row=$this->M_product->count();
		$perpage=15;
		$uri_segment=3;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'product/index/';
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
		
		$supplier = $this->session->userdata('id_supplier');
		$jenis = $this->session->userdata('id_jenis');
		$provider = $this->session->userdata('id_provider');
		if (my_level()==null) { $lokasi = $this->session->userdata('id_lokasi'); }
		else $lokasi = my_location();

		$data['pagination'] = $this->pagination->create_links();	
		$data['no']=$offset+1;
		$data['listdata'] = $this->M_product->show(null, $supplier, $jenis, $provider, $lokasi, $perpage, $offset);
		$data['listsupplier'] = $this->M_supplier->show(null,null,null);
		$data['listjenis'] = $this->M_jenis->show(null,null,null);
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['listprovider'] = $this->M_provider->show(null,null,null);
		$data['title'] = 'Product';
		$data['subtitle'] = 'List Daftar Product';
		$data['br'] = '';
		$data['product'] = 'class="active"';
		$data['js'] = 'product/daftar';
		$data['page'] = 'product/daftar';
		$this->load->view('page', $data);
		}
		else {redirect('product/stock-product');}
	}

	public function tambah($param1=null, $param2=null, $param3=null)
	{
		if ($this->input->post('simpan')) {
			$this->form_validation->set_rules('kode', 'Kode', 'callback_cekproduck');
			$this->form_validation->set_rules('harga_awal', 'Harga Awal', 'required');
			$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
			$this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
			$this->form_validation->set_rules('id_jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('id_provider', 'Provider', 'required');
			$this->form_validation->set_rules('id_lokasi', 'Lokasi', 'required');
			$this->form_validation->set_rules('id_barang', 'Barang', 'required');
			if ($this->form_validation->run()) {
				$id_product = $this->M_product->newid();
				$arr_data['id_product'] = $id_product;
				$id_jenis = $this->input->post('id_jenis');
				$id_provider = $this->input->post('id_provider');
				$id_barang = $this->input->post('id_barang');
				$arr_data['product'] = product_name($id_jenis,$id_provider,$id_barang);
				$variable = array('id_supplier', 'id_jenis', 'id_provider', 'id_lokasi', 'id_barang', 'kode', 'quantity', 'harga_beli', 'harga_awal', 'harga_jual', 'harga_akhir');
				foreach ($variable as $key) {
					$arr_data[$key] = $this->input->post($key);
				}
				$this->M_product->insert($arr_data);

				$arr_log['id_product'] = $id_product;
				$arr_log['id_user'] = my_userid();
				$arr_log['id_lokasi'] = my_location();
				$arr_log['tanggal'] = date('Y-m-d H:i:s');
				$arr_log['kode'] = $this->input->post('kode');
				$arr_log['product'] = product_name($id_jenis,$id_provider,$id_barang);
				$arr_log['quantity_awal'] = 0;
				$arr_log['quantity_akhir'] = $this->input->post('quantity');
				$arr_log['quantity_tambah'] = $this->input->post('quantity');
				$arr_log['quantity_jual'] = NULL;
				$arr_log['harga_satuan'] = $this->input->post('harga_jual');
				$arr_log['harga_masuk'] = $this->input->post('quantity')*$this->input->post('harga_jual');
				$arr_log['harga_keluar'] = NULL;

				$this->M_log_stock->insert($arr_log);

				$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
				redirect('product');
			}
		}
		// elseif ($this->input->post('scan')) {
		// 	$this->form_validation->set_rules('kode', 'Kode', 'callback_cekproduck');
		// 	$this->form_validation->set_rules('harga_awal', 'Harga Awal', 'required');
		// 	$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
		// 	$this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
		// 	$this->form_validation->set_rules('id_jenis', 'Jenis', 'required');
		// 	$this->form_validation->set_rules('id_provider', 'Provider', 'required');
		// 	$this->form_validation->set_rules('id_lokasi', 'Lokasi', 'required');
		// 	$this->form_validation->set_rules('id_barang', 'Barang', 'required');
		// 	if ($this->form_validation->run()) {
		// 		$arr_data['id_product'] = $this->M_product->newid();
		// 		$id_jenis = $this->input->post('id_jenis');
		// 		$id_provider = $this->input->post('id_provider');
		// 		$id_barang = $this->input->post('id_barang');
		// 		$arr_data['product'] = product_name($id_jenis,$id_provider,$id_barang);
		// 		$variable = array('id_supplier', 'id_jenis', 'id_provider', 'id_lokasi', 'id_barang', 'kode', 'quantity', 'harga_beli', 'harga_awal', 'harga_jual', 'harga_akhir');
		// 		foreach ($variable as $key) {
		// 			$arr_data[$key] = $this->input->post($key);
		// 		}
		// 		$this->M_product->insert($arr_data);
		// 		$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
		// 		redirect('product');
		// 	}
		// }
		elseif ($this->input->post('import')) {
			$this->form_validation->set_rules('kode', 'Kode', 'callback_cekproduck');
			$this->form_validation->set_rules('harga_awal', 'Harga Awal', 'required');
			$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
			$this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
			$this->form_validation->set_rules('id_jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('id_provider', 'Provider', 'required');
			$this->form_validation->set_rules('id_lokasi', 'Lokasi', 'required');
			$this->form_validation->set_rules('id_barang', 'Barang', 'required');
			if ($this->form_validation->run()) {
				$id_product = $this->M_product->newid();
				$kode = encrypts($id_product);
				$arr_data['id_product'] = $id_product;
				$id_jenis = $this->input->post('id_jenis');
				$id_provider = $this->input->post('id_provider');
				$id_barang = $this->input->post('id_barang');
				$arr_data['product'] = product_name($id_jenis,$id_provider,$id_barang);
				$variable = array('id_supplier', 'id_jenis', 'id_provider', 'id_lokasi', 'id_barang', 'kode', 'quantity', 'harga_beli', 'harga_awal', 'harga_jual', 'harga_akhir');
				foreach ($variable as $key) {
					$arr_data[$key] = $this->input->post($key);
				}
				$this->M_product->insert($arr_data);

				$arr_log['id_product'] = $id_product;
				$arr_log['id_user'] = my_userid();
				$arr_log['id_lokasi'] = my_location();
				$arr_log['tanggal'] = date('Y-m-d H:i:s');
				$arr_log['kode'] = $this->input->post('kode');
				$arr_log['product'] = product_name($id_jenis,$id_provider,$id_barang);
				$arr_log['quantity_awal'] = 0;
				$arr_log['quantity_akhir'] = $this->input->post('quantity');
				$arr_log['quantity_tambah'] = $this->input->post('quantity');
				$arr_log['quantity_jual'] = NULL;
				$arr_log['harga_satuan'] = $this->input->post('harga_jual');
				$arr_log['harga_masuk'] = $this->input->post('quantity')*$this->input->post('harga_jual');
				$arr_log['harga_keluar'] = NULL;

				$this->M_log_stock->insert($arr_log);

				$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
				redirect('product/tambah-stock/'.$kode);
			}
		}
		elseif ($this->input->post('batal')) redirect('product');
		$data['listsupplier'] = $this->M_supplier->show(null,null,null);
		$data['listjenis'] = $this->M_jenis->show(null,null,null);
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['listprovider'] = $this->M_provider->show(null,null,null);
		$data['listbarang'] = $this->M_barang->show(null,null,null);
		$data['title'] = 'Product';
		$data['subtitle'] = 'Tambah Product Baru';
		$data['br'] = array();
		$data['product'] = 'class="active"';
		$data['page'] = 'product/tambah';
		$data['js'] = 'product/tambah';
		$this->load->view('page', $data);
	}

	public function ubah($param1=null, $param2=null, $param3=null)
	{
		$id_product = decrypts($param1);
		if ($this->input->post('simpan')) {
			// $this->form_validation->set_rules('kode', 'Kode', 'callback_cekproduck');
			$this->form_validation->set_rules('harga_awal', 'Harga Awal', 'required');
			$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
			$this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
			$this->form_validation->set_rules('id_jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('id_provider', 'Provider', 'required');
			$this->form_validation->set_rules('id_lokasi', 'Lokasi', 'required');
			$this->form_validation->set_rules('id_barang', 'Barang', 'required');
			if ($this->form_validation->run()) {
				$id_jenis = $this->input->post('id_jenis');
				$id_provider = $this->input->post('id_provider');
				$id_barang = $this->input->post('id_barang');
				$arr_data['product'] = product_name($id_jenis,$id_provider,$id_barang);
				$variable = array('id_supplier', 'id_jenis', 'id_provider', 'id_lokasi', 'id_barang', 'kode', 'quantity', 'harga_beli', 'harga_awal', 'harga_jual', 'harga_akhir');
				foreach ($variable as $key) {
					$arr_data[$key] = $this->input->post($key);
				}
				$this->M_product->update($arr_data, $id_product);
				$this->session->set_flashdata('msg',msg_success('Data berhasil dirubah.'));
				redirect('product');
			}
		}
		elseif ($this->input->post('batal')) redirect('product');

		$id_product = decrypts($param1);
		$get = $this->M_product->get($id_product);
		$data['listdata'] = $get;
		$kode = $get->row()->kode;

		$total_row=$this->M_product->count_stock_detail($id_product);
		$perpage=15;
		$uri_segment=4;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'product/ubah/'.$param1.'/';
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

		// $data['pagination'] = $this->pagination->create_links();
		$data['no']=$offset+1;
		$data['kode']=encrypts($id_product);
		// $data['listdetailstock']= $this->M_product->show_stock_detail($id_product,$perpage,$offset);
		$data['listdetailstock']= $this->M_product->show_stock_detail($id_product,null, null);
		$data['listdata'] = $this->M_product->get($id_product);
		$data['listsupplier'] = $this->M_supplier->show(null,null,null);
		$data['listjenis'] = $this->M_jenis->show(null,null,null);
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['listprovider'] = $this->M_provider->show(null,null,null);
		$data['listbarang'] = $this->M_barang->show(null,null,null);
		$data['title'] = 'Product';
		$data['subtitle'] = 'Ubah Data Product';
		$data['br'] = array();
		$data['product'] = 'class="active"';
		$data['js'] = 'product/ubah';
		$data['page'] = 'product/ubah';
		$this->load->view('page', $data);	
	}

	public function data()
	{
		$this->session->unset_userdata('id_supplier');
		$this->session->unset_userdata('id_jenis');
		$this->session->unset_userdata('id_provider');
		$this->session->unset_userdata('id_lokasi');
		redirect('product');
	}

	public function tampilkan()
	{
		$id_supplier = $this->input->post('pid_supplier');
		$id_jenis = $this->input->post('pid_jenis');
		$id_provider = $this->input->post('pid_provider');
		$id_lokasi = $this->input->post('pid_lokasi');

		$this->session->set_userdata('id_supplier', $id_supplier);
		$this->session->set_userdata('id_jenis', $id_jenis);
		$this->session->set_userdata('id_provider', $id_provider);
		$this->session->set_userdata('id_lokasi', $id_lokasi);
	}

	public function detail($param1=null, $param2=null, $param3=null)
	{
		$id_product = decrypts($param1);
		$get = $this->M_product->get($id_product);
		$data['listdata'] = $get;
		// $kode = $get->row()->kode;

		$total_row=$this->M_product->count_stock_detail($id_product);
		$perpage=15;
		$uri_segment=4;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'product/detail/'.$param1.'/';
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

		// $data['pagination'] = $this->pagination->create_links();
		$data['no']=$offset+1;
		$data['kode']=$param1;
		// $data['listdetailstock']= $this->M_product->show_stock_detail($id_product,$perpage,$offset);
		$data['listdetailstock']= $this->M_product->show_stock_detail($id_product,null,null);
		$data['title'] = 'Product';
		$data['subtitle'] = 'Detail Data Product';
		$data['br'] = array();
		$data['product'] = 'class="active"';
		$data['js'] = 'product/detail';
		$data['page'] = 'product/detail';
		$this->load->view('page', $data);
	}

	public function cekproduck()
	{
		$kode = $this->input->post('kode');
		$id_jenis = $this->input->post('id_jenis');
		$id_provider = $this->input->post('id_provider');
		$id_barang = $this->input->post('id_barang');
		$name = product_name($id_jenis,$id_provider,$id_barang);
		if (check_product($kode)!=null) {
			$this->form_validation->set_message('cekproduck', "Product $kode - $name sudah ada.");
			return false;
		}
		return true;
	}

	public function hapus($param1=null, $param2=null, $param3=null)
	{
		$id_product = decrypts($param1);
		$this->M_product->delete($id_product);
		$this->M_product->delete_allstock_detail($id_product);
		$this->session->set_flashdata('msg',msg_success('Data berhasil dihapus.'));
		redirect('product');
	}

	public function hapus_detail_stock($param1=null, $param2=null, $param3=null)
	{
		$id_pdetail = $param1;
		$this->M_product->delete_stock_detail($id_pdetail);
		$this->session->set_flashdata('msg',msg_success('Data berhasil dihapus.'));
		redirect('product/ubah/'.$param2);
	}

	public function update_detail_stock()
	{
		// $value = json_decode(file_get_contents('php://input'));
		$id_pdetail = $this->input->post('id_pdetail');
		$kode = $this->input->post('kode');
		$msisdn = $this->input->post('msisdn');
		$exp = $this->input->post('exp');
		$keterangan = $this->input->post('keterangan');

		$arr_data = array(
			'kode'=>$kode,
			'msisdn'=>$msisdn,
			'exp'=>$exp,
			'keterangan'=>$keterangan
		);

		$this->M_product->update_detail_stock($arr_data,$id_pdetail);
	}

	public function print()
	{
		$supplier = $this->session->userdata('id_supplier');
		$jenis = $this->session->userdata('id_jenis');
		$provider = $this->session->userdata('id_provider');
		$lokasi = $this->session->userdata('id_lokasi');

		$data['listdata'] = $this->M_product->show(null, $supplier, $jenis, $provider, $lokasi, null, null);
		$this->load->view('product/print', $data);
	}

	public function barcode()
	{
		$supplier = $this->session->userdata('id_supplier');
		$jenis = $this->session->userdata('id_jenis');
		$provider = $this->session->userdata('id_provider');
		$lokasi = $this->session->userdata('id_lokasi');

		$data['listdata'] = $this->M_product->show(null, $supplier, $jenis, $provider, $lokasi, null, null);
		$this->load->view('product/barcode', $data);
	}

	public function tambah_stock($param)
	{
		$this->load->library('excel');
		if ($this->input->post('simpan')) {
			$expired = $this->input->post('expired');
			$file = $_FILES['userfile'];
			if (!empty($file)) {
				$name 	= $file['name'];
				$type 	= $file['type'];
				$size 	= $file['size'];
				$temp 	= $file['tmp_name'];
				$error 	= $file['error'];
				$ax = array(); $ax = explode('.', $file['name']);
				$ext = end($ax);
				if ($error > 0) {
					$this->session->set_flashdata('msg',msg_danger('Kesalahan upload.'));
					redirect('product/import');
				}
				else {
					if($ext=='xls' || $ext=='xlsx') 
					{
						$mime = get_mime_by_extension($name);
						if (
							$mime=='application/vnd.ms-excel' ||
							$mime=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
						) 
						{
							$file_name = 'data_product';
							$file_dir = url_encode('userdata/'.$file_name);
							if (!is_dir($file_dir)) mkdir($file_dir,0777,TRUE);
							if (get_files($file_dir.'/'.$file_name.'.*')==TRUE) array_map('unlink', glob($file_dir.'/'.$file_name.'.*'));
							if (move_uploaded_file($temp, "$file_dir/$file_name.$ext")) 
							{
								$id_product = decrypts($param);
								$stock_awal = stock($id_product);
								$objLoad = PHPExcel_IOFactory::load($file_dir.'/'.$file_name.'.'.$ext);
								$dataArr = array();
								foreach ($objLoad->getWorksheetIterator() as $worksheet) {
									$worksheetTitle     = $worksheet->getTitle();
									$highestRow         = $worksheet->getHighestRow(); // e.g. 10
									$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
									$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

									for ($row = 2; $row <= $highestRow; ++ $row) {
										for ($col = 0; $col < $highestColumnIndex; ++ $col) {
										  $cell = $worksheet->getCellByColumnAndRow($col, $row);
										  $val = $cell->getValue();
										  $dataArr[$row][$col] = $val;
										}
									}
								}
								$arr_data = array();
								foreach ($dataArr as $key => $value) {
									if ($value[0]!=null) {
										$arr_data[] = array(
											'id_product'=>$id_product,
											'kode'=>intval($value[0]),
											'exp'=>$expired,
											'tglmasuk'=>date('Y-m-d H:i:s'),
											'product'=>product($id_product),
											'harga'=>harga($id_product),
											'flag'=>'1');
									}
								}
								$this->M_product->stock_batch($arr_data);

								$arr_log['id_product'] = $id_product;
								$arr_log['id_user'] = my_userid();
								$arr_log['id_lokasi'] = my_location();
								$arr_log['tanggal'] = date('Y-m-d H:i:s');
								$arr_log['kode'] = get_kodeproduct($id_product);
								$arr_log['product'] = product($id_product);
								$arr_log['quantity_awal'] = $stock_awal;
								$arr_log['quantity_akhir'] = stock($id_product);
								$arr_log['quantity_tambah'] = stock($id_product);
								$arr_log['quantity_jual'] = null;
								$arr_log['harga_satuan'] = harga($id_product);
								$arr_log['harga_masuk'] = stock($id_product)*harga($id_product);
								$arr_log['harga_keluar'] = null;

								echo json_encode($arr_log);
								$this->M_log_stock->insert($arr_log);
								
								if(count($arr_data)==null){
									$this->session->set_flashdata('msg',msg_warning('Data sudah diinput.'));
								}
								elseif (count($arr_data)>=1) {
									$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
								}
								redirect('product');
							}
							else {
								$this->session->set_flashdata('msg',msg_danger('Gagal saat proses unggah.'));
								redirect('product/tambah-stock/'.$param);
							}
						}
						else {
							$this->session->set_flashdata('msg',msg_danger('Format file tidak diijinkan.'));
							redirect('product/tambah-stock/'.$param);
						}
					}
					elseif ($ext=='txt' || $ext=='csv') {
						$mime = get_mime_by_extension($name);
						if (
							$mime=='text/csv' ||
							$mime=='text/x-comma-separated-values' ||
							$mime=='text/plain'
						) 
						{
							$id_product = decrypts($param);
							$stock_awal = stock($id_product);
							$file_name = 'data_product';
							$file_dir = url_encode('userdata/'.$file_name);
							if (!is_dir($file_dir)) mkdir($file_dir,0777,TRUE);
							if (get_files($file_dir.'/'.$file_name.'.*')==TRUE) array_map('unlink', glob($file_dir.'/'.$file_name.'.*'));
							if (move_uploaded_file($temp, "$file_dir/$file_name.$ext")) 
							if (($handle = fopen($file_dir.'/'.$file_name.'.'.$ext,"r")) !== FALSE) {
								$batas=0;
								$isi=array();
								while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
									if($batas!=0 && $data[0]!='')	{
										$arr_data[] = array(
											'id_product'=>$id_product,
											'kode'=>$data[0], 
											'exp'=>$expired,
											'tglmasuk'=>date('Y-m-d H:i:s'),
											'product'=>product($id_product),
											'harga'=>harga($id_product),
											'flag'=>'1');
									}
									$batas++;
								}
								fclose($handle);
								unlink($file_dir.'/'.$file_name.'.'.$ext);
								$this->M_product->stock_batch($arr_data);

								$arr_log['id_product'] = $id_product;
								$arr_log['id_user'] = my_userid();
								$arr_log['id_lokasi'] = my_location();
								$arr_log['tanggal'] = date('Y-m-d H:i:s');
								$arr_log['kode'] = get_kodeproduct($id_product);
								$arr_log['product'] = product($id_product);
								$arr_log['quantity_awal'] = $stock_awal;
								$arr_log['quantity_akhir'] = stock($id_product);
								$arr_log['quantity_tambah'] = stock($id_product);
								$arr_log['quantity_jual'] = null;
								$arr_log['harga_satuan'] = harga($id_product);
								$arr_log['harga_masuk'] = stock($id_product)*harga($id_product);
								$arr_log['harga_keluar'] = null;

								// echo json_encode($arr_log);
								$this->M_log_stock->insert($arr_log);
							}
							if(count($arr_data)==null){
								$this->session->set_flashdata('msg',msg_warning('Data sudah diinput.'));
							}
							elseif (count($arr_data)>=1) {
								$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
							}
							redirect('product/detail/'.$param);
						}
					}
					else {
						$this->session->set_flashdata('msg',msg_danger('Extensi file tidak diijinkan.'));
						redirect('product/tambah-stock/'.$param);
					}
				}
			}
		}
		elseif ($this->input->post('batal')) redirect('product');
		$data['title'] = 'Product';
		$data['subtitle'] = 'Import Stock';
		$data['br'] = array();
		$data['js'] = 'product/import';
		$data['product'] = 'class="active"';
		$data['page'] = 'product/import_stock';
		$this->load->view('page', $data);
	}

	public function update_stock($param)
	{
		$this->load->library('excel');
		if ($this->input->post('simpan')) {
			$expired = $this->input->post('expired');
			$file = $_FILES['userfile'];
			if (!empty($file)) {
				$name 	= $file['name'];
				$type 	= $file['type'];
				$size 	= $file['size'];
				$temp 	= $file['tmp_name'];
				$error 	= $file['error'];
				$ax = array(); $ax = explode('.', $file['name']);
				$ext = end($ax);
				if ($error > 0) {
					$this->session->set_flashdata('msg',msg_danger('Kesalahan upload.'));
					redirect('product/import');
				}
				else {
					if($ext=='xls' || $ext=='xlsx') 
					{
						$mime = get_mime_by_extension($name);
						if (
							$mime=='application/vnd.ms-excel' ||
							$mime=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
						) 
						{
							$file_name = 'data_product';
							$file_dir = url_encode('userdata/'.$file_name);
							if (!is_dir($file_dir)) mkdir($file_dir,0777,TRUE);
							if (get_files($file_dir.'/'.$file_name.'.*')==TRUE) array_map('unlink', glob($file_dir.'/'.$file_name.'.*'));
							if (move_uploaded_file($temp, "$file_dir/$file_name.$ext")) 
							{
								$id_product = decrypts($param);
								$stock_awal = stock($id_product);
								$objLoad = PHPExcel_IOFactory::load($file_dir.'/'.$file_name.'.'.$ext);
								$dataArr = array();
								foreach ($objLoad->getWorksheetIterator() as $worksheet) {
									$worksheetTitle     = $worksheet->getTitle();
									$highestRow         = $worksheet->getHighestRow(); // e.g. 10
									$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
									$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

									for ($row = 2; $row <= $highestRow; ++ $row) {
										for ($col = 0; $col < $highestColumnIndex; ++ $col) {
										  $cell = $worksheet->getCellByColumnAndRow($col, $row);
										  $val = $cell->getValue();
										  $dataArr[$row][$col] = $val;
										}
									}
								}
								$arr_data = array();
								foreach ($dataArr as $key => $value) {
									if ($value[0]!=null) {
										$arr_data[] = array(
											'id_product'=>$id_product,
											'kode'=>intval($value[0]),
											'exp'=>$expired,
											'tglmasuk'=>date('Y-m-d H:i:s'),
											'product'=>product($id_product),
											'harga'=>harga($id_product),
											'flag'=>'1');
									}
								}
								$this->M_product->stock_batch($arr_data);

								$arr_log['id_product'] = $id_product;
								$arr_log['id_user'] = my_userid();
								$arr_log['id_lokasi'] = my_location();
								$arr_log['tanggal'] = date('Y-m-d H:i:s');
								$arr_log['kode'] = get_kodeproduct($id_product);
								$arr_log['product'] = product($id_product);
								$arr_log['quantity_awal'] = $stock_awal;
								$arr_log['quantity_akhir'] = stock($id_product);
								$arr_log['quantity_tambah'] = stock($id_product);
								$arr_log['quantity_jual'] = null;
								$arr_log['harga_satuan'] = harga($id_product);
								$arr_log['harga_masuk'] = stock($id_product)*harga($id_product);
								$arr_log['harga_keluar'] = null;

								$this->M_log_stock->insert($arr_log);
								
								if(count($arr_data)==null){
									$this->session->set_flashdata('msg',msg_warning('Data sudah diinput.'));
								}
								elseif (count($arr_data)>=1) {
									$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
								}
								redirect('product/detail/'.$param);
							}
							else {
								$this->session->set_flashdata('msg',msg_danger('Gagal saat proses unggah.'));
								redirect('product/update-stock/'.$param);
							}
						}
						else {
							$this->session->set_flashdata('msg',msg_danger('Format file tidak diijinkan.'.get_mime_by_extension($name)));
							redirect('product/update-stock/'.$param);
						}
					}
					elseif ($ext=='txt' || $ext=='csv') {
						$mime = get_mime_by_extension($name);
						if (
							$mime=='text/csv' ||
							$mime=='text/x-comma-separated-values' ||
							$mime=='text/plain'
						) 
						{
							$id_product = decrypts($param);
							$stock_awal = stock($id_product);
							$file_name = 'data_product';
							$file_dir = url_encode('userdata/'.$file_name);
							if (!is_dir($file_dir)) mkdir($file_dir,0777,TRUE);
							if (get_files($file_dir.'/'.$file_name.'.*')==TRUE) array_map('unlink', glob($file_dir.'/'.$file_name.'.*'));
							if (move_uploaded_file($temp, "$file_dir/$file_name.$ext")) 
							if (($handle = fopen($file_dir.'/'.$file_name.'.'.$ext,"r")) !== FALSE) {
								$batas=0;
								$isi=array();
								while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
									if($batas!=0 && $data[0]!='')	{
										$arr_data[] = array('id_product'=>$id_product,'kode'=>intval($data[0]), 'exp'=>$expired, 'flag'=>'1');
									}
									$batas++;
								}
								fclose($handle);
								unlink($file_dir.'/'.$file_name.'.'.$ext);
								$this->M_product->stock_batch($arr_data);

								$arr_log['id_product'] = $id_product;
								$arr_log['id_user'] = my_userid();
								$arr_log['id_lokasi'] = my_location();
								$arr_log['tanggal'] = date('Y-m-d H:i:s');
								$arr_log['kode'] = get_kodeproduct($id_product);
								$arr_log['product'] = product($id_product);
								$arr_log['quantity_awal'] = $stock_awal;
								$arr_log['quantity_akhir'] = stock($id_product);
								$arr_log['quantity_tambah'] = stock($id_product);
								$arr_log['quantity_jual'] = null;
								$arr_log['harga_satuan'] = harga($id_product);
								$arr_log['harga_masuk'] = stock($id_product)*harga($id_product);
								$arr_log['harga_keluar'] = null;

								$this->M_log_stock->insert($arr_log);
							}
							if(count($arr_data)==null){
								$this->session->set_flashdata('msg',msg_warning('Data sudah diinput.'));
							}
							elseif (count($arr_data)>=1) {
								$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
							}
							redirect('product/detail/'.$param);
						}
					}
					else {
						$this->session->set_flashdata('msg',msg_danger('Extensi file tidak diijinkan.'));
						redirect('product/update-stock/'.$param);
					}
				}
			}
		}
		elseif ($this->input->post('batal')) redirect('product');
		$data['title'] = 'Product';
		$data['subtitle'] = 'Import Stock';
		$data['br'] = array();
		$data['js'] = 'product/import';
		$data['section'] = 'update_stock';
		$data['product'] = 'class="active"';
		$data['page'] = 'product/import_stock';
		$this->load->view('page', $data);
	}

	public function stock_template()
	{
		$this->load->library('excel');
		$filename='template_barang.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('barang');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Kode');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getProperties()->setCreator("4171");
		$this->excel->getProperties()->setLastModifiedBy("4171");
		$this->excel->getProperties()->setTitle($filename);
		$this->excel->getProperties()->setSubject("Report Data barang");
		$this->excel->getProperties()->setDescription(base_url());
		$this->excel->getProperties()->setCategory("Report");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function import()
	{
		$this->load->library('excel');
		if ($this->input->post('simpan')) {
			$file = $_FILES['userfile'];
			if (!empty($file)) {
				$name 	= $file['name'];
				$type 	= $file['type'];
				$size 	= $file['size'];
				$temp 	= $file['tmp_name'];
				$error 	= $file['error'];
				$ax = array(); $ax = explode('.', $file['name']);
				$ext = end($ax);
				if ($error > 0) {
					$this->session->set_flashdata('msg',msg_danger('Kesalahan upload.'));
					redirect('barang/import');
				}
				else {
					if($ext=='xls' || $ext=='xlsx' || $ext=='csv') 
					{
						$mime = get_mime_by_extension($name);
						if (
							$mime=='application/vnd.ms-excel' ||
							$mime=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
							$mime=='text/csv'
						) 
						{
							$file_name = 'data_barang';
							$file_dir = url_encode('userdata/'.$file_name);
							if (!is_dir($file_dir)) mkdir($file_dir,0777,TRUE);
							if (get_files($file_dir.'/'.$file_name.'.*')==TRUE) array_map('unlink', glob($file_dir.'/'.$file_name.'.*'));
							if (move_uploaded_file($temp, "$file_dir/$file_name.$ext")) 
							{
								$this->file_rklrpl = array(
									'file_name' 	=> $file_name.'.'.$ext,
									'file_type' 	=> $file["type"],
									'file_size' 	=> $file["size"],
									'file_temp' 	=> $file["tmp_name"],
									'error' 			=> $file["error"],
									'file_dir' 		=> $file_dir,
									'full_path' 	=> $file_dir.'/'.$file_name.'.'.$ext
								);

								$objLoad = PHPExcel_IOFactory::load($file_dir.'/'.$file_name.'.'.$ext);
								$dataArr = array();
								foreach ($objLoad->getWorksheetIterator() as $worksheet) {
									$worksheetTitle     = $worksheet->getTitle();
									$highestRow         = $worksheet->getHighestRow(); // e.g. 10
									$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
									$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

									for ($row = 2; $row <= $highestRow; ++ $row) {
										for ($col = 0; $col < $highestColumnIndex; ++ $col) {
										  $cell = $worksheet->getCellByColumnAndRow($col, $row);
										  $val = $cell->getValue();
										  $dataArr[$row][$col] = $val;
										}
									}
								}
								$arr_data = array();
								foreach ($dataArr as $key => $value) {
									if ($value[0]!=null) {
										if (check_barang($value[0])==null) $arr_data[] = array('kode'=>intval($value[0]), 'barang'=>$value[1], 'keterangan'=>$value[2]);
									}
								}
								if(count($arr_data)==null){
									$this->session->set_flashdata('msg',msg_warning('Data sudah diinput.'));
								}
								elseif (count($arr_data)>=1) {
									$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.<br>Beberapa data sudah ada, proses akan dilewati otomatis.'));
								}
								$this->M_barang->insert_batch($arr_data);
								redirect('barang');
							}
							else {
								$this->session->set_flashdata('msg',msg_danger('Gagal saat proses unggah.'));
								redirect('barang/import');
							}
						}
						else {
							$this->session->set_flashdata('msg',msg_danger('Format file tidak diijinkan.'));
							redirect('barang/import');
						}
					}
					else {
						$this->session->set_flashdata('msg',msg_danger('Extensi file tidak diijinkan.'));
						redirect('barang/import');
					}
				}
			}
		}
		elseif ($this->input->post('batal')) redirect('barang');
		$data['title'] = 'Product';
		$data['br'] = array();
		$data['js'] = 'barang/import';
		$data['barang'] = 'class="active"';
		$data['page'] = 'barang/import';
		$this->load->view('page', $data);
	}

	public function template()
	{
		$this->load->library('excel');
		$filename='template_barang.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('barang');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Kode');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('B1', 'Barang');
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('C1', 'Keterangan');
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getProperties()->setCreator("4171");
		$this->excel->getProperties()->setLastModifiedBy("4171");
		$this->excel->getProperties()->setTitle($filename);
		$this->excel->getProperties()->setSubject("Report Data barang");
		$this->excel->getProperties()->setDescription(base_url());
		$this->excel->getProperties()->setCategory("Report");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function export()
	{
		$no = 1;$i = 2;
		$listdata = $this->M_barang->show(null, null, null);
		if ($listdata->result()) {
			$this->load->library('excel');
			$filename='data_barang.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('barang');
			$this->excel->getActiveSheet()->setCellValue('A1', 'No');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setCellValue('B1', 'Kode');
			$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setCellValue('C1', 'Barang');
			$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setCellValue('D1', 'Keterangan');
			$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			foreach ($listdata->result() as $key) {
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $key->kode);
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $key->barang);
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $key->keterangan);
				$no++;
				$i++;
			}

			$this->excel->getProperties()->setCreator("4171");
			$this->excel->getProperties()->setLastModifiedBy("4171");
			$this->excel->getProperties()->setTitle($filename);
			$this->excel->getProperties()->setSubject("Report Data barang");
			$this->excel->getProperties()->setDescription(base_url());
			$this->excel->getProperties()->setCategory("Report");

			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}
		else {
			$this->session->set_flashdata('msg',msg_warning('Data kosong.'));
			redirect('barang');
		}
	}

	public function stock_product($param1=null, $param2=null, $param3=null)
	{
		$total_row=$this->M_product->count();
		$perpage=15;
		$uri_segment=3;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'product/stock-product/';
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
		
		$supplier = $this->session->userdata('id_supplier');
		$jenis = $this->session->userdata('id_jenis');
		$provider = $this->session->userdata('id_provider');
		if (my_level()==null) { $lokasi = $this->session->userdata('id_lokasi'); }
		else $lokasi = my_location();

		$data['pagination'] = $this->pagination->create_links();	
		$data['no']=$offset+1;
		$data['listdata'] = $this->M_product->show(null, $supplier, $jenis, $provider, $lokasi, $perpage, $offset);
		$data['listsupplier'] = $this->M_supplier->show(null,null,null);
		$data['listjenis'] = $this->M_jenis->show(null,null,null);
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['listprovider'] = $this->M_provider->show(null,null,null);
		$data['title'] = 'Product';
		$data['subtitle'] = 'List Daftar Product';
		$data['br'] = '';
		$data['stock_product'] = 'class="active"';
		$data['js'] = 'product/daftar';
		$data['page'] = 'product/stock_product';
		$this->load->view('page', $data);
	}

	public function tambah_stock_product($param1=null, $param2=null, $param3=null)
	{
		$id_product = decrypts($param1);
		if ($this->input->post('simpan')) {
			$this->form_validation->set_rules('kode', 'Kode', 'trim|required|numeric');
			$this->form_validation->set_rules('msisdn', 'MSISDN', 'trim|required|numeric|min_length[9]|max_length[12]');
			$this->form_validation->set_rules('expired', 'Expired', 'required');
			$this->form_validation->set_rules('harga_awal', 'Harga Pcs');
			$this->form_validation->set_rules('harga_akhir', 'Harga Grosir');
			if ($this->form_validation->run()) {
				if ($this->input->post('harga_awal')=='') {$harga = harga($id_product);}
				else {$harga= $this->input->post('harga_awal');}
				if ($this->input->post('harga_akhir')=='') {$harga_grosir = harga($id_product);}
				else {$harga_grosir= $this->input->post('harga_akhir');}
				$kode= $this->input->post('kode');
				$msisdn= $this->input->post('msisdn');
				$exp= $this->input->post('expired');
				$arr_data[] = array(
						'id_product'=>$id_product,
						'kode'=>$kode,
						'exp'=>$exp,
						'msisdn'=>$msisdn,
						'tglmasuk'=>date('Y-m-d H:i:s'),
						'product'=>product($id_product),
						'harga'=>$harga,
						'harga_grosir'=>$harga_grosir,
						'flag'=>'1');
				$this->M_product->stock_batch($arr_data);
				$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
				redirect('product/detail/'.$param1.'.phtml');
			}
		}
		elseif ($this->input->post('batal')) redirect('product/detail/'.$param1.'.phtml');
		$data['kode']=$param1;
		$data['title'] = 'Product';
		$data['subtitle'] = 'Tambah Stock Product';
		$data['br'] = array();
		$data['product'] = 'class="active"';
		$data['page'] = 'product/tambah_stock';
		$this->load->view('page', $data);
	}

	public function search($param1=null)
	{
		$get = $this->M_product->search($param1);
		$data['listdata'] = $get;
		$data['search']=$param1;
		$data['title'] = 'Product';
		$data['subtitle'] = 'Search';
		$data['br'] = array();
		$data['js'] = 'product/search';
		$data['product'] = 'class="active"';
		$data['page'] = 'product/search';
		$this->load->view('page', $data);
	}
}