# COMMANDES POUR L'ORAL - VIDE GRENIER EN LIGNE

Ce fichier répertorie toutes les commandes que vous exécuterez pendant votre oral, sur la base du GUIDE-ORAL.md déjà existant, mais organisé de manière plus pratique pour l'exécution des commandes.

## 1. PRÉPARATION INITIALE - VÉRIFICATION DES ENVIRONNEMENTS

```bash
# Afficher toutes les branches et confirmer que vous êtes sur feature/demo-presentation
git branch
git branch --show-current

# Afficher l'état des conteneurs Docker
docker ps

# Vérifier que les deux environnements sont actifs (ou les démarrer si nécessaire)
start-dev.bat  # Si l'environnement de développement n'est pas en cours d'exécution
start-prod.bat  # Si l'environnement de production n'est pas en cours d'exécution
```

## 2. DÉMONSTRATION DES BUGS CORRIGÉS

```bash
# Bug 1 - Photo requise
git checkout bugfix/issue-1-photo-required
git show
# Démontrer la correction dans le navigateur

# Bug 2 - Auto-login après inscription
git checkout bugfix/issue-2-auto-login
git show
# Démontrer la correction dans le navigateur

# Bug 3 - Remember Me
git checkout bugfix/issue-3-remember-me
git show
# Démontrer la correction dans le navigateur

# Bug 4 - Formulaire de contact
git checkout bugfix/issue-4-contact-form
git show
# Démontrer la correction dans le navigateur
```

## 3. DÉMONSTRATION DES TESTS UNITAIRES

```bash
# Exécution des tests unitaires
git checkout develop
docker-compose -f docker-compose.dev.yml exec dev_web ./vendor/bin/phpunit tests/



# Montrer les fichiers de test individuels
docker-compose -f docker-compose.dev.yml exec dev_web cat tests/UserControllerTest.php
docker-compose -f docker-compose.dev.yml exec dev_web cat tests/ContactFormTest.php
docker-compose -f docker-compose.dev.yml exec dev_web cat tests/RememberMeTest.php
docker-compose -f docker-compose.dev.yml exec dev_web cat tests/UploadTest.php
```

## 4. DÉVELOPPEMENT EN LIVE - WORKFLOW GITFLOW

```bash
# 1. Retourner à la branche feature/demo-presentation
git checkout feature/demo-presentation

# 2. Montrer les modifications apportées à l'interface
git show

# 3. Montrer l'environnement de développement avec la nouvelle interface
# Ouvrir http://localhost:8081 dans le navigateur

# 4. Montrer l'environnement de production sans la nouvelle interface
# Ouvrir http://localhost:8082 dans le navigateur

# 5. Créer une pull request sur GitHub (déjà préparé)
# Montrer l'interface GitHub avec la pull request

# 6. Merger la branche feature dans develop
git checkout develop
git merge feature/demo-presentation
git log -1

# 7. Vérifier l'environnement de développement
# Rafraîchir http://localhost:8081 dans le navigateur

# 8. Merger develop dans main
git checkout main
git merge develop
git log -1

# 9. Reconstruire l'environnement de production
docker-compose -f docker-compose.prod.yml up -d --build

# 10. Vérifier l'environnement de production mis à jour
# Rafraîchir http://localhost:8082 dans le navigateur
```

## 5. DOCUMENTATION API

```bash
# Montrer la documentation API générée
dir docs/api

# Exécuter la génération de documentation
generate-docs.bat

# Montrer la documentation dans le navigateur
# Ouvrir http://localhost:8082/docs/api/ dans le navigateur
```

## 6. DÉMONSTRATION DE LA COEXISTENCE DES ENVIRONNEMENTS

```bash
# Montrer que les deux environnements fonctionnent simultanément
docker ps

# Montrer les différences entre les environnements
docker-compose -f docker-compose.dev.yml config
docker-compose -f docker-compose.prod.yml config

# Démontrer la séparation des données
# Ajouter un article dans l'environnement de développement
# Montrer qu'il n'apparaît pas dans l'environnement de production
```

## 7. SCRIPTS DE DÉMARRAGE

```bash
# Montrer les scripts de démarrage
type start-dev.bat
type start-prod.bat
type docker-entrypoint.sh
```

---

Ces commandes suivent exactement le flux de votre présentation orale et vous permettront de démontrer efficacement tous les aspects du projet demandés dans les consignes.
