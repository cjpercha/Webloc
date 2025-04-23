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

    public function getHistoria($idHistoria) {
        $historia = [];
        if($idHistoria > 0) {
            $db      = \Config\Database::connect();
            $builder = $db->table('historia')->select('*')->where('Id', $idHistoria);
            $res = $builder->get()->getRow();
            $imagen = $res->Portada;
            if(!isset($res->Portada)) $imagen = 'perfil.png';
            // AÑADIR CATEGORIAS
            $historia = [
                'idHistoria' => $res->Id,
                'titulo' => $res->Titulo,
                'fechaPublicacion' => $res->FechaPublicacion,
                'descripcion' => $res->Descripcion,
                'estado' => $res->Estado,
                'idAutor' => $res->idAutor,
                'puntuacion' => $res->Puntuacion,
                'imagen' => $imagen,
            ];
        }
        // $perfil puede tener campos en NULL pero eso es para la gente que no ha rellenado esos campos, 
        // hay que comprobarlo en la vista para saber si mostrar algo o no
        return $historia;
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

    public function actualizarHistoria($data) {

        $datos = [
            'Titulo' => $data['titulo'],
            'FechaPublicacion' => $data['fechaPublicacion'],
            'Descripcion' => $data['descripcion'],
            'Estado' => $data['estado'],
            'Puntuacion' => $data['puntuacion'],
        ];

        //Categorias

        if(isset($data['nombreImagen'])) {
            $datos['Imagen'] = $data['nombreImagen'];
        }

        
        $db      = \Config\Database::connect();
        $builder = $db->table('historia');
        $builder->update($datos, 'Id = '.$data['idHistoria']);

        return $builder;

    }
}