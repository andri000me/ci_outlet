<?php
/**
* Model mutasi
*/
class M_mutasi extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->product = 'product';
		$this->mutasi = 'mutasi';
		$this->detail = 'mutasi_detail';
		$this->temp = 'mutasi_tmp';
	}

	public function newid()
	{
		$this->db->select_max('id_mutasi','max');
		$cek=$this->db->get($this->mutasi);
		return $cek->row()->max+1;
	}

	function count($id_product_awal)
	{
		$this->db->select('id_mutasi');
		$this->db->from($this->mutasi);
		if ($id_product_awal) $this->db->where('id_product_awal', $id_product_awal);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->mutasi, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->mutasi, $arr_data);
	}

	public function update($arr_data,$id_mutasi)
	{
		$this->db->where('id_mutasi', $id_mutasi);
		$this->db->update($this->mutasi, $arr_data);
	}

	public function show($id_product_awal,$perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->mutasi);
		if ($id_product_awal) $this->db->where('id_product_awal', $id_product_awal);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_mutasi)
	{
		return $this->db->get_where($this->mutasi, array('id_mutasi'=>$id_mutasi));
	}

	public function delete($id_mutasi)
	{
		$this->db->delete($this->mutasi, array('id_mutasi'=>$id_mutasi));
	}

	public function detail_count($id_mutasi)
	{
		$this->db->select('id_mutasi');
		$this->db->from($this->detail);
		if ($id_mutasi) $this->db->where('id_mutasi', $id_mutasi);
		return $this->db->count_all_results();
	}

	public function detail_insert($arr_data)
	{
		$this->db->insert($this->detail, $arr_data);
	}
	public function detail_show($id_mutasi,$perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->detail);
		if ($id_mutasi) $this->db->where('id_mutasi', $id_mutasi);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	// 
	// TEMP
	// 
	public function insert_mutasi_tmp($arr_data)
	{
		$this->db->insert($this->temp, $arr_data);
	}

	public function show_mutasi_tmp($id_user,$id_lokasi)
	{
		$this->db->select('*');
		$this->db->from($this->temp);
		if($id_user)	$this->db->where('id_user', $id_user);
		if($id_lokasi)	$this->db->where('id_lokasi', $id_lokasi);
		return $this->db->get();
	}

	public function show_mutasi_tmp_grp($id_user,$id_lokasi)
	{
		$this->db->select('a.id_product, a.kode, a.product, a.harga_jual, b.*');
		$this->db->from($this->product.' a');
		$this->db->join('(SELECT id_product, id_user, id_lokasi, COUNT(id_product) jumlah FROM '.$this->temp.' GROUP BY id_product, id_user, id_lokasi) b', 'a.id_product = b.id_product', 'left');
		if($id_user)	$this->db->where('b.id_user', $id_user);
		if($id_lokasi)	$this->db->where('b.id_lokasi', $id_lokasi);
		return $this->db->get();
	}

	public function show_mutasi_tmp_product($id_user,$id_lokasi,$id_product)
	{
		$this->db->select('*');
		$this->db->from($this->temp);
		if($id_user)	$this->db->where('id_user', $id_user);
		if($id_lokasi)	$this->db->where('id_lokasi', $id_lokasi);
		if($id_product)	$this->db->where('id_product', $id_product);
		return $this->db->get();
	}

	public function detail_mutasi_tmp($id_product)
	{
		return $this->db->get_where($this->temp, array('id_product'=>$id_product));
	}

	public function check_mutasi_tmp($kode_stock)
	{
		return $this->db->get_where($this->temp, array('kode_stock'=>$kode_stock));
	}

	public function total_mutasi_tmp($id_user,$id_lokasi)
	{
		$this->db->select('COUNT(id_tmp) total');
		$this->db->from($this->temp);
		if($id_user)	$this->db->where('id_user', $id_user);
		if($id_lokasi)	$this->db->where('id_lokasi', $id_lokasi);
		$cek = $this->db->get();
		return $cek->row()->total;
	}

	public function delete_mutasi_tmp($id_product,$id_user,$id_lokasi)
	{
		$this->db->delete($this->temp, array('id_product'=>$id_product,'id_user'=>$id_user,'id_lokasi'=>$id_lokasi));
	}

	public function deleteall_mutasi_tmp($id_user,$id_lokasi)
	{
		$this->db->delete($this->temp, array('id_user'=>$id_user,'id_lokasi'=>$id_lokasi));
	}
}