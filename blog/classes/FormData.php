<?php

/**
 * Class FormData
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class FormData extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'json',
        'time',
        'page',
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
        return $this->getDb()->getOne("SELECT COUNT(formdata.id) FROM formdata WHERE formdata.status IN (?a)", $status);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT formdata.* FROM formdata WHERE formdata.id = ?i", $id);
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
            $idSQL = $this->getDb()->parse(" AND formdata.id IN (?a)", $id);
        }
        return $this->getDb()->getAll("SELECT formdata.* FROM formdata WHERE formdata.status IN (?a) ?p ORDER BY ?n ?p LIMIT ?i, ?i", $status, $idSQL, $sort, $sort == 'time' ? '' : 'DESC', $page * $limit - $limit, $limit);
    }

    /**
     * @return int|bool
     */
    public function getLastId(){
        return $this->getDb()->getOne("SELECT formdata.id FROM formdata ORDER BY formdata.id DESC");
    }

    /**
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $search
     * @return array
     */
    public function search($status, $page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT formdata.* FROM formdata WHERE formdata.json LIKE '%' ?s '%' OR formdata.page LIKE '%' ?s '%' AND formdata.status IN (?a) ORDER BY formdata.id LIMIT ?i, ?i", $search, $search, $status, $page * $limit - $limit, $limit);
        return $data;
    }

    /**
     * @param array $status
     * @param string $search
     * @return int
     */
    public function searchCount($status, $search) {
        return $this->getDb()->getOne("SELECT COUNT(formdata.id) FROM formdata WHERE formdata.json LIKE '%' ?s '%' OR formdata.page LIKE '%' ?s '%' AND formdata.status IN (?a)", $search, $search, $status);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE FROM formdata WHERE formdata.id IN (?a) ", $id);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function add($data) {
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO formdata (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastID = $this->getDb()->insertId();
            $this->getDb()->query("UPDATE formdata SET position = ?i WHERE id = ?i", $this->getLastId(), $lastID);
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
        return $this->getDb()->query("UPDATE formdata SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }
}