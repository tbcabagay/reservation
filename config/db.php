<?php

$config = parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web.ini');

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . $config['host'] .';dbname=' . $config['dbname'],
    'username' => $config['username'],
    'password' => $config['password'],
    'charset' => 'utf8',
    'tablePrefix' => $config['tblprefix'],
];
