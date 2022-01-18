<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Response\redirect;

guard();

($app = $fun['db']->selectOne('apps', $filter = array('appsid = ? and deleted_at is null', $params['app']))) || not_found();

$data = validate(array(
  'name' => 'trim|required|max:32',
  'alias' => 'trim|required|max:16',
  'url' => 'trim|required|max:100',
  'active' => 'required|in:on,off',
  'description' => 'trim|nullable|max:100',
));
dataCommit($data);

$user = user();

$fun['db']->update('apps', $data + array(
  'updated_by' => $user['userid'],
  'updated_at' => date('Y-m-d H:i:s'),
), $filter);

messageCommit('Application has been saved');
redirect('/');
