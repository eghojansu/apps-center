<?php

use Ekok\Cosiler\Http\HttpException;

use function Ekok\Cosiler\Http\Response\start;
use function Ekok\Cosiler\Http\status;
use function Ekok\Cosiler\Template\load;

try {
    handleError($error);
} catch (Throwable $e) {
    handleError($e);
}

function handleError(Throwable $error) {
    $dev = env_is('dev');
    $code = $error instanceof HttpException ? $error->statusCode : 500;
    $data = compact('dev', 'code') + array(
        'text' => status($code),
        'message' => $error->getMessage(),
    );

    if ($dev) {
        $data['trace'] = array_filter(array_map('format_frame', $error->getTrace()));
    }

    start($code);
    load('error', $data);
}
