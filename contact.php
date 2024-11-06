<?php
session_start();
require_once 'vendor/autoload.php';

if(isset($_POST['sendBtn'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
    ->setUsername('jukotee@gmail.com')
    ->setPassword('jnwaqjawaltrsrqn')
    ;

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    $bodyContent = "<h3> You have a new enquiry</h3>
        <h4>Name: ".$name." </4>
        <h4>Email: ".$email."</4>
        <h4>Subject: ".$subject."</4>
        <h4>Mesage: ".$message."</4>
    ";

    // Create a message
    $message = (new Swift_Message())

        ->setSubject("New enquiry from Web Contact Form")
        ->setFrom([$email => $name])
        ->setTo(['rivasbookstoreltd@gmail.com' => 'Rivas Bookstore']) //Change this email address to your email address
        ->setBody($bodyContent, 'text/html')
        ;

    // Send the message
    $result = $mailer->send($message);
    // You can also use Sendmail as a transport:
    
    // Sendmail
    $transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');
    if($result){
        $_SESSION['status'] = "Your message has been sent successfully.";
        header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit(0);
    }else{
        $_SESSION['status'] = "Oop! Something went wrong. Please try again.";
        header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit(0);
    }
}else{
    header("Location: index.php");
        exit(0);
}