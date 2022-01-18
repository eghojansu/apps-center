<?php

use function Ekok\Cosiler\Http\Response\redirect;
use function Ekok\Cosiler\Http\session_end;

session_end();
redirect('/');
