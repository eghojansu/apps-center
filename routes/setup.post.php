<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Response\redirect;

!is_file($versionFile = $fun['tmp_dir'] . '/version.txt') || not_found();

/** @var PDO */
$pdo = $fun['db']->getPdo();

foreach (glob($fun['project_dir'] . '/databases/*.sql') as $file) {
  $pdo->exec(file_get_contents($file));
}

$fun['db']->update('user', array('active' => 'on', 'password' => password_hash('admin123', PASSWORD_BCRYPT)), array('userid = "admin"'));

file_put_contents($versionFile, 'Installed at ' . date('Y-m-d H:i:s'));
redirect('/');
