<?php

    session_start();
    require_once("funciones/funciones.php");
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ficha']) && validar_ficha($_POST['ficha'])){

        if(!empty($_POST['miel'])){ return header('Location: index.php'); }
        
    $campos = [
        
        'usuarioOEmail' => 'Nombre de Usuario o Correo Electronico',
        'password' => 'Contraseña'
        
    ];

    $errores = validar($campos);

    if(empty($errores)){
        $errores = login();

    }
    

}

    //session_start();
    //$_SESSION['usuario']="leno";
    $titulo = "Ingenieria Informatica ITCH | Login";
    require_once('parciales/arriba.php');
    require_once('parciales/navegacion.php');

?>


      <!--contenedor principal (cuerpo de la pagina)-->
      <div class="container" id="pagina-login">
      <div class="row">
              <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

              <h1 class="titulo-de-pagina">Login</h1>

             <hr>

             <?php 
                  if(!empty($errores)){
                      echo mostrarErrores($errores);
                  }
             
             ?>

              <!--formulario de login-->
               <form method = "POST" id = "formulario-login">
               <input type="hidden" name="ficha" value="<?php echo ficha_csrf(); ?>">
               <input type="hidden" name="miel" value="">
                   
                   <div class="row">
                       <div class="col-sm-12">
                           <div class="form-group">
                               <input type="text" class="form-control input-lg" name="usuarioOEmail" value="<?php echo $_POST['usuarioOEmail'] ?? '' ?>" placeholder="Nombre de Usuario o Email" tabindex="1" autofocus>
                           </div>
                       </div>
                       <div class="col-sm-12">
                           <div class="form-group">
                               <input type="password" class="form-control input-lg" name="password" placeholder="Password" tabindex="2">
                           </div>
                       </div>
                   </div>

                   <hr>

                   <div class="row">
                       <div class="col-sm-6">
                           <button type="submit" class="btn btn-success btn-lg btn-block" name="loginbtn" tabindex=3>Ingresar</button>
                          
                       </div>
                   
                       <div class="col-sm-6">
                           <a href="index.php" class="btn btn-danger btn-lg btn-block" tabindex="4">Cancelar</a>
                          
                       </div>
                   </div>

          
                </form><!--termina formulario de login-->
                  
              </div>
          </div>
          

      </div><!--termina contenedor principal (cuerpo de la pagina)-->

<?php
    
    require_once('parciales/pie.php');
    require_once('parciales/abajo.php');

?>
      

