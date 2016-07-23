<?php
namespace Agendor;

class Model extends Object
{
    protected static $root_url;

    public function __construct($response = array())
    {
        parent::__construct($response);
    }

    public static function getUrl()
    {
        $class_match = explode('\\', get_called_class());
        $class = isset($class_match[1]) ? $class_match[1] : $class_match[0];
        if (!preg_match("/people/i", $class)) {
            return '/'. strtolower($class.'s');
        }
        return '/'. strtolower($class);
    }

    public function create()
    {
        try {
            $request = new Request(self::getUrl(), 'POST');
            $parameters = $this->__toArray(true);
            $request->setParameters($parameters);
            $response = $request->run();
            return $this->refresh($response);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
            $request = new Request(self::getUrl(). '/' . $this->getId(), 'PUT');
            $parameters = $this->unsavedArray();
            $request->setParameters($parameters);
            $response = $request->run();
            return $this->refresh($response);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public static function findById($id)
    {
        $request = new Request(self::getUrl() . '/' . $id, 'GET');
        $response = $request->run();
        $class = get_called_class();
        return new $class($response);
    }

    public static function delete($id)
    {
        $request = new Request(self::getUrl() . '/' . $id, 'DELETE');
        $response = $request->run();
        return $response;
    }

    public static function all($page = 1, $count = 10)
    {
        $request = new Request(self::getUrl(), 'GET');
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
