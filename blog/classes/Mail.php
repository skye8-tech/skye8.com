<?php

/**
 * Class Mail
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Mail {

    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public function send($to, $subject, $message) {
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8; \r\n";
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        return mail($to, $subject, $message, $headers);
    }
}