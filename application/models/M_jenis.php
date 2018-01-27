<?php
/**
* Model jenis
*/
class M_jenis extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->jenis = 'jenis';
	}

	public function newid()
	{
		$this->db->select_max('id_jenis','max');
		$cek=$this->db->get($this->jenis);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_jenis');
		$this->db->from($this->jenis);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->jenis, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->jenis, $arr_data);
	}

	public function update($arr_data,$id_jenis)
	{
		$this->db->where('id_jenis', $id_jenis);
		$this->db->update($this->jenis, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->jenis);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_jenis)
	{
		return $this->db->get_where($this->jenis, array('id_jenis'=>$id_jenis));
	}

	public function delete($id_jenis)
	{
		$this->db->delete($this->jenis, array('id_jenis'=>$id_jenis));
	}
	
	public function cek_kode($kode)
	{
		return $this->db->get_where($this->jenis, array('kode'=>$kode));
	}
}