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
        if (!is_dir($this->config['lw_simplefile']['dir'].$this->id.'/')) {
            return false;
        }
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
    
    function getMaxUploadSize()
    {
        $maxpost = ini_get('post_max_size');
        $maxfile = ini_get('upload_max_filesize');
        if ($maxpost > $maxfile) {
            $maxsize = $maxfile;
        }
        else {
            $maxsize = $maxpost;
        }
        return $maxsize;
    }
    
    function return_bytes($val) 
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }    
}