#!/bin/bash

echo "=== Génération de la documentation API Vide Grenier en Ligne ==="

# Vérification que les dépendances sont installées
if [ ! -f "vendor/bin/openapi" ]; then
    echo "❌ OpenAPI Generator non trouvé. Installation des dépendances..."
    composer install
fi

# Création du répertoire docs s'il n'existe pas
mkdir -p docs/api

# Copie du fichier OpenAPI existant
if [ -f "docs/api/openapi.yaml" ]; then
    echo "✅ Utilisation du fichier OpenAPI existant"
else
    echo "❌ Fichier OpenAPI non trouvé"
    exit 1
fi

# Génération de la documentation HTML avec Swagger UI
echo "🔄 Génération de la documentation HTML..."

# Création d'une page HTML simple avec Swagger UI
cat > docs/api/index.html << 'EOF'
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Vide Grenier en Ligne</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui.css" />
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        body {
            margin:0;
            background: #fafafa;
        }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle({
                url: './openapi.yaml',
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout",
                validatorUrl: null
            });
        };
    </script>
</body>
</html>
EOF

# Génération d'annotations dans le code source (commentaires pour future amélioration)
echo "📝 Scan du code source pour annotations OpenAPI..."
find App/ -name "*.php" -exec grep -l "swagger\|openapi\|@OA" {} \; || echo "Aucune annotation OpenAPI trouvée dans le code source"

echo ""
echo "✅ Documentation générée avec succès !"
echo "📁 Fichiers générés:"
echo "   - docs/api/openapi.yaml (Spécification OpenAPI)"
echo "   - docs/api/index.html (Interface Swagger UI)"
echo ""
echo "🌐 Pour visualiser la documentation:"
echo "   1. Démarrez le serveur de développement"
echo "   2. Ouvrez http://localhost:8080/docs/api/"
echo ""
echo "📖 La documentation inclut:"
echo "   - Endpoints API disponibles"
echo "   - Schémas de données"
echo "   - Exemples de requêtes/réponses"
echo "   - Codes d'erreur"
