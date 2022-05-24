<?php

/**
 * Class Tags
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Tags extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'time',
        'name',
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
            $t['content-count'] = $this->getDb()->getOne("SELECT COUNT(content.id) FROM content WHERE content.tags regexp '[[:<:]](?i)[[:>:]]'", $t['id']);
        }
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->getDb()->getOne("SELECT COUNT(tags.id) FROM tags");
    }

    /**
     * @param string $name
     * @return int
     */
    public function getId($name) {
        return $this->getDb()->getOne("SELECT tags.id FROM tags WHERE tags.name = ?s", $name);
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
            $idSQL = $this->getDb()->parse(" WHERE tags.id IN (?a)", $id);
        }
        $data =  $this->getDb()->getAll("SELECT tags.* FROM tags ?p ORDER BY ?n ?p LIMIT ?i, ?i", $idSQL, $sort, $sort == 'time' ? '' : 'DESC', $page * $limit - $limit, $limit);
        $this->addSubData($data);
        return $data;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT * FROM tags WHERE tags.id = ?i", $id);
    }

    /**
     * @param int $id
     * @param string $field
     * @return bool|mixed
     */
    public function getOne($id, $field){
        return $this->getDb()->getOne("SELECT ?n FROM tags WHERE tags.id = ?i", $field, $id);
    }

    /**
     * @return int|bool
     */
    public function getLastId(){
        return $this->getDb()->getOne("SELECT tags.id FROM tags ORDER BY tags.id DESC");
    }

    /**
     * @return array|bool
     */
    public function getAll(){
        $temp = $this->getCache()->readCache('tags', 'get-all', array());
        if($temp){
            return $temp;
        }else{
            $data = $this->getDb()->getAll("SELECT tags.* FROM tags ORDER BY tags.id");
            $this->addSubData($data);
            return $this->getCache()->writeCache('tags', 'get-all', array(), $data);
        }
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $search

     * @return array
     */
    public function search($page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT tags.* FROM tags WHERE tags.name  LIKE '%' ?s '%' ORDER BY tags.id LIMIT ?i, ?i", $search, $page * $limit - $limit, $limit);
        $this->addSubData($data);
        return $data;
    }

    /**
     * @param string $search
     * @return int
     */
    public function searchCount($search) {
        return $this->getDb()->getOne("SELECT COUNT(tags.id) FROM tags WHERE tags.name LIKE '%' ?s '%'", $search);
    }
    
    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $data['time'] = $this->getDate();
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO tags (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastID = $this->getDb()->insertId();
            $this->getLogs()->addTag($lastID);
            $this->getDb()->query("UPDATE tags SET position = ?i WHERE id = ?i", $this->getLastId(), $lastID);
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
        $this->getLogs()->editTags($data['id']);
        $this->getCache()->clearAll();
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE tags SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        $this->updateContentTags($id);
        $this->getCache()->clearAll();
        $this->getLogs()->deleteTags($id);
        if($this->getDb()->query("DELETE FROM tags WHERE tags.id IN (?a)", $id)) {
            return true;
        }
        return false;
    }

    /**
     * @param array $id
     * @return void
     */
    private function updateContentTags($id){
        $content = $this->getDb()->getAll("SELECT content.id, content.tags FROM content WHERE content.tags regexp '[[:<:]](?p)[[:>:]]'", implode('|', $id));
        foreach ($content as $t){
            $tags = explode(',', $t['tags']);
            $tags = array_diff($tags, $id);
            $this->getDb()->query("UPDATE content SET tags = ?s WHERE id = ?i", implode(',', $tags), $t['id']);
        }
    }
}