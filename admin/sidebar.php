<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-dark bg-dark fixed-top d-md-none">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar"
        aria-controls="sidebar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <span class="navbar-brand">Admin Panel</span>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white vh-100 position-fixed p-3" id="sidebar">
        <h5 class="text-center">Admin Panel</h5>
        <ul class="nav flex-column mt-3">
          <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#adminMenu">Manage Admin</a>
            <div class="collapse show" id="adminMenu">
              <a class="nav-link text-white ps-4" href="Homeadmin.php">Admin list</a>
              <a class="nav-link text-white ps-4" href="insertadmin.php">Add Admin</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#productMenu">Manage Product</a>
            <div class="collapse show" id="productMenu">
              <a class="nav-link text-white ps-4" href="product.php">Product list</a>
              <a class="nav-link text-white ps-4" href="insertproduct.php">Add Product</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#userMenu">Manage User</a>
            <div class="collapse show" id="userMenu">
              <a class="nav-link text-white ps-4" href="userlist.php">User list</a>
              <a class="nav-link text-white ps-4" href="Orderadmin.php">Order</a>
            </div>
          </li>
          <a class="nav-link text-white" href="logoutAdmin.php">Logout</a>
        </ul>
      </nav>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>