<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tstatus extends MY_Controller {

	protected $access = array('SuperAdmin','Admin', 'User');

    function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('tstatus_model');
       
    }

    public function index($error = NULL)
    {
	    $Tstatus = $this->tstatus_model->get_all();

        $data = array(
            'action' => site_url('Tstatus/proses'),
            'periodegaji' => set_value('periodegaji'),
            'penerbitgaji' => set_value('penerbitgaji'),
           // 'namapt' => $this->Master->getallbrand(),
            'error' => $error['error']
        );

		$this->load->view('header');
//        $this->load->view('Tstatus/Tstatus_head',$data);
        $this->load->view('tstatus/tstatus_list',$Tstatus);
        $this->load->view('footer');
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->tstatus_model->json();
    }

    


}
