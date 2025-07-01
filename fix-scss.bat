@echo off
echo === Correction automatique des erreurs SCSS ===

echo 🔧 Correction des media queries...
powershell -Command "Get-ChildItem style\*.scss | ForEach-Object { (Get-Content $_.FullName) -replace 'screen and\(', 'screen and (' | Set-Content $_.FullName }"

echo 🔧 Correction des propriétés CSS...
powershell -Command "Get-ChildItem style\*.scss | ForEach-Object { (Get-Content $_.FullName) -replace 'moz-box-shadow', '-moz-box-shadow' | Set-Content $_.FullName }"
powershell -Command "Get-ChildItem style\*.scss | ForEach-Object { (Get-Content $_.FullName) -replace 'webkit-box-shadow', '-webkit-box-shadow' | Set-Content $_.FullName }"
powershell -Command "Get-ChildItem style\*.scss | ForEach-Object { (Get-Content $_.FullName) -replace 'fond-size', 'font-size' | Set-Content $_.FullName }"

echo 🔧 Correction des media queries complexes...
powershell -Command "Get-ChildItem style\*.scss | ForEach-Object { (Get-Content $_.FullName) -replace 'min-width: ([0-9]+px)\) and\(max-width', 'min-width: $1) and (max-width' | Set-Content $_.FullName }"

echo ✅ Corrections appliquées !
echo 🔄 Compilation du SCSS...

sass style\main.scss public\css\style.css --style=expanded

if %errorlevel% equ 0 (
    echo ✅ Compilation SCSS réussie !
) else (
    echo ❌ Erreur de compilation SCSS
    pause
    exit /b 1
)

echo 🎨 CSS généré avec succès dans public\css\style.css
pause
