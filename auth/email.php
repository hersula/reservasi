<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    include('../helper/base_url.php');
    require '../mailer/autoload.php';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            
        //Send using SMTP
        $mail->SMTPDebug = 0;                      
         //Enable verbose debug output
        // $mail->Host       = 'registrasi.norbumedika.id';                     
        $mail->Host       = 'reservasi.norbumedika.id';                     
        //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   
        //Enable SMTP authentication
        // $mail->Username   = 'norbumed@registrasi.norbumedika.id'; //SMTP username
        $mail->Username   = 'norbumedika@reservasi.norbumedika.id'; //SMTP username
        $mail->Password   = 'QxmRZd=ZWfo?';   // pasword reservasi.norbumedika.id                             
        // $mail->Password   = 'Ib[Xe7a!B@3]';                               
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
        $mail->Subject = 'Verifikasi Akun Member Norbu Medika';
        $mail->Body    = "Selamat, anda berhasil membuat akun. Untuk mengaktifkan akun anda silahkan klik link dibawah ini.
        <a target='blank' href='".BASE_URL."auth/activation.php?t=".$token."'>".BASE_URL."auth/activation.php?t=".$token."</a><br><br><br><a target='blank' href='".BASE_URL."'>Subscribe</a>";
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>