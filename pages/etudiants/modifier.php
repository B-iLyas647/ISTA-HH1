<?php
session_start();
$activePage = 'etudiants_liste';
$pageTitle  = 'Modifier un étudiant — ISTA HH1';
$rootPath   = '../../';

include('../../connexion.php');

// Vérifier que le CIN est fourni
if (!isset($_GET['cin']) || empty(trim($_GET['cin']))) {
    header("Location: liste.php");
    exit();
}
$cin = htmlspecialchars(strip_tags(trim($_GET['cin'])));

// Vérifier que l'étudiant existe
$stmt = $connexion->prepare("SELECT * FROM etudiants WHERE id = :cin");
$stmt->execute([':cin' => $cin]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    header("Location: liste.php");
    exit();
}

$errors = [];

if (isset($_POST['valider'])) {

    if (empty($_POST['newName']))   $errors[] = "Le nom est obligatoire.";
    if (empty($_POST['newPrenom'])) $errors[] = "Le prénom est obligatoire.";
    if (!isset($_POST['newMoy']) || $_POST['newMoy'] === '') $errors[] = "La moyenne est obligatoire.";

    if (empty($errors)) {
        $newNom    = htmlspecialchars(strip_tags(trim($_POST['newName'])));
        $newPrenom = htmlspecialchars(strip_tags(trim($_POST['newPrenom'])));
        $newMoy    = floatval($_POST['newMoy']);

        if (strlen($newNom) < 2)    $errors[] = "Le nom doit contenir au moins 2 caractères.";
        if (strlen($newPrenom) < 2) $errors[] = "Le prénom doit contenir au moins 2 caractères.";
        if ($newMoy < 0 || $newMoy > 20) $errors[] = "La moyenne doit être entre 0 et 20.";
    }

    if (empty($errors)) {
        try {
            $stmt = $connexion->prepare(
                "UPDATE etudiants SET Nom=:nom, Prenom=:prenom, Moyenne=:moy WHERE CIN=:cin"
            );
            $stmt->execute([
                ':nom'    => $newNom,
                ':prenom' => $newPrenom,
                ':moy'    => $newMoy,
                ':cin'    => $cin
            ]);
            header("Location: liste.php?succes=modifie");
            exit();
        } catch (Exception $e) {
            $errors[] = "Erreur base de données : " . $e->getMessage();
        }
    }
}

// Repopuler : valeurs POST si erreur, sinon valeurs BDD
$valNom    = !empty($errors) ? htmlspecialchars($_POST['newName']   ?? '') : htmlspecialchars($etudiant['Nom']);
$valPrenom = !empty($errors) ? htmlspecialchars($_POST['newPrenom'] ?? '') : htmlspecialchars($etudiant['Prenom']);
$valMoy    = !empty($errors) ? htmlspecialchars($_POST['newMoy']    ?? '') : htmlspecialchars($etudiant['Moyenne']);

include('../../nav.php');
?>

<div class="page-top">
    <div class="breadcrumb">Étudiants → Modifier</div>
    <h1>Modifier l'étudiant</h1>
    <div class="accent-bar-e"></div>
</div>

<div class="card" style="max-width:540px;">
    <div class="card-body">

        <p style="margin-bottom:1.2rem;">
            <span class="badge badge-e">CIN : <?= htmlspecialchars($etudiant['CIN']) ?></span>
        </p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="modifier.php?cin=<?= urlencode($cin) ?>" method="post">

            <div class="field-group">
                <label>ID (non modifiable)</label>
                <input type="text" value="<?= htmlspecialchars($etudiant['id']) ?>" readonly>
            </div>

            <div class="field-group">
                <label for="newName">Nom</label>
                <input type="text" id="newName" name="newName" value="<?= $valNom ?>">
            </div>

            <div class="field-group">
                <label for="newPrenom">Prénom</label>
                <input type="text" id="newPrenom" name="newPrenom" value="<?= $valPrenom ?>">
            </div>

            <div class="field-group">
                <label for="newMoy">Moyenne / 20</label>
                <input type="number" id="newMoy" name="newMoy" step="0.01" min="0" max="20"
                       value="<?= $valMoy ?>">
            </div>

            <div class="form-actions">
                <button type="submit" name="valider" class="btn btn-primary-e">Enregistrer</button>
                <a href="liste.php" class="btn btn-ghost">Annuler</a>
            </div>

        </form>
    </div>
</div>

<?php include('../../footer.php'); ?>
