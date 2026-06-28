<?php
session_start();
$activePage = 'etudiants_liste';
$pageTitle  = 'Liste des étudiants — ISTA HH1';
$rootPath   = '../../';

include('../../connexion.php');

$succes = $_GET['succes'] ?? null;

try {
    $contenu = $connexion->query("SELECT * FROM etudiants ORDER BY Nom ASC");
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

include('../../nav.php');
?>

<div class="page-top">
    <div class="breadcrumb">Étudiants</div>
    <h1>Liste des étudiants</h1>
    <div class="accent-bar-e"></div>
</div>

<?php if ($succes === 'ajoute'): ?>
    <div class="alert alert-success">Étudiant ajouté avec succès.</div>
<?php elseif ($succes === 'modifie'): ?>
    <div class="alert alert-success">Étudiant modifié avec succès.</div>
<?php elseif ($succes === 'supprime'): ?>
    <div class="alert alert-success">Étudiant supprimé avec succès.</div>
<?php endif; ?>

<div class="top-bar">
    <span style="color:var(--text-2);font-size:0.9rem;">Tous les étudiants enregistrés</span>
    <a href="ajouter.php" class="btn btn-primary-e btn-sm">+ Ajouter un étudiant</a>
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
                <th>Date Naissance</th>
                <th>Filiere</th>
                <th>Niveau</th>
                <th>Moyenne</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($ligne = $contenu->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><span class="badge badge-e"><?= htmlspecialchars($ligne['id']) ?></span></td>
                <td style="color:var(--text);font-weight:500;"><?= htmlspecialchars($ligne['Nom']) ?></td>
                <td><?= htmlspecialchars($ligne['Prenom']) ?></td>
                <td><?= htmlspecialchars($ligne['Email']) ?></td>
                <td><?= htmlspecialchars($ligne['Telephone']) ?></td>
                <td><?= htmlspecialchars($ligne['DateNaissance']) ?></td>
                <td><?= htmlspecialchars($ligne['Filiere']) ?></td>
                <td><?= htmlspecialchars($ligne['Niveau']) ?></td>
                <td>
                    <span class="badge <?= $ligne['Moyenne'] < 10 ? 'badge-danger' : 'badge-e' ?>">
                        <?= htmlspecialchars($ligne['Moyenne']) ?> / 20
                    </span>
                </td>
                <td>
                    <div class="td-actions">
                        <a href="modifier.php?cin=<?= urlencode($ligne['id']) ?>"
                           class="btn btn-ghost btn-sm">Modifier</a>
                        <a href="supprimer.php?cin=<?= urlencode($ligne['id']) ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../../footer.php'); ?>
