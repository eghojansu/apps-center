<?php

use function Ekok\Cosiler\Http\not_found;
use function Ekok\Cosiler\Http\Request\ip_address;
use function Ekok\Cosiler\Http\Request\user_agent;

define('REDIRECT_TIMEOUT', 3);

($app = $fun['db']->selectOne('apps', $criteria = array('appsid = ? and deleted_at is null', $params['app']))) || not_found();

$user = user();
$fun['db']->insert('apps_hit', array(
  'appsid' => $app['appsid'],
  'visitor_ip' => ip_address(),
  'visitor_agent' => user_agent(),
  'visited_at' => date('Y-m-d H:i:s'),
  'created_at' => date('Y-m-d H:i:s'),
  'updated_at' => date('Y-m-d H:i:s'),
  'created_by' => $user['userid'] ?? null,
  'updated_by' => $user['userid'] ?? null,
));
$fun['db']->update('apps', array(
  'popularity' => $app['popularity'] + 1,
  'updated_at' => date('Y-m-d H:i:s'),
), $criteria);

$fun['title'] = 'Visit: ' . $app['name'];
?>
<div class="text-center py-5">
  <p>You will be redirected to <a id="timer-target" href="<?= $app['url'] ?>"><?= $app['name'] ?></a> in <span id="timer"><?= REDIRECT_TIMEOUT ?></span> seconds</p>
  <p>Click link below or copy and paste in your browser address bar:</p>
  <p><a class="fs-1" href="<?= $app['url'] ?>"><?= $app['url'] ?></a></p>
  <p class="mt-5 mb-3 text-muted text-center">&copy; <?= $fun['app.alias'] ?> &ndash; <?= $fun['app.year'] ?></p>
</div>

<script>
  (() => {
    let timeout = <?= REDIRECT_TIMEOUT ?>, timerEl = document.getElementById('timer')

    const timerId = setInterval(() => {
      timerEl.innerHTML = --timeout

      if (timeout <= 0) {
        const targetEl = document.getElementById('timer-target')

        clearInterval(timerId)
        window.location.href = targetEl.href
      }
    }, 1000)
  })()
</script>
