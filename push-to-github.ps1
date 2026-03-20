#!/usr/bin/env pwsh
# Script pour pousser le projet Kaylia vers GitHub
# Usage: .\push-to-github.ps1

Write-Host "🚀 Push du projet Kaylia Suite Home vers GitHub" -ForegroundColor Cyan
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

# Vérifier si git est installé
if (-not (Get-Command git -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Git n'est pas installé sur ce système" -ForegroundColor Red
    exit 1
}

# Vérifier si on est dans un dépôt git
if (-not (Test-Path .git)) {
    Write-Host "📦 Initialisation du dépôt Git..." -ForegroundColor Yellow
    git init
    Write-Host "✅ Dépôt Git initialisé" -ForegroundColor Green
}

# Vérifier si le remote existe
$remoteExists = git remote | Select-String "origin"
if (-not $remoteExists) {
    Write-Host "🔗 Ajout du remote GitHub..." -ForegroundColor Yellow
    git remote add origin https://github.com/sabzeboss1/Kaylia-suitehome.git
    Write-Host "✅ Remote ajouté" -ForegroundColor Green
} else {
    Write-Host "✅ Remote GitHub déjà configuré" -ForegroundColor Green
}

Write-Host ""
Write-Host "📋 Fichiers qui seront inclus:" -ForegroundColor Yellow
Write-Host "================================" -ForegroundColor Yellow

# Afficher le statut
git status --short

Write-Host ""
Write-Host "📝 Fichiers exclus par .gitignore:" -ForegroundColor Yellow
Write-Host "===================================" -ForegroundColor Yellow
Write-Host "- Tous les README*.md et fichiers .md en majuscules" -ForegroundColor Gray
Write-Host "- Fichiers .env (sensibles)" -ForegroundColor Gray
Write-Host "- node_modules/" -ForegroundColor Gray
Write-Host "- Fichiers de test (test-*.php, test-*.html, etc.)" -ForegroundColor Gray
Write-Host "- Scripts PowerShell (.ps1)" -ForegroundColor Gray
Write-Host "- Dossiers .vscode/, .idea/, .kiro/" -ForegroundColor Gray

Write-Host ""
$confirm = Read-Host "Voulez-vous continuer avec le push? (o/n)"

if ($confirm -ne "o" -and $confirm -ne "O") {
    Write-Host "❌ Opération annulée" -ForegroundColor Red
    exit 0
}

Write-Host ""
Write-Host "📦 Ajout des fichiers..." -ForegroundColor Yellow
git add .

Write-Host ""
$commitMessage = Read-Host "Message de commit (ou appuyez sur Entrée pour le message par défaut)"
if ([string]::IsNullOrWhiteSpace($commitMessage)) {
    $commitMessage = "Update: Kaylia Suite Home - Système de réservation complet"
}

Write-Host ""
Write-Host "💾 Création du commit..." -ForegroundColor Yellow
git commit -m "$commitMessage"

Write-Host ""
Write-Host "🚀 Push vers GitHub..." -ForegroundColor Yellow

# Déterminer la branche
$branch = git branch --show-current
if ([string]::IsNullOrWhiteSpace($branch)) {
    $branch = "main"
    git branch -M main
}

Write-Host "📤 Push vers la branche: $branch" -ForegroundColor Cyan

try {
    git push -u origin $branch
    Write-Host ""
    Write-Host "✅ Push réussi!" -ForegroundColor Green
    Write-Host "🌐 Votre projet est maintenant sur: https://github.com/sabzeboss1/Kaylia-suitehome" -ForegroundColor Cyan
} catch {
    Write-Host ""
    Write-Host "⚠️  Erreur lors du push. Tentative avec --force..." -ForegroundColor Yellow
    $forceConfirm = Read-Host "Voulez-vous forcer le push? (o/n)"
    
    if ($forceConfirm -eq "o" -or $forceConfirm -eq "O") {
        git push -u origin $branch --force
        Write-Host ""
        Write-Host "✅ Push forcé réussi!" -ForegroundColor Green
    } else {
        Write-Host "❌ Push annulé" -ForegroundColor Red
        exit 1
    }
}

Write-Host ""
Write-Host "🎉 Terminé!" -ForegroundColor Green
