<?php
/**
* Model Users
*/
class M_users extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->user = 'users';
		$this->user_log = 'users_logs';
	}

	public function sigin($username,$password)
	{
		$this->db->select('*');
		$this->db->from($this->user);
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		// $this->db->where('status','1');
		return $this->db->get();
	}

	public function newid()
	{
		$this->db->select_max('id_user','max');
		$cek=$this->db->get($this->user);
		return $cek->row()->max+1;
	}

	function count()
	{
		$this->db->select('id_user');
		$this->db->from($this->user);
		return $this->db->count_all_results();
	}

	public function insert($arr_data)
	{
		$this->db->insert($this->user, $arr_data);
	}

	public function insert_batch($arr_data)
	{
		$this->db->insert_batch($this->user, $arr_data);
	}

	public function update($arr_data,$id_user)
	{
		$this->db->where('id_user', $id_user);
		$this->db->update($this->user, $arr_data);
	}

	public function show($nama, $perpage, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->user);
		$this->db->where('level !=', null);
		if ($nama) $this->db->like('nama', $nama);
		if ($perpage||$offset) $this->db->limit($perpage,$offset);
		return $this->db->get();
	}

	public function get($id_user)
	{
		return $this->db->get_where($this->user, array('id_user'=>$id_user));
	}

	public function delete($id_user)
	{
		$this->db->delete($this->user, array('id_user'=>$id_user));
	}

	public function log_insert($arr_data)
	{
		$this->db->insert($this->user_log, $arr_data);
	}

	public function log_delete($id_user)
	{
		$this->db->delete($this->user_log, array('id_user'=>$id_user));
	}

	public function log_status($id_user)
	{
		$this->db->select('*');
		$this->db->from($this->user_log.' t');
		$this->db->join('(select id_user, max(datetime) as MaxDate
    from '.$this->user_log.' group by id_user) tm', 't.id_user = tm.id_user and t.datetime = tm.MaxDate');
    return $this->db->get();
	}

	public function user_status($id_user)
	{
		$this->db->select('t.*');
		$this->db->from($this->user_log.' t');
		$this->db->join($this->user.' a', 'a.id_user = t.id_user');
		$this->db->join('(select id_user, max(datetime) as MaxDate
    from '.$this->user_log.' group by id_user) tm', 't.id_user = tm.id_user and t.datetime = tm.MaxDate');
    $this->db->where('t.status', 'online');
    $this->db->where("a.level = 'Admin' OR a.level = 'Seles'");
    return $this->db->get();
	}
}