<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tmsteslip_model extends CI_Model
{

    public $table = 'tmsteslip';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id,nik,nama,jabatan,periodegaji,penerbitgaji,namapt,email');
        $this->datatables->from('tmsteslip');
       
        return $this->datatables->generate();
    }


       function loaddata($dataarray) {
           for ($i = 0; $i < count($dataarray); $i++) {
               $data = array(
                   'nik' => $dataarray[$i]['nik'],
                   'nama' => $dataarray[$i]['nama'],
                   'jabatan' => $dataarray[$i]['jabatan'],
                   'periodegaji' => $dataarray[$i]['periode'],
                   'gaji' => $dataarray[$i]['gaji'],
                   'svctetap' => $dataarray[$i]['svctetap'],
                   'svcvariabel' => $dataarray[$i]['svcvariabel'],
                   'target' => $dataarray[$i]['target'],
                   'lembur' => $dataarray[$i]['lembur'],
                   'uangmakan' => $dataarray[$i]['uangmakan'],
                   'transport' => $dataarray[$i]['transport'],
                   'pengmcu' => $dataarray[$i]['pengmcu'],
                   'bpjsnakerjht' => $dataarray[$i]['bpjsnakerjht'],
                   'bpjsnakerjp' => $dataarray[$i]['bpjsnakerjp'],
                   'bpjssehat' => $dataarray[$i]['bpjssehat'],
                   'potmcu' => $dataarray[$i]['potmcu'],
                   'pinalty' => $dataarray[$i]['pinalty'],
                   'potlain' => $dataarray[$i]['potlain'],
                   'ketpot' => $dataarray[$i]['ketpot'],
                   'penlain' => $dataarray[$i]['penlain'],
                   'ketpen' => $dataarray[$i]['ketpen'],
                   'sakit' => $dataarray[$i]['sakit'],
                   'alpha' => $dataarray[$i]['alpha'],
                   'cutdak' => $dataarray[$i]['cutdak'],
                   'hadir' => $dataarray[$i]['hadir'],
                   'thp' => $dataarray[$i]['thp'],
                   'penerbitgaji' => $dataarray[$i]['penerbitgaji'],
                   'namapt' => $dataarray[$i]['namapt'],
                   'email' => $dataarray[$i]['email']

               );

              $cek=$this->db->where('nik', $this->input->post('nik'));
               if ($cek) {
                   $this->db->insert($this->table, $data);
               }else{
                  echo "Data Double baris ke-".$i;
               }
           }
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
      	$this->db->or_like('periodegaji', $q);
      	$this->db->or_like('gaji', $q);
      	$this->db->or_like('svctetap', $q);
      	$this->db->or_like('svcvariabel', $q);
      	$this->db->or_like('target', $q);
      	$this->db->or_like('lembur', $q);
      	$this->db->or_like('uangmakan', $q);
      	$this->db->or_like('transport', $q);
      	$this->db->or_like('pengmcu', $q);
      	$this->db->or_like('bpjsnaker', $q);
      	$this->db->or_like('bpjssehat', $q);
      	$this->db->or_like('potmcu', $q);
      	$this->db->or_like('pinalty', $q);
      	$this->db->or_like('potlain', $q);
      	$this->db->or_like('ketpot', $q);
      	$this->db->or_like('sakit', $q);
      	$this->db->or_like('alpha', $q);
      	$this->db->or_like('cutdak', $q);
      	$this->db->or_like('hadir', $q);
      	$this->db->or_like('thp', $q);
      	$this->db->or_like('penerbitgaji', $q);
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
      	$this->db->or_like('periodegaji', $q);
      	$this->db->or_like('gaji', $q);
      	$this->db->or_like('svctetap', $q);
      	$this->db->or_like('svcvariabel', $q);
      	$this->db->or_like('target', $q);
      	$this->db->or_like('lembur', $q);
      	$this->db->or_like('uangmakan', $q);
      	$this->db->or_like('transport', $q);
      	$this->db->or_like('pengmcu', $q);
      	$this->db->or_like('bpjsnaker', $q);
      	$this->db->or_like('bpjssehat', $q);
      	$this->db->or_like('potmcu', $q);
      	$this->db->or_like('pinalty', $q);
      	$this->db->or_like('potlain', $q);
      	$this->db->or_like('ketpot', $q);
      	$this->db->or_like('sakit', $q);
      	$this->db->or_like('alpha', $q);
      	$this->db->or_like('cutdak', $q);
      	$this->db->or_like('hadir', $q);
      	$this->db->or_like('thp', $q);
      	$this->db->or_like('penerbitgaji', $q);
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

