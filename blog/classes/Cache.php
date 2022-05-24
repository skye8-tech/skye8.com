<?php

/**
 * Class Cache
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Cache{

    /**
     * @var string
     */
    private $path;

    /**
     *
     */
    public function __construct(){
        $this->path = PATH. '/cache/';
    }
    
    /**
     * @param string $type
     * @param string $method
     * @param array $param
     * @return bool|mixed
     */
    public function readCache($type, $method, $param){
        $file = $this->path.$type.'/'. mb_ereg_replace('([^\w\s\d\-_~,;\[\]\(\).])', '', $method).'-'.implode('-', $param);
        if (strlen($file) < 200 && file_exists($file)){
            return unserialize(file_get_contents($file));
        }else{
            return false;
        }
    }

    /**
     * @param string $type
     * @param string $method
     * @param array $param
     * @param mixed $data
     * @return mixed
     */
    public function writeCache($type, $method, $param, $data){
        $file = $this->path.$type.'/'. mb_ereg_replace('([^\w\s\d\-_~,;\[\]\(\).])', '', $method).'-'.implode('-', $param);
        if(strlen($file) < 200){
            $handle = fopen($file, 'w');
            fwrite($handle, serialize($data));
            fclose($handle);
        }
        return $data;
    }

    /**
     * @return array
     */
    public function buildParam(){
        $param = func_get_args();
        foreach ($param as &$t){
            $t = is_array($t) ? $t : [$t];
        }
        return call_user_func_array('array_merge', $param);
    }

    /**
     * @param string $type
     */
    public function clear($type){
        array_map('unlink', glob($this->path.$type.'/*'));
    }

    /**
     * @return bool
     */
    public function clearAll(){
        return deleteFilesInDir($this->path);
    }
}