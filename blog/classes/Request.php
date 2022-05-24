<?php

/**
 * Class Request
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Request{

    /**
     * @var string
     */
    private $routes;

    /**
     * Request constructor.
     */
    function __construct() {
        $url = $this->getRequest();
        $utm = stristr($url, '?utm');
        if($utm !== FALSE) {
            $url = str_replace($utm, '', $url);
        }
        $this->routes = explode('/', $url);
    }

    /**
     * @return string
     */
    public function getProtocol(){
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
    }

    /**
     * @return string
     */
    public function getURL(){
        return $this->getProtocol().$this->getHTTPHost().$this->getRequest();
    }

    /**
     * @return string
     */
    public function getBaseURL(){
        return $this->getProtocol().$this->getHTTPHost();
    }

    /**
     * @return mixed
     */
    public function getRequest(){
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @param int $num
     * @return mixed
     */
    public function getRoutes($num = null){
        return is_numeric($num) ? $this->routes[$num] : $this->routes;
    }

    /**
     * @return int
     */
    public function getRoutesCount(){
        return count($this->routes) - 1;
    }

    /**
     * @return string
     */
    public function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return string
     */
    public function getHTTPHost() {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return bool
     */
    public function isSearchBot(){
        $bots = array(
            'Yandex',
            'Google',
            'Mail',
            'Rambler',
            'Yahoo',
            'msnbot',
            'bingbot',
            'AhrefsBot'
        );
        foreach($bots as $t){
            if(strstr($this->getUserAgent(), $t)){
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isPOST(){
        return $this->getMethod() == 'POST' ? true : false;
    }

    /**
     * @return bool
     */
    public function isAdminPath(){
        return $this->routes[1] == 'admin';
    }

    /**
     * @return string
     */
    public function getUserIP() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * @param array|string $keys
     * @return mixed
     */
    public function getGETValues($keys = null){
        $array = $_GET;
        if(is_array($keys)){
            $temp = array();
            foreach($keys as $t){
                $temp[$t] = $array[$t];
            }
            return $temp;
        }else{
            return isset($keys) ? $array[$keys] : $array;
        }
    }

    /**
     * @param array|string $keys
     * @return mixed
     */
    public function getPOSTValues($keys = null){
        $array = $_POST;
        if(is_array($keys)){
            $temp = array();
            foreach($keys as $t){
                $temp[$t] = $array[$t];
            }
            return $temp;
        }else{
            return isset($keys) ? $array[$keys] : $array;
        }
    }
}