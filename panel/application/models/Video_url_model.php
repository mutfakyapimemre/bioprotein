<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Video_url_model extends CI_Model
{
	public $tableName = "video_urls";
	public function __construct()
	{
		parent::__construct();
        // Set orderable column fields
            
        $this->column_order = array('video_urls.rank', 'video_urls.id', 'video_urls.id', 'video_urls.img_url', 'video_urls.url','video_urls.lang','video_urls.isActive', 'video_urls.createdAt','video_urls.updatedAt','video_urls.updatedAt');
        // Set searchable column fields
        $this->column_search = array('video_urls.rank', 'video_urls.id', 'video_urls.id', 'video_urls.img_url', 'video_urls.url','video_urls.lang','video_urls.isActive', 'video_urls.createdAt','video_urls.updatedAt','video_urls.updatedAt');
        // Set default order
        $this->order = array('video_urls.rank' => 'ASC');
	}
	public function get_all($where = array(), $order = "id ASC")
	{
		return $this->db->where($where)->order_by($order)->get($this->tableName)->result();;
	}
	public function add($data = array())
	{
		return $this->db->insert($this->tableName, $data);
	}
	public function get($where = array())
	{
		return $this->db->where($where)->get($this->tableName)->row();
	}
	public function update($where = array(), $data = array())
	{
		return $this->db->where($where)->update($this->tableName, $data);
	}
	public function delete($where = array())
	{
		return $this->db->where($where)->delete($this->tableName);
	}
    
    public function rowCount($where = array())
    {
        return $this->db->where($where)->count_all_results($this->tableName);
    }

    public function countFiltered($where = array(), $postData = null)
    {

        $this->_get_datatables_query($postData);
        $this->db->select('
            video_urls.rank,
            video_urls.id,
            video_urls.gallery_id,
            video_urls.description,
            video_urls.img_url,
            video_urls.url,
            video_urls.lang,
            video_urls.isActive,
            video_urls.createdAt,
            video_urls.updatedAt,
            video_urls.sharedAt',    false);


        $query = $this->db->where($where)->get();
  
        return $query->num_rows();
	}
	
	public function getRows($where = array(), $postData = array())
    {
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->_get_datatables_query($postData);
      
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }

        $this->db->select('
		video_urls.rank,
		video_urls.id,
		video_urls.gallery_id,
		video_urls.description,
		video_urls.img_url,
		video_urls.url,
        video_urls.lang,
		video_urls.isActive,
		video_urls.createdAt,
        video_urls.updatedAt,
        video_urls.sharedAt',    false);
        return $this->db->get()->result();
        
    }

    private function _get_datatables_query($postData)
    {
        $this->db->where(["video_urls.id!=" => null]);

        //print_r($postData);


        $this->db->from($this->tableName);
        $i = 0;
        // loop searchable columns
        foreach ($this->column_search as $item) {
            // if datatable send POST for search

            if (!empty($postData['search'])) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search'], 'both');
                    $this->db->or_like($item, strto("lower",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|upper",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|ucwords",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|capitalizefirst",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|ucfirst",$postData['search']), 'both');
                } else {
                    $this->db->or_like($item, $postData['search'], 'both');
                    $this->db->or_like($item, strto("lower",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|upper",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|ucwords",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|capitalizefirst",$postData['search']), 'both');
                    $this->db->or_like($item, strto("lower|ucfirst",$postData['search']), 'both');
                }

                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }


        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}
