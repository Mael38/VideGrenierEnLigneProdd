#!/bin/bash

echo "=== Démarrage de l'environnement de PRODUCTION Vide Grenier en Ligne ==="
echo "Port: 80"
echo "Base de données: port 3306"
echo ""

# Vérification que Docker est installé
if ! command -v docker &> /dev/null; then
    echo "❌ Docker n'est pas installé ou n'est pas dans le PATH"
    exit 1
fi

# Vérification que Docker Compose est installé
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose n'est pas installé ou n'est pas dans le PATH"
    exit 1
fi

# Arrêt des conteneurs existants (au cas où)
echo "🔄 Arrêt des conteneurs existants..."
docker-compose -f docker-compose.prod.yml down

# Construction et démarrage des conteneurs
echo "🚀 Construction et démarrage des conteneurs de production..."
docker-compose -f docker-compose.prod.yml up --build -d

# Attendre que les services soient prêts
echo "⏳ Attente du démarrage des services..."
sleep 10

# Vérification du statut des conteneurs
echo "📋 Statut des conteneurs:"
docker-compose -f docker-compose.prod.yml ps

# Test de connectivité
echo ""
echo "🌐 Test de connectivité..."
if curl -s -o /dev/null -w "%{http_code}" http://localhost | grep -q "200\|302"; then
    echo "✅ Application accessible sur http://localhost"
else
    echo "⚠️  L'application pourrait ne pas être encore prête. Vérifiez les logs:"
    echo "   docker-compose -f docker-compose.prod.yml logs web"
fi

echo ""
echo "=== Environnement de PRODUCTION démarré ==="
echo "🌐 Application: http://localhost"
echo "🗄️  Base de données: localhost:3306"
echo ""
echo "📝 Commandes utiles:"
echo "   Voir les logs: docker-compose -f docker-compose.prod.yml logs -f"
echo "   Arrêter: docker-compose -f docker-compose.prod.yml down"
echo "   Redémarrer: docker-compose -f docker-compose.prod.yml restart"
