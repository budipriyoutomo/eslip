<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tstatus_model extends CI_Model
{

    public $table = 'tstatus';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id,nik,nama,jabatan,periode,penerbit,namapt,email,status');
        $this->datatables->from('tstatus');
		
        return $this->datatables->generate();
    }
	
    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }
    function get_data_send()
    {
        //$this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {

        $this->db->like('', $q);
      	$this->db->or_like('nik', $q);
      	$this->db->or_like('nama', $q);
      	$this->db->or_like('jabatan', $q);
      	$this->db->or_like('periode', $q);
      	$this->db->or_like('penerbit', $q);
		$this->db->or_like('namapt', $q);
		$this->db->or_like('email', $q);
		$this->db->or_like('status', $q);
      	$this->db->from($this->table);

        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('', $q);
      $this->db->or_like('nik', $q);
      	$this->db->or_like('nama', $q);
      	$this->db->or_like('jabatan', $q);
      	$this->db->or_like('periode', $q);
      	$this->db->or_like('penerbit', $q);
		$this->db->or_like('namapt', $q);
		$this->db->or_like('email', $q);
		$this->db->or_like('status', $q);
      	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    //truncate
    function truncateall(){
        $this->db->truncate($this->table);
    }

}

