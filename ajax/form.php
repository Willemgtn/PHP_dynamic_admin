<?php 
include('../config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    $data = array(
        'success' => false,

    );

    if(isset($_POST['form']) && $_POST['form'] == 'dash'){
        if(isset($_POST['email']) && $_POST['email'] != ''){
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                // echo '<script>alert("Invalid e-mail format")</script>';
                $data['msg'] = 'Invalid e-mail format';
            } else {
                $mail = new Email();
                $mail -> addrecipient ($email, 'john doe');
                $mail -> formatMail(array(
                    'subject' => 'php development',
                    'body' => 'it <strong>works</strong><hr> é isso aí ÂÊÎÔÛáéíóúàèìòùÏï Wï'
                ));
                
                if($mail -> sendEmail()){
                    $data['success'] = true;
                    $data['msg'] = 'E-mail cadastrado com sucesso.';
                } else {
                    $data['msg'] = 'E-mail could not be send. Internal error.';
                }
            }
        } else { 
            // echo '<script>alert("No e-mail provided")</script>';
            $data['msg'] = 'No e-mail provided.';
        }
    // } else if(isset($_POST['contactSend'])){         //Ajax does not send the submit name and value in the requests with serialize.
    } else if(isset($_POST['form']) && $_POST['form'] == 'contact'){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $mensagem = $_POST['mensagem'];


        $emailBody = '';
        foreach ($_POST as $key => $value) {
            $emailBody .= ucfirst($key).": ".$value."<hr>";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            // echo '<script>alert("Invalid e-mail format")</script>';
            $data['msg'] = 'Invalid e-mail format';
        } else if (false){
            // Future validation, name, telephone.
        } else {
            $mail = new Email();
            $mail -> addrecipient ($email, 'Developer');
            $mail -> formatMail(array(
                'subject' => 'New Contact - php in development',
                'body' => $emailBody
            ));
        }
        
        if($mail -> sendEmail()){
            $data['success'] = true;
            $data['msg'] = 'Formulario enviado com sucesso.';

        } else {
            $data['msg'] = 'E-mail could not be send. Internal error.';
        }
    }
    die(json_encode($data));


    // $data = [];
    // $emailBody = '';
    // foreach ($_POST as $key => $value) {
    //     $emailBody .= ucfirst($key).": ".$value."<hr>";
    // }
    // $mail = new Email();
    // $mail -> addrecipient ('a.w.cerqueira@gmail.com', 'Developer');
    // $mail -> formatMail(array(
    //     'subject' => 'New Contact - php in development',
    //     'body' => $emailBody
    // ));


    // if($mail -> sendEmail()){
    //     $data['sucess'] = true;
    // } else {
    //     $data['error'] = true;
    // }

    // die(json_encode($data));
?>