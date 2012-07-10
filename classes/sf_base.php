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
    
    function fileExists()
    {
        $directory = lw_directory::getInstance($this->config['lw_simplefile']['dir'].$this->id.'/');
        $files = $directory->getDirectoryContents('file');
        
        if (count($files)==1) {
            return true;
        }
        return false;
    }
    
    function getFile()
    {
        $directory = lw_directory::getInstance($this->config['lw_simplefile']['dir'].$this->id.'/');
        $files = $directory->getDirectoryContents('file');
        return $files[0];
    }    
}