<nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">

               <!-- logo y boton de expander y colapsar los enlances-->
               <div class="navbar-header">
                   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#enlaces">
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>

                   </button>
                   <a href="index.php" class="navbar-brand">Ingeniera Informatica ITCH</a>


               </div><!-- termina logo y boton de expander y colapsar los enlances-->

               
               <!--enlaces de navegacion-->
              <div class="collapse navbar-collapse navbar-right " id="enlaces">
                  <ul class="nav navbar-nav">
                     <li><a href="index.php">Principio</a></li>
                     <li><a href="#">Nosotros</a></li>
                     <li><a href="#">Galeria</a></li>
                     <li><a href="#">Contactos</a></li>
    


                        <?php
                             if(isset($_SESSION['usuario'])){
                                 echo'
                                     <li>
                                         <a href="#" cllas="dropdown-toggle" data-toggle="dropdown">
                                              '.$_SESSION['usuario'].' <span class="caret"></span>
                                         </a>
                                             <ul class="dropdown-menu">
                                               <li><a href="#">Mi Perfil</a></li>
                                               <li><a href="#">Mi Cuenta</a></li>
                                               <li><a href="#">Mis Preferencias</a></li>
                                               <li class="divider"></li>
                                               <li><a href="logout.php">Cerrar Sesion</a></li>
                                           </ul>
                                    </li>
                                ';
                             }
                             else{
                                 echo'
                                 <li><a href="login.php">Login</a></li>
                                 <li><a href="registro.php">Registro</a></li>
                                 
                                 ';
                             }
                        
                        ?>
                  </ul>

                 </div> <!--termina enlaces de navegacion-->
          </div>
</nav>