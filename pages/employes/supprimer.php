<?php
include('../../connexion.php');

if (!isset($_GET['mat']) || !is_numeric($_GET['mat'])) {
    header("Location: liste.php");
    exit();
}

$id = intval($_GET['mat']);

try {
    $stmt = $connexion->prepare("DELETE FROM employes WHERE Matricule = :mat");
    $stmt->execute([':mat' => $id]);
} catch (Exception $e) {
    // Rediriger sans succès en cas d'erreur
}

header("Location: liste.php?succes=supprime");
exit();
?>
