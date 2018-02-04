<?php
/**
* Controller penjualan
*/
class Penjualan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_product');
		$this->load->model('M_penjualan');
		$this->load->model('M_setting');
		$this->load->model('M_log_stock');
	}

	public function index($param1=null, $param2=null, $param3=null) {
		$id_user = my_userid();
		$id_lokasi = my_location();
		$data['title'] = 'Penjualan';
		$data['br'] = '';
		$data['penjualan'] = 'class="active"';
		$data['js'] = 'penjualan/daftar';
		$data['page'] = 'penjualan/daftar';
		$this->load->view('page', $data);
	}

	public function submit_scan($barcode=null)
	{
		$kode_stock = $barcode;
		if ($kode_stock!=null) {
			$g = check_barcode($kode_stock);
			if ($g==0) {
				echo 'empty';
			}
			else if ($g==1) {
				$get_nofaktur = $this->M_penjualan->last_no_faktur();
				$last_no_faktur = $get_nofaktur->row()->max_no_faktur;
				$no_faktur_need_zero = $last_no_faktur+1;
				
				if(strlen($no_faktur_need_zero)==1){$no_faktur_plus_zero = '000000'.$no_faktur_need_zero;}
				elseif(strlen($no_faktur_need_zero)==2){$no_faktur_plus_zero = '00000'.$no_faktur_need_zero;}
				elseif(strlen($no_faktur_need_zero)==2){$no_faktur_plus_zero = '0000'.$no_faktur_need_zero;}
				elseif(strlen($no_faktur_need_zero)==3){$no_faktur_plus_zero = '000'.$no_faktur_need_zero;}
				elseif(strlen($no_faktur_need_zero)==4){$no_faktur_plus_zero = '00'.$no_faktur_need_zero;}
				elseif(strlen($no_faktur_need_zero)==5){$no_faktur_plus_zero = '0'.$no_faktur_need_zero;}
				elseif(strlen($no_faktur_need_zero)==6){$no_faktur_plus_zero = $no_faktur_need_zero;}
				$no_faktur_now = $no_faktur_plus_zero;
				$id_faktur = $this->M_penjualan->newid();

				$id_stok = get_idstock($kode_stock);
				$kode_product = stock_kodeproduct($kode_stock);
				$id_product = get_idproduct($kode_product);
				$stock_awal = stock($id_product);

				$arr_faktur['id_faktur'] = $id_faktur;
				$arr_faktur['no_faktur'] = $no_faktur_now;
				$arr_faktur['id_user'] = my_userid();
				$arr_faktur['id_lokasi'] = my_location();
				$arr_faktur['tanggal'] = date('Y-m-d H:i:s');
				$arr_faktur['totalitem'] = 1;
				$arr_faktur['totaldisc'] = null;
				$arr_faktur['totalbelanja_awal'] = null;
				$arr_faktur['totalbelanja_akhir'] = harga($id_product);
				$arr_faktur['tunai'] = null;
				$arr_faktur['kembali'] = null;
				$arr_faktur['flag_transaksi'] = 1;
				$arr_faktur['kode_product'] = stock_kodeproduct($kode_stock);
				$arr_faktur['kode_stock'] = $barcode;
				$arr_faktur['nama_product'] = product($id_product);
				$arr_faktur['harga_satuan'] = harga($id_product);
				$arr_faktur['id_product'] = $id_product;

				$arr['flag'] = '0';
				// echo json_encode($arr_faktur);
				$this->M_product->update_stock($arr, $kode_stock);
				$this->M_penjualan->insert($arr_faktur);

				$arr_log['id_product'] = $id_product;
				$arr_log['id_user'] = my_userid();
				$arr_log['id_lokasi'] = my_location();
				$arr_log['tanggal'] = date('Y-m-d H:i:s');
				$arr_log['kode'] = stock_kodeproduct($kode_stock);
				$arr_log['product'] = product($id_product);
				$arr_log['quantity_awal'] = $stock_awal;
				$arr_log['quantity_akhir'] = stock($id_product);
				$arr_log['quantity_tambah'] = null;
				$arr_log['quantity_jual'] = 1;
				$arr_log['harga_satuan'] = harga($id_product);
				$arr_log['harga_masuk'] = null;
				$arr_log['harga_keluar'] = 1*harga($id_product);
				// echo json_encode($arr_log);
				$this->M_log_stock->insert($arr_log);

				$detail_transaksi = $this->M_penjualan->detail_transaksi($id_faktur);
				$waktu_transaksi = $detail_transaksi->row()->tanggal;
				$data['id_faktur'] = $id_faktur;
				$data['no_faktur'] = $detail_transaksi->row()->no_faktur;
				$data['set'] = $this->M_setting->show();
				$data['waktu_transaksi'] = $waktu_transaksi;
				$data['listdata'] = $this->M_penjualan->detail_transaksi($id_faktur);
				$data['totalbelanja'] = $this->M_penjualan->total_detail_transaksi($id_faktur);
				$this->load->view('penjualan/print', $data);
			}
			else {
				echo 'unlist';
			}
		}
	}

	public function submit_grosir($barcode=null)
	{
		$kode_stock = $barcode;
		$arr_data = array();
		if ($kode_stock!=null) {
			$g = check_barcode($kode_stock);
			if ($g==0) {
				echo json_encode(array('error'=>'empty'));
			}
			else if ($g==1) {
				$id_stok = get_idstock($kode_stock);
        $kode_product = stock_kodeproduct($kode_stock);
        $id_product = get_idproduct($kode_product);
        $stock_awal = stock($id_product);

        $arr_data = array(
          'id_user'=> my_userid(),
          'id_lokasi'=> my_location(),
          'id_product'=> $id_product,
          'kode'=>$kode_product,
          'id_pdetail'=> $id_stok,
          'kode_stock'=>$kode_stock,
          'jumlah'=> 1,
          'hargasatuan'=> harga($id_product),
          'product'=> product($id_product),
          'diskon'=> 0,
          'total'=> harga($id_product),
          'flag'=> 1
        );
        $arr['flag'] = '0';
        $this->M_penjualan->input_grosir_tmp($arr_data);
        $this->M_product->update_stock($arr, $kode_stock);

        // data
        $id_user = my_userid();
		    $id_lokasi = my_location();
		    $arr_tmp = array();
		    $temp = $this->M_penjualan->show_grosir_tmp_grp($id_user,$id_lokasi);
		    // echo $this->db->last_query();

		    if ($temp->result()) {
		      foreach ($temp->result() as $tmp) {
		        $stock_awal = stock($tmp->id_product);
		        $arr_tmp[] = array(
		          'id_product'=>$tmp->id_product,
		          'kode'=>$tmp->kode,
		          'jumlah'=>$tmp->jumlah,
		          'hargasatuan'=>$tmp->harga_jual,
		          'product'=>$tmp->product,
		          'diskon'=>$tmp->diskon,
		          'total'=>$tmp->total
		        );
		      }
		      echo json_encode($arr_tmp);
		    }
			}
			else {
				// echo 'unlist';s9
				echo json_encode(array('error'=>'unlist'));
			}
		}
		else {
			// echo 'unlist';
			echo json_encode(array('error'=>'unlist'));
		}
	}

	public function grosir_list()
	{
		$id_user = my_userid();
    $id_lokasi = my_location();
    $arr_tmp = array();
    $temp = $this->M_penjualan->show_grosir_tmp_grp($id_user,$id_lokasi);
    // echo $this->db->last_query();

    if ($temp->result()) {
      foreach ($temp->result() as $tmp) {
        $stock_awal = stock($tmp->id_product);
        $arr_tmp[] = array(
          'id_product'=>$tmp->id_product,
          'kode'=>$tmp->kode,
          'jumlah'=>$tmp->jumlah,
          'hargasatuan'=>$tmp->harga_jual,
          'product'=>$tmp->product,
          'diskon'=>$tmp->diskon,
          'total'=>$tmp->total
        );
      }
      echo json_encode($arr_tmp);
    }
	}

	public function get_total_grosir()
	{
		$id_user = my_userid();
		$id_lokasi = my_location();
		$data = $this->M_penjualan->show_grosir_tmp_ttl($id_user,$id_lokasi);
		echo json_encode($data);
	}

	public function gsr_check()
	{
		$kd = $this->input->post('param1');
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

	public function gsr_print()
	{
		$gsrbayar = $this->input->get_post('pgsrbayar');
		$gsrkembalian = $this->input->get_post('pgsrkembalian');
		$gsrpotongan = $this->input->get_post('gsrpotongan');
		$id_user = my_userid();
		$id_lokasi = my_location();
		$get_nofaktur = $this->M_penjualan->last_grosir_faktur();
		$last_no_faktur = $get_nofaktur->row()->max_no_faktur;
		$no_faktur_need_zero = $last_no_faktur+1;
		
		if(strlen($no_faktur_need_zero)==1){$no_faktur_plus_zero = '000000'.$no_faktur_need_zero;}
		elseif(strlen($no_faktur_need_zero)==2){$no_faktur_plus_zero = '00000'.$no_faktur_need_zero;}
		elseif(strlen($no_faktur_need_zero)==2){$no_faktur_plus_zero = '0000'.$no_faktur_need_zero;}
		elseif(strlen($no_faktur_need_zero)==3){$no_faktur_plus_zero = '000'.$no_faktur_need_zero;}
		elseif(strlen($no_faktur_need_zero)==4){$no_faktur_plus_zero = '00'.$no_faktur_need_zero;}
		elseif(strlen($no_faktur_need_zero)==5){$no_faktur_plus_zero = '0'.$no_faktur_need_zero;}
		elseif(strlen($no_faktur_need_zero)==6){$no_faktur_plus_zero = $no_faktur_need_zero;}
		$no_faktur_now = $no_faktur_plus_zero;
		$id_faktur = $this->M_penjualan->newid_grosir();
		$total = $this->M_penjualan->show_grosir_tmp_ttl($id_user,$id_lokasi);
		$load_tmp = $this->M_penjualan->show_grosir_tmp($id_user,$id_lokasi);
		$id_product = $load_tmp->row()->id_product;
		$stock_awal = stock($id_product);
		$total_akhir = intval($total) - intval($gsrpotongan);

		$arr_faktur['id_faktur'] = $id_faktur;
		$arr_faktur['id_user'] = $id_user;
		$arr_faktur['id_lokasi'] = $id_lokasi;
		$arr_faktur['tanggal'] = date('Y-m-d H:i:s');
		$arr_faktur['no_faktur'] = $no_faktur_now;
		$arr_faktur['total'] = $total;
		$arr_faktur['potongan'] = $gsrpotongan;
		$arr_faktur['total_akhir'] = $total_akhir;
		$arr_faktur['keterangan'] = null;
		$arr_faktur['bayar'] = $gsrbayar;
		$arr_faktur['kembalian'] = $gsrkembalian;

		$this->M_penjualan->input_grosir($arr_faktur);
		$faktur_gros = $this->M_penjualan->last_grosir_faktur();
		$no_faktur = $faktur_gros->row()->max_no_faktur;
		$detail_transaksi = $this->M_penjualan->get_transaksigrosir(null,$no_faktur);
		
		foreach ($load_tmp->result() as $val) {
			$arr['flag'] = '0';
			$this->M_product->update_stock($arr, $val->kode);
			$stock_akhir = stock($id_product);

			$arr_dtl['id_faktur'] = $detail_transaksi->row()->id_faktur;
			$arr_dtl['id_product'] = $val->id_product;
			$arr_dtl['kode'] = $val->kode;
			$arr_dtl['kode_stock'] = $val->kode_stock;
			$arr_dtl['jumlah'] = $val->jumlah;
			$arr_dtl['hargasatuan'] = $val->hargasatuan;
			$arr_dtl['product'] = $val->product;
			$arr_dtl['diskon'] = $val->diskon;
			$arr_dtl['total'] = $val->total;

			$this->M_penjualan->input_grosir_detail($arr_dtl);

			$arr_log['id_product'] = $id_product;
			$arr_log['id_user'] = $id_user;
			$arr_log['id_lokasi'] = $id_lokasi;
			$arr_log['tanggal'] = date('Y-m-d H:i:s');
			$arr_log['kode'] = $val->kode;
			$arr_log['product'] = $val->product;
			$arr_log['quantity_awal'] = $stock_awal;
			$arr_log['quantity_akhir'] = $stock_akhir;
			$arr_log['quantity_tambah'] = null;
			$arr_log['quantity_jual'] = 1;
			$arr_log['harga_satuan'] = $val->hargasatuan;
			$arr_log['harga_masuk'] = null;
			$arr_log['harga_keluar'] = 1*$val->hargasatuan;

			$this->M_log_stock->insert($arr_log);
		}
		$this->M_penjualan->deleteall_grosir_tmp($id_user,$id_lokasi);
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

	public function del_itm($param1=null)
	{
		$arr['flag'] = '1';
		$get = $this->M_penjualan->detail_grosir_temp($param1);
		foreach ($get->result() as $val) {
			$kode_stock = $val->kode_stock;
			$kodes[] = array($kode_stock);
			$this->M_product->update_stock($arr, $kode_stock);
		}
		echo json_encode($kodes);
		$id_user = my_userid();
		$id_lokasi = my_location();
		$this->M_penjualan->delete_grosir_tmp($param1,$id_user,$id_lokasi);
	}

	public function del_all()
	{
		$arr['flag'] = '1';
		$id_user = my_userid();
		$id_lokasi = my_location();
		$get = $this->M_penjualan->show_grosir_tmp($id_user,$id_lokasi);
		foreach ($get->result() as $val) {
			$kode_stock = $val->kode_stock;
			$kodes[] = array($kode_stock);
			$this->M_product->update_stock($arr, $kode_stock);
		}
		echo json_encode($kodes);
		$this->M_penjualan->deleteall_grosir_tmp($id_user,$id_lokasi);
	}
}
