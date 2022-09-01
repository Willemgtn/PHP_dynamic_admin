<?php
    use Facebook\Facebook;
    use Facebook\Exceptions\FacebookResponseException;
    use Facebook\Exceptions\FacebookSDKException;
    

    require_once './classes/Facebook/autoload.php';

    $redirectUrl = 'http://localhost/danki/dev1.0/projeto/?url=login&auth=fb';
    $fbPermission = ['email'];
    $fb = new Facebook(array(
        'app_id' => FB_APP_ID,
        'app_secret' => FB_APP_SECRET,
        'default_graph_version' => 'v2.10',
    ));
    // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
    $helper = $fb->getRedirectLoginHelper();
    //   $helper = $fb->getJavaScriptHelper();
    //   $helper = $fb->getCanvasHelper();
    //   $helper = $fb->getPageTabHelper();

    if (isset($_GET['logout']) && $_GET['logout'] == 'fb'){
        unset($_SESSION['facebook_access_token']);
        unset($_SESSION['userData']);
    }
    try{
        if(isset($_SESSION['facebook_access_token'])){
            $accessToken = $_SESSION['facebook_access_token'];
        } else {
            $accessToken = $helper -> getAccessToken();
        }
    } catch(FacebookResponseException $e){
        echo '1. Graph returned an error: ' . $e->getMessage();

    }
    if(isset($accessToken)){
        echo "AccessToken: $accessToken <hr>";
        if(isset($_SESSION['facebook_access_token'])){
            $fb -> setDefaultAccessToken($_SESSION['facebook_access_token']);
        } else {
            $_SESSION['facebook_access_token'] = (string)$accessToken;
            $oAuth2Client = $fb -> getOAuth2Client();
            $longLivedAccessToken = $oAuth2Client -> getLongLivedAccessToken($_SESSION['facebook_access_token']);
            $_SESSION['facebook_access_token'] = (string)$longLivedAccessToken;
            $fb -> setDefaultAccessToken($_SESSION['facebook_access_token']);
        }

        if(isset($_GET['code'])){
            header('Location: ./?url=login');
            // Painel::redirect('./?url=login');
        }
        try {
            $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
            $fbUserProfile = $profileRequest -> getGraphNode() -> asArray();
            
            $_SESSION['userData'] = array_merge(['oath_provider' => 'facebook'],$fbUserProfile);
            $logoutUrl = $helper -> getLogoutUrl($accessToken, $redirectUrl.'&logout=fb');

            if(!empty($fbUserProfile)){
                echo '<hr>' . 
                    '<a href="' . $logoutUrl . '">Logout</a>'
                    . '<hr>';
            }

        } catch(FacebookResponseException $e) {
            // $fbUserData = [
            //     'oauth_provider' => 'facebook',
            //     'oauth_uid' => $fbUserProfile['id'],
            //     'first_name' => $fbUserProfile['first_name'],
            //     'last_name' => $fbUserProfile['last_name'],
            // ];
            // $userData = $fbUserData;
            // print_r($userData);
           

            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            // exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            // exit;
        }
          
        //   $me = $response->getGraphUser();
        //   echo 'Logged in as ' . $me->getName();
    } else {
        // Could not set the accessToken
        $loginUrl = $helper -> getLoginUrl($redirectUrl, $fbPermission);
        echo '<hr>' . 
            '<a href="' . $loginUrl . '">Login com o Facebook</a>'
            . '<hr>';
    }
    echo "<pre>";
    // print_r($fbUserProfile);
    print_r($_SESSION);
    echo "</pre>";

    
?>