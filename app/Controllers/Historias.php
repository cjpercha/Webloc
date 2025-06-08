<?php

namespace App\Controllers;
use App\Models\Historia;
use App\Models\Usuario;

class Historias extends BaseController
{

    public function editar($idHistoria = 0)
    {

        $historiaM = new Historia();

        $categorias = $historiaM->getCategorias();
        
        //Cargar aqui los datos de la historia y mandarlo de vuelta como en editar perfil
        if($idHistoria == 0) {

            return view('editarHistoria.php', ['accion' => 'nuevo', 'categorias' => $categorias]);

        }

        //$historia = '';
        $historia = $historiaM->getHistoria($idHistoria);

        return view('editarHistoria.php', ['accion' => 'editar', 'categorias' => $categorias, 'historia' => $historia]);
    }

    public function configurar($idHistoria) // Cambiar esto para historia
    {
        // Mandar los datos del usuario para que se carguen en el form

        $historiaM = new Historia();

        $historia = $historiaM->getHistoria($idHistoria);

        return view('editarHistoria.php', ['historia' => $historia]);
    }  
    
    public function actualizar() // Creo que no es necesario mandar el id porque lo podré sacar del formulario
    {
        
        $historiaM = new Historia();

        $form_data = $this->request->getPost();

        $reglas = [
            'titulo' => ['required', 'max_length[255]'],
            //'categorias' => ['required'],
            'descripcion' => ['required', 'max_length[255]'],
            'imagen' => [
                //'uploaded[imagen]',  // Equivalente a required
                'is_image[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,2048]',
                'max_dims[imagen,1024,1024]',
                ]            
        ];

        $mensaje_error = [
            'titulo' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
            ],
            'categorias' => [
                'required' => 'Debe marcar alguna categoria'
            ],
            'descripcion' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande'
            ],
            'imagen' => [
                // 'uploaded' => 'La imagen es requerida',
                'is_image' => 'Debe introducir una imagen',
                'mime_in' => 'El formato de la imagen no es correcto. Los admitidos son jpg, jpeg y png',
                'max_size' => 'La imagen es demasiado grande. Tamaño máximo 2 megabytes',
                'max_dims' => 'Las dimensiones máximas de la imagen son 1024x1024',
            ],
        ];

        $validations = $this->validate($reglas, $mensaje_error);

        //$form_data = $this->request->getPost();
        $idUsuario = $form_data['IdAutor']; //Esto no se si lo necesitare. También puedo meterlo como idAutor
             

        if(!$validations) {

            $usuario = new Usuario();
            $perfil = $usuario->getPerfil($idUsuario); // Cambiar por Historia
            $categorias = $historiaM->getCategorias();
            $historia = ['titulo' => $form_data['titulo'],
                        'descripcion' => $form_data['descripcion']
                    ];
            $idAutor = $form_data['IdAutor'];
            $data = [
                    'historia' => $historia, // Si no funciona tengo que 'construir la historia' y mandarla
                    'validation' => $this->validator,
                    'accion' => 'editar',
                    'categorias' => $categorias
                ];
            return view('editarHistoria.php', $data);

        } else {

            // Compruebo si se ha subido una imagen y guardo el nombre asignado
            $img = $this->request->getFile('imagen');
            $nombreImagen = '';
            $idHistoria = $form_data['idHistoria'];
            if($img->isValid()){
                $ext = $img->getClientExtension();
                $nombreImagen = 'portada_'.$idHistoria.'.'.$ext;// Tengo que cambiar como se guardan las portadas
                $form_data['nombreImagen'] = $nombreImagen;
            }
            $actualizacion = '';
            if($form_data['accion'] == 'Crear historia') {
                $actualizacion = $historiaM->crearHistoria($form_data);
            } else {
                $actualizacion = $historiaM->actualizarHistoria($form_data);
            }
            
            // Esto está mal, tendría que sacar el ide de la historia, porque el id usuario es el autor
            //$historia = $historia->getHistoria($idUsuario);

            $historia = [];

            /*if(!$actualizacion){
                if($form_data['accion'] == 'Crear historia') {
                return view('editarHistoria.php', ['accion' => 'nuevo', 'error1' => 'Ha ocurrido un error al crear la historia']);
                } else {
                    $historia = $historiaM->getHistoria($idHistoria);
                    return view('editarHistoria.php', ['accion' => 'editar', 'historia' => $historia, 'error1' => 'Ha ocurrido un error al actualizar la historia']);
                }
            } else {
                $historia = $historiaM->getHistoria($idHistoria);
                return view('editarHistoria.php', ['accion' => 'editar', 'historia' => $historia, 'conf1' => 'Se ha actualizado la historia']);
            }*/

            $usuarioM = new Usuario();
            $perfil = $usuarioM->getPerfil($idUsuario);
            $historias = $historiaM->getHistoriasUsuario($idUsuario);
            $categorias = $historiaM->getCategorias();
            
            return view('perfil.php', ['perfil' => $perfil, 'historias' => $historias, 'categorias' => $categorias]);
        }
    }

    
}
