<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include_once("../../../connection.php");
include_once("../../../helper/base_url.php");
require '../../../mailer/autoload.php';

if(isset($_POST["update"])) {
    //var_dump($_POST);
    //exit;
  $id_pasien    = $_POST["id_pasien"];
  $nik          = $_POST["nik"];
  $name         = $_POST["name"];
  $email        = $_POST["email"];
  $password     = md5($_POST["password"]);

    // $sql_check = "select * from master_pasien where email='$email' and id = '$id_pasien'";
    $sql_check = "select * from master_pasien where nik='$nik' and id = '$id_pasien'";
    $result = mysqli_query($conn,$sql_check);
    $row = mysqli_fetch_array($result);
    $id_pasien_master    = $row["id"];
    $check_email_verifikasi    = $row["isEmailVerified"];
    $fullname = $row['name'];

    //var_dump($row);
    //var_dump($_POST);
    //exit;

    if(mysqli_num_rows($result) > 0){

      if ($check_email_verifikasi > 0) {
        
        $sql2 = "update master_pasien set email='$email', password='$password', createdAt=NOW() where id='$id_pasien'";
                mysqli_query($conn, $sql2);  
                
                $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah Account Pasien') ";
                mysqli_query($conn, $sql_query1);

        echo '<script>alert("Akun sudah di verifikasi, silahkan login.");window.location.replace("../../admin.php?page=account-pasien-data");</script>';


      }else{

                $token = hash('sha256', md5(date("Y-m-d H:i:s")));

                $sql2 = "update master_pasien set email='$email', password='$password', createdAt=NOW(), token='$token' where id='$id_pasien'";
                mysqli_query($conn, $sql2);  
                
                $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah Account Pasien') ";
                mysqli_query($conn, $sql_query1);

                $verifikasi_email = email_verifikasi($email, $fullname, $token, $id_pasien_master);
                if ($verifikasi_email) {
                    # code...
                    
                    echo '<script>alert("Berhasil membuat Account pada pasien, silahkan cek email dengan data yang telah terdaftar !");window.location.replace("../../admin.php?page=account-pasien-data");</script>';
                    // echo("<script>location.href = 'info_activation_send_account.php';</script>");
                } else {
                    # code...
                    echo '<script>alert("Gagal untuk memverifikasi email ! Mohon periksa kembali datanya !");history.go(-1);</script>';
                }


      }

    }else{
   
        echo '<script>alert("Data yang anda cari tidak ditemukan.");window.location.replace("../../admin.php?page=account-pasien-data");</script>';

    }

}


function email_verifikasi($email, $fullname, $token, $id_pasien_master)
{

    include_once("../../../helper/base_url.php");
    require '../../../mailer/autoload.php';
    
                $mail = new PHPMailer();

                try {
                    // echo $admin_email;
                    // exit;
                    //Server settings
                    $mail->isSMTP();
                    //Send using SMTP
                    //var_dump($mail->isSMTP());
                    // var_dump($mail->SMTPDebug);
                    // exit;
                    $mail->SMTPDebug = 0;
                    //var_dump($mail->SMTPDebug);
                    //exit;
                    //Enable verbose debug output
                    $mail->Host       = 'reservasi.norbumedika.id';
                    //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;
                    //Enable SMTP authentication
                    $mail->Username   = 'norbumedika@reservasi.norbumedika.id';                     //SMTP username
                    $mail->Password   = 'QxmRZd=ZWfo?';
                    //SMTP password
                    $mail->SMTPSecure = 'ssl';
                    //Enable implicit TLS encryption
                    $mail->Port       = 465;
                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('norbumedika@reservasi.norbumedika.id', 'Norbu Medika');
                    $mail->addAddress($email, $fullname);     //Add a recipient
                    // $mail->addAddress('ellen@example.com');               //Name is optional
                    // $mail->addReplyTo('info@example.com', 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Verifikasi Akun Member Norbu Medika (Not-Reply)';
                    $mail->Body    = "Selamat, anda berhasil membuat akun di reservasi Norbu Medika. Untuk mengaktifkan akun anda silahkan klik link dibawah ini.
                    <a target='blank' href='" . BASE_URL . "auth/activation.php?t=" . $token . "'>" . BASE_URL . "auth/activation.php?t=" . $token . "</a><br><br><br><a target='blank' href='" . BASE_URL . "'>Subscribe</a>";
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo 'Message has been sent';
                    #header("location: info_activation_send.php", true, 301);
                    echo '<script>alert("Account sudah berhasil dibuat, silahkan periksa email anda untuk memverifikasi akun !");window.location.replace("../../admin.php?page=account-pasien-data&id='.$id_pasien_master.'");</script>';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

                }

}
