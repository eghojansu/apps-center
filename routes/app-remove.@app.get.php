<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Response\redirect;

guard();

($app = $fun['db']->selectOne('apps', $filter = array('appsid = ? and deleted_at is null', $params['app']))) || not_found();

$user = user();

$fun['db']->update('apps', array(
  'deleted_by' => $user['userid'],
  'deleted_at' => date('Y-m-d H:i:s'),
), $filter);

messageCommit('Application has been removed');
redirect('/');
