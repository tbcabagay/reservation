<?php

$config = parse_ini_file('/home/tbcabagay/sql/reservation.ini');

return [
    'adminEmail' => $config['mailer_username'],
    'rememberMeDuration' => 3600*24*30,
    'appName' => 'Sanctuario de San Pablo Resort and Spa',
];
