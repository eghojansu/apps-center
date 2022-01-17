<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/bootstrap-icons.css') ?>" rel="stylesheet">
    <title><?= $page_title ?? ($title ?? 'Home') . ' - ' . $fun['app.name'] ?></title>
  </head>
  <body>
    <?= $output ?>
  </body>
</html>
