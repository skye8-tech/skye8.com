<?php

/**
 * Class FileEditor
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class FileEditor {

    /**
     * @param $dir
     * @return string
     */
    public function getFilesHTML($dir) {
        $string = '';
        $dir = urldecode($dir);
        if(file_exists($dir)) {
            $files = scandir($dir);
            natcasesort($files);
            if(count($files) > 2) {
                $string = '<ul class="jqueryFileTree" style="display: none;">';
                foreach($files as $file) {
                    if(file_exists($dir . $file) && $file != '.' && $file != '..' && $file != 'fonts' && $file != 'img' && is_dir($dir . $file)) {
                        $string .= '<li class="directory collapsed"><a href="#" rel="' . htmlentities($dir . $file) . '/">' . htmlentities($file) . '</a></li>';
                    }
                }
                foreach($files as $file) {
                    if(file_exists($dir . $file) && $file != '.' && $file != '..' && $file != '.htaccess' && !is_dir($dir . $file)) {
                        $ext = preg_replace('/^.*\./', '', $file);
                        $string .= '<li class="file ext-' . $ext . '"><a href="#" rel="' . htmlentities($dir . $file) . '"">' . htmlentities($file) . '</a></li>';
                    }
                }
                $string .= '</ul>';
            }
        }
        return $string;
    }

    /**
     * @param $file
     * @return bool|string
     */
    public function getContent($file) {
        if(file_exists($file)) {
            return file_get_contents($file);
        }
        return false;
    }

    /**
     * @param $file
     * @param $content
     * @return bool|string
     */
    public function save($file, $content) {
        if(file_exists($file) && isset($content)) {
            return file_put_contents($file, $content);
        }
        return false;
    }
} 