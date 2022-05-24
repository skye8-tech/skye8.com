<?php

/**
 * Class Installer
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

class Installer{

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Template
     */
    private $template;

    /**
     * @var Installer
     */
    private static $instance;

    /**
     * Installer constructor.
     */
    function __construct() {
        if (self::$instance) {
            $this->template = &self::$instance->template;
            $this->settings = &self::$instance->settings;
        } else {
            self::$instance = $this;
            $this->settings = new Settings();
            $this->template = new Template(
                Registry::get('templates-dir'),
                Registry::get('templates-ext')
            );
        }
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function checkLicenseKey($key = null){
        $key = $key ? $key : $this->settings->settings['license-key'];
        $domain = getenv("HTTP_HOST");
        if(substr(md5(substr(md5('def261bfc2'.str_replace('www.', '', $domain)), 0, 9)), 0 , 9) === $key){
            return true;
        }else{
            return false;
        }
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
     * @return Settings
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * @return Template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * @param int $route
     * @return int | array
     */
    public function getRoute($route = 0) {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if ($route == 0) {
            return $routes;
        } else {
            return $routes[$route];
        }
    }

    /**
     * @return bool
     */
    public function sessionStart() {
        return session_start();
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
        if (isset($_COOKIE[md5($key)])) {
            return base64_decode($_COOKIE[md5($key)]);
        } else {
            return false;
        }

    }

    /**
     * @return array
     */
    public function checkSystem() {
        return array(
            'php-version' => phpversion(),
            'php-5-4' => phpversion() < '5.4' ? 0 : 1,
            'curl' => function_exists('curl_version') ? 1 : 0,
            'is-mysql' => function_exists('mysqli_connect') ? 1 : 0,
            'output-buffering' => ini_get('output_buffering') ? 1 : 0,
            'magic-quotes-runtime' => ini_get('magic_quotes_runtime') ? 'yes' : 0,
            'magic-quotes-gpc' => ini_get('magic_quotes_gpc') ? 1 : 0,
            'register-globals' => ini_get('register_globals') ? 1 : 0,
            'session-auto-start' => ini_get('session.auto_start') ? 1 : 0
        );
    }

    /**
     * @return array
     */
    public function checkFiles() {
        $files = array(
            '../cache/statistics',
            '../cache/comments',
            '../cache/category',
            '../cache/content',
            '../files/uploads',
            '../files/images',
            '../cache/pages',
            '../cache/tags',
            '../files/images/thumbnail',
            '../config/db-config.php',
            '../data/settings.php',
            '../data/log'
        );

        $result = array();

        foreach ($files as $file) {
            if (!file_exists($file)) {
                $status = array(
                    'file' => str_replace('..', '', $file),
                    'text' => 'not found!',
                    'error' => 1,
                    'chmod' => '-'
                );
                $result['not-found-error'] = true;
            } elseif (is_writable($file)) {
                $status = array(
                    'file' => str_replace('..', '', $file),
                    'text' => 'allowed!',
                    'error' => 0,
                    'chmod' => @decoct(@fileperms($file)) % 1000,
                );
            } else {
                @chmod($file, 0777);
                if (is_writable($file)) {
                    $status = array(
                        'file' => str_replace('..', '', $file),
                        'text' => 'allowed!',
                        'error' => 0,
                        'chmod' => @decoct(@fileperms($file)) % 1000,
                    );
                } else {
                    @chmod("$file", 0755);
                    if (is_writable($file)) {
                        $status = array(
                            'file' => str_replace('..', '', $file),
                            'text' => 'allowed!',
                            'error' => 0,
                            'chmod' => @decoct(@fileperms($file)) % 1000,
                        );
                    } else {
                        $status = array(
                            'file' => str_replace('..', '', $file),
                            'text' => 'prohibited',
                            'error' => 1,
                            'chmod' => @decoct(@fileperms($file)) % 1000,
                        );
                        $result['chmod-error'] = true;
                    }
                }
            }

            $result['files'][$file] = $status;
        }

        return $result;
    }

    /**
     * @param array $param
     */
    public function updateConfig($param) {
        file_put_contents(Registry::get('db-config'), "<?php\n\nreturn array(\n" .
            "\t'host' => '" . $param['host'] . "',\n" .
            "\t'user' => '" . $param['user'] . "',\n" .
            "\t'pass' => '" . $param['pass'] . "',\n" .
            "\t'db' => '" . $param['name'] . "',\n" .
            "\t'port' => NULL,\n" .
            "\t'socket' => NULL,\n" .
            "\t'pconnect' => FALSE,\n" .
            "\t'charset' => 'utf8',\n" .
            "\t'errmode' => 'error',\n" .
            "\t'exception' => 'Exception'\n);");
    }

    /**
     * @return bool
     */
    public function checkInstalled() {
        if ($this->getSettings()->settings['installed']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function licensePage() {
        return array(
            'template' => 'license',
            'title' => 'License agreement',
            'data' => array(
                'license-text' => file_get_contents(Registry::get('license-file'))
            )
        );
    }

    /**
     * @return array
     */
    public function systemPage() {
        return array(
            'template' => 'system',
            'title' => 'Configuration check',
            'data' => $this->checkSystem()

        );
    }

    /**
     * @return array
     */
    public function filesPage() {
        return array(
            'template' => 'files',
            'title' => 'Checking system files',
            'data' => $this->checkFiles()

        );
    }

    /**
     * @return array
     */
    public function configurationPage() {
        return array(
            'template' => 'config',
            'title' => 'System configuration settings',
        );
    }

    /**
     * @return array
     */
    public function successPage() {
        return array(
            'template' => 'success',
            'title' => 'Installation completed successfully',
        );
    }
}