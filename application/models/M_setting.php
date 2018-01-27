<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_setting extends CI_Model {
		
	function __construct()
	{
		parent::__construct();
		$this->setting = 'setting';
	}

	public function insert($array)
	{
		$this->db->insert($this->setting, $array);
	}

	public function update($array)
	{
		$this->db->where('id', 1);
		$this->db->update($this->setting, $array);
	}

	public function show()
	{
		return $this->db->get_where($this->setting, array('id'=>1));
	}
}

/* End of file M_setting.php */
/* Location: ./application/models/M_setting.php */