<?php
/**
 * summary
 */
class M_blog extends CI_Model
{
  /**
   * Blog
   */
  public function __construct()
  {
    parent::__construct();
    $this->blog = 'blog';
  }

  public function newid()
	{
		$this->db->select_max('id','max');
		$cek=$this->db->get($this->blog);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id');
		$this->db->from($this->blog);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->blog, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->blog, $arr_data);
	}

	public function update($arr_data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->blog, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->blog);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id)
	{
		return $this->db->get_where($this->blog, array('id'=>$id));
	}

	public function delete($id)
	{
		$this->db->delete($this->blog, array('id'=>$id));
	}
	
	public function cek_kode($kode)
	{
		return $this->db->get_where($this->blog, array('kode'=>$kode));
	}
}