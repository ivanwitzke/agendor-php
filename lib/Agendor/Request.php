<?php
namespace Ivanwitzke\Agendor;

class Request extends Agendor
{
    private $path;
    private $method;
    private $parameters = array();
    private $headers;
    private $live;

    public function __construct($path, $method, $live = Agendor::LIVE)
    {
        $this->method = $method;
        $this->path = $path;
        $this->live = $live;
    }

    public function run()
    {
        if (!parent::getApiKey()) {
            throw new Exception("You need to configure API key before performing requests.");
        }

        $this->parameters = array_merge($this->parameters, array( "api_key" => parent::getApiKey()));
        $client = new RestClient(array("method" => $this->method, "url" => $this->fullApiUrl($this->path), "headers" => $this->headers, "parameters" => $this->parameters ));

        $response = $client->run();

        if ($response["code"] == 204) {
            return true;
        }

        $decode = json_decode($response["body"], true);
        if ($decode === null) {
            throw new Exception("Failed to decode json from response.\n\n Response: ".$response);
        } else {
            if ($response["code"] == 200 || $response["code"] == 201) {
                return $decode;
            } else {
                throw Exception::buildWithFullMessage($decode);
            }
        }
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
