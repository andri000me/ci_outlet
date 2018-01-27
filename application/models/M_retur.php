<?php
/**
 * summary
 */
class M_retur extends CI_Model
{
  /**
   * summary
   */
  public function __construct()
  {
    parent::__construct();
		$this->retur = 'retur';
    $this->retur_temp = 'retur_tmp';
    $this->transaksi = 'transaksi';
    $this->transaksi_grosir = 'transaksi_grosir';
    $this->transaksi_grosir_detail = 'transaksi_grosir_detail';
  }

  public function newid()
  {
    $this->db->select_max('id_retur','max');
    $cek=$this->db->get($this->retur);
    return $cek->row()->max+1;
  }

  function count($id_lokasi, $id_user, $tgl_awal, $tgl_akhir)
  {
    $tanggal = "tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
    $this->db->select('id_retur');
    $this->db->from($this->retur);
    if ($id_lokasi) $this->db->where('id_lokasi', $id_lokasi);
    if ($id_user) $this->db->where('id_user', $id_user);
    if ($tgl_awal || $tgl_akhir) $this->db->where($tanggal);
    return $this->db->count_all_results();
  }

  public function insert($arr_data)
  {
    $this->db->insert($this->retur, $arr_data);
  }

  public function insert_batch($arr_data)
  {
    $this->db->insert_batch($this->retur, $arr_data);
  }

  public function update($arr_data,$id_retur)
  {
    $this->db->where('id_retur', $id_retur);
    $this->db->update($this->retur, $arr_data);
  }

  public function cek_kode($no_faktur)
  {
    return $this->db->get_where($this->retur, array('no_faktur'=>$no_faktur));
  }

  public function show($id_lokasi, $id_user, $tgl_awal, $tgl_akhir)
  {
    $tanggal = "tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
    $this->db->select('*');
    $this->db->from($this->retur);
    if ($id_lokasi) $this->db->where('id_lokasi', $id_lokasi);
    if ($id_user) $this->db->where('id_user', $id_user);
    if ($tgl_awal || $tgl_akhir) $this->db->where($tanggal);
    return $this->db->get();;
  }

  public function grosir_retur_tmp($kode_stock)
  {
    $this->db->select('a.*, b.*');
    $this->db->from($this->transaksi_grosir_detail.' a');
    $this->db->join($this->transaksi_grosir.' b', 'a.id_faktur = b.id_faktur', 'left');
    if ($kode_stock) $this->db->where('a.kode_stock', $kode_stock);
    return $this->db->get();
  }

  public function insert_temp($arr_data)
  {
    $this->db->insert($this->retur_temp, $arr_data);
  }

  public function show_temp($no_faktur)
  {
    $this->db->select('*');
    $this->db->from($this->retur_temp);
    if ($no_faktur) $this->db->where('no_faktur', $no_faktur);
    return $this->db->get();
  }

  public function getstock_temp($kode_stock)
  {
    $this->db->select('*');
    $this->db->from($this->retur_temp);
    if ($kode_stock) $this->db->where('kode_stock', $kode_stock);
    return $this->db->get();
  }

  public function delete_temp($no_faktur)
  {
    $this->db->delete($this->retur_temp,array('no_faktur'=>$no_faktur));
  }

  public function delete_item_temp($kode_stock)
  {
    $this->db->delete($this->retur_temp,array('kode_stock'=>$kode_stock));
  }
}
?>