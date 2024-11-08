<?php

namespace App\Models;

use CodeIgniter\Model;

class Historia extends Model {

    public function getCategorias() {
        $perfil = [];
        $db      = \Config\Database::connect();
        $builder = $db->table('categoria')->select('*');
        $res = $builder->get()->getResult();
        $categorias =[];

        foreach($res as $categoria) {

            $categorias[$categoria->Nombre] = $categoria->Nombre;

        }
        
        return $categorias;
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
}