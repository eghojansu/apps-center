<?php

use function Ekok\Cosiler\Http\flash;
use function Ekok\Cosiler\Http\path as HttpPath;
use function Ekok\Cosiler\Http\Request\post;
use function Ekok\Cosiler\Http\Response\redirect;
use function Ekok\Cosiler\Http\session as HttpSession;
use function Ekok\Cosiler\storage as CosilerStorage;

function storage() {
    return CosilerStorage();
}

function env_is(string ...$envs) {
    return in_array(strtolower(storage()['env'] ?? 'prod'), array_map('strtolower', $envs));
}

function asset(string $path) {
    return HttpPath('/assets/' . ltrim($path, '/'));
}

function path(string $path = null) {
    return HttpPath($path);
}

function format_trace_frame(array $frame) {
    if (false !== strpos($frame['function'], '{closure}')) {
        return '';
    }

    $line = $frame['file'];

    if (isset($frame['line'])) {
        $line .= ':' . $frame['line'];
    }

    $line .= ' ';

    if (isset($frame['class'])) {
        $line .= $frame['line'] . '->';
    }

    $line .= $frame['function'];

    return $line;
}

function session(string $key = null, $value = null) {
    return HttpSession($key, $value);
}

function is_guest() {
    return !session('user');
}

function user() {
    $id = session('user');

    return $id ? storage()['db']->selectOne('user', array('userid = ?', $id)) : null;
}

function userCommit($id) {
    session('user', $id);
}

function guard(string $target = null) {
    if (is_guest()) {
        redirect($target ?? 'login');
    }
}

function guest(string $target = null) {
    is_guest() || redirect($target ?? '/');
}

function message() {
    return flash('message');
}

function messageCommit(string $message) {
    session('message', $message);
}

function error() {
    return flash('error');
}

function errorCommit(string $message, array $errors = null) {
    session('error', array(
        'message' => $message,
        'errors' => array_map(fn(array $group) => implode(', ', $group), $errors ?? array()),
    ));
}

function data() {
    return flash('data');
}

function dataCommit(array $data = null) {
    session('data', $data ?? array());
}

function validate(array $rules, array $data = null) {
    return storage()['validator']->validate($rules, $data ?? post())->getData();
}
