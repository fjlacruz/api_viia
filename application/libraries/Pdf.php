<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdf {
    
    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'/libraries/mpdf/mpdf.php';
         
        if ($params == NULL)
        {
            $param = '';         
        }
         
        return new mPDF($param);
    }
}