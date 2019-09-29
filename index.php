<?php
    session_start();
    $titulo = "Ingenieria Informatica ITCH | Principio";
    require_once('parciales/arriba.php');
    require_once('parciales/navegacion.php');
   

?>


      <!--contenedor principal (cuerpo de la pagina)-->
      <div class="container" id="pagina-principio">
          <h1 class="titulo-de-pagina">Pagina Principal</h1>
          
          <?php
                 if(isset($_SESSION['usuario'])){
                                 echo'
                                 <p>Bienvenido '.$_SESSION['usuario'].'></p>
                                   
                                ';
                             }
                             else{
                                 echo'
                                 <p>Por Registrate o has Login
                                 
                                 ';
                     }
                        
             ?>

      </div><!--termina contenedor principal (cuerpo de la pagina)-->

<?php
    
    require_once('parciales/pie.php');
    require_once('parciales/abajo.php');

?>
      

