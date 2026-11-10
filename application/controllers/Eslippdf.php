<?php
Class Eslippdf extends MY_Controller{

//protected $access = array('SuperAdmin','Admin', 'User');
//
	function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
				$this->load->model('Tmsteslip_model');
				$this->load->model('Master');
    }

    function index(){

    }
		function genpdf(){

				//$tmsteslip = $this->Tmsteslip_model->get_all();
				//$tmsteslip = $this->Master->getbrand();

        $pdf = new FPDF('L','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
				$pdf->Image('./image/logo.png',10,10,-300);
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',14);

				// Header
        $pdf->SetX(25);
        $pdf->Cell(120,5,'PT. Panca Abadi Nan Jaya',0,1);
        $pdf->SetFont('Arial','',9);
				$pdf->SetX(25);
        $pdf->Cell(120,5,'JL. SUMATERA NO. 9',0,1,'L');
				$pdf->SetX(25);
        $pdf->Cell(120,5,'BANDUNG',0,1,'L');
				$pdf->SetX(25);
        $pdf->Cell(120,5,'TELP: 022-5441 0675',0,1,'L');


        $pdf->Line(10,30,200,30);
      //  $pdf->Cell(10,4,'',0,1);
        $pdf->SetFont('Arial','B',9);
      //  $pdf->Cell(190,6,'Periode : Desember 2018 ',0,1,'R');
        $x = 'ST-0098234';
        $pdf->Cell(100,7,'NIK : '.$x,0,0,'L');

        $pdf->Cell(0,7,'Periode : Desember 2018',0,1,'R');
        $pdf->Cell(100,6,'Nama : Budi Priyo Utomo',0,0,'L');
        $pdf->Cell(100,7,'Jabatan : Bartender',0,1,'L');
        $pdf->Line(10,43,200,43);
        $pdf->Cell(80,6,'PENERIMAAN',0,0,'L');
        $pdf->Cell(10,6,'POTONGAN',0,1,'L');
        $pdf->Line(10,49,200,49);
				//$gaji = '500000';
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(40,5,'GAJI',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,0,'L');
        $pdf->Cell(55,5,'BPJS KETENAGAKERJAAN',0,0,'L');
				$pdf->Cell(40,5,' = 45.000',0,1,'L');

        $pdf->Cell(40,5,'SERVICE TETAP',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,0,'L');
        $pdf->Cell(55,5,'BPJS KESEHATAN',0,0,'L');
				$pdf->Cell(40,5,' = 45.000',0,1,'L');

        $pdf->Cell(40,5,'SERVICE VARIABEL',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,0,'L');
        $pdf->Cell(55,5,'POTONGAN MCU',0,0,'L');
				$pdf->Cell(40,5,' = 45.000',0,1,'L');

        $pdf->Cell(40,5,'TARGET',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,0,'L');
        $pdf->Cell(55,5,'PINALTY SAFETY SHOES',0,0,'L');
				$pdf->Cell(40,5,' = 45.000',0,1,'L');

        $pdf->Cell(40,5,'LEMBUR',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,0,'L');
        $pdf->Cell(55,5,'POTONGAN LAIN',0,0,'L');
				$pdf->Cell(40,5,' = 45.000',0,1,'L');

        $pdf->Cell(40,5,'UANG MAKAN',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,0,'L');
        $pdf->Cell(55,5,'KET POTONGAN :',0,1,'L');


        $pdf->Cell(40,5,'TRANSPORT',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,0,'L');
        $pdf->Cell(80,5,'catatan keterangan potongan lain ',0,1,'L');
        $pdf->Cell(40,5,'PENGEMBALIAN MCU ',0,0,'L');
				$pdf->Cell(40,5,' = 5.000.000',0,1,'L');

        $pdf->Cell(10,3,'',0,1);
        $pdf->Cell(80,3,'KETERANGAN :',0,1,'L');
        $pdf->Cell(40,5,'JUMLAH SAKIT',0,0,'L');
				$pdf->Cell(40,5,' = 1',0,1,'L');
        $pdf->Cell(40,5,'JUMLAH ALPHA',0,0,'L');
				$pdf->Cell(40,5,' = 1',0,1,'L');
        $pdf->Cell(40,5,'JUMLAH CUTI DADAKAN',0,0,'L');
				$pdf->Cell(40,5,' = 1',0,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->Line(10,110,200,110);
        $pdf->Cell(40,6,'TOTAL PENERIMAAN',0,0,'L');
				$pdf->Cell(40,6,' = 5.000.000',0,0,'L');
        $pdf->Cell(55,6,'TOTAL POTONGAN',0,0,'L');
				$pdf->Cell(40,6,' = 5.000.000',0,1,'L');
        $pdf->Line(10,116,200,116);
        $pdf->Cell(40,6,'TAKE HOME PAY',0,0,'L');
				$pdf->Cell(40,6,'= 5.000.000',0,0,'L');
        $pdf->Cell(0,6,'Penerbitan : 5 Desember 2018',0,1,'R');
        $pdf->SetFont('Arial','',8);

        //$pdf->Output('./temp_send/Eslip.pdf','F');
        $pdf->Output();

		}
}
