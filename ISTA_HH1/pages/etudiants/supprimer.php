<?php
include('../../connexion.php');

if (!isset($_GET['cin']) || empty(trim($_GET['cin']))) {
    header("Location: liste.php");
    exit();
}

$cin = htmlspecialchars(strip_tags(trim($_GET['cin'])));

try {
    $stmt = $connexion->prepare("DELETE FROM etudiants WHERE id = :cin");
    $stmt->execute([':cin' => $cin]);
} catch (Exception $e) {
    // En cas d'erreur, rediriger sans message de succès
}

header("Location: liste.php?succes=supprime");
exit();
?>
