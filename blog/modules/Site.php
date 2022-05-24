<?php

/**
 * Class Site
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Site extends App{

    /**
     * @var string|bool
     */
    private $url = false;

    /**
     * @var array|bool
     */
    private $urls = false;

    /**
     * @var int|bool
     */
    private $page = false;

    /**
     * @var array|bool
     */
    private $user = false;

    /**
     * @var array|bool
     */
    private $tags = false;

    /**
     * @var int|bool
     */
    private $count = false;

    /**
     * @var string|bool
     */
    private $sort = false;

    /**
     * @var array|bool
     */
    private $data = false;

    /**
     * @var array|bool
     */
    private $news = false;

    /**
     * @var array|bool
     */
    private $pages = false;

    /**
     * @var int|bool
     */
    private $limit = false;

    /**
     * @var string|bool
     */
    private $title = false;

    /**
     * @var int|bool
     */
    private $active = false;

    /**
     * @var array|bool
     */
    private $entries = false;

    /**
     * @var array|bool
     */
    private $neighbor = false;

    /**
     * @var array|bool
     */
    private $category = false;

    /**
     * @var string|bool
     */
    private $keywords = false;

    /**
     * @var array|bool
     */
    private $settings = false;

    /**
     * @var int|bool
     */
    private $pageCount = false;

    /**
     * @var int|bool
     */
    private $pageLast = false;

    /**
     * @var bool
     */
    private $pageLastShow = false;

    /**
     * @var string|bool
     */
    private $template = false;

    /**
     * @var array|bool
     */
    private $comments = false;

    /**
     * @var string|bool
     */
    private $description = false;

    /**
     * @var array|bool
     */
    private $bookmark = false;

    /**
     * @var array|bool
     */
    private $updatedRatings = false;

    /**
     * @var string|bool
     */
    private $tagPrefix = false;

    /**
     * @var string|bool
     */
    private $tagURLPrefix = false;

    /**
     * @var array|bool
     */
    private $categoryPrefix = false;

    /**
     * @var string|bool
     */
    private $categoryURLPrefix = false;


    /**
     * Site constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->settings = $this->getSettings()->settings;
        $this->limit = $this->settings['page-rows'];
        $this->setSort();
    }

    /**
     * @return bool
     */
    public function isOffline(){
        return $this->settings['site-enable'] ? false : true;
    }

    /**
     * @return void
     */
    public function setVisit(){
        if($this->getCookie('visit') != 'yes'){
            $this->setCookie('visit', 'yes', gmmktime(23), '/');
        }
    }

    /**
     * @return void
     */
    private function setUrl(){
        $this->urls['pages'] = $this->getPages()->getUrl($this->getPages()->systemType);
        $this->urls['category'] = array(
            'prefix-enable' => $this->settings['category-prefix-enable'],
            'prefix' => $this->settings['category-prefix-enable'] ? '/'.$this->urls['pages']['catalog'].'/' : '/',
        );
        $this->urls['content'] = array(
            'prefix-enable' => $this->settings['content-prefix-enable']
        );
    }

    /**
     * @return void;
     */
    private function setSort(){
        $valid = array('id', 'time', 'views', 'rating');
        $sort = $this->getCookie('sort');
        if(in_array($sort, $valid)){
            $this->sort = $sort;
        }else{
            $this->sort = $this->settings['sort-site'];
        }
    }

    /**
     * @param int $category
     * @param int $page
     * @return void
     */
    private function setLastPage($category, $page){
        $array = unserialize($this->getCookie('category-page-last'));
        $viewed = $this->sessionGetValue('category-viewed-id');
        if($this->settings['category-page-last-enable'] && $this->isInt($array[$category])){
            if($category != $viewed){
                $this->pageLastShow = true;
                $this->pageLast = $array[$category];
            }
        }
        $array[$category] = $page;
        $this->sessionSetValue('category-viewed-id', $category);
        $this->setCookie('category-page-last', serialize($array), time() + 60 * 60 * 24 * 30, '/');
    }

    /**
     * @return string|bool
     */
    public function updateSort(){
        $valid = array('id', 'time', 'views', 'rating');
        $sort = $this->getRequest()->getPOSTValues('sort');
        if(in_array($sort, $valid)){
            $this->setCookie('sort', $sort);
            return $sort;
        }
        return false;
    }

    /**
     * @return array|bool
     */
    public function updateRating(){
        if($this->getRequest()->isPOST() && $this->getRequest()->getPOSTValues('id') > 0){
            $this->updatedRatings = explode(',', $this->getCookie('updated-ratings'));
            if(!in_array($this->getRequest()->getPOSTValues('id'), $this->updatedRatings)){
                $rating = $this->getContent()->getOne($this->getRequest()->getPOSTValues('id'), 'rating') + 1;
                $this->getContent()->update(array(
                    'id' => array($this->getRequest()->getPOSTValues('id')),
                    'rating' => $rating
                ));
                $this->updatedRatings[] = $this->getRequest()->getPOSTValues('id');
                $this->setCookie('updated-ratings', implode(',', $this->updatedRatings), time() + 60 * 60 * 24 *30);
                return $rating;
            }
        }
        return false;
    }

    /**
     * @return array|bool
     */
    public function updateBookmark(){
        if($this->getRequest()->isPOST()){
            $this->bookmark = explode(',', $this->getCookie('bookmark'));
            if(!in_array($this->getRequest()->getPOSTValues('id'), $this->bookmark)){
                $this->bookmark[] = $this->getRequest()->getPOSTValues('id');
            }else{
                $key = array_search($this->getRequest()->getPOSTValues('id'), $this->bookmark);
                unset($this->bookmark[$key]);
            }
            $this->setCookie('bookmark', implode(',', $this->bookmark), time() + 60 * 60 * 24 * 30);
            return count($this->bookmark) - 1;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getBookmarkCount(){
        return count(explode(',', $this->getCookie('bookmark'))) - 1;
    }

    /**
     * @return array
     */
    private function getNewEntries(){
        $data = $this->getContent()->get(array(1), 1, 3, 'id');
        $this->jsonToArray($data, true);
        return $data;
    }

    /**
     * @return array
     */
    private function getBookmarkId(){
        return explode(',', $this->getCookie('bookmark'));
    }

    /**
     * @return array
     */
    private function getUpdatedRatingsId(){
        return explode(',', $this->getCookie('updated-ratings'));
    }

    /**
     * @return void
     */
    private function setMainData(){
        $this->tags = $this->getTags()->getAll();
        $this->user = $this->getUsers()->getUser();
        $this->news = $this->getNewEntries();
        $this->pages = $this->getPages()->getTree(array(1), array(2, 3, 4, 5, 6, 7));
        $this->bookmark = $this->getBookmarkId();
        $this->category = $this->getCategory()->getTree(array(1));
        $this->updatedRatings = $this->getUpdatedRatingsId();
        $this->setPrefix();
        $this->setUrl();

    }

    /**
     * @return void
     */
    private function setPrefix(){
        $this->tagPrefix = $this->getPages()->getOne(2, 'url');
        $this->categoryPrefix = $this->getPages()->getOne(4, 'url');
        $this->tagURLPrefix =  '/'.$this->tagPrefix.'/';
        $this->categoryURLPrefix = $this->settings['category-prefix-enable'] ? '/'.$this->categoryPrefix.'/' : '/';
    }

    /**
     * @param int $page
     * @return array
     */
    public function home($page){
        $this->setMainData();
        $this->page = $page;
        $this->template = 'main/list';
        $this->count = $this->getContent()->getCount(array(1), null, null, null, null);
        $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 1;
        if($this->page > $this->pageCount || $this->page < 1){
            return $this->notFound();
        }else{
            $this->data = $this->getPages()->getRow(3);
            $this->entries = $this->getContent()->get(array(1), $this->page, $this->limit, $this->sort);
            $this->url = '/page-';
            $this->title = $this->settings['site-title'];
            $this->keywords = $this->settings['site-keywords'];
            $this->description = $this->settings['site-description'];
            $this->decodeHtml($this->data);
            $this->jsonToArray($this->data);
            $this->jsonToArray($this->entries, true);
        }
        return $this->outArray();
    }

    /**
     * @param string $category
     * @param int $page
     * @return mixed
     */
    public function category($category, $page){
        $this->setMainData();
        $id = $this->getCategory()->getId($category, array(1));
        if($this->isInt($id)){
            $this->page = $page;
            $this->template = 'main/list';
            $this->count = $this->getContent()->getCount(array(1), null, $id, null, null);
            $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 1;
            if($this->page > $this->pageCount || $this->page < 1){
                return $this->notFound();
            }else{
                $this->active = $id;
                $this->data = $this->getCategory()->getRow($id);
                $this->entries = $this->getContent()->get(array(1), $this->page, $this->limit, $this->sort, $id);
                $this->url = $this->categoryURLPrefix.$category.'/page-';
                $this->title = $this->data['title'];
                $this->keywords = $this->data['keywords'];
                $this->description = $this->data['description'];
                $this->setLastPage($id, $page);
                $this->decodeHtml($this->data);
                $this->jsonToArray($this->data);
                $this->jsonToArray($this->entries, true);
                return $this->outArray();
            }
        }
        return $this->notFound();
    }

    /**
     * @param int $id
     * @return array
     */
    public function entry($id){
        $this->setMainData();
        $this->template = 'entries/entry';
        $data = $this->getContent()->getRow($id);
        if($data['status'] == 0){
            if($this->user == false || $this->user['role'] != 0){
                return $this->notFound();
            }
        }
        if($this->isArray($data)){
            $this->data = $data;
            $this->jsonToArray($this->data);
            $this->decodeHtml($this->data);
            $this->title = $this->data['title'];
            $this->keywords = $this->data['keywords'];
            $this->description = $this->data['description'];
            $this->comments = $this->getComments()->getAllTree(array(1), $id, 'time');
            $this->neighbor = $this->getContent()->getNeighborID(array(1), $this->sort, $data['category'], $data['id']);
            $this->neighbor['prev'] = $this->notEmpty($this->neighbor['prev']) ? getEntryURL($this->urls, $this->getContent()->getRow($this->neighbor['prev'])) : null;
            $this->neighbor['next'] = $this->notEmpty($this->neighbor['next']) ? getEntryURL($this->urls, $this->getContent()->getRow($this->neighbor['next'])) : null;
            $this->getContent()->update(array('views' => ($data['views'] + 1), 'id' => array($data['id'])));
        }else{
            return $this->notFound();
        }
        return $this->outArray();
    }

    /**
     * @return array
     */
    public function login(){
        $this->setMainData();
        if(!$this->user){
            $this->template = 'users/login';
            $this->title = 'log in';
        }else{
            header("Location: /");
        }
        return $this->outArray();
    }

    /**
     * @return bool
     */
    public function logout(){
        $this->getUsers()->logout();
        header("Location: /");
        return false;
    }

    /**
     * @return array
     */
    public function register(){
        $this->setMainData();
        if(!$this->user){
            $this->template = 'users/register';
            $this->title = 'User registration';
        }else{
            header("Location: /");
        }
        return $this->outArray();
    }

    /**
     * @return array
     */
    public function lostPassword(){
        $this->setMainData();
        if(!$this->user){
            $this->template = 'password/lost';
            $this->title = 'Password recovery';
        }else{
            header("Location: /");
        }
        return $this->outArray();
    }

    /**
     * @param string $lost
     * @return array
     */
    public function newPassword($lost){
        $this->setMainData();
        $id = $this->getUsers()->getIdByLost($lost);
        if($this->isInt($id)){
            $this->template = 'password/new';
            $this->title = 'Enter new password';
            $this->sessionSetValue('lost-password-id', $id);
            $this->sessionSetValue('lost-password-key', $lost);
        }else{
            header("Location: /");
        }
        return $this->outArray();
    }

    /**
     * @return array
     */
    public function profile(){
        $this->setMainData();
        if(!empty($this->user)){
            $this->title = 'My profile';
            $this->template = 'users/profile';
            $this->data = $this->getUsers()->getRow($this->user['id']);
            $this->entries = $this->getContent()->get(array(0), 1, 100, 'time', null, null, null, $this->user['id']);
            $this->comments = $this->getComments()->get(array(0), 1, 100, 'time', null, null, $this->user['id']);
            $this->jsonToArray($this->entries, true);
            $this->count = 100;
        }else{
            header("Location: /");
        }
        return $this->outArray();
    }

    /**
     * @param int $page
     * @return array
     */
    public function userEntries($page){
        $this->setMainData();
        $this->page = $page;
        $this->template = 'main/list';
        $this->title = 'User posts «'.$this->user['login'].'»';
        $this->count = $this->getContent()->getCount(array(0, 1), null, null, null, $this->user['id']);
        $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 1;
        if($this->page > $this->pageCount || $this->page < 1 || $this->user == false){
            return $this->notFound();
        }else{
            $this->data['header'] = $this->title;
            $this->data['elements']['elements'][] = 'entries';
            $this->data['elements']['property']['entries-enable'] = 1;
            $this->entries = $this->getContent()->get(array(0, 1), $this->page, $this->limit, $this->sort, null, null, null, $this->user['id']);
            $this->url = '/user/entries/page-';
            $this->jsonToArray($this->entries, true);
            return $this->outArray();
        }
    }

    /**
     * @param int $page
     * @return array
     */
    public function userComments($page){
        $this->setMainData();
        $this->page = $page;
        $this->template = 'main/list';
        $this->title = 'User comments «'.$this->user['login'].'»';
        $this->count = $this->getComments()->getCount(array(0, 1), null, null, $this->user['id']);
        $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 1;
        if($this->page > $this->pageCount || $this->page < 1 || $this->user == false){
            return $this->notFound();
        }else{
            $this->data['header'] = $this->title;
            $this->data['elements']['elements'][] = 'comments';
            $this->data['elements']['property']['comments-enable'] = 1;
            $this->comments = $this->getComments()->get(array(0, 1), $this->page, $this->limit, 'time', null, null, $this->user['id']);
            $this->url = '/user/comments/page-';
            return $this->outArray();
        }
    }

    /**
     * @param int $id
     * @return array
     */
    private function add($id){
        $this->setMainData();
        $this->template = 'pages/add';
        $this->data = $this->getPages()->getRow($id);
        $this->jsonToArray($this->data);
        $this->decodeHtml($this->data);
        return $this->outArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function page($id){
        $this->setMainData();
        $this->template = 'pages/page';
        $this->data = $this->getPages()->getRow($id);
        $this->title = $this->data['title'];
        $this->keywords = $this->data['keywords'];
        $this->description = $this->data['description'];
        $this->jsonToArray($this->data);
        $this->decodeHtml($this->data);
        return $this->outArray();
    }

    /**
     * @param int $id
     * @return array
     */
    private function gallery($id){
        $this->setMainData();
        $this->template = 'pages/gallery';
        $this->data = $this->getPages()->getRow($id);
        $this->title = $this->data['title'];
        $this->keywords = $this->data['keywords'];
        $this->description = $this->data['description'];
        $this->jsonToArray($this->data);
        $this->decodeHtml($this->data);
        return $this->outArray();
    }

    /**
     * @param int $page
     * @return array
     */
    private function bookmark($page){
        $this->setMainData();
        $this->template = 'main/list';
        $this->page = $page;
        $this->count = $this->getBookmarkCount();
        $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 1;
        if($this->page > $this->pageCount || $this->page < 1){
            return $this->notFound();
        }else{
            $this->data = $this->getPages()->getRow(6);
            $this->entries = $this->getContent()->get(array(1), $this->page, $this->limit, $this->sort, null, null, $this->bookmark);
            $this->url = '/'.$this->data['url'].'/page-';
            $this->title = $this->data['title'];
            $this->keywords = $this->data['keywords'];
            $this->description = $this->data['description'];
            $this->decodeHtml($this->data);
            $this->jsonToArray($this->data);
            $this->jsonToArray($this->entries, true);
            return $this->outArray();
        }
    }

    /**
     * @return string
     */
    private function sitemap(){
        $this->setMainData();
        $data = $this->getCategory()->getAll(array(1));
        $xml = new DomDocument('1.0', 'utf-8');
        $urlset = $xml->appendChild($xml->createElement('urlset'));
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        foreach($data as $t) {
            for($i = intval(($t['count'] - 1) / $this->limit) + 1; $i > 0; $i--) {
                $url = $urlset->appendChild($xml->createElement('url'));
                $url->appendChild($xml->createElement('loc', $this->getRequest()->getBaseURL().$this->categoryURLPrefix.$t['url'] . '/page-' . $i));
                $url->appendChild($xml->createElement('changefreq', 'daily'));
                $url->appendChild($xml->createElement('priority', 0.5));
            }
        }
        $xml->formatOutput = true;
        return $xml->saveXML();
    }

    /**
     * @return string
     */
    private function rss(){
        $this->setMainData();
        $data = $this->getContent()->get(array(1), 1, 30, 'time');
        $this->jsonToArray($data, true);
        $xml = new DomDocument('1.0', 'utf-8');
        $rss = $xml->appendChild($xml->createElement('rss'));
        $rss->setAttribute('version', '2.0');
        $channel = $rss->appendChild($xml->createElement('channel'));
        $channel->appendChild($xml->createElement("title", $this->settings['site-title']));
        $channel->appendChild($xml->createElement("link", 'http://' . $this->getRequest()->getHTTPHost()));
        $channel->appendChild($xml->createElement("description", $this->settings['site-description']));
        foreach ($data as $t) {
            $item = $channel->appendChild($xml->createElement('item'));
            $item->appendChild($xml->createElement('title', $t['header']));
            $item->appendChild($xml->createElement('link', $this->getRequest()->getBaseURL().getEntryURL($this->urls, $t)));
            $item->appendChild($xml->createElement('description', $t['content']));
            $item->appendChild($xml->createElement('pubDate', date("D, d M Y H:i:s O", strtotime($t['time']))));
        }
        $xml->formatOutput = true;
        return $xml->saveXML();
    }

    /**
     * @param int $page
     * @return array
     */
    private function search($page){
        $this->setMainData();
        if($this->getRequest()->isPOST()){
            $this->sessionSetValue('search', $this->getRequest()->getPOSTValues('search'));
            header('Location: /search');
        }
        $this->template = 'main/list';
        $this->page = $page;
        $this->count = $this->getContent()->searchCount(array(1), $this->sessionGetValue('search'));
        $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 1;
        if($this->page > $this->pageCount || $this->page < 1){
            return $this->notFound();
        }else{
            $this->title = 'Site search';
            $this->data['header'] = $this->title;
            $this->data['search-count'] = $this->count;
            $this->data['elements']['elements'][] = 'search';
            $this->data['search-string'] = $this->sessionGetValue('search');
            if(mb_strlen($this->sessionGetValue('search'), 'utf-8') < 3){
                $this->pageCount = 0;
                $this->data['search-error'] = true;
            }elseif ($this->count == 0){
                $this->pageCount = 0;
                $this->data['search-empty'] = true;
            }else{
                $this->data['search-success'] = true;
                $this->data['elements']['elements'][] = 'entries';
                $this->data['elements']['property']['entries-enable'] = 1;
                $this->entries = $this->getContent()->search(array(1), $this->page, $this->limit, $this->sessionGetValue('search'));
                $this->jsonToArray($this->entries, true);
                $this->url = '/search/page-';
            }
            return $this->outArray();
        }
    }

    /**
     * @param string $tag
     * @param int $page
     * @return mixed
     */
    private function tag($tag, $page){
        $this->setMainData();
        $id = $this->getTags()->getId(urldecode($tag));
        if($this->isInt($id)){
            $this->page = $page;
            $this->template = 'main/list';
            $this->count = $this->getContent()->getCount(array(1), $id, null, null, null);
            $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 1;
            if($this->page > $this->pageCount || $this->page < 1){
                return $this->notFound();
            }else{
                $this->data = $this->getPages()->getRow(2);
                $this->decodeHtml($this->data);
                $this->jsonToArray($this->data);
                !$this->data['elements']['property']['tag-name-enable'] ?: $this->data['title'] = $this->data['title'].' «'.urldecode($tag).'»';
                !$this->data['elements']['property']['tag-name-enable'] ?: $this->data['header'] = $this->data['header'].' «'.urldecode($tag).'»';
                $this->entries = $this->getContent()->get(array(1), $this->page, $this->limit, $this->sort, null, $id);
                $this->url = '/'.$this->data['url'].'/'.urldecode($tag).'/page-';
                $this->title = $this->data['title'];
                $this->keywords = $this->data['keywords'];
                $this->description = $this->data['description'];
                $this->jsonToArray($this->entries, true);
                return $this->outArray();
            }
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    public function getUserPage(){
        if($this->getRequest()->getRoutes(2) == 'entries'){
            if(preg_match('/page-(\d+$)/', $this->getRequest()->getRoutes(3))){
                return $this->userEntries(explode('-', $this->getRequest()->getRoutes(3))[1]);
            }elseif ($this->getRequest()->getRoutes(3) == ''){
                return $this->userEntries(1);
            }
        }elseif($this->getRequest()->getRoutes(2) == 'comments'){
            if(preg_match('/page-(\d+$)/', $this->getRequest()->getRoutes(3))){
                return $this->userComments(explode('-', $this->getRequest()->getRoutes(3))[1]);
            }elseif($this->getRequest()->getRoutes(3) == ''){
                return $this->userComments(1);
            }
        }elseif ($this->getRequest()->getRoutes(2) == ''){
            return $this->profile();
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    public function getLostPasswordPage(){
        if(preg_match('/key-(\w+$)/', $this->getRequest()->getRoutes(2))){
            return $this->newPassword(explode('-', $this->getRequest()->getRoutes(2))[1]);
        }elseif($this->getRequest()->getRoutes(2) == ''){
            return $this->lostPassword();
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    public function getSearchPage(){
        if(preg_match('/page-(\d+$)/', $this->getRequest()->getRoutes(2))){
            return $this->search(explode('-', $this->getRequest()->getRoutes(2))[1]);
        }elseif($this->getRequest()->getRoutes(2) == ''){
            return $this->search(1);
        }
        return $this->notFound();
    }

    /**
     * @return array|mixed
     */
    public function getCategoryPage(){
        $nameRoute = $this->settings['category-prefix-enable'] ? 2 : 1;
        $pageRoute = $this->settings['category-prefix-enable'] ? 3 : 2;
        $checkRoute = $this->settings['category-prefix-enable'] ? 4 : 3;
        if($this->isString($this->getRequest()->getRoutes($nameRoute))){
            if(preg_match('/page-(\d+$)/', $this->getRequest()->getRoutes($pageRoute))){
                return $this->category($this->getRequest()->getRoutes($nameRoute), explode('-', $this->getRequest()->getRoutes($pageRoute))[1]);
            }elseif($this->getRequest()->getRoutes($pageRoute) == ''){
                return $this->category($this->getRequest()->getRoutes($nameRoute), 1);
            }else{
                if($this->settings['content-prefix-enable']){
                    $content = $this->getContent()->getId($this->getRequest()->getRoutes($pageRoute), [1]);
                    if($this->notEmpty($content) && !$this->notEmpty($this->getRequest()->getRoutes($checkRoute))){
                        return $this->entry($content);
                    }
                }
            }
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    public function getTagPage(){
        if(preg_match('/page-(\d+$)/', $this->getRequest()->getRoutes(3))){
            return $this->tag($this->getRequest()->getRoutes(2), explode('-', $this->getRequest()->getRoutes(3))[1]);
        }elseif($this->getRequest()->getRoutes(3) == ''){
            return $this->tag($this->getRequest()->getRoutes(2), 1);
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    public function getBookmarkPage(){
        if(preg_match('/page-(\d+$)/', $this->getRequest()->getRoutes(2))){
            return $this->bookmark(explode('-', $this->getRequest()->getRoutes(2))[1]);
        }elseif ($this->getRequest()->getRoutes(2) == ''){
            return $this->bookmark(1);
        }
        return $this->notFound();
    }

    /**
     * @return array|bool
     */
    public function getRobots(){
        if($this->settings['robots-enable']){
            header("Content-Type: text/plain; charset=utf-8", true);
            $content =  htmlspecialchars_decode($this->settings['robots-content']);
            echo  str_replace('{host}', $this->getRequest()->getBaseURL(), $content);
            return true;
        }
        return $this->notFound();
    }

    /**
     * @return array|bool
     */
    public function getSiteMap(){
        if($this->settings['sitemap-enable']){
            header("Content-Type: text/xml; charset=utf-8", true);
            echo $this->sitemap();
            return true;
        }
        return $this->notFound();
    }

    /**
     * @return array|bool
     */
    public function getRSS(){
        if($this->settings['rss-enable']){
            header("Content-Type: text/xml; charset=utf-8", true);
            echo $this->rss();
            return true;
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    private function notFound() {
        $this->setMainData();
        header("HTTP/1.0 404 Not Found");
        $this->template = 'pages/page';
        $this->data = $this->getPages()->getRow(1);
        $this->title = $this->data['title'];
        $this->jsonToArray($this->data);
        $this->decodeHtml($this->data);
        return $this->outArray();
    }

    /**
     * @return array|bool
     */
    public function getAPIData(){
        if($this->settings['api-enable']){
            header("Content-Type: application/json; charset=utf-8", true);
            echo $this->getAPI()->getJSON();
            return true;
        }
        return $this->notFound();
    }

    /**
     * @return array
     */
    private function getOtherPage(){
        if(preg_match('/page-(\d+$)/', $this->getRequest()->getRoutes(1))){
            return $this->home(explode('-', $this->getRequest()->getRoutes(1))[1]);
        }else{
            if(!$this->settings['content-prefix-enable']){
                $content = $this->getContent()->getId($this->getRequest()->getRoutes(1), [1]);
                if($this->notEmpty($content) && !$this->notEmpty($this->getRequest()->getRoutes(2))){
                    return $this->entry($content);
                }
            }
        }
        return $this->getCategoryPage();
    }

    /**
     * @return array
     */
    public function getPage(){
        $data = $this->getPages()->getMeta($this->getRequest()->getRoutes(1), array(1));
        if($this->isArray($data) && $data['status'] == 1){
            switch ($data['type']){
                case 1:
                    return $this->getTagPage();
                    break;
                case 3:
                    return $this->getCategoryPage();
                    break;
                case 4:
                    return $this->getBookmarkPage();
                    break;
                case 5:
                    return $this->add($data['id']);
                    break;
                case 6:
                    return $this->page($data['id']);
                    break;
                case 7:
                    return $this->gallery($data['id']);
                    break;
            }
        }
        return $this->getOtherPage();
    }

    /**
     * @return array
     */
    private function outArray(){
        return array(
            'template' => $this->template,
            'title' => $this->title,
            'keywords' => $this->keywords,
            'description' => $this->description,
            'main' => array(
                'user' => $this->user
            ),
            'navbar' => array(
                'urls' => $this->urls,
                'pages' => $this->pages,
                'category' => $this->category,
                'category-url-prefix' => $this->categoryURLPrefix
            ),
            'sidebar' => array(
                'urls' => $this->urls,
                'news' => $this->news,
                'tags' => $this->tags,
                'active' => $this->active,
                'settings' => $this->settings,
                'category' => $this->category,
                'tag-url-prefix' => $this->tagURLPrefix,
                'category-url-prefix' => $this->categoryURLPrefix
            ),
            'content' => array(
                'url' => $this->url,
                'urls' => $this->urls,
                'page' => $this->page,
                'data' => $this->data,
                'news' => $this->news,
                'user' => $this->user,
                'sort' => $this->sort,
                'tags' => $this->tags,
                'limit' => $this->limit,
                'count' => $this->count,
                'entries' => $this->entries,
                'settings' => $this->settings,
                'comments' => $this->comments,
                'category' => $this->category,
                'bookmark' => $this->bookmark,
                'page-last' => $this->pageLast,
                'page-count' => $this->pageCount,
                'page-last-show' => $this->pageLastShow,
                'tag-url-prefix' => $this->tagURLPrefix,
                'category-url-prefix' => $this->categoryURLPrefix,
                'updated-ratings' => $this->updatedRatings,
                'neighbor' => $this->neighbor
            )
        );
    }

    /**
     * @return string|bool
     */
    public function ajaxSearch(){
        header("Content-Type: application/json; charset=utf-8", true);
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $result['query'] = $this->getRequest()->getPOSTValues('search');
        $result['suggestions'] = [];
        if(mb_strlen($this->getRequest()->getPOSTValues('search')) > 3){
            $data = $this->getContent()->search(array(1), 1, 30, $result['query']);
            $this->setUrl();
            foreach ($data as $t){
                $result['suggestions'][] = array(
                    'value' => mb_substr($t['header'], 0, 30).'...',
                    'data' => getEntryURL($this->urls, $t)
                );
            }
            return json_encode($result);
        }
        return json_encode($result);
    }

    /**
     * @return string;
     */
    public  function unsubscribe(){
        header("refresh: 5; url=/");
        $email = base64_decode($this->getRequest()->getRoutes(2));
        if($this->getSubscriptions()->checkEmail($email)){
            $this->getSubscriptions()->deleteByEmail($email);
            return 'You have unsubscribed from the newsletter!';
        }
        return 'An error has occurred!';
    }

    /**
     * @return bool|string
     */
    public function addLostPassword(){
        $data = $this->getRequest()->getPOSTValues();
        if ($this->isString($data['lostname']) && $this->sessionGetValue('captcha-0') == md5($data['captcha'])) {
            $id = $this->getUsers()->getId($data['lostname']);
            $this->sessionSetValue('captcha-0', rand(0, 9999));
            if(!$this->isInt($id)) {
                $id = $this->getUsers()->getIdByEmail($data['lostname']);
            }
            if($this->isInt($id)){
                $key = md5(md5(rand(0, 999999).$data['lostname']));
                $data = $this->getUsers()->getRow($id);
                if ($this->getUsers()->update(array('id' => array($id), 'lost' => $key))) {
                    if($this->getNotify()->lostPassword($data['email'], $data['login'], $key)){
                        return 'ok';
                    }
                }
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function addUser(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->isString($data['login'], $data['name'], $data['email'], $data['password']) && $this->sessionGetValue('captcha-0') == md5($data['captcha'])){
            $data['role'] = 1;
            if($this->getUsers()->add($data)){
                if($this->getUsers()->login($data['login'], $data['password'])){
                    return 'ok';
                }
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function updateUserPassword(){
        $data = $this->getRequest()->getPOSTValues();
        $data['id'] = $this->sessionGetValue('lost-password-id');
        $data['key'] = $this->sessionGetValue('lost-password-key');
        if($this->isInt($data['id']) && $this->isString($data['key'], $data['password']) && $this->sessionGetValue('captcha-0') == md5($data['captcha'])){
            $user = $this->getUsers()->getRow($data['id']);
            $this->sessionSetValue('captcha-0', rand(0, 9999));
            $this->sessionSetValue('lost-password-id', rand(0, 9999));
            $this->sessionSetValue('lost-password-key', rand(0, 9999));
            if($user['lost'] == $data['key']){
                if($this->getUsers()->update(array('id' => array($data['id']), 'password' => $data['password'], 'lost' => ''))){
                    if($this->getUsers()->login($user['login'], $data['password'])){
                        return 'ok';
                    }
                }
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function updateUser(){
        $data = $this->getRequest()->getPOSTValues();
        $this->user = $this->getUsers()->getUser();
        if($this->isString($data['login'], $data['name'], $data['email'], $data['current-password']) && $this->user){
            if(md5(md5($data['current-password'])) == $this->user['password']){
                $data['id'][] = $this->user['id'];
                $data['time'] = $this->user['time'];
                if($this->notEmpty($data['new-password'])){
                    $data['password'] = $data['new-password'];
                }
                if($this->getUsers()->update($data)){
                    return 'ok';
                }
            }else{
                return 'wrong-password';
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function addContent(){
        $data = $this->getRequest()->getPOSTValues();
        if(!empty($this->user)){
            $data['user'] = $this->user['id'];
        }
        if($this->isString($data['shortentry']) && $this->sessionGetValue('captcha-0') == md5($data['captcha'])){
            $data['status'] = 0;
            $data['time'] = $this->getDate();
            $data['elements'] = $this->getContent()->getDefaultElements();
            $this->sessionSetValue('captcha-0', rand(0, 9999));
            if($this->getContent()->add($data)){
                $this->sessionSetValue('captcha-0', rand(0, 9999));
                return 'ok';
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function addComment(){
        $data = $this->getRequest()->getPOSTValues();
        $this->user = $this->getUsers()->getUser();
        if(!empty($this->user)){
            $data['name'] = $this->user['login'];
            $data['email'] = $this->user['email'];
            $data['user'] = $this->user['id'];
        }
        if($this->isString($data['name'], $data['email'], $data['comment']) && $this->sessionGetValue('captcha-0') == md5($data['captcha'])){
            $data['ip'] = $this->getRequest()->getUserIP();
            $data['status'] = $this->settings['comment-moderation-enable'] ? 0 : 1;
            $this->sessionSetValue('captcha-0', rand(0, 9999));
            if($this->getComments()->add($data)){
                return $this->settings['comment-moderation-enable'] ? 'moderation' : 'no-moderation';
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function addDeliveryEmail(){
        $data = $this->getRequest()->getPOSTValues();
        $data['status'] = 1;
        $data['time'] = $this->getDate();
        $data['email'] = $data['subscribe-email'];
        if($this->getSubscriptions()->checkEmail($data['email'])) {
            return 'already signed';
        }
        if ($this->getSubscriptions()->add($data)) {
            return 'ok';
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function addFormData(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->isString($data['json'], $data['page']) && $this->sessionGetValue('captcha-0') == md5($data['captcha'])){
            $data['status'] = 0;
            $data['time'] = $this->getDate();
            $this->sessionSetValue('captcha-0', rand(0, 9999));
            if($this->getFormData()->add($data)){
                if($this->getSettings()->settings['notifications-enable']){
                    $this->getNotify()->formSubmit($data);
                }
                return 'ok';
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function checkCaptcha(){
        $valid = md5($this->getRequest()->getPOSTValues('captcha')) == $this->sessionGetValue('captcha-0') ? true : false;
        return json_encode(array(
            'valid' => $valid
        ));
    }

    /**
     * @return string|bool
     */
    public function checkFreeLogin(){
        $free = true;
        $id = $this->getUsers()->getId($this->getRequest()->getPOSTValues('login'));
        if($this->isInt($id)){
            $free = $this->getRequest()->getPOSTValues('id') == $id ? true : false;
        }
        return json_encode(array(
            'valid' => $free
        ));
    }

    /**
     * @return string|bool
     */
    public function checkFreeEmail(){
        $free = true;
        $id = $this->getUsers()->getIdByEmail($this->getRequest()->getPOSTValues('email'));
        if($this->isInt($id)){
            $free = $this->getRequest()->getPOSTValues('id') == $id ? true : false;
        }
        return json_encode(array(
            'valid' => $free
        ));
    }

    /**
     * @return string|bool
     */
    public function checkFreeURL(){
        $free = true;
        $id = $this->getPages()->getId($this->getRequest()->getPOSTValues('url'), array(0, 1));
        if($this->isInt($id)){
            $free = $this->getRequest()->getPOSTValues('id') == $id ? true : false;
        }else{
            $id = $this->getContent()->getId($this->getRequest()->getPOSTValues('url'), array(0, 1));
            if($this->isInt($id)){
                $free = $this->getRequest()->getPOSTValues('id') == $id ? true : false;
            }else{
                $id = $this->getCategory()->getId($this->getRequest()->getPOSTValues('url'), array(0, 1));
                if($this->isInt($id)){
                    $free = $this->getRequest()->getPOSTValues('id') == $id ? true : false;
                }
            }
        }
        return json_encode(array(
            'valid' => $free
        ));
    }
}