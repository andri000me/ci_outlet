<?php
/*----------  Encription  ----------*/
function encrypts($value=NULL)
{
	$app=& get_instance();
	if ($value==NULL) {
		return FALSE;
	}
	else return $app->crypto->encode($value);
}
function decrypts($value=NULL)
{
	$app=& get_instance();
	if ($value==NULL) {
		return FALSE;
	}
	else return $app->crypto->decode($value);
}
/*----------  End of Encription  ----------*/


/*----------  Function URL Encode Decode  ----------*/
function url_encode($str)
{
	$replace = array("!" => "%21", "*" => "%2A", "'" => "%27", "(" => "%28", ")" => "%29", ";" => "%3B", ":" => "%3A", "@" => "%40", "&" => "%26", "=" => "%3D", "+" => "%2B", "$" => "%24", "," => "%2C", "?" => "%3F", "%" => "%25", "#" => "%23", "[" => "%5B", "]" => "%5D", " " => "-");
	$value = str_replace(array_keys($replace), array_values($replace), strtolower($str));
	return preg_replace('/([^:])(\/{2,})/', '$1/', $value);
}

function url_decode($str)
{
	$replace = array("%21" => "!", "%2A" => "*", "%27" => "'", "%28" => "(", "%29" => ")", "%3B" => ";", "%3A" => ":", "%40" => "@", "%26" => "&", "%3D" => "=", "%2B" => "+", "%24" => "$", "%2C" => ",", "%2F" => "/", "%3F" => "?", "%25" => "%", "%23" => "#", "%5B" => "[", "%5D" => "]", "-" => " ");
	$value = str_replace(array_keys($replace), array_values($replace), strtolower($str));
	return preg_replace('/([^:])(\/{2,})/', '$1/', $value);
}

function spacer($str)
{
	$replace = array(" " => "-");
	return str_replace(array_keys($replace), array_values($replace), strtolower($str));
}
/*----------  End of Function URL Encode Decode  ----------*/


/*----------  Function Get File Attribute  ----------*/
function get_files($value=NULL,$result=FALSE)
{
	$variable = glob($value);
	$value = array();
	foreach ($variable as $key) {
		if (is_file($key)) {
			$key = new SplFileInfo($key);
			$value[]= array(
				'base_name' => $key->getBasename('.'.$key->getExtension()),
				'file_name' => $key->getFilename(),
				'file_ext' => $key->getExtension(),
				'file_size' => $key->getSize(),
				'file_mime' => mime_content_type($key->getPathname()),
				'date_mod'  => date("Y-m-d H:i:s.u", $key->getMTime()),
				'full_path' => $key->getPathname()
			);
		}
	}
	if ($result==TRUE) {
		return $value;
	}
	else {
		if ($value!=NULL) {
			return TRUE;
		}
		else return FALSE;
	}
}

function set()
{
	$arr = array();
	$app =& get_instance();
	$app->load->model('M_setting');
	$get = $app->M_setting->show();
	if ($get->result()) {
		$arr['nama'] = $get->row()->nama;
		$arr['logo'] = $get->row()->logo;
		$arr['alamat'] = $get->row()->alamat;
		$arr['telp'] = $get->row()->telp;
		$arr['pin'] = $get->row()->pin;
		$arr['ig'] = $get->row()->ig;
		$arr['keterangan'] = $get->row()->keterangan;
		$arr['tips'] = $get->row()->tips;
	}
	return $arr;
}

function expired()
{
	$tgl_awal = date('Y-m-d');
	$e = explode('-', date('Y-m-d'));
  $d = $e[2]+2;
  $tgl_akhir = "$e[0]-$e[1]-$d";
  $arr = array();
  $app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->expired($tgl_awal,$tgl_akhir);
	if ($get->result()) {
		foreach ($get->result() as $var) {
			$arr[] = array(
				'product'=>$var->product,
				'expired'=>$var->expired
			);
		}
	}
  return $arr;
}

function expired_count()
{
	$arr = array();
	$tgl_awal = date('Y-m-d');
	$e = explode('-', date('Y-m-d'));
  $d = $e[2]+2;
  $tgl_akhir = "$e[0]-$e[1]-$d";
  $arr = array();
  $app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->expired_count($tgl_awal,$tgl_akhir);
	if ($get->result()) {
		foreach ($get->result() as $val) {
			$arr[]= $val->total;
		}
		return $arr;
	}
	else return $arr;
}

/*----------  End of Function Get File Attribute  ----------*/

function format_harga_rp($harga)
{
  $harga    = number_format($harga); //menggalihan format harga pada curency  
  $harga     = /*"Rp.".*/str_replace(",",".",$harga).""; // mengganti koma dengan titik
  return $harga;
}

function get_idproduct($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->get_detail($value);
	if ($get->result()) {
		return $get->row()->id_product;
	}
	else {
		return null;
	}
}

function get_idstock($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->barcode($value);
	if ($get->result()) {
		return $get->row()->id_pdetail;
	}
	else {
		return null;
	}
}

function get_stockproduct($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->cek_kode($value);
	if ($get->result()) {
		return $get->row()->quantity;
	}
	else {
		return null;
	}
}

function get_kodeproduct($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->get($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function get_kdsupplier($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_supplier');
	$get = $app->M_supplier->get($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function get_kdjenis($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_jenis');
	$get = $app->M_jenis->get($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function get_kdlokasi($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_lokasi');
	$get = $app->M_lokasi->get($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function get_kdprovider($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_provider');
	$get = $app->M_provider->get($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function get_kdproduct($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->get($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function get_kdbarang($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_barang');
	$get = $app->M_barang->get($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function get_fakturitem($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_penjualan');
	$get = $app->M_penjualan->get($value);
	if ($get->result()) {
		return $get->row()->no_faktur;
	}
	else {
		return null;
	}
}

function get_fakturgrosir($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_penjualan');
	$get = $app->M_penjualan->get_transaksigrosir($value, null);
	if ($get->result()) {
		return $get->row()->no_faktur;
	}
	else {
		return null;
	}
}

function product_name($id_jenis=null,$id_provider=null,$id_barang=null)
{
	$app =& get_instance();
	$app->load->model('M_jenis');
	$app->load->model('M_provider');
	$app->load->model('M_barang');

	$d = $app->M_jenis->get($id_jenis);
	if($d->result()) $jenis = $d->row()->jenis;
	else $jenis = '';

	$t = $app->M_provider->get($id_provider);
	if($t->result()) $provider = $t->row()->provider;
	else $provider = '';
	
	$w = $app->M_barang->get($id_barang);
	if($w->result()) $barang = $w->row()->barang;
	else $barang = '';

	return $jenis.' '.$provider.' '.$barang;
}
function product($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->get($value);
	if ($get->result()) {
		return $get->row()->product;
	}
	else return null;
}

function harga($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->get($value);
	if ($get->result()) {
		return $get->row()->harga_jual;
	}
	else return null;
}

function stocklimit()
{
	$app =& get_instance();
	$app->load->model('M_Stock');
	$get = $app->M_Stock->stocklimit();
	if ($get->result()) {
		foreach ($get->result() as $key) {
			$arr[] = array(
				'quantity' => $key->quantity,
				'kode' => $key->kode,
				'product' => $key->product,
				'provider' => $key->provider,
				'supplier' => $key->supplier,
				'jenis' => $key->jenis,
				'lokasi' => $key->lokasi
			);
		}
		return $arr;
	}
}

function stock($a=null)
{
	$app =& get_instance();
	$app->load->model('M_product');
	if ($a) {
		$get = $app->M_product->stock($a);
		if ($get==null) {
			$get2 = $app->M_product->count_stock_detail($a);
			if ($get2==null) {
				return '0';
			}
			else return $get2;
		}
		else return $get;
	}
	else return '0';
}

function stock_kodeproduct($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$pdetail = $app->M_product->barcode($value);
	if ($pdetail->result()) {
		$id_product = $pdetail->row()->id_product;
		$get = $app->M_product->get($id_product);
		if ($get->result()) {
			return $get->row()->kode;
		}
	}
	else {
		return null;
	}
}

function stock_kodestock($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->stock_detail($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function generate_barcode($code=null)
{
	$app =& get_instance();
	$app->zend->load('Zend/Barcode');

	$barcodeOptions = array('text' => $code);
	$rendererOptions = array();
	$imageResource = Zend_Barcode::factory('Code128', 'image', $barcodeOptions, $rendererOptions)->draw();
  ob_start();
  imagejpeg($imageResource);
  $contents = ob_get_contents();
  ob_end_clean();
	return base64_encode($contents);
}

function productstock_awal($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_Stock');
	$get = $app->M_Stock->cek_kode($value);
	if ($get->result()) {
		return $get->row()->quantity;
	}
	else {
		return null;
	}
}

function check_barcode($value=null)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->barcode($value);
	if ($get->result()) {
		return $get->row()->flag;
	}
	else return 3;
}

function check_kodeproduct($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->cek_kode($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function check_jenis($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_jenis');
	$get = $app->M_jenis->cek_kode($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function check_lokasi($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_lokasi');
	$get = $app->M_lokasi->cek_kode($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function check_provider($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_provider');
	$get = $app->M_provider->cek_kode($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function check_product($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_product');
	$get = $app->M_product->cek_kode($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function check_barang($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_barang');
	$get = $app->M_barang->cek_kode($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function check_supplier($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_supplier');
	$get = $app->M_supplier->cek_kode($value);
	if ($get->result()) {
		return $get->row()->kode;
	}
	else {
		return null;
	}
}

function check_fakturitem($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_penjualan');
	$get = $app->M_penjualan->get_transaksiitem(null,$value);
	if ($get->result()) {
		return $get->row()->no_faktur;
	}
	else {
		return null;
	}
}

function check_fakturgrosir($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_penjualan');
	$get = $app->M_penjualan->get_transaksigrosir(null,$value);
	if ($get->result()) {
		return $get->row()->no_faktur;
	}
	else {
		return null;
	}
}

function check_returitem($value=NULL)
{
	$app =& get_instance();
	$app->load->model('M_retur');
	$get = $app->M_retur->cek_kode($value);
	if ($get->result()) {
		return $get->row()->no_faktur;
	}
	else {
		return null;
	}
}

function get_ip()
{
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
  else if(isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}
/*----------  End of Function Get IP  ----------*/


function keyup($string=FALSE)
{
	return md5(sha1('hellhathnofury $%@hackyourH32d'.$string.'232399sdfsdfklj93049'));
}

function get_lokasi($value=null)
{
	$app=& get_instance();
	$app->load->model('M_lokasi');
	$get = $app->M_lokasi->get($value);
	if ($get->result()) {
		return $get->row()->lokasi;
	}
	else {
		return null;
	}
}

function get_username($value=null)
{
	$app=& get_instance();
	$app->load->model('M_users');
	$get = $app->M_users->get($value);
	if ($get->result()) {
		return $get->row()->username;
	}
	else {
		return null;
	}
}

function get_name_of_user($value=null)
{
	$app=& get_instance();
	$app->load->model('M_users');
	$get = $app->M_users->get($value);
	if ($get->result()) {
		return $get->row()->nama;
	}
	else {
		return null;
	}
}

function is_login()
{		
	$app=& get_instance();
	$user_data=$app->session->userdata('user_data');
	if($user_data==NULL) return FALSE;		
	else return TRUE;
}

function user_name()
{
	$app=& get_instance();
	$val = $app->session->userdata('user_data');
	return $val['nama'];
}

function my_username()
{
	$app=& get_instance();
	$val = $app->session->userdata('user_data');
	return $val['username'];
}

function my_level()
{
	$app=& get_instance();
	$val = $app->session->userdata('user_data');
	return $val['level'];
}

function my_status()
{
	$app=& get_instance();
	$val = $app->session->userdata('user_data');
	return $val['status'];
}

function my_userid()
{
	$app=& get_instance();
	$val = $app->session->userdata('user_data');
	return $val['id'];
}

function my_photo()
{
	$app=& get_instance();
	$val = $app->session->userdata('user_data');
	return $val['photo'];
}

function my_location()
{
	$app=& get_instance();
	$val = $app->session->userdata('user_data');
	return $val['lokasi'];
}

/*----------  Function Alert Message  ----------*/
function msg_danger($value=NULL)
{
	if(empty($value)) return FALSE;
	return '<div class="alert alert-dismissible alert-danger animated slideInX">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Danger!</b><br> '.$value.'
		</div>';
}
function msg_warning($value=NULL)
{
	if(empty($value)) return FALSE;
	return '<div class="alert alert-dismissible alert-warning animated slideInX">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Warning!</b><br> '.$value.'
		</div>';
}
function msg_info($value=NULL)
{
	if(empty($value)) return FALSE;
	return '<div class="alert alert-dismissible alert-info animated slideInX">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Info!</b><br> '.$value.'
		</div>';
}
function msg_primary($value=NULL)
{
	if(empty($value)) return FALSE;
	return '<div class="alert alert-dismissible alert-primary animated slideInX">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		'.$value.'
		</div>';
}
function msg_success($value=NULL)
{
	if(empty($value)) $value = 'Data berhasil di proses.';
	return '<div class="alert alert-dismissible alert-success animated slideInX">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<b>Success!</b><br> '.$value.'
		</div>';
}
/*----------  End of Function Alert Message  ----------*/
?>