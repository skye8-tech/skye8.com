<?php

define('APP', TRUE);
define('PATH', dirname(__FILE__));

if(phpversion() < '5.4'){
    exit('For the script to work, version php 5.4 and later is required.');
}

$start = microtime(true);

require PATH.'/modules/Site.php';

function __autoload($class) {
    require PATH.'/classes/'.$class.'.php';
}

$site = new Site();

if($site->isOffline()){
    echo $site->getTemplate()->compileBloc('main/offline', null);
    return;
}

$site->sessionStart();
$site->setVisit();
$request = $site->getRequest();

switch ($request->getRoutes(1)) {
    case '':
        $out = $site->home(1);
        break;
    case 'api':
        $out = $site->getAPIData();
        break;
    case 'rss':
        $out = $site->getRSS();
        break;
    case 'user':
        $out = $site->getUserPage();
        break;
    case 'login':
        $out = $site->login();
        break;
    case 'logout':
        $out = $site->logout();
        break;
    case 'search':
        $out = $site->getSearchPage();
        break;
    case 'register':
        $out = $site->register();
        break;
    case 'robots.txt':
        $out = $site->getRobots();
        break;
    case 'sitemap.xml':
        $out = $site->getSiteMap();
        break;
    case 'lostpassword':
        $out = $site->getLostPasswordPage();
        break;
    case 'unsubscribe':
        echo $site->unsubscribe();
        break;
    case 'captcha':
        getCaptcha();
        break;
    case 'ajax':
        if ($request->isPOST()) {
            switch ($request->getPOSTValues('action')) {
                case 'login':
                    echo $site->getUsers()->login($request->getPOSTValues('login'), $request->getPOSTValues('password')) ? 'ok' : '';
                    break;
                case 'search':
                    echo $site->ajaxSearch();
                    break;
                case 'add-user':
                    echo $site->addUser();
                    break;
                case 'update-sort':
                    echo $site->updateSort();
                    break;
                case 'add-content':
                    echo $site->addContent();
                    break;
                case 'add-comment':
                    echo $site->addComment();
                    break;
                case 'update-user':
                    echo $site->updateUser();
                    break;
                case 'update-rating':
                    echo $site->updateRating();
                    break;
                case 'check-captcha':
                    echo $site->checkCaptcha();
                    break;
                case 'lost-password':
                    echo $site->addLostPassword();
                    break;
                case 'update-bookmark':
                    echo $site->updateBookmark();
                    break;
                case 'get-bookmark-count':
                    echo $site->getBookmarkCount();
                    break;
                case 'check-free-login':
                    echo $site->checkFreeLogin();
                    break;
                case 'check-free-email':
                    echo $site->checkFreeEmail();
                    break;
                case 'check-free-url':
                    echo $site->checkFreeURL();
                    break;
                case 'update-password':
                    echo $site->updateUserPassword();
                    break;
                case 'add-delivery-email':
                    echo $site->addDeliveryEmail();
                    break;
                case 'add-formdata':
                    echo $site->addFormData();
                    break;
            }
        }
        break;
    default:
        $out = $site->getPage();
}

if ($site->isArray($out)) {
    $site->getTemplate()->main('main/main', $out['main']);
    $site->getTemplate()->set('{title}', $out['title']);
    $site->getTemplate()->set('{keywords}', $out['keywords']);
    $site->getTemplate()->set('{description}', $out['description']);
    $site->getTemplate()->set('{http-host}', $request->getHTTPHost());
    $site->getTemplate()->bloc('{links}', 'navbar/links', $out['navbar']);
    $site->getTemplate()->bloc('{sidebar}', 'main/sidebar', $out['sidebar']);
    $site->getTemplate()->bloc('{content}', $out['template'], $out['content']);
    $site->getTemplate()->set('{runtime}', microtime(true) - $start);
    $site->getTemplate()->set('{memory}', sizeConvert(memory_get_peak_usage()));
    $site->getTemplate()->set('{path}', '/public/templates/'. $site->getSettings()->settings['template']);
    $site->getTemplate()->out();
    $site->getLogs()->updateStat();
}