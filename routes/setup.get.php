<?php

use function Ekok\Cosiler\Http\not_found;

!is_file($versionFile = $fun['tmp_dir'] . '/version.txt') || not_found();

$fun['title'] = 'SETUP';
?>
<div class="mx-auto my-5" style="max-width: 280px">
  <form method="post" autocomplete="off">
    <h1 class="h3 mb-3 fw-normal text-center">Run application setup</h1>

    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">RUN SETUP NOW</button>
  </form>
</div>
