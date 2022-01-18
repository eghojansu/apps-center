<?php

use function Ekok\Cosiler\Http\Response\back;
use function Ekok\Cosiler\Http\Response\redirect;

guard();

$data = validate(array(
  'appsid' => 'trim|required|max:8',
  'name' => 'trim|required|max:32',
  'alias' => 'trim|required|max:16',
  'url' => 'trim|required|max:100',
  'active' => 'required|in:on,off',
  'description' => 'trim|nullable|max:100',
));
dataCommit($data);

$found = $fun['db']->selectOne('apps', array('appsid = ?', $data['appsid']));
$user = user();

if ($found) {
  errorCommit('Application exists!');
  back();
}

$fun['db']->insert('apps', $data + array(
  'created_by' => $user['userid'],
  'updated_by' => $user['userid'],
  'created_at' => date('Y-m-d H:i:s'),
  'updated_at' => date('Y-m-d H:i:s'),
));

messageCommit('Application has been saved');
redirect('/');
