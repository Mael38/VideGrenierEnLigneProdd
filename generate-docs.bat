@echo off
echo === Generation de la documentation API Vide Grenier en Ligne ===

REM Verification que les dependances sont installees
if not exist "vendor\bin\openapi" (
    echo ❌ OpenAPI Generator non trouve. Installation des dependances...
    composer install
)

REM Creation du repertoire docs s'il n'existe pas
if not exist "docs\api" mkdir docs\api

REM Copie du fichier OpenAPI existant
if exist "docs\api\openapi.yaml" (
    echo ✅ Utilisation du fichier OpenAPI existant
) else (
    echo ❌ Fichier OpenAPI non trouve
    pause
    exit /b 1
)

REM Generation de la documentation HTML avec Swagger UI
echo 🔄 Generation de la documentation HTML...

(
echo ^<!DOCTYPE html^>
echo ^<html lang="fr"^>
echo ^<head^>
echo     ^<meta charset="UTF-8"^>
echo     ^<meta name="viewport" content="width=device-width, initial-scale=1.0"^>
echo     ^<title^>API Documentation - Vide Grenier en Ligne^</title^>
echo     ^<link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui.css" /^>
echo     ^<style^>
echo         html {
echo             box-sizing: border-box;
echo             overflow: -moz-scrollbars-vertical;
echo             overflow-y: scroll;
echo         }
echo         *, *:before, *:after {
echo             box-sizing: inherit;
echo         }
echo         body {
echo             margin:0;
echo             background: #fafafa;
echo         }
echo     ^</style^>
echo ^</head^>
echo ^<body^>
echo     ^<div id="swagger-ui"^>^</div^>
echo     ^<script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-bundle.js"^>^</script^>
echo     ^<script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-standalone-preset.js"^>^</script^>
echo     ^<script^>
echo         window.onload = function^(^) {
echo             const ui = SwaggerUIBundle^({
echo                 url: './openapi.yaml',
echo                 dom_id: '#swagger-ui',
echo                 deepLinking: true,
echo                 presets: [
echo                     SwaggerUIBundle.presets.apis,
echo                     SwaggerUIStandalonePreset
echo                 ],
echo                 plugins: [
echo                     SwaggerUIBundle.plugins.DownloadUrl
echo                 ],
echo                 layout: "StandaloneLayout",
echo                 validatorUrl: null
echo             }^);
echo         };
echo     ^</script^>
echo ^</body^>
echo ^</html^>
) > docs\api\index.html

echo.
echo ✅ Documentation generee avec succes !
echo 📁 Fichiers generes:
echo    - docs\api\openapi.yaml ^(Specification OpenAPI^)
echo    - docs\api\index.html ^(Interface Swagger UI^)
echo.
echo 🌐 Pour visualiser la documentation:
echo    1. Demarrez le serveur de developpement
echo    2. Ouvrez http://localhost:8080/docs/api/
echo.
echo 📖 La documentation inclut:
echo    - Endpoints API disponibles
echo    - Schemas de donnees
echo    - Exemples de requetes/reponses
echo    - Codes d'erreur
echo.
pause
