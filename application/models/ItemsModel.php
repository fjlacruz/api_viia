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



	
  public function usuarios_guardar($arrayData)
  {
    extract($arrayData);

    $sql = "INSERT INTO t_usuarios (nombres, apellidos, rut,email,usuario,clave,telefono,rol) 
                          VALUES  ('{$nombres}','{$apellidos}','{$rut}','{$email}','{$usuario}','{$clave}','{$telefono}',{$rol})";
    $this->db->query($sql);
    //return 1;
    if ($this->db->affected_rows() > 0) {
      return 1;
    } else {
      return 0;
    }
  }















  public function consultar_usuario($usuario = false, $clave = false)
  {
    $parametros = get_defined_vars();
    $sql = "SELECT id_usuario,UPPER(nombres)as nombres,UPPER(apellidos) as apellidos, UPPER(usuario) as usuario,
        UPPER(correo) as correo,telefono,rol,estatus,DATE_FORMAT(fecha_registro,'%d-%m-%Y')as fecha_registro 
    from t_usuarios 
    where usuario='{$usuario}' and clave='{$clave}' and estatus='1'";
    $query = $this->db->query($sql);
    $result = $query->result();
    return $query->result();
    //SELECT cedula,p_nombre,p_apellido,rol,id_usuario from t_usuarios where usuario='admin' and clave='00096995e9369076a898930cadb2c1f9' and estatus=1 
  }

  public function existe_correo($correo)
  {
    $sql = "SELECT * from t_usuarios where correo = '{$correo}'";
    $query = $this->db->query($sql);
    $result = $query->result();
    //print_r($result);
    //exit;
    if (isset($result[0])) {
      return "1";
    } else {
      return "0";
    }
  }
  public function existe_correo_recuperar($correo)
  {
    $sql = "SELECT * from t_usuarios where correo = '{$correo}'";
    $query = $this->db->query($sql);
    $result = $query->result();
    //print_r($result);
    //exit;
    if (isset($result[0])) {
      return "1";
    } else {
      return "0";
    }
  }
  public function existe_usuario($cedula)
  {
    $sql = "SELECT * from t_usuarios where cedula = '{$cedula}'";
    $query = $this->db->query($sql);
    $result = $query->result();
    //print_r($result);
    //exit;
    if (isset($result[0])) {
      return "1";
    } else {
      return "0";
    }
  }
}
