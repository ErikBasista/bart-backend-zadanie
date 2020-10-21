<?php

namespace App\Http\Controllers;

use Facebook;

class FacebookAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function facebookLogin(){
        $fb = $this->fbCredentials();

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://localhost/token', $permissions);

        echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

    }

    public function userProfile(){
        $fb = $this->fbCredentials();

        try {
            // Returns a `Facebook\Response` object
            $response = $fb->get('/me?fields=id,name', '{access-token}');
        } catch(Facebook\Exception\ResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exception\SDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $response = $fb->get('/me?fields=id,name', '{access-token}');

        $user = $response->getGraphUser();

        echo 'Name: ' . $user['name'];
        // OR
        // echo 'Name: ' . $user->getName();
    }

    public function my(){
        $fb = $this->fbCredentials();

        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
                '1053174974861205',
                'EAAFtk2AnBLwBAOhNP7AIdMmNBK5Hi8Es2BrKHXUwsZBBsdhxcvWgsUZA6QqsZCNZB6mkrfoNog1JWWT1VGaTdSxi3OCRMjPqPIrfRIxkTHZCfqbAmimpTW72BQOqUB1VzIcEAK3Ul7TxZAWyoh9oSSuJQRy1ZALH52uw8IxMRMFAQXyMt618gPn4u5hH7g7uQQZD'
            );
        } catch(FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
        //return response()->json($graphNode['id']);
        echo $graphNode;

    }

    public function facebookCallback(){
        $fb = $this->fbCredentials();

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exception\ResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exception\SDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($config['app_id']);
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exception\SDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;
    }

    private function fbCredentials(){
        return $fb = new Facebook\Facebook([
            'app_id' => '1053174974861205',
            'app_secret' => '0e083b427faffaa6596d2df3893b42ab',
            'default_graph_version' => 'v2.10',
        ]);
    }
}
