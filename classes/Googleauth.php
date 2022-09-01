<?php 

    define('GOOGLE_OAUTH_API_ID', '694733661227-1nulfl8tdoejqosli4tb1fenc2nl7vmt.apps.googleusercontent.com');
    define('GOOGLE_OAUTH_API_SECRET', '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');
    use Google\Client as Google_Client;
    use Google\Service\Oauth2 as Google_Service;

    echo "<hr><pre>";
    print_r($_SESSION);
    echo "<hr></pre>";

    require_once './classes/Google/Client/autoload.php';
    // require_once './classes/Google/Auth/autoload.php';

    // require_once './classes/GuzzleHttp/Psr7/autoload.php';
    require './classes/autoload.php';

    $gClient = new Google_Client();
    $gClient -> setClientId(GOOGLE_OAUTH_API_ID);
    $gClient -> setClientSecret(GOOGLE_OAUTH_API_SECRET);
    $gClient -> setRedirectUri('http://localhost/danki/dev1.0/projeto/?url=login&auth=google');

    $gClient -> addScope('email');

    // if(isset($_GET['auth']) && $_GET['auth'] == 'google')
    if(!isset($_GET['code'])){
        // precisamos logar
        echo '<a href="' . $gClient -> createAuthUrl() . '"> Logar com sua conta google!</a>';
    } else if( $_GET['auth'] == 'google') {
        $token = $gClient -> fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION = $token;
        echo "Token : <pre>";
        print_r($token);
        echo "</pre>";
        
    }
    if(!isset($token['error']) && isset($_SESSION['access_token'])){

        $_SESSION['access_token'] = $token['access_token'];
        $gClient -> setAccessToken($_SESSION['access_token']);
        // print_r($gClient );
        // $google_service = new google_service_oauth2($gClient);
        $google_service = new Google_Service($gClient);
        // $gClient -> 
        // $data = $google_service -> userinfo -> get();
        $data = $google_service -> userinfo -> get();
        echo "Login Data : <pre>";
        print_r($data);
        echo "</pre>";
    }

        // TODO : 
        // Persistence.
        // User info is correctly retrieved
