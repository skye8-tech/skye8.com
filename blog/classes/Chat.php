<?php

/**
 * Class Chat
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Chat extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'time',
        'user',
        'message',
        'position'
    );

    /**
     * @var array
     */
    private $toIntFields = array(

    );

    /**
     * @param $data
     * @return void
     */
    private function addSubData(&$data){
        foreach ($data as &$t){
            $t['name'] = $this->getDb()->getOne("SELECT users.name FROM users WHERE users.id = ?i", $t['user']);
        }
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->getDb()->getOne("SELECT COUNT(chat.id) FROM chat");
    }


    /**
     * @param int $page
     * @param int $limit
     * @param string $sort
     * @param array $id
     * @return array
     */
    public function get($page, $limit, $sort, $id = null) {
        $idSQL = '';
        if($this->isArray($id)){
            $idSQL = $this->getDb()->parse(" WHERE chat.id IN (?a)", $id);
        }
        $data =  $this->getDb()->getAll("SELECT chat.* FROM chat ?p ORDER BY ?n ?p LIMIT ?i, ?i", $idSQL, $sort, $sort == 'time' ? '' : 'DESC', $page * $limit - $limit, $limit);
        $this->addSubData($data);
        return $data;
    }

    /**
     * @param int $last
     * @return array
     */
    public function getLast($last){
        $data = $this->getDb()->getAll("SELECT chat.* FROM chat WHERE id > ?i ORDER BY id DESC ", $last);
        $this->addSubData($data);
        return $data;
    }

    /**
     * @return int|bool
     */
    public function getLastId(){
        return $this->getDb()->getOne("SELECT chat.id FROM chat ORDER BY chat.id DESC");
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT * FROM chat WHERE chat.id = ?i", $id);
    }

    /**
     * @param int $id
     * @param string $field
     * @return bool|mixed
     */
    public function getOne($id, $field){
        return $this->getDb()->getOne("SELECT ?n FROM chat WHERE chat.id = ?i", $field, $id);
    }

    /**
     * @return array|bool
     */
    public function getAll(){
        $temp = $this->getCache()->readCache('chat', 'get-all', array());
        if($temp){
            return $temp;
        }else{
            $data = $this->getDb()->getAll("SELECT chat.* FROM chat ORDER BY chat.id");
            $this->addSubData($data);
            return $this->getCache()->writeCache('chat', 'get-all', array(), $data);
        }
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $search

     * @return array
     */
    public function search($page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT chat.* FROM chat WHERE chat.message  LIKE '%' ?s '%' ORDER BY chat.id LIMIT ?i, ?i", $search, $page * $limit - $limit, $limit);
        $this->addSubData($data);
        return $data;
    }

    /**
     * @param string $search
     * @return int
     */
    public function searchCount($search) {
        return $this->getDb()->getOne("SELECT COUNT(chat.id) FROM chat WHERE chat.name LIKE '%' ?s '%'", $search);
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $data['time'] = $this->getDate();
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO chat (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastID = $this->getDb()->insertId();
            $this->getLogs()->addChat($lastID);
            $this->getDb()->query("UPDATE chat SET position = ?i WHERE id = ?i", $this->getLastId(), $lastID);
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
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE chat SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        if($this->getDb()->query("DELETE FROM chat WHERE chat.id IN (?a)", $id)) {
            return true;
        }
        return false;
    }
}