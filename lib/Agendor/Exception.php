<?php
namespace W6\Agendor;

class AgendorException extends \Exception
{
    protected $url;
    protected $method;
    protected $return_code;
    protected $parameter_name;
    protected $type;
    protected $errors;

    // Builds with a message and a response from the server
    public function __construct($message = null, $response_error = null)
    {
        $this->url = (isset($response_error['url'])) ? $response_error['url'] : null;
        $this->method = (isset($response_error['method'])) ? $response_error['method'] : null;

        if (isset($response_error['errors'])) {
            foreach ($response_error['errors'] as $error) {
                $this->errors[] = new AgendorError($error);
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
    public static function buildWithFullMessage($response_error)
    {
        $message = $response_error['message'];

        $instance =  new self($message, $response_error);
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
        return $this->return_code;
    }
}
