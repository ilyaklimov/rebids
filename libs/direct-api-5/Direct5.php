<?php

class Direct5 {

	private $url = 'https://api.direct.yandex.com/json/v5';
	private $token = '';
	private $login = '';

	function getResult($service, $method, $params) {

		$url = $this->url.'/'.$service;

		$header = array(
			'Accept-Language: ru',
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Bearer '.$this->token,
			'Client-Login: '.$this->login,
		);

        $request = array(
            'method' => $method,
            'params' => $params,
        );

        // преобразование в JSON-формат
        $request = json_encode($request);

        // параметры запроса
		$opts = array(
		    "ssl"=>array(
		        "verify_peer"=> false,
		        "verify_peer_name"=> false,
		    ),
			'http' => array(
				'method'  => 'POST',
				'header'  => $header,
				'content' => $request
			)
		);

		$context = stream_context_create($opts);

		$result = file_get_contents($url, 0, $context);

		return json_decode($result, true);
	}

	function __construct($token, $login) {
		$this->token = $token;
		$this->login = $login;
	}


}