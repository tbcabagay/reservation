<?php

$config = parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web.ini');

return [
    'adminEmail' => $config['mailer_username'],
    'rememberMeDuration' => 3600*24*30,
    'appName' => 'Sanctuario de San Pablo Resort and Spa',
];
