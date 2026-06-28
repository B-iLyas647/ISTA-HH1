<?php
session_start();
$activePage = 'employes_liste';
$pageTitle  = 'Liste des employés — ISTA HH1';
$rootPath   = '../../';

include('../../connexion.php');

$succes = $_GET['succes'] ?? null;

try {
    $donnees = $connexion->query("SELECT * FROM employes ORDER BY Nom ASC");
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

include('../../nav.php');
?>

<div class="page-top">
    <div class="breadcrumb">Employés</div>
    <h1>Liste des employés</h1>
    <div class="accent-bar-p"></div>
</div>

<?php if ($succes === 'ajoute'): ?>
    <div class="alert alert-success">Employé ajouté avec succès.</div>
<?php elseif ($succes === 'modifie'): ?>
    <div class="alert alert-success">Employé modifié avec succès.</div>
<?php elseif ($succes === 'supprime'): ?>
    <div class="alert alert-success">Employé supprimé avec succès.</div>
<?php endif; ?>

<div class="top-bar">
    <span style="color:var(--text-2);font-size:0.9rem;">Tous les employés enregistrés</span>
    <a href="ajouter.php" class="btn btn-primary-p btn-sm">+ Ajouter un employé</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Fonction</th>
                <th>Salaire</th>
                <th>Date d'Embauche</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($ligne = $donnees->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><span class="badge badge-p"><?= htmlspecialchars($ligne['id']) ?></span></td>
                <td style="color:var(--text);font-weight:500;"><?= htmlspecialchars($ligne['Nom']) ?></td>
                <td><?= htmlspecialchars($ligne['Prenom']) ?></td>
                <td><?= htmlspecialchars($ligne['Email']) ?></td>
                <td><?= htmlspecialchars($ligne['Telephone']) ?></td>
                <td><?= htmlspecialchars($ligne['Fonction']) ?></td>
                <td><?= number_format($ligne['Salaire']) ?> MAD</td>
                <td><?= htmlspecialchars($ligne['DateEmbauche']) ?></td>
                <td>
                    <div class="td-actions">
                        <a href="modifier.php?mat=<?= $ligne['id'] ?>"
                           class="btn btn-ghost btn-sm">Modifier</a>
                        <a href="supprimer.php?mat=<?= $ligne['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Supprimer cet employé ?')">Supprimer</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../../footer.php'); ?>
