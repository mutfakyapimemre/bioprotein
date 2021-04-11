<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class General_model extends CI_Model{
	public $tableName = null;
	public function __construct(){
		parent::__construct();
    }
    /**
     * @param string // Tablo Adı
	 * @param array // Where Parametreleri key => value
	 * @param array // Tablo Adı:tabloadı Eşleşeceği ID: c.1tabloid=p.2tabloid Eşleşme Tipi : Left  
	 */
	public function get($tableName = null,$select = null,$where = [],$joinTable=[])
	{
		if(!empty($joinTable)){
			foreach($joinTable as $key => $value){
				$this->db->join($key,$value[0],$value[1]);
			}
		}
		if(!empty($select)){
			$this->db->select($select);
		}
		return $this->db->where($where)->get($tableName)->row();
	}

	public function get_all($tableName = null,$select = null,$order = null,$where = [],  $likes = [],$joinTable=[],$limit=[])
    {	
		if(!empty($joinTable)){
			foreach($joinTable as $key => $value){
				$this->db->join($key,$value[0],$value[1]);
			}
		}
		if(!empty($select)){
			$this->db->select($select);
		}
		if(!empty($likes)){
			$i = 0;
			foreach($likes as $key => $value):
				$this->db->group_start();
				if($i == 0):
					$this->db->like($key,$value,'both');
					$this->db->or_like($key, strto("lower",$value), 'both');
                    $this->db->or_like($key, strto("lower|upper",$value), 'both');
                    $this->db->or_like($key, strto("lower|ucwords",$value), 'both');
                    $this->db->or_like($key, strto("lower|capitalizefirst",$value), 'both');
                    $this->db->or_like($key, strto("lower|ucfirst",$value), 'both');
				else:
					$this->db->or_like($key,$value,'both');
					$this->db->or_like($key, strto("lower",$value), 'both');
                    $this->db->or_like($key, strto("lower|upper",$value), 'both');
                    $this->db->or_like($key, strto("lower|ucwords",$value), 'both');
                    $this->db->or_like($key, strto("lower|capitalizefirst",$value), 'both');
                    $this->db->or_like($key, strto("lower|ucfirst",$value), 'both');
				endif;
				$this->db->group_end();
				$i++;
			endforeach;
		}
		if(!empty($limit)){
			if(!empty($limit[1])){
				$this->db->limit($limit[0],$limit[1]);
			}
			else{
				$this->db->limit($limit[0]);
			}
		}
        return $this->db->where($where)->order_by($order)->get($tableName)->result();
    }

	public function add($tableName = null,$data = array())
	{
		$this->db->insert($tableName, $data);
		return $this->db->insert_id();
	}
	
	public function update($tableName = null,$where = [], $data = array())
	{
		return $this->db->where($where)->update($tableName, $data);
	}

	public function delete($tableName = null,$where = [])
	{
		return $this->db->where($where)->delete($tableName);
	}

	public function rowCount($tableName = null,$where = [])
    {
        return $this->db->where($where)->count_all_results($tableName);
	}
}