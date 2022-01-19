<?php
$guest = is_guest();
$user = !$guest;
$criteria = $guest ? array('active = "on" and deleted_at is null') : null;
$apps = $fun['db']->select('apps', $criteria, array('orders' => array('priority' => 'desc', 'popularity' => 'desc')));
$max = count($apps) - 1;
?>
<div class="py-5">
  <div class="apps-control row border-bottom pb-3 mb-3">
    <div class="col">
      <h1 class="text-danger h2"><?= $fun['app.name'] ?></h1>
    </div>
    <div class="col">
      <div class="btn-toolbar justify-content-end" role="toolbar" aria-label="Apps control">
        <div class="btn-group" role="group" aria-label="Apps control">
          <?php if ($user): ?>
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
        </div>
        <div class="card-footer d-flex justify-content-between">
          <div class="btn-toolbar" role="toolbar" aria-label="Left toolbar">
            <?php if ($user): ?>
              <div class="btn-group" role="group" aria-label="Crud control">
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
            <?php endif ?>
            <?php if ($user && !$app['deleted_at']): ?>
              <div class="btn-group ms-2" role="group" aria-label="Priority control">
                <a href="<?= 0 == $app['priority'] ? '#' : path('app-priority/' . $app['appsid'] . '?dir=down') ?>" class="btn btn-secondary <?= 0 == $app['priority'] ? 'disabled' : null ?>">
                  <i class="bi-arrow-down-circle"></i>
                </a>
                <a href="#" class="btn btn-secondary disabled">
                  <?= $app['priority'] ?>
                </a>
                <a href="<?= path('app-priority/' . $app['appsid'] . '?dir=up') ?>" class="btn btn-secondary">
                  <i class="bi-arrow-up-circle"></i>
                </a>
              </div>
            <?php endif ?>
          </div>
          <div class="btn-toolbar" role="toolbar" aria-label="Right toolbar">
            <div class="btn-group" role="group" aria-label="Access control">
              <a href="#" class="btn btn-info disabled">
                <?= $app['popularity'] ?> <i class="bi-star"></i>
              </a>
              <a href="<?= $app['active'] === 'on' && !$app['deleted_at'] ? path('visit/' . $app['appsid']) : '#' ?>" class="btn btn-success <?= $app['active'] === 'on' && !$app['deleted_at'] ? null : 'disabled' ?>">
                Open <i class="bi-arrow-right-circle"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
