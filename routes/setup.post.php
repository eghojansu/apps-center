<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Response\redirect;

!is_file($versionFile = $fun['tmp_dir'] . '/version.txt') || not_found();

$fun['db']->update('user', array('active' => 'on', 'password' => password_hash('admin123', PASSWORD_BCRYPT)), array('userid = "admin"'));

file_put_contents($versionFile, 'Installed at ' . date('Y-m-d H:i:s'));
redirect('/');
