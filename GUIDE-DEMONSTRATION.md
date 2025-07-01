# Guide de Démonstration Orale
## Bloc 5 - INFCDLPC7 - Vide Grenier en Ligne

> **Durée :** 20 minutes  
> **Structure :** 4 parties + 5 min questions  

---

## 🎯 Plan de présentation

### 1. Introduction (2 min)
**"Bonjour, je vais vous présenter la reprise et la maintenance du projet Vide Grenier en Ligne"**

- **Contexte** : Reprise d'un projet avec 4 bugs critiques
- **Objectif** : Mise en place d'un workflow GitFlow et d'environnements Docker
- **Livrables** : Corrections, tests, documentation, déploiement

### 2. Démonstration des corrections (6 min)

#### A. Bug #1 - Photo optionnelle (1.5 min)
```bash
# Ouvrir http://localhost:8080/product/create
# Montrer la soumission SANS photo
# ✅ Fonctionne maintenant
```
**"Avant : erreur obligatoire. Maintenant : photo optionnelle"**

#### B. Bug #2 - Auto-login après inscription (1.5 min)
```bash
# Ouvrir http://localhost:8080/user/register
# S'inscrire avec un nouvel utilisateur
# ✅ Connexion automatique après inscription
```
**"L'utilisateur est maintenant connecté automatiquement"**

#### C. Bug #3 - Remember me (1.5 min)
```bash
# Se connecter avec "Se souvenir de moi"
# Fermer navigateur, rouvrir
# ✅ Toujours connecté
```
**"Le cookie persistant fonctionne maintenant"**

#### D. Bug #4 - Formulaire de contact (1.5 min)
```bash
# Aller sur une page produit
# Cliquer "Contacter le vendeur"
# ✅ Formulaire intégré au lieu de mailto
```
**"Formulaire intégré remplace l'ouverture d'email"**

### 3. Tests unitaires (3 min)

```bash
cd c:\Users\mael.belhacene\Documents\Developpement\CESI\Bloc\VideGrenierEnLigneProd
vendor\bin\phpunit tests\
```

**Montrer le résultat :**
- ✅ 22 tests passés
- ✅ 53 assertions validées
- ✅ Couverture des 4 bugs corrigés

**"Chaque correction dispose de tests automatisés"**

### 4. Développement GitFlow en live (7 min)

#### A. État initial - Environnements désynchronisés (2 min)
```bash
# Montrer les containers actifs
docker ps

# Accéder aux deux environnements
# Dev: http://localhost:8080
# Prod: http://localhost
```
**"Développement et production coexistent avec des versions différentes"**

#### B. Développement d'une feature (3 min)
```bash
git status
git checkout develop

# Créer une nouvelle feature
git checkout -b feature/demo-amelioration-ui

# Faire une modification simple (ex: modifier un commentaire dans le header)
# Dans App/Views/base.html, ajouter un commentaire
```

**Modification live :**
```html
<!-- Version 1.0.3 - Amélioration UI démo -->
```

```bash
git add .
git commit -m "feat: Amélioration interface utilisateur v1.0.3"
git checkout develop
git merge feature/demo-amelioration-ui
git branch -d feature/demo-amelioration-ui
```

#### C. Déploiement en production (2 min)
```bash
# Merger dans master
git checkout master
git merge develop
git tag v1.0.3

# Redéployer la production
docker-compose -f docker-compose.prod.yml down
docker-compose -f docker-compose.prod.yml up -d --build
```

**"La production est maintenant à jour avec develop"**

### 5. Architecture technique (2 min)

#### A. Environnements Docker
```bash
docker-compose -f docker-compose.dev.yml ps
docker-compose -f docker-compose.prod.yml ps
```

**Structure :**
- **Dev** : Port 8080, volumes partagés, hot reload
- **Prod** : Port 80, code intégré, optimisé

#### B. Documentation API
```bash
# Ouvrir docs/api/index.html dans le navigateur
```
**"Documentation OpenAPI générée automatiquement"**

---

## 🛠️ Commandes de préparation

### Avant la présentation :
```bash
# 1. S'assurer que les environnements tournent
docker-compose -f docker-compose.dev.yml up -d
docker-compose -f docker-compose.prod.yml up -d

# 2. Préparer la branche pour la démo
git checkout develop
git status

# 3. Tester les accès
# Dev: http://localhost:8080
# Prod: http://localhost

# 4. Préparer le code à modifier (identifier le fichier exact)
```

### Pendant la présentation :
1. **Navigateurs préparés** avec les deux environnements
2. **Terminal ouvert** sur le projet
3. **Éditeur prêt** pour la modification live
4. **Documentation API** accessible

---

## 📝 Points clés à mentionner

### GitFlow
- **Branches** : master, develop, feature/*, bugfix/*
- **Merge requests** : Toujours via develop
- **Tags** : Versioning sémantique (v1.0.0, v1.0.1, v1.0.2)

### Docker
- **Séparation** : Environnements isolés
- **Persistance** : Données en volumes
- **Scripts** : Automatisation déploiement

### Tests
- **Unitaires** : PHPUnit
- **Couverture** : Bugs critiques
- **Automatisation** : CI/CD ready

### Documentation
- **Issues** : Traçabilité complète
- **API** : OpenAPI/Swagger
- **Technique** : README, guides

---

## ⚡ Backup si problème technique

### Si Docker ne démarre pas :
- Montrer les fichiers de configuration
- Expliquer l'architecture prévue
- Démontrer via les scripts

### Si Git pose problème :
- Montrer l'historique existant
- Expliquer le workflow théorique
- Utiliser les documents de traçabilité

### Si les tests échouent :
- Montrer les fichiers de tests
- Expliquer la logique de validation
- Mentionner que ça fonctionnait avant

---

## 🎯 Objectif final

**Démontrer la maîtrise complète du cycle DevOps :**
- ✅ Gestion de projet (GitFlow, Issues)
- ✅ Développement (Corrections, Tests)
- ✅ Déploiement (Docker, Scripts)
- ✅ Maintenance (Documentation, Monitoring)

**Message final :** *"Le projet respecte toutes les exigences du Bloc 5 et est prêt pour un environnement de production professionnel"*
