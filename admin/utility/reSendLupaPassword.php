<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include_once("../../connection.php");
include_once("../../helper/base_url.php");
require '../../mailer/autoload.php';

$email = isset($_POST['email']) ? $_POST['email'] : '';

$select_user = mysqli_query($conn, "select * from master_karyawan where email='$email'");
//echo $select_user;
//exit;
if(mysqli_num_rows($select_user) >=1) {
    $result = mysqli_fetch_array($select_user) or die(mysqli_error($conn));
    $fullname = $result['name'];
    $admin_email = $result['email'];
    
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
        $mail->Body    = "Untuk mengubah password anda silahkan klik link di bawah ini.
            <a target='blank' href='" . BASE_URL . "admin/utility/Lupa_Password.php?page=lupa-password&email=".$admin_email."'><i>Click Disini !</i></a><br><br><br><a target='blank' href='" . BASE_URL . "'>Subscribe</a>";
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
        #header("location: info_activation_send.php", true, 301);
        echo("<script>location.href = 'info_activation_send_lupapassword.php';</script>");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }
        
} else {
    echo '<script>
              alert("Alamat email tidak ditemukan.");
              window.location.href = "'.BASE_URL.'admin/utility/Lupa_Password.php";
              </script>';
    //header('location: ' . $_SERVER['HTTP_REFERER']);
}


 

