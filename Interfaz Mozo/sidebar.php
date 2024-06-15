<!DOCTYPE html>
<head>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="sidebar">
    <div class="logo_details">
      <i class="bx bxl-audible icon"></i>
      <div class="logo_name">La cochera</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <i class="bx bx-search"></i>
        <input type="text" placeholder="Buscar...">
         <span class="tooltip">Busqueda</span>
      </li>
      <li>
        <a href="inicio.php">
          <i class="bx bx-grid-alt"></i>
          <span class="link_name">Inicio</span>
        </a>
        <span class="tooltip">Inicio</span>
      </li>
      <li>
        <a href="index.php">
          <i class="bx bx-folder"></i>
          <span class="link_name">Pedidos Pendientes</span>
        </a>
        <span class="tooltip">Pedidos Pendientes</span>
      </li>
      <li>
        <a href="Aprobados.php">
          <i class="bx bx-folder"></i>
          <span class="link_name">Pedidos Aprobados</span>
        </a>
        <span class="tooltip">Pedidos Aprobados</span>
      </li>
      <li>
        <a href="llamados.php">
          <i class="bx bx-chat"></i>
          <span class="link_name">Llamados</span>
        </a>
        <span class="tooltip">Llamados</span>
      </li>
      <li>
      <li>
        <a href="todamesa.php">
          <i class="bx bx-chat"></i>
          <span class="link_name">Mesas</span>
        </a>
        <span class="tooltip">Mesas</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-cart-alt"></i>
          <span class="link_name">Pagos</span>
        </a>
        <span class="tooltip">Pagos</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="link_name">Reportes</span>
        </a>
        <span class="tooltip">Reportes</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-user"></i>
          <span class="link_name">Perfil</span>
        </a>
        <span class="tooltip">Perfil</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-cog"></i>
          <span class="link_name">Configuracion</span>
        </a>
        <span class="tooltip">Configuracion</span>
      </li>
      <li class="profile">
        <div class="profile_details">
          <img src="foto.png" alt="profile image">
          <div class="profile_content">
            <div class="name">Luz Karina</div>
            <div class="designation">Admin</div>
          </div>
        </div>
        <i class="bx bx-log-out" id="log_out"></i>
      </li>
    </ul>
  </div>
  <script src="script.js"></script>
</body>
</html>