<?php

namespace App\Controllers;
use App\Models\Historia;

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

        //$historiaM = new Historia();

        $historia = '';
        //$historia = $historiaM->getPerfil($idHistoria);

        return view('editarHistoria.php', ['accion' => 'nuevo', 'categorias' => $categorias, 'historia' => $historia]);
    }

    public function perfil($idUsuario = '')
    {
        // Depende del usuario que lo visite podrá editar su perfil, seguir al usuario o solamente verlo
        // por lo que tengo que mandar al perfil que sea correspondiente

        $usuario = new Usuario();

        $perfil = $usuario->getPerfil($idUsuario);
        
        return view('perfil.php', ['perfil' => $perfil]);
    }

    public function configurar($idUsuario)
    {
        // Mandar los datos del usuario para que se carguen en el form

        $usuario = new Usuario();

        $perfil = $usuario->getPerfil($idUsuario);

        return view('configPerfil.php', ['perfil' => $perfil]);
    }

    public function actualizar() // Creo que no es necesario mandar el id porque lo podré sacar del formulario
    {
        
        $historiaM = new Historia();

        $form_data = $this->request->getPost();
        $reglas = [
            'titulo' => ['required', 'max_length[255]'],
            'correo' => ['required', 'max_length[255]'],
            'fecha' => ['required'],
            'nombre' => ['max_length[255]'],
            'apellidos' => ['max_length[255]'],
            'descripcion' => ['max_length[255]'],
            'imagen' => [
                //'uploaded[imagen]',  // Equivalente a required
                'is_image[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,2048]',
                'max_dims[imagen,1024,1024]',
                ]            
        ];

        $mensaje_error = [
            'usuario' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
            ],
            'correo' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
            ],
            'fecha' => [
                'required' => 'Este campo es obligatorio'
            ],
            'nombre' => [
                'max_length' => 'El valor introducido es demasiado grande',
            ],
            'apellidos' => [
                'max_length' => 'El valor introducido es demasiado grande',
            ],
            'descripcion' => [
                'max_length' => 'Ha superado el límite de caracteres.',
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
        //*

        $form_data = $this->request->getPost();
        //$idUsuario = $form_data['idUsuario']; //Esto lo saco de un hidden o de session. También puedo meterlo como idAutor
        
        var_dump($form_data);die;

        if(!$validations) {

            $perfil = $usuario->getPerfil($idUsuario);
            return view('configPerfil.php', ['perfil' => $perfil, 'validation' => $this->validator]);

        } else {

            // Compruebo si se ha subido una imagen y guardo el nombre asignado
            $img = $this->request->getFile('imagen');
            $nombreImagen = '';
            if($img->isValid()){
                $ext = $img->getClientExtension();
                $nombreImagen = 'perfil_'.$idUsuario.'.'.$ext;
                $form_data['nombreImagen'] = $nombreImagen;
            }

            $actualizacion = $usuario->actualizarPerfil($form_data);
            $perfil = $usuario->getPerfil($idUsuario);

            if(!$actualizacion){
                return view('configPerfil.php', ['perfil' => $perfil, 'error1' => 'Ha ocurrido un error al actualizar el perfil']);
            } else {
                
                if($img->isValid()){ // Si hay una imagen nueva y ha funcionado la actualización, guardo la imagen y actualizo
                    $_SESSION['imagen'] = $nombreImagen;
                    $resImg = $img->move('public/assets/imagen/perfil/', $nombreImagen, true);
                }
                $_SESSION['usuario'] = $form_data['usuario'];
                return view('configPerfil.php', ['perfil' => $perfil, 'conf1' => 'Se ha actualizado el perfil']);
            }
        }
    }

    public function actualizarClave() // Creo que no es necesario mandar el id porque lo podré sacar del formulario
    {
        
        $usuario = new Usuario();

        $reglas = [
            'claveAct' => ['required', 'max_length[255]'],
            'clave' => ['required', 'max_length[255]', 'min_length[1]'], //ACTUALIZAR EL MINIMO EN LAS CONTRASEÑAS AGUACATE
            'clave2' => ['required', 'max_length[255]', 'min_length[1]','matches[clave]'], //ACTUALIZAR EL MINIMO EN LAS CONTRASEÑAS AGUACATE
        ];

        $mensaje_error = [
            'claveAct' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
            ],
            'clave' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
                'min_length' => 'La contraseña debe tener al menos 10 caracteres',
            ],
            'clave2' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
                'min_length' => 'La contraseña debe tener al menos 10 caracteres',
                'matches' => 'Las contraseñas no coinciden',
            ]
        ];

        $validations = $this->validate($reglas, $mensaje_error);

        $form_data = $this->request->getPost();
        $idUsuario = $form_data['idUsuario'];

        if(!$validations) {

            $perfil = $usuario->getPerfil($idUsuario);
            return view('configPerfil.php', ['perfil' => $perfil, 'validation' => $this->validator]);

        } else {

            $actualizacion = $usuario->actualizarClave($form_data);

            $perfil = $usuario->getPerfil($idUsuario);
            if(!$actualizacion){
                return view('configPerfil.php', ['perfil' => $perfil, 'error2' => 'Ha ocurrido un error al actualizar la contraseña']);
            } else {
                return view('configPerfil.php', ['perfil' => $perfil, 'conf2' => 'Se ha actualizado la contraseña']);
            }
        }
    }
}
