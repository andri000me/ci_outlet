<?php
/**
* Controller provider
*/
class Provider extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if(!is_login()) redirect('signin');
		$this->load->model('M_provider');
	}

	public function index($param1=null, $param2=null, $param3=null)
	{
		$total_row=$this->M_provider->count();
		$perpage=15;
		$uri_segment=3;
		$offset=intval($this->uri->segment($uri_segment));
		$config['base_url']    = base_url().'provider/index/';
		$config['total_rows']  = $total_row;
		$config['per_page']    = $perpage;
		$config['uri_segment'] = $uri_segment;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';//'&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';//'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';//'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';//'&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();	
		$data['no']=$offset+1;
		$data['listdata'] = $this->M_provider->show(null, $perpage, $offset);
		$data['title'] = 'Provider';
		$data['subtitle'] = 'List Daftar provider';
		$data['br'] = '';
		$data['provider'] = 'class="active"';
		$data['js'] = 'provider/daftar';
		$data['page'] = 'provider/daftar';
		$this->load->view('page', $data);
	}

	public function tambah($param1=null, $param2=null, $param3=null)
	{
		if ($this->input->post('simpan')) {
			$this->form_validation->set_rules('kode', 'Kode', 'required');
			$this->form_validation->set_rules('provider', 'Nama provider', 'required');
			if ($this->form_validation->run()) {
				$arr_data['id_provider'] = $this->M_provider->newid();
				$variable = array('kode', 'provider', 'keterangan');
				foreach ($variable as $key) {
					$arr_data[$key] = $this->input->post($key);
				}
				$this->M_provider->insert($arr_data);
				$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.'));
				redirect('provider');
			}
		}
		elseif ($this->input->post('batal')) redirect('provider');
		$data['title'] = 'Provider';
		$data['subtitle'] = 'Tambah provider Baru';
		$data['br'] = array();
		$data['provider'] = 'class="active"';
		$data['page'] = 'provider/tambah';
		$this->load->view('page', $data);
	}

	public function ubah($param1=null, $param2=null, $param3=null)
	{
		$id_provider = decrypts($param1);
		if ($this->input->post('simpan')) {
			$this->form_validation->set_rules('kode', 'Kode', 'required');
			$this->form_validation->set_rules('provider', 'Nama provider', 'required');
			if ($this->form_validation->run()) {
				$variable = array('kode', 'provider', 'keterangan');
				foreach ($variable as $key) {
					$arr_data[$key] = $this->input->post($key);
				}
				$this->M_provider->update($arr_data, $id_provider);
				$this->session->set_flashdata('msg',msg_success('Data berhasil dirubah.'));
				redirect('provider');
			}
		}
		elseif ($this->input->post('batal')) redirect('provider');
		$data['listdata'] = $this->M_provider->get($id_provider);
		$data['title'] = 'Provider';
		$data['subtitle'] = 'Ubah Data provider';
		$data['br'] = array();
		$data['provider'] = 'class="active"';
		$data['page'] = 'provider/ubah';
		$this->load->view('page', $data);
	}

	public function detail($param1=null, $param2=null, $param3=null)
	{
		$id_provider = decrypts($param1);
		$data['listdata'] = $this->M_provider->get($id_provider);
		$data['title'] = 'Provider';
		$data['subtitle'] = 'Detail Data provider';
		$data['br'] = array();
		$data['provider'] = 'class="active"';
		$data['page'] = 'provider/detail';
		$this->load->view('page', $data);
	}

	public function hapus($param1=null, $param2=null, $param3=null)
	{
		$id_provider = decrypts($param1);
		$this->M_provider->delete($id_provider);
		$this->session->set_flashdata('msg',msg_success('Data berhasil dihapus.'));
		redirect('provider');
	}

	public function print()
	{
		$data['listdata'] = $this->M_provider->show(null, null, null);
		$this->load->view('provider/print', $data);
	}

	public function import()
	{
		$this->load->library('excel');
		if ($this->input->post('simpan')) {
			$file = $_FILES['userfile'];
			if (!empty($file)) {
				$name 	= $file['name'];
				$type 	= $file['type'];
				$size 	= $file['size'];
				$temp 	= $file['tmp_name'];
				$error 	= $file['error'];
				$ax = array(); $ax = explode('.', $file['name']);
				$ext = end($ax);
				if ($error > 0) {
					$this->session->set_flashdata('msg',msg_danger('Kesalahan upload.'));
					redirect('provider/import');
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
							$file_name = 'data_provider';
							$file_dir = url_encode('userdata/'.$file_name);
							if (!is_dir($file_dir)) mkdir($file_dir,0777,TRUE);
							if (get_files($file_dir.'/'.$file_name.'.*')==TRUE) array_map('unlink', glob($file_dir.'/'.$file_name.'.*'));
							if (move_uploaded_file($temp, "$file_dir/$file_name.$ext")) 
							{
								$this->file_rklrpl = array(
									'file_name' 	=> $file_name.'.'.$ext,
									'file_type' 	=> $file["type"],
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
										if (check_provider($value[0])==null) $arr_data[] = array('kode'=>$value[0], 'provider'=>$value[1], 'keterangan'=>$value[2]);
									}
								}
								if(count($arr_data)==null){
									$this->session->set_flashdata('msg',msg_warning('Data sudah diinput.'));
								}
								elseif (count($arr_data)>=1) {
									$this->session->set_flashdata('msg',msg_success('Data berhasil disimpan.<br>Beberapa data sudah ada, proses akan dilewati otomatis.'));
								}
								$this->M_provider->insert_batch($arr_data);
								redirect('provider');
							}
							else {
								$this->session->set_flashdata('msg',msg_danger('Gagal saat proses unggah.'));
								redirect('provider/import');
							}
						}
						else {
							$this->session->set_flashdata('msg',msg_danger('Format file tidak diijinkan.'));
							redirect('provider/import');
						}
					}
					else {
						$this->session->set_flashdata('msg',msg_danger('Extensi file tidak diijinkan.'));
						redirect('provider/import');
					}
				}
			}
		}
		elseif ($this->input->post('batal')) redirect('provider');
		$data['title'] = 'provider';
		$data['subtitle'] = 'Souvenir';
		$data['br'] = array();
		$data['js'] = 'provider/import';
		$data['provider'] = 'class="active"';
		$data['page'] = 'provider/import';
		$this->load->view('page', $data);
	}

	public function template()
	{
		$this->load->library('excel');
		$filename='template_provider.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('provider');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Kode');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('B1', 'Provider');
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->setCellValue('C1', 'Keterangan');
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getProperties()->setCreator("4171");
		$this->excel->getProperties()->setLastModifiedBy("4171");
		$this->excel->getProperties()->setTitle($filename);
		$this->excel->getProperties()->setSubject("Report Data provider");
		$this->excel->getProperties()->setDescription(base_url());
		$this->excel->getProperties()->setCategory("Report");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function export()
	{
		$no = 1;$i = 2;
		$listdata = $this->M_provider->show(null, null, null);
		if ($listdata->result()) {
			$this->load->library('excel');
			$filename='data_provider.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('provider');
			$this->excel->getActiveSheet()->setCellValue('A1', 'No');
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setCellValue('B1', 'Kode');
			$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setCellValue('C1', 'Provider');
			$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->setCellValue('D1', 'Keterangan');
			$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			foreach ($listdata->result() as $key) {
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $key->kode);
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $key->provider);
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $key->keterangan);
				$no++;
				$i++;
			}

			$this->excel->getProperties()->setCreator("4171");
			$this->excel->getProperties()->setLastModifiedBy("4171");
			$this->excel->getProperties()->setTitle($filename);
			$this->excel->getProperties()->setSubject("Report Data Provider");
			$this->excel->getProperties()->setDescription(base_url());
			$this->excel->getProperties()->setCategory("Report");

			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}
		else {
			$this->session->set_flashdata('msg',msg_warning('Data kosong.'));
			redirect('provider');
		}
	}
}