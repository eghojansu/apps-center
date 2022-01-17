<?php

Ekok\Cosiler\Template\directory(__DIR__ . '/../templates');
Ekok\Cosiler\storage(
    'fun',
    (new Ekok\Container\Box())->load(__DIR__ . '/../env.php', __DIR__ . '/../env.dev.php'),
    true,
);
