<?php
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/Exception.php';
require '../PHPMailer/OAuth.php';
require '../PHPMailer/POP3.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
if(isset($_FILES["files"])){
    print_r($_FILES["files"]);
    print_r($_FILES["files"]["tmp_name"]);
    $endodedArr = $_FILES["files"]["name"];


    $tym=0;
    foreach($_FILES['files']['name'] as $a){
        $target_dir = "./upload/";
        $target_file = $target_dir . $a;
        foreach($_FILES['files']['size'] as $b){
            if($b < 25000000){
                if(!file_exists($target_file)) {
                    move_uploaded_file($_FILES["files"]["tmp_name"][$tym], $target_file); 
                    // array_push($myArr, $a);
                }
            }
        }
        $tym++;
    }

    $mail = new PHPMailer(true);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date = $_POST['date'];
        $to = $_POST['to'];
        $title = $_POST['title'];
        $message = $_POST['message'];
        $pass = $_POST['pass'];
        $time = $_POST['time'];    

    }

    print_r($time);
    if ($_POST["time"] !== "00:00:00"){
        $hah = implode(",", $endodedArr);
        $localhost = "localhost"; #localhost
        $user = "root"; #username of phpmyadmin
        $dbpass = "";  #password of phpmyadmin
        $dbname = "email";  #database name
        $conn = mysqli_connect($localhost,$user,$dbpass,$dbname);

        $sql = "INSERT into mytable(`date`, `time`, `from`, `to`, `domain`, `title`, `message`, `pass`, `file`)
            VALUES('$date', '$time', 'from', '$to', 'domain', '$title', '$message', '$pass', '$hah')";

        if(mysqli_query($conn, $sql)){
            echo "File Sucessfully uploaded";
        }else{
            echo "Error";
        }
    }
    mysqli_close($conn);









    // //sending mailer
    try {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mateuszjanicki3p1@gmail.com';
        $mail->Password   = $pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('mateuszjanicki3p1@gmail.com');
        $mail->addAddress($to);

        foreach($endodedArr as $a){
            print_r($a);
            $mail->addAttachment('./upload/' . $a);
        }
        $mail->IsSMTP();
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}else{
    $mail = new PHPMailer(true);

    $date = $_POST['date'];
    $to = $_POST['to'];
    $title = $_POST['title'];
    $message = $_POST['message'];
    $pass = $_POST['pass'];
    $time = $_POST['time'];    

    // echo $date;
    print_r($time);
    // if ($_POST["time"] !== "00:00:00"){
    //     $localhost = "localhost"; #localhost
    //     $user = "root"; #username of phpmyadmin
    //     $dbpass = "";  #password of phpmyadmin
    //     $dbname = "email";  #database name
    //     $conn = mysqli_connect($localhost,$user,$dbpass,$dbname);

    //     $sql = "INSERT into mytable(`date`, `time`, `from`, `to`, `domain`, `title`, `message`, `pass`, `file`)
    //         VALUES('$date', '$time', 'from', '$to', 'domain', '$title', '$message', '$pass', 'file')";

    //     if(mysqli_query($conn, $sql)){
    //         echo "File Sucessfully uploaded";
    //     }else{
    //         echo "Error";
    //     }
    // }
    // mysqli_close($conn);



    // //sending mailer
    try {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mateuszjanicki3p1@gmail.com';
        $mail->Password   = $pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('mateuszjanicki3p1@gmail.com');
        $mail->addAddress($to);   
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>