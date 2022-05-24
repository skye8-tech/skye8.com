<?php

/**
 * Class Core
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

include PATH.'/functions/functions.php';

class Core {

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Template
     */
    private $template;

    /**
     * @var Mail
     */
    private $mail;

    /**
     * @var DataBase
     */
    private $db;

    /**
     * @var Logs
     */
    private $logs;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var int
     */
    private $starTime;

    /**
     * @var Core
     */
    private static $instance;

    /**
     * Core constructor.
     */
    function __construct() {
        if(self::$instance) {
            $this->db = &self::$instance->db;
            $this->mail = &self::$instance->mail;
            $this->logs = &self::$instance->logs;
            $this->cache = &self::$instance->cache;
            $this->request = &self::$instance->request;
            $this->settings = &self::$instance->settings;
            $this->template = &self::$instance->template;
            $this->starTime = &self::$instance->starTime;
        } else {
            self::$instance = $this;
            $this->starTime = time();
            $this->setHeader();
            $this->db = new DataBase();
            $this->mail = new Mail();
            $this->logs = new Logs($this);
            $this->cache = new Cache();
            $this->request = new Request();
            $this->settings = new Settings();
            $this->template = new Template($this->getTemplatePath(), '.tpl');

            date_default_timezone_set($this->settings->settings['timezone']);
        }
    }

    /**
     * @return void
     */
    private function setHeader(){
        header("X-Powered-By: HammerBlog CMS");
    }

    /**
     * @return string
     */
    private function getTemplatePath(){
        if($this->request->getRoutes(1) !== 'admin'){
            return PATH . '/public/templates/' . $this->settings->settings['template'] . '/tpl/';
        }
        return PATH . '/admin/public/tpl/';
    }

    /**
     * @return string
     */
    public function getRootDir() {
        return dirname(__DIR__);
    }

    /**
     * @return int
     */
    public function getStartTime(){
        return $this->starTime;
    }

    /**
     * @return DataBase
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * @return Template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * @return Request
     */
    public function getRequest(){
        return $this->request;
    }

    /**
     * @return Cache
     */
    public function getCache(){
        return $this->cache;
    }

    /**
     * @return Mail
     */
    public function getMail(){
        return $this->mail;
    }

    /**
     * @return Logs
     */
    public function getLogs(){
        return $this->logs;
    }

    /**
     * @return Settings
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * @return bool
     */
    public function notEmpty(){
        $args = func_get_args();
        $result = true;

        foreach ($args as $t) {
            if(empty($t)){
                $result = $result ? false : false;
            }
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isString(){
        $args = func_get_args();
        $result = true;

        foreach ($args as $t) {
            if(!is_string($t)){
                $result = $result ? false : false;
            }
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isArray(){
        $args = func_get_args();
        $result = true;

        foreach ($args as $t) {
            if(!is_array($t)){
                $result = $result ? false : false;
            }
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isInt(){
        $args = func_get_args();
        $result = true;

        foreach ($args as $t) {
            if(!is_numeric($t)){
                $result = $result ? false : false;
            }
        }
        return $result;
    }

    /**
     * @param string $date
     * @return bool
     */
    public function checkDateFormat($date){
        if(preg_match('/\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}/', $date)) {
            return true;
        }
        return false;
    }

    /**
     * @return false|string
     */
    public function getDate(){
        return date('Y-m-d G:i:s');
    }

    /**
     * @param string $data
     * @return mixed
     */
    function parseJSON($data){
        return json_decode(htmlspecialchars_decode($data), true);    
    }

    /**
     * @param array $data
     * @param bool $flag
     * @return void
     */
    public function jsonToArray(&$data, $flag = false){
        if($data !== false){
            if($flag){
                foreach($data as &$t){
                    $t['specification'] = $this->parseJSON($t['specification']);
                    $t['elements'] = $this->parseJSON($t['elements']);
                    $t['images'] = $this->parseJSON($t['images']);
                    $t['slider'] = $this->parseJSON($t['slider']);
                    $t['video'] = $this->parseJSON($t['video']);
                    $t['form'] = $this->parseJSON($t['form']);
                }
            }else{
                $data['specification'] = $this->parseJSON($data['specification']);
                $data['elements'] = $this->parseJSON($data['elements']);
                $data['images'] = $this->parseJSON($data['images']);
                $data['slider'] = $this->parseJSON($data['slider']);
                $data['video'] = $this->parseJSON($data['video']);
                $data['form'] = $this->parseJSON($data['form']);
            }
        }
    }

    /**
     * @param array $data
     * @param bool $flag
     * @return void
     */
    public function decodeImages(&$data, $flag = false){
        if($data !== false){
            if($flag){
                foreach($data as &$t){
                    $t['images'] = $this->parseJSON($t['images']);
                }
            }else{
                $data['images'] = $this->parseJSON($data['images']);
            }
        }
    }

    /**
     * @param array $data
     * @param bool $flag
     */
    public function decodeHtml(&$data, $flag = false){
        if($flag){
            foreach($data as &$t){
                $t['shortentry'] = htmlspecialchars_decode($t['shortentry']);
                $t['fullentry'] = htmlspecialchars_decode($t['fullentry']);
                $t['content'] = htmlspecialchars_decode($t['content']);
            }
        }else{
            $data['shortentry'] = htmlspecialchars_decode($data['shortentry']);
            $data['fullentry'] = htmlspecialchars_decode($data['fullentry']);
            $data['content'] = htmlspecialchars_decode($data['content']);
        }
    }

    /**
     * @return void
     */
    public function setHeaderJSON(){
        header('Content-Type: application/json; charset=utf-8');
    }

    /**
     * @param $data
     * @param $availableFields
     * @param $toIntFields
     * @return array
     */
    public function buildSQLAddArray($data, $availableFields, $toIntFields){
        $fields = ''; $values = '';
        foreach($data as $key => $value){
            if(in_array($key, $availableFields)){
                $fields .= '`'.$key.'`, ';
                if(in_array($key, $toIntFields)){
                    $values .= intval($value);
                }elseif ($this->isArray($value)){
                    $values .= "'".implode(",", array_filter($value, function($v) { return $v !== ''; }))."'";
                }elseif($this->isString($value)){
                    $values .= "'".htmlspecialchars($value, ENT_QUOTES)."'";
                }else{
                    $values .= $value;
                }
                $values .= ', ';
            }
        }
        return array(
            'fields' => rtrim($fields, ', '),
            'values' => rtrim($values, ', ')
        );
    }

    /**
     * @param $data
     * @param $availableFields
     * @param $toIntFields
     * @return array
     */
    public function buildSQLUpdateArray($data, $availableFields, $toIntFields){
        $sets = '';
        foreach($data as $key => $value){
            if(in_array($key, $availableFields) && $key != 'id'){
                $sets .= '`'.$key.'` = ';
                if(in_array($key, $availableFields)){
                    if(in_array($key, $toIntFields)){
                        $sets .= intval($value);
                    }elseif ($this->isArray($value)){
                        $sets .= "'".implode(",", array_filter($value, function($v) { return $v !== ''; }))."'";
                    }elseif($this->isString($value)){
                        $sets .= "'".htmlspecialchars($value, ENT_QUOTES)."'";
                    }else{
                        $sets .= $value;
                    }
                    $sets .= ', ';
                }
            }
        }
        return array(
            'sets' => rtrim($sets, ', '),
        );
    }
    
    /**
     * @return bool
     */
    public function sessionStart() {
        return session_start();
    }

    /**
     * @return void
     */
    public function sessionUnset() {
        session_unset();
    }

    /**
     * @return bool
     */
    public function sessionDestroy() {
        return session_destroy();
    }

    /**
     * @return bool
     */
    public function sessionAbort(){
        return session_abort();
    }

    /**
     * @param string|null $name
     * @return string
     */
    public function sessionName($name = null){
        return $this->isString($name) ? session_name($name) : session_name();
    }

    /**
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function sessionSetValue($name, $value){
        $_SESSION[md5($name)] = base64_encode($value);
    }

    /**
     * @param mixed $name
     * @return mixed
     */
    public function sessionGetValue($name){
        return base64_decode($_SESSION[md5($name)]);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $time
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return bool
     */
    public function setCookie($key, $value, $time = 0, $path = null, $domain = null, $secure = false, $httpOnly = false) {
        return setcookie(md5($key), base64_encode($value), $time, $path, $domain, $secure, $httpOnly);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCookie($key) {
        if(isset($_COOKIE[md5($key)])){
            return base64_decode($_COOKIE[md5($key)]);
        }else{
            return false;
        }

    }
}