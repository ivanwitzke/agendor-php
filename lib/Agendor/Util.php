<?php

class AgendorUtil
{
    public static function fromCamelCase($str)
    {
        $matches = null;
        if (preg_match_all('/(^|[A-Z])+([a-z]|$)*/', $str, $matches)) {
            $words = $matches[0];
            $words_clean = array();
            foreach ($words as $key => $word) {
                if (strlen($word) > 0) {
                    $words_clean[] = strtolower($word);
                }
            }
            return implode('_', $words_clean);
        } else {
            return strtolower($str);
        }
    }

    public static function isList($arr)
    {
        if (!is_array($arr)) {
            return false;
        }

        foreach (array_keys($arr) as $k) {
            if (!is_numeric($k)) {
                return false;
            }
        }
        return true;
    }

    public static function convertAgendorObjectToArray($object)
    {
        $output = array();
        foreach ($object as $key => $value) {
            if ($value instanceof AgendorObject) {
                $output[$key] = $value->__toArray(true);
            } else if (is_array($value)) {
                $output[$key] = self::convertAgendorObjectToArray($value);
            } else {
                $output[$key] = $value;
            }
        }
        return $output;
    }

    public static function convertToAgendorObject($response)
    {
        $types = array(
            'person' => 'AgendorPeople',
            'deal' => 'AgendorDeal',
            'organization' => 'AgendorOrganization',
            'task' => 'AgendorTask'
        );

        if (self::isList($response)) {
            $output = array();
            foreach ($response as $j) {
                array_push($output, self::convertToAgendorObject($j));
            }
            return $output;
        } else if (is_array($response)) {
            $objectName = self::getObjectName($response);
            if (isset($objectName) && is_string($objectName) && isset($types[$objectName])) {
                $class = $types[$objectName];
            } else {
                $class = 'AgendorObject';
            }

            return AgendorObject::build($response, $class);
        } else {
            return $response;
        }
    }

    public function getObjectName($response)
    {
        if (is_array($response)) {
            foreach ($response as $key => $value) {
                if (preg_match('/^([a-zA-Z]+)Id$/', $key, $matches)) {
                    return $matches[1];
                }
            }
        }
        return null;
    }
}
