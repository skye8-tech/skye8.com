<?php

/**
 * Class Notify
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Notify extends Core {

    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     */
    public function email($to, $subject, $message) {
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8; \r\n";
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        mail($to, $subject, $message, $headers);
    }


    /**
     * @param array $data
     * @param string $email
     */
    public function message($data, $email) {
        $data = array(
            'header' => 'Unread message on the site ' . $this->getRequest()->getHTTPHost(),
            'data' => $data,
            'link' => array(
                'url' => $this->getRequest()->getBaseURL(). '/admin/messages',
                'name' => 'View message in admin panel'
            )
        );
        $html = $this->getTemplate()->compileBloc('email/message', $data);
        $this->email($email, $data['header'], $html);
    }

    /**
     * @param array $formData
     */
    public function formSubmit($formData) {
        $data = array(
            'header' => 'User filled out a form on the site ' . $this->getRequest()->getHTTPHost(),
            'form-data' => $formData['json'],
            'link' => array(
                'url' => $this->getRequest()->getBaseURL(). '/admin/formdata',
                'name' => 'View messages in the admin panel'
            )
        );
        $html = $this->getTemplate()->compileBloc('../../../../admin/public/tpl/email/form', $data);
        $this->email($this->getSettings()->settings['notification-email'], $data['header'], $html);
    }

    /**
     * @param string $email
     * @param string $login
     * @param string $key
     * @return bool
     */
    public function lostPassword($email, $login, $key){
        $data = array(
            'header' => 'Password recovery on '.$this->getRequest()->getHTTPHost(),
            'host' => $this->getRequest()->getHTTPHost(),
            'login' => $login,
            'link' => array(
                'url' => $this->getRequest()->getBaseURL().'/lostpassword/key-'.$key,
                'name' => 'Reset password now'
            )
        );
        $html = $this->getTemplate()->compileBloc('../../../../admin/public/tpl/email/password', $data);
        return $this->getMail()->send($email, $data['header'], $html);
    }
} 