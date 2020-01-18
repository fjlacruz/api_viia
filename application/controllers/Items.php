<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Items extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
		$this->load->model('ItemsModel');
    }
 
	
	public function getItems()
    {
		$modulo = $this->input->get('modulo');
		$id_item = $this->input->get('id_item');
        $items =  $this->ItemsModel->listarItems($modulo,$id_item);
        echo json_encode(array('response' => $items, 'estatus' => 'OK', 'code' => 200));
        
    }

    function editarItem()
    {

        extract($_POST);
        $up = $this->ItemsModel->modificarItem($id_item, $descripcion, $cantidad);
        if ($up==1) {
            echo json_encode(array('response' => 'success', 'estatus' => 'OK', 'code' => 200));
        } else {
            echo json_encode(array('response' => 'fail', 'estatus' => 'OK', 'code' => 404));
        }
	}
	
	function eliminarItem()
    {

        $id_item = $this->input->get('id_item');
        $delete = $this->ItemsModel->eliminarItem($id_item);
     
    }


}
