<?php
include "../cekLogin.php";
$outlet_id = $_SESSION['outletID'];
$queryGetFaskes = $conn->query("SELECT isFaskes FROM master_outlet WHERE id='$outlet_id'");
$isFaskes       = $queryGetFaskes->fetch_array();

$arrayRoleName = $_SESSION['rolesName'];

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= BASE_URL . 'admin' ?>" class="brand-link">
    <img src="<?= BASE_URL  . 'images/LogoNorbuMedika.png'?>" class="brand-image img-circle">
    <span class="brand-text font-weight-light">NORBU MEDIKA</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
            <a href="<?= BASE_URL . 'admin' ?>" class="nav-link <?php if (isset($_GET['page']) == false) {
                                                  echo 'active';
                                                } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
      </li>
     
        <?php
        if ($isFaskes['isFaskes'] != '1' && in_array('Admin', $arrayRoleName) || in_array('Superadmin', $arrayRoleName) || in_array('Accounting', $arrayRoleName)) { ?>
          <li class="nav-item <?php if ($_GET['page'] == 'reservation' || $_GET['page'] == 'history-tindakan' || $_GET['page'] == 'hasil-lab-antigen') {
                                echo 'menu-is-opening menu-open';
                              } ?>">
            <a href="" class="nav-link">
              <i class="nav-icon fa fa-plus-square"></i>
              <p>
                Transaksi Rawat Jalan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin.php?page=reservation" class="nav-link <?php if ($_GET['page'] == 'reservation') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>Pendaftaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin.php?page=history-tindakan" class="nav-link <?php if ($_GET['page'] == 'history-tindakan') {
                                                                            echo 'active';
                                                                          } ?>">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>Riwayat Tindakan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../admin/admin.php?page=hasil-lab-antigen" class="nav-link <?php if ($_GET['page'] == 'hasil-lab-antigen') {
                                                                                      echo 'active';
                                                                                    } ?>">
                  <i class="far fa-chart-bar nav-icon"></i>
                  <p>Hasil Tes Antigen</p>
                </a>
              </li>
            </ul>
          </li>
        <?php }
        ?>
        
        <!--Menu Faskes-->
        <?php if($isFaskes['isFaskes'] == '1' || in_array('Superadmin', $arrayRoleName) || in_array('Accounting', $arrayRoleName)) { ?>
        <li class="nav-item <?php if ($_GET['page'] == 'reservation-faskes' || $_GET['page'] == 'hasil-pcr-faskes' || $_GET['page'] == 'hasil-antigen-faskes') {
                              # code...
                              echo 'menu-is-opening menu-open';
                            } ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-clinic-medical"></i>
            <p>
              Faskes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="admin.php?page=reservation-faskes" class="nav-link <?php if ($_GET['page'] == 'reservation-faskes') {
                                                                            echo 'active';
                                                                          } ?>">
                <i class="nav-icon fas fa-copy"></i>
                <p>Pendaftaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../admin/admin.php?page=hasil-pcr-faskes" class="nav-link <?php if ($_GET['page'] == 'hasil-pcr-faskes') {
                                                                                    echo 'active';
                                                                                  } ?>">
                <i class="far fa-chart-bar nav-icon"></i>
                <p>Hasil PCR</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../admin/admin.php?page=hasil-antigen-faskes" class="nav-link <?php if ($_GET['page'] == 'hasil-antigen-faskes') {
                                                                                    echo 'active';
                                                                                  } ?>">
                <i class="far fa-chart-bar nav-icon"></i>
                <p>Hasil Antigen</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <!--End Menu Faskes-->
        
        <?php if ($isFaskes['isFaskes'] != '1' && in_array('Superadmin', $arrayRoleName) || in_array('Laboratorium', $arrayRoleName) || in_array('Accounting', $arrayRoleName)) { ?>
          <li class="nav-item <?php if ($_GET['page'] == 'sample-lab' || $_GET['page'] == 'hasil-lab-pcr') {
                                # code...
                                echo 'menu-is-opening menu-open';
                              } ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-flask"></i>
              <p>
                Laboratorium
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../admin/admin.php?page=sample-lab" class="nav-link <?php if ($_GET['page'] == 'sample-lab') {
                                                                                echo 'active';
                                                                              } ?>">
                  <i class="fa fa-book fa-fw nav-icon"></i>
                  <p>Admin Sample</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../admin/admin.php?page=hasil-lab-pcr" class="nav-link <?php if ($_GET['page'] == 'hasil-lab-pcr') {
                                                                                  echo 'active';
                                                                                } ?>">
                  <i class="far fa-chart-bar nav-icon"></i>
                  <p>Hasil Tes PCR</p>
                </a>
              </li>
            </ul>
          </li>
        <?php
        } ?>
        <?php if ($isFaskes['isFaskes'] != '1' && in_array('Superadmin', $arrayRoleName)) { ?>
          <li class="nav-item <?php if ($_GET['page'] == 'roles-data' || $_GET['page'] == 'tambah-roles-data' || $_GET['page'] == 'ubah-roles-data' || $_GET['page'] == 'hapus-roles-data' || $_GET['page'] == 'lihat-roles-data' || $_GET['page'] == 'outlet-data' || $_GET['page'] == 'tambah-outlet-data' || $_GET['page'] == 'ubah-outlet-data' || $_GET['page'] == 'hapus-outlet-data' || $_GET['page'] == 'lihat-outlet-data' || $_GET['page'] == 'tindakan-data' || $_GET['page'] == 'tambah-tindakan-data' || $_GET['page'] == 'ubah-tindakan-data' ||  $_GET['page'] == 'hapus-tindakan-data' || $_GET['page'] == 'lihat-tindakan-data' ||  $_GET['page'] == 'master-pasien-data' || $_GET['page'] == 'ubah-pasien-data' || $_GET['page'] == 'hapus-pasien-data' || $_GET['page'] == 'lihat-pasien-data' || $_GET['page'] == 'karyawan-data' || $_GET['page'] == 'tambah-karyawan-data' ||  $_GET['page'] == 'ubah-karyawan-data' ||  $_GET['page'] == 'hapus-karyawan-data' || $_GET['page'] == 'lihat-karyawan-data' || $_GET['page'] == 'target-gen-data' || $_GET['page'] == 'tambah-target-gen-data' || $_GET['page'] == 'ubah-target-gen-data' ||  $_GET['page'] == 'hapus-target-gen-data' ||  $_GET['page'] == 'lihat-target-gen-data' ||  $_GET['page'] == 'reagen-data' || $_GET['page'] == 'tambah-reagen-data' || $_GET['page'] == 'ubah-reagen-data' || $_GET['page'] == 'hapus-reagen-data' || $_GET['page'] == 'lihat-reagen-data' || $_GET['page'] == 'master-hasil-tes-data' || $_GET['page'] == 'ubah-hasil-tes-data' || $_GET['page'] == 'lihat-hasil-tes-data' || $_GET['page'] == 'tipe-klien-data' ||  $_GET['page'] == 'tambah-tipe-klien-data' ||  $_GET['page'] == 'ubah-tipe-klien-data' ||  $_GET['page'] == 'hapus-tipe-klien-data' ||  $_GET['page'] == 'lihat-tipe-klien-data' || $_GET['page'] == 'klien-data' || $_GET['page'] == 'tambah-klien-data' || $_GET['page'] == 'ubah-klien-data' || $_GET['page'] == 'hapus-klien-data' || $_GET['page'] == 'lihat-klien-data' || $_GET['page'] == 'tipe-pembayaran-data' || $_GET['page'] == 'tambah-tipe-pembayaran-data' || $_GET['page'] == 'lihat-tipe-pembayaran-data') {
                                # code...
                                echo 'menu-is-opening menu-open';
                              } ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
              <p class="text-sm">
                MASTER
                <i class="fas fa-angle-left right"></i>
              </p>
          </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin.php?page=roles-data" class="nav-link <?php if ($_GET['page'] == 'roles-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin.php?page=outlet-data" class="nav-link <?php if ($_GET['page'] == 'outlet-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Outlet</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="admin.php?page=karyawan-data" class="nav-link <?php if ($_GET['page'] == 'karyawan-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Karyawan</p>
                </a>
              </li>
               
              <li class="nav-item">
                <a href="admin.php?page=tindakan-data" class="nav-link <?php if ($_GET['page'] == 'tindakan-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Tindakan</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="admin.php?page=master-pasien-data" class="nav-link <?php if ($_GET['page'] == 'master-pasien-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Pasien</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="admin.php?page=target-gen-data" class="nav-link <?php if ($_GET['page'] == 'target-gen-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Target Reagen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin.php?page=reagen-data" class="nav-link <?php if ($_GET['page'] == 'reagen-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Reagen</p>
                </a>
              </li>            
              <li class="nav-item">
                <a href="admin.php?page=master-hasil-tes-data"class="nav-link <?php if ($_GET['page'] == 'master-hasil-tes-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Hasil Tes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin.php?page=tipe-klien-data" class="nav-link <?php if ($_GET['page'] == 'tipe-klien-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Tipe Klien</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin.php?page=klien-data" class="nav-link <?php if ($_GET['page'] == 'klien-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Klien</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin.php?page=tipe-pembayaran-data" class="nav-link <?php if ($_GET['page'] == 'tipe-pembayaran-data') {
                                                                        echo 'active';
                                                                      } ?>">
                  <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Tipe Pembayaran</p>
                </a>
              </li>
            </ul>
      </li>
      <?php
        } 
      ?>
      
      <li class="nav-item <?php if ($_GET['page'] == 'ganti-password') {
              echo 'menu-is-opening menu-open';
              } ?>">
        <a href="" class="nav-link">
          <i class="nav-icon fa fa-cog"></i>
            <p>
              UTILITY
              <i class="right fas fa-angle-left"></i>
            </p>
        </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="admin.php?page=ganti-password" class="nav-link <?php if ($_GET['page'] == 'ganti-password') {
                  echo 'active';
                } ?>">
               <i class="far fa-circle nav-icon"></i>
                <p>Ganti Password</p>
                </a>
            </li>
          </ul>
      </li>
      
      

      </ul>
    </nav>
  </div>
</aside>