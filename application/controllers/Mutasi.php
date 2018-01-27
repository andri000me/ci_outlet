<?php
/**
* Controller mutasi
*/
class Mutasi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_mutasi');
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
		$data['title'] = 'Mutasi';
		$data['subtitle'] = 'Product';
		$data['br'] = '';
		$data['mutasi'] = 'class="active"';
		$data['js'] = 'mutasi/daftar';
		$data['page'] = 'mutasi/daftar';
		$this->load->view('page', $data);
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

	public function riwayat($param1=null, $param2=null, $param3=null)
	{
		if ($param1=='detail') {
			$id_mutasi = decrypts($param2);
			$get = $this->M_mutasi->get($id_mutasi);
			$total_row=$this->M_mutasi->detail_count($id_mutasi);
			$perpage=15;
			$uri_segment=5;
			$offset=intval($this->uri->segment($uri_segment));
			$config['base_url']    = base_url().'mutasi/riwayat/detail/'.$param2.'/'.$param3.'/';
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
			$data['listdata'] = $get;
			$data['listdetailstock'] = $this->M_mutasi->detail_show($id_mutasi,$perpage, $offset);
			$data['title'] = 'Mutasi';
			$data['subtitle'] = 'Product';
			$data['br'] = '';
			$data['mutasi'] = 'class="active"';
			// $data['js'] = 'mutasi/detail';
			$data['page'] = 'mutasi/detail';
		}
		else {
			$id_product = decrypts($param1);
			$get = $this->M_product->get($id_product);
			if ($get->result()) {
				$total_row=$this->M_mutasi->count($id_product);
				$perpage=15;
				$uri_segment=4;
				$offset=intval($this->uri->segment($uri_segment));
				$config['base_url']    = base_url().'mutasi/riwayat/'.$param1.'/';
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
				$data['listdata'] = $get;
				$data['kode']=encrypts($id_product);
				$data['listmutasi']= $this->M_mutasi->show($id_product, $perpage, $offset);
				$data['title'] = 'Mutasi';
				$data['subtitle'] = 'Product';
				$data['br'] = '';
				$data['mutasi'] = 'class="active"';
				// $data['js'] = 'mutasi/riwayat';
				$data['page'] = 'mutasi/riwayat';
			}
			else redirect('mutasi');
		}
		$this->load->view('page', $data);
	}

	public function moving($param1=null, $param2=null, $param3=null)
	{
		$id_product = decrypts($param1);
		$get = $this->M_product->get($id_product);
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
		$data['kode']=encrypts($id_product);
		
		$data['listdata'] = $get;
		$data['kode']=encrypts($id_product);
		$data['listlokasi'] = $this->M_lokasi->show(null,null,null);
		$data['listdetailstock']= $this->M_product->show_stock_detail($id_product,$perpage,$offset);
		$data['title'] = 'Mutasi';
		$data['subtitle'] = 'Product';
		$data['br'] = '';
		$data['mutasi'] = 'class="active"';
		$data['js'] = 'mutasi/moving';
		$data['page'] = 'mutasi/moving';
		$this->load->view('page', $data);
	}

	public function mutasi_list()
	{
		$id_user = my_userid();
    $id_lokasi = my_location();
    $arr_tmp = array();
    $temp = $this->M_mutasi->show_mutasi_tmp_grp($id_user,$id_lokasi);
    // echo $this->db->last_query();

    if ($temp->result()) {
      foreach ($temp->result() as $tmp) {
        $stock_awal = stock($tmp->id_product);
        $arr_tmp[] = array(
          'kode'=> $tmp->kode,
          'id_product'=> $tmp->id_product,
          'product'=> $tmp->product,
          'jumlah'=> $tmp->jumlah
        );
      }
      echo json_encode($arr_tmp);
    }
	}
	
	public function mutasi_check()
	{
		$kd = $this->input->post('pbarcode');
		$check = $this->M_product->barcode($kd);
		// echo $this->db->last_query();
		if ($check->result()) {
			$id_product = $check->row()->id_product;
			$get = $this->M_product->get($id_product);
			if ($get->result()) {
				$kode = $get->row()->kode;
				$aget = $this->M_product->get_detail($kode);
				$product = $aget->row()->product;
				$harga = $aget->row()->harga_jual;
				$arr = array('id'=>$id_product, 'kode'=>$kode, 'product'=>$product, 'harga'=>$harga, 'stock'=>stock($id_product));
				echo json_encode($arr);
			}
			else {
				$arr = array('id'=>'', 'kode'=>'', 'product'=>'', 'harga'=>'', 'stock'=>'');
				echo json_encode($arr);
			}
		}
		else {
			$get = $this->M_product->get_detail_k($kd);
			if ($get->result()) {
				$id_product = $get->row()->id_product;
				$kode = $get->row()->kode;
				$harga = $get->row()->harga_jual;
				$product = $get->row()->product;
				$arr = array('id'=>$id_product, 'kode'=>$kode, 'product'=>$product, 'harga'=>$harga, 'stock'=>stock($id_product));
				echo json_encode($arr);
			}
			else {
				$arr = array('id'=>'', 'kode'=>'', 'product'=>'', 'harga'=>'', 'stock'=>'');
				echo json_encode($arr);
			}
		}
	}

	public function mutasi_temp($barcode=null)
	{
		$kode_stock = $barcode;
		$arr_data = array();
		if ($kode_stock!=null) {
			$g = check_barcode($kode_stock);
			if ($g==0) {
				echo json_encode(array('error'=>'empty'));
			}
			else if ($g==1) {
				$mcheck = $this->M_mutasi->check_mutasi_tmp($kode_stock);
				if ($mcheck->result()) {
					echo json_encode(array('error'=>'listed'));
				}
				else {
					$id_stok = get_idstock($kode_stock);
	        $kode_product = stock_kodeproduct($kode_stock);
	        $id_product = get_idproduct($kode_product);
	        $stock_awal = stock($id_product);

	        $arr_data = array(
	          'kode'=> $kode_product,
	          'id_product'=> $id_product,
	          'id_lokasi'=> my_location(),
	          'id_user'=> my_userid(),
	          'kode_stock'=> $kode_stock,
	          'id_pdetail'=> $id_stok,
	          'product'=> product($id_product),
	          'harga'=> harga($id_product)
	        );
	        // $arr['flag'] = '0';
	        $this->M_mutasi->insert_mutasi_tmp($arr_data);
	        // $this->M_product->update_stock($arr, $kode_stock);
	        
			    echo json_encode($arr_data);
				}
			}
			else {
				echo json_encode(array('error'=>'unlist'));
			}
		}
		else {
			echo json_encode(array('error'=>'unlist'));
		}
	}

	public function mutasi_submit($lokasi)
	{
		if ($lokasi) {
			$id_user = my_userid();
	    $id_lokasi = my_location();
	    $load_grp = $this->M_mutasi->show_mutasi_tmp_grp($id_user,$id_lokasi);
	    $jumlah = $this->M_mutasi->total_mutasi_tmp($id_user,$id_lokasi);
	    $arr_dtl = array();
	    $arr_grp = array();

	    if ($load_grp->result()) {
	    	foreach ($load_grp->result() as $grp) {
					$id_mutasi = $this->M_mutasi->newid();
					$id_lokasi_awal = $id_lokasi;
					$id_lokasi_akhir = $lokasi;
					$id_product_awal = $grp->id_product;
					$kode_awal = $grp->kode;
					$product = $grp->product;
					$tanggal = date('Y-m-d H:i:s');
					$lokasi_awal = get_lokasi($id_lokasi);
					$lokasi_akhir = get_lokasi($lokasi);
					$jumlah = $grp->jumlah;

					$getproduct = $this->M_product->get($id_product_awal);
					foreach ($getproduct->result() as $key) {
						$kd_supplier = get_kdsupplier($key->id_supplier);
						$kd_jenis = get_kdjenis($key->id_jenis);
						$kd_provider = get_kdprovider($key->id_provider);
						$kd_lokasi = get_kdlokasi($id_lokasi_akhir);
						$kd_barang = get_kdbarang($key->id_barang);

						$kd_akhir = $kd_supplier.$kd_jenis.$kd_provider.$kd_barang.$kd_lokasi;
						$xx = check_kodeproduct($kd_akhir);

						if ($xx==null) {
							$id_product_akhir = $this->M_product->newid();
							$kode_akhir = $kd_akhir;
							$product['id_product'] = $id_product_akhir;
							$product['id_supplier'] = $key->id_supplier;
							$product['id_jenis'] = $key->id_jenis;
							$product['id_provider'] = $key->id_provider;
							$product['id_lokasi'] = $id_lokasi_akhir;
							$product['id_barang'] = $key->id_barang;
							$product['kode'] = $kode_akhir;
							$product['product'] = $key->product;
							$product['quantity'] = $key->quantity;
							$product['harga_beli'] = $key->harga_beli;
							$product['harga_awal'] = $key->harga_awal;
							$product['harga_jual'] = $key->harga_jual;
							$product['harga_akhir'] = $key->harga_akhir;
						}
						else {
							$id_product_akhir = get_idproduct($kd_akhir);
							$kode_akhir = $kd_akhir;
						}
					}
	  		
	  			$arr_grp['id_mutasi'] = $id_mutasi;
	  			$arr_grp['id_lokasi_awal'] = $id_lokasi_awal;
	  			$arr_grp['id_lokasi_akhir'] = $id_lokasi_akhir;
	  			$arr_grp['id_product_awal'] = $id_product_awal;
	  			$arr_grp['kode_awal'] = $kode_awal;
	  			$arr_grp['id_product_akhir'] = $id_product_akhir;
	  			$arr_grp['kode_akhir'] = $kode_akhir;
	  			$arr_grp['product'] = $product;
	  			$arr_grp['tanggal'] = $tanggal;
	  			$arr_grp['lokasi_awal'] = $lokasi_awal;
	  			$arr_grp['lokasi_akhir'] = $lokasi_akhir;
	  			$arr_grp['jumlah'] = $jumlah;

	  			$this->M_mutasi->insert($arr_grp);

	  			if ($grp->id_product) {
	  				$arr_dtl['id_mutasi'] = $id_mutasi;
	  				$load_tmp = $this->M_mutasi->show_mutasi_tmp_product($id_user,$id_lokasi,$grp->id_product);
		  			if ($load_tmp->result()) {
				    	foreach ($load_tmp->result() as $tmp) {
				  			$arr_dtl['kode'] = $tmp->kode;
								$arr_dtl['id_product'] = $tmp->id_product;
								$arr_dtl['id_lokasi'] = $tmp->id_lokasi;
								$arr_dtl['id_user'] = $tmp->id_user;
								$arr_dtl['kode_stock'] = $tmp->kode_stock;
								$arr_dtl['id_pdetail'] = $tmp->id_pdetail;
								$arr_dtl['product'] = $tmp->product;
								$arr_dtl['harga'] = $tmp->harga;
								$this->M_mutasi->detail_insert($arr_dtl);

								$arr['id_product'] = $id_product_akhir;
								$this->M_product->update_stock($arr, $tmp->kode_stock);
				  		}
				    }
	  			}
	    	}
	    	$this->M_mutasi->deleteall_mutasi_tmp($id_user,$id_lokasi);
	    	echo json_encode(array('msg'=>'success'));
	    }
	    else {
	    	echo json_encode(array('msg'=>'error'));
	    }
		}
		else {
    	echo json_encode(array('msg'=>'error'));
    }
	}

	public function del_itm($param1=null)
	{
		$arr['flag'] = '1';$kodes=array();
		$get = $this->M_mutasi->detail_mutasi_tmp($param1);
		foreach ($get->result() as $val) {
			$kode_stock = $val->kode_stock;
			$kodes[] = array($kode_stock);
			$this->M_product->update_stock($arr, $kode_stock);
		}
		echo json_encode($kodes);
		$id_user = my_userid();
		$id_lokasi = my_location();
		$this->M_mutasi->delete_mutasi_tmp($param1,$id_user,$id_lokasi);
	}

	public function del_all()
	{
		$arr['flag'] = '1';$kodes=array();
		$id_user = my_userid();
		$id_lokasi = my_location();
		$get = $this->M_mutasi->show_mutasi_tmp($id_user,$id_lokasi);
		foreach ($get->result() as $val) {
			$kode_stock = $val->kode_stock;
			$kodes[] = array($kode_stock);
			$this->M_product->update_stock($arr, $kode_stock);
		}
		echo json_encode($kodes);
		$this->M_mutasi->deleteall_mutasi_tmp($id_user,$id_lokasi);
	}
}