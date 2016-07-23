<?php
namespace Ivanwitzke\Agendor;

class Exception extends \Exception
{
    protected $url;
    protected $method;
    protected $returnCode;
    protected $parameterName;
    protected $type;
    protected $errors;

    // Builds with a message and a response from the server
    public function __construct($message = null, $responseError = null)
    {
        $this->url = (isset($responseError['url'])) ? $responseError['url'] : null;
        $this->method = (isset($responseError['method'])) ? $responseError['method'] : null;

        if (isset($responseError['errors'])) {
            foreach ($responseError['errors'] as $error) {
                $this->errors[] = new Error($error);
            }
        }

        parent::__construct($message);
    }


    // Builds an exception based on an error object
    public static function buildWithError($error)
    {
        $instance = new self($error->getMessage());
        return $instance;
    }

    // Builds an exception with the server response and joins all the errors
    public static function buildWithFullMessage($responseError)
    {
        $message = $responseError['message'] ?: ($responseError['error'] ?: "Unknown error");

        $instance =  new self($message, $responseError);
        return $instance;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getReturnCode()
    {
        return $this->returnCode;
    }
}
