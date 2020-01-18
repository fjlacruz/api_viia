<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('email');
		$this->load->model('Consultas_usuarios_model');
		$this->load->model('ItemsModel');
        $this->load->library('Configemail');
        $this->load->library('user_agent');
    }
    //============funcion para loguear usuarios=======================//
    function userLogin()
    {
        $rut = $this->input->post('rut');
        $clave = md5($this->input->post('clave'));
  
        $user = $this->Consultas_usuarios_model->loguear($rut, $clave);
        foreach ($user as $resultado) {
            $id_usuario =  $resultado->id_usuario;
            $nombres =  $resultado->nombres;
            $apellidos =  $resultado->apellidos;
            $rut =  $resultado->rut;
            $usuario =  $resultado->usuario;
            $email =  $resultado->email;
            $clave =  $resultado->clave;
            $token =  $resultado->token;
            $rol =  $resultado->rol;
            $telefono = $resultado->telefono;
        }
        // en caso de existir los datos del usuario se genera el token para el acceso
        if ($user) {
            $token = sha1(rand(0000, 9999));
            $up = $this->Consultas_usuarios_model->actualizarToken($id_usuario, $token);
            if ($up == 1) {
                echo json_encode(array('token' => $token, 'res' => 'success'));
            }
        } else {
            echo json_encode(array('token' => '', 'res' => 'fail'));
        }
    }

    //====== funcion para cerrar la sesion del usuario==========//
    function logout()
    {
        extract($_GET);

        $userToken = $this->Consultas_usuarios_model->usuariosToken($token);

        foreach ($userToken as $resultado) {
            $id_usuario =  $resultado->id_usuario;
        }
        //se actualiza el token a NULL
        $up = $this->Consultas_usuarios_model->cancelarToken($id_usuario);
        if ($up == 1) {
            echo json_encode(array('res' => 'success'));
        } else {
            echo json_encode(array('res' => 'fail'));
        }
    }

    public function getUsers()
    {
        $token = $this->input->get('token');
        $buscar = $this->input->get('buscar'); // Variable que viene por get desde el buscador de usuarios
        $id_usuario = $this->input->get('id_usuario');
        $x = 1;
        if ($x == 1) {
            $usuarios =  $this->Consultas_usuarios_model->usuarios($token, $buscar, $id_usuario);
            echo json_encode(array('response' => $usuarios, 'estatus' => 'OK', 'code' => 200));
        } else {
            echo json_encode(array('response' => 'Acceso Restringido', 'code' => 404));
        }
	}
	
	public function getItems()
    {
        $modulo = $this->input->get('modulo');
        $items =  $this->ItemsModel->listarItems($modulo);
        echo json_encode(array('response' => $items, 'estatus' => 'OK', 'code' => 200));
        
    }


    public function cantidadUsuarios()
    {

        $cantUsuarios =  $this->Consultas_usuarios_model->cantidaDeusuarios();
        echo json_encode(array('response' => $cantUsuarios, 'estatus' => 'OK', 'code' => 200));
    }

    function editarUsuario()
    {

        extract($_POST);
    
        $confirmarClave = md5($this->input->post('confirmarClave'));//este campo solo viene de la vista de cambiar clave

        $up = $this->Consultas_usuarios_model->modificarUsuario($id_usuario, $nombres, $apellidos, $rut, $usuario, $email, $telefono, $rol, $estatus,$confirmarClave);
        if ($up==1) {
            echo json_encode(array('response' => 'success', 'estatus' => 'OK', 'code' => 200));
        } else {
            echo json_encode(array('response' => 'fail', 'estatus' => 'OK', 'code' => 404));
        }
    }
    public function registrar_usuario()
    {
        extract($_POST);

        $arrayData = array(
            'nombres' => strtoupper($nombres),
            'apellidos' => strtoupper($apellidos),
            'rut' => strtoupper($rut),
            'usuario' => strtoupper($usuario),
            'telefono' => $telefono,
            'email' => strtoupper($email),
            'rol' => $rol,
            'clave' => md5($rut) // se asigna por defecto el rut           
        );
        $guardar = $this->Consultas_usuarios_model->usuarios_guardar($arrayData);
        if ($guardar == 1) {
            echo json_encode(array('response' => 'success', 'estatus' => 'OK', 'code' => 200));
        } else {
            echo json_encode(array('response' => 'fail', 'estatus' => 'OK', 'code' => 404));
        }
    }

}
