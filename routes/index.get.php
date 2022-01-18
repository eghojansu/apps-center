<?php
$guest = is_guest();
$criteria = $guest ? array('active = "on" and deleted_at is null') : null;
$apps = $fun['db']->select('apps', $criteria, array('order' => 'priority desc, popularity desc'));
?>
<div class="py-5">
  <div class="apps-control row border-bottom pb-3 mb-3">
    <div class="col">
      <h1 class="text-danger h2"><?= $fun['app.name'] ?></h1>
    </div>
    <div class="col">
      <div class="btn-toolbar justify-content-end" role="toolbar" aria-label="Apps control">
        <div class="btn-group" role="group" aria-label="Apps control">
          <?php if (!$guest): ?>
            <a onclick="return confirm('Are you sure to LOGOUT?')"  href="<?= path('logout') ?>" class="btn btn-secondary">
              Logout <i class="bi-power"></i>
            </a>
          <?php endif ?>
          <a href="<?= path('app-create') ?>" class="btn btn-primary">
            Create Apps <i class="bi-cloud-plus"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <?= alert(message(), 'info') ?>
  <div class="card-group mt-5">
    <?php foreach ($apps as $app): ?>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?= e($app['name']) ?></h5>
          <?php if ($app['description']): ?><p class="card-text"><?= e($app['description']) ?></p><?php endif ?>
          <?php if (!$guest): ?>
            <ul>
              <li>Popularity: <?= $app['popularity'] ?></li>
            </ul>
          <?php endif ?>
        </div>
        <div class="card-footer d-flex justify-content-between">
          <div class="btn-group">
            <?php if ($app['deleted_at']): ?>
              <a onclick="return confirm('Are you sure RESTORE this app?')" href="<?= $guest ? '#' : path('app-restore/' . $app['appsid']) ?>" class="btn btn-info <?= $guest ? 'disabled' : null ?>">
                Restore <i class="bi-arrow-clockwise"></i>
              </a>
            <?php else: ?>
              <a onclick="return confirm('Are you sure DELETE this app?')" href="<?= $guest ? '#' : path('app-remove/' . $app['appsid']) ?>" class="btn btn-danger <?= $guest ? 'disabled' : null ?>">
                Remove <i class="bi-trash"></i>
              </a>
              <a href="<?= $guest ? '#' : path('app-edit/' . $app['appsid']) ?>" class="btn btn-warning <?= $guest ? 'disabled' : null ?>">
                Edit <i class="bi-pencil"></i>
              </a>
            <?php endif ?>
          </div>
          <a href="<?= $app['active'] === 'on' && !$app['deleted_at'] ? path('visit/' . $app['appsid']) : '#' ?>" class="btn btn-success <?= $app['active'] === 'on' && !$app['deleted_at'] ? null : 'disabled' ?>">
            Open <i class="bi-arrow-right-circle"></i>
          </a>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
