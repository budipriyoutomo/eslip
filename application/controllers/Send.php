<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends CI_Controller {

	public function index()
	{

	}
	public function setemail()
	{
			$email="tofansuryadi@yahoo.co.id";
			$subject="E-Slip PT Panca";
			$message="Dear User, Berikut E-Slip Gaji Bulan Ini ";
			$this->sendEmail($email,$subject,$message);
	}
public function sendEmail($email,$subject,$message)
    {

    $config = Array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://mail.namahosting.id',
      'smtp_port' => 465,
      'smtp_user' => 'hrd@bogajabar.co.id',
      'smtp_pass' => 'alexandria',
      'mailtype' => 'html',
      'charset' => 'iso-8859-1',
      'wordwrap' => TRUE
    );


          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from('hrd@bogajabar.co.id');
          $this->email->to($email);
          $this->email->subject($subject);
          $this->email->message($message);
          $this->email->attach('./temp_send/ESlip.pdf');
          if($this->email->send())
         {
          echo 'Email send.';
         }
         else
        {
         show_error($this->email->print_debugger());
        }

    }
}
