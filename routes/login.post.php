<?php

use function Ekok\Cosiler\Http\Response\back;

guest();

$data = validate(array(
  'username' => 'trim|required',
  'password' => 'trim|required',
));
dataCommit($data);

$found = $fun['db']->selectOne('user', array('userid = ?', $data['username']));

if (!$found || !password_verify($data['password'], $found['password'])) {
  errorCommit('Invalid credentials');
  back();
}

if (!$found['active']) {
  errorCommit('Your account is inactive');
  back();
}

userCommit($found['userid']);
messageCommit('Welcome back');
back();
