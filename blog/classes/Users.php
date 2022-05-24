<?php

/**
 * Class Users
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Users extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'tin',
        'time',
        'lost',
        'role',
        'hash',
        'name',
        'email',
        'phone',
        'login',
        'status',
        'address',
        'password',
        'organization'
    );

    /**
     * @var array
     */
    private $toIntFields = array(
        'role',
        'status'
    );

    /**
     * @return array|bool
     */
    public function getUser() {
        $userId = $this->getCookie('user-id');
        $userRole = $this->getCookie('user-role');
        $userHash = $this->getCookie('user-hash');

        if(is_numeric($userId) && is_numeric($userRole) && strlen($userHash) > 0){
            $user = $this->getDb()->getRow("SELECT * FROM users WHERE id = ?i", $userId);
            if(($user['id'] !== $this->getCookie('user-id') || ($user['role'] !== $this->getCookie('user-role') || ($user['hash'] !== $this->getCookie('user-hash'))))) {
                $this->logout();
                return false;
            } else {
                return $user;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function login($login, $password) {
        $user = $this->getDb()->getRow("SELECT * FROM users WHERE login = ?s", $login);
        if($this->notEmpty($user) && $user['status'] != 0) {
            if($user['password'] === md5(md5($password))) {
                $hash = md5(rand(0, 9999999));
                $this->getDb()->query("UPDATE users SET hash = ?s WHERE id = ?i", $hash, $user['id']);
                $this->setCookie('user-id', $user['id'], time() + 60 * 60 * 24 * 30, '/');
                $this->setCookie('user-hash', $hash, time() + 60 * 60 * 24 * 30, '/');
                $this->setCookie('user-role', $user['role'], time() + 60 * 60 * 24 * 30, '/');
                return true;
            }
        }
        return false;
    }

    /**
     * @return void
     */
    public function logout() {
        $this->setCookie('user-id', "", time() - 3600 * 24 * 30 * 12, '/');
        $this->setCookie('user-role', "", time() - 3600 * 24 * 30 * 12, '/');
        $this->setCookie('user-hash', "", time() - 3600 * 24 * 30 * 12, '/');
    }
    
    /**
     * @param array $role
     * @return int
     */
    public function getCount($role) {
        return $this->getDb()->getOne("SELECT COUNT(users.id) FROM users WHERE users.role IN (?a)", $role);
    }

    /**
     * @param array $role
     * @return array
     */
    public function getList($role) {
        return $this->getDb()->getAll("SELECT users.id, users.time, users.login, users.name, users.email FROM users WHERE users.role IN(?a) ORDER BY users.id", $role);
    }

    /**
     * @param array $role
     * @param int $page
     * @param int $limit
     * @param array $id
     * @return array
     */
    public function get($role, $page, $limit, $id = null) {
        $idSQL = '';
        if($this->isArray($id)){
            $idSQL = $this->getDb()->parse(" AND id IN (?a)", $id);
        }
        return  $this->getDb()->getAll("SELECT (SELECT COUNT(content.id) FROM content WHERE content.user = users.id) as content, (SELECT COUNT(comments.id) FROM comments WHERE comments.user = users.id) as comments, users.* FROM users WHERE users.role IN (?a) ?p ORDER BY users.id LIMIT ?i, ?i", $role, $idSQL, $page * $limit - $limit, $limit);
    }

    /**
     * @param string $login
     * @return int
     */
    public function getId($login) {
        return $this->getDb()->getOne("SELECT users.id FROM users WHERE users.login = ?s", $login);
    }

    /**
     * @param int $id
     * @param string $field
     * @return bool|mixed
     */
    public function getOne($id, $field){
        return $this->getDb()->getOne("SELECT ?n FROM users WHERE users.id = ?i", $field, $id);
    }

    /**
     * @param array $role
     * @return array
     */
    public function getAll($role) {
        return $this->getDb()->getAll("SELECT users.* FROM users WHERE users.role IN (?a)", $role);
    }

    /**
     * @return int|bool
     */
    public function getLastId(){
        return $this->getDb()->getOne("SELECT users.id FROM users ORDER BY users.id DESC");
    }

    /**
     * @param string $email
     * @return int
     */
    public function getIdByEmail($email) {
        return $this->getDb()->getOne("SELECT users.id FROM users WHERE users.email = ?s", $email);
    }

    /**
     * @param string $key
     * @return int
     */
    public function getIdByLost($key) {
        return $this->getDb()->getOne("SELECT users.id FROM users WHERE users.lost = ?s", $key);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getLogin($id) {
        return $this->getDb()->getOne("SELECT users.login FROM users WHERE users.id = ?s", $id);
    }
    
    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT (SELECT COUNT(content.id) FROM content WHERE content.user = users.id) as content, (SELECT COUNT(comments.id) FROM comments WHERE comments.user = users.id) as comments, users.* FROM users WHERE users.id = ?i", $id);
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $search

     * @return array
     */
    public function search($page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT (SELECT COUNT(content.id) FROM content WHERE content.user = users.id) as content, (SELECT COUNT(comments.id) FROM comments WHERE comments.user = users.id) as comments, users.* FROM users WHERE users.login  LIKE '%' ?s '%' ORDER BY users.id LIMIT ?i, ?i", $search, $page * $limit - $limit, $limit);
        return $data;
    }

    /**
     * @param string $search
     * @return int
     */
    public function searchCount($search) {
        return $this->getDb()->getOne("SELECT COUNT(users.id) FROM users WHERE users.login LIKE '%' ?s '%'", $search);
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $this->sqlDataHandler($data);
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO users (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $this->getLogs()->addUser($this->getDb()->insertId());
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
        $this->sqlDataHandler($data);
        $this->getLogs()->editUsers($data['id']);
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE users SET ".$sets['sets']." WHERE users.id IN (?a)", $data['id']);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        if($this->getDb()->query("DELETE FROM users WHERE users.id IN (?a)", $id)) {
            $this->getLogs()->deleteUsers($id);
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return void
     */
    private function sqlDataHandler(&$data){
        if(!$this->isArray($data['id'])){
            $data['time'] = $this->getDate();
        }
        if(!empty($data['password'])){
            $data['password'] =  md5(md5($data['password']));
        }else{
            unset($data['password']);
        }
    }
}