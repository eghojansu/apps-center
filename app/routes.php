<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Response\json;
use function Ekok\Cosiler\Http\Response\start;
use function Ekok\Cosiler\Route\did_match;
use function Ekok\Cosiler\Route\files;
use function Ekok\Cosiler\Route\globals_add;
use function Ekok\Cosiler\storage;
use function Ekok\Cosiler\Template\load;

globals_add('fun', $fun = storage());
ob_start();
$result = files(__DIR__ . '/../routes');
$output = ob_get_clean();

if (is_array($result) || $result instanceof JsonSerializable) {
    json($result);
} elseif (did_match()) {
    start(200);
    load('main', compact('output', 'fun'));
} else {
    not_found('This page is not exists');
}
