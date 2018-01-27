<?php 
/**
 * summary
 */
class M_laporan extends CI_Model
{
  /**
   * summary
   */
  public function __construct()
  {
    parent::__construct();
    $this->product = 'product';
    $this->transaksi = 'transaksi';
    $this->log_stock = 'log_stock';
    $this->grosir = 'transaksi_grosir';
  }

  public function show($id_lokasi, $tgl_awal, $tgl_akhir, $perpage, $offset)
	{
		$tanggal = '';
		if ($tgl_awal!='' && $tgl_akhir!='') {
      $tanggal = "WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
    }
    elseif ($tgl_awal=='' && $tgl_akhir!='') {
      $tanggal = "WHERE date(tanggal)='$tgl_akhir'";
    }
    elseif ($tgl_awal!='' && $tgl_akhir=='') {
      $tanggal = "WHERE date(tanggal)='$tgl_awal'";
    }
		$this->db->select('a.*, b.*');
		$this->db->from($this->product.' a');
    $this->db->join('(SELECT kode, harga_satuan, SUM(quantity_awal) AS qawal, SUM(quantity_tambah) AS qtambah, SUM(quantity_jual) AS qjual, SUM(harga_masuk) AS hmasuk, SUM(harga_keluar) AS hkeluar FROM '.$this->log_stock.' '.$tanggal.' GROUP BY kode, harga_satuan) b', 'a.kode = b.kode');
    if ($id_lokasi) $this->db->where('a.id_lokasi', $id_lokasi);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

  public function count($id_lokasi, $tgl_awal, $tgl_akhir)
  {
    $tanggal = '';
    if ($tgl_awal!='' && $tgl_akhir!='') {
      $tanggal = "WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
    }
    elseif ($tgl_awal=='' && $tgl_akhir!='') {
      $tanggal = "WHERE date(tanggal)='$tgl_akhir'";
    }
    elseif ($tgl_awal!='' && $tgl_akhir=='') {
      $tanggal = "WHERE date(tanggal)='$tgl_awal'";
    }
    $this->db->select('a.*, b.*');
    $this->db->from($this->product.' a');
    $this->db->join('(SELECT kode, harga_satuan, SUM(quantity_awal) AS qawal, SUM(quantity_tambah) AS qtambah, SUM(quantity_jual) AS qjual, SUM(harga_masuk) AS hmasuk, SUM(harga_keluar) AS hkeluar FROM '.$this->log_stock.' '.$tanggal.' GROUP BY kode, harga_satuan) b', 'a.kode = b.kode');
    if ($id_lokasi) $this->db->where('a.id_lokasi', $id_lokasi);
    return $this->db->count_all_results();
  }

  public function total_jual($id_lokasi, $tgl_awal, $tgl_akhir, $perpage, $offset)
  {
    $tanggal = '';
    if ($tgl_awal!='' && $tgl_akhir!='') {
      $tanggal = "WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
    }
    elseif ($tgl_awal=='' && $tgl_akhir!='') {
      $tanggal = "WHERE date(tanggal)='$tgl_akhir'";
    }
    elseif ($tgl_awal!='' && $tgl_akhir=='') {
      $tanggal = "WHERE date(tanggal)='$tgl_awal'";
    }
    $this->db->select('SUM(b.hkeluar) total_jual');
    $this->db->from($this->product.' a');
    $this->db->join('(SELECT kode, harga_satuan, SUM(quantity_awal) AS qawal, SUM(quantity_tambah) AS qtambah, SUM(quantity_jual) AS qjual, SUM(harga_masuk) AS hmasuk, SUM(harga_keluar) AS hkeluar FROM '.$this->log_stock.' '.$tanggal.' GROUP BY kode, harga_satuan) b', 'a.kode = b.kode');
    if ($id_lokasi) $this->db->where('a.id_lokasi', $id_lokasi);
    if ($perpage||$offset) $this->db->limit($perpage,$offset);
    $get = $this->db->get();
    return $get->row()->total_jual;
  }

  public function transaksi($id_lokasi, $id_user, $tgl_awal, $tgl_akhir, $perpage, $offset)
  {
    $this->db->select('*');
    $this->db->from($this->transaksi);
    if ($id_lokasi) $this->db->where('id_lokasi', $id_lokasi);
    if ($id_user) $this->db->where('id_user', $id_user);
    // if ($tgl_awal || $tgl_akhir) $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");

    if ($tgl_awal!='' && $tgl_akhir!='') {
      $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    }
    elseif ($tgl_awal=='' && $tgl_akhir!='') {
      $this->db->where("date(tanggal)='$tgl_akhir'");
    }
    elseif ($tgl_awal!='' && $tgl_akhir=='') {
      $this->db->where("date(tanggal)='$tgl_awal'");
    }

    if ($perpage||$offset) $this->db->limit($perpage,$offset);
    $this->db->order_by('tanggal', 'desc');
    return $this->db->get();
  }

  public function transcount($id_lokasi, $id_user, $tgl_awal, $tgl_akhir)
  {
    $this->db->select('id_faktur');
    $this->db->from($this->transaksi);
    if ($id_lokasi) $this->db->where('id_lokasi', $id_lokasi);
    if ($id_user) $this->db->where('id_user', $id_user);
    // if ($tgl_awal || $tgl_akhir) $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    if ($tgl_awal!='' && $tgl_akhir!='') {
      $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    }
    elseif ($tgl_awal=='' && $tgl_akhir!='') {
      $this->db->where("date(tanggal)='$tgl_akhir'");
    }
    elseif ($tgl_awal!='' && $tgl_akhir=='') {
      $this->db->where("date(tanggal)='$tgl_awal'");
    }

    return $this->db->count_all_results();
  }

  public function grosir($id_lokasi, $id_user, $tgl_awal, $tgl_akhir, $perpage, $offset)
  {
    $this->db->select('*');
    $this->db->from($this->grosir);
    if ($id_lokasi) $this->db->where('id_lokasi', $id_lokasi);
    if ($id_user) $this->db->where('id_user', $id_user);
    // if ($tgl_awal || $tgl_akhir) $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    if ($tgl_awal!='' && $tgl_akhir!='') {
      $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    }
    elseif ($tgl_awal=='' && $tgl_akhir!='') {
      $this->db->where("date(tanggal)='$tgl_akhir'");
    }
    elseif ($tgl_awal!='' && $tgl_akhir=='') {
      $this->db->where("date(tanggal)='$tgl_awal'");
    }

    if ($perpage||$offset) $this->db->limit($perpage,$offset);
    $this->db->order_by('tanggal', 'desc');
    return $this->db->get();
  }

  public function grosir_transcount($id_lokasi, $id_user, $tgl_awal, $tgl_akhir)
  {
    $this->db->select('id_faktur');
    $this->db->from($this->grosir);
    if ($id_lokasi) $this->db->where('id_lokasi', $id_lokasi);
    if ($id_user) $this->db->where('id_user', $id_user);
    // if ($tgl_awal || $tgl_akhir) $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    if ($tgl_awal!='' && $tgl_akhir!='') {
      $this->db->where("tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    }
    elseif ($tgl_awal=='' && $tgl_akhir!='') {
      $this->db->where("date(tanggal)='$tgl_akhir'");
    }
    elseif ($tgl_awal!='' && $tgl_akhir=='') {
      $this->db->where("date(tanggal)='$tgl_awal'");
    }

    return $this->db->count_all_results();
  }
}
?>