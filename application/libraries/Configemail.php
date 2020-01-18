<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configemail {

    function ConfigSrvEmail() {

			$email_config = Array(
				'protocol'  => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => '465',
				'smtp_user' => 'idsistemas15@gmail.com',
				'smtp_pass' => '15329166',
				'mailtype'  => 'html',
				'starttls'  => true,
				'newline'   => "\r\n",
				'chartset' => "iso-8859-1"
			);
        return $email_config;
    }

    //Ejemplo de utilizaciÃ³n para una clave de 10 caracteres: 
}
