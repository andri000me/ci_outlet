<?php
/**
* Model product
*/
class M_product extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->product = 'product';
		$this->detail = 'product_detail';
		$this->jenis = 'jenis';
		$this->supplier = 'supplier';
		$this->provider ='provider';
		$this->lokasi = 'lokasi';
	}

	public function newid()
	{
		$this->db->select_max('id_product','max');
		$cek=$this->db->get($this->product);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_product');
		$this->db->from($this->product);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->product, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->product, $arr_data);
	}

	public function update($arr_data,$id_product)
	{
		$this->db->where('id_product', $id_product);
		$this->db->update($this->product, $arr_data);
	}

	public function show($nama, $supplier, $jenis, $provider, $lokasi, $perpage, $offset)
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e. lokasi');
		$this->db->from($this->product.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->lokasi.' e', 'a.id_lokasi = e.id_lokasi', 'left');
		if ($supplier) $this->db->where('a.id_supplier', $supplier);
		if ($jenis) $this->db->where('a.id_jenis', $jenis);
		if ($provider) $this->db->where('a.id_provider', $provider);
		if ($lokasi) $this->db->where('a.id_lokasi', $lokasi);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_product)
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e. lokasi');
		$this->db->from($this->product.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->lokasi.' e', 'a.id_lokasi = e.id_lokasi', 'left');
		if ($id_product) $this->db->where('a.id_product', $id_product);
		return $this->db->get();
	}

	public function cek_lokasi($id_product,$id_lokasi)
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e. lokasi');
		$this->db->from($this->product.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->lokasi.' e', 'a.id_lokasi = e.id_lokasi', 'left');
		if ($id_product) $this->db->where('a.id_product', $id_product);
		if ($lokasi) $this->db->where('a.id_lokasi', $lokasi);
		return $this->db->get();
	}

	public function get_detail($kode)
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e. lokasi');
		$this->db->from($this->product.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->lokasi.' e', 'a.id_lokasi = e.id_lokasi', 'left');
		if ($kode) $this->db->where('a.kode', $kode);
		return $this->db->get();
	}

	public function get_detail_k($kode)
	{
		if (my_level()==null) $id_lokasi = $this->session->userdata('id_lokasi');
		else $id_lokasi = my_location();
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e. lokasi');
		$this->db->from($this->product.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->lokasi.' e', 'a.id_lokasi = e.id_lokasi', 'left');
		$this->db->where('a.kode', $kode);
		$this->db->where('e.id_lokasi', $id_lokasi);
		return $this->db->get();
	}

	public function stock($id_product)
	{
		$this->db->select('quantity');
		$cek=$this->db->get_where($this->product, array('id_product'=>$id_product));
		return $cek->row()->quantity;
	}

	public function updatestock($kode, $quantity)
	{
		$this->db->where('kode', $kode);
		$this->db->update($this->product, array('quantity'=>$quantity));
	}

	public function delete($id_product)
	{
		$this->db->delete($this->product, array('id_product'=>$id_product));
	}

	public function cek_kode($kode)
	{
		return $this->db->get_where($this->product, array('kode'=>$kode));
	}

	public function stocklimit()
	{
		$this->db->select('a.*, b.supplier, c.jenis, d.provider, e. lokasi');
		$this->db->from($this->product.' a');
		$this->db->join($this->supplier.' b', 'a.id_supplier = b.id_supplier', 'left');
		$this->db->join($this->jenis.' c', 'a.id_jenis = c.id_jenis', 'left');
		$this->db->join($this->provider.' d', 'a.id_provider = d.id_provider', 'left');
		$this->db->join($this->lokasi.' e', 'a.id_lokasi = e.id_lokasi', 'left');
		$this->db->where('quantity <= 5');
		return $this->db->get();
	}


	public function stock_batch($arr_data)
	{
		$this->db->insert_batch($this->detail, $arr_data);
	}

	public function stock_insert($arr_data)
	{
		$this->db->insert($this->detail, $arr_data);
	}

	public function count_stock_detail($id_product)
	{
		$this->db->select('*');
		$this->db->from($this->detail);
		$this->db->where('id_product', $id_product);
		$this->db->where('flag', '1');
		return $this->db->count_all_results();
	}

	public function show_stock_detail($id_product,$perpage,$offset)
	{
		$this->db->select('*');
		$this->db->from($this->detail);
		$this->db->where('id_product', $id_product);
		$this->db->where('flag', '1');
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function delete_stock_detail($id_pdetail)
	{
		$this->db->delete($this->detail, array('id_pdetail'=>$id_pdetail));
	}

	public function delete_allstock_detail($id_product)
	{
		$this->db->delete($this->detail, array('id_product'=>$id_product));
	}

	public function update_detail_stock($arr_data,$id_pdetail)
	{
		$this->db->where('id_pdetail', $id_pdetail);
		$this->db->update($this->detail, $arr_data);
	}

	public function barcode($kode)
	{
		if (my_level()==null) $id_lokasi = $this->session->userdata('id_lokasi');
		else $id_lokasi = my_location();

		if($id_lokasi==null) $id_lokasi = my_location();
		$id_lokasi = my_location();
		$this->db->select('a.*, b.id_lokasi');
		$this->db->from($this->detail.' a');
		$this->db->join($this->product.' b', 'a.id_product = b.id_product', 'left');
		$this->db->where('a.kode', $kode);
		$this->db->where('b.id_lokasi', $id_lokasi);
		return $this->db->get();

		// return $this->db->get_where($this->detail,array('kode'=>$kode));
	}

	public function update_stock($arr_data,$kode)
	{
		$this->db->where('kode', $kode);
		$this->db->update($this->detail, $arr_data);
	}

	public function stock_limit($id_product, $limit)
	{
		$this->db->select('*');
		$this->db->from($this->detail);
		$this->db->where('flag', '1');
		$this->db->where('id_product', $id_product);
		$this->db->order_by('id_pdetail', 'desc');
		$this->db->limit($limit);
		// $this->db->update($this->detail, array('flag'=> $flag));
		return $this->db->get();
	}
	public function stock_limit_update($id_pdetail)
	{
		$this->db->where('id_pdetail', $id_pdetail);
		$this->db->update($this->detail, array('flag'=> '0'));
	}
	public function stock_limit_retur($id_pdetail)
	{
		$this->db->where('id_pdetail', $id_pdetail);
		$this->db->update($this->detail, array('flag'=> '1'));
	}
	public function stock_detail($id_pdetail)
	{
		return $this->db->get_where($this->detail,array('id_pdetail'=>$id_pdetail));
	}

	public function expired($tgl_awal,$tgl_akhir)
	{
		$this->db->select('a.product, COUNT(a.id_product) AS expired');
		$this->db->from($this->product.' a');
		$this->db->join($this->detail.' b', 'a.id_product = b.id_product', 'left');
		$this->db->where("DATE(b.exp) <= '$tgl_akhir' ");
		$this->db->group_by('a.id_product');
		return $this->db->get();
	}

	public function expired_count($tgl_awal,$tgl_akhir)
	{
		$this->db->select('COUNT(a.id_product) AS total');
		$this->db->from($this->product.' a');
		$this->db->join($this->detail.' b', 'a.id_product = b.id_product', 'left');
		$this->db->where("DATE(b.exp) <= '$tgl_akhir' ");
		$this->db->group_by('a.id_product');
		return $this->db->get();
	}

	public function expired_detail($tgl_awal,$tgl_akhir)
	{
		$this->db->select('a.product, b.*');
		$this->db->from($this->product.' a');
		$this->db->join($this->detail.' b', 'a.id_product = b.id_product', 'left');
		$this->db->where("b.exp BETWEEN '$tgl_awal' AND '$tgl_akhir' ");
		return $this->db->get();
	}

	public function search($key)
	{
		$this->db->select('*');
		$this->db->from($this->detail);
		$this->db->where("product LIKE '%$key%' ESCAPE '!' OR
			msisdn LIKE '%$key%' ESCAPE '!' OR
			kode LIKE '%$key%' ESCAPE '!'");
		return $this->db->get();
	}
}