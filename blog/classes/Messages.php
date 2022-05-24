<?php

/**
 * Class Messages
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Messages extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
	    'time',
        'user',
        'status',
        'subject',
        'message',
        'position',
        'recipient',
    );

    /**
     * @var array
     */
    private $toIntFields = array(

    );

    /**
     * @param array $data
     * @param bool $list
     * @return void
     */
    private function addSubData(&$data, $list = null){
        if($list){
            foreach ($data as &$t){
                $t['user-data'] = $this->getDb()->getRow("SELECT users.* FROM users WHERE users.id = ?i", $t['user']);
                $t['recipient-data'] = $this->getDb()->getRow("SELECT users.* FROM users WHERE users.id = ?i", $t['recipient']);
            }
        }else{
            $data['user-data'] = $this->getDb()->getRow("SELECT users.* FROM users WHERE users.id = ?i", $data['user']);
            $data['recipient-data'] = $this->getDb()->getRow("SELECT users.* FROM users WHERE users.id = ?i", $data['recipient']);
        }
    }

    /**
     * @param array $recipient
     * @param array $user
     * @param array $status
     * @param array $time
     * @param array $id
     * @return int
     */
    public function getCount($recipient = null, $user = null, $status = null, $time = null, $id = null) {
        $idSQL = '';
        $timeSQL = '';
        $userSQL = '';
        $statusSQL = '';
        $recipientSQL = '';
        if($this->isArray($id)){
            $idSQL = $this->getDb()->parse(" AND messages.id IN (?a)", $id);
        }
        if($this->isArray($time)){
            if($this->notEmpty($time['start'])){
                $timeSQL .= $this->getDb()->parse(" AND messages.time >= ?s", $time['start']);
            }
            if($this->notEmpty($time['end'])){
                $timeSQL .= $this->getDb()->parse(" AND messages.time <= ?s", $time['end']);
            }
        }
        if($this->isArray($user)){
            $userSQL = $this->getDb()->parse(" AND messages.user IN (?a)", $user);
        }
        if($this->isArray($status)){
            $statusSQL = $this->getDb()->parse(" AND messages.status IN (?a)", $status);
        }
        if($this->isArray($recipient)){
            $recipientSQL = $this->getDb()->parse(" AND messages.recipient IN (?a)", $recipient);
        }
        return $this->getDb()->getOne("SELECT COUNT(messages.id) FROM messages WHERE messages.id > 0 ?p ?p ?p ?p ?p", $idSQL, $timeSQL, $userSQL, $statusSQL, $recipientSQL);
    }

    /**
     * @param string $name
     * @return int
     */
    public function getId($name) {
        return $this->getDb()->getOne("SELECT tasks.id FROM tasks WHERE tasks.name = ?s", $name);
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $sort
     * @param array $recipient
     * @param array $user
     * @param array $status
     * @param array $time
     * @param array $id
     * @return array
     */
    public function get($page, $limit, $sort, $recipient = null, $user = null, $status = null, $time = null, $id = null) {
        $idSQL = '';
        $timeSQL = '';
        $userSQL = '';
        $statusSQL = '';
        $recipientSQL = '';
        if($this->isArray($id)){
            $idSQL = $this->getDb()->parse(" AND messages.id IN (?a)", $id);
        }
        if($this->isArray($time)){
            if($this->notEmpty($time['start'])){
                $timeSQL .= $this->getDb()->parse(" AND messages.time >= ?s", $time['start']);
            }
            if($this->notEmpty($time['end'])){
                $timeSQL .= $this->getDb()->parse(" AND messages.time <= ?s", $time['end']);
            }
        }
        if($this->isArray($user)){
            $userSQL = $this->getDb()->parse(" AND messages.user IN (?a)", $user);
        }
        if($this->isArray($status)){
            $statusSQL = $this->getDb()->parse(" AND messages.status IN (?a)", $status);
        }
        if($this->isArray($recipient)){
            $recipientSQL = $this->getDb()->parse(" AND messages.recipient IN (?a)", $recipient);
        }
        $data =  $this->getDb()->getAll("SELECT messages.* FROM messages WHERE messages.id > 0 ?p ?p ?p ?p ?p ORDER BY ?n ?p LIMIT ?i, ?i", $idSQL, $timeSQL, $userSQL, $statusSQL, $recipientSQL, $sort, $sort == 'time' ? '' : 'DESC', $page * $limit - $limit, $limit);
        $this->addSubData($data, true);
        return $data;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        $data =  $this->getDb()->getRow("SELECT * FROM messages WHERE messages.id = ?i", $id);
        $this->addSubData($data);
        return $data;
    }

    /**
     * @param int $id
     * @param string $field
     * @return bool|mixed
     */
    public function getOne($id, $field){
        return $this->getDb()->getOne("SELECT ?n FROM messages WHERE messages.id = ?i", $field, $id);
    }

    /**
     * @return int|bool
     */
    public function getLastId(){
        return $this->getDb()->getOne("SELECT messages.id FROM messages ORDER BY messages.id DESC");
    }

    /**
     * @return array
     */
    public function getForNavbar(){
        $messages = $this->getDb()->getAll("SELECT messages.* FROM messages WHERE messages.recipient = ?i AND messages.status = ?i ORDER BY messages.id DESC", Registry::get('user-id'), 0);
        $this->addSubData($messages, true);
        $data['count'] = count($messages);
        $data['messages'] = array_reverse($messages);
        return $data;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $search

     * @return array
     */
    public function search($page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT messages.* FROM messages WHERE messages.subject  LIKE '%' ?s '%' OR messages.message  LIKE '%' ?s '%' ORDER BY messages.id LIMIT ?i, ?i", $search, $search, $page * $limit - $limit, $limit);
        $this->addSubData($data, true);
        return $data;
    }

    /**
     * @param string $search
     * @return int
     */
    public function searchCount($search) {
        return $this->getDb()->getOne("SELECT COUNT(messages.id) FROM messages WHERE messages.subject LIKE '%' ?s '%' OR messages.message  LIKE '%' ?s '%'", $search, $search);
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO messages (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastID = $this->getDb()->insertId();
            $this->getLogs()->addMessage($lastID);
            $this->getDb()->query("UPDATE messages SET position = ?i WHERE id = ?i", $this->getLastId(), $lastID);
            $this->getCache()->clearAll();
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function update($data) {
        $this->getCache()->clearAll();
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE messages SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        $this->getCache()->clearAll();
        $this->getLogs()->deleteMessages($id);
        if($this->getDb()->query("DELETE FROM messages WHERE messages.id IN (?a)", $id)) {
            return true;
        }
        return false;
    }

}