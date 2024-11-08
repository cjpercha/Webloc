<?php

namespace App\Controllers;
use App\Models\Usuario;

class Login extends BaseController
{
    public function iniciarSesion(): string
    {
        
        $reglas = [
            'usuario' => ['required', 'max_length[255]'],
            'clave' => ['required', 'max_length[255]']
        ];

        $mensaje_error = [
            'usuario' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
            ],
            'clave' => [
                'required' => 'Este campo es obligatorio',
                'max_length' => 'El valor introducido es demasiado grande',
            ]
        ];

        $validations = $this->validate($reglas, $mensaje_error);

        if(!$validations) {
            
            return view('login.php', ['validation' => $this->validator]);

        } else {

            $form_data = $this->request->getPost();

            $usuario = new Usuario();

            $usuario = $usuario->login($form_data);

            if($usuario == 0) {
                return view('login.php', ['error' => 'Los datos de acceso son incorrectos']);
            }

            $session = \Config\Services::session();
            $session->set($usuario);

            return view('inicio.php');

        }
        
    }

    public function registro(): string
    {
        
        $reglas = [
            'usuario' => ['required', 'max_length[255]'],
            'correo' => ['required', 'max_length[255]'],
            'clave' => ['required', 'max_length[255]', 'min_length[1]'], //ACTUALIZAR EL MINIMO EN LAS CONTRASEÑAS AGUACATE
            'clave2' => ['required', 'max_length[255]', 'min_length[1]','matches[clave]'], //ACTUALIZAR EL MINIMO EN LAS CONTRASEÑAS AGUACATE
            'fecha' => ['required'],
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
            ],
            'fecha' => [
                'required' => 'Este campo es obligatorio'
            ]
        ];

        $validations = $this->validate($reglas, $mensaje_error);

        if(!$validations) {
            
            return view('registro.php', ['validation' => $this->validator]);

        } else {

            $form_data = $this->request->getPost();

            
            $registro = new Usuario();

            $usuario = $registro->registro($form_data);

            switch($usuario){
                case 'usuarioExiste':
                    return view('registro.php', ['error' => 'Ese nombre de usuario ya está en uso']);
                    break;
                case 'correoExiste':
                    return view('registro.php', ['error' => 'Ese correo ya está en uso']);
                    break;
                case 'edad':
                    return view('registro.php', ['error' => 'Debes de tener al menos 13 años']);
                    break;
                case 'erroSql':
                    return view('registro.php', ['error' => 'Ha ocurrido un error al crear el usuario']);
                    break;
                // Si es correcto no tengo que devolver la cadena tengo que devolver el usuario para guardarlo en cache y redirigirlo al incio
                default: 
                    $session = \Config\Services::session();
                    $session->set($usuario);
                    return view('inicio.php');
                    break;
            }

        }
        
    }

    public function cerrarSesion()
    {
        unset(
            $_SESSION['idUsuario'],
            $_SESSION['usuario'],
            $_SESSION['esAdmin'],
        );
        return redirect()->to('Usuarios/inicio'); 
        return view('inicio.php');
    }
}
