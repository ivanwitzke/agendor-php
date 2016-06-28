<?php
namespace W6\Agendor;

class RestClient
{
    private $http_client;
    private $method;
    private $url;
    private $token;
    private $headers = array();
    private $parameters =  array();
    private $curl;

    public function __construct($params = array())
    {
        $this->curl = curl_init();
        $this->headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        if (!$params["url"]) {
            throw new AgendorException("You must set the URL to make a request.");
        } else {
            $this->url = $params["url"];
        }

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 60);

        if ($params["parameters"]) {
            $this->parameters = array_merge($this->parameters, $params["parameters"]);
        }

        if (!$this->parameters["api_key"]) {
            throw new AgendorException("You must provide a token make a request.");
        } else {
            $this->token = $this->parameters["api_key"];
            $this->headers[] = "Authorization: Token " . $this->token;
            unset($this->parameters["api_key"]);
        }

        if ($params["method"]) {
            $this->method = $params["method"];
        }

        if (isset($params["headers"])) {
            $this->headers = array_merge($this->headers, $params["headers"]);
        }

        if ($this->method) {
            switch ($this->method) {
                case 'post':
                case 'POST':
                    curl_setopt($this->curl, CURLOPT_POST, true);
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->parameters));
                    break;
                case 'get':
                case 'GET':
                    $this->url .= '?' . http_build_query($this->parameters);
                    break;
                case 'put':
                case 'PUT':
                    curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->parameters));
                    break;
                case 'delete':
                case 'DELETE':
                    curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->parameters));
                    break;

            }
        }

        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
    }

    public function run()
    {
        $response = curl_exec($this->curl);
        $error = curl_error($this->curl);

        if ($error) {
            var_dump($error);
            // throw new AgendorException("error: ".$error);
        }

        $code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        curl_close($this->curl);

        return array("code" => $code, "body" => $response);
    }
}
