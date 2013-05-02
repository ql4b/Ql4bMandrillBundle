<?php
namespace Ql4b\Bundle\MandrillBundle\Service\Api;
	
use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request;

class Client {
	
	/**
	 * @var string
	 */
	private $apiEndpoint;
	
	/**
	 * @var string
	 */
	private $key;
	
	/**
	 * @var string
	 */
	private $format = 'json';
	
	/**
	 * @var HttpClient
	 */
	private static $httpClient;
	
	/**
	 * @param string $apiEndpoint
	 * @param string $key
	 */
	public function __construct($apiEndpoint, $key){
	
		$this->apiEndpoint = $apiEndpoint;
		$this->key = $key;
	
	}
	
	/**
	 * @link http://mandrillapp.com/api/docs/users.html#method=info
	 * @return Response
	 */
	public function userInfo(){
	
		return $this->request('users/info');
	
	}
	
	/**
	 * 
	 * @param array $data
	 * @link http://mandrillapp.com/api/docs/messages.html#method=send-template
	 * @return Response
	 * 
	 */
	public function sendTemplate($data){
	
		return $this->request('messages/send-template', $data);
	}
	
	/**
	 * 
	 * @param array $data
	 * @link http://mandrillapp.com/api/docs/messages.html#method=send
	 * @return Response
	 */
	public function send($data){
		
		return $this->request('messages/send', $data);
		
	}
	
	/**
	 *
	 * @param string $method
	 * @param array $data
	 * @throws \Exception
	 * @return Response
	 */
	private function request($method, array $data = array()){
		
		$uri = $this->apiEndpoint .'/' . $method . '.' . $this->format;
		
		$request = new Request;
		$request->setUri($uri);
		
		$request->setContent($this->buildRequestData($data));
		$request->setMethod(Request::METHOD_POST);
		
		try {
			$response = self::getHttpClient()->send($request);
		} catch (\Exception $e){
			throw new \Exception("HTTP Communication error",null,$e);
		}

		return new Response($response);
	
	}
	
	/**
	 * @param array $data
	 * @return string
	 */
	private function buildRequestData(array $data){
	
		$requestData = array_merge($data, array ('key' => $this->key));
		return json_encode($requestData);
	
	}

	/**
	 * @return HttpClient 
	 */
	private static function getHttpClient(){
		
		if (!isset(self::$httpClient)){
			self::$httpClient = new HttpClient();
		}
		
		return self::$httpClient;
		
	}
	
	
}
