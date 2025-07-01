# GUIDE DÉMONSTRATION ORALE - BLOC 5
## Déployer et maintenir une application informatique (20 minutes)

---

## 📋 STRUCTURE DE LA PRÉSENTATION

### 1. INTRODUCTION (2 minutes)
- Présentation du projet Vide Grenier en Ligne
- Contexte : reprise d'un projet avec 4 bugs à corriger
- Objectifs : mise en place des environnements dev/prod et correction des bugs

---

## 🐛 2. DÉMONSTRATION DES 4 BUGS CORRIGÉS (5 minutes)

### Bug #1 - Photo non requise
**Branche**: `bugfix/issue-1-photo-required`
**Démonstration**:
```bash
# Montrer le code avant/après
git show bugfix/issue-1-photo-required
```
- Avant : Erreur si pas de photo
- Après : Photo optionnelle, validation ajustée

### Bug #2 - Auto-login après inscription  
**Branche**: `bugfix/issue-2-auto-login`
**Démonstration**:
- Montrer le code de connexion automatique
- Tester l'inscription avec redirection

### Bug #3 - Remember me
**Branche**: `bugfix/issue-3-remember-me`
**Démonstration**:
- Montrer l'implémentation des cookies persistants
- Tester la persistance de session

### Bug #4 - Formulaire de contact
**Branche**: `bugfix/issue-4-contact-form`
**Démonstration**:
- Avant : lien mailto
- Après : formulaire intégré

---

## 🧪 3. DÉMONSTRATION DES TESTS UNITAIRES (3 minutes)

```bash
# Exécuter tous les tests
vendor\bin\phpunit tests\

# Résultat attendu
OK (22 tests, 55 assertions)
```

**Tests par module**:
- UserControllerTest.php - Tests d'authentification
- ContactFormTest.php - Tests du formulaire
- RememberMeTest.php - Tests de persistance
- UploadTest.php - Tests d'upload de fichiers

---

## 🔄 4. DÉVELOPPEMENT EN LIVE AVEC GITFLOW (7 minutes)

### 4.1 Préparation - Feature à développer
**Feature suggérée**: Ajouter un système de favoris

### 4.2 Workflow GitFlow
```bash
# 1. Vérifier état actuel
git status
git branch

# 2. Créer la feature depuis develop
git checkout develop
git pull origin develop
git checkout -b feature/favorites-system

# 3. Développer (code préparé à l'avance)
# Ajouter un bouton favoris sur les articles
echo "Code de la feature favoris..." > favorites.php

# 4. Commit et push
git add .
git commit -m "feat: add favorites system for articles"
git push origin feature/favorites-system

# 5. Merge vers develop
git checkout develop
git merge feature/favorites-system

# 6. Push develop
git push origin develop
```

### 4.3 Prouver la désynchronisation dev/prod

```bash
# Démarrer l'environnement de développement
start-dev.bat

# Vérifier que la nouvelle feature est présente
# http://localhost:8080

# Démarrer l'environnement de production  
start-prod.bat

# Vérifier que la production n'a pas la feature
# http://localhost
```

### 4.4 Mise à jour production

```bash
# Merger develop vers master
git checkout master
git merge develop

# Tag de nouvelle version
git tag v1.0.3
git push origin master --tags

# Redéployer la production
docker-compose -f docker-compose.prod.yml down
docker-compose -f docker-compose.prod.yml up --build -d

# Vérifier que la feature est maintenant en production
```

---

## 🐳 5. DÉMONSTRATION COEXISTENCE ENVIRONNEMENTS (3 minutes)

### 5.1 Démarrage simultané
```bash
# Terminal 1 - Développement
start-dev.bat
# Accessible sur http://localhost:8080

# Terminal 2 - Production  
start-prod.bat
# Accessible sur http://localhost
```

### 5.2 Vérification des différences
- **Dev**: Dernières features, logs verbeux, hot-reload
- **Prod**: Version stable, optimisée, pas de volumes externes

### 5.3 Architecture Docker
```
Développement (port 8080):
├── Container web (volumes synchronisés)
├── Container DB (port 3307)
└── Hot-reload activé

Production (port 80):
├── Container web (code embarqué)
├── Container DB (port 3306)
└── Optimisé pour performance
```

---

## 📚 6. BONUS - DOCUMENTATION ET OUTILS

### API Documentation
```bash
# Générer la documentation Swagger
generate-docs.bat

# Ouvrir http://localhost:8080/docs/api/
```

### Système d'issues
- Montrer `ISSUES.md` avec traçabilité complète
- Démontrer le lien entre issues et branches

### Scripts utilitaires
- `fix-scss.bat` - Compilation SCSS
- `start-dev.bat` / `start-prod.bat` - Gestion environnements
- `generate-docs.bat` - Documentation API

---

## ⏰ TIMING RECOMMANDÉ

| Section | Durée | Cumul |
|---------|-------|-------|
| Introduction | 2 min | 2 min |
| Bugs corrigés | 5 min | 7 min |
| Tests unitaires | 3 min | 10 min |
| GitFlow live | 7 min | 17 min |
| Environnements | 3 min | 20 min |

---

## 🎯 POINTS CLÉS À RETENIR

### ✅ Exigences respectées à 100%
1. Repository Git avec GitFlow complet
2. Système de gestion des issues
3. 4 bugs corrigés avec tests
4. Environnements Docker dev/prod
5. Scripts de lancement automatisés
6. Documentation API Swagger
7. Coexistence des environnements
8. Merge requests et traçabilité

### 💡 Bonnes pratiques démontrées
- Commits atomiques et descriptifs
- Branches nommées selon convention
- Tests pour chaque correction
- Séparation claire dev/prod
- Documentation technique complète
- Scripts d'automatisation

---

## 🛠️ COMMANDES DE SECOURS

Si problème pendant la démonstration :

```bash
# Vérifier l'état Git
git status
git log --oneline -5

# Redémarrer les environnements
docker-compose -f docker-compose.dev.yml restart
docker-compose -f docker-compose.prod.yml restart

# Vérifier les tests
vendor\bin\phpunit tests\

# Vérifier les services
docker ps
```

---

## 📝 QUESTIONS POSSIBLES

**Q: Comment gérez-vous les conflits de merge ?**
R: Workflow GitFlow avec branches courtes, review de code, tests automatiques

**Q: Quelle est votre stratégie de tests ?**  
R: Tests unitaires pour chaque bug, PHPUnit, coverage des cas critiques

**Q: Comment sécurisez-vous les environnements ?**
R: Variables d'environnement séparées, pas de données sensibles en dur

**Q: Que faites-vous en cas de problème en production ?**
R: Branches hotfix, rollback rapide, monitoring des logs
