<?php
/**
* Model stock
*/
class M_stock extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->stock = 'stock';
		$this->supplier = 'supplier';
		$this->jenis = 'jenis';
		$this->provider = 'provider';
		$this->lokasi = 'lokasi';
		$this->barang = 'barang';
	}

	public function newid()
	{
		$this->db->select_max('id_stock','max');
		$cek=$this->db->get($this->stock);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_stock');
		$this->db->from($this->stock);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->stock, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->stock, $arr_data);
	}

	public function update($arr_data,$kode)
	{
		$this->db->where('kode', $kode);
		$this->db->update($this->stock, $arr_data);
	}

	public function show($id_user, $perpage, $offset)
	{
		$this->db->select('a.*');
		$this->db->from($this->stock.' a');
		if ($id_user) $this->db->where('a.id_user', $id_user);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_stock)
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e.barang, f.lokasi');
		$this->db->from($this->stock.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->barang.' e', 'a.id_barang = e.id_barang', 'left');
		$this->db->join($this->lokasi.' f', 'a.id_lokasi = f.id_lokasi', 'left');
		if ($id_stock) $this->db->where('a.id_stock', $id_stock);
		return $this->db->get();
	}

	public function get_detail($kode)
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e.barang, f.lokasi');
		$this->db->from($this->stock.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->barang.' e', 'a.id_barang = e.id_barang', 'left');
		$this->db->join($this->lokasi.' f', 'a.id_lokasi = f.id_lokasi', 'left');
		if ($kode) $this->db->where('a.kode', $kode);
		return $this->db->get();
	}

	public function stock($kode)
	{
		$this->db->select('quantity');
		$cek=$this->db->get_where($this->stock, array('kode'=>$kode));
		return $cek->row()->quantity;
	}

	public function updatestock($kode, $quantity)
	{
		$this->db->where('kode', $kode);
		$this->db->update($this->stock, array('quantity'=>$quantity));
	}

	public function delete($kode)
	{
		$this->db->delete($this->stock, array('kode'=>$kode));
	}

	public function cek_kode($kode)
	{
		return $this->db->get_where($this->stock, array('kode'=>$kode));
	}

	public function stocklimit()
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e.barang, f.lokasi');
		$this->db->from($this->stock.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->barang.' e', 'a.id_barang = e.id_barang', 'left');
		$this->db->join($this->lokasi.' f', 'a.id_lokasi = f.id_lokasi', 'left');
		$this->db->where('quantity <= 5');
		return $this->db->get();
	}
}