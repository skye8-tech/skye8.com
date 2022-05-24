<?php

/**
 * Class Subscriptions
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Subscriptions extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'time',
        'email',
        'status',
        'position'
    );

    /**
     * @var array
     */
    private $toIntFields = array(
        'status',
    );

    /**
     * @param array $status
     * @return int
     */
    public function getCount($status) {
        return $this->getDb()->getOne("SELECT COUNT(subscriptions.id) FROM subscriptions WHERE subscriptions.status IN (?a)", $status);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT subscriptions.* FROM subscriptions WHERE subscriptions.id = ?i", $id);
    }

    /**
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $sort
     * @param array $id
     * @return array
     */
    public function get($status, $page, $limit, $sort, $id = null) {
        $idSQL = '';
        if($this->isArray($id)){
            $idSQL = $this->getDb()->parse(" AND subscriptions.id IN (?a)", $id);
        }
        return $this->getDb()->getAll("SELECT subscriptions.* FROM subscriptions WHERE subscriptions.status IN (?a) ?p ORDER BY ?n ?p LIMIT ?i, ?i", $status, $idSQL, $sort, $sort == 'time' ? '' : 'DESC', $page * $limit - $limit, $limit);
    }

    /**
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $search
     * @return array
     */
    public function search($status, $page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT subscriptions.* FROM subscriptions WHERE subscriptions.email LIKE '%' ?s '%' AND subscriptions.status IN (?a) ORDER BY subscriptions.id LIMIT ?i, ?i", $search, $status, $page * $limit - $limit, $limit);
        return $data;
    }

    /**
     * @param array $status
     * @param string $search
     * @return int
     */
    public function searchCount($status, $search) {
        return $this->getDb()->getOne("SELECT COUNT(subscriptions.id) FROM subscriptions WHERE subscriptions.email LIKE '%' ?s '%' AND subscriptions.status IN (?a)", $search, $status);
    }

    /**
     * @param array $status
     * @return array
     */
    public function getAll($status){
        return $this->getDb()->getAll("SELECT subscriptions.* FROM subscriptions WHERE subscriptions.status IN (?a) ORDER BY subscriptions.id DESC", $status);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE FROM subscriptions WHERE id IN (?a) ", $id);
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("INSERT INTO subscriptions (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")");
    }

    /**
     * @param $data
     * @return bool
     */
    public function update($data) {
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE subscriptions SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function checkEmail($email){
        if($this->getDb()->getRow("SELECT id FROM subscriptions WHERE email = ?s", $email)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $email
     * @return bool
     */
    public function deleteByEmail($email) {
        return $this->getDb()->query("DELETE FROM subscriptions WHERE email = ?s", $email);
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     */
    public function sendEmail($to, $subject, $message) {
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8; \r\n";
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        mail($to, $subject, $message, $headers);
    }

    /**
     * @param string $header
     * @param string $content
     * @return bool
     */
    public function newDelivery($header, $content) {
        $tmp = $this->getTemplate()->get('email/delivery');
        foreach($this->getAll(array(1)) as $t){
            $data = array(
                'content' => $content,
                'link' => array(
                    'url' => $this->getRequest()->getBaseURL().'/unsubscribe/'.base64_encode($t['email']),
                    'name' => 'Cancel subscription!'
                )
            );

            $this->sendEmail($t['email'], $header,  $this->getTemplate()->compileStr($tmp, $data));
        }
        return true;
    }
}