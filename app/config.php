<?php

use Ekok\Container\Box;
use Ekok\Sql\Connection;
use Ekok\Utils\Str;
use Ekok\Validation\Validator;

Ekok\Cosiler\Template\directory(__DIR__ . '/../templates');
Ekok\Cosiler\storage(
    'fun',
    (new Box())
        ->load(__DIR__ . '/../env.php', __DIR__ . '/../env.dev.php')
        ->allSet(array(
            'project_dir' => Str::fixslashes(dirname(__DIR__)),
            'validator' => fn() => new Validator(),
        ))
        ->with(static fn (array $db, Box $box) => $box->set('db', new Connection($db['dsn'], $db['username'], $db['password'], $db['options'])), 'db_setup')
        ->with(function (Box $box) {
            is_dir($tmp = $box['project_dir'] . '/var') || mkdir($tmp, 0777, true);

            $box->allSet(array(
                'tmp_dir' => $tmp,
            ));
        }),
    true,
);
