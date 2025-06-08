<?php

namespace App\Models;

use CodeIgniter\Model;

class Historia extends Model {

    public function getCategorias() {
        $db      = \Config\Database::connect();
        $builder = $db->table('categoria')->select('*');
        $res = $builder->get()->getResult();
        $categorias =[];

        foreach($res as $categoria) {

            $categorias[$categoria->Id] = $categoria->Nombre;

        }
        
        return $categorias;
    }

    public function getNombreCategoria($idCategoria) {
        $db      = \Config\Database::connect();
        $builder = $db->table('categoria')->select('Nombre');
        
        $nombre = $builder->where('Id', $idCategoria)->get()->getRow();

        return $nombre ? $nombre->Nombre : FALSE;
    }

    public function getCategoriasHistoria($idHistoria) {
        $db      = \Config\Database::connect();
        $builder = $db->table('categoriaHistoria')->select('IdCategoria');

        $categorias = [];
        $res = $builder->where('IdHistoria', $idHistoria)->get();

        foreach ($res->getResult() as $row) {
            $categorias[] = $row->IdCategoria;
        }

        return $categorias;
    }

    public function getNombreCategoriasHistoria($idHistoria) {
        $db      = \Config\Database::connect();
        $builder = $db->table('categoriaHistoria')->select('IdCategoria');

        $categorias = [];
        $res = $builder->where('IdHistoria', $idHistoria)->get();

        foreach ($res->getResult() as $row) {
            $categorias[] = $this->getNombreCategoria($row->IdCategoria);
        }

        return $categorias;
    }



    public function getHistoria($idHistoria) {
        $historia = [];
        if($idHistoria > 0) {
            $db      = \Config\Database::connect();
            $builder = $db->table('historia')->select('*')->where('Id', $idHistoria);
            $res = $builder->get()->getRow();

            if (!$res) return $historia;

            $imagen = isset($res->Portada) ? $res->Portada : 'portada.png';
            $categorias = $this->getCategoriasHistoria($idHistoria);
            $historia = [
                'idHistoria' => $idHistoria,
                'titulo' => $res->Titulo,
                'fechaPublicacion' => $res->FechaPublicacion,
                'descripcion' => $res->Descripcion,
                'estado' => $res->Estado,
                'IdAutor' => $res->IdAutor,
                'puntuacion' => $res->Puntuacion,
                'imagen' => $imagen,
                'categorias' => $categorias
            ];
        }
        return $historia;
    }

    public function getHistoriasUsuario($idUsuario) {
        $historias = [];
        if ($idUsuario > 0) {
            $db      = \Config\Database::connect();
            $builder = $db->table('historia')->select('*')->where('IdAutor', $idUsuario);
            $res = $builder->get()->getResult();

            if (!$res) return $historias;

            foreach ($res as $row) {
                $imagen = isset($row->Portada) ? $row->Portada : 'portada.png';
                $categorias = $this->getCategoriasHistoria($row->Id);
                $historias[] = [
                    'idHistoria' => $row->Id,
                    'titulo' => $row->Titulo,
                    'fechaPublicacion' => $row->FechaPublicacion,
                    'descripcion' => $row->Descripcion,
                    'estado' => $row->Estado,
                    'IdAutor' => $row->IdAutor,
                    'puntuacion' => $row->Puntuacion,
                    'imagen' => $imagen,
                    'categorias' => $categorias
                ];
            }
        }
        return $historias;
    }


    public function crearHistoria($data) {

        $fecha = date("Y-m-d H:i:s");

        $historia = [
            'Titulo' => $data['titulo'],
            'FechaPublicacion' => $fecha,
            'Descripcion' => $data['descripcion'],
            'Estado' => 'En progreso',
            'Puntuacion' => 0,
            'IdAutor' => $data['IdAutor']
        ];

        if(isset($data['nombreImagen'])) {
            $datos['Imagen'] = $data['nombreImagen'];
        }


        $db      = \Config\Database::connect();
        $db->transStart();

        
        $builder = $db->table('historia');

        $builder->insert($historia);

        $id = $db->insertID();

        $builder = $db->table('categoriaHistoria');
        foreach ($data['categoria'] as $idCategoria){
            
            $insert = [
            'idCategoria' => $idCategoria,
            'idHistoria' => $id,
            ];
            $builder->insert($insert);
        }

        $db->transComplete();

        if($db->transStatus()){
            return $id;
        } else {
            return $db->transStatus();
        }
    }

    public function actualizarHistoria($data) {

        $fecha = date("Y-m-d H:i:s");
        $id = $data['idHistoria'];

        $datos = [
            'Titulo' => $data['titulo'],
            'FechaPublicacion' => $fecha,
            'Descripcion' => $data['descripcion'],
            'Estado' => 'En progreso',
            'Puntuacion' => 0,
        ];

        if(isset($data['nombreImagen'])) {
            $datos['Imagen'] = $data['nombreImagen'];
        }

        //var_dump($data);die;

        $db      = \Config\Database::connect();
        $db->transStart();

        $builder = $db->table('historia');
        $builder->update($datos, 'Id = '.$data['idHistoria']);

        $builder = $db->table('categoriaHistoria');
        $builder->where('idHistoria', $id)->delete();
        if(isset($data['categoria'])) {
            foreach ($data['categoria'] as $idCategoria){
                
                $insert = [
                'idCategoria' => $idCategoria,
                'idHistoria' => $id,
                ];
                $builder->insert($insert);
            }
        }

        $db->transComplete();

        if($db->transStatus()){
            return $data['idHistoria'];
        } else {
            return $db->transStatus();
        }
        

    }
}