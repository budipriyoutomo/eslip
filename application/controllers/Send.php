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

    $this->config->load('email_secret');
    $config = $this->config->item('smtp_bogajabar');


          $this->load->library('email', $config);
          $this->email->set_newline("\r\n");
          $this->email->from($config['smtp_user']);
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
