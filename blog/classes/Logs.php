<?php

/**
 * Class Logs
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Logs {

    /**
     * @var Core
     */
    private $core;
    
    /**
     * Logs constructor.
     * @param Core $core
     */
    public function __construct($core){
        $this->core = $core;
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->core->getDb()->getOne("SELECT COUNT(logs.id) FROM logs");
    }

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function get($page, $limit) {
        return  $this->core->getDb()->getAll("SELECT (SELECT users.login FROM users WHERE users.id = logs.user) as login, logs.* FROM logs ORDER BY logs.id DESC  LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * @return array
     */
    public function getLastActions(){
        $logs = $this->core->getDb()->getAll("SELECT (SELECT users.login FROM users WHERE users.id = logs.user) as login, logs.* FROM logs ORDER BY logs.id DESC LIMIT ?i", 5);
        $data['count'] = count($logs);
        $data['logs'] = array_reverse($logs);
        return $data;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $search
     * @return array
     */
    public function search($page, $limit, $search) {
        $data = $this->core->getDb()->getAll("SELECT (SELECT users.login FROM users WHERE users.id = logs.user) as login, logs.* FROM logs WHERE logs.event LIKE '%' ?s '%' ORDER BY logs.id DESC LIMIT ?i, ?i", $search, $page * $limit - $limit, $limit);
        return $data;
    }

    /**
     * @param string $search
     * @return int
     */
    public function searchCount($search) {
        return $this->core->getDb()->getOne("SELECT COUNT(logs.id) FROM logs WHERE logs.event LIKE '%' ?s '%'", $search);
    }

    /**
     * @param int $id
     * @return void
     */
    public function addContent($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Added entry number: '.$id);
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function editContent($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Edited entry number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function deleteContent($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Deleted entry number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function addCategory($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Added category number: '.$id);
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function editCategory($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Edited category number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function deleteCategory($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Deleted category number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function addTag($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Added tag number: '.$id);
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function editTags($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Edited tag number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function deleteTags($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Deleted tag number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function addMessage($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Sent a message number: '.$id);
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function deleteMessages($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Deleted message number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function addUser($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Added user number: '.$id);
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function editUsers($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Edited by user number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function deleteUsers($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Deleted user number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function addChat($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Posted in chat message number: '.$id);
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function editComments($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Edited comment number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function deleteComments($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Deleted comment number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function addPage($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Added page number: '.$id);
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function editPage($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Edited page number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @param array $id
     * @return void
     */
    public function deletePage($id){
        if($this->core->getRequest()->isAdminPath()){
            $this->core->getDb()->query("INSERT INTO logs SET user = ?i, time = ?s, event = ?s", $this->core->getCookie('user-id'), $this->core->getDate(), 'Deleted page number: '. implode(',', $id));
            $this->core->getDb()->query("UPDATE logs SET position = ?i WHERE id = ?i", $this->core->getDb()->insertId(), $this->core->getDb()->insertId());
        }
    }

    /**
     * @return void
     */
    public function updateRequestLog(){
        $file = $this->core->getRootDir() . '/data/log';
        $lines = file($file);
        while(count($lines) > 1000)
            array_shift($lines);
        $lines[] = $this->core->getDate().'|'.$this->core->getRequest()->getUserAgent().'|'.$this->core->getRequest()->getUserIP().'|'.$this->core->getRequest()->getURL() . "\r\n";
        file_put_contents($file, $lines);
    }

    /**
     * @return void
     */
    public function updateStat() {
        if(!$this->core->getRequest()->isSearchBot()){
            $temp = $this->core->getCache()->readCache('statistics', date("d.m.y"), array());
            if($temp){
                $id = $temp;
            }else{
                $data = $this->core->getDb()->getOne("SELECT id FROM statistics WHERE period = ?s", date("d.m.y"));
                $id = $this->core->getCache()->writeCache('statistics', date("d.m.y"), array(), $data);
            }
            if($id) {
                if($this->core->getCookie('visit') == 'yes') {
                    $this->core->getDb()->query("UPDATE statistics SET total = total + 1 WHERE id = ?i", $id);
                } else {
                    $this->core->getDb()->query("UPDATE statistics SET total = total + 1, uniques = uniques + 1 WHERE id = ?i", $id);
                }
            } else {
                $this->core->getDb()->query("INSERT INTO statistics (period,  uniques, total) VALUES (?s, ?i, ?i)", date("d.m.y"), 1, 1);
            }
        }
        $this->updateRequestLog();
    }

    /**
     * @param $limit
     * @return array
     */
    public function getStat($limit) {
        return $this->core->getDb()->getAll("SELECT * FROM statistics ORDER BY id DESC LIMIT ?i", $limit);
    }
}