<?php

define('APP', true);
define('PATH', dirname(__DIR__));

if(phpversion() < '5.4'){
    exit('For the script to work, version php 5.4 and later is required.');
}

require PATH . '/install/classes/Installer.php';

function __autoload($class) {
    require PATH . '/classes/' . $class . '.php';
}

Registry::set('sql-file', PATH . '/install/data/db');
Registry::set('db-config', PATH . '/config/db-config.php');
Registry::set('license-file', PATH . '/install/data/license');
Registry::set('templates-dir', PATH . '/install/templates/');
Registry::set('templates-ext', '.tpl');


$installer = new Installer();
$installer->sessionStart();

$routes = $installer->getRoute();

if ($installer->checkInstalled()) {
    echo 'The script is already installed! Delete directory /install';
    return;
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    switch ($installer->sessionGetValue('step')) {
        case null:
            $out = $installer->licensePage();
            break;
        case 'system':
            $out = $installer->systemPage();
            break;
        case 'files':
            $out = $installer->filesPage();
            break;
        case 'config':
            $out = $installer->configurationPage();
            break;
        case 'user':
            break;
        case 'success':
            $installer->getSettings()->updateSettings(array('installed' => 1));
            $out = $installer->successPage();
            break;
    }
}

switch ($routes[2]) {
    case 'ajax':
        if ($_SERVER['REQUEST_METHOD'] == "POST" && is_string($_POST['action'])) {
            switch ($_POST['action']) {
                case 'accept-license':
                    $installer->sessionSetValue('step', 'system');
                    echo 'ok';
                    break;
                case 'accept-system':
                    $installer->sessionSetValue('step', 'files');
                    echo 'ok';
                    break;
                case 'accept-files':
                    $installer->sessionSetValue('step', 'config');
                    echo 'ok';
                    break;
                case 'check-license':
                    echo $installer->checkLicenseKey($_POST['key']) ? 'ok' : '';
                    break;
                case 'check-db-config':
                    if ($installer->notEmpty($_POST['db-host'], $_POST['db-user'], $_POST['db-name'])) {
                        $connect = mysqli_connect(trim($_POST['db-host']), trim($_POST['db-user']), trim($_POST['db-pass']), trim($_POST['db-name']));
                        if (mysqli_ping($connect)) {
                            echo 'ok';
                        }
                        mysqli_close($connect);
                    } else {
                        echo 'error';
                    }
                    break;
                case 'install':

                    $installer->updateConfig(array(
                        'host' => trim($_POST['db-host']),
                        'user' => trim($_POST['db-user']),
                        'pass' => trim($_POST['db-pass']),
                        'name' => trim($_POST['db-name'])
                    ));

                    $db = new DataBase();

                    $tables = $db->getCol("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = ?s AND TABLE_SCHEMA = ?s", 'BASE TABLE', $_POST['db-name']);

                    foreach ($tables as $t){
                        $db->query("DROP TABLE ?n", $t);
                    }

                    $sql = explode('###', file_get_contents(Registry::get('sql-file')));

                    foreach ($sql as $t) {
                        $db->query($t);
                    }

                    $param = array_map('trim', $_POST);

                    if ($db->query("INSERT INTO users (status, role, login, name, email, password) VALUES (?i, ?i, ?s, ?s, ?s, ?s)", 1, 0, $param['login'], $param['name'], $param['email'], md5(md5($param['password'])))) {
                        $installer->getSettings()->updateSettings($_POST);
                        $installer->sessionSetValue('step', 'success');
                        echo 'ok';
                    }
                    break;
            }
        }
        break;
}

if (is_array($out)) {
    $installer->getTemplate()->main('main');
    $installer->getTemplate()->set('{title}', $out['title']);
    $installer->getTemplate()->bloc('{content}', $out['template'], $out['data'], false);
    $installer->getTemplate()->out();
}