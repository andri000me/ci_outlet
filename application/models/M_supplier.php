<?php
/**
* Model supplier
*/
class M_supplier extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->supplier = 'supplier';
	}

	public function newid()
	{
		$this->db->select_max('id_supplier','max');
		$cek=$this->db->get($this->supplier);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_supplier');
		$this->db->from($this->supplier);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->supplier, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->supplier, $arr_data);
	}

	public function update($arr_data,$id_supplier)
	{
		$this->db->where('id_supplier', $id_supplier);
		$this->db->update($this->supplier, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->supplier);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_supplier)
	{
		return $this->db->get_where($this->supplier, array('id_supplier'=>$id_supplier));
	}

	public function delete($id_supplier)
	{
		$this->db->delete($this->supplier, array('id_supplier'=>$id_supplier));
	}

	public function cek_kode($kode)
	{
		return $this->db->get_where($this->supplier, array('kode'=>$kode));
	}
}