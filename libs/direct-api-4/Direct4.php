<?php

class Direct4 {

    private $url = 'https://api.direct.yandex.ru/v4/json/';
    private $token = '';
    private $login = '';


    public function utf8($struct) {
        if (is_array($struct)) {
            foreach ($struct as $key => $value) {
                $res[$key] = $this->utf8($value);
            }
        } else {
            $res = utf8_encode($struct);
        }

        return $res;
    }


    private function getResult($method, $params) {

        $request = array(
            'token'=> $this->token,
            'method'=> $method,
            'param'=> $this->utf8($params),
            'locale'=> 'ru',
        );

        // преобразование в JSON-формат
        $request = json_encode($request);

        // параметры запроса
        $opts = array(
            "ssl"=>array(
                "verify_peer"=> false,
                "verify_peer_name"=> false,
            ),
            'http'=>array(
                'method'=>"POST",
                'content'=>$request,
            )
        );

        // создание контекста потока
        $context = stream_context_create($opts);

        // отправляем запрос и получаем ответ от сервера
        return file_get_contents($this->url, 0, $context);
    }


    public function createNewForecast($phrases, $lr) {
        if (empty($phrases) OR empty($lr)) {
            return false;
        }

        if (!is_array($phrases)) {
            return false;
        }

        $res = $this->getResult('CreateNewForecast', ['Phrases' => $phrases, 'GeoID' => $lr]);

        return json_decode($res);
    }


    public function getForecast($id) {
        if (empty($id)) {
            return false;
        }

        $res = $this->getResult('GetForecast', $id);

        return json_decode($res);
    }


    public function deleteForecastReport($id) {
        if (empty($id)) {
            return false;
        }

        $res = $this->getResult('DeleteForecastReport', $id);

        return json_decode($res);
    }


    public function getForecastList() {
        $res = $this->getResult('GetForecastList', []);
        return json_decode($res);
    }


    function __construct($token, $login) {
        $this->token = $token;
        $this->login = $login;
    }

}

?>
