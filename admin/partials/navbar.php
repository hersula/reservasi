<?php
include "../cekLogin.php";
$email = $_SESSION['email'];

$sql = "SELECT master_outlet.id, master_karyawan.name name_karyawan, master_karyawan.email email_karyawan, master_karyawan.status, 
master_roles.roleName, master_outlet.name name_outlet, master_outlet.isFaskes FROM karyawan_role_list JOIN master_karyawan on karyawan_role_list.karyawanID = master_karyawan.id JOIN master_roles on karyawan_role_list.rolesID = master_roles.id 
JOIN master_outlet on master_outlet.id = master_karyawan.outletID where master_karyawan.email ='$email'";

$result = mysqli_fetch_array(mysqli_query($conn, $sql));

?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>



  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <?= 'Welcome, ' . $_SESSION['name']; ?> | <?= $result['name_outlet'] ?>
      </a>
      <div class="dropdown-menu float-right">
        <?php if ($result['roleName'] == 'Superadmin' && $result['isFaskes'] != '1') { ?>

          <a class="dropdown-item" href="" data-toggle="modal" data-target="#change-outlet">Change outlet</a>
        <?php } ?>
        <a class="dropdown-item" href="<?= BASE_URL ?>admin/logoutAdmin.php">Logout</a>
      </div>
    </li>
  </ul>


</nav>


<div class="modal fade" id="change-outlet">
  <div class="modal-dialog">
    <form action="../admin/change_outlet.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Mengubah outlet</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <select type="text" class="custom-select custom-select-sm" id="outletID" name="outletID" required>
              <option value="">Pilih outlet</option>
              <?php
              $outletID = $_SESSION['outletID'];
              $query_select_outlet = $conn->query("SELECT * FROM master_outlet WHERE isFaskes='0'");
              while ($result = $query_select_outlet->fetch_array()) { ?>

                <option <?php if ($result['id'] == $outletID) {
                          echo 'selected';
                        } ?> value="<?= $result['id'] ?>"><?= $result['name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>