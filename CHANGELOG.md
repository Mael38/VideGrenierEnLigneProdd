# CHANGELOG

## [1.0.3] - 2025-07-01 - Version finale Bloc 5
### Added
- ✅ Validation complète des exigences Bloc 5 - INFCDLPC7
- ✅ Guide de démonstration orale (GUIDE-DEMONSTRATION.md)
- ✅ Documentation technique complète (VALIDATION-BLOC5.md)
- ✅ Scripts de correction SCSS automatisés (fix-scss.sh/bat)
- ✅ Tests unitaires finalisés (22 tests, 53 assertions)

### Fixed  
- ✅ Tests unitaires Upload corrigés et fonctionnels
- ✅ Environnements Docker optimisés pour coexistence
- ✅ Documentation API finalisée avec OpenAPI/Swagger

### Technical
- ✅ GitFlow complètement implémenté
- ✅ Tous les bugs client corrigés et testés
- ✅ Environnements dev/prod opérationnels
- ✅ Projet prêt pour évaluation Bloc 5

## [1.0.2] - 2025-06-30 - Corrections SCSS et UI
### Fixed
- ✅ Problèmes de compilation SCSS résolus
- ✅ Layout des pages login/register corrigé
- ✅ Media queries et propriétés CSS fixes
- ✅ Migration vers Dart Sass

## [1.0.1] - 2025-06-29 - Corrections bugs critiques
### Fixed
- ✅ Bug #1: Photo non requise pour les annonces
- ✅ Bug #2: Auto-login après inscription
- ✅ Bug #3: Fonctionnalité "se souvenir de moi"
- ✅ Bug #4: Formulaire de contact intégré

### Added
- ✅ Tests unitaires pour chaque correction
- ✅ Documentation des corrections (ISSUES.md)

## [1.0.0] - 2024-12-30

### Release - Vide Grenier en Ligne Production Ready

Cette première version marque la livraison complète du projet selon les spécifications du Bloc 5 - INFCDLPC7.

### ✨ Nouveautés
- **Environnement Docker complet** : Développement et production séparés
- **Documentation API** : OpenAPI 3.0.3 avec interface Swagger UI
- **Scripts d'automatisation** : Démarrage dev/prod automatisé
- **Tests unitaires** : Couverture complète des corrections

### 🐛 Corrections de bugs
- **#1** : Photo non requise pour une annonce - Upload d'image rendu optionnel
- **#2** : Connexion automatique après inscription - Implémentation complète  
- **#3** : Fonctionnalité "se souvenir de moi" - Tokens sécurisés
- **#4** : Formulaire de contact sur page produit - Interface intégrée

### 🔧 Améliorations techniques
- **Sécurisation** : Upload de fichiers, validation formulaires, tokens remember_me
- **Performance** : Docker production optimisé, autoloader classmap
- **Maintenabilité** : Tests unitaires, documentation complète
- **Déploiement** : Scripts automatisés Windows/Linux

### 📚 Documentation
- `GITFLOW.md` : Workflow Git détaillé
- `ISSUES.md` : Spécifications des bugs corrigés
- `PROJECT-SUMMARY.md` : Vue d'ensemble complète du projet
- `docs/api/` : Documentation API interactive

### 🚀 Déploiement
- **Développement** : `start-dev.sh/bat` → http://localhost:8080
- **Production** : `start-prod.sh/bat` → http://localhost
- **Documentation** : `generate-docs.sh/bat` → http://localhost:8080/docs/api/

### 📋 Validation
- ✅ 4 bugs corrigés et testés
- ✅ Environnements dev/prod fonctionnels
- ✅ GitFlow respecté avec traçabilité complète
- ✅ Tests unitaires passants
- ✅ Documentation API générée
- ✅ Scripts de démarrage opérationnels

---

**Livrable conforme aux exigences du Bloc 5 - INFCDLPC7**  
**Prêt pour démonstration et mise en production**
