<?php

use function Ekok\Cosiler\Http\path as HttpPath;
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

function format_frame(array $frame) {
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
