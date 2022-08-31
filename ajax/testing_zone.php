<?php 
include('../config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    


    $data = array(
        'success' => false,
        'msg' => 'This is a test message'
    );
    $emailBody = '';
    foreach ($_POST as $key => $value) {
        // $emailBody .= ucfirst($key).": ".$value."<hr>";
        $data[$key] = $value;
    }
    $mail = new Email();
    // $mail -> addrecipient ('a.w.cerqueira@gmail.com', 'Developer');
    // $mail -> formatMail(array(
    //     'subject' => 'New Contact - php in development',
    //     'body' => $emailBody
    // ));


    

    die(json_encode($data));
?>