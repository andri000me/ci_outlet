<?php
/**
* Model lokasi
*/
class M_lokasi extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->lokasi = 'lokasi';
	}

	public function newid()
	{
		$this->db->select_max('id_lokasi','max');
		$cek=$this->db->get($this->lokasi);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_lokasi');
		$this->db->from($this->lokasi);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->lokasi, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->lokasi, $arr_data);
	}

	public function update($arr_data,$id_lokasi)
	{
		$this->db->where('id_lokasi', $id_lokasi);
		$this->db->update($this->lokasi, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->lokasi);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_lokasi)
	{
		return $this->db->get_where($this->lokasi, array('id_lokasi'=>$id_lokasi));
	}

	public function delete($id_lokasi)
	{
		$this->db->delete($this->lokasi, array('id_lokasi'=>$id_lokasi));
	}

	public function cek_kode($kode)
	{
		return $this->db->get_where($this->lokasi, array('kode'=>$kode));
	}
}