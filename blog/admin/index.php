<?php

define('APP', true);
define('PATH', dirname(__DIR__));

if(phpversion() < '5.4'){
    exit('For the script to work, version php 5.4 and later is required.');
}

include PATH.'/modules/Admin.php';

function __autoload($class){
    require PATH. '/classes/' . $class . '.php';
}

$admin = new Admin();
$admin->sessionStart();
$request = $admin->getRequest();
$user = $admin->getUsers()->getUser();

Registry::set('user-id', $user['id']);

if(empty($user) || $user['role'] != 0 || $user['status'] == 0) {
    if($request->isPOST()) {
        if($admin->getUsers()->login($request->getPOSTValues('login'), $request->getPOSTValues('password'))) {
            header("Location: /admin");
            exit();
        } else {
            header("Location: /admin?fail=yes");
            exit();
        }
    } else {
        echo $admin->getTemplate()->compileBloc('login', null);
    }
    return;
}

switch($request->getRoutes(2)) {
    case '':
        header("Location: /admin/report");
        break;
    case 'chat':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'send-message':
                    echo $admin->sendChatMessage();
                    break;
                case 'get-message':
                    echo $admin->getChatLastMessage();
                    break;
                case 'get-last':
                    echo $admin->getChatLastId();
                    break;
            }
        }else{
            $out = $admin->managementChat();
        }
        break;
    case 'tags':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/tag', null);
                    break;
                case 'get-form-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/tag', $admin->getTagEditData());
                    break;
                case 'check-free-name':
                    echo $admin->checkFreeTagName();
                    break;
                case 'update-position':
                    echo $admin->updateTagsPosition() ? 'ok' : '';
                    break;
                case 'add':
                    echo $admin->getTags()->add($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'update':
                    echo $admin->getTags()->update($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->getTags()->delete($request->getPOSTValues('id')) ? 'ok' : '';
                    break;
            }
        } else {
            $out = $admin->managementTags();
        }
        break;
        break;
    case 'users':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/user', null);
                    break;
                case 'get-form-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/user', $admin->getUserEditData($request->getPOSTValues('id')));
                    break;
                case 'check-free-login':
                    echo $admin->checkFreeLogin();
                    break;
                case 'check-free-email':
                    echo $admin->checkFreeEmail();
                    break;
                case 'check-super-password':
                    echo $admin->checkSuperPassword();
                    break;
                case 'clear-log':
                    echo $admin->clearLog() ? 'ok' : '';
                    break;
                case 'add':
                    echo $admin->getUsers()->add($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'update':
                    echo $admin->getUsers()->update($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->getUsers()->delete($request->getPOSTValues('id')) ? 'ok' : '';
                    break;
            }
        }else{
            $out = $admin->managementUsers();
        }
        break;
    case 'pages':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-page-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/page', $admin->getPageAddData());
                    break;
                case 'get-form-gallery-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/gallery', $admin->getPageEditData());
                    break;
                case 'get-form-not-found-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/404', $admin->getPageEditData());
                    break;
                case 'get-form-home-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/home', $admin->getPageEditData());
                    break;
                case 'get-form-tag-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/tag', $admin->getPageEditData());
                    break;
                case 'get-form-add-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/add', $admin->getPageEditData());
                    break;
                case 'get-form-bookmark-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/bookmark', $admin->getPageEditData());
                    break;
                case 'get-form-category-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/category', $admin->getPageEditData());
                    break;
                case 'get-form-page-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/page', $admin->getPageEditData());
                    break;
                case 'get-form-gallery-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/pages/gallery', $admin->getPageEditData());
                    break;
                case 'check-free-url':
                    echo $admin->checkFreeURL();
                    break;
                case 'add':
                    echo $admin->addPage() ? 'ok' : '';
                    break;
                case 'update':
                    echo $admin->getPages()->update($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'update-position':
                    echo $admin->getPages()->updatePosition() ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->getPages()->delete($request->getPOSTValues('id')) ? 'ok' : '';
                    break;
            }
        } else {
            if($admin->getRequest()->getRoutes(3) == 'get-json'){
                echo $admin->getPages()->getJSON();
            }else{
                $out = $admin->managementPages();
            }
        }
        break;
    case 'images':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'multiple-upload':
                    echo json_encode($admin->getImages()->multipleUpload());
                    break;
                case 'upload':
                    echo json_encode($admin->getImages()->upload());
                    break;
                case 'delete':
                    echo $admin->getImages()->delete($request->getPOSTValues('name')) ? 'ok' : '';
                    break;
            }
        }
        break;
    case 'navbar':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-data':
                    echo $admin->getNavbarsData();
                    break;
            }
        }
        break;
        break;
    case 'report':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-main-chart-data-json':
                    echo $admin->getReport()->getMainChartDateJSON($user['id']);
                    break;
                case 'get-main-storage-data-json':
                    echo $admin->getReport()->getMainStorageDateJSON();
                    break;
            }
        } else {
            $out = $admin->managementReport();
        }
        break;
    case 'logout':
        $admin->getUsers()->logout();
        header("Location: /");
        exit();
        break;
    case 'search':
        $out = $admin->managementSearch();
        break;
    case 'content':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/content', $admin->getContentAddData(), false);
                    break;
                case 'get-form-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/content', $admin->getContentEditData(), false);
                    break;
                case 'check-free-url':
                    echo $admin->checkFreeURL();
                    break;
                case 'update-position':
                    echo $admin->updateContentPosition() ? 'ok' : '';
                    break;
                case 'add':
                    echo $admin->getContent()->add($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'update':
                    echo $admin->getContent()->update($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->getContent()->delete($request->getPOSTValues('id')) ? 'ok' : '';
                    break;
            }
        } else {
            $out = $admin->managementContent();
        }
        break;
    case 'category':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/category', $admin->getCategoryAddData());
                    break;
                case 'get-form-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/category', $admin->getCategoryEditData());
                    break;
                case 'check-free-url':
                    echo $admin->checkFreeURL();
                    break;
                case 'add':
                    echo $admin->getCategory()->add($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'update':
                    echo $admin->getCategory()->update($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'update-position':
                    echo $admin->getCategory()->updatePosition() ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->getCategory()->delete($request->getPOSTValues('id')) ? 'ok' : '';
                    break;
            }
        } else {
            if($admin->getRequest()->getRoutes(3) == 'get-json'){
                echo $admin->getCategory()->getJSON();
            }else{
                $out = $admin->managementCategory();
            }
        }
        break;
    case 'formdata':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-view-data':
                    echo $admin->getTemplate()->compileBloc('views/formdata', $admin->getFormDataViewData($request->getPOSTValues('id')));
                    break;
                case 'update-position':
                    echo $admin->updateFormDataPosition() ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->getFormData()->delete($request->getPOSTValues('id')) ? 'ok' : '';
                    break;
            }
        } else {
            $out = $admin->managementFormData();
        }
        break;
    case 'comments':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-edit':
                    echo $admin->getTemplate()->compileBloc('forms/edit/comment', $admin->getCommentEditData());
                    break;
                case 'get-view-location':
                    echo $admin->getTemplate()->compileBloc('views/location', $admin->getCommentsLocationData());
                    break;
                case 'update-position':
                    echo $admin->updateCommentsPosition() ? 'ok' : '';
                    break;
                case 'add':
                    echo $admin->getComments()->add($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'update':
                    echo $admin->getComments()->update($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->getComments()->delete($request->getPOSTValues('id')) ? 'ok' : '';
                    break;
            }
        } else {
            $out = $admin->managementComments();
        }
        break;
    case 'messages':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-add':
                    echo $admin->getTemplate()->compileBloc('forms/add/message', $admin->getMessageAddData());
                    break;
                case 'get-view':
                    echo $admin->getTemplate()->compileBloc('views/message', $admin->getMessageViewData());
                    break;
                case 'update-position':
                    echo $admin->updateMessagePosition() ? 'ok' : '';
                    break;
                case 'add':
                    echo $admin->addMessage() ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->deleteMessage() ? 'ok' : '';
                    break;
            }
        } else {
            $out = $admin->managementMessages();
        }
        break;
    case 'settings':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'update':
                    echo $admin->updateSettings() ? 'ok' : '';
                    break;
                case 'clear-cache':
                    echo $admin->clearCache() ? 'ok' : '';
                    break;
                case 'clear-images':
                    echo $admin->clearImages() ? 'ok' : '';
                    break;
            }
        } else {
            $out = $admin->managementSettings();
        }
        break;
    case 'templates':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-content':
                    echo $admin->getFileEditor()->getContent($request->getPOSTValues('file'));
                    break;
                case 'set-template':
                    echo $admin->getSettings()->updateSettings($request->getPOSTValues()) ? 'ok' : '';
                    break;
                case 'set-edit-template':
                    echo $admin->setEditTemplate() ? 'ok' : '';
                    break;
                case 'save':
                    echo $admin->getFileEditor()->save($request->getPOSTValues('file'), $request->getPOSTValues('content')) ? 'ok' : '';
                    break;
            }
        } else {
            if($request->getRoutes(3) == 'get-list'){
                echo $admin->getFileEditor()->getFilesHTML($request->getPOSTValues('dir'));
            }else{
                $out = $admin->managementTemplates();
            }
        }
        break;
    case 'statistics':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-stat':
                    echo json_encode(array_reverse($admin->getLogs()->getStat(10)));
                    break;
                case 'get-log':
                    echo file_get_contents($admin->getRootDir() . '/data/log');
                    break;
            }
        } else {
            $out = $admin->managementStatistics();
        }
        break;
    case 'summernote':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-filemanager-html':
                    echo $admin->getTemplate()->compileBloc('summernote/filemanager', $admin->getSummernote()->getImagesArray());
                    break;
                case 'get-editor-html':
                    echo $admin->getTemplate()->compileBloc('summernote/editor', null);
                    break;
                case 'get-components-html':
                    echo $admin->getTemplate()->compileBloc('summernote/components', array('icons' => $admin->getSummernote()->getIconClassNameArray()));
                    break;
                case 'images-upload':
                    echo json_encode($admin->getSummernote()->uploadImages());
                    break;
                case 'images-delete':
                    echo $admin->getSummernote()->deleteImages($request->getPOSTValues('name')) ? 'ok' : '';
                    break;
            }
        }
        break;
    case 'subscriptions':
        if($request->getRoutes(3) == 'ajax' && $request->isPOST()) {
            switch($request->getPOSTValues('action')) {
                case 'get-form-new':
                    echo $admin->getTemplate()->compileBloc('forms/add/subscriptions', null);
                    break;
                case 'delivery':
                    echo $admin->newEmailDelivery() ? 'ok' : '';
                    break;
                case 'update-position':
                    echo $admin->updateSubscriptionsPosition() ? 'ok' : '';
                    break;
                case 'update':
                    echo $admin->updateSubscriptions() ? 'ok' : '';
                    break;
                case 'delete':
                    echo $admin->deleteSubscriptions() ? 'ok' : '';
                    break;
            }
        } else {
            $out = $admin->managementSubscriptions();
        }
        break;
    case 'check-login':
        echo 'ok';
        break;
    default:
        header("Location: /admin");
        exit();
}

if($admin->isArray($out)) {
    $admin->addOutData($out);
    $admin->getTemplate()->main('main', $out);
    $admin->getTemplate()->set('{path}', $out['path']);
    $admin->getTemplate()->set('{title}', $out['title']);
    $admin->getTemplate()->bloc('{tools}', 'tools', $out['side']);
    $admin->getTemplate()->bloc('{sidebar-left}', 'sidebar/left', $out['side']);
    $admin->getTemplate()->bloc('{sidebar-right}', 'sidebar/right', $out['side']);
    $admin->getTemplate()->bloc('{content}', $out['template'], $out['data'], false);
    $admin->getTemplate()->out();
}