#!/bin/bash

# Script pour réinitialiser l'application Laravel
# Usage: ./scripts/reset-app.sh

echo "🔄 Réinitialisation de l'application Laravel..."

# Nettoyer les caches
echo "📦 Nettoyage des caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Réinitialiser la base de données
echo "🗄️  Réinitialisation de la base de données..."
php artisan migrate:fresh --seed

# Régénérer les clés et optimiser
echo "🔑 Optimisation de l'application..."
php artisan key:generate
php artisan config:cache
php artisan route:cache

# Recompiler les assets
echo "🎨 Compilation des assets..."
npm run build

echo "✅ Application réinitialisée avec succès!"
echo "🚀 Vous pouvez démarrer avec: php artisan serve"