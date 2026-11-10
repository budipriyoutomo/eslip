<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Salin file ini menjadi email_secret.php lalu isi kredensialnya.
*/

$config['smtp_maharasa'] = array(
	'protocol'    => 'mail',
	'smtp_host'   => 'mail.example.com',
	'smtp_port'   => 465,
	'smtp_user'   => 'SMTP_USER',
	'smtp_pass'   => 'SMTP_PASSWORD',
	'smtp_crypto' => 'tls',
);

$config['smtp_bogajabar'] = array(
	'protocol'  => 'smtp',
	'smtp_host' => 'ssl://mail.example.com',
	'smtp_port' => 465,
	'smtp_user' => 'SMTP_USER',
	'smtp_pass' => 'SMTP_PASSWORD',
	'mailtype'  => 'html',
	'charset'   => 'iso-8859-1',
	'wordwrap'  => TRUE,
);

$config['smtp_gmail'] = array(
	'protocol'    => 'mail',
	'smtp_host'   => 'smtp.gmail.com',
	'smtp_port'   => 587,
	'smtp_user'   => 'SMTP_USER',
	'smtp_pass'   => 'SMTP_PASSWORD',
	'smtp_crypto' => 'tls',
);
