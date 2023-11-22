<?php 
    // echo "Cwd: " . getcwd();
    // include('../config.php'); 


    use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;
    // use PHPMailer\PHPMailer\SMTP;
    // require_once 'PHPMailer/src/PhpMailer.php';
    // require getcwd().'/classes/PHPMailer/src/PhpMailer.php';
    
    // require_once '../classes/PHPMailer/src/PHPMailer.php';
    // require_once '../classes/PHPMailer/src/Exception.php';
    // require_once '../classes/PHPMailer/src/SMTP.php';
    

    class Email {

        private $mail;
        private $username = EMAIL_USERNAME;
        private $password = EMAIL_PASSWORD;
        private $host = EMAIL_HOST;     
        private $nickname = 'PHPMailer in development';

        function __construct(){
        
            $this -> mail = new PHPMailer(true);
            
            // try {
                //Server settings
                // $this -> mail->SMTPDebug = SMTP::DEBUG_SERVER;                          //Enable verbose debug output
                $this -> mail->isSMTP();                                                //Send using SMTP
                $this -> mail->Host       = $this -> host;                              //Set the SMTP server to send through
                $this -> mail->SMTPAuth   = true;                                       //Enable SMTP authentication
                $this -> mail->Username   = $this -> username;                          //SMTP username
                $this -> mail->Password   = $this -> password;                          //SMTP password
                $this -> mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                //Enable implicit TLS encryption
                $this -> mail->Port       = 465;                                        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $this -> mail->setFrom($this -> username, $this -> nickname);
                // $mail->addAddress('john@gmail.com', 'Joe User');     //Add a recipient
                // $mail->addAddress('ellen@example.com');               //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                // //Content
                // $mail->isHTML(true);                                  //Set email format to HTML
                // $mail->Subject = 'Here is the subject';
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                // $mail->send();
                // echo 'Message has been sent';
            // } catch (Exception $e) {
            //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // };
        }

        public function addrecipient($email, $name){
            $this -> mail -> addAddress($email, $name);     //Add a recipient

        }
        public function formatMail ($info){
             //Attachments
            // $this -> mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $this -> mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this -> mail->isHTML(true);                                  //Set email format to HTML
            $this -> mail->CharSet = 'UTF-8';
            $this -> mail->Subject = $info['subject'];
            $this -> mail->Body    = $info['body'];
            $this -> mail->AltBody = strip_tags($info['body']);
        }
        public function sendEmail(){
            if($this -> mail -> send()){
                // echo 'Message has been sent';
                // echo '<script>alert("E-mail has been send.")</script>';
                return true;
            } else {
                // echo "Message could not be sent. Mailer Error: {$this -> mail->ErrorInfo}";
                // echo '<script>alert(Error: E-mail could not be send.")</script>';
                return false;
            }
        }
    }
?>