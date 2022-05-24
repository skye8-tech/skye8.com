<?php

/**
 * Class Admin
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Admin extends App {

    /**
     * @var array|bool
     */
    private $settings = false;
    
    /**
     * @var int|bool
     */
    private $page = false;

    /**
     * @var string|bool
     */
    private $url = false;

    /**
     * @var string|bool
     */
    private $urlParam = false;

    /**
     * @var string|bool
     */
    private $title = false;

    /**
     * @var array|bool
     */
    private $data = false;

    /**
     * @var array|bool
     */
    private $sidebar = false;

    /**
     * @var string|bool
     */
    private $search = false;

    /**
     * @var int|bool
     */
    private $count = false;

    /**
     * @var string|bool
     */
    private $template = false;

    /**
     * @var int|bool
     */
    private $pageCount = false;

    /**
     * @var int|bool
     */
    private $active = false;

    /**
     * @var bool
     */
    private $filter = false;

    /**
     * @var int|bool
     */
    private $limit = false;

    /**
     * @var string|bool
     */
    private $sort = false;

    
    /**
     * Admin constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->settings = $this->getSettings()->settings;
        $this->limit = $this->getSettings()->settings['page-rows-admin'];
        $this->sort = $this->getSettings()->settings['sort-admin'];
    }

    /**
     * @return array
     */
    public function managementContent() {
        $this->title = 'Record management';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);
        $activeCount = $this->getContent()->getCount(array(1));
        $inactiveCount = $this->getContent()->getCount(array(0));
        $allCount = $this->getContent()->getCount(array(0, 1));

        switch($this->filter){
            case 'active':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $activeCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getContent()->get(array(1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/content/active/';
                $this->title.= ' - published';
                break;
            case 'inactive':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $inactiveCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getContent()->get(array(0), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/content/inactive/';
                $this->title.= ' - hidden';
                break;
            case 'category':
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->page = $this->getRequest()->getRoutes(5) > 0 ? $this->getRequest()->getRoutes(5) : 1;
                $this->count = $this->getContent()->getCount(array(0, 1), null, $this->active);
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getContent()->get(array(0, 1), $this->page, $this->limit, $this->sort, $this->active);
                $this->url = '/admin/content/category/'.$this->active.'/';
                $this->title.= ' - from category: '.$this->getCategory()->getOne($this->active, 'name');
                break;
            case 'not-category':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $this->getContent()->getCount(array(0, 1), null, 0);
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getContent()->get(array(0, 1), $this->page, $this->limit, $this->sort, 0);
                $this->url = '/admin/content/not-category/';
                $this->title.= ' - without category';
                break;
            case 'search':
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getContent()->searchCount(array(0, 1), $this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getContent()->search(array(0, 1), $this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                    $this->search = $this->getRequest()->getGETValues('search');
                }
                $this->url = '/admin/content/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                break;
            case 'user':
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->page = $this->getRequest()->getRoutes(5) > 0 ? $this->getRequest()->getRoutes(5) : 1;
                $this->count = $this->getContent()->getCount(array(0, 1), null, null, $this->getRequest()->getRoutes(4));
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getContent()->get(array(0, 1), $this->page, $this->limit, $this->sort, null, null, null, $this->active);
                $this->url = '/admin/content/user/'.$this->getRequest()->getRoutes(4).'/';
                $this->title.= ' - user records: '.$this->getUsers()->getLogin($this->getRequest()->getRoutes(4));
                break;
            case 'tag':
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->page = $this->getRequest()->getRoutes(5) > 0 ? $this->getRequest()->getRoutes(5) : 1;
                $this->count = $this->getContent()->getCount(array(0, 1), $this->active, null);
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getContent()->get(array(0, 1), $this->page, $this->limit, $this->sort, null, $this->active);
                $this->url = '/admin/content/tag/'.$this->active.'/';
                $this->title.= ' - with tag: '.$this->getTags()->getOne($this->active, 'name');
                break;
            case 'one':
                $this->page = 1;
                $this->pageCount = 1;
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getContent()->get(array(1), 1, 1, $this->sort, null, null, array($this->active));
                $this->count = count($this->data) ? 1 : 0;
                $this->title.= ' - record #'.$this->active;
                break;
            default:
                $this->filter = '';
                $this->page = $this->getRequest()->getRoutes(3) > 0 ? $this->getRequest()->getRoutes(3) : 1;
                $this->count = $allCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getContent()->get(array(0, 1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/content/';
                $this->title.= ' - all';
        }

        $bg = array(
            'not-category' => 'primary',
            'inactive' => 'warning',
            'category' => 'primary',
            'active' => 'success',
            'search' => 'primary',
            'user' => 'primary',
            'tag' => 'primary',
            'one' => 'primary',
            '' => 'primary',
        );

        if($this->page > $this->pageCount || $this->page == 0){
            $this->count = 0;
        }

        return array(
            'template' => 'content',
            'title' => $this->title,
            'path' => 'Record management',
            'data' => array(
                'bg' => $bg[$this->filter],
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'New entry',
                        'icon' => 'fa fa-plus',
                        'class' => 'content-add',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'All entries',
                        'icon' => 'fa fa-newspaper-o',
                        'active' => $this->filter == '' ? 1 : 0,
                        'badge' => $allCount,
                        'url' => '/admin/content',
                    ),
                    array(
                        'name' => 'without category',
                        'icon' => 'fa fa-folder-o',
                        'active' => $this->filter == 'not-category' ? 1 : 0,
                        'badge' => $this->getContent()->getCount(array(0, 1), null, 0),
                        'url' => '/admin/content/not-category',
                    ),
                    array(
                        'name' => 'Published',
                        'icon' => 'fa fa-eye',
                        'active' => $this->filter == 'active' ? 1 : 0,
                        'badge' => $activeCount,
                        'url' => '/admin/content/active',
                    ),
                    array(
                        'name' => 'Hidden',
                        'icon' => 'fa fa-eye-slash',
                        'active' => $this->filter == 'inactive' ? 1 : 0,
                        'badge' => $inactiveCount,
                        'url' => '/admin/content/inactive',
                    )
                ),
                'active' => $this->active,
                'filter' => $this->filter,
                'tags' => $this->getTags()->getAll(),
                'category' => $this->getCategory()->getTree(array(0, 1))
            ),
        );
    }

    /**
     * @return array
     */
    public function managementCategory(){
        $this->title = 'Category management';
        return array(
            'template' => 'category',
            'title' => $this->title,
            'path' => 'Category management',
            'data' => array(
                'title' => $this->title,
                'data' => $this->getSettings()->settings,
                'bg' => 'primary'
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'New category',
                        'icon' => 'fa fa-plus',
                        'class' => 'category-add',
                        'url' => '#',
                    ),
                )
            ),
        );
    }

    /**
     * @return array
     */
    public function managementComments() {
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);
        $this->title = 'Comment management';
        $activeCount = $this->getComments()->getCount(array(1));
        $inactiveCount = $this->getComments()->getCount(array(0));
        $allCount = $this->getComments()->getCount(array(0, 1));

        switch($this->filter){
            case 'active':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $activeCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getComments()->get(array(1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/comments/active/';
                $this->title.= ' - published';
                break;
            case 'inactive':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $inactiveCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getComments()->get(array(0), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/comments/inactive/';
                $this->title.= ' - hidden';
                break;
            case 'content':
                $this->page = 1;
                $this->pageCount = 1;
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getComments()->get(array(0, 1), $this->page, $this->limit, $this->sort, $this->active);
                $this->url = '/admin/comments/news/'.$this->active.'/';
                $this->title.= ' - to record: '.$this->getContent()->getOne($this->active, 'id');
                $this->count = count($this->data) ? 1 : 0;
                break;
            case 'search':
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->search = $this->getRequest()->getGETValues('search');
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getComments()->searchCount(array(0, 1), $this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getComments()->search(array(0, 1), $this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                }
                $this->url = '/admin/comments/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                break;
            case 'user':
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->page = $this->getRequest()->getRoutes(5) > 0 ? $this->getRequest()->getRoutes(5) : 1;
                $this->count = $this->getComments()->getCount(array(0, 1), null, null, $this->getRequest()->getRoutes(4));
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getComments()->get(array(0, 1), $this->page, $this->limit, $this->sort, null, null, $this->active);
                $this->url = '/admin/comments/user/'.$this->active.'/';
                $this->title.= ' - user comments: '.$this->getUsers()->getLogin($this->active);
                break;
            case 'one':
                $this->page = 1;
                $this->pageCount = 1;
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getComments()->get(array(0, 1), 1, 1, $this->sort, null, array($this->active), null);
                $this->count = count($this->data) ? 1 : 0;
                $this->title.= ' - comment #'.$this->active;
                break;
            default:
                $this->page = $this->getRequest()->getRoutes(3) > 0 ? $this->getRequest()->getRoutes(3) : 1;
                $this->count = $allCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getComments()->get(array(0, 1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/comments/';
                $this->title.= ' - все';
        }

        $bg = array(
            'inactive' => 'warning',
            'active' => 'success',
            'search' => 'primary',
            'news' => 'primary',
            'user' => 'primary',
            'one' => 'primary',
            '' => 'primary',
        );

        if($this->page > $this->pageCount || intval($this->page) == 0){
            $this->count = 0;
        }

        return array(
            'template' => 'comments',
            'title' => $this->title,
            'path' => 'Comment management',
            'data' => array(
                'bg' => $bg[$this->filter],
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'All comments',
                        'icon' => 'fa fa-comments-o',
                        'active' => $this->filter == '' ? 1 : 0,
                        'badge' => $activeCount,
                        'url' => '/admin/comments',
                    ),
                    array(
                        'name' => 'Published',
                        'icon' => 'fa fa-eye',
                        'active' => $this->filter == 'active' ? 1 : 0,
                        'badge' => $activeCount,
                        'url' => '/admin/comments/active',
                    ),
                    array(
                        'name' => 'Hidden',
                        'icon' => 'fa fa-eye-slash',
                        'active' => $this->filter == 'inactive' ? 1 : 0,
                        'badge' => $inactiveCount,
                        'url' => '/admin/comments/inactive',
                    )
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function managementSettings() {
        return array(
            'template' => 'settings',
            'title' => 'Script settings',
            'path' => 'Script settings',
            'data' => array(
                'data' => include $this->getRootDir() . '/data/settings.php'
                ),
            'side' => array(
                'title' => 'Options',
                'data' => array(
                    array(
                        'name' => 'Clear cache',
                        'icon' => 'fa fa-trash',
                        'class' => 'cache-clear',
                        'url' => '#'
                    ),
                    array(
                        'name' => 'Clear image',
                        'icon' => 'fa fa-trash',
                        'class' => 'images-clear',
                        'url' => '#'
                    )
                )
            )
        );
    }

    /**
     * @return array
     */
    public function managementReport() {
        $this->title = 'Summary of key figures';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);
        $side = null;

        switch($this->filter){
            default:
                $this->filter = '';
                $this->data = [];
                $this->url = '/admin/report/';
                $this->title.= '';
        }

        return array(
            'template' => 'report',
            'title' => $this->title,
            'path' => 'Summary of key figures',
            'data' => array(
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'filter' => $this->filter,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => $side
        );
    }

    /**
     * @return array
     */
    public function managementChat() {
        $this->title = 'Internal chat';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);

        switch($this->filter){
            default:
                $this->filter = '';
                $this->data = [];
                $this->url = '/admin/chat/';
                $this->title.= '';
        }

        return array(
            'template' => 'chat',
            'title' => $this->title,
            'path' => 'Internal chat',
            'data' => array(
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            )
        );
    }

    /**
     * @return array
     */
    public function managementSearch() {
        $this->title = 'Global search';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);

        switch($this->filter){
            default:
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->data['content-count'] = $this->getContent()->searchCount([0, 1], $this->getRequest()->getGETValues('search'));
                    $this->data['content-data'] = $this->getContent()->search([0, 1], 1, 50, $this->getRequest()->getGETValues('search'));
                    $this->search = $this->getRequest()->getGETValues('search');
                }
                $this->url = '/admin/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
        }

        $bg = array(
            '' => 'primary',
        );

        return array(
            'template' => 'search',
            'title' => $this->title,
            'path' => 'Global search',
            'data' => array(
                'bg' => $bg[$this->filter],
                'data' => $this->data,
                'title' => $this->title,
                'search' => $this->search,
                'settings' => $this->getSettings()->settings
            )
        );
    }

    /**
     * @return array
     */
    public function managementMessages() {
        $this->title = 'Messages';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);

        switch($this->filter){
            case 'outbox':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $this->getMessages()->getCount(null, [Registry::get('user-id')]);
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getMessages()->get($this->page, $this->limit, $this->sort, null, [Registry::get('user-id')]);
                $this->url = '/admin/messages/outbox';
                $this->title.= ' - outgoing';
                break;
            case 'unread':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $this->getMessages()->getCount([Registry::get('user-id')], null, [0]);
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getMessages()->get($this->page, $this->limit, $this->sort, [Registry::get('user-id')], null, [0]);
                $this->url = '/admin/messages/unread';
                $this->title.= ' - unread';
                break;
            case 'search':
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getMessages()->searchCount($this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getMessages()->search($this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                    $this->search = $this->getRequest()->getGETValues('search');
                }
                $this->url = '/admin/messages/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                break;
            case 'one':
                $this->page = 1;
                $this->pageCount = 1;
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getMessages()->get(1, 1, $this->sort, null, null, null, null, array($this->active));
                $this->count = count($this->data) ? 1 : 0;
                $this->title.= ' - '.$this->data[0]['subject'];
                break;
            default:
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $this->getMessages()->getCount([Registry::get('user-id')]);
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getMessages()->get($this->page, $this->limit, $this->sort, [Registry::get('user-id')]);
                $this->url = '/admin/message/inbox';
                $this->title.= ' - inbox';
        }

        $bg = array(
            'outbox' => 'primary',
            'unread' => 'warning',
            'search' => 'primary',
            'one' => 'primary',
            '' => 'success',
        );

        if($this->page > $this->pageCount || $this->page == 0){
            $this->count = 0;
        }

        return array(
            'template' => 'message',
            'title' => $this->title,
            'path' => 'Messages',
            'data' => array(
                'bg' => $bg[$this->filter],
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'Send',
                        'icon' => 'fa fa-send-o',
                        'class' => 'message-add',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Inbox',
                        'icon' => 'fa fa-inbox',
                        'active' => $this->filter == '' ? 1 : 0,
                        'badge' => $this->getMessages()->getCount([Registry::get('user-id')]),
                        'url' => '/admin/messages',
                    ),
                    array(
                        'name' => 'Outgoing',
                        'icon' => 'fa fa-send',
                        'active' => $this->filter == 'outbox' ? 1 : 0,
                        'badge' => $this->getMessages()->getCount(null, [Registry::get('user-id')]),
                        'url' => '/admin/messages/outbox',
                    ),
                    array(
                        'name' => 'Unread',
                        'icon' => 'fa fa-envelope',
                        'active' => $this->filter == 'unread' ? 1 : 0,
                        'badge' => $this->getMessages()->getCount([Registry::get('user-id')], null, [0]),
                        'url' => '/admin/messages/unread',
                    )
                ),
                'active' => $this->active,
            ),
        );
    }

    /**
     * @return array
     */
    public function managementTags(){
        $this->title = 'Tag management';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);
        switch($this->filter){
            case 'search':
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->search = $this->getRequest()->getGETValues('search');
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getTags()->searchCount($this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getTags()->search($this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                }
                $this->url = '/admin/tags/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                break;
            case 'one':
                $this->page = 1;
                $this->pageCount = 1;
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getTags()->get(1, 1, $this->sort, array($this->active));
                $this->count = count($this->data) ? 1 : 0;
                $this->title.= ' - '.$this->data[0]['name'];
                break;
            default:
                $this->page = $this->getRequest()->getRoutes(3) > 0 ? $this->getRequest()->getRoutes(3) : 1;
                $this->count = $this->getTags()->getCount();
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getTags()->get($this->page, $this->limit, $this->sort);
                $this->url = '/admin/tags/';
        }

        if($this->page > $this->pageCount || $this->page == 0){
            $this->count = 0;
        }

        return array(
            'template' => 'tags',
            'title' => $this->title,
            'path' => 'Tag management',
            'data' => array(
                'bg' => 'primary',
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'Add tag',
                        'icon' => 'fa fa-plus',
                        'class' => 'tag-add',
                        'url' => '#',
                    ),
                )
            ),
        );
    }

    /**
     * @return array
     */
    public function managementPages(){
        $this->title = 'Page management';
        return array(
            'template' => 'pages',
            'title' => $this->title,
            'path' => 'Page management',
            'data' => array(
                'title' => $this->title,
                'data' => $this->getSettings()->settings,
                'bg' => 'primary'
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'New page',
                        'icon' => 'fa fa-file-o',
                        'class' => 'page-add',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'New gallery',
                        'icon' => 'fa fa-file-image-o',
                        'class' => 'gallery-add',
                        'url' => '#',
                    )
                )
            ),
        );
    }

    /**
     * @return array
     */
    public function managementSubscriptions() {
        $this->title = 'Email management';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);
        $activeCount = $this->getSubscriptions()->getCount(array(1));
        $inactiveCount = $this->getSubscriptions()->getCount(array(0));
        $allCount = $this->getSubscriptions()->getCount(array(0,1));

        switch($this->filter){
            case 'active':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $activeCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getSubscriptions()->get(array(1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/subscriptions/active/';
                $this->title.= ' - active';
                break;
            case 'inactive':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $inactiveCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getSubscriptions()->get(array(0), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/subscriptions/inactive/';
                $this->title.= ' - inactive';
                break;
            case 'search':
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->search = $this->getRequest()->getGETValues('search');
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getSubscriptions()->searchCount(array(0, 1), $this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getSubscriptions()->search(array(0, 1), $this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                }
                $this->url = '/admin/subscriptions/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                break;
            case 'one':
                $this->page = 1;
                $this->pageCount = 1;
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getSubscriptions()->get(array(0, 1), 1, 1, $this->sort, array($this->active));
                $this->count = count($this->data) ? 1 : 0;
                $this->title.= ' - '.$this->data[0]['email'];
                break;
            default:
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $allCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getSubscriptions()->get(array(0, 1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/subscriptions/';
                $this->title.= ' - все';
        }

        if($this->page > $this->pageCount || $this->page == 0){
            $this->count = 0;
        }

        $bg = array(
            'inactive' => 'warning',
            'active' => 'success',
            'search' => 'primary',
            'one' => 'primary',
            '' => 'primary',
        );

        return array(
            'template' => 'subscriptions',
            'title' => $this->title,
            'path' => 'Email management',
            'data' => array(
                'bg' => $bg[$this->filter],
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'New Newsletter',
                        'icon' => 'fa fa-send',
                        'class' => 'new-subscriptions',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'All subscribers',
                        'icon' => 'fa fa-send-o',
                        'active' => $this->filter == '' ? 1 : 0,
                        'badge' => $allCount,
                        'url' => '/admin/subscriptions',
                    ),
                    array(
                        'name' => 'Active',
                        'icon' => 'fa fa-eye',
                        'active' => $this->filter == 'active' ? 1 : 0,
                        'badge' => $activeCount,
                        'url' => '/admin/subscriptions/active',
                    ),
                    array(
                        'name' => 'Inactive',
                        'icon' => 'fa fa-eye-slash',
                        'active' => $this->filter == 'inactive' ? 1 : 0,
                        'badge' => $inactiveCount,
                        'url' => '/admin/subscriptions/inactive',
                    )
                )
            ),
        );
    }

    /**
     * @return array
     */
    public function managementUsers() {
        $this->title = 'User management';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);
        $role = 0;

        switch($this->filter){
            case 'admin':
                $this->template = 'users';
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $this->getUsers()->getCount(array(0));
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getUsers()->get(array(0), $this->page, $this->limit);
                $this->url = '/admin/users/admin/';
                $this->title.= ' - administrators';
            break;
            case 'search':
                $this->template = 'users';
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getUsers()->searchCount($this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getUsers()->search($this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                    $this->search = $this->getRequest()->getGETValues('search');
                }
                $this->url = '/admin/users/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                $role = 1;
                break;
            case 'search-event':
                $this->template = 'logs';
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getLogs()->searchCount($this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getLogs()->search($this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                    $this->search = $this->getRequest()->getGETValues('search');
                }
                $this->url = '/admin/users/search-event/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                $role = 1;
                break;
            case 'logs':
                $this->template = 'logs';
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $this->getLogs()->getCount();
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getLogs()->get($this->page, $this->limit);
                $this->url = '/admin/users/logs/';
                $this->title.= ' - user actions';
                break;
            case 'one':
                $this->page = 1;
                $this->pageCount = 1;
                $this->template = 'users';
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getUsers()->get(array(0, 1), 1, 1, array($this->active));
                $this->count = count($this->data) ? 1 : 0;
                $this->title.= ' - '. $this->data[0]['login'];
                $role = 1;
                break;
            default:
                $this->filter = '';
                $this->template = 'users';
                $this->page = $this->getRequest()->getRoutes(3) > 0 ? $this->getRequest()->getRoutes(3) : 1;
                $this->count = $this->getUsers()->getCount(array(1));
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getUsers()->get(array(1), $this->page, $this->limit);
                $this->url = '/admin/users/';
                $this->title.= ' - users';
                $role = 1;
        }

        $bg = array(
            'search-event' => 'primary',
            'search' => 'primary',
            'admin' => 'success',
            'logs' => 'primary',
            'one' => 'primary',
            '' => 'primary',
        );


        $sideAction[] = array(
            'name' => 'Add user',
            'icon' => 'fa fa-plus',
            'class' => 'user-add',
            'url' => '#',
        );

        if($this->page > $this->pageCount || $this->page == 0){
            $this->count = 0;
        }

        if($this->getCookie('user-id') == 1){
            $sideAction[] = array(
                'name' => 'Clear action log',
                'icon' => 'fa fa-trash',
                'class' => 'log-clear',
                'url' => '#',
            );
        }

        return array(
            'template' => $this->template,
            'title' => $this->title,
            'path' => 'user management',
            'data' => array(
                'bg' => $bg[$this->filter],
                'role' => $role,
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'filter' => $this->filter,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => array(
                'title' => 'Actions',
                'data' => $sideAction
            ),
        );
    }

    /**
     * @return array
     */
    public function managementFormData() {
        $this->title = 'Form data';
        $this->filter = $this->isInt($this->getRequest()->getRoutes(3)) ? '' : $this->getRequest()->getRoutes(3);
        $viewedCount = $this->getFormData()->getCount(array(1));
        $notViewedCount = $this->getFormData()->getCount(array(0));
        $allCount = $this->getFormData()->getCount(array(0, 1));

        switch($this->filter){
            case 'viewed':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $viewedCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getFormData()->get(array(1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/formdata/active/';
                $this->title.= ' - viewed';
                break;
            case 'not-viewed':
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $notViewedCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getFormData()->get(array(0), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/formdata/not-viewed/';
                $this->title.= ' - not viewed';
                break;
            case 'search':
                if($this->isString($this->getRequest()->getGETValues('search'))){
                    $this->search = $this->getRequest()->getGETValues('search');
                    $this->page = $this->getRequest()->getGETValues('page') > 0 ? $this->getRequest()->getGETValues('page') : 1;
                    $this->count = $this->getFormData()->searchCount(array(0, 1), $this->getRequest()->getGETValues('search'));
                    $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                    $this->data = $this->getFormData()->search(array(0, 1), $this->page, $this->limit, $this->getRequest()->getGETValues('search'));
                }
                $this->url = '/admin/formdata/search/?search='.$this->search.'&page=';
                $this->title.= ' - searching results';
                break;
            case 'one':
                $this->page = 1;
                $this->pageCount = 1;
                $this->active = $this->isInt($this->getRequest()->getRoutes(4)) ? $this->getRequest()->getRoutes(4) : 1;
                $this->data = $this->getFormData()->get(array(0, 1), 1, 1, $this->sort, array($this->active));
                $this->count = count($this->data) ? 1 : 0;
                $this->title.= ' - request #'.$this->active;
                break;
            default:
                $this->page = $this->getRequest()->getRoutes(4) > 0 ? $this->getRequest()->getRoutes(4) : 1;
                $this->count = $allCount;
                $this->pageCount = $this->count > 0 ? (intval(($this->count - 1) / $this->limit) + 1) : 0;
                $this->data = $this->getFormData()->get(array(0, 1), $this->page, $this->limit, $this->sort);
                $this->url = '/admin/formdata/active/';
                $this->title.= ' - all requests';
        }

        $bg = array(
            'not-viewed' => 'success',
            'viewed' => 'warning',
            'search' => 'primary',
            'one' => 'primary',
            '' => 'primary',
        );

        if($this->page > $this->pageCount || $this->page == 0){
            $this->count = 0;
        }

        return array(
            'template' => 'formdata',
            'title' => $this->title,
            'path' => 'Form data',
            'data' => array(
                'bg' => $bg[$this->filter],
                'url' => $this->url,
                'data' => $this->data,
                'page' => $this->page,
                'count' => $this->count,
                'limit' => $this->limit,
                'title' => $this->title,
                'search' => $this->search,
                'page-count' => $this->pageCount,
                'url-param' => $this->urlParam,
                'settings' => $this->getSettings()->settings
            ),
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'All requests',
                        'icon' => 'fa fa-database',
                        'active' => $this->filter == '' ? 1 : 0,
                        'badge' => $allCount,
                        'url' => '/admin/formdata',
                    ),
                    array(
                        'name' => 'Viewed',
                        'icon' => 'fa fa-eye',
                        'active' => $this->filter == 'viewed' ? 1 : 0,
                        'badge' => $viewedCount,
                        'url' => '/admin/formdata/viewed',
                    ),
                    array(
                        'name' => 'Not viewed',
                        'icon' => 'fa fa-eye-slash',
                        'active' => $this->filter == 'not-viewed' ? 1 : 0,
                        'badge' => $notViewedCount,
                        'url' => '/admin/formdata/not-viewed',
                    )
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function managementTemplates() {
        $this->title = 'Template management';
        $this->filter = $this->getRequest()->getRoutes(3);

        switch($this->filter){
            case 'edit':
                $this->template = 'editor';
                $this->url = '/admin/templates/edit';
                $this->title.= ' - template editing';
                $this->data = array(
                    'patch' => PATH . '/public/templates/',
                    'templates' =>$this->getTemplatesList(),
                    'edit-template' => $this->notEmpty($this->sessionGetValue('edit-template')) ? $this->sessionGetValue('edit-template') : $this->settings['template'],
                );
                $this->sidebar = array(
                    'title' => 'Files',
                    'design-edit' => true,
                    'data' => array(true)
                );
                break;
            default:
                $this->template = 'templates';
                $this->url = '/admin/templates';
                $this->title.= ' - template selection';
                $this->data = array(
                    'templates' => $this->getTemplatesList(),
                    'template' => $this->settings['template']
                );
                $this->sidebar = array(
                'title' => 'Actions',
                'data' => array(
                    array(
                        'name' => 'Edit',
                        'icon' => 'fa fa-edit',
                        'class' => '',
                        'url' => '/admin/templates/edit',
                    ),
                )
            );
        }
        
        return array(
            'template' => $this->template,
            'title' => $this->title,
            'path' => 'Template management',
            'data' => array(
                'title' => $this->title,
                'data' => $this->data,
                'url' => $this->url,
                'bg' => 'primary',
                'settings' => $this->getSettings()->settings
            ),
            'side' => $this->sidebar
        );
    }

    /**
     * @return array
     */
    public function managementStatistics() {
        return array(
            'template' => 'statistics',
            'title' => 'Attendance Statistics',
            'path' => 'Attendance Statistics',
            'side' => array(
                'title' => 'Navigation',
                'data' => array(
                    array(
                        'name' => 'Requests log',
                        'icon' => 'fa fa-book',
                        'class' => 'view-log',
                        'url' => '#',
                    )
                )
            ),
        );
    }

    /**
     * @return array
     */
    private function getTemplatesList(){
        return array_diff(scandir(PATH . '/public/templates/'), array('.', '..'));
    }

    /**
     * @return bool
     */
    public function clearCache(){
        return $this->getCache()->clearAll();
    }

    /**
     * @return bool
     */
    public function clearImages(){
        $news = $this->getContent()->getAllImages();
        $pages = $this->getPages()->getAllImages();
        $headings = $this->getCategory()->getAllImages();
        $this->getImages()->multipleDelete(array_diff($this->getImages()->getMainImagesList(),
            array_merge($news, $pages, $headings)));
        return true;
    }

    /**
     * @return bool
     */
    public function clearLog(){
        if($this->getDb()->query("TRUNCATE logs")) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateSettings(){
        $this->getCache()->clearAll();
        return $this->getSettings()->updateSettings($this->getRequest()->getPOSTValues());
    }

    /**
     * @return int|bool
     */
    public function getChatLastId(){
        return $this->getChat()->getLastId();
    }

    /**
     * @return array|bool
     */
    public function getChatLastMessage(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->isInt($data['last'])){
            $this->setHeaderJSON();
            return json_encode(array(
                'count' => $this->getChat()->getCount(),
                'last' => $this->getChat()->getLastId(),
                'messages' => $this->getChat()->getLast($data['last'])
            ));
        }
        return false;
    }

    /**
     * @return bool
     */
    public function sendChatMessage(){
        $data = $this->getRequest()->getPOSTValues();
        $data['user'] = $this->getUsers()->getUser()['id'];
        if($this->getChat()->add($data)){
            $this->setHeaderJSON();
            return json_encode(array(
                'count' => $this->getChat()->getCount(),
                'last' => $this->getChat()->getLastId(),
                'messages' => $this->getChat()->getLast($data['last'])
            ));
        }
        return false;
    }

    /**
     * @return array
     */
    public function getCategoryAddData(){
        $param = $this->getRequest()->getPOSTValues();
        return array(
            'category' => $this->getCategory()->getTree(array(0, 1)),
            'parent' => $param['parent']
        );
    }

    /**
     * @return array
     */
    public function getCategoryEditData() {
        $param = $this->getRequest()->getPOSTValues();
        $data = $this->getCategory()->getRow($param['id']);
        $data['elements'] = $this->parseJSON($data['elements']);
        $data['images'] = $this->parseJSON($data['images']);
        $data['slider'] = $this->parseJSON($data['slider']);
        return array(
            'category' => $this->getCategory()->getTree(array(0, 1)),
            'data' => $data
        );
    }

    /**
     * @return array
     */
    public function getContentAddData(){
        return array(
            'tags' => $this->getTags()->getAll(),
            'category' => $this->getCategory()->getTree(array(0, 1))
        );
    }

    /**
     * @return array
     */
    public function getContentEditData() {
        $param = $this->getRequest()->getPOSTValues();
        $data = $this->getContent()->getRow($param['id']);
        $data['elements'] = $this->parseJSON($data['elements']);
        $data['images'] = $this->parseJSON($data['images']);
        $data['slider'] = $this->parseJSON($data['slider']);
        $data['video'] = $this->parseJSON($data['video']);
        $data['form'] = $this->parseJSON($data['form']);
        return array(
            'use-tags' => explode(',', $data['tags']),
            'use-category' => explode(',', $data['category']),
            'settings' => $this->settings,
            'category' => $this->getCategory()->getTree(array(0, 1)),
            'tags' => $this->getTags()->getAll(),
            'data' => $data
        );
    }

    /**
     * @return string|bool
     */
    public function checkValidLicenseKey(){
        $this->setHeaderJSON();
        return json_encode(array(
            'valid' => $this->checkLicenseKey($this->getRequest()->getPOSTValues('license-key'))
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

    /**
     * @return string|bool
     */
    public function checkFreeTagName(){
        $free = true;
        $id = $this->getTags()->getId($this->getRequest()->getPOSTValues('name'));
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
    public function checkSuperPassword(){
        $data = $this->getUsers()->getRow(1);
        $valid = md5(md5($this->getRequest()->getPOSTValues('super-password'))) == $data['password'] ? true : false;
        return json_encode(array(
            'valid' => $valid
        ));
    }

    /**
     * @return bool
     */
    public function addMessage(){
        $data = $this->getRequest()->getPOSTValues();
        $data['status'] = 0;
        $data['time'] = $this->getDate();
        $data['user'] = Registry::get('user-id');
        if($this->getMessages()->add($data)){
            $this->getNotify()->message(array(
                'header' => $data['subject'],
                'message' => $data['message']),
                $this->getUsers()->getOne($data['recipient'], 'email'));
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function addPage(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->getPages()->add($data)){
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateTagsPosition(){
        $array = json_decode($this->getRequest()->getPOSTValues('json'), true);
        if($this->isArray($array)) {
            foreach($array as $t){
                $this->getTags()->update($t);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateCommentsPosition(){
        $array = json_decode($this->getRequest()->getPOSTValues('json'), true);
        if($this->isArray($array)) {
            foreach($array as $t){
                $this->getComments()->update($t);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateContentPosition(){
        $array = json_decode($this->getRequest()->getPOSTValues('json'), true);
        if($this->isArray($array)) {
            foreach($array as $t){
                $this->getContent()->update($t);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateMessagePosition(){
        $array = json_decode($this->getRequest()->getPOSTValues('json'), true);
        if($this->isArray($array)) {
            foreach($array as $t){
                $this->getMessages()->update($t);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateSubscriptionsPosition(){
        $array = json_decode($this->getRequest()->getPOSTValues('json'), true);
        if($this->isArray($array)) {
            foreach($array as $t){
                $this->getSubscriptions()->update($t);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateFormDataPosition(){
        $array = json_decode($this->getRequest()->getPOSTValues('json'), true);
        if($this->isArray($array)) {
            foreach($array as $t){
                $this->getFormData()->update($t);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateSubscriptions(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->getSubscriptions()->update($data)){
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function deleteMessage(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->getMessages()->delete($data['id'])){
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function deleteSubscriptions(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->getSubscriptions()->delete($data['id'])){
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getTagEditData() {
        $param = $this->getRequest()->getPOSTValues();
        return array(
            'data' => $this->getTags()->getRow($param['id'])
        );
    }

    /**
     * @return array
     */
    public function getEvaluationViewPeriodData() {
        $data = $this->getRequest()->getPOSTValues();
        return array(
            'user' => $this->getUsers()->getRow($data['user']),
        );
    }

    /**
     * @return array
     */
    public function getMessageAddData() {
        return array(
            'users' => $this->getUsers()->getAll([0, 1, 2, 3])
        );
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUserEditData($id) {
        return array(
            'data' => $this->getUsers()->getRow($id)
        );
    }
    
    /**
     * @return array
     */
    public function getPageAddData(){
        return array(
            'pages' => $this->getPages()->getTree(array(0, 1), array(6, 7)),
            'parent' => $this->getRequest()->getPOSTValues('parent')
        );
    }

    /**
     * @return array
     */
    public function getPageEditData() {
        $data = $this->getPages()->getRow($this->getRequest()->getPOSTValues('id'));
        $data['elements'] = $this->parseJSON($data['elements']);
        $data['images'] = $this->parseJSON($data['images']);
        $data['slider'] = $this->parseJSON($data['slider']);
        $data['video'] = $this->parseJSON($data['video']);
        $data['form'] = $this->parseJSON($data['form']);
        return array(
            'pages' => $this->getPages()->getTree(array(0, 1), array(6, 7)),
            'data' => $data
        );
    }

    /**
     * @return array
     */
    public function getCommentsLocationData(){
        $ip = $this->getRequest()->getPOSTValues('ip');
        return $this->parseJSON(file_get_contents('http://ip-api.com/json/'.$ip));
    }

    /**
     * @return array
     */
    public function getCommentEditData() {
        return array(
            'data' => $this->getComments()->getRow($this->getRequest()->getPOSTValues('id'))
        );
    }

    /**
     * @return array
     */
    public function getMessageViewData(){
        $param = $this->getRequest()->getPOSTValues();
        $data = $this->getMessages()->getRow($this->getRequest()->getPOSTValues('id'));
        if($data['user'] !== Registry::get('user-id')){
            $this->getMessages()->update(array('status' => 1, 'id' => [$param['id']]));
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getNavbarsData(){
        $data = array(
            'formdata' => $this->getFormData()->getCount(array(0)),
            'messages' => $this->getMessages()->getForNavbar(),
            'actions' => $this->getLogs()->getLastActions(),
        );
        return json_encode($data);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getFormDataViewData($id){
        $this->getFormData()->update(array(
            'status' => 1,
            'id' => array($id)
        ));
        $data = $this->getFormData()->getRow($id);
        $data['json'] = $this->parseJSON($data['json']);
        return $data;
    }

    /**
     * @return bool
     */
    public function newEmailDelivery(){
        $data = $this->getRequest()->getPOSTValues();
        if($this->isString($data['title'], $data['content'])) {
            if($this->getSubscriptions()->newDelivery($data['title'], $data['content'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function setEditTemplate(){
        $this->sessionSetValue('edit-template', $this->getRequest()->getPOSTValues('edit-template'));
        return true;
    }

    /**
     * @param array $data
     * @return void
     */
    public function addOutData(&$data){
        $data['chat']['count'] = $this->getChat()->getCount();
        $data['chat']['message'] = $this->getChat()->get(1, 50, 'time');
        $data['chat']['last-id'] = $this->getChat()->getLastId();
        $data['side']['user'] = $this->getUsers()->getUser();
        $data['side']['users'] = $this->getUsers()->getAll(array(0));
    }
}