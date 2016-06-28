<?php
namespace W6\Agendor;

class AgendorRequest extends Agendor
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
            throw new AgendorException("You need to configure API key before performing requests.");
        }

        $this->parameters = array_merge($this->parameters, array( "api_key" => parent::getApiKey()));
        // var_dump($this->parameters);
        // $this->headers = (Agendor::LIVE) ? array("X-Live" => 1) : array();
        $client = new RestClient(array("method" => $this->method, "url" => $this->fullApiUrl($this->path), "headers" => $this->headers, "parameters" => $this->parameters ));

        $response = $client->run();
        $decode = json_decode($response["body"], true);
        if ($decode === null) {
            throw new Exception("Failed to decode json from response.\n\n Response: ".$response);
        } else {
            if ($response["code"] == 200) {
                return $decode;

            } else {
                throw AgendorException::buildWithFullMessage($decode);
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
