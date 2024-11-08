<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuario extends Model {

    public function login($datos) {


        $db      = \Config\Database::connect();
        $builder = $db->table('usuario')->select('*')->where('Usuario', $datos['usuario'])->where('Clave', $datos['clave']);
        $res = $builder->get()->getRow();

        if(!isset($res)) {
            return 0;
        }
        
        $imagen = "perfil.png";
        if(isset($res->Imagen)) {
            $imagen = $res->Imagen;
        }
        
        $usuario = [
            "idUsuario" => $res->Id,
            "usuario" => $res->Usuario,
            "esAdmin" => $res->EsAdmin,
            "imagen" => $imagen
        ];
        
        return $usuario;
    }

    public function registro($datos) {


        $db      = \Config\Database::connect();

        $usuario = [
            'usuario'            => $datos['usuario'],
            'correo'             => $datos['correo'],
            'clave'              => $datos['clave'],
            'fechaNacimiento'    => $datos['fecha'],
        ];

        $edad = date_diff(date_create($usuario['fechaNacimiento']), date_create(date("Y-m-d")))->format('%y');
        if($edad < 13){
            return 'edad';
        }

        $builder = $db->table('usuario')->select('*')->where('Usuario', $usuario['usuario']);
        $res = $builder->get()->getRow();

        if(isset($res)) {
            return 'usuarioExiste';
        }

        $builder = $db->table('usuario')->select('*')->where('Correo', $usuario['correo']);
        $res = $builder->get()->getRow();

        if(isset($res)) {
            return 'correoExiste';
        }

        $builder = $db->table('usuario')->insert($usuario);
        // toda la ejecución de $db devuelve true o false según resulte el sql por lo que se puede usar
        // $builder para comprobarlo

        $id = $db->insertID();

        if(!$builder) {
            return 'errorSql';
        }

        
        
        $usuario = [
            "idUsuario" => $id,
            "usuario" => $usuario['usuario'],
            "esAdmin" => 0,
            "imagen" => 'perfil.png'
        ];
        
        return $usuario;
    }

    public function getPerfil($idUsuario) {
        $perfil = [];
        if($idUsuario > 0) {
            $db      = \Config\Database::connect();
            $builder = $db->table('usuario')->select('*')->where('Id', $idUsuario);
            $res = $builder->get()->getRow();
            $imagen = $res->Imagen;
            if(!isset($res->Imagen)) $imagen = 'perfil.png';
            $perfil = [
                'idUsuario' => $res->Id,
                'nombre' => $res->Nombre,
                'apellidos' => $res->Apellidos,
                'usuario' => $res->Usuario,
                'correo' => $res->Correo,
                'fecha' => $res->FechaNacimiento,
                'imagen' => $imagen,
                'descripcion' => $res->Descripcion,
            ];
        }
        // $perfil puede tener campos en NULL pero eso es para la gente que no ha rellenado esos campos, 
        // hay que comprobarlo en la vista para saber si mostrar algo o no
        return $perfil;
    }

    public function actualizarPerfil($data) {

        $datos = [
            'Nombre' => $data['nombre'],
            'Apellidos' => $data['apellidos'],
            'Usuario' => $data['usuario'],
            'Correo' => $data['correo'],
            'FechaNacimiento' => $data['fecha'],
            'Descripcion' => $data['descripcion'],
        ];

        if(isset($data['nombreImagen'])) {
            $datos['Imagen'] = $data['nombreImagen'];
        }

        
        $db      = \Config\Database::connect();
        $builder = $db->table('usuario');
        $builder->update($datos, 'Id = '.$data['idUsuario']);

        return $builder;

    }

    public function actualizarClave($data) {


        $db      = \Config\Database::connect();
        $builder = $db->table('usuario')->select('*')->where('Id', $data['idUsuario'])->where('Clave', $data['claveAct']);
        $res = $builder->get()->getRow();

        if(!isset($res)) {
            return 0;
        }

        $datos = [
            'clave' => $data['clave']
        ];
        $builder = $db->table('usuario');
        $builder->update($datos, 'Id = '.$data['idUsuario']);

        return $builder;

    }

    // Posiblemente no necesite esta funcion dado que no la puedo llamar en la vista
    public function getImagen($idUsuario) {
        if($idUsuario > 0) {
            $db      = \Config\Database::connect();
            $builder = $db->table('usuario')->select('Imagen')->where('Id', $idUsuario);
            $res = $builder->get()->getRow();
            if($res['Imagen'] != ''){
                return $res['Imagen'];
            } else {
                return 'perfil';
            }
            
        }
        return 'perfil';
    }
}