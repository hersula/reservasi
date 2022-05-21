<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= BASE_URL ?>" class="brand-link text-md">
    <img src="<?= BASE_URL . 'images/LogoNorbuMedika.png' ?>" class="brand-image img-circle">
    <span class="brand-text font-weight-light">NORBU MEDIKA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex text-sm">
        <div class="image">
          <img src="../../admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= BASE_URL ?>" class="d-block"><?= $_SESSION['name']; ?></a>
        </div>
      </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <!-- <li class="nav-item menu-open">
          </li> -->

        <li class="nav-item mt-2">
          <a href="<?= BASE_URL ?>" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Pendaftaran Tes
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL . 'pasien/main/index.php?page=history' ?>" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Riwayat Tes COVID 19
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL . 'logout.php' ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>