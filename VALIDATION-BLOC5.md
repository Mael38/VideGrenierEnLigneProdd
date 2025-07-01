# Validation Bloc 5 - INFCDLPC7
## Déployer et maintenir une application informatique

> **Date de validation :** 1er juillet 2025  
> **Projet :** Vide Grenier en Ligne  
> **Version :** 1.0.2  

---

## ✅ Checklist des Exigences

### 1. Repository Git et gestion des issues ✅

- [x] **Repository créé** : Projet hébergé sur Git avec historique traçable
- [x] **Système de gestion des issues** : Fichier `ISSUES.md` avec tous les bugs identifiés
- [x] **Traçabilité** : Commits liés aux issues avec messages explicites

```bash
# Vérification
git log --oneline | head -10
git branch -a
```

### 2. GitFlow ✅

- [x] **Branches principales** : `master`, `develop`
- [x] **Branches de fonctionnalités** : `feature/*`
- [x] **Branches de correction** : `bugfix/*`
- [x] **Branches de release** : `release/*`
- [x] **Tags de version** : `v1.0.0`, `v1.0.1`, `v1.0.2`

**Branches actuelles :**
```
* feature/project-validation
  develop
  master
  bugfix/issue-1-photo-required
  bugfix/issue-2-auto-login
  bugfix/issue-3-remember-me
  bugfix/issue-4-contact-form
  release/v1.0.0
```

### 3. Correction des 4 bugs client ✅

#### Bug #1 - Photo non requise ✅
- **Status** : Corrigé dans `bugfix/issue-1-photo-required`
- **Solution** : Modification de la validation pour rendre la photo optionnelle
- **Commit** : [voir historique Git]

#### Bug #2 - Auto-login après inscription ✅
- **Status** : Corrigé dans `bugfix/issue-2-auto-login`
- **Solution** : Connexion automatique après inscription réussie
- **Commit** : [voir historique Git]

#### Bug #3 - Bouton "se souvenir de moi" ✅
- **Status** : Corrigé dans `bugfix/issue-3-remember-me`
- **Solution** : Implémentation des cookies persistants
- **Commit** : [voir historique Git]

#### Bug #4 - Formulaire de contact ✅
- **Status** : Corrigé dans `bugfix/issue-4-contact-form`
- **Solution** : Remplacement du mailto par un formulaire intégré
- **Commit** : [voir historique Git]

### 4. Environnement de développement Docker ✅

- [x] **Docker Compose dev** : `docker-compose.dev.yml`
- [x] **Dockerfile dev** : `Dockerfile.dev`
- [x] **Script de lancement** : `start-dev.sh` / `start-dev.bat`
- [x] **Configuration** : `.env.dev`

**Vérification :**
```bash
docker-compose -f docker-compose.dev.yml up -d
# Port 8080 pour le dev
```

### 5. Tests unitaires ✅

- [x] **PHPUnit installé** : Version 12.2.5
- [x] **Tests créés** : 
  - `UserControllerTest.php` (auto-login, remember me)
  - `UploadTest.php` (validation photo)
  - `ContactFormTest.php` (formulaire contact)
  - `RememberMeTest.php` (cookies persistants)

**Exécution :**
```bash
vendor\bin\phpunit tests\
# Résultat : Tests: 22, Assertions: 53, Succès
```

### 6. Environnement de production Docker ✅

- [x] **Docker Compose prod** : `docker-compose.prod.yml`
- [x] **Dockerfile prod** : `Dockerfile.prod`
- [x] **Script de lancement** : `start-prod.sh` / `start-prod.bat`
- [x] **Architecture séparée** :
  - Container Web avec code intégré
  - Container DB avec persistance
  - Réseau dédié

### 7. Documentation API ✅

- [x] **OpenAPI/Swagger** : `docs/api/openapi.yaml`
- [x] **Documentation générée** : `docs/api/index.html`
- [x] **Script de génération** : `generate-docs.sh` / `generate-docs.bat`

**Routes documentées :**
- `/api/products` - Gestion des articles
- `/api/users` - Gestion des utilisateurs
- `/api/contact` - Formulaire de contact
- `/api/cities` - Recherche de villes

### 8. Coexistence des environnements ✅

- [x] **Ports différents** :
  - Dev : 8080
  - Prod : 80
- [x] **Bases séparées** :
  - Dev : Port 3307
  - Prod : Port 3306
- [x] **Volumes distincts** :
  - `mysql_data_dev`
  - `mysql_data_prod`

### 9. Scripts de lancement ✅

- [x] **Développement** :
  - `start-dev.sh` (Linux/Mac)
  - `start-dev.bat` (Windows)
- [x] **Production** :
  - `start-prod.sh` (Linux/Mac)
  - `start-prod.bat` (Windows)

### 10. Fichiers .env ✅

- [x] **Développement** : `.env.dev`
- [x] **Production** : Variables dans docker-compose.prod.yml
- [x] **Sécurité** : Mots de passe distincts par environnement

---

## 🎯 Préparation pour l'oral (20 minutes)

### Démonstration des corrections (5 min)
1. **Bug photo** : Montrer soumission sans photo
2. **Auto-login** : Inscription + connexion automatique
3. **Remember me** : Test de persistance session
4. **Formulaire contact** : Utilisation du formulaire intégré

### Tests unitaires (3 min)
```bash
vendor\bin\phpunit tests\
```
Montrer les 22 tests qui passent avec 53 assertions.

### Développement GitFlow en live (7 min)
1. **État initial** : Montrer que prod != dev
2. **Nouvelle feature** : 
   ```bash
   git checkout develop
   git checkout -b feature/demo-live
   # Modification mineure (ex: ajout d'un commentaire)
   git add .
   git commit -m "Demo: Ajout fonctionnalité mineure"
   git checkout develop
   git merge feature/demo-live
   ```
3. **Déploiement prod** :
   ```bash
   git checkout master
   git merge develop
   git tag v1.0.3
   # Redémarrage container prod
   ```

### Environnements Docker (5 min)
1. **Coexistence** :
   ```bash
   docker-compose -f docker-compose.dev.yml up -d
   docker-compose -f docker-compose.prod.yml up -d
   docker ps  # Montrer les 4 containers
   ```
2. **Accès simultané** :
   - Dev : http://localhost:8080
   - Prod : http://localhost

---

## 📋 Documentation technique ajoutée

- [x] **ISSUES.md** : Gestion des bugs et traçabilité
- [x] **GITFLOW.md** : Workflow de développement
- [x] **SCSS-FIX.md** : Corrections techniques CSS
- [x] **PROJECT-SUMMARY.md** : Résumé du projet
- [x] **DEMONSTRATION.md** : Guide pour la démonstration
- [x] **VALIDATION-BLOC5.md** : Ce document

---

## ✅ Statut final

**TOUTES LES EXIGENCES DU BLOC 5 SONT RESPECTÉES**

Le projet est prêt pour l'évaluation orale avec :
- ✅ Repository Git vivant et traçable
- ✅ GitFlow implémenté avec branches et tags
- ✅ 4 bugs corrigés et testés
- ✅ Environnements Docker dev/prod opérationnels
- ✅ Tests unitaires fonctionnels (22 tests, 53 assertions)
- ✅ Documentation API générée (OpenAPI/Swagger)
- ✅ Scripts de déploiement automatisés
- ✅ Coexistence des environnements validée

**Prochaines étapes :**
1. Merger cette branche dans develop
2. Créer une release v1.0.3
3. Déployer en production
4. Préparer la démonstration orale
