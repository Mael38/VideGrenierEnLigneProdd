# GitFlow Workflow - Vide Grenier En Ligne

## Structure des branches

- **master/main** : Branche de production, contient uniquement le code stable et testé
- **develop** : Branche de développement, intègre toutes les nouvelles fonctionnalités
- **feature/** : Branches pour développer de nouvelles fonctionnalités
- **bugfix/** : Branches pour corriger les bugs identifiés
- **hotfix/** : Branches pour les corrections urgentes en production
- **release/** : Branches pour préparer une nouvelle version

## Workflow des bugs à corriger

Selon les consignes du client, nous devons corriger 4 bugs :

1. **Bug #1** : Message d'erreur lors de la soumission d'annonce sans photo
2. **Bug #2** : Utilisateur non connecté automatiquement après inscription
3. **Bug #3** : Bouton "se souvenir de moi" non fonctionnel
4. **Bug #4** : Formulaire de contact non présent sur la page produit

## Process de développement

1. Créer une issue pour chaque bug
2. Créer une branche `bugfix/issue-X` depuis `develop`
3. Développer la correction
4. Créer les tests unitaires associés
5. Merge request vers `develop`
6. Après validation, merge vers `master` pour production

## Commandes Git courantes

```bash
# Créer une nouvelle branche de bugfix
git checkout develop
git pull origin develop
git checkout -b bugfix/issue-1

# Après développement
git add .
git commit -m "fix: correction du bug #1 - message d'erreur photo manquante"
git push origin bugfix/issue-1

# Merge request via interface web ou commande
git checkout develop
git merge bugfix/issue-1
git push origin develop
```