<?php
require_once __DIR__ . '/../config.php';

require_once __DIR__ . '/../Controller/eventController.php';

$db=config::getConnexion();
$controller = new EventController($db);
$events = $controller->showDashboard();
?>

<h2>Dashboard Events</h2>
<?php foreach ($events as $event): ?>
    <div>
        <strong><?= $event['nom_e'] ?></strong> - <?= $event['date_e'] ?> - <?= $event['lieu_e'] ?>
    </div>
<?php endforeach; ?>
