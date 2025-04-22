<?php
require_once './config.php';
require_once './Controller/eventController.php';

$db=config::getConnexion();
$controller = new EventController($db);
$events = $controller->showFrontOffice();
?>

<h2>Upcoming Events</h2>
<?php foreach ($events as $event): ?>
    <div>
        <strong><?= $event['nom_e'] ?></strong> - <?= $event['date_e'] ?> - <?= $event['lieu_e'] ?>
    </div>
<?php endforeach; ?>
