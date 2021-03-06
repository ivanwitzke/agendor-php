<?php
namespace Ivanwitzke\Agendor;

class Deal extends Model
{
    public function setId($value)
    {
        $this->_attributes["dealId"] = $value;
        $this->_unsavedAttributes->add("dealId");
    }

    public function getId()
    {
        if (array_key_exists("dealId", $this->_attributes)) {
            return $this->_attributes["dealId"];
        } else {
            return null;
        }
    }
}
