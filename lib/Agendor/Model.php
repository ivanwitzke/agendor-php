<?php

class AgendorModel extends AgendorObject
{
    protected static $root_url;

    public function __construct($response = array())
    {
        parent::__construct($response);
    }

    public static function getUrl()
    {
        $class = get_called_class();
        $search = preg_match("/Agendor(.*)/", $class, $matches);
        if (!preg_match("/people/i", $matches[1])) {
            return '/'. strtolower($matches[1].'s');
        }
        return '/'. strtolower($matches[1]);
    }

    public function create()
    {
        try {
            $request = new AgendorRequest(self::getUrl(), 'POST');
            $parameters = $this->__toArray(true);
            $request->setParameters($parameters);
            $response = $request->run();
            return $this->refresh($response);
        } catch (Exception $e) {
            throw new AgendorException($e->getMessage());
        }
    }

    public function save()
    {
        try {
            if (method_exists(get_called_class(), 'validate')) {
                if (!$this->validate()) {
                    return false;
                }
            }
            $request = new AgendorRequest(self::getUrl(). '/' . $this->id, 'PUT');
            $parameters = $this->unsavedArray();
            $request->setParameters($parameters);
            $response = $request->run();
            return $this->refresh($response);
        } catch (Exception $e) {
            throw new AgendorException($e->getMessage());
        }
    }


    public static function findById($id)
    {
        $request = new AgendorRequest(self::getUrl() . '/' . $id, 'GET');
        $response = $request->run();
        $class = get_called_class();
        return new $class($response);
    }

    public static function all($page = 1, $count = 10)
    {
        $request = new AgendorRequest(self::getUrl(), 'GET');
        $request->setParameters(array("page" => $page, "per_page" => $count));
        $response = $request->run();
        $return_array = array();
        $class = get_called_class();
        foreach ($response as $r) {
            $return_array[] = new $class($r);
        }

        return $return_array;
    }
}
