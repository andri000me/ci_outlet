<?php
/**
* Model barang
*/
class M_barang extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->barang = 'barang';
	}

	public function newid()
	{
		$this->db->select_max('id_barang','max');
		$cek=$this->db->get($this->barang);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_barang');
		$this->db->from($this->barang);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->barang, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->barang, $arr_data);
	}

	public function update($arr_data,$id_barang)
	{
		$this->db->where('id_barang', $id_barang);
		$this->db->update($this->barang, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->barang);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		$this->db->order_by('kode', 'acd');
		return $this->db->get();
	}

	public function get($id_barang)
	{
		return $this->db->get_where($this->barang, array('id_barang'=>$id_barang));
	}

	public function delete($id_barang)
	{
		$this->db->delete($this->barang, array('id_barang'=>$id_barang));
	}

	public function cek_kode($kode)
	{
		return $this->db->get_where($this->barang, array('kode'=>$kode));
	}
}