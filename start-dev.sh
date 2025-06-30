#!/bin/bash

echo "🚀 Démarrage de l'environnement de développement Vide Grenier En Ligne"
echo "======================================================================"

# Vérification que nous sommes sur la branche develop
current_branch=$(git branch --show-current)
if [ "$current_branch" != "develop" ]; then
    echo "⚠️  Attention: Vous n'êtes pas sur la branche 'develop' (branche actuelle: $current_branch)"
    read -p "Voulez-vous continuer? (y/N) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Arrêt des containers existants
echo "📦 Arrêt des containers existants..."
docker-compose -f docker-compose.dev.yml down

# Construction et démarrage des containers
echo "🔨 Construction et démarrage des containers de développement..."
docker-compose -f docker-compose.dev.yml up --build -d

# Attendre que la base de données soit prête
echo "⏳ Attente de la base de données..."
sleep 10

# Installation des dépendances si nécessaire
echo "📚 Installation des dépendances..."
docker-compose -f docker-compose.dev.yml exec web composer install

# Vérification que les services sont bien démarrés
echo "✅ Vérification des services..."
docker-compose -f docker-compose.dev.yml ps

echo ""
echo "🎉 Environnement de développement démarré avec succès!"
echo "🌐 Application accessible sur: http://localhost:8080"
echo "🗄️  Base de données accessible sur: localhost:3307"
echo "📋 Pour voir les logs: docker-compose -f docker-compose.dev.yml logs -f"
echo "🛑 Pour arrêter: docker-compose -f docker-compose.dev.yml down"
echo ""
