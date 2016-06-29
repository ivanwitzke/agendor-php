<?php

class AgendorTask extends AgendorModel
{
    public function setId($value)
    {
        $this->_attributes["taskId"] = $value;
        $this->_unsavedAttributes->add("taskId");
    }

    public function getId()
    {
        if (array_key_exists("taskId", $this->_attributes)) {
            return $this->_attributes["taskId"];
        } else {
            return null;
        }
    }
}
