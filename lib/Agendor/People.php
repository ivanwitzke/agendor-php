<?php
namespace Agendor;

class People extends Model
{
    public function setId($value)
    {
        $this->_attributes["personId"] = $value;
        $this->_unsavedAttributes->add("personId");
    }

    public function getId()
    {
        if (array_key_exists("personId", $this->_attributes)) {
            return $this->_attributes["personId"];
        } else {
            return null;
        }
    }
}
