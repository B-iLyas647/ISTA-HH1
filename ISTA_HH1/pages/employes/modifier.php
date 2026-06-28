<?php
session_start();
$activePage = 'employes_liste';
$pageTitle  = 'Modifier un employé — ISTA HH1';
$rootPath   = '../../';

include('../../connexion.php');

$validOptions = ['RH', 'Chef projet', 'Technicien superieure'];
$validGenre   = ['Homme', 'Femme'];

// Vérifier l'ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: liste.php");
    exit();
}
$id = intval($_GET['id']);

// Vérifier que l'employé existe
$stmt = $connexion->prepare("SELECT * FROM employes WHERE Matricule = :mat");
$stmt->execute([':mat' => $id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$employe) {
    header("Location: liste.php");
    exit();
}

$errors = [];

if (isset($_POST['valider'])) {

    if (empty($_POST['newName']))   $errors[] = "Le nom est obligatoire.";
    if (empty($_POST['newPrenom'])) $errors[] = "Le prénom est obligatoire.";
    if (empty($_POST['newSal']))    $errors[] = "Le salaire est obligatoire.";
    if (empty($_POST['newSex']))    $errors[] = "Le sexe est obligatoire.";
    if (empty($_POST['newPost']))   $errors[] = "Le poste est obligatoire.";

    if (empty($errors)) {
        $newNom    = htmlspecialchars(strip_tags(trim($_POST['newName'])));
        $newPrenom = htmlspecialchars(strip_tags(trim($_POST['newPrenom'])));
        $newSal    = floatval($_POST['newSal']);

        if (!in_array($_POST['newSex'], $validGenre))    $errors[] = "Valeur invalide pour le sexe.";
        else $newSex = $_POST['newSex'];

        if (!in_array($_POST['newPost'], $validOptions)) $errors[] = "Valeur invalide pour le poste.";
        else $newPost = $_POST['newPost'];

        if (strlen($newNom) < 2)    $errors[] = "Le nom doit contenir au moins 2 caractères.";
        if (strlen($newPrenom) < 2) $errors[] = "Le prénom doit contenir au moins 2 caractères.";
        if ($newSal <= 0)           $errors[] = "Le salaire doit être un nombre positif.";
    }

    if (empty($errors)) {
        try {
            $stmt = $connexion->prepare(
                "UPDATE employes SET Nom=:nom, Prenom=:prenom, Salaire=:sal, Sexe=:sexe, Post=:post
                 WHERE Matricule=:mat"
            );
            $stmt->execute([
                ':nom'    => $newNom,
                ':prenom' => $newPrenom,
                ':sal'    => $newSal,
                ':sexe'   => $newSex,
                ':post'   => $newPost,
                ':mat'    => $id
            ]);
            header("Location: liste.php?succes=modifie");
            exit();
        } catch (Exception $e) {
            $errors[] = "Erreur base de données : " . $e->getMessage();
        }
    }
}

// Repopuler
$valNom    = !empty($errors) ? htmlspecialchars($_POST['newName']   ?? '') : htmlspecialchars($employe['Nom']);
$valPrenom = !empty($errors) ? htmlspecialchars($_POST['newPrenom'] ?? '') : htmlspecialchars($employe['Prenom']);
$valSal    = !empty($errors) ? htmlspecialchars($_POST['newSal']    ?? '') : htmlspecialchars($employe['Salaire']);
$valSex    = !empty($errors) ? ($_POST['newSex']  ?? '')                  : $employe['Sexe'];
$valPost   = !empty($errors) ? ($_POST['newPost'] ?? '')                  : $employe['Post'];

include('../../nav.php');
?>

<div class="page-top">
    <div class="breadcrumb">Employés → Modifier</div>
    <h1>Modifier l'employé</h1>
    <div class="accent-bar-p"></div>
</div>

<div class="card employe-form" style="max-width:540px;">
    <div class="card-body">

        <p style="margin-bottom:1.2rem;">
            <span class="badge badge-p">Matricule : <?= htmlspecialchars($employe['Matricule']) ?></span>
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

        <form action="modifier.php?mat=<?= $id ?>" method="post">

            <div class="field-group">
                <label>Matricule (non modifiable)</label>
                <input type="text" value="<?= htmlspecialchars($employe['Matricule']) ?>" readonly>
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
                <label for="newSal">Salaire (MAD)</label>
                <input type="number" id="newSal" name="newSal" step="0.01" value="<?= $valSal ?>">
            </div>

            <div class="field-group">
                <label>Sexe</label>
                <div class="radio-group">
                    <?php foreach ($validGenre as $genre): ?>
                        <label class="radio-item">
                            <input type="radio" name="newSex" value="<?= $genre ?>"
                                <?= $valSex === $genre ? 'checked' : '' ?>>
                            <?= $genre ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="field-group">
                <label for="newPost">Poste</label>
                <select name="newPost" id="newPost">
                    <?php foreach ($validOptions as $opt): ?>
                        <option value="<?= $opt ?>" <?= $valPost === $opt ? 'selected' : '' ?>>
                            <?= $opt ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" name="valider" class="btn btn-primary-p">Enregistrer</button>
                <a href="liste.php" class="btn btn-ghost">Annuler</a>
            </div>

        </form>
    </div>
</div>

<?php include('../../footer.php'); ?>
