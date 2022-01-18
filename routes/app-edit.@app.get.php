<?php

use function Ekok\Cosiler\Http\not_found;

guard();

($app = $fun['db']->selectOne('apps', array('appsid = ? and deleted_at is null', $params['app']))) || not_found();

$data = data();
$error = error();

$fun['title'] = 'Edit App';
?>
<div class="mx-auto my-5" style="max-width: 500px">
  <form method="post" autocomplete="off">
    <h1 class="h3 mb-3 fw-normal text-center">Edit App : <?= e($app['appsid']) ?></h1>
    <?= alert($error['message'] ?? null, 'danger', false) ?>
    <div class="form-floating mt-3">
      <input type="text" name="name" class="form-control <?= isset($error['errors']['name']) ? 'is-invalid' : null ?>" value="<?= e($data['name'] ?? $app['name'] ?? null) ?>" id="inputName" placeholder="Application Name">
      <label for="inputName">Application Name</label>
      <?php if (isset($error['errors']['name'])): ?><div class="invalid-feedback"><?= $error['errors']['name'] ?></div><?php endif ?>
    </div>
    <div class="form-floating mt-3">
      <input type="text" name="alias" class="form-control <?= isset($error['errors']['alias']) ? 'is-invalid' : null ?>" value="<?= e($data['alias'] ?? $app['alias'] ?? null) ?>" id="inputAlias" placeholder="Alias">
      <label for="inputAlias">Alias</label>
      <?php if (isset($error['errors']['alias'])): ?><div class="invalid-feedback"><?= $error['errors']['alias'] ?></div><?php endif ?>
    </div>
    <div class="form-floating mt-3">
      <input type="text" name="url" class="form-control <?= isset($error['errors']['url']) ? 'is-invalid' : null ?>" value="<?= e($data['url'] ?? $app['url'] ?? null) ?>" id="inputUrl" placeholder="URL">
      <label for="inputUrl">URL</label>
      <?php if (isset($error['errors']['url'])): ?><div class="invalid-feedback"><?= $error['errors']['url'] ?></div><?php endif ?>
    </div>
    <div class="mt-3">
      <div class="form-check">
        <input class="form-check-input <?= isset($error['errors']['active']) ? 'is-invalid' : null ?>" type="radio" name="active" id="inputActive" value="on">
        <label class="form-check-label" for="inputActive">Active</label>
      </div>
      <div class="form-check">
        <input class="form-check-input <?= isset($error['errors']['active']) ? 'is-invalid' : null ?>" type="radio" name="active" id="inputInactive" value="off">
        <label class="form-check-label" for="inputInactive">Inactive</label>
      </div>
      <?php if (isset($error['errors']['active'])): ?><div class="invalid-feedback d-block"><?= $error['errors']['active'] ?></div><?php endif ?>
    </div>
    <div class="form-floating mt-3">
      <textarea name="description" class="form-control <?= isset($error['errors']['description']) ? 'is-invalid' : null ?>" id="inputDescription" placeholder="Description" style="height: 100px"><?= e($data['description'] ?? $app['description'] ?? null) ?></textarea>
      <label for="inputDescription">Description</label>
      <?php if (isset($error['errors']['description'])): ?><div class="invalid-feedback"><?= $error['errors']['description'] ?></div><?php endif ?>
    </div>

    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Save</button>
    <a href="<?= path('/') ?>" class="w-100 btn btn-secondary mt-2">Cancel</a>
    <p class="mt-5 mb-3 text-muted text-center">&copy; <?= $fun['app.alias'] ?> &ndash; <?= $fun['app.year'] ?></p>
  </form>
</div>
