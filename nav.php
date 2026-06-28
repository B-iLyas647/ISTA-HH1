<?php
// nav.php — Barre de navigation partagée
// Usage: include('../nav.php'); ou include('nav.php');
// Passer $activePage = 'etudiants_liste' etc. avant d'inclure
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'ISTA HH1' ?></title>
    <link rel="stylesheet" href="/ISTA_HH1/css/style.css">
</head>
<body>
<div class="layout">

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="institute">ISTA HH1</div>
            <div class="tagline">Gestion des données</div>
        </div>

        <nav>
            <div class="nav-section">
                <div class="nav-label">Tableau de bord</div>
                <a href="<?= $rootPath ?? '../' ?>index.php"
                   class="nav-link <?= $activePage === 'dashboard' ? 'active-e' : '' ?>">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                    </svg>
                    Accueil
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-label">Étudiants</div>
                <a href="<?= $rootPath ?? '../' ?>pages/etudiants/liste.php"
                   class="nav-link <?= $activePage === 'etudiants_liste' ? 'active-e' : '' ?>">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Liste des étudiants
                </a>
                <a href="<?= $rootPath ?? '../' ?>pages/etudiants/ajouter.php"
                   class="nav-link <?= $activePage === 'etudiants_ajouter' ? 'active-e' : '' ?>">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter un étudiant
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-label">Employés</div>
                <a href="<?= $rootPath ?? '../' ?>pages/employes/liste.php"
                   class="nav-link <?= $activePage === 'employes_liste' ? 'active-p' : '' ?>">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                    Liste des employés
                </a>
                <a href="<?= $rootPath ?? '../' ?>pages/employes/ajouter.php"
                   class="nav-link <?= $activePage === 'employes_ajouter' ? 'active-p' : '' ?>">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter un employé
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            Année 2025 / 2026
        </div>
    </aside>

    <main class="main">
