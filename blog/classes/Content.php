<?php

/**
 * Class Content
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Content extends Core{

    /**
     * @var array
     */
    private $availableFields = array(
        'id',
        'url',
        'user',
        'title',
        'tags',
        'time',
        'form',
        'status',
        'rating',
        'views',
        'video',
        'slider',
        'header',
        'images',
        'position',
        'fullentry',
        'category',
        'elements',
        'keywords',
        'shortentry',
        'description',
    );

    /**
     * @var array
     */
    private $toIntFields = array(
        'views',
        'rating',
        'status',
    );

    /**
     * @return string
     */
    public function getDefaultElements(){
        $array = array(
            'previews' => 'images',
            'elements' => array(
                'slider',
                'images',
                'video',
                'content'
            ),
            'property' => array(
                'slider-enable' => 1,
                'images-enable' => 1,
                'video-enable' => 1,
                'content-enable' => 1,
                'form' => 0
            )
        );
        return json_encode($array);
    }

    /**
     * @param array $data
     * @param bool $list
     * @return void
     */
    private function addSubData(&$data, $list = null){
        if($list){
            foreach ($data as &$t){
                if(!empty($t['tags'])){
                    $t['tags-data'] = $this->getDb()->getAll("SELECT tags.* FROM tags WHERE tags.id IN (?p)", $t['tags']);
                }
                if(!empty($t['category'])){
                    $t['category-data'] = $this->getDb()->getAll("SELECT category.* FROM category WHERE category.id IN (?p)", $t['category']);
                }
            }
        }else{
            if(!empty($data['tags'])){
                $data['tags-data'] = $this->getDb()->getAll("SELECT tags.* FROM tags WHERE tags.id IN (?p)", $data['tags']);
            }
            if(!empty($data['category'])){
                $data['category-data'] = $this->getDb()->getAll("SELECT category.* FROM category WHERE category.id IN (?p)", $data['category']);
            }
        }
    }

    /**
     * @param int $id - id категории
     * @return array
     */
    public function getSubCategoryId($id) {
        $data = $this->getDb()->getAll("SELECT category.id, category.parent FROM category ORDER BY category.id");
        return getSubId($data, $id);
    }

    /**
     * @param array $status
     * @param int $tags
     * @param int $category
     * @param array $id
     * @param int $user
     * @return int
     */
    public function getCount($status, $tags = null, $category = null, $id= null, $user = null) {
        $temp = $this->getCache()->readCache('content', 'get-count', array_merge($status, array($tags, $category)));
        if($temp){
            return $temp;
        }else{
            $idSQL = '';
            $tagsSQL = '';
            $userSQL = '';
            $categorySQL = '';
            if($this->isArray($id)){
                $idSQL = $this->getDb()->parse(" AND content.id IN (?a)", $id);
            }
            if($this->isInt($user)){
                $userSQL = $this->getDb()->parse(" AND user = ?i", $user);
            }
            if($this->isInt($tags)){
                $tagsSQL = $this->getDb()->parse(" AND tags regexp '[[:<:]](?i)[[:>:]]'", $tags);
            }
            if($this->isInt($category)){
                $ids = $category == 0 ? array() : $this->getSubCategoryId($category);
                $ids[] = $category;
                $categorySQL = $this->getDb()->parse(" AND category regexp '[[:<:]](?p)[[:>:]]'", implode('|', $ids));
            }
            return $this->getCache()->writeCache('content', 'get-count', array_merge($status, array($tags, $category)), $this->getDb()->getOne("SELECT COUNT(content.id) FROM content WHERE content.status IN (?a) ?p ?p ?p ?p", $status, $categorySQL, $tagsSQL, $idSQL, $userSQL));
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRow($id) {
        $data = $this->getDb()->getRow("SELECT (SELECT COUNT(comments.id) FROM comments WHERE comments.content = content.id) as comments, (SELECT users.login FROM users WHERE users.id = content.user) as login, content.* FROM content WHERE id = ?i", $id);
        $this->addSubData($data);
        return $data;
    }
    
    /**
     * @param int $id
     * @param string $field
     * @return array
     */
    public function getOne($id, $field) {
        return $this->getDb()->getOne("SELECT content.?n FROM content WHERE content.id = ?i", $field, $id);
    }

    /**
     * @param string $url
     * @param array $status
     * @return int
     */
    public function getId($url, $status) {
        return $this->getDb()->getOne("SELECT content.id FROM content WHERE content.url = ?s AND content.status IN (?a)", $url, $status);
    }

    /**
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $sort
     * @param int $category
     * @param array $tags
     * @param array $id
     * @param int $user
     * @return array
     */
    public function get($status, $page, $limit, $sort, $category = null, $tags = null, $id = null, $user = null) {
        $idSQL = '';
        $tagsSQL = '';
        $userSQL = '';
        $categorySQL = '';
        if($this->isArray($id)){
            $idSQL = $this->getDb()->parse(" AND content.id IN (?a)", $id);
        }
        if($this->isInt($user)){
            $userSQL = $this->getDb()->parse(" AND content.user = ?i", $user);
        }
        if($this->isInt($tags)){
            $tagsSQL = $this->getDb()->parse(" AND content.tags regexp '[[:<:]](?i)[[:>:]]'", $tags);
        }
        if($this->isInt($category)){
            $ids = $category == 0 ? array() : $this->getSubCategoryId($category);
            $ids[] = $category;
            $categorySQL = $this->getDb()->parse(" AND category regexp '[[:<:]](?p)[[:>:]]'", implode('|', $ids));
        }
        $data =  $this->getDb()->getAll("SELECT (SELECT COUNT(comments.id) FROM comments WHERE comments.content = content.id AND status IN (?a)) as comments, (SELECT users.login FROM users WHERE users.id = content.user) as login, content.* FROM content WHERE content.status IN (?a) ?p ?p ?p ?p ORDER BY ?n ?p LIMIT ?i, ?i", $status, $status, $categorySQL, $tagsSQL, $idSQL, $userSQL, $sort, $sort == 'time' ? '' : 'DESC', $page * $limit - $limit, $limit);
        $this->addSubData($data, true);
        return $data;
    }
    
    /**
     * @param array $status
     * @param int $limit
     * @param int $category
     * @return array
     */
    public function getRandom($status, $limit, $category) {
        $categorySQL = '';
        if($this->isInt($category)){
            $ids = $category == 0 ? array() : $this->getSubCategoryId($category);
            $ids[] = $category;
            $categorySQL = $this->getDb()->parse(" AND category regexp '[[:<:]](?p)[[:>:]]'", implode('|', $ids));
        }
        $data = $this->getDb()->getAll("SELECT (SELECT COUNT(comments.id) FROM comments WHERE comments.content = content.id) as comments, (SELECT users.login FROM users WHERE users.id = content.user) as login, content.* FROM content WHERE content.status IN (?a) ?p ORDER BY rand() LIMIT 0, ?i", $status, $categorySQL, $limit);
        $this->addSubData($data);
        return $data;
    }

    /**
     * @param array $status
     * @param string $sort
     * @param int $category
     * @param int $id
     * @return array|bool
     */
    public function getNeighborID($status, $sort, $category, $id){
        return $this->getDb()->getRow("SELECT (SELECT content.id FROM content WHERE content.id < ?i AND content.status IN (?a) AND content.category = ?s ORDER BY ?n DESC LIMIT 1) as prev,(SELECT content.id FROM content WHERE content.id > ?i AND content.status IN (?a) AND content.category = ?s ORDER BY ?n LIMIT 1) as next, content.id FROM content WHERE content.id = ?i ", $id, $status, $category, $sort, $id, $status, $category, $sort,  $id);
    }

    /**
     * @return int|bool
     */
    public function getLastId(){
        return $this->getDb()->getOne("SELECT content.id FROM content ORDER BY content.id DESC");
    }

    /**
     * @param array $status
     * @param int $page
     * @param int $limit
     * @param string $search
     * @return array
     */
    public function search($status, $page, $limit, $search) {
        $data = $this->getDb()->getAll("SELECT (SELECT COUNT(comments.id) FROM comments WHERE comments.content = content.id) as comments, (SELECT users.login FROM users WHERE users.id = content.user) as login, content.* FROM content WHERE content.title LIKE '%' ?s '%' OR content.header LIKE '%' ?s '%' OR content.shortentry LIKE '%' ?s '%' OR content.fullentry LIKE '%' ?s '%' AND content.status IN (?a) ORDER BY content.id LIMIT ?i, ?i", $search, $search, $search, $search, $status, $page * $limit - $limit, $limit);
        $this->addSubData($data, true);
        return $data;
    }

    /**
     * @param array $status
     * @param string $search
     * @return int
     */
    public function searchCount($status, $search) {
        return $this->getDb()->getOne("SELECT COUNT(content.id) FROM content WHERE content.title LIKE '%' ?s '%' OR content.header LIKE '%' ?s '%' OR content.shortentry LIKE '%' ?s '%' OR content.fullentry LIKE '%' ?s '%' AND content.status IN (?a)", $search, $search, $search, $search, $status);
    }

    /**
     * @param $data
     * @return bool
     */
    public function add($data) {
        $this->sqlDataHandler($data);
        $data['user'] = $this->getCookie('user-id');
        $data['category'] = empty($data['category']) ? '0' : $data['category'];
        $fieldsAndValues = $this->buildSQLAddArray($data, $this->availableFields, $this->toIntFields);
        if($this->getDb()->query("INSERT INTO content (".$fieldsAndValues['fields'].") VALUES (".$fieldsAndValues['values'].")")){
            $lastID = $this->getDb()->insertId();
            $this->getDb()->query("UPDATE content SET position = ?i WHERE id = ?i", $this->getLastId(), $lastID);
            $this->getLogs()->addContent($this->getDb()->insertId());
            $this->getCache()->clearAll();
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update($data) {
        $this->sqlDataHandler($data);
        $this->getCache()->clearAll();
        $this->getLogs()->editContent($data['id']);
        $sets = $this->buildSQLUpdateArray($data, $this->availableFields, $this->toIntFields);
        return $this->getDb()->query("UPDATE content SET ".$sets['sets']." WHERE id IN (?a)", $data['id']);
    }

    /**
     * @param array $id
     * @return bool
     */
    public function delete($id) {
        $this->deleteImages($id);
        $this->getCache()->clearAll();
        $this->getLogs()->deleteContent($id);
        return $this->getDb()->query("DELETE FROM content WHERE id IN (?a) ", $id);
    }

    /**
     * @return array
     */
    public function getAllImages() {
        $images = array();
        $data =  $this->getDb()->getAll("SELECT content.images, content.slider FROM content");
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
        $data = $this->getDb()->getAll("SELECT content.images, content.slider FROM content WHERE id IN (?a)", $id);
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
     * @param array $data
     */
    private function sqlDataHandler(&$data){
        if(isset($data['time'])){
            $data['time'] = $this->checkDateFormat($data['time']) ? $data['time'] : $this->getDate();
        }
        if(!$this->isArray($data['id'])){
            $data['user'] = $this->getCookie('user-id');
        }
        if($this->notEmpty($data['content'])){
            $data['tags'] = empty($data['tags']) ? '' : $data['tags'];
            $data['category'] = empty($data['category']) ? '0' : $data['category'];
        }
    }
}