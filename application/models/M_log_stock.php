<?php
/**
* 
*/
class M_log_stock extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->log = 'log_stock';
		$this->supplier = 'supplier';
		$this->jenis = 'jenis';
		$this->lokasi = 'lokasi';
		$this->provider = 'provider';
		$this->barang = 'barang';
	}

	public function newid()
	{
		$this->db->select_max('id_log_in','max');
		$cek=$this->db->get($this->log);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_log_in');
		$this->db->from($this->log);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->log, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->log, $arr_data);
	}

	public function show($lokasi, $tgl_awal, $tgl_akhir, $perpage, $offset)
	{
		$this->db->select('a.*, e.lokasi');
		$this->db->from($this->log.' a');
		$this->db->join($this->lokasi.' e', 'a.id_lokasi = e.id_lokasi', 'left');
		if ($lokasi) $this->db->where('a.id_lokasi', $lokasi);
		if ($tgl_awal || $tgl_akhir) $this->db->where("a.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		$this->db->order_by('a.tanggal', 'desc');
		return $this->db->get();
	}
}