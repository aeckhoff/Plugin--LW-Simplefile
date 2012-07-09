<?php

class sf_upload extends sf_base
{
    function __construct()
    {
        $this->request = lw_registry::getInstance()->getEntry("request");
        $this->config = lw_registry::getInstance()->getEntry("config");
    }
    
    function execute()
    {
        switch($this->request->getAlnum("cmd".$this->id))
        {
            case "upload":
                $ok = $this->checkUpload();
                if (!$ok) {
                    $this->output = $this->buildUploadform();    
                } else {
                    $this->saveFile();
                    $this->pageReload(lw_page::getInstance()->getUrl(array("cmd".$this->id=>"done")));
                }
                break;
                
            case "done":
                $this->output = $this->showDoneMessage();
                break;
            
            default:
                $this->output = $this->buildUploadform();
                break;
        }
    }
    
    function checkUpload() 
    {
        $fileArray = $this->request->getFileData('file');
        if (strlen(trim($fileArray['name'])) < 1) {
            $error = true;
            $this->errorMessage[] = "nofilename";
        }
        if ($fileArray['size'] < 1) {
            $error = true;
            $this->errorMessage[] = "filenosize";
        }
        if ($fileArray['size'] > 100000) {
            $error = true;
            $this->errorMessage[] = "filetoobig";
        }
        if (!$error) {
            $this->filename = base64_encode(trim($fileArray['name']));
            $this->tempname = trim($fileArray['tmp_name']);
            return true;
        }
        return false;
    }
    
    function saveFile() 
    {
        if ($this->config['lw_simplefile']['dir'] && is_dir($this->config['lw_simplefile']['dir']) && is_writable($this->config['lw_simplefile']['dir'])) {
            $directory = lw_directory::getInstance($this->config['lw_simplefile']['dir'].$this->id.'/');
            $directory->delete(true);
            mkdir($directory->getBasepath().$directory->getName());
            $directory->addFile($this->tempname, $this->filename);
            return true;
        }
        die($this->config['lw_simplefile']['dir']." not writeable");
    }
    
    function showDoneMessage() 
    {
        $output = "<div>Upload done!</div>";
        return $output;
    }
    
    function buildUploadform()
    {
        $action = lw_page::getInstance()->getUrl(array("cmd".$this->id=>"upload"));
        $output = '<form action="'.$action.'" method="POST" enctype="multipart/form-data">'.PHP_EOL;
        $output.= '    <div><input type="file" name="file" /></div>'.PHP_EOL;
        $output.= '    <div><input type="submit" name="save" /></div>'.PHP_EOL;
        $output.= '</form>'.PHP_EOL;
        if (count($this->errorMessage)>0) {
            foreach($this->errorMessage as $message) {
                $output.="<div>".$message."</div>".PHP_EOL;
            }
        }
        return $output;
    }
}