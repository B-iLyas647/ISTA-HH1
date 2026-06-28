<?php
session_start();
$activePage = 'employes_ajouter';
$pageTitle  = 'Ajouter un employé — ISTA HH1';
$rootPath   = '../../';

include('../../connexion.php');

$validOptions = ['RH', 'Chef projet', 'Technicien superieure'];
$validGenre   = ['Homme', 'Femme'];

$errors = [];
$old    = [];

if (isset($_POST['submit'])) {

    if (empty($_POST['matricule'])) $errors[] = "Le matricule est obligatoire.";
    if (empty($_POST['nom']))       $errors[] = "Le nom est obligatoire.";
    if (empty($_POST['prenom']))    $errors[] = "Le prénom est obligatoire.";
    if (empty($_POST['salaire']))   $errors[] = "Le salaire est obligatoire.";
    if (empty($_POST['sexe']))      $errors[] = "Le sexe est obligatoire.";
    if (empty($_POST['poste']))     $errors[] = "Le poste est obligatoire.";

    if (empty($errors)) {
        $mat    = intval($_POST['matricule']);
        $nom    = htmlspecialchars(strip_tags(trim($_POST['nom'])));
        $prenom = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
        $sal    = floatval($_POST['salaire']);

        if (!in_array($_POST['sexe'], $validGenre))   $errors[] = "Valeur invalide pour le sexe.";
        else $sexe = $_POST['sexe'];

        if (!in_array($_POST['poste'], $validOptions)) $errors[] = "Valeur invalide pour le poste.";
        else $poste = $_POST['poste'];

        if (strlen($nom) < 2)    $errors[] = "Le nom doit contenir au moins 2 caractères.";
        if (strlen($prenom) < 2) $errors[] = "Le prénom doit contenir au moins 2 caractères.";
        if ($sal <= 0)           $errors[] = "Le salaire doit être un nombre positif.";
    }

    if (empty($errors)) {
        try {
            $stmt = $connexion->prepare(
                "INSERT INTO employes (Matricule, Nom, Prenom, Salaire, Sexe, Post)
                 VALUES (:mat, :nom, :prenom, :sal, :sexe, :poste)"
            );
            $stmt->execute([
                ':mat'    => $mat,
                ':nom'    => $nom,
                ':prenom' => $prenom,
                ':sal'    => $sal,
                ':sexe'   => $sexe,
                ':poste'  => $poste
            ]);
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
    <div class="breadcrumb">Employés</div>
    <h1>Ajouter un employé</h1>
    <div class="accent-bar-p"></div>
</div>

<div class="card employe-form" style="max-width:540px;">
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
                <label for="matricule">Matricule</label>
                <input type="number" id="matricule" name="matricule"
                       placeholder="Numéro de matricule"
                       value="<?= htmlspecialchars($old['matricule'] ?? '') ?>">
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
                <label for="salaire">Salaire (MAD)</label>
                <input type="number" id="salaire" name="salaire"
                       placeholder="0.00" step="0.01"
                       value="<?= htmlspecialchars($old['salaire'] ?? '') ?>">
            </div>

            <div class="field-group">
                <label>Sexe</label>
                <div class="radio-group">
                    <?php foreach ($validGenre as $genre): ?>
                        <label class="radio-item">
                            <input type="radio" name="sexe" value="<?= $genre ?>"
                                <?= ($old['sexe'] ?? '') === $genre ? 'checked' : '' ?>>
                            <?= $genre ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="field-group">
                <label for="poste">Poste</label>
                <select name="poste" id="poste">
                    <option value="" disabled <?= empty($old['poste']) ? 'selected' : '' ?>>
                        Sélectionner un poste
                    </option>
                    <?php foreach ($validOptions as $opt): ?>
                        <option value="<?= $opt ?>" <?= ($old['poste'] ?? '') === $opt ? 'selected' : '' ?>>
                            <?= $opt ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary-p">Enregistrer</button>
                <a href="liste.php" class="btn btn-ghost">Annuler</a>
            </div>

        </form>
    </div>
</div>

<?php include('../../footer.php'); ?>
