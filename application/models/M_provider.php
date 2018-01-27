<?php
/**
* Model provider
*/
class M_provider extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->provider = 'provider';
	}

	public function newid()
	{
		$this->db->select_max('id_provider','max');
		$cek=$this->db->get($this->provider);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_provider');
		$this->db->from($this->provider);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->provider, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->provider, $arr_data);
	}

	public function update($arr_data,$id_provider)
	{
		$this->db->where('id_provider', $id_provider);
		$this->db->update($this->provider, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->provider);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_provider)
	{
		return $this->db->get_where($this->provider, array('id_provider'=>$id_provider));
	}

	public function delete($id_provider)
	{
		$this->db->delete($this->provider, array('id_provider'=>$id_provider));
	}

	public function cek_kode($kode)
	{
		return $this->db->get_where($this->provider, array('kode'=>$kode));
	}
}