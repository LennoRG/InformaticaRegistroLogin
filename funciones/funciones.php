<?php

//funcion para enviar email
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function phpMailer($email, $usuario){
        require_once('vendor/PHPMailer/src/Exception.php');
        require_once('vendor/PHPMailer/src/PHPMailer.php');
        require_once('vendor/PHPMailer/src/SMTP.php');

        $mail = new PHPMailer(true);

        try{
            //Servidor mailjet
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'in-v3.mailjet.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'e4102e053198213e7724c2f13a31854f';
            $mail->Password = 'ca3237301a230697a54809b3d5247065';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Usuarios
            $mail->setFrom('elenoramirez20@gmail.com', 'InformaticaITCH.com');
            $mail->addAddress($email, $usuario);

            //Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenido a la Plataforma de Ingenieria Informatica del Instituto Tecnologico de Chilpancingo</b>.';
            $mail->Body = 'Gracias por Registrarte. Ahora ya formas parte de nuestra gran <b>Comunidad</b>';
            $mail->AltBody = 'Gracias por Registrarte. Ahora ya formas parte de nuestra gras Comunidad';

        $mail->send();
        }catch (Exception $e) {
            echo 'El mensaje no pudo ser enviado: '.$mail->ErrorInfo;
        }

    } 



//funciones
    function registro(){
        require_once('Recursos/conexion.php');
        $errores = duplicacion($con);

        if(!empty($errores)){
            return $errores;
        }

        $nombre = limpiar($_POST['nombre']);
        $apellidos = limpiar($_POST['apellidos']);
        $usuario = limpiar($_POST['usuario']);
        $email = limpiar($_POST['email']);
        $carrera = limpiar($_POST['carrera']);
        $numControl = limpiar($_POST['numControl']);
        $password = limpiar($_POST['password']);

        $declaracion = $con -> prepare("INSERT INTO `usuarios` (`Nombre`, `Apellidos`, `Usuario`, `Email`, `Carrera`, `NunControl`, `Password`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $declaracion -> bind_param("sssssis", $nombre, $apellidos, $usuario, $email, $carrera, $numControl, password_hash($password, PASSWORD_DEFAULT));
        $declaracion -> execute();
        $resultado = $declaracion -> affected_rows;
        $declaracion -> free_result();
        $declaracion -> close();
        $con -> close();

        if($resultado == 1){
            $_SESSION['usuario'] = $usuario;
            header('Location: index.php');
            phpMailer($email, $usuario);


        }
        else{
            $errores[] = 'Problemas Tecnicos... Por Favor Intentalo Mas Tarde.';
        }

        return $errores;

    }

    function duplicacion($con){
        $errores = [];

            $usuario = limpiar($_POST['usuario']);
            $email = limpiar($_POST['email']);

            $declaracion = $con -> prepare("SELECT `Usuario`, `Email` FROM `usuarios` WHERE `Usuario` = ? OR `Email` = ?");
            $declaracion -> bind_param("ss", $usuario, $email);
            $declaracion -> execute();
            $resultado = $declaracion -> get_result();
            $cantidad = mysqli_num_rows($resultado);
            $linea = $resultado -> fetch_assoc();
            $declaracion -> free_result();
            $declaracion -> close();

            if($cantidad > 0){
                if($_POST['usuario'] == $linea['Usuario']){
                    $errores[] = 'EL NOMBRE DE USUARIO ya existe';
                }
                if($_POST['email'] == $linea['Email']){
                    $errores[] = 'EL CORREO ELECTRONICO ya existe';
                }


            }

            return $errores;

        
    }

    function login(){
        require_once('Recursos/conexion.php');
        $errores = [];

            $usuario = limpiar($_POST['usuarioOEmail']);
            $password = limpiar($_POST['password']);

            $declaracion = $con -> prepare("SELECT `Usuario`, `Password`, `Intentos`, `id`, `Tiempo` FROM `usuarios` WHERE `Usuario` = ? OR `Email` = ?");
            $declaracion -> bind_param("ss", $usuario, $usuario);
            $declaracion -> execute();
            $resultado = $declaracion -> get_result();
            $cantidad = mysqli_num_rows($resultado);
            $linea = $resultado -> fetch_assoc();
            $declaracion -> free_result();
            $declaracion -> close();
            

            if($cantidad == 1){

                $errores = fuerzaBruta($con, $linea['Intentos'], $linea['id'], $linea['Tiempo']);
                if(!empty($errores)){ return $errores;}



                if(password_verify($password, $linea['Password'])){
                    $intento = 0;
                    $tiempo = NULL;
                    $id = $linea ['id'];
                    $declaracion = $con -> prepare("UPDATE `usuarios` SET `Intentos` = ?, `Tiempo` = ? WHERE `id` = ?");
                    $declaracion -> bind_param("isi", $intento, $tiempo, $id);
                    $declaracion -> execute();
                    $declaracion -> close();
                    
                    $_SESSION['usuario'] = $linea['Usuario'];
                    header('Location: index.php');
                    
                }
                else{
                    $errores[] = 'NOMBRE DE USUARIO Y CONTRASEÑA NO SON VALIDOS.';
                }


            }
            else{
                $errores[] = 'NOMBRE DE USUARIO Y CONTRASEÑA NO SON VALIDOS.';
            }

            return $errores;

        
    }

    function fuerzaBruta($con, $intento, $id, $tiempo){
        $errores = [];
        $intento = $intento + 1;
        
        $declaracion = $con -> prepare("UPDATE `usuarios` SET `Intentos` = ? WHERE `id` = ?");
        $declaracion -> bind_param("ii", $intento, $id);
        $declaracion -> execute();
        $declaracion -> close();

        if($intento == 5){

            $ahora = date('Y-m-d H:i:s');

            $declaracion = $con -> prepare("UPDATE `usuarios` SET `Tiempo` = ? WHERE `id` = ?");
            $declaracion -> bind_param("si", $ahora, $id);
            $declaracion -> execute();
            $declaracion -> close();
            $errores[]= 'Esta Cuenta ha sido bloqueada por los proximos 15 minutos.';
        }
        elseif($intento > 5){
           // 900 son los segundos en 15 minutoos
            $espera = strtotime(date('Y-m-d H:i:s')) - strtotime($tiempo);
            $minutos = ceil(900-$espera)/60;


            if($espera < 900){
                $errores[] = 'Esta Cuenta ha sido bloqueada por los proximos '.$minutos.' minutos.';
            }
            else{
                $intento = 1;
                $tiempo = NULL;
                $declaracion = $con -> prepare("UPDATE `usuarios` SET `Intentos` = ?, `Tiempo` = ? WHERE `id` = ?");
                $declaracion -> bind_param("isi", $intento, $tiempo, $id);
                $declaracion -> execute();
                $declaracion -> close();

            }

        }
    

        
        return $errores;
    }


    function limpiar($datos){
         $datos = trim($datos);
         $datos = stripslashes($datos);
         $datos = htmlspecialchars($datos);
         return $datos;

     }

     function mostrarErrores($errores){
         $resultado = '<div class="alert alert-danger errores"><ul>';
         foreach($errores as $error){
             $resultado .= '<li>' . htmlspecialchars($error) . '</li>';
         }
         $resultado .= '</ul></div>';
         return $resultado;
     }

     function ficha_csrf(){
         $ficha = bin2hex(random_bytes(32));
         return $_SESSION['ficha'] = $ficha;
     }

     function validar_ficha($ficha){
         if(isset($_SESSION['ficha']) && hash_equals($_SESSION['ficha'], $ficha)){
             unset($_SESSION['ficha']);
             return true;

         }
         return false;
     }
     
     function validar($campo){
         $errores = [];
         foreach($campo as $nombre => $mostrar){
             if(!isset($_POST[$nombre]) || $_POST[$nombre] == NULL){
                 $errores[] = $mostrar . ' Campo Requerido.';

             }
             else{
                 $valides = campo();
                 foreach($valides as $campo => $opcion){
                     if($nombre == $campo){
                         if(!preg_match($opcion['patron'], $_POST[$nombre])){
                             $errores[] = $opcion['error'];

                         }

                     }

                 }
             }

         }

         return $errores;

     }
     
     
     function campo(){
         $validacion = [
             'nombre' => [
                 'patron' => '/^[a-z\s]{2,45}$/i',
                 'error' => 'NOMBRES solo puede usar letras y espacios de 2 a 45 caracteres.'             
             ],
             'apellidos' => [
                'patron' => '/^[a-z\s]{2,45}$/i',
                'error' => 'APELLIDOS solo puede usar letrar y espacios.'             
             ],
             'usuario' => [
                'patron' => '/^[a-z][\w]{2,45}$/i',
                'error' => 'NOMBRE de USUARIO solo puede usar letrar y espacios.'             
             ],
             'email' => [
                'patron' => '/^[a-z]+[\w\.]{2,}@([\w]{2,}\.)+[\w]{2,100}$/i',
                'error' => 'EL CORREO ELECTRONICO debe de ser en un formato valido.'             
             ],
             'carrera' => [
                'patron' => '/^[a-z\s\.]{2,45}$/i',
                'error' => 'CARRERA solo puede usar letrar y espacios.' 
             ],
             'numControl' => [
                'patron' => '/^[\w]{8}$/',
                'error' => 'NUMERO DE CONTROL solo acepta 8 caracteres numericos.' 
             ], 
             'password' => [
                'patron' =>  '/(?=^[\w\!@#\$%\^&\*\?]{8,30}$)(?=(.*\d){2,})(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,})(?=(.*[\|@#\$%\^&\*\?_]){2,})^.*/',
                'error' =>  'Por favor ingrese un PASSWORD validO.
                             El PASSWORD debe tener por lo menos 2 letras mayusculas, 2 letras minusculas, 2 numero y 2 simbolos.'
             ],

             'usuarioOEmail' => [
                'patron' =>  '/(?=^[a-z]+[\w@\.{2,50}$])/i',
                'error' =>  'Use NOMBRE DE USUARIO O CORREO ELCTRONICO Registrado.'
             ]

             
         ];
         return $validacion;

     }

     function comparadorDePass($password, $confPass){
         $errores = [];
         if($password !== $confPass){
             $errores[] = 'Las Contraseñas No Coninciden';

         }

         return $errores;
     }


?>