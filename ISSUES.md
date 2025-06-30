# Issues Tracker - Vide Grenier En Ligne

## Bugs à corriger (selon demande client)

### Issue #1 - Message d'erreur lors de soumission sans photo
**Statut**: 🔴 À faire  
**Priorité**: Haute  
**Assigné**: Développeur  
**Branche**: `bugfix/issue-1-photo-required`

**Description**: Un message d'erreur s'affiche quand on ne poste pas une photo dans une annonce. Tous les champs devaient être requis.

**Critères d'acceptation**:
- [ ] Permettre la soumission d'annonce sans photo
- [ ] Ajouter une validation côté client et serveur
- [ ] Mettre à jour les tests unitaires
- [ ] Documenter le changement

---

### Issue #2 - Connexion automatique après inscription
**Statut**: 🔴 À faire  
**Priorité**: Haute  
**Assigné**: Développeur  
**Branche**: `bugfix/issue-2-auto-login`

**Description**: Quand un utilisateur s'enregistre, il n'est pas connecté automatiquement après l'inscription.

**Critères d'acceptation**:
- [ ] Connecter automatiquement l'utilisateur après inscription réussie
- [ ] Rediriger vers la page appropriée
- [ ] Ajouter les tests unitaires
- [ ] Gérer les cas d'erreur

---

### Issue #3 - Bouton "se souvenir de moi" non fonctionnel
**Statut**: 🔴 À faire  
**Priorité**: Moyenne  
**Assigné**: Développeur  
**Branche**: `bugfix/issue-3-remember-me`

**Description**: Le bouton "se souvenir de moi" ne semble pas fonctionner correctement.

**Critères d'acceptation**:
- [ ] Implémenter la fonctionnalité de cookie persistant
- [ ] Tester la persistance de session
- [ ] Ajouter les tests unitaires
- [ ] Sécuriser les cookies

---

### Issue #4 - Formulaire de contact sur page produit
**Statut**: 🔴 À faire  
**Priorité**: Moyenne  
**Assigné**: Développeur  
**Branche**: `bugfix/issue-4-contact-form`

**Description**: Il était prévu d'avoir un formulaire de contact sur la page du produit, mais actuellement c'est la boîte mail qui s'ouvre.

**Critères d'acceptation**:
- [ ] Créer un formulaire de contact intégré
- [ ] Remplacer le lien mailto par le formulaire
- [ ] Implémenter l'envoi d'email via le formulaire
- [ ] Ajouter la validation et les tests

---

## Tâches techniques

### Issue #5 - Tests unitaires
**Statut**: 🔴 À faire  
**Priorité**: Haute  
**Assigné**: Développeur  
**Branche**: `feature/unit-tests`

**Description**: Créer les tests unitaires pour l'application

**Critères d'acceptation**:
- [ ] Tests pour les modèles (User, Articles, Cities)
- [ ] Tests pour les contrôleurs
- [ ] Tests pour les utilitaires (Hash, Upload)
- [ ] Coverage minimum de 80%

---

### Issue #6 - Documentation API
**Statut**: 🔴 À faire  
**Priorité**: Moyenne  
**Assigné**: Développeur  
**Branche**: `feature/api-documentation`

**Description**: Utiliser un système de génération documentaire pour le code API (Swagger)

**Critères d'acceptation**:
- [ ] Intégrer Swagger/OpenAPI
- [ ] Documenter toutes les routes API
- [ ] Générer la documentation automatiquement
- [ ] Script de génération de docs

---

### Issue #7 - Environnement de production Docker
**Statut**: 🔴 À faire  
**Priorité**: Haute  
**Assigné**: DevOps  
**Branche**: `feature/docker-production`

**Description**: Concevoir un environnement de production avec containers séparés

**Critères d'acceptation**:
- [ ] Container pour base de données persistante
- [ ] Container web avec code de la branche master
- [ ] Scripts de déploiement (.sh)
- [ ] Fichiers .env pour chaque environnement
