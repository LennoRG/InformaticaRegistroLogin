<?php
     $con = new mysqli('localhost', 'root', '', 'info_plataforma');
     if($con -> connect_error){
         die('Conexion No Establecida: ' . $con -> connect_error);         

     }
     /*else{
         echo 'Conexion Exitosa';
     }*/


?>