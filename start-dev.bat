@echo off
echo 🚀 Démarrage de l'environnement de développement Vide Grenier En Ligne
echo ======================================================================

REM Vérification de la branche courante
for /f "tokens=*" %%i in ('git branch --show-current') do set current_branch=%%i
if not "%current_branch%"=="develop" (
    echo ⚠️  Attention: Vous n'êtes pas sur la branche 'develop' ^(branche actuelle: %current_branch%^)
    set /p confirm="Voulez-vous continuer? (y/N) "
    if /i not "%confirm%"=="y" exit /b 1
)

REM Arrêt des containers existants
echo 📦 Arrêt des containers existants...
docker-compose -f docker-compose.dev.yml down

REM Construction et démarrage des containers
echo 🔨 Construction et démarrage des containers de développement...
docker-compose -f docker-compose.dev.yml up --build -d

REM Attendre que la base de données soit prête
echo ⏳ Attente de la base de données...
timeout /t 10 /nobreak

REM Installation des dépendances si nécessaire
echo 📚 Installation des dépendances...
docker-compose -f docker-compose.dev.yml exec dev_web composer install

REM Vérification que les services sont bien démarrés
echo ✅ Vérification des services...
docker-compose -f docker-compose.dev.yml ps

echo.
echo 🎉 Environnement de développement démarré avec succès!
echo 🌐 Application accessible sur: http://localhost:8081
echo 🗄️  Base de données accessible sur: localhost:3308
echo 📋 Pour voir les logs: docker-compose -f docker-compose.dev.yml logs -f
echo 🛑 Pour arrêter: docker-compose -f docker-compose.dev.yml down
echo.
