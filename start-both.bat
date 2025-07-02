@echo off
echo ==============================================
echo  Lancement des environnements Dev et Prod
echo ==============================================

echo.
echo Arret de tous les conteneurs...
docker stop %*|docker ps -q% 2>nul

echo.
echo Nettoyage des environnements...
docker-compose -f docker-compose.dev.yml down
docker-compose -f docker-compose.prod.yml down

echo.
echo Lancement de l'environnement de developpement...
docker-compose -f docker-compose.dev.yml up -d

echo.
echo Lancement de l'environnement de production...
docker-compose -f docker-compose.prod.yml up -d

echo.
echo ==============================================
echo  Environnements lances avec succes !
echo ==============================================
echo  DEV  : http://localhost:8081
echo  PROD : http://localhost:8082
echo ==============================================
echo  DB DEV  : localhost:3308
echo  DB PROD : localhost:3309
echo ==============================================

docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"

pause
