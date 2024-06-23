<?php
    
    session_start();
    if(!isset($_SESSION['rol'])){
        header('location: ../loginPage/login.php');

    } else{
        if($_SESSION['rol'] != 1){
            header('location: ../loginPage/login.php');
        }
    }



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/style2.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <div id="loader" class="loader">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="adminPanel.php">La Cochera</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        
                        <li><a class="dropdown-item" href="../loginPage/login.php?cerrar_sesion=true">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Dashboard</div>
                            <a class="nav-link" href="adminPanel.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Panel de Control
                            </a>
                            <div class="sb-sidenav-menu-heading">Gestión de Contenido</div>

                            <!-- Primer elemento colapsable -->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMenu1" aria-expanded="false" aria-controls="collapseMenu1">
                                <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                                Carta
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseMenu1" aria-labelledby="headingMenu1" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    
                                    <a class="nav-link" href="admProducto.php">Edicion Producto</a>
                                    <a class="nav-link" href="admCategoria.php">Categorías</a>
                                </nav>
                            </div>

                            <!-- Segundo elemento colapsable -->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMenu2" aria-expanded="false" aria-controls="collapseMenu2">
                                <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                                Interfaces
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseMenu2" aria-labelledby="headingMenu2" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="menu_management.php">Mozo</a>
                                    <a class="nav-link" href="admProducto.php">Cocina</a>
                                </nav>
                            </div>

                            <a class="nav-link" href="pedidos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Pedidos
                            </a>
                            <div class="sb-sidenav-menu-heading">Personal y Clientes</div>
                            <a class="nav-link" href="personal.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Personal
                            </a>
                            <a class="nav-link" href="clientes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                                Clientes
                            </a>
                            <div class="sb-sidenav-menu-heading">Informes</div>
                            <a class="nav-link" href="informes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Informes
                            </a>

                            <a class="nav-link" href="historial.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                                Historial de cambios
                            </a>
                            
                        </div>
                    </div>
                    
                </nav>
            </div>
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="main-content">
                        <div class="contenedor">
                            <div><h2>Clientes</h2></div>
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Buscar" aria-label="Buscar..." aria-describedby="btnNavbarSearch" />
                                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                            </div>
                           
                        </div>
                        
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="thfiltro" id="Nombrefiltro" data-order="asc" data-field="nombre"><span class="header-text">Nombre</span> <i id="nombrefilter" class="fas fa-sort"></i></th>
                                        <th class="thfiltro" id="Preciofiltro" data-order="asc" data-field="precio"><span class="header-text">Direccion</span> <i id="preciofilter" class="fas fa-sort"></i></th>
                                        <th class="thfiltro" id="Categoriafiltro" data-order="asc" data-field="categoria"><span class="header-text">Numero</span> <i id="categoriafilter" class="fas fa-sort" ></i></th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="contenidoTabla">
                                    <!-- Aquí se agregarán las filas de la tabla dinámicamente con JavaScript -->
                                </tbody>
                            </table>
                            
                            <!-- Agregar elementos de paginación -->
                            <div class="pagination">
                                <button id="previousPage">Anterior</button>
                                <span id="pageInfo">Página <span id="currentPage">1</span> de <span id="totalPages">1</span></span>
                                <button id="nextPage">Siguiente</button>
                                <select id="itemsPerPage">
                                    <option value="5">5 por página</option>
                                    <option value="10" selected>10 por página</option>
                                    <option value="20">20 por página</option>
                                    <option value="50">50 por página</option>
                                </select>
                            </div>
                        </div>
                        
                        



                    </div>
                    

                

                    
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Grupo 3 Esis 2024 </div>
                            <div>
                                <a href="https://github.com/09LuisDc2001">by LDC09</a>
                                &middot;
                                <a href="https://github.com/avjovet/laCochera2.0">Repository Github</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="js/script3.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/scriptCliente.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    </body>
</html>
