<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tmsteslip extends MY_Controller {

	protected $access = array('SuperAdmin','Admin', 'User');

    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->library('form_validation');
	    $this->load->library('datatables');
        $this->load->model('Tmsteslip_model');
        $this->load->model('Tstatus_model');
        $this->load->model('Master');
        $this->load->helper('email');
        $this->load->helper('file');


    }

    public function index($error = NULL)
    {
	    $tmsteslip = $this->Tmsteslip_model->get_all();

        $data = array(
            'action' => site_url('tmsteslip/proses'),
            'periodegaji' => set_value('periodegaji'),
            'penerbitgaji' => set_value('penerbitgaji'),
            'namapt' => $this->Master->getallbrand(),
            'error' => $error['error']
        );

		    $this->load->view('header');
        $this->load->view('tmsteslip/tmsteslip_head',$data);
        $this->load->view('tmsteslip/tmsteslip_list',$tmsteslip);
        $this->load->view('footer');
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->Tmsteslip_model->json();
    }

    public function proses()
    {
        //validasi judul
        $this->form_validation->set_rules('namapt', 'namapt', 'trim|required');
        $this->form_validation->set_rules('periodegaji', 'periodegaji', 'trim|required');
        $this->form_validation->set_rules('penerbitgaji', 'penerbitgaji', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            // jika validasi judul gagal
            $this->index();
        } else {
            // config upload
            $config['upload_path'] = './temp_upload/';
            $config['allowed_types'] = 'xls';
            $config['max_size'] = '10000';
            //$config['filename'] = $filename;
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload()) {
                // jika validasi file gagal, kirim parameter error ke index
                $error = array('error' => $this->upload->display_errors());
                $this->index($error);

                //redirect(site_url('in'));
            } else {
              // jika berhasil upload ambil data dan masukkan ke database
              $upload_data = $this->upload->data();

              $this->load->library('Excel_reader');

              //tentukan file
              $this->excel_reader->setOutputEncoding('UTF-8');
              $file = $upload_data['full_path'];

              $this->excel_reader->read($file);
              error_reporting(E_ALL ^ E_NOTICE);

              // array data
              $data = $this->excel_reader->sheets[0];
              $dataexcel = Array();
              for ($i = 1; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                   break;
                   $dataexcel[$i - 1]['nik'] = $data['cells'][$i][1];
                   $dataexcel[$i - 1]['nama'] = $data['cells'][$i][2];
                   $dataexcel[$i - 1]['jabatan'] = $data['cells'][$i][3];
                  // $dataexcel[$i - 1]['periode'] = $data['cells'][$i][4];
                   $dataexcel[$i - 1]['periode'] = date("Y-m-d",strtotime(substr($this->input->post('periodegaji',TRUE),0,10)));//$data['cells'][$i][4];
                   $dataexcel[$i - 1]['gaji'] = $data['cells'][$i][5];
                   $dataexcel[$i - 1]['svctetap'] = $data['cells'][$i][6];
                   $dataexcel[$i - 1]['svcvariabel'] = $data['cells'][$i][7];
                   $dataexcel[$i - 1]['target'] = $data['cells'][$i][8];
                   $dataexcel[$i - 1]['lembur'] = $data['cells'][$i][9];
                   $dataexcel[$i - 1]['uangmakan'] = $data['cells'][$i][10];
                   $dataexcel[$i - 1]['transport'] = $data['cells'][$i][11];
                   $dataexcel[$i - 1]['pengmcu'] = $data['cells'][$i][12];
                   $dataexcel[$i - 1]['bpjsnakerjht'] = $data['cells'][$i][13];
                   $dataexcel[$i - 1]['bpjsnakerjp'] = $data['cells'][$i][14];
                   $dataexcel[$i - 1]['bpjssehat'] = $data['cells'][$i][15];
                   $dataexcel[$i - 1]['potmcu'] = $data['cells'][$i][16];
                   $dataexcel[$i - 1]['pinalty'] = $data['cells'][$i][17];
                   $dataexcel[$i - 1]['potlain'] = $data['cells'][$i][18];
                   $dataexcel[$i - 1]['ketpot'] = $data['cells'][$i][19];
                   $dataexcel[$i - 1]['penlain'] = $data['cells'][$i][20];
                   $dataexcel[$i - 1]['ketpen'] = $data['cells'][$i][21];
                   $dataexcel[$i - 1]['sakit'] = $data['cells'][$i][22];
                   $dataexcel[$i - 1]['alpha'] = $data['cells'][$i][23];
                   $dataexcel[$i - 1]['cutdak'] = $data['cells'][$i][24];
                   $dataexcel[$i - 1]['hadir'] = $data['cells'][$i][25];
                   $dataexcel[$i - 1]['thp'] = $data['cells'][$i][26];
                   //$dataexcel[$i - 1]['penerbitgaji'] = $data['cells'][$i][27];
                   $dataexcel[$i - 1]['penerbitgaji'] = date("Y-m-d",strtotime(substr($this->input->post('penerbitgaji',TRUE),0,10)));//$data['cells'][$i][27];
                   //$dataexcel[$i - 1]['namapt'] = $data['cells'][$i][28];
                   $dataexcel[$i - 1]['namapt'] = $this->input->post('namapt',TRUE);//$data['cells'][$i][28];
                   $dataexcel[$i - 1]['email'] = $data['cells'][$i][29];

              }

              //load model
              $this->Tmsteslip_model->loaddata($dataexcel);

              //delete file
              $file = $upload_data['file_name'];
              $path = './temp_upload/' . $file;
              unlink($path);

              redirect(site_url('Tmsteslip'));
            }
        //redirect ke halaman awal
        }
    }

    function genpdf(){

        $tmsteslip = $this->Tmsteslip_model->get_all();
        foreach($tmsteslip as $row ){
        if (delete_files('./temp_send/')){
            
          $idpt = $row->namapt;
          $brand = $this->Master->getbrand($idpt);
          $pdf = new FPDF('L','mm','A5');
          // membuat halaman baru
        $pdf->AddPage('','','',$brand->namaPT);
        if($idpt==1){
          $pdf->Image('./image/logo-ST.png',10,10,-300);
        }elseif ($idpt==2) {
          $pdf->Image('./image/logo-PL.png',10,10,-300); // code...
        }elseif ($idpt==3) {
          $pdf->Image('./image/logo-BJ.png',10,10,-300); // code...
        }elseif ($idpt==4) {
          $pdf->Image('./image/logo-XF.png',10,10,-300); // code...
        }
        //$pdf->Image('./image/logo.png',10,10,-300);
        //$
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',14);

        // Header
        $pdf->SetX(25);
        $pdf->Cell(120,5, $brand->namaPT ,0,1);
        $pdf->SetFont('Arial','',9);
        $pdf->SetX(25);
        $pdf->Cell(120,5, $brand->alamat  ,0,1,'L');
        $pdf->SetX(25);
        $pdf->Cell(120,5,$brand->kota,0,1,'L');
        $pdf->SetX(25);
        $pdf->Cell(120,5,$brand->telp ,0,1,'L');
        //$pdf->Cell(120,5,'' ,0,1,'L');


        $pdf->Line(10,30,200,30);
      //  $pdf->Cell(10,4,'',0,1);
        $pdf->SetFont('Arial','B',9);
      //  $pdf->Cell(190,6,'Periode : Desember 2018 ',0,1,'R');

        $pdf->Cell(100,7,'NIK : '.$row->nik,0,0,'L');

        //$pdf->Cell(0,7,'Periode :'.$row->periodegaji,0,1,'R');
        $periode= date("F-Y",strtotime(substr($row->periodegaji,0,10)));
        $pdf->Cell(0,7,'Periode :'.$periode ,0,1,'R');

        $pdf->Cell(100,6,'Nama : '.$row->nama,0,0,'L');
        $pdf->Cell(100,7,'Jabatan : '.$row->jabatan,0,1,'L');
        $pdf->Line(10,43,200,43);
        $pdf->Cell(80,6,'PENERIMAAN',0,0,'L');
        $pdf->Cell(10,6,'POTONGAN',0,1,'L');
        $pdf->Line(10,49,200,49);

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(40,5,'GAJI',0,0,'L');
        $pdf->Cell(40,5,' = '. number_format($row->gaji,2,",",".") ,0,0,'L');
        $pdf->Cell(55,5,'BPJS KETENAGAKERJAAN JHT',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->bpjsnakerjht,2,",","."),0,1,'L');

        $pdf->Cell(40,5,'SERVICE TETAP',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->svctetap,2,",","."),0,0,'L');
        $pdf->Cell(55,5,'BPJS KETENAGAKERJAAN JP',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->bpjsnakerjp,2,",","."),0,1,'L');

        $pdf->Cell(40,5,'SERVICE VARIABEL',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->svcvariabel,2,",","."),0,0,'L');
        $pdf->Cell(55,5,'BPJS KESEHATAN',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->bpjssehat,2,",","."),0,1,'L');
        
        $pdf->Cell(40,5,'TARGET',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->target,2,",","."),0,0,'L');        
        $pdf->Cell(55,5,'POTONGAN MCU',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->potmcu,2,",","."),0,1,'L');
        
        $pdf->Cell(40,5,'LEMBUR',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->lembur,2,",","."),0,0,'L');
        $pdf->Cell(55,5,'PINALTY SAFETY SHOES',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->pinalty,2,",","."),0,1,'L');

        $pdf->Cell(40,5,'UANG MAKAN',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->uangmakan,2,",","."),0,0,'L');
        $pdf->Cell(55,5,'POTONGAN LAIN',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->potlain,2,",","."),0,1,'L');

        $pdf->Cell(40,5,'TRANSPORT',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->transport,2,",","."),0,0,'L');
        $pdf->Cell(55,5,'KET POTONGAN :',0,1,'L');
        
        $pdf->Cell(40,5,'PENGEMBALIAN MCU ',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->pengmcu,2,",","."),0,0,'L');
        $pdf->Cell(55,5,$row->ketpot,0,1,'L');

        $pdf->Cell(40,5,'PENERIMAAN LAINNYA',0,0,'L');
        $pdf->Cell(40,5,' = '.number_format($row->penlain,2,",","."),0,0,'L');
        $pdf->Cell(40,5,'JUMLAH SAKIT',0,0,'L');
        $pdf->Cell(55,5,' = '.$row->sakit,0,1,'L');


        $pdf->Cell(80,5,'KET PENERIMAAN : ',0,0,'L');
        $pdf->Cell(40,5,'JUMLAH ALPHA',0,0,'L');
        $pdf->Cell(55,5,' = '.$row->alpha,0,1,'L');
        
        $pdf->Cell(80,5,$row->ketpen,0,0,'L');
        
        //$pdf->Cell(10,3,'',0,1);
        //$pdf->Cell(40,5,'JUMLAH SAKIT',0,0,'L');
        //$pdf->Cell(40,5,' = '.$row->sakit,0,1,'L');
        
        $pdf->Cell(40,5,'JUMLAH CUTI DADAKAN',0,0,'L');
        $pdf->Cell(55,5,' = '.$row->cutdak,0,1,'L');
        $pdf->Cell(80,3,'',0,0);
        $pdf->Cell(40,5,'JUMLAH KEHADIRAN',0,0,'L');
        $pdf->Cell(55,5,' = '.$row->hadir,0,1,'L');



        $pdf->SetFont('Arial','B',9);
        $pdf->Line(10,115,200,115);
        $pdf->Cell(40,6,'TOTAL PENERIMAAN',0,0,'L');
        $totpenerimaan = $row->gaji + $row->svcvariabel + $row->svctetap + $row->target + $row->lembur +  $row->uangmakan + $row->transport + $row->pengmcu + $row->penlain;
        $pdf->Cell(40,6,' = '.number_format($totpenerimaan,2,",","."),0,0,'L');
        $pdf->Cell(55,6,'TOTAL POTONGAN',0,0,'L');
        $totpotongan = $row->bpjsnakerjht + $row->bpjsnakerjp + $row->bpjssehat + $row->potmcu + $row->pinalty + $row->potlain ;
        $pdf->Cell(40,6,' = '.number_format($totpotongan,2,",","."),0,1,'L');
        $pdf->Line(10,121,200,121);
        $pdf->Cell(40,6,'TAKE HOME PAY',0,0,'L');
        $pdf->Cell(40,6,' = '.number_format($row->thp,2,",","."),0,0,'L');
        $pdf->Cell(0,6,'Bandung , '. $row->penerbitgaji ,0,1,'R');
        $pdf->SetFont('Arial','',8);

            $output = './temp_send/'.$row->nik.'.pdf';
       
        $pdf->Output($output,'F');
        //$pdf->Output();
        //$email =$row->email;

        $status  = $this->setemail($row->email,$brand->namaPT,$periode,$output);
        
        
         $data = array(
    		'nik' => $row->nik,
    		'nama' => $row->nama,
    		'jabatan' => $row->jabatan,
    		'periode' => $row->periodegaji,
    		'penerbit' => $row->penerbitgaji,
    		'namapt' => $row->namapt,
    		'email' => $row->email,
    		'status' => $status,
    	    );
    	    
	     $this->Tstatus_model->insert($data);
	     
        if(!unlink($output)){
            break;
        }else{
            delete_files($output);
        } 
        
        $this->Tmsteslip_model->delete($row->id);
        
        }else {
            printf('error');
        }
      }

    //redirect(site_url('tmsteslip')); 
    }

    public function setemail($email,$pt,$periode,$output)
  	{
  		//	$email="budi_p_u@yahoo.co.uk";
  			$subject="E-Slip ".$pt;
  			$message="Dear $email, Berikut E-Slip Gaji Bulan ".$periode;
  			
  	   return  $this->sendEmail($email,$subject,$message,$output);
  	}

    public function sendEmail($email,$subject,$message,$output)
    {

      $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://mail.namahosting.id',
        'smtp_port' => 465,
        'smtp_user' => 'hrd@bogajabar.co.id',
        'smtp_pass' => 'alexandria',
       // 'mailtype' => 'html',
        //'charset' => 'iso-8859-1',
        //'wordwrap' => TRUE
      );


            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('hrd@bogajabar.co.id');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->attach($output);
            if($this->email->send())
            {
                //echo 'Email send. '.$output;
                $this->email->clear(TRUE); 
                return true;
            
            } else {
               // show_error($this->email->print_debugger());
                return false;
            }

      }

    public function delete($id)
    {
     	$level = $this->session->userdata('role') ;

		if ($level!='User')
		{
			$row = $this->Tmsteslip_model->get_by_id($id);

			if ($row) {
				$this->Tmsteslip_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('tmsteslip'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('tmsteslip'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('tmsteslip'));

		}
    }

    public function deldata(){
      $level = $this->session->userdata('role') ;

		if ($level!='User')
		{
      	$this->Tmsteslip_model->truncateall();
        $this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('tmsteslip'));
    }

    }

    public function _rules()
    {
	$this->form_validation->set_rules('nik', 'nik', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('jabatan', 'jabatan', 'trim|required');
	$this->form_validation->set_rules('periodegaji', 'periodegaji', 'trim|required');
	$this->form_validation->set_rules('gaji', 'gaji', 'trim|required|numeric');
	$this->form_validation->set_rules('svctetap', 'svctetap', 'trim|required|numeric');
	$this->form_validation->set_rules('svcvariabel', 'svcvariabel', 'trim|required|numeric');
	$this->form_validation->set_rules('target', 'target', 'trim|required|numeric');
	$this->form_validation->set_rules('lembur', 'lembur', 'trim|required|numeric');
	$this->form_validation->set_rules('uangmakan', 'uangmakan', 'trim|required|numeric');
	$this->form_validation->set_rules('transport', 'transport', 'trim|required|numeric');
	$this->form_validation->set_rules('pengmcu', 'pengmcu', 'trim|required|numeric');
  $this->form_validation->set_rules('bpjsnakerjht', 'bpjsnaker', 'trim|required|numeric');
  $this->form_validation->set_rules('bpjsnakerjp', 'bpjsnaker', 'trim|required|numeric');
	$this->form_validation->set_rules('bpjssehat', 'bpjssehat', 'trim|required|numeric');
	$this->form_validation->set_rules('potmcu', 'potmcu', 'trim|required|numeric');
	$this->form_validation->set_rules('pinalty', 'pinalty', 'trim|required|numeric');
	$this->form_validation->set_rules('potlain', 'potlain', 'trim|required|numeric');
	$this->form_validation->set_rules('ketpot', 'ketpot', 'trim|required');
	$this->form_validation->set_rules('sakit', 'sakit', 'trim|required');
	$this->form_validation->set_rules('alpha', 'alpha', 'trim|required');
	$this->form_validation->set_rules('cutdak', 'cutdak', 'trim|required');
	$this->form_validation->set_rules('thp', 'thp', 'trim|required|numeric');
	$this->form_validation->set_rules('penerbitgaji', 'penerbitgaji', 'trim|required');

	$this->form_validation->set_rules('', '', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }




}
