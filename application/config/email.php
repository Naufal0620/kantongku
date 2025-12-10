<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
    'protocol'  => 'smtp',
    'smtp_host' => $_ENV['SMTP_HOST'],
    'smtp_user' => $_ENV['SMTP_USER'],
    'smtp_pass' => $_ENV['SMTP_PASS'],
    'smtp_port' => $_ENV['SMTP_PORT'],
    'mailtype'  => 'html',
    'charset'   => 'utf-8',
    'newline'   => "\r\n",
    'crlf'      => "\r\n", 
    'validation'=> TRUE
];