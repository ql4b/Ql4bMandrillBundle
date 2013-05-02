<?php
namespace Ql4b\Bundle\MandrillBundle\Service\Api;

use Zend\Http\Response as HttpResponse;

class Response {
	
	/**
	 * @var boolean
	 */
	private $valid;
	
	/**
	 * @var \stdClass
	 */
	private $data;
	
	/**
	 * @param HttpResponse $response
	 */
	public function __construct(HttpResponse $response){
		
		if ($response->getStatusCode() !== HttpResponse::STATUS_CODE_200)
			$this->valid = false;
		else 
			$this->valid = true;
		
		if (($rawData = $response->getBody()) !== "")
			$this->data = json_decode($rawData);
		
	}
	
	/**
	 * @return boolean
	 */
	public function isValid(){
		
		return $this->valid;
		
	}
	
	/**
	 * @return \stdClass
	 */
	public function getData(){
		
		return $this->data;
	}
	
}