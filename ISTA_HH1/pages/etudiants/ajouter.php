<?php
session_start();
$activePage = 'etudiants_ajouter';
$pageTitle  = 'Ajouter un étudiant — ISTA HH1';
$rootPath   = '../../';

include('../../connexion.php');

$errors = [];
$old    = [];

if (isset($_POST['submit'])) {

    if (empty($_POST['cin']))     $errors[] = "Le CIN est obligatoire.";
    if (empty($_POST['nom']))     $errors[] = "Le nom est obligatoire.";
    if (empty($_POST['prenom']))  $errors[] = "Le prénom est obligatoire.";
    if (empty($_POST['moyenne'])) $errors[] = "La moyenne est obligatoire.";

    if (empty($errors)) {
        $cin     = htmlspecialchars(strip_tags(trim($_POST['cin'])));
        $nom     = htmlspecialchars(strip_tags(trim($_POST['nom'])));
        $prenom  = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
        $moyenne = floatval($_POST['moyenne']);

        if (!preg_match('/^[A-Z]{2}[0-9]{4,6}$/', $cin))
            $errors[] = "Format CIN invalide (ex: AB12345).";
        if (strlen($nom) < 2)
            $errors[] = "Le nom doit contenir au moins 2 caractères.";
        if (strlen($prenom) < 2)
            $errors[] = "Le prénom doit contenir au moins 2 caractères.";
        if ($moyenne < 0 || $moyenne > 20)
            $errors[] = "La moyenne doit être entre 0 et 20.";
    }

    if (empty($errors)) {
        try {
            $stmt = $connexion->prepare(
                "INSERT INTO etudiants (CIN, Nom, Prenom, Moyenne) VALUES (:cin, :nom, :prenom, :moy)"
            );
            $stmt->execute([':cin' => $cin, ':nom' => $nom, ':prenom' => $prenom, ':moy' => $moyenne]);
            header("Location: liste.php?succes=ajoute");
            exit();
        } catch (Exception $e) {
            $errors[] = "Erreur base de données : " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $old = $_POST;
    }
}

include('../../nav.php');
?>

<div class="page-top">
    <div class="breadcrumb">Étudiants</div>
    <h1>Ajouter un étudiant</h1>
    <div class="accent-bar-e"></div>
</div>

<div class="card" style="max-width:540px;">
    <div class="card-body">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="ajouter.php" method="post">

            <div class="field-group">
                <label for="cin">CIN</label>
                <input type="text" id="cin" name="cin"
                       placeholder="Ex: AB12345"
                       value="<?= htmlspecialchars($old['cin'] ?? '') ?>">
            </div>

            <div class="field-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom"
                       placeholder="Nom de famille"
                       value="<?= htmlspecialchars($old['nom'] ?? '') ?>">
            </div>

            <div class="field-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom"
                       placeholder="Prénom"
                       value="<?= htmlspecialchars($old['prenom'] ?? '') ?>">
            </div>

            <div class="field-group">
                <label for="moyenne">Moyenne / 20</label>
                <input type="number" id="moyenne" name="moyenne"
                       placeholder="0.00" step="0.01" min="0" max="20"
                       value="<?= htmlspecialchars($old['moyenne'] ?? '') ?>">
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary-e">Enregistrer</button>
                <a href="liste.php" class="btn btn-ghost">Annuler</a>
            </div>

        </form>
    </div>
</div>

<?php include('../../footer.php'); ?>
