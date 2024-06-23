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
        <title>Informes</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/reportes.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="adminPanel.php">La Cochera</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div></div> </div>
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
                            
                        </div>
                    </div>
                    
                </nav>
            </div>
            
            <div id="layoutSidenav_content">
                <main>
                <div class="container">
                <button class="box" id="1b">Productos</button>
                <button class="box" id="2b">Mesas</button>
                <button class="box" id="3b" >Tipo de pedido</button>
                <button class="box" id="4b" >Ventas por dia</button>
                <button class="box" id="5b" >Ventas por fecha</button>
                <button class="box" id="6b">Hamburguesas</button>
                <button class="box" id="7b">Platos</button>
                <button class="box" id="8b">Bebidas</button>
                            
                </div>
                    <div class="chart-container">
                        <div id="loader" class="loader"></div>
        


                        <div class="grafcontainer" id="1">
                            <h2>Productos vendidos</h2>
                            <label for="order-select">Orden:</label>
                            <select id="order-select1">
                                <option value="desc">Descendente</option>
                                <option value="asc">Ascendente</option>
                            </select>
                            <label for="num-elements">Número de elementos:</label>
                            <input type="range" id="num-elements1" min="1" max="20" value="10" oninput="document.getElementById('num-elements-value1').innerText = this.value">
                            <span id="num-elements-value1">10</span>
                            <canvas id="chart1" height = 100 ></canvas>
                        </div>

                        <div class="grafcontainer" id="2">
                            <h2>Agregados ventas</h2>
                            <label for="order-select">Orden:</label>
                            <select id="order-select2">
                                <option value="desc">Descendente</option>
                                <option value="asc">Ascendente</option>
                            </select>
                            <label for="num-elements">Número de elementos:</label>
                            <input type="range" id="num-elements2" min="1" max="20" value="10" oninput="document.getElementById('num-elements-value2').innerText = this.value">
                            <span id="num-elements-value2">10</span>
                            <canvas id="chart2" height = 100></canvas>
                        </div>
                        <div class="grafcontainer" id="3">
                            <h2>Bebidas ventas</h2>
                            <label for="order-select">Orden:</label>
                            <select id="order-select3">
                                <option value="desc">Descendente</option>
                                <option value="asc">Ascendente</option>
                            </select>
                            <label for="num-elements">Número de elementos:</label>
                            <input type="range" id="num-elements3" min="1" max="20" value="10" oninput="document.getElementById('num-elements-value3').innerText = this.value">
                            <span id="num-elements-value3">10</span>
                            <canvas id="chart3" height = 100></canvas>
                        </div>
                        <div class="grafcontainer" id="4" >
                            <h2>Pedidos por tipo</h2>
                            <canvas id="chart4" height = 100></canvas>
                        </div>
                        <div class="grafcontainer" id="5">
                            <h2>Hamburguesas ventas</h2>
                            <label for="order-select">Orden:</label>
                            <select id="order-select5">
                                <option value="desc">Descendente</option>
                                <option value="asc">Ascendente</option>
                            </select>
                            <label for="num-elements">Número de elementos:</label>
                            <input type="range" id="num-elements5" min="1" max="20" value="10" oninput="document.getElementById('num-elements-value5').innerText = this.value">
                            <span id="num-elements-value5">10</span>
                            <canvas id="chart5" height = 100></canvas>
                        </div>
                        <div class="grafcontainer" id="6">
                            <h2>Mesas</h2>
                            <label for="order-select">Orden:</label>
                            <select id="order-select6">
                                <option value="desc">Descendente</option>
                                <option value="asc">Ascendente</option>
                            </select>
                            <label for="num-elements">Número de elementos:</label>
                            <input type="range" id="num-elements6" min="1" max="20" value="10" oninput="document.getElementById('num-elements-value6').innerText = this.value">
                            <span id="num-elements-value6">10</span>
                            <canvas id="chart6" height = 100></canvas>
                        </div>

                        <div class="grafcontainer" id="7" >
                            <h2>Platos</h2>
                            <label for="order-select">Orden:</label>
                            <select id="order-select7">
                                <option value="desc">Descendente</option>
                                <option value="asc">Ascendente</option>
                            </select>
                            <label for="num-elements">Número de elementos:</label>
                            <input type="range" id="num-elements7" min="1" max="20" value="10" oninput="document.getElementById('num-elements-value7').innerText = this.value">
                            <span id="num-elements-value7">10</span>
                            <canvas id="chart7"></canvas>
                        </div>
                        
                        <div class="grafcontainer" id="8">
                            <h2>Ventas por fecha</h2>
                            <label for="num-elements">Número de elementos:</label>
                            <input type="range" id="num-elements8" min="1" max="20" value="10" oninput="document.getElementById('num-elements-value8').innerText = this.value">
                            <span id="num-elements-value8">10</span>
                            <canvas id="chart8" height = 100></canvas>
                        </div>

                        <div class="grafcontainer" id="9">
                            <h2>Ventas por dia</h2>
                            <canvas id="chart9" height = 100></canvas>
                        </div>


                    </div>



                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/reportes.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
    </body>
</html>
