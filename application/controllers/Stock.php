<?php
/**
* Controller stock
*/
class stock extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_log_stock');
		$this->load->model('M_product');
		$this->load->model('M_stock');
		$this->load->model('M_supplier');
		$this->load->model('M_provider');
		$this->load->model('M_lokasi');
		$this->load->model('M_jenis');
		$this->load->model('M_barang');
	}

	public function index($param1=null, $param2=null, $param3=null)
	{
		$data['listdata'] = $this->M_stock->show(null, null, null);
		$data['title'] = 'Fashion';
		$data['subtitle'] = 'stock';
		$data['br'] = '';
		$data['stock'] = 'class="active"';
		$data['js'] = 'stock/daftar';
		$data['page'] = 'stock/daftar';
		$this->load->view('page', $data);
	}

	public function hapus($param1=null, $param2=null, $param3=null)
	{
		$id = decrypts($param1);
		$this->M_stock->delete($id);
		$this->session->set_flashdata('msg',msg_success('Data berhasil dihapus.'));
		redirect('stock');
	}

	public function check_data()
	{
		$kode = $this->input->post('param_kode');
		$quantitys = $this->input->post('param_quantity');
		if ($quantitys) $quantity = $quantitys;
		else $quantity = 1;
		
		if ($kode) {
			$getproduct = $this->M_product->get_detail($kode);
			if ($getproduct->result()) {
				$checkstock = $this->M_stock->cek_kode($kode);
				if ($checkstock->result()) {
					$qtt = $checkstock->row()->quantity + $quantity;
					$arr_data['quantity'] = $qtt;
					$this->M_stock->update($arr_data, $kode);
					echo json_encode('get');
				}
				else {
					$arr_data = array(
						'kode' => $getproduct->row()->kode,
						'id_user' => my_userid(),
						'id_supplier' => $getproduct->row()->id_supplier,
						'id_provider' => $getproduct->row()->id_provider,
						'id_lokasi' => $getproduct->row()->id_lokasi,
						'id_jenis' => $getproduct->row()->id_jenis,
						'id_barang' => $getproduct->row()->id_barang,
						'product' => $getproduct->row()->product,
						'quantity' => $quantity
					);
					$this->M_stock->insert($arr_data);
					echo json_encode('get');
				}
			}
			else {
				echo json_encode(null);
			}
		}
		else {
			echo json_encode(null);
		}
	}

	public function verifikasi()
	{
		$gettemp = $this->M_stock->show(my_userid(), null, null);
		$arr_data = array();
		if ($gettemp->result()) {
			foreach ($gettemp->result() as $key) {
				$arr_data[] = array(
					'kode' => $key->kode,
					'id_supplier' => $key->id_supplier,
					'id_provider' => $key->id_provider,
					'id_lokasi' => $key->id_lokasi,
					'id_jenis' => $key->id_jenis,
					'id_barang' => $key->id_barang,
					'quantity' => $key->quantity
				);
			}
			
			foreach ($arr_data as $value) {
				if ($value['kode']==get_kodestock($value['kode'])) {
					$qty_n = get_stockproduct($value['kode']) + $value['quantity'];
					$getproduct = $this->M_product->get_detail($value['kode']);
					if($getproduct->row()->quantity==null) $qty_o = 0;
					else $qty_o = $getproduct->row()->quantity;
					$qty_t = $qty_n - $qty_o;
					$qty_j = 0;
					$harga_masuk = $getproduct->row()->harga_akhir * $qty_t;
					$harga_jual = $getproduct->row()->harga_jual * $qty_j;

					$arr_stock['kode'] = $getproduct->row()->kode;
					$arr_stock['tanggal'] = date("Y-m-d H:i:s");
					$arr_stock['id_supplier'] = $getproduct->row()->id_supplier;
					$arr_stock['id_provider'] = $getproduct->row()->id_provider;
					$arr_stock['id_lokasi'] = $getproduct->row()->id_lokasi;
					$arr_stock['id_jenis'] = $getproduct->row()->id_jenis;
					$arr_stock['id_barang'] = $getproduct->row()->id_barang;
					$arr_stock['product'] = $getproduct->row()->product;
					$arr_stock['quantity_awal'] = $qty_o;
					$arr_stock['quantity_akhir'] = $qty_n;
					$arr_stock['quantity_tambah'] = $qty_t;
					$arr_stock['quantity_jual'] = $qty_j;
					$arr_stock['harga_masuk'] = $harga_masuk;
					$arr_stock['harga_jual'] = $harga_jual;

					$this->M_log_stock->insert($arr_stock);
					$this->M_product->updatestock($value['kode'], $qty_n);
					$this->M_stock->delete($value['kode']);
				}
			}
		}
		$this->session->set_flashdata('msg',msg_success('Stock berhasil diperbarui.'));
		redirect('stock');
	}

	public function import()
	{
		$this->load->library('excel');
		if ($this->input->post('simpan')) {
			$file = $_FILES['userfile'];
			if (!empty($file)) {
				$name 	= $file['name'];
				$jenis 	= $file['jenis'];
				$size 	= $file['size'];
				$temp 	= $file['tmp_name'];
				$error 	= $file['error'];
				$ax = array(); $ax = explode('.', $file['name']);
				$ext = end($ax);
				if ($error > 0) {
					$this->session->set_flashdata('msg',msg_danger('Kesalahan upload.'));
					redirect('stock/import');
				}
				else {
					if($ext=='xls' || $ext=='xlsx' || $ext=='csv') 
					{
						$mime = get_mime_by_extension($name);
						if (
							$mime=='application/vnd.ms-excel' ||
							$mime=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
							$mime=='text/csv'
						)
						{
							$file_name = 'data_stock';
							$file_dir = url_encode('userdata/'.$file_name);
							if (!is_dir($file_dir)) mkdir($file_dir,0777,TRUE);
							if (get_files($file_dir.'/'.$file_name.'.*')==TRUE) array_map('unlink', glob($file_dir.'/'.$file_name.'.*'));
							if (move_uploaded_file($temp, "$file_dir/$file_name.$ext")) 
							{
								$this->file_rklrpl = array(
									'file_name' 	=> $file_name.'.'.$ext,
									'file_jenis' 	=> $file["jenis"],
									'file_size' 	=> $file["size"],
									'file_temp' 	=> $file["tmp_name"],
									'error' 			=> $file["error"],
									'file_dir' 		=> $file_dir,
									'full_path' 	=> $file_dir.'/'.$file_name.'.'.$ext
								);

								$objLoad = PHPExcel_IOFactory::load($file_dir.'/'.$file_name.'.'.$ext);
								$dataArr = array();
								foreach ($objLoad->getWorksheetIterator() as $worksheet) {
									$worksheetTitle     = $worksheet->getTitle();
									$highestRow         = $worksheet->getHighestRow(); // e.g. 10
									$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
									$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

									for ($row = 2; $row <= $highestRow; ++ $row) {
										for ($col = 0; $col < $highestColumnIndex; ++ $col) {
										  $cell = $worksheet->getCellByColumnAndRow($col, $row);
										  $val = $cell->getValue();
										  $dataArr[$row][$col] = $val;
										}
									}
								}
								$arr_data = array();
								foreach ($dataArr as $key => $value) {
									if ($value[0]!=null) {
										if (check_stock($value[0])==null) $arr_data[] = array(
											'id_supplier'=>$value[0],
											'id_jenis'=>$value[1],
											'id_provider'=>$value[2],
											'id_lokasi'=>$value[3],
											'id_size'=>$value[4],
											'kode'=>$value[5],
											'stock'=>$value[6],
											'harga_beli'=>$value[7],
											'harga_jual'=>$value[8]);
									}
								}
								if(count($arr_data)==null){
									$this->session->set_flashdata('msg',msg_warning('Data sudah diinput.'));
								}
								elseif (count($arr_data)>=1) {
									$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.<br>Beberapa data sudah ada, proses akan dilewati otomatis.'));
								}
								$this->M_stock->insert_batch($arr_data);
								redirect('stock');
							}
							else {
								$this->session->set_flashdata('msg',msg_danger('Gagal saat proses unggah.'));
								redirect('stock/import');
							}
						}
						else {
							$this->session->set_flashdata('msg',msg_danger('Format file tidak diijinkan.'));
							redirect('stock/import');
						}
					}
					else {
						$this->session->set_flashdata('msg',msg_danger('Extensi file tidak diijinkan.'));
						redirect('stock/import');
					}
				}
			}
		}
		elseif ($this->input->post('batal')) redirect('stock');
		$data['title'] = 'Fashion';
		$data['subtitle'] = 'stock';
		$data['br'] = array();
		$data['js'] = 'stock/import';
		$data['stock'] = 'class="active"';
		$data['page'] = 'stock/import';
		$this->load->view('page', $data);
	}

	public function template()
	{
		$this->load->library('excel');
		$filename='template_stock.xls'; //save our workbook as this file name
		header('Content-jenis: application/vnd.ms-excel'); //mime jenis
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('stock');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Kode Supplier');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('B1', 'Kode jenis');
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('C1', 'Kode provider');
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('D1', 'Kode lokasi');
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('E1', 'Kode Size');
		$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('F1', 'Harga Beli');
		$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('G1', 'Harga Jual');
		$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getProperties()->setCreator("Dolan");
		$this->excel->getProperties()->setLastModifiedBy("Dolan");
		$this->excel->getProperties()->setTitle($filename);
		$this->excel->getProperties()->setSubject("Report Data Fashion stock");
		$this->excel->getProperties()->setDescription(base_url());
		$this->excel->getProperties()->setCategory("Report");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}