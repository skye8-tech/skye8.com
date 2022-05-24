<?php

/**
 * Class Settings
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Settings{

    /**
     * @var array
     */
    public $settings;

    /**
     * Settings constructor.
     */
    function __construct() {
        $this->settings = $this->getSettings();
    }

    /**
     * @return array
     */
    public function getSettings() {
        return include PATH.'/data/settings.php';
    }

    /**
     * @param array|string $key
     * @param mixed $value
     * @return bool
     */
    public function updateSettings($key, $value = null) {
        $settings = $this->getSettings();
        if(is_array($key)) {
            foreach($key as $k => $v) {
                if(array_key_exists($k, $settings)){
                    $settings[$k] = $v;
                }
            }
        } else {
            if($settings[$key]) {
                $settings[$key] = $value;
            }
        }
        $handler = fopen(PATH.'/data/settings.php', 'w+');
        fwrite($handler, "<?php\n\nreturn array(\n");
        foreach($settings as $name => $value) {
            if(array_key_exists($name, $settings)){
                $value = strpos('enable', $name) ? intval($value) : $value;
                $value = htmlspecialchars(htmlspecialchars_decode($value));
                fwrite($handler, "    '$name' => \"{$value}\",\n");
            }
        }
        fwrite($handler, ");");
        fclose($handler);
        return true;
    }
}