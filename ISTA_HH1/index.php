<?php
$activePage = 'dashboard';
$pageTitle  = 'ISTA HH1 — Tableau de bord';
$cssPath    = 'css/style.css';
$rootPath   = './';

include('connexion.php');

$nbEtudiants = $connexion->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
$nbEmployes  = $connexion->query("SELECT COUNT(*) FROM employes")->fetchColumn();
$moyGlobal   = $connexion->query("SELECT ROUND(AVG(Moyenne),2) FROM etudiants")->fetchColumn();
$salMoyen    = $connexion->query("SELECT ROUND(AVG(Salaire),2) FROM employes")->fetchColumn();

include('nav.php');
?>

<div class="page-top">
    <div class="breadcrumb">ISTA HH1</div>
    <h1>Tableau de bord</h1>
    <p class="subtitle">Vue d'ensemble du centre</p>
    <div class="accent-bar-e"></div>
</div>

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">Étudiants</div>
        <div class="stat-value"><?= $nbEtudiants ?></div>
    </div>
    <div class="stat-card blue">
        <div class="stat-label">Moyenne générale</div>
        <div class="stat-value"><?= $moyGlobal ?? '—' ?></div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Employés</div>
        <div class="stat-value"><?= $nbEmployes ?></div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Salaire moyen</div>
        <div class="stat-value"><?= $salMoyen ? number_format($salMoyen, 0, ',', ' ') : '—' ?></div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-top:1rem;">
    <div class="card">
        <div class="card-body">
            <p style="font-size:0.72rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-3);margin-bottom:0.75rem;">Étudiants</p>
            <p style="color:var(--text-2);font-size:0.92rem;margin-bottom:1.2rem;">Gérer les inscriptions, les notes et les informations personnelles des étudiants.</p>
            <div style="display:flex;gap:0.6rem;flex-wrap:wrap;">
                <a href="pages/etudiants/liste.php" class="btn btn-primary-e btn-sm">Voir la liste</a>
                <a href="pages/etudiants/ajouter.php" class="btn btn-ghost btn-sm">+ Ajouter</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p style="font-size:0.72rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-3);margin-bottom:0.75rem;">Employés</p>
            <p style="color:var(--text-2);font-size:0.92rem;margin-bottom:1.2rem;">Gérer les fiches des employés, leurs postes, salaires et informations.</p>
            <div style="display:flex;gap:0.6rem;flex-wrap:wrap;">
                <a href="pages/employes/liste.php" class="btn btn-primary-p btn-sm">Voir la liste</a>
                <a href="pages/employes/ajouter.php" class="btn btn-ghost btn-sm">+ Ajouter</a>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
