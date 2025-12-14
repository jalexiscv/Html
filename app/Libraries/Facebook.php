<?php

namespace App\Libraries;

require_once(APPPATH . 'ThirdParty/Facebook/autoload.php');

use Higgs\I18n\Time;
use Facebook\Facebook as FB;
use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Helpers\FacebookJavaScriptHelper;
use Facebook\Helpers\FacebookRedirectLoginHelper;

class Facebook
{

    /**
     * @var FB
     */
    private $fb;

    /**
     * @var FacebookRedirectLoginHelper|FacebookJavaScriptHelper
     */
    private $helper;
    private $facebook_app_id;
    private $facebook_app_secret;
    private $facebook_login_redirect_ur;
    private $facebook_logout_redirect_url;
    private $facebook_login_type;
    private $facebook_permissions;
    private $facebook_graph_version;
    private $facebook_auth_on_load;
    private $session;

    /**
     * Facebook constructor.
     */
    public function __construct()
    {
        $this->session = session();
        /*
          |  facebook_app_id               string   Your Facebook App ID.
          |  facebook_app_secret           string   Your Facebook App Secret.
          |  facebook_login_redirect_url   string   URL to redirect back to after login. (do not include base URL)
          |  facebook_logout_redirect_url  string   URL to redirect back to after logout. (do not include base URL)
          |  facebook_login_type           string   Set login type. (web, js, canvas)
          |  facebook_permissions          array    Your required permissions.
          |  facebook_graph_version        string   Specify Facebook Graph version. Eg v3.2
          |  facebook_auth_on_load         boolean  Set to TRUE to check for valid access token on every page load.
         */
        $this->facebook_app_id = '606871226577710';
        $this->facebook_app_secret = 'e8e9507bc09aa625d2e4849e9ceca78e';
        $this->facebook_login_redirect_url = '/facebook/authentication'; // Debe ser totalmente exacta sin / al final o dara error
        $this->facebook_logout_redirect_url = '/facebook/authentication/logout';
        $this->facebook_login_type = 'web';
        $this->facebook_permissions = array('email');
        $this->facebook_graph_version = 'v3.2';
        $this->facebook_auth_on_load = TRUE;
        if (!isset($this->fb)) {
            $this->fb = new FB([
                'app_id' => $this->facebook_app_id,
                'app_secret' => $this->facebook_app_secret,
                'default_graph_version' => $this->facebook_graph_version
            ]);
        }
        switch ($this->facebook_login_type) {
            case 'js':
                $this->helper = $this->fb->getJavaScriptHelper();
                break;
            case 'canvas':
                $this->helper = $this->fb->getCanvasHelper();
                break;
            case 'page_tab':
                $this->helper = $this->fb->getPageTabHelper();
                break;
            case 'web':
                $this->helper = $this->fb->getRedirectLoginHelper();
                break;
        }
        if (isset($_GET['state'])) {
            $this->helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        if ($this->facebook_auth_on_load === TRUE) {
            $this->authenticate();
        }
    }

    /**
     * Get a new access token from Facebook
     *
     * @return array|AccessToken|null|object|void
     */
    private function authenticate()
    {
        $access_token = $this->get_access_token();
        if ($access_token && $this->get_expire_time() > (time() + 30) || $access_token && !$this->get_expire_time()) {
            $this->fb->setDefaultAccessToken($access_token);
            return $access_token;
        }
        if (!$access_token) {
            //echo("not have a stored access token or if it has expired, try get a new access token");
            try {
                $access_token = $this->helper->getAccessToken();
            } catch (FacebookResponseException $e) {
                echo("Graph returned an error: {$e->getCode()}: {$e->getMessage()}");
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            } catch (FacebookSDKException $e) {
                echo("Facebook SDK returned an error: {$e->getCode()}: {$e->getMessage()}");
                $this->logError($e->getCode(), $e->getMessage());
                return (null);
            }
            // If we got a session we need to exchange it for a long lived session.
            if (isset($access_token)) {
                $access_token = $this->long_lived_token($access_token);
                $this->set_expire_time($access_token->getExpiresAt());
                $this->set_access_token($access_token);
                $this->fb->setDefaultAccessToken($access_token);
                return $access_token;
            }
        }
// Collect errors if any when using web redirect based login
        if ($this->facebook_login_type === 'web') {
            if ($this->helper->getError()) {
// Collect error data
                $error = array(
                    'error' => $this->helper->getError(),
                    'error_code' => $this->helper->getErrorCode(),
                    'error_reason' => $this->helper->getErrorReason(),
                    'error_description' => $this->helper->getErrorDescription()
                );
                return $error;
            }
        }
        return $access_token;
    }

    /**
     * Get stored access token
     *
     * @return mixed
     */
    private function get_access_token()
    {
        $fat = $this->session->get('fb_access_token');
        return ($fat);
    }

    /**
     * @return mixed
     */
    private function get_expire_time()
    {
        return $this->session->get('fb_expire');
    }

    /**
     * @param $code
     * @param $message
     *
     * @return array
     */
    private function logError($code, $message)
    {
        log_message('error', '[FACEBOOK PHP SDK] code: ' . $code . ' | message: ' . $message);
        return ['error' => $code, 'message' => $message];
    }

    /**
     * Exchange short lived token for a long lived token
     *
     * @param AccessToken $access_token
     *
     * @return AccessToken|null
     */
    private function long_lived_token(AccessToken $access_token)
    {
        if (!$access_token->isLongLived()) {
            $oauth2_client = $this->fb->getOAuth2Client();
            try {
                return $oauth2_client->getLongLivedAccessToken($access_token);
            } catch (FacebookSDKException $e) {
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }
        }
        return $access_token;
    }

    /**
     * @param DateTime $time
     */
    private function set_expire_time($time = null)
    {
        if (!empty($time)) {
            //$dt= new DateTime($time);
            //$this->session->set('fb_expire', $dt->getTimestamp());
            $time = new Time();
            $t = $time::parse($time);
            $ts = $t->getTimestamp();
            $this->session->set('fb_expire', $ts);
        }
    }

    /**
     * Store access token
     *
     * @param AccessToken $access_token
     */
    private function set_access_token(AccessToken $access_token)
    {
        $this->session->set('fb_access_token', $access_token->getValue());
    }

    public function get_Permissions()
    {
        return ($this->facebook_permissions);
    }

    /**
     * @return FB
     */
    public function object()
    {
        return $this->fb;
    }

    /**
     * Check whether the user is logged in.
     * by access token
     *
     * @return mixed|boolean
     */
    public function is_authenticated()
    {
        $access_token = $this->authenticate();
        if (isset($access_token)) {
            return ($access_token);
        }
        return (false);
    }

    /**
     * Do Graph request
     *
     * @param       $method
     * @param       $endpoint
     * @param array $params
     * @param null $access_token
     *
     * @return array
     */
    public function request($method, $endpoint, $params = [], $access_token = null)
    {
        //$access_token=$this->get_access_token();
        try {
            $response = $this->fb->{strtolower($method)}($endpoint, $params, $access_token);
            return $response->getDecodedBody();
        } catch (FacebookResponseException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        } catch (FacebookSDKException $e) {
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Generate Facebook login url for web
     *
     * @return  string
     */
    public function login_url()
    {
        // Login type must be web, else return empty string
        if ($this->facebook_login_type != 'web') {
            return '';
        }
        $url = base_url() . $this->facebook_login_redirect_url;
        $permissions = $this->facebook_permissions;
        return $this->helper->getLoginUrl($url, $permissions);
    }

    /**
     * Generate Facebook logout url for web
     *
     * @return string
     */
    public function logout_url()
    {
// Login type must be web, else return empty string
        if ($this->facebook_login_type != 'web') {
            return '';
        }
// Get logout url
        return $this->helper->getLogoutUrl(
            $this->get_access_token(),
            base_url() . $this->facebook_logout_redirect_url
        );
    }

    /**
     * Destroy local Facebook session
     */
    public function destroy_session()
    {
        $this->session->set('fb_access_token', null);
    }

    /**
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @param $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        return $this->$$var;
    }

}

?>