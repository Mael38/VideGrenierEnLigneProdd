#!/bin/bash

echo "=== Correction automatique des erreurs SCSS ==="

# Correction des media queries sans espace
echo "🔧 Correction des media queries..."
find style/ -name "*.scss" -exec sed -i 's/screen and(/screen and (/g' {} \;

# Correction des propriétés CSS incorrectes
echo "🔧 Correction des propriétés CSS..."
find style/ -name "*.scss" -exec sed -i 's/moz-box-shadow/-moz-box-shadow/g' {} \;
find style/ -name "*.scss" -exec sed -i 's/webkit-box-shadow/-webkit-box-shadow/g' {} \;
find style/ -name "*.scss" -exec sed -i 's/fond-size/font-size/g' {} \;

# Correction des media queries avec min-width et max-width
echo "🔧 Correction des media queries complexes..."
find style/ -name "*.scss" -exec sed -i 's/min-width: \([0-9]*px\)) and(max-width/min-width: \1) and (max-width/g' {} \;

echo "✅ Corrections appliquées !"
echo "🔄 Compilation du SCSS..."

# Compilation du SCSS
sass style/main.scss public/css/style.css --style=expanded

if [ $? -eq 0 ]; then
    echo "✅ Compilation SCSS réussie !"
else
    echo "❌ Erreur de compilation SCSS"
    exit 1
fi

echo "🎨 CSS généré avec succès dans public/css/style.css"
