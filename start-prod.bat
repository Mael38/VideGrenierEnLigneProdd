@echo off
echo === Demarrage de l'environnement de PRODUCTION Vide Grenier en Ligne ===
echo Port: 80
echo Base de donnees: port 3306
echo.

REM Verification que Docker est installe
docker --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker n'est pas installe ou n'est pas dans le PATH
    pause
    exit /b 1
)

REM Verification que Docker Compose est installe
docker-compose --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker Compose n'est pas installe ou n'est pas dans le PATH
    pause
    exit /b 1
)

REM Arret des conteneurs existants (au cas ou)
echo 🔄 Arret des conteneurs existants...
docker-compose -f docker-compose.prod.yml down

REM Construction et demarrage des conteneurs
echo 🚀 Construction et demarrage des conteneurs de production...
docker-compose -f docker-compose.prod.yml up --build -d

REM Attendre que les services soient prets
echo ⏳ Attente du demarrage des services...
timeout /t 10 /nobreak >nul

REM Verification du statut des conteneurs
echo 📋 Statut des conteneurs:
docker-compose -f docker-compose.prod.yml ps

echo.
echo === Environnement de PRODUCTION demarre ===
echo 🌐 Application: http://localhost
echo 🗄️  Base de donnees: localhost:3306
echo.
echo 📝 Commandes utiles:
echo    Voir les logs: docker-compose -f docker-compose.prod.yml logs -f
echo    Arreter: docker-compose -f docker-compose.prod.yml down
echo    Redemarrer: docker-compose -f docker-compose.prod.yml restart
echo.
pause
