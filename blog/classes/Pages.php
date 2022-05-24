<?php

/**
 * Class Pages
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Pages extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'url',
        'icon',
        'title',
        'type',
        'form',
        'blog',
        'name',
        'class',
        'video',
        'slider',
        'header',
        'status',
        'parent',
        'images',
        'position',
        'content',
        'keywords',
        'elements',
        'description'
    );

    public $systemType = array(
        0, 1, 2, 3, 4, 5,
    );

    /**
     * @var array
     */
    private $toIntFields = array(
        'status'
    );

    /**
     * @param array $data
     * @return array
     */
    private function tree($data) {
        $new = array();
        foreach($data as $a) {
            $new[$a['parent']][] = $a;
        }
        return createTreeArray($new, $new[0]);
    }

    /**
     * @param array $status
     * @param array $type
     * @return array|bool
     */
    public function getTree($status, $type) {
        $data = $this->getDb()->getAll("SELECT pages.* FROM pages WHERE pages.status IN (?a) AND pages.type IN (?a) ORDER BY pages.position", $status, $type);
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * @param array $data
     * @return string
     */
    private function createJSON($data){
        arrayRenameKey($data, 'name', 'text');
        foreach ($data as &$t){
            $t['icon'] = 'fa '.$t['icon'];
            switch ($t['type']){
                case 0:
                    $t['type'] = 'not-found';
                    $t['label'] = 'page 404';
                    break;
                case 1:
                    $t['type'] = 'tag';
                    $t['label'] = 'records by tag';
                    break;
                case 2:
                    $t['type'] = 'home';
                    $t['label'] = 'home';
                    break;
                case 3:
                    $t['type'] = 'category';
                    $t['label'] = 'categories';
                    break;
                case 4:
                    $t['type'] = 'bookmark';
                    $t['label'] = 'bookmarks';
                    break;
                case 5:
                    $t['type'] = 'add';
                    $t['label'] = 'add';
                    break;
                case 6:
                    $t['type'] = 'page';
                    $t['label'] = 'page';
                    break;
                case 7:
                    $t['type'] = 'gallery';
                    $t['label'] = 'gallery';
                    break;
            }
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
        return $this->createJSON($this->getDb()->getAll("SELECT pages.* FROM pages ORDER BY pages.position"));
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        return $this->getDb()->getRow("SELECT pages.* FROM pages WHERE pages.id = ?i", $id);
    }

    /**
     * @param int $id
     * @param string $field
     * @return bool|mixed
     */
    public function getOne($id, $field){
        return $this->getDb()->getOne("SELECT ?n FROM pages WHERE pages.id = ?i", $field, $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function getParentId($id) {
        return $this->getDb()->getOne("SELECT pages.parent FROM pages WHERE pages.id = ?i", $id);
    }


    /**
     * @param string $url
     * @param array $status
     * @return int
     */
    public function getId($url, $status) {
        return $this->getDb()->getOne("SELECT pages.id FROM pages WHERE pages.url = ?s AND pages.status IN (?a)", $url, $status);
    }

    /**
     * @param string $url
     * @param array $status
     * @return array
     */
    public function getMeta($url, $status){
        return $this->getDb()->getRow("SELECT pages.id, pages.url, pages.type, pages.status FROM pages WHERE pages.url = ?s AND pages.status IN (?a)", $url, $status);
    }

    /**
     * @param array $type
     * @return array
     */
    public function getUrl($type){
        $temp = $this->getCache()->readCache('pages', 'get-url', $type);
        if($temp){
            return $temp;
        }else{
            $result = array();
            $data = $this->getDb()->getAll("SELECT pages.type, pages.url, pages.header  FROM pages WHERE pages.type IN (?a)", $type);
            foreach ($data as $t){
                $result[$t['type']] = $t['url'];
            }
            return $this->getCache()->writeCache('pages', 'get-url', $type, $result);
        }
    }

    /**
     * @param int $id id
     * @return int
     */
    public function getStatus($id) {
        if($id == 0){
            return 1;
        }else{
            return $this->getDb()->getOne("SELECT pages.status FROM pages WHERE pages.id = ?i", $id);
        }

    }

    /**
     * @param int $id
     * @return int
     */
    public function getParentStatus($id) {
        $parentId = $this->getParentId($id);
        if($parentId == 0) {
            return 1;
        } else {
            return $this->getDb()->getOne("SELECT pages.status FROM pages WHERE pages.id = ?i", $parentId);
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function getSubId($id) {
        $result = array();
        $data = $this->getDb()->getAll("SELECT pages.id FROM pages WHERE pages.parent = ?i", $id);
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
        return $this->getDb()->query("UPDATE pages SET pages.parent = ?i WHERE pages.id IN (?a)", $parent, $id);
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $data['status'] = $this->getStatus($data['parent']) ? 1 : 0;
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO pages (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastInsertID = $this->getDb()->insertId();
            $lastID = $this->getDb()->getOne("SELECT pages.id FROM pages ORDER BY pages.id DESC LIMIT 1, 1");
            $this->getLogs()->addPage($lastInsertID);
            return $this->getDb()->query("UPDATE pages SET pages.position = ?i WHERE pages.id = ?i", $lastID, $lastInsertID);
        }else{
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function update($data) {
        $this->getLogs()->editPage($data['id']);
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE pages SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }

    /**
     * @return array
     */
    public function getAllImages() {
        $images = array();
        $data =  $this->getDb()->getAll("SELECT pages.images, pages.slider FROM pages");
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
     * @return bool
     */
    public function delete($id) {
        $this->deleteImages($id);
        $this->getLogs()->deletePage($id);
        foreach($id as $t) {
            if($this->updateParent($this->getParentId($t), $this->getSubId($t))) {
                if(!$this->getDb()->query("DELETE FROM pages WHERE pages.id = ?i", $t)) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $id
     * @return void
     */
    private function deleteImages($id){
        $images = array();
        $data = $this->getDb()->getAll("SELECT pages.images, pages.slider FROM pages WHERE id IN (?a)", $id);
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
            $array = $this->parseJSON($t['images']);
            if(!empty($array) && isset($array[0]['image'])){
                foreach ($array as $data) {
                    $images[] = $data['image'];
                }
            }
        }
        $imagesClass = new Images();
        $imagesClass->multipleDelete($images);
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
}