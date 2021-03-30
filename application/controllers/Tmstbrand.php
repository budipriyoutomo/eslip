<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tmstbrand extends MY_Controller {

	protected $access = array('SuperAdmin','Admin', 'User');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tmstbrand_model');
        $this->load->library('form_validation');
	      $this->load->library('datatables');
    }

    public function index()
    {
	    $tmstbrand = $this->Tmstbrand_model->get_all();

        $data = array(
            'tmstbrand_data' => $tmstbrand
        );
		$this->load->view('header');
        $this->load->view('tmstbrand/tmstbrand_list', $data);
        $this->load->view('footer');
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->Tmstbrand_model->json();
    }

    public function read($id)
    {
        $row = $this->Tmstbrand_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'namaPT' => $row->namaPT,
		'alamat' => $row->alamat,
		'telp' => $row->telp,
		'logo' => $row->logo,
	    );

			$this->load->view('header');
            $this->load->view('tmstbrand/tmstbrand_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tmstbrand'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tmstbrand/create_action'),
	    'id' => set_value('id'),
	    'namaPT' => set_value('namaPT'),
	    'alamat' => set_value('alamat'),
	    'telp' => set_value('telp'),
	    'logo' => set_value('logo'),
	);

		$this->load->view('header');
		$this->load->view('tmstbrand/tmstbrand_form', $data);
        $this->load->view('footer');

    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'namaPT' => $this->input->post('namaPT',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'telp' => $this->input->post('telp',TRUE),
		'logo' => $this->input->post('logo',TRUE),
	    );

            $this->Tmstbrand_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tmstbrand'));
        }
    }

    public function update($id)
    {
        $row = $this->Tmstbrand_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tmstbrand/update_action'),
		'id' => set_value('id', $row->id),
		'namaPT' => set_value('namaPT', $row->namaPT),
		'alamat' => set_value('alamat', $row->alamat),
		'telp' => set_value('telp', $row->telp),
		'logo' => set_value('logo', $row->logo),
	    );
			$this->load->view('header');
			$this->load->view('tmstbrand/tmstbrand_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tmstbrand'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'namaPT' => $this->input->post('namaPT',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'telp' => $this->input->post('telp',TRUE),
		'logo' => $this->input->post('logo',TRUE),
	    );

            $this->Tmstbrand_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tmstbrand'));
        }
    }

    public function delete($id)
    {
     	$level = $this->session->userdata('role') ;

		if ($level!='User')
		{
			$row = $this->Tmstbrand_model->get_by_id($id);

			if ($row) {
				$this->Tmstbrand_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('tmstbrand'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('tmstbrand'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('tmstbrand'));

		}
    }

    public function _rules()
    {
	$this->form_validation->set_rules('namaPT', 'namapt', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('logo', 'logo', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tmstbrand.xls";
        $judul = "tmstbrand";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "NamaPT");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Telp");
	xlsWriteLabel($tablehead, $kolomhead++, "Logo");

	foreach ($this->Tmstbrand_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->namaPT);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->telp);
	    xlsWriteLabel($tablebody, $kolombody++, $data->logo);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tmstbrand.doc");

        $data = array(
            'tmstbrand_data' => $this->Tmstbrand_model->get_all(),
            'start' => 0
        );

        $this->load->view('tmstbrand/tmstbrand_doc',$data);
    }

}

/* End of file Tmstbrand.php */
/* Location: ./application/controllers/Tmstbrand.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-11-28 02:58:58 */
/* http://harviacode.com */
