<?php

class sf_base extends lw_object
{
    function __construct()
    {

    }
    
    public function setID($id)
    {
        $this->id = base64_encode($id);
    }
    
    public function setIntranet($id)
    {
        $this->intranet = intval($id);
    }

    public function getOutput()
    {
        return $this->output;
    }
}