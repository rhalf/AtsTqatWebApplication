<?php

/**
 * 
 */
class system_sessions {

    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;
    private static $instance;

    /**
     * 
     */
    public function __construct() {
        //if (!isset($_SESSION)){
        // session_start();
        //}
        // if ($Create)
        //     session_regenerate_id(true);
    }

    /**
     * 
     * @return type
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }

    /**
     * 
     * @return type
     */
    public function startSession() {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }
        return $this->sessionState;
    }

    /**
     * regenarate the session id
     */
    public function newid() {
        session_regenerate_id(true);
    }

    /**
     * 
     * @param type $key
     * @param type $value
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function get($key) {
        if ($this->is_set($key)) {
            return $_SESSION[$key];
        }
    }

    /**
     * 
     * @param type $key
     * @return boolean
     */
    public function is_set($key) {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $key
     */
    public function un_set($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * 
     * @return boolean
     */
    public function Destroy() {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            // session_unset(); // need to be called before session_destroy()
            //session_destroy();	
            //session_destroy();
            $cookieParams = session_get_cookie_params();
            setcookie(session_name(), '', 0, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
            unset($_SESSION);
            return !$this->sessionState;
        }
        return FALSE;
    }

    /**
     * 
     * @param type $userid
     * @param type $username
     * @param type $userPass
     * @param type $userCmpDB
     * @param type $userCmp
     * @param type $userCmpDisplay
     * @param type $timezone
     * @param type $priv
     * @param type $udb
     * @param type $lang
     */
    public function validateUser($userid, $username, $userPass, $userCmpDB, $userCmp, $userCmpDisplay, $timezone, $priv, $udb, $lang) {
        $this->set('valid', 1);
        $this->set('userid', $userid);
        $this->set('userName', $username);
        $this->set('userPass', $userPass);
        $this->set('userCmpdb', $userCmpDB);
        $this->set('userCmp', $userCmp);
        $this->set('userCmpDisplay', $userCmpDisplay);
        $this->set('timezone', $timezone);
        $this->set('priv', $priv);
        $this->set('udb', $udb);
        $this->set('language', $lang);
    }

    /**
     * 
     * @param type $userid
     * @param type $userPass
     * @param type $lang
     */
    public function validateMaster($userid, $userPass, $lang) {
        $this->set('mvalid', 1);
        $this->set('muserid', $userid);
        $this->set('muserPass', md5($userPass));
        $this->set('language', $lang);
    }

    /**
     * 
     */
    public function logout() {
        $this->Destroy();
    }

    /**
     * 
     * @return type
     */
    public function getID() {
        return session_id();
    }

    /**
     * 
     * @return boolean
     */
    public function isLoggedIn() {
        if (isset($_SESSION['valid']) && isset($_SESSION['userid']) && isset($_SESSION['userPass']) &&
            isset($_SESSION['userCmp'])) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @return boolean
     */
    public function isMasterLoggedIn() {
        if (isset($_SESSION['mvalid']) && $_SESSION['muserid'] && $_SESSION['muserPass']) {
            return true;
        }
        return false;
    }

}

?>