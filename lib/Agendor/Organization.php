<?php
namespace Agendor;

class Organization extends Model
{
    public function setId($value)
    {
        $this->_attributes["organizationId"] = $value;
        $this->_unsavedAttributes->add("organizationId");
    }

    public function getId()
    {
        if (array_key_exists("organizationId", $this->_attributes)) {
            return $this->_attributes["organizationId"];
        } else {
            return null;
        }
    }
}
