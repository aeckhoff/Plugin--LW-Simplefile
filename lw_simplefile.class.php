<?php

class lw_simplefile extends lw_plugin
{
    function __construct()
    {
        parent::__construct();
    }
    
    function buildPageOutput()
    {
        if (!lw_in_auth::getInstance()->isLoggedIn() && !lw_registry::getInstance()->getEntry("auth")->isLoggedIn()) {
            return "<!-- simplefile needs a logged in user -->";
        }
        
        include_once(dirname(__FILE__).'/classes/sf_base.php');
        
        if ($this->params['cmd']=="upload") {
            include_once(dirname(__FILE__).'/classes/sf_upload.php');
            $object = new sf_upload();
            
        }
        elseif($this->params['cmd']=="download") {
            include_once(dirname(__FILE__).'/classes/sf_download.php');
            $object = new sf_download();
        }
        else {
            return "<!-- cmd missing -->";
        }
        
        $object->setID($this->params['id']);
        $object->setIntranet($this->params['intranet']);
        $object->execute();
        return $object->getOutput();
    }
}