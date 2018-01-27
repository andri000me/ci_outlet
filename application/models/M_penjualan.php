<?php
/**
* Model transaksi
*/
class M_penjualan extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->transaksi = 'transaksi';
		$this->transaksi_detail = 'transaksi_detail';
		$this->transaksi_grosir = 'transaksi_grosir';
		$this->transaksi_grosir_detail = 'transaksi_grosir_detail';
		$this->transaksi_grosir_tmp = 'transaksi_grosir_tmp';
		$this->product = 'product';
		$this->supplier = 'supplier';
		$this->jenis = 'jenis';
		$this->provider = 'provider';
		$this->lokasi = 'lokasi';
		$this->stock = 'stock';
	}

	public function newid()
	{
		$this->db->select_max('id_faktur','max');
		$cek=$this->db->get($this->transaksi);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_faktur');
		$this->db->from($this->transaksi);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->transaksi, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->transaksi, $arr_data);
	}

	public function update($arr_data,$id_faktur)
	{
		$this->db->where('id_faktur', $id_faktur);
		$this->db->update($this->transaksi, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('a.*');
		$this->db->from($this->transaksi.' a');
		$this->db->order_by('a.tanggal', 'desc');
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}
	public function last($nama, $perpage, $offset)
	{
		$this->db->select('a.*');
		$this->db->from($this->transaksi.' a');
		$this->db->order_by('a.tanggal', 'desc');
		$this->db->limit(1);
		return $this->db->get();
	}

	// tambahan
	function last_transaksi()
	{
		$this->db->select('*');
    	$this->db->from($this->transaksi);
    	$this->db->order_by("id_faktur", "desc");
    	$this->db->limit('1');
    	return $this->db->get();
	}

	function last_no_faktur()
	{
		$this->db->select('max(no_faktur) max_no_faktur');
    	$this->db->from($this->transaksi);
    	return $this->db->get();
	}

	function get_totalbelanja_awal_old($id_faktur)
	{
		$this->db->select('sum(a.quantity*b.harga_jual) totalbelanja_awal');
		$this->db->from($this->transaksi_detail.' a');
		$this->db->join($this->fashionproduct.' b','b.kode=a.kode','left');
		$this->db->where('a.id_faktur',$id_faktur);
		return $this->db->get();
	}

	function get_totalbelanja_awal($id_faktur)
	{
		$this->db->select('sum(a.harga*a.quantity) totalbelanja_awal');
		$this->db->from($this->transaksi_detail.' a');
		$this->db->where('a.id_faktur',$id_faktur);
		return $this->db->get();
	}

	function get_totalitem($id_faktur)
	{
		$this->db->select('sum(a.quantity) totalitem');
		$this->db->from($this->transaksi_detail.' a');
		$this->db->where('a.id_faktur',$id_faktur);
		return $this->db->get();
	}

	function show_all_barang_order($id_faktur)
	{
		$this->db->select('a.*');
		$this->db->from($this->transaksi_detail.' a');
		$this->db->where('a.id_faktur',$id_faktur);
		return $this->db->get();
	}

	function detail_transaksi($id_faktur)
	{
		$this->db->select('a.*');
  	$this->db->from($this->transaksi.' a');
  	$this->db->where("id_faktur",$id_faktur);
  	return $this->db->get();
	}

	public function total_detail_transaksi($id_faktur)
	{
		$this->db->select('SUM(a.totalbelanja_akhir) AS totalbelanja');
  	$this->db->from($this->transaksi.' a');
  	$this->db->where("id_faktur",$id_faktur);
  	$get = $this->db->get();
  	return $get->row()->totalbelanja;
	}

	function detail_transaksi_barang($id_faktur)
	{
		$this->db->select('a.*');
  	$this->db->from($this->transaksi_detail.' a');
  	$this->db->where("id_faktur",$id_faktur);
  	return $this->db->get();
	}

	function cek_transaksi_detail($kode,$id_faktur)
	{
		$this->db->select('a.*');
  	$this->db->from($this->transaksi_detail.' a');
  	$this->db->where("kode",$kode);
  	$this->db->where("id_faktur",$id_faktur);
  	$this->db->limit('1');
  	return $this->db->get();
	}

	function cek_qty($kode)
	{
		$this->db->select('a.*');
  	$this->db->from($this->product.' a');
  	$this->db->where("kode",$kode);
  	$this->db->limit('1');
  	return $this->db->get();
	}

	function cek_kode_barang($kode,$id_faktur)
	{
		$this->db->select('a.*');
  	$this->db->from($this->transaksi_detail.' a');
  	$this->db->where("kode",$kode);
  	$this->db->where("id_faktur",$id_faktur);
  	$this->db->limit('1');
  	return $this->db->get();
	}

	function insert_transaksi($waktu_transaksi,$id_pegawai)
	{
		if ($this->db->insert($this->transaksi,
			array('no_faktur'=>'0',
					'id_user'=>$id_pegawai,
		  			'tanggal'=>$waktu_transaksi,
			 	  'totalitem'=>'0',
			 	  'totaldisc'=>'0',
 		  'totalbelanja_awal'=>'0',
 		 'totalbelanja_akhir'=>'0',
		 	 		  'tunai'=>'0',
			 		'kembali'=>'0',
		     'flag_transaksi'=>'4'))) return TRUE;
		else return FALSE;
	}

	function insert_transaksi_detail($id_faktur,$kode,$product,$harga)
	{
		if($this->db->insert($this->transaksi_detail,
			array('id_faktur'=>$id_faktur,
				   	   'kode'=>$kode,
				   'quantity'=>'1',
				    'product'=>$product,
					  'harga'=>$harga))) return TRUE;
		else return FALSE;
	}

	function update_qty($id_faktur,$kode,$qty)
	{
		$data['quantity'] = $qty;
		$this->db->where('kode',$kode);
		$this->db->where('id_faktur',$id_faktur);
		$this->db->update($this->transaksi_detail,$data);
	}

	function update_stok($kode,$stok_update,$nm_table)
	{
		$data['quantity'] = $stok_update;
		$this->db->where('kode',$kode);
		$this->db->update($nm_table,$data);
	}

	function update_transaksi($id_faktur,$no_faktur,$totalitem,$totalbelanja_awal,$totaldisc,$totalbelanja_akhir,$tunai,$kembali,$flag)
	{
		if($no_faktur!=NULL){$data['no_faktur'] = $no_faktur;}
		if($totalitem!=NULL){$data['totalitem'] = $totalitem;}
		if($totalbelanja_awal!=NULL){$data['totalbelanja_awal'] = $totalbelanja_awal;}
		if($totaldisc!=NULL){$data['totaldisc'] = $totaldisc;}
		if($totalbelanja_akhir!=NULL){$data['totalbelanja_akhir'] = $totalbelanja_akhir;}
		if($totalbelanja_akhir!=NULL){$data['tunai'] = $tunai;}
		if($totalbelanja_akhir!=NULL){$data['kembali'] = $kembali;}
		if($flag!=NULL){$data['flag_transaksi'] = $flag;}
		$this->db->where('id_faktur',$id_faktur);
		$this->db->update($this->transaksi,$data);
	}

	function update_flag_transaksi($id_faktur,$flag)
	{
		$data['flag_transaksi'] = $flag;
		$this->db->where('id_faktur',$id_faktur);
		$this->db->update($this->transaksi,$data);
	}

	function hapus_barang($id_faktur,$kode)
	{
		$this->db->delete($this->transaksi_detail,array('id_faktur'=>$id_faktur,'kode'=>$kode));
	}

	// end of tambahan

	public function get($id_faktur)
	{
		$this->db->select('a.*, f.lokasi');
		$this->db->from($this->transaksi.' a');
		$this->db->join($this->lokasi.' f', 'a.id_lokasi = f.id_lokasi', 'left');
		if ($id_faktur) $this->db->where('a.id_faktur', $id_faktur);
		return $this->db->get();
	}

	public function get_detail($kode)
	{
		$this->db->select('a.*, b.product, c.supplier, d.jenis, e.provider, f.lokasi');
		$this->db->from($this->transaksi.' a');
		$this->db->join($this->product.' b', 'a.id_product = b.id_product', 'left');
		$this->db->join($this->supplier.' c', 'a.id_supplier = c.id_supplier', 'left');
		$this->db->join($this->jenis.' d', 'a.id_jenis = d.id_jenis', 'left');
		$this->db->join($this->provider.' e', 'a.id_provider = e.id_provider', 'left');
		$this->db->join($this->lokasi.' f', 'a.id_lokasi = f.id_lokasi', 'left');
		if ($kode) $this->db->where('a.kode', $kode);
		return $this->db->get();
	}

	public function get_transaksiitem($id_faktur,$no_faktur)
	{
		$this->db->select('*');
		$this->db->from($this->transaksi);
		if($id_faktur)	$this->db->where('id_faktur', $id_faktur);
		if($no_faktur)	$this->db->where('no_faktur', $no_faktur);
		return $this->db->get();
	}

	public function transaksi($id_faktur)
	{
		$this->db->select('quantity');
		$cek=$this->db->get_where($this->transaksi, array('id_faktur'=>$id_faktur));
		return $cek->row()->quantity;
	}

	public function updatetransaksi($kode, $quantity)
	{
		$this->db->where('kode', $kode);
		$this->db->update($this->transaksi, array('quantity'=>$quantity));
	}

	public function update_transaksi_item($kode_stock,$arr_data)
	{
		$this->db->where('kode_stock', $kode_stock);
		$this->db->update($this->transaksi, $arr_data);
	}

	public function delete($id_faktur)
	{
		$this->db->delete($this->transaksi, array('id_faktur'=>$id_faktur));
	}

	public function cek_kode($kode)
	{
		return $this->db->get_where($this->transaksi, array('kode'=>$kode));
	}

	public function transaksilimit()
	{
		$this->db->select('a.*, b.product, c.supplier, d.jenis, e.provider, f.lokasi');
		$this->db->from($this->transaksi.' a');
		$this->db->join($this->product.' b', 'a.id_product = b.id_product', 'left');
		$this->db->join($this->supplier.' c', 'a.id_supplier = c.id_supplier', 'left');
		$this->db->join($this->jenis.' d', 'a.id_jenis = d.id_jenis', 'left');
		$this->db->join($this->provider.' e', 'a.id_provider = e.id_provider', 'left');
		$this->db->join($this->lokasi.' f', 'a.id_lokasi = f.id_lokasi', 'left');
		$this->db->where('quantity <= 10');
		return $this->db->get();
	}

	public function temp_transaksi($id_user)
	{
		return $this->db->get_where($this->temp, array('id_user'=>$id_user));
	}

	public function temp_check($kode)
	{
		$this->db->select('a.*, b.product, c.supplier, d.jenis, e.provider, f.lokasi');
		$this->db->from($this->temp.' a');
		$this->db->join($this->product.' b', 'a.id_product = b.id_product', 'left');
		$this->db->join($this->supplier.' c', 'a.id_supplier = c.id_supplier', 'left');
		$this->db->join($this->jenis.' d', 'a.id_jenis = d.id_jenis', 'left');
		$this->db->join($this->provider.' e', 'a.id_provider = e.id_provider', 'left');
		$this->db->join($this->lokasi.' f', 'a.id_lokasi = f.id_lokasi', 'left');
		if ($kode) $this->db->where('a.kode', $kode);
		return $this->db->get();
	}

	public function temp_update($arr_data,$kode)
	{
		$this->db->where('kode', $kode);
		$this->db->update($this->temp, $arr_data);
	}

	public function temp_insert($arr_data)
	{
		$this->db->insert_batch($this->temp, $arr_data);
	}

	public function delete_item_temp($id_temp_transaksi)
	{
		$this->db->delete($this->temp, array('id_temp_transaksi'=>$id_temp_transaksi));
	}

	public function newid_grosir()
	{
		$this->db->select_max('id_faktur','max');
		$cek=$this->db->get($this->transaksi_grosir);
		return $cek->row()->max+1;
	}

	public function last_grosir_faktur()
	{
		$this->db->select('max(no_faktur) max_no_faktur');
    	$this->db->from($this->transaksi_grosir);
    	return $this->db->get();
	}

	public function input_grosir($arr_data)
	{
		$this->db->insert($this->transaksi_grosir, $arr_data);
	}

	public function update_grosir($arr_data, $id_faktur)
	{
		$this->db->where('id_faktur', $id_faktur);
		$this->db->update($this->transaksi_grosir, $arr_data);
	}

	public function input_grosir_detail($arr_data)
	{
		$this->db->insert($this->transaksi_grosir_detail, $arr_data);
	}

	public function show_grosir($id_user,$id_lokasi,$id_faktur,$no_faktur)
	{
		$this->db->select('*');
		$this->db->from($this->transaksi_grosir);
		if($id_user)	$this->db->where('id_user', $id_user);
		if($id_lokasi)	$this->db->where('id_lokasi', $id_lokasi);
		if($id_faktur)	$this->db->where('id_faktur', $id_faktur);
		if($no_faktur)	$this->db->where('no_faktur', $no_faktur);
		return $this->db->get();
	}

	public function show_grosir_detail($id_faktur,$no_faktur=null)
	{
		$this->db->select('*');
		$this->db->from($this->transaksi_grosir_detail);
		if($id_faktur)	$this->db->where('id_faktur', $id_faktur);
		if($no_faktur)	$this->db->where('no_faktur', $no_faktur);
		return $this->db->get();
	}

	public function show_grosir_detail_grp($id_faktur)
	{
		$this->db->select('a.id_product, a.kode, a.product, a.harga_jual, b.*');
		$this->db->from($this->product.' a');
		$this->db->join('(SELECT id_product, id_faktur, hargasatuan, SUM(jumlah) jumlah, SUM(total) total, SUM(diskon) diskon FROM '.$this->transaksi_grosir_detail.' GROUP BY id_product, id_faktur, hargasatuan) b', 'a.id_product = b.id_product', 'left');
		if($id_faktur)	$this->db->where('b.id_faktur', $id_faktur);
		return $this->db->get();
	}

	public function get_transaksigrosir($id_faktur,$no_faktur)
	{
		$this->db->select('*');
		$this->db->from($this->transaksi_grosir);
		if($id_faktur)	$this->db->where('id_faktur', $id_faktur);
		if($no_faktur)	$this->db->where('no_faktur', $no_faktur);
		return $this->db->get();
	}

	public function get_grosir_item($kode_stock)
	{
		$this->db->select('*');
		$this->db->from($this->transaksi_grosir_detail);
		if($kode_stock)	$this->db->where('kode_stock', $kode_stock);
		return $this->db->get();
	}

	public function update_grosir_item($kode_stock,$arr_data)
	{
		$this->db->where('kode_stock', $kode_stock);
		$this->db->update($this->transaksi_grosir_detail, $arr_data);
	}

	public function total_grosir_detail($id_faktur,$no_faktur)
	{
		$this->db->select('total');
		$this->db->from($this->transaksi_grosir);
		if($id_faktur)	$this->db->where('id_faktur', $id_faktur);
		if($no_faktur)	$this->db->where('no_faktur', $no_faktur);
		$get = $this->db->get();
		return $get->row()->total;
	}

	public function input_grosir_tmp($arr_data)
	{
		$this->db->insert($this->transaksi_grosir_tmp, $arr_data);
	}

	public function delete_grosir_tmp($id_product,$id_user,$id_lokasi)
	{
		$this->db->delete($this->transaksi_grosir_tmp, array('id_product'=>$id_product,'id_user'=>$id_user,'id_lokasi'=>$id_lokasi));
	}

	public function deleteall_grosir_tmp($id_user,$id_lokasi)
	{
		$this->db->delete($this->transaksi_grosir_tmp, array('id_user'=>$id_user,'id_lokasi'=>$id_lokasi));
	}

	public function detail_grosir_temp($id_product)
	{
		return $this->db->get_where($this->transaksi_grosir_tmp, array('id_product'=>$id_product));
	}

	public function show_grosir_tmp($id_user,$id_lokasi)
	{
		$this->db->select('*');
		$this->db->from($this->transaksi_grosir_tmp);
		if($id_user)	$this->db->where('id_user', $id_user);
		if($id_lokasi)	$this->db->where('id_lokasi', $id_lokasi);
		return $this->db->get();
	}
	
	public function show_grosir_tmp_grp($id_user,$id_lokasi)
	{
		$this->db->select('a.id_product, a.kode, a.product, a.harga_jual, b.*');
		$this->db->from($this->product.' a');
		$this->db->join('(SELECT id_product, id_user, id_lokasi, SUM(jumlah) jumlah, SUM(total) total, SUM(diskon) diskon FROM '.$this->transaksi_grosir_tmp.' GROUP BY id_product, id_user, id_lokasi) b', 'a.id_product = b.id_product', 'left');
		if($id_user)	$this->db->where('b.id_user', $id_user);
		if($id_lokasi)	$this->db->where('b.id_lokasi', $id_lokasi);
		return $this->db->get();
	}

	public function show_grosir_tmp_ttl($id_user,$id_lokasi)
	{
		$this->db->select('SUM(b.total) total');
		$this->db->from($this->product.' a');
		$this->db->join('(SELECT id_product, id_user, id_lokasi, SUM(jumlah) jumlah, SUM(total) total, SUM(diskon) diskon FROM '.$this->transaksi_grosir_tmp.' GROUP BY id_product, id_user, id_lokasi) b', 'a.id_product = b.id_product', 'left');
		if($id_user)	$this->db->where('b.id_user', $id_user);
		if($id_lokasi)	$this->db->where('b.id_lokasi', $id_lokasi);
		$cek = $this->db->get();
		return $cek->row()->total;
	}
}