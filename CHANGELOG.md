# CHANGELOG

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
