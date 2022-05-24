<?php

/**
 * Class Category
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Category extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'url',
        'title',
        'icon',
        'name',
        'slider',
        'status',
        'parent',
        'header',
        'images',
        'content',
        'position',
        'elements',
        'keywords',
        'description',
    );

    /**
     * @var array
     */
    private $toIntFields = array(
        'position',
        'parent',
        'status'
    );

    /**
     * @param array $data
     * @return array
     */
    private function tree($data) {
        $new = array();
        foreach($data as $a) {
            $a['count'] = getRecordsCount($data, $a['id'], $a['count']);
            $new[$a['parent']][] = $a;
        }
        return createTreeArray($new, $new[0]);
    }

    /**
     * @param array $status
     * @return array|bool
     */
    public function getTree($status) {
        $temp = $this->getCache()->readCache('category', 'get-tree', $status);
        if($temp){
            return $temp;
        }else{
            $data = $this->getDb()->getAll("SELECT category.* FROM category WHERE category.status IN (?a) ORDER BY category.position", $status);
            if(!empty($data)){
                foreach($data as &$t) {
                    $t['count'] = $this->getDb()->getOne("SELECT COUNT(content.id) FROM content WHERE content.status IN (?a) AND content.category regexp '[[:<:]](?i)[[:>:]]'", $status, $t['id']);
                }
                return $this->getCache()->writeCache('category', 'get-tree', $status, $this->tree($data));
            }
        }
        return false;
    }

    /**
     * @param array $status
     * @return array|bool
     */
    public function getAll($status) {
        $temp = $this->getCache()->readCache('category', 'get-all', $status);
        if($temp){
            return $temp;
        }else{
            $data = $this->getDb()->getAll("SELECT category.* FROM category WHERE category.status IN (?a) ORDER BY category.position", $status);
            if(count($data) !== 0){
                foreach($data as &$t) {
                    $t['count'] = $this->getDb()->getOne("SELECT COUNT(content.id) FROM content WHERE content.category regexp '[[:<:]](?i)[[:>:]]'", $t['id']);
                }
                return $this->getCache()->writeCache('category', 'get-all', $status, $data);
            }
        }
        return false;
    }

    /**
     * @param array $data
     * @return string
     */
    private function createJSON($data){
        arrayRenameKey($data, 'name', 'text');
        foreach ($data as &$t){
            $t['icon'] = 'fa '.$t['icon'];
        }
        unset($t);
        $json =  json_encode($data);
        $json = str_replace('"parent":"0"', '"parent":"#"', $json);
        return $json;
    }

    /**
     * @return string
     */
    public function getJSON() {
        return $this->createJSON($this->getDb()->getAll("SELECT category.* FROM category ORDER BY category.position"));
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT category.* FROM category WHERE category.id = ?i", $id);
    }

    /**
     * @param int $id
     * @param string $field
     * @return bool|mixed
     */
    public function getOne($id, $field){
        return $this->getDb()->getOne("SELECT ?n FROM category WHERE category.id = ?i", $field, $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function getParentId($id) {
        return $this->getDb()->getOne("SELECT category.parent FROM category WHERE category.id = ?i", $id);
    }

    /**
     * @param string $url
     * @param array $status
     * @return int
     */
    public function getId($url, $status) {
        return $this->getDb()->getOne("SELECT category.id FROM category WHERE category.url = ?s AND category.status IN (?a)", $url, $status);
    }

    /**
     * @param int $id id
     * @return int
     */
    public function getStatus($id) {
        if($id == 0){
            return 1;
        }else{
            return $this->getDb()->getOne("SELECT category.status FROM category WHERE category.id = ?i", $id);
        }

    }

    /**
     * @param int $id
     * @return array
     */
    public function getSubId($id) {
        $result = array();
        $data = $this->getDb()->getAll("SELECT category.id FROM category WHERE category.parent = ?i", $id);
        foreach($data as $t) {
            $result[] = $t['id'];
        }
        return $result;
    }

    /**
     * @param int $parent
     * @param array $id
     * @return bool
     */
    public function updateParent($parent, $id) {
        return $this->getDb()->query("UPDATE category SET category.parent = ?i WHERE category.id IN (?a)", $parent, $id);
    }

    /**
     * @return bool
     */
    public function updatePosition(){
        $array = json_decode($this->getRequest()->getPOSTValues('new-position'), true);
        if($this->isArray($array)) {
            foreach($array as $t){
                $this->update($t);
            }
            if($this->update($this->getRequest()->getPOSTValues())){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $this->getCache()->clear('category');
        $data['status'] = $this->getStatus($data['parent']) ? 1 : 0;
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO category (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastInsertID = $this->getDb()->insertId();
            $lastID = $this->getDb()->getOne("SELECT category.id FROM category ORDER BY category.id DESC LIMIT 1, 1");
            $lastID = $lastID ? $lastID : 0;
            $this->getLogs()->addCategory($lastInsertID);
            return $this->getDb()->query("UPDATE category SET category.position = ?i WHERE category.id = ?i", $lastID, $lastInsertID);
        }else{
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function update($data) {
        $this->getCache()->clear('category');
        $this->getLogs()->editCategory($data['id']);
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE category SET ".$sets['sets']." WHERE category.id IN (?a)", $data['id']);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        $this->deleteImages($id);
        $this->getCache()->clearAll();
        $this->updateContentCategory($id);
        $this->getLogs()->deleteCategory($id);
        foreach($id as $t) {
            if($this->updateParent($this->getParentId($t), $this->getSubId($t))) {
                if(!$this->getDb()->query("DELETE FROM category WHERE category.id = ?i", $t)) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getAllImages() {
        $images = array();
        $data =  $this->getDb()->getAll("SELECT category.images, category.slider FROM category");
        $this->jsonToArray($data, true);
        if(!empty($data)){
            foreach ($data as $t) {
                if(!empty($t['images'])){
                    foreach ($t['images'] as $image) {
                        $images[] = $image;
                    }
                }
                if(!empty($t['slider'])){
                    foreach ($t['slider'] as $data) {
                        if(!empty($data['image'])){
                            $images[] = $data['image'];
                        }
                    }
                }
            }
        }
        return $images;
    }

    /**
     * @param array $id
     * @return void
     */
    private function deleteImages($id){
        $images = array();
        $data = $this->getDb()->getAll("SELECT category.images, category.slider FROM category WHERE id IN (?a)", $id);
        foreach ($data as $t){
            $array = $this->parseJSON($t['images']);
            if(!empty($array)){
                foreach ($array as $image) {
                    $images[] = $image;
                }
            }
            $array = $this->parseJSON($t['slider']);
            if(!empty($array)){
                foreach ($array as $data) {
                    $images[] = $data['image'];
                }
            }
        }
        $imagesClass = new Images();
        $imagesClass->multipleDelete($images);
    }

    /**
     * @param array $id
     * @return void
     */
    private function updateContentCategory($id){
        $content = $this->getDb()->getAll("SELECT content.id, content.category FROM content WHERE content.category regexp '[[:<:]](?p)[[:>:]]'", implode('|', $id));
        foreach ($content as $t){
            $category = explode(',', $t['category']);
            $category = array_diff($category, $id);
            $category = count($category) > 1 ? implode(',', $category) : 0;
            $this->getDb()->query("UPDATE content SET category = ?s WHERE id = ?i", $category, $t['id']);
        }
    }
}