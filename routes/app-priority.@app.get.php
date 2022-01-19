<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Request\get;
use function Ekok\Cosiler\Http\Response\redirect;

guard();

(($app = $fun['db']->selectOne('apps', $filter = array('appsid = ? and deleted_at is null', $params['app']))) && in_array($dir = get('dir'), array('up', 'down'))) || not_found();

$user = user();

$fun['db']->update('apps', array(
  'priority' => max(0, $app['priority'] + ('up' === $dir ? 1 : -1)),
  'updated_by' => $user['userid'],
  'updated_at' => date('Y-m-d H:i:s'),
), $filter);

messageCommit('Application has been updated');
redirect('/');
