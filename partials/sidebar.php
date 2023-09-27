<nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand px-4" href="#">JAZMIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">JAZMIN</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="tables.php">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categories.php">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="menu.php">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_users.php">Manage Users</a>
          </li>    
          <li class="nav-item">
            <a class="nav-link" href="cashup.php">History and Cash up</a>
          </li>     
          <li class="nav-item">
            <a class="nav-link" href="graph.php">Sales Report</a>
          </li>
        </ul>
        <hr>
        <a href="login.php?logout" class="d-flex align-items-center text-white text-decoration-none "  aria-expanded="false">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="d-none d-sm-inline mx-1">Logout</span>
        </a>
      </div>
    </div>
  </div>
</nav>