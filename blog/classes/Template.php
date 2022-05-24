<?php

/**
 * Class Template
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Template {

    /**
     * @var string
     */
    protected $dir;

    /**
     * @var string
     */
    protected $ext;

    /**
     * @var string
     */
    protected $out;

    /**
     * @var array
     */
    protected $bloc = array();

    /**
     * @var array
     */
    protected $var = array();
    
    
    /**
     * @param string $dir
     * @param string $ext
     * Template constructor.
     */
    public function __construct($dir, $ext) {
        $this->dir = $dir;
        $this->ext = $ext;
    }

    /**
     * @param string $file
     * @param array $data
     */
    public function main($file, $data = null) {
        $this->out = $this->compile($this->get($file), $file, $data);
    }
    
    /**
     * @param string $source
     * @param string $file
     * @param array $data
     * @param bool $compression
     * @return string
     */
    protected function compile($source, $file, $data = array(), $compression = true) {
        ob_start();
        eval('?>' . $source . '<?php ');
        $html = ob_get_contents();
        ob_end_clean();
        if($compression){
            return preg_replace('/^\s+|\n|\r|\t|\s+$/m', '', $html);
        }
        return $html;
    }

    /**
     * @param string $file
     * @return string
     */
    public function get($file) {
        return file_get_contents($this->dir . $file . $this->ext);
    }

    /**
     * @param string $bloc
     * @param string $file
     * @param array $data
     * @param bool $compression
     */
    public function bloc($bloc, $file, $data = array(), $compression = true) {
        if($file !== ''){
            $this->var[$bloc] = $this->compile($this->get($file), $file, $data, $compression);
        }else{
            $this->set($bloc, '');
        }
    }

    /**
     * @param string $file
     * @param array $data
     * @param bool $compression
     * @return string
     */
    public function compileBloc($file, $data = array(), $compression = true) {
        return $this->compile($this->get($file), $file, $data, $compression);
    }

    /**
     * @param string $str
     * @param array $data
     * @param array $data
     * @param bool $compression
     * @return string
     */
    public function compileStr($str, $data = array(), $compression = true) {
        return $this->compile($str, 'str', $data, $compression);
    }

    /**
     * @param $dir
     * @param $data
     * @param $out
     * @return bool
     */
    public function createFlyOds($dir, $data, $out) {
        $dir = $this->dir.$dir;
        if (extension_loaded('zip')) {
            if (file_exists($dir)) {
                $zip = new ZipArchive();
                $fileT = tempnam('tmp', 'ods-tmp');
                if ($zip->open($fileT, ZIPARCHIVE::OVERWRITE)) {
                    $dir = realpath($dir);
                    if (is_dir($dir)) {
                        $iterator = new RecursiveDirectoryIterator($dir);
                        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
                        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = realpath($file);
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($dir . '\\', '', str_replace($dir . '/', '', $file . '')));
                            } else if (is_file($file)) {
                                if(strripos($file, 'content.xml')){
                                    ini_set('short_open_tag', '0');
                                    $content = $this->compileStr(file_get_contents($file), $data, false);
                                    ini_set('short_open_tag', '1');
                                }else{
                                    $content = file_get_contents($file);
                                }
                                $zip->addFromString(str_replace($dir . '\\', '', str_replace($dir . '/', '', $file)), $content);
                            }
                        }
                    } else if (is_file($dir)) {
                        $zip->addFromString(basename($dir), file_get_contents($dir));
                    }
                }
                $zip->close();
                header('Content-Type: application/ods');
                header('Content-Length: ' . filesize($fileT));
                header('Content-Disposition: attachment; filename="'.$out.'"');
                readfile($fileT);
                unlink($fileT);
            }
        }
        return false;
    }

    /**
     * @param string $find
     * @param string $replace
     */
    public function set($find, $replace) {
        $this->var[$find] = $replace;
    }

    /**
     * @return void
     */
    public function out() {
        foreach($this->var as $find => $replace) {
            $this->out = str_replace($find, $replace, $this->out);
        }
        echo $this->out;
    }

    /**
     * @return string
     */
    public function getOut() {
        foreach($this->var as $find => $replace) {
            $this->out = str_replace($find, $replace, $this->out);
        }
        return $this->out;
    }

}