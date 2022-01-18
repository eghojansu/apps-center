<?php

use Ekok\Cosiler\Http\HttpException;
use Ekok\Validation\ValidationException;

use function Ekok\Cosiler\Http\Response\back;
use function Ekok\Cosiler\Http\status;
use function Ekok\Cosiler\Template\load;
use function Ekok\Cosiler\Http\Response\start;

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
        $data['trace'] = array_filter(array_map('format_trace_frame', $error->getTrace()));
    }

    if ($error instanceof ValidationException) {
        errorCommit($data['message'], $error->result->getErrors());
        dataCommit($error->result->getData());
        back();
    }

    start($code);
    load('error', $data);
}
