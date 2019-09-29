<?php
    session_start();
    require_once("funciones/funciones.php");
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ficha']) && validar_ficha($_POST['ficha'])){

        if(!empty($_POST['miel'])){ return header('Location: index.php'); }
        
        $campos = [
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'usuario' => 'Nombre de Usario',
            'email' => 'Correo Electronico',
            'carrera' => 'Carrera',
            'numControl' => 'Numero de Control',
            'password' => 'Contraseña',
            'confPass' => 'Confirma tu Contraseña',
            'terminos' => 'Termino y Condiciones'
        ];

        $errores = validar($campos);
        $errores = array_merge($errores, comparadorDePass($_POST['password'], $_POST['confPass']));

        if(empty($errores)){
            $errores = registro();

        }
        

    }

    $titulo = "Ingenieria Informatica ITCH | Registro";
    require_once('parciales/arriba.php');
    require_once('parciales/navegacion.php');
    require_once("Recursos/conexion.php");

?>


      <!--contenedor principal (cuerpo de la pagina)-->
      <div class="container" id="pagina-registro">
          <div class="row">
              <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

              <h1 class="titulo-de-pagina">Instituto Tecnologico de Chilpancingo</h1>

             <hr>

             <?php 
                  if(!empty($errores)){
                      echo mostrarErrores($errores);
                  }
             
             ?>
             <!-- <ul class="errores"></ul> -->

              <!--formulario de registro-->
               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST" id="formulario-registro">
                   <input type="hidden" name="ficha" value="<?php echo ficha_csrf(); ?>">
                   <input type="hidden" name="miel" value="">
                   <h2><small>Plataforma de Ingenieria Informatica</small></h2>
                   <hr>
                   <div class="row">
                       <div class="col-sm-6">
                           <div class="form-group">
                               <div class="input-group">
                                  <div class="campo-contenedor">
                                      <input type="text" class="form-control input-lg" name="nombre" value="<?php echo $_POST['nombre'] ?? '' ?>" placeholder="Nombre" tabindex="1" autofocus>
                                         <span class="glyphicon iconoDerecho"></span>
                                         <span class="glyphicon glyphicon-user iconoIzquierdo"></span>
                                  </div>
                                     <div class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="Nombre(s) de la persona registrandose">
                                         <span class="glyphicon glyphicon-info-sign"></span>
                                     </div>
                               </div>
                           </div>
                       </div>
                       <div class="col-sm-6">
                           <div class="form-group">
                               <div class="input-group">
                               <div class="campo-contenedor">
                                      <input type="text" class="form-control input-lg" name="apellidos" value="<?php echo $_POST['apellidos'] ?? '' ?>" placeholder="Apellidos" tabindex="2">
                                         <span class="glyphicon iconoDerecho"></span>
                                         <!-- <span class="glyphicon glyphicon-user iconoIzquierdo"></span> -->
                                  </div>
                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="Apellidos de la persona registrandose">
                                      <span class="glyphicon glyphicon-info-sign"></span>
                                    </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="row">
                       <div class="col-sm-6">
                           <div class="form-group">
                               <div class="input-group">
                               <div class="campo-contenedor">
                                   <input type="text" class="form-control input-lg" name="usuario" value="<?php echo $_POST['usuario'] ?? '' ?>" placeholder="Nombre de Usuario" tabindex="3">   
                                         <span class="glyphicon iconoDerecho"></span>
                                         <span class="glyphicon glyphicon-user iconoIzquierdo" style="color:blue"></span>
                                       </div>
                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="Nombre(s) de Usuario que de desee usar">
                                      <span class="glyphicon glyphicon-info-sign"></span>
                                    </div>
                               </div>
                           </div>
                       </div>
                       <div class="col-sm-6">
                           <div class="form-group">
                               <div class="input-group">
                               <div class="campo-contenedor">
                                   <input type="text" class="form-control input-lg" name="email" value="<?php echo $_POST['email'] ?? '' ?>" placeholder="Email" tabindex="4"> 
                                         <span class="glyphicon iconoDerecho"></span>
                                         <span class="glyphicon glyphicon-envelope iconoIzquierdo"></span>
                                       </div>
                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="Correo electronico valido que desee usar">
                                      <span class="glyphicon glyphicon-info-sign"></span>
                                    </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="row">
                       <div class="col-sm-6">
                           <div class="form-group">
                           <div class="input-group">
                                 <div class="campo-contenedor">
                                   <input type="text" class="form-control input-lg" name="carrera" value="<?php echo $_POST['carrera'] ?? '' ?>" placeholder="Carrera" tabindex="5"> 
                                         <span class="glyphicon iconoDerecho"></span>
                                         <span class="glyphicon glyphicon-education iconoIzquierdo"></span>
                                       </div> 
                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="Carrera Profesional que este cursando">
                                      <span class="glyphicon glyphicon-info-sign"></span>
                                    </div>
                               </div>
                         </div>
                       </div>
                       <div class="col-sm-6">
                           <div class="form-group">
                           <div class="input-group">
                           <div class="campo-contenedor">
                               <input type="text" class="form-control input-lg" name="numControl" value="<?php echo $_POST['numControl'] ?? '' ?>" placeholder="Numero de Control" tabindex="6"> 
                                         <span class="glyphicon iconoDerecho"></span>
                                         <span class="glyphicon glyphicon-pencil iconoIzquierdo"></span>
                                       </div>  
                                   <div class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="Tu numero de control">
                                      <span class="glyphicon glyphicon-info-sign"></span>
                                    </div> 
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="row">
                       <div class="col-sm-6">
                           <div class="form-group">
                               <input type="password" class="form-control input-lg" name="password" placeholder="Password" tabindex="7" id="password">
                           </div>
                       </div>
                       <div class="col-sm-6">
                           <div class="form-group">
                               <input type="password" class="form-control input-lg" name="confPass"  placeholder="Confirmar Password" tabindex="8">
                           </div>
                       </div>
                   </div>

                   <div class="row">
                       <div class="col-sm-5">
                           <label class="btn btn-primary">
                               <input type="checkbox" name="terminos" tabindex="9" <?php if(isset($_POST['terminos'])){ echo "checked='checked'"; } ?>">
                               Acepto Terminos y Condiciones
                           </label>
                          
                       </div>
                   </div>

                   <hr>

                   <div class="row">
                       <div class="col-sm-6">
                           <button type="submit" class="btn btn-success btn-lg btn-block" name="registrarbtn" tabindex=10>Registrar</button>
                          
                       </div>
                   
                       <div class="col-sm-6">
                           <a href="index.php" class="btn btn-danger btn-lg btn-block" tabindex="11">Cancelar</a>
                          
                       </div>
                   </div>
                   
                   <hr>

          
                </form><!--termina formulario de registro-->
                  
              </div>
          </div>

      </div><!--termina contenedor principal (cuerpo de la pagina)-->

<?php
    
    require_once('parciales/pie.php');
    require_once('parciales/abajo.php');

?>
      

