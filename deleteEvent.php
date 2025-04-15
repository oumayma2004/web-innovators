<?php
require_once '../config.php';
require_once '../Controller/eventController.php';




$db = config::getConnexion();
$controller = new EventController($db);

$event = null;

// Si on soumet l'ID pour charger les infos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['load_event'])) {
    $id_event = $_POST['id_event'];
    $event = $controller->getEventById($id_event); // Cette méthode doit exister dans ton EventController
    if (!$event) {
        echo "<p style='color:red;'>❌ Aucun événement trouvé avec l'ID $id_event</p>";
    }
}

// Si on confirme la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
    $id_event = $_POST['id_event'];
    $controller->deleteEvent($id_event); // Méthode à implémenter dans ton EventController
    echo "<p style='color:green;'>✅ Événement supprimé avec succès !</p>";
}
?>

<h2>Supprimer un Événement</h2>

<!-- Étape 1 : Rechercher par ID -->
<form method="POST" action="deleteEvent.php">
    <label>ID de l'événement :</label><br>
    <input type="number" name="id_event" required><br><br>
    <button type="submit" name="load_event">🔍 Charger l'événement</button>
</form>

<?php if ($event): ?>
    <!-- Étape 2 : Afficher et confirmer la suppression -->
    <form method="POST" action="deleteEvent.php" onsubmit="return confirm('⚠ Êtes-vous sûr de vouloir supprimer cet événement ?');">
        <input type="hidden" name="id_event" value="<?= htmlspecialchars($event['id_event']) ?>">

        <label>Event Name:</label><br>
        <input type="text" name="nom_e" value="<?= htmlspecialchars($event['nom_e']) ?>" readonly><br><br>

        <label>Date début:</label><br>
        <input type="date" name="date_de_e" value="<?= htmlspecialchars($event['date_de_e']) ?>" readonly><br><br>

        <label>Date fin:</label><br>
        <input type="date" name="date_f_e" value="<?= htmlspecialchars($event['date_f_e']) ?>" readonly><br><br>

        <label>Location:</label><br>
        <input type="text" name="lieu_e" value="<?= htmlspecialchars($event['lieu_e']) ?>" readonly><br><br>

        <label>Price:</label><br>
        <input type="number" name="prix_e" value="<?= htmlspecialchars($event['prix_e']) ?>" readonly><br><br>

        <label>Status:</label><br>
        <input type="text" name="etat_e" value="<?= htmlspecialchars($event['etat_e']) ?>" readonly><br><br>

        <label>Category:</label><br>
        <input type="text" name="category_e" value="<?= htmlspecialchars($event['category_e']) ?>" readonly><br><br>

        <label>Description:</label><br>
        <textarea name="desc_e" rows="4" readonly><?= htmlspecialchars($event['desc_e']) ?></textarea><br><br>

        <label>Image actuelle:</label><br>
        <?php if (!empty($event['image'])): ?>
            <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" width="100"><br>
        <?php else: ?>
            <em>Aucune image</em><br>
        <?php endif; ?><br>

        <button type="submit" name="delete_event" style="color: red;">❌ Supprimer cet événement</button>
    </form>
<?php
endif;
?>