<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{
	public $tableName = null;
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * @param string // Tablo Adı
	 * @param array // Where Parametreleri key => value
	 * @param array // Tablo Adı:tabloadı Eşleşeceği ID: c.1tabloid=p.2tabloid Eşleşme Tipi : Left  
	 */
	public function get($tableName = null, $select = null, $where = [], $joinTable = [], $likes = [])
	{
		if (!empty($joinTable)) :
			foreach ($joinTable as $key => $value) :
				$this->db->join($key, $value[0], $value[1]);
			endforeach;
		endif;
		if (!empty($select)) :
			$this->db->select($select);
		endif;
		if (!empty($likes)) :
			$i = 0;
			foreach ($likes as $key => $value) :
				// first loop
				if ($i === 0) :
					// open bracket
					$this->db->group_start();
					$this->db->like($key, $value, 'both');
					$this->db->or_like($key, strto("lower", $value), 'both');
					$this->db->or_like($key, strto("lower|upper", $value), 'both');
					$this->db->or_like($key, strto("lower|ucwords", $value), 'both');
					$this->db->or_like($key, strto("lower|capitalizefirst", $value), 'both');
					$this->db->or_like($key, strto("lower|ucfirst", $value), 'both');
				else :
					$this->db->or_like($key, $value, 'both');
					$this->db->or_like($key, strto("lower", $value), 'both');
					$this->db->or_like($key, strto("lower|upper", $value), 'both');
					$this->db->or_like($key, strto("lower|ucwords", $value), 'both');
					$this->db->or_like($key, strto("lower|capitalizefirst", $value), 'both');
					$this->db->or_like($key, strto("lower|ucfirst", $value), 'both');
				endif;

				// last loop
				if (count($likes) - 1 == $i) :
					// close bracket
					$this->db->group_end();
				endif;
				$i++;
			endforeach;
		endif;
		return $this->db->where($where)->get($tableName)->row();
	}

	public function get_all($tableName = null, $select = null, $order = null, $where = [],  $likes = [], $joinTable = [], $limit = [], $wherein = [])
	{
		if (!empty($select)) :
			$this->db->select($select);
		endif;
		if (!empty($joinTable)) :
			foreach ($joinTable as $key => $value) :
				$this->db->join($key, $value[0], $value[1]);
			endforeach;
		endif;
		$this->db->where(["id!=" => null]);
		$this->db->where($where);
		if (!empty($wherein)) :
			foreach ($wherein as $key => $value) :
				$this->db->where_in($key, $value);
			endforeach;
		endif;
		if (!empty($likes)) :
			$i = 0;
			$j = 0;
			foreach ($likes as $key => $value) :
				if (!is_array($value)) :
					// first loop
					if ($i === 0) :
						// open bracket
						$this->db->group_start();
						$this->db->like($key, $value, 'both');
						$this->db->or_like($key, strto("lower", $value), 'both');
						$this->db->or_like($key, strto("lower|upper", $value), 'both');
						$this->db->or_like($key, strto("lower|ucwords", $value), 'both');
						$this->db->or_like($key, strto("lower|capitalizefirst", $value), 'both');
						$this->db->or_like($key, strto("lower|ucfirst", $value), 'both');
					else :
						$this->db->or_like($key, $value, 'both');
						$this->db->or_like($key, strto("lower", $value), 'both');
						$this->db->or_like($key, strto("lower|upper", $value), 'both');
						$this->db->or_like($key, strto("lower|ucwords", $value), 'both');
						$this->db->or_like($key, strto("lower|capitalizefirst", $value), 'both');
						$this->db->or_like($key, strto("lower|ucfirst", $value), 'both');
					endif;

					// last loop
					if (count($likes) - 1 == $i) :
						// close bracket
						$this->db->group_end();
					endif;
					$i++;
				else :
					// first loop
					if ($i === 0) :
						// open bracket
						$this->db->group_start();
					endif;
					foreach ($value as $k => $v) :
						foreach ($v as $kk => $vv) :
							// first loop
							if ($j === 0) :

								$this->db->like($kk, $vv, 'both');
								$this->db->or_like($kk, strto("lower", $vv), 'both');
								$this->db->or_like($kk, strto("lower|upper", $vv), 'both');
								$this->db->or_like($kk, strto("lower|ucwords", $vv), 'both');
								$this->db->or_like($kk, strto("lower|capitalizefirst", $vv), 'both');
								$this->db->or_like($kk, strto("lower|ucfirst", $vv), 'both');
							else :
								$this->db->or_like($kk, $vv, 'both');
								$this->db->or_like($kk, strto("lower", $vv), 'both');
								$this->db->or_like($kk, strto("lower|upper", $vv), 'both');
								$this->db->or_like($kk, strto("lower|ucwords", $vv), 'both');
								$this->db->or_like($kk, strto("lower|capitalizefirst", $vv), 'both');
								$this->db->or_like($kk, strto("lower|ucfirst", $vv), 'both');
							endif;
							$j++;
						endforeach;
					endforeach;

					// last loop
					if (count($likes) - 1 == $i) :
						// close bracket
						$this->db->group_end();
					endif;
					$i++;
				endif;
			endforeach;
		endif;
		if (!empty($limit)) :
			if (!empty($limit[1])) :
				$this->db->limit($limit[0], $limit[1]);
			else :
				$this->db->limit($limit[0]);
			endif;
		endif;
		return $this->db->order_by($order)->get($tableName)->result();
	}

	public function add($tableName = null, $data = array())
	{
		$this->db->insert($tableName, $data);
		return $this->db->insert_id();
	}

	public function update($tableName = null, $where = [], $data = array())
	{
		return $this->db->where($where)->update($tableName, $data);
	}

	public function delete($tableName = null, $where = [])
	{
		return $this->db->where($where)->delete($tableName);
	}

	public function rowCount($tableName = null, $where = [], $likes = [])
	{
		$this->db->where($where);
		if (!empty($likes)) :
			$i = 0;
			foreach ($likes as $key => $value) :
				// first loop
				if ($i === 0) :
					// open bracket
					$this->db->group_start();
					$this->db->like($key, $value, 'both');
					$this->db->or_like($key, strto("lower", $value), 'both');
					$this->db->or_like($key, strto("lower|upper", $value), 'both');
					$this->db->or_like($key, strto("lower|ucwords", $value), 'both');
					$this->db->or_like($key, strto("lower|capitalizefirst", $value), 'both');
					$this->db->or_like($key, strto("lower|ucfirst", $value), 'both');
				else :
					$this->db->or_like($key, $value, 'both');
					$this->db->or_like($key, strto("lower", $value), 'both');
					$this->db->or_like($key, strto("lower|upper", $value), 'both');
					$this->db->or_like($key, strto("lower|ucwords", $value), 'both');
					$this->db->or_like($key, strto("lower|capitalizefirst", $value), 'both');
					$this->db->or_like($key, strto("lower|ucfirst", $value), 'both');
				endif;

				// last loop
				if (count($likes) - 1 == $i) :
					// close bracket
					$this->db->group_end();
				endif;
				$i++;
			endforeach;
		endif;
		return $this->db->count_all_results($tableName);
	}
}
