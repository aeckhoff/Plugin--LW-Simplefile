<?php

class sf_download extends sf_base
{
    function __construct()
    {
        $this->request = lw_registry::getInstance()->getEntry("request");
        $this->config = lw_registry::getInstance()->getEntry("config");
    }
    
    function execute()
    {
        if (!$this->fileExists()) {
            $this->output = "<!-- no file for -".base64_decode($this->id)."-  available -->";
            return;
        }
        
        switch($this->request->getAlnum("cmd".$this->id))
        {
            case "download":
                $this->output = $this->download();
                break;
            
            default:
                $this->output = $this->buildDownloadLink();
                break;
        }
    }
   
    function download() 
    {
        $filepath = $this->config['lw_simplefile']['dir'].$this->id.'/';
        $file = $this->getFile();
        
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/octet-stream");
        header("Content-disposition: attachment; filename=\"" . base64_decode($file->getName()) . "\"");
        readfile($filepath.$file->getName());
        exit();
    }

    function buildDownloadLink()
    {
        $action = lw_page::getInstance()->getUrl(array("cmd".$this->id=>"download"));
        $output = '<a href="'.$action.'">download</a>'.PHP_EOL;
        return $output;
    }
}