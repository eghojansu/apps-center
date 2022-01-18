<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Response\redirect;

guard();

($app = $fun['db']->selectOne('apps', $filter = array('appsid = ? and deleted_at is not null', $params['app']))) || not_found();

$user = user();

$fun['db']->update('apps', array(
  'updated_by' => $user['userid'],
  'updated_at' => date('Y-m-d H:i:s'),
  'deleted_by' => null,
  'deleted_at' => null,
), $filter);

messageCommit('Application has been restored');
redirect('/');
