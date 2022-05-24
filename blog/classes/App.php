<?php

/**
 * Class App
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class App extends Core{

    /**
     * @var Users
     */
    private $users;

    /**
     * @var Report
     */
    private $report;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var Messages
     */
    private $messages;

    /**
     * @var FormData
     */
    private $formData;

    /**
     * @var Pages
     */
    private $pages;

    /**
     * @var Comments
     */
    private $comments;

    /**
     * @var Tags
     */
    private $tags;

    /**
     * @var Chat
     */
    private $chat;

    /**
     * @var Summernote
     */
    private $summernote;

    /**
     * @var Images
     */
    private $images;

    /**
     * @var Notify
     */
    private $notify;

    /**
     * @var API
     */
    private $api;

    /**
     * @var FileEditor
     */
    private $fileEditor;

    /**
     * @var Subscriptions
     */
    private $subscriptions;

    /**
     * @var App
     */
    private static $instance;

    /**
     * App constructor.
     */
    function __construct() {
        parent::__construct();
        if(self::$instance) {
            $this->chat = &self::$instance->chat;
            $this->users = &self::$instance->users;
            $this->report = &self::$instance->report;
            $this->category = &self::$instance->category;
            $this->content = &self::$instance->content;
            $this->messages = &self::$instance->messages;
            $this->formData = &self::$instance->formData;
            $this->images = &self::$instance->images;
            $this->notify = &self::$instance->notify;
            $this->fileEditor = &self::$instance->fileEditor;
            $this->subscriptions = &self::$instance->subscriptions;
            $this->pages = &self::$instance->pages;
            $this->tags = &self::$instance->tags;
            $this->api = &self::$instance->api;
            $this->comments = &self::$instance->comments;
            $this->summernote = &self::$instance->summernote;
        } else {
            self::$instance = $this;
            $this->users = new Users();
            $this->report = new Report();
            $this->category = new Category();
            $this->content = new Content();
            $this->messages = new Messages();
            $this->chat = new Chat();
            $this->formData = new FormData();
            $this->images = new Images();
            $this->notify = new Notify();
            $this->fileEditor = new FileEditor();
            $this->subscriptions = new Subscriptions();
            $this->pages = new Pages();
            $this->tags = new Tags();
            $this->api = new API();
            $this->comments = new Comments();
            $this->summernote = new Summernote();
        }
    }

    /**
     * @return Users
     */
    public function getUsers(){
        return $this->users;
    }

    /**
     * @return Report
     */
    public function getReport(){
        return $this->report;
    }

    /**
     * @return Category
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * @return Content
     */
    public function getContent(){
        return $this->content;
    }
    
    /**
     * @return Images
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * @return Notify
     */
    public function getNotify() {
        return $this->notify;
    }

    /**
     * @return Pages
     */
    public function getPages(){
        return $this->pages;
    }

    /**
     * @return Tags
     */
    public function getTags(){
        return $this->tags;
    }

    /**
     * @return Chat
     */
    public function getChat(){
        return $this->chat;
    }

    /**
     * @return Messages
     */
    public function getMessages(){
        return $this->messages;
    }

    /**
     * @return API
     */
    public function getApi(){
        return $this->api;
    }

    /**
     * @return Comments
     */
    public function getComments() {
        return $this->comments;
    }
    
    /**
     * @return Summernote
     */
    public function getSummernote() {
        return $this->summernote;
    }

    /**
     * @return FormData
     */
    public function getFormData() {
        return $this->formData;
    }

    /**
     * @return FileEditor
     */
    public function getFileEditor() {
        return $this->fileEditor;
    }

    /**
     * @return Subscriptions
     */
    public function getSubscriptions() {
        return $this->subscriptions;
    }
}