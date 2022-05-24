<?php

/**
 * Class Comments
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Comments extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'ip',
        'user',
        'time',
        'reply',
        'name',
        'email',
        'status',
        'content',
        'comment',
        'position'
    );

    /**
     * @var array
     */
    private $toIntFields = array(
        'status'
    );

    private function tree($data) {
        $new = array();
        foreach($data as $a) {
            $new[$a['reply']][] = $a;
        }
        return createTreeArray($new, $new[0]);
    }

    /**
     * @param array $status
     * @param int $content
     * @param array $id
     * @param int $user
     * @return int
     */
    public function getCount($status, $content = null, $id = null, $user = null) {
        $temp = $this->getCache()->readCache('comments', 'get-count', $this->getCache()->buildParam($status, $content, $id, $user));
        if($temp){
            return $temp;
        }else{
            $idSQL = '';
            $userSQL = '';
            $contentSQL = '';
            if($this->isArray($id)){
                $idSQL = $this->getDb()->parse(" AND comments.id IN (?a)", $id);
            }
            if($this->isInt($user)){
                $userSQL = $this->getDb()->parse(" AND comments.user = ?i", $user);
            }
            if($this->isInt($content)){
                $contentSQL = $this->getDb()->parse(" AND comments.content = ?i", $content);
            }
            return $this->getCache()->writeCache('comments', 'get-count', $this->getCache()->buildParam($status, $content, $id, $user), $this->getDb()->getOne("SELECT COUNT(comments.id) FROM comments WHERE comments.status IN (?a) ?p ?p ?p", $status, $contentSQL, $idSQL, $userSQL));
        }
    }

    /**
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $sort
     * @param int $content
     * @param array $id
     * @param int $user
     * @return array
     */
    public function get($status, $page, $limit, $sort, $content = null, $id = null, $user = null) {
        $idSQL = '';
        $userSQL = '';
        $contentSQL = '';
        if($this->isArray($id)){
            $idSQL = $this->getDb()->parse(" AND comments.id IN (?a)", $id);
        }
        if($this->isInt($user)){
            $userSQL = $this->getDb()->parse(" AND comments.user = ?i", $user);
        }
        if($this->isInt($content)){
            $contentSQL = $this->getDb()->parse(" AND comments.content = ?i", $content);
        }
        return $this->getDb()->getAll("SELECT (SELECT users.login FROM users WHERE users.id = comments.user) as login, comments.* FROM comments WHERE comments.status IN (?a) ?p ?p ?p ORDER BY ?n ?p LIMIT ?i, ?i", $status, $contentSQL,  $idSQL, $userSQL, $sort, $sort == 'time' ? '' : 'DESC',  $page * $limit - $limit, $limit);
    }

    /**
     * @return int|bool
     */
    public function getLastId(){
        return $this->getDb()->getOne("SELECT comments.id FROM comments ORDER BY comments.id DESC");
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT (SELECT users.login FROM users WHERE users.id = comments.user) as login, comments.* FROM comments WHERE id = ?i", $id);
    }

    /**
     * @param array $status
     * @param int $content
     * @param string $sort
     * @return array|bool
     */
    public function getAllTree($status, $content, $sort){
        $data = $this->getDb()->getAll("SELECT (SELECT users.login FROM users WHERE users.id = comments.user) as login, comments.* FROM comments WHERE comments.status IN (?a) AND comments.content = ?i ORDER BY ?n", $status, $content, $sort);
        if(!empty($data)){
            return $this->tree($data);
        }
        return false;
    }

    /**
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $search

     * @return array
     */
    public function search($status, $page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT (SELECT users.login FROM users WHERE users.id = comments.user) as login, comments.* FROM comments WHERE comments.comment LIKE '%' ?s '%' AND comments.status IN (?a) ORDER BY comments.id LIMIT ?i, ?i", $search, $status, $page * $limit - $limit, $limit);
        return $data;
    }

    /**
     * @param array $status
     * @param string $search
     * @return int
     */
    public function searchCount($status, $search) {
        return $this->getDb()->getOne("SELECT COUNT(comments.id) FROM comments WHERE comments.comment LIKE '%' ?s '%' AND comments.status IN (?a)", $search, $status);
    }
    
    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $data['time'] = $this->getDate();
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO comments (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastID = $this->getDb()->insertId();
            $this->getDb()->query("UPDATE comments SET position = ?i WHERE id = ?i", $this->getLastId(), $lastID);
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
        $this->getLogs()->editComments($data['id']);
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE comments SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        $this->getCache()->clear('comments');
        $this->getLogs()->deleteComments($id);
        return $this->getDb()->query("DELETE FROM comments WHERE id IN (?a) ", $id);
    }
}