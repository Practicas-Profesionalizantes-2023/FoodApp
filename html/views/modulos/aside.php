<?php

session_start();


if (isset($_GET["cerrar_sesion"]) && $_GET["cerrar_sesion"] == 1) {

    session_destroy();

    echo '
            <script>
                window.location = "http://localhost:8081/";
            </script>        
        ';
}
?>

<!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index.php" class="brand-link">
         <img src="views/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text  font-weight-bold">APP FOOD</span>
     </a>

    

     <!-- Sidebar -->
     <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="views/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <h6 class="text-warning"><?php
                
                echo $_SESSION["user_roleName"]. ': '.$_SESSION["user_N"] ?></h6>
           
            </div>
        </div>
        
         <!-- Sidebar Menu -->
         <nav class="mt-2">

             <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            
           

                 <li class="nav-item">
                     <a style="cursor: pointer;" class="nav-link active" onclick="CargarContenido('views/dashboard/dashboard.php','content-wrapper')">
                         <i class="nav-icon fas fa-th"></i>
                         <p>
                             Tablero Principal
                         </p>
                     </a>
                 </li>
                 <?php
                 
                                     
                 if ($_SESSION["user_role"]==1) { ?>
                 <!-- <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Productos
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a style="cursor: pointer;" class="nav-link" onclick="CargarContenido('views/productos.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Inventario</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a style="cursor: pointer;" class="nav-link" onclick="CargarContenido('views/carga_masiva_productos.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Carga Masiva</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a style="cursor: pointer;" class="nav-link" onclick="CargarContenido('views/categorias.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Categorías</p>
                             </a>
                         </li>
                     </ul>
                 </li> -->
                 <?php }  if ($_SESSION["user_role"]==2 or $_SESSION["user_role"]==1) { ?>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-store-alt"></i>
                         <p>Ventas<i class="right fas fa-angle-left"></i></p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/sales/index.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Punto de Venta</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/administrar_ventas.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Administrar ventas</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <?php } if ($_SESSION["user_role"]==1 ) { ?>
                 <li class="nav-item">
                     <a style="cursor: pointer;" class="nav-link" onclick="CargarContenido('views/compras.php','content-wrapper')">
                         <i class="nav-icon fas fa-dolly text-ligth"></i>
                         <p>
                             Compras
                         </p>
                     </a>
                 </li>
                 <?php }  if ($_SESSION["user_role"]==1) { ?>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-store-alt"></i>
                         <p>Menu<i class="right fas fa-angle-left"></i></p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/menu/crud_menus.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Administrar Menu</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/menu/create_menu.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Agregar Menu</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <?php }  if ($_SESSION["user_role"]==1) { ?>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-store-alt"></i>
                         <p>Categorias<i class="right fas fa-angle-left"></i></p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/menu/crud_categorys.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Administrar Categoria</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/menu/create_category.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Agregar Categoria</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                  <?php }  if ($_SESSION["user_role"]==1) { ?>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-store-alt"></i>
                         <p>Empleados<i class="right fas fa-angle-left"></i></p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/users/crud_users.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Administrar Empleados</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link" style="cursor:pointer;" onclick="CargarContenido('views/users/create_user.php','content-wrapper')">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Agregar Empleados</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a style="cursor: pointer;" class="nav-link" onclick="CargarContenido('views/reportes.php','content-wrapper')">
                         <i class="nav-icon fas fa-chart-line text-ligth"></i>
                         <p>
                             Reportes
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a style="cursor: pointer;" class="nav-link" onclick="CargarContenido('views/configuracion.php','content-wrapper')">
                         <i class="nav-icon fas fa-cogs text-ligth"></i>
                         <p>
                             Configuración
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a style="cursor: pointer;" class="nav-link" href="http://localhost:8081?cerrar_sesion=1">
                         <i class="nav-icon fas fa-sign-out-alt"></i>
                         <p>
                             Cerrar Sesion
                         </p>
                     </a>
                 </li>
                 <?php } ?>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
     <?php    function CloseSession() {
        session_unset();
        session_destroy();
    }
    ?>
 </aside>

 <script>
    cerrarSesion() {
                // Realizar una solicitud AJAX al servidor para cerrar la sesión
                var xhr = new XMLHttpRequest();
                xhr.open('POST' 'logout.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Redirigir o realizar cualquier otra acción después de cerrar sesión
                        window.location.href = 'login';
                    }
                };
                xhr.send();
            }
    


     $(".nav-link").on('click', function() {
         $(".nav-link").removeClass('active');
         $(this).addClass('active');
     })
 </script>