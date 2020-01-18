<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class ItemsModel extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }


  public function listarItems($modulo=NULL,$id_item=NULL)
  {

    $query = "SELECT id_item, descripcion,cantidad,modulo,estatus
							FROM t_items";
							if($modulo!=NULL){
								$query.= " where";
								$query .= " modulo= {$modulo}";
							}

							if($id_item!=NULL){
								$query.= " where";
								$query .= " id_item= {$id_item}";
							}
   
   // print_r($query);
    $query = $this->db->query($query);

    return $query->result();
  }

  public function modificarItem($id_item, $descripcion, $cantidad)
  {
	$sql = "UPDATE  t_items set descripcion = '{$descripcion}', cantidad = '{$cantidad}' where id_item= {$id_item}";
    $query = $this->db->query($sql);
    if ($this->db->affected_rows() > 0) {
      return 1;
    } else {
      return 0;
    }
	}
	
	public function eliminarItem($id_item)
  {
		$this->db->where('id_item', $id_item);
    $this->db->delete('t_items');
  }


}
