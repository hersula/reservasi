<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <?php
    $nik = $_SESSION['nik'];
    $sql = mysqli_query($conn, "select count(*) as jumlah from temp_cart where nik='$nik'");
    $fetch = mysqli_fetch_array($sql);
    ?>
    <li class="nav-item">
      <a class="nav-link" href="<?= BASE_URL . 'pasien/main/index.php?page=cart' ?>">
        <i class="fas fa-shopping-cart"></i>
        <?php 
          if (mysqli_num_rows($sql) != 0) {
            # code...
            echo '<span class="badge badge-danger navbar-badge">'.$fetch["jumlah"].'</span>';
          }
        ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?= BASE_URL ?>">
       <b>Halo,</b> <?= $_SESSION['name']; ?>
      </a>
    </li>

  </ul>
</nav>