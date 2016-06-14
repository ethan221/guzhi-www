<?php namespace App\Service;

use App\Eloquent\Customer;
use App\Eloquent\Address;
use App\Eloquent\CustomerLogin;
use App\Eloquent\CustomerActivity;
use App\Eloquent\CustomerGroup;

use App\Validation\RegisterValidator;

class EdgapiService
{
	protected $opencart;

	protected $params;

	protected $error_messages;

	public $errors;

	public function __construct($opencart, $params, $error_messages)
	{
		$this->opencart = $opencart;
		$this->params = $params;
		$this->error_messages = $error_messages;
                                    $this->init();
	}
        
                 public function init(){
                           $this->opencart->load->helper('utils');
                 }
                 
}