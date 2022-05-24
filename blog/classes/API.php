<?php

/**
 * Class API
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class API extends App{

    /**
     * @var array|bool
     */
    private $param = false;

    /**
     * @var array|bool
     */
    private $data = false;

    /**
     * @return void
     */
    private function  getSQLSelectData(){
        $this->notEmpty($this->param['sql']) ?: $this->data['error'][] = 'empty sql query';
        !preg_match('(insert|update|delete)', strtolower($this->param['sql'])) ?: $this->data['error'][] = 'forbidden sql expression';
        if(!$this->notEmpty($this->data['error'])){
            $data = $this->getDb()->getAll($this->param['sql']);
            if($this->notEmpty($data) && $this->isArray($data)){
                $this->data['data'] = $data;
            }else{
                $this->data['error'][] = 'empty sql query result';
            }
        }
    }

    /**
     * @return void
     */
    private function setCategoryData(){
        $this->data['data'] = $this->getCategory()->getTree(array(1));
        $this->jsonToArray($this->data['data'], true);
    }

    /**
     * @return void
     */
    private function setTagsData(){
        $this->data['data'] = $this->getTags()->getAll();
        $this->jsonToArray($this->data['data'], true);
    }

    /**
     * @return void
     */
    private function setEntriesData(){
        $this->isInt($this->param['page']) ?: $this->data['error'][] = 'invalid param: page not int';
        $this->isInt($this->param['limit']) ?: $this->data['error'][] = 'invalid param: limit not int';
        $this->isString($this->param['sort']) ?: $this->data['error'][] = 'invalid param: sort not string';
        !($this->param['category'] != null && !$this->isInt($this->param['category'])) ?: $this->data['error'][] = 'invalid param: category not int';
        !($this->param['tags'] != null && !$this->isArray($this->param['tags'])) ?: $this->data['error'][] = 'invalid param: tags not array';
        !($this->param['id'] != null && !$this->isArray($this->param['id'])) ?: $this->data['error'][] = 'invalid param: id not array';
        if(empty($this->data['error'])){
            $this->data['data'] = $this->getContent()->get(array(1), $this->param['page'], $this->param['limit'], $this->param['sort'], $this->param['category'], $this->param['tags'], $this->param['id']);
            $this->jsonToArray($this->data['data'], true);
        }
    }

    /**
     * @return void
     */
    private function setRandomEntriesData(){
        $this->isInt($this->param['limit']) ?: $this->data['error'][] = 'invalid param: limit not int';
        !($this->param['category'] != null && !$this->isInt($this->param['category'])) ?: $this->data['error'][] = 'invalid param: category not int';
        if(empty($this->data['error'])){
            $this->data['data'] = $this->getContent()->getRandom(array(1), $this->param['limit'], $this->param['category']);
            $this->jsonToArray($this->data['data'], true);
        }
    }

    /**
     * @return void
     */
    private function setCommentsData(){
        $this->isInt($this->param['page']) ?: $this->data['error'][] = 'invalid param: page not int';
        $this->isInt($this->param['limit']) ?: $this->data['error'][] = 'invalid param: limit not int';
        $this->isString($this->param['sort']) ?: $this->data['error'][] = 'invalid param: sort not string';
        !($this->param['entry'] != null && !$this->isInt($this->param['entry'])) ?: $this->data['error'][] = 'invalid param: entry not int';
        if(empty($this->data['error'])){
            $this->data['data'] = $this->getComments()->get(array(1), $this->param['page'], $this->param['limit'], $this->param['sort'], $this->param['entry']);
        }
    }

    /**
     * @return string
     */
    public function getJSON(){
        $this->param = $this->getRequest()->getGETValues();
        if($this->param['token'] == $this->getSettings()->settings['api-token']){
            if($this->isString($this->param['action'])){
                switch ($this->param['action']){
                    case 'get-tags':
                        $this->setTagsData();
                        break;
                    case 'get-category':
                        $this->setCategoryData();
                        break;
                    case 'get-entries':
                        $this->setEntriesData();
                        break;
                    case 'get-random-entries':
                        $this->setRandomEntriesData();
                        break;
                    case 'get-comments':
                        $this->setCommentsData();
                        break;
                    case 'get-sql-select':
                        $this->getSQLSelectData();
                        break;
                    default:
                        $this->data['error'] = 'invalid action';
                }
            }else{
                $this->data['error'] = 'action not set';
            }
        }else{
            $this->data['error'] = 'invalid token';
        }
        return json_encode($this->data);
    }
}