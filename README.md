# 🚀 Yachad - Plateforme de Collaboration pour Développeurs

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![Livewire](https://img.shields.io/badge/Livewire-3.x-pink)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

Yachad est une plateforme moderne de gestion de projets et de collaboration conçue spécifiquement pour les équipes de développement. Elle offre une interface intuitive pour gérer les projets, assigner des tâches, suivre le temps et faciliter la collaboration entre développeurs.

## ✨ Fonctionnalités Principales

- **🔐 Système d'authentification multi-rôles** (Admin, Développeur, Chef de projet, Utilisateur)
- **📊 Tableaux de bord personnalisés** selon le rôle
- **📋 Gestion complète des projets** avec statuts et priorités
- **✅ Système de tâches** avec assignation et suivi
- **⏱️ Time tracking** pour les développeurs
- **👥 Gestion des profils développeurs** avec compétences et évaluations
- **📈 Rapports et statistiques** en temps réel
- **🎨 Interface moderne et responsive** avec Bootstrap 5

## 🛠️ Technologies Utilisées

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Livewire 3, Blade, Bootstrap 5, Vite
- **Base de données:** SQLite (développement), MySQL/PostgreSQL (production)
- **Icons:** FontAwesome 7
- **Tests:** Pest PHP

## 📦 Installation Rapide

### Prérequis
- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- SQLite (pour le développement)

### Étapes d'installation

1. **Cloner le repository**
   ```bash
   git clone [votre-repo]
   cd laravel
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   npm install
   ```

3. **Configuration de l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Initialiser la base de données**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Compiler les assets**
   ```bash
   npm run build
   ```

6. **Démarrer l'application**
   ```bash
   php artisan serve
   ```

   Ou utiliser le script de développement complet :
   ```bash
   composer run dev
   ```

## 👥 Comptes de Démonstration

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@devcollab.com | password123 |
| Développeur Senior | developer@devcollab.com | password123 |
| Développeur Frontend | sarah@devcollab.com | password123 |
| Utilisateur | user@devcollab.com | password123 |

## 🚀 Scripts Utilitaires

### Réinitialiser l'application
```bash
./scripts/reset-app.sh
```

### Vérifier la santé de l'application
```bash
php scripts/health-check.php
```

### Créer un nouvel utilisateur
```bash
php scripts/create-user.php
```

## 📚 Documentation

- [Guide de Test Complet](GUIDE_TEST_APPLICATION.md)
- [Rapport d'État](RAPPORT_FINAL.md)

## 🧪 Tests

Exécuter tous les tests :
```bash
php artisan test
```

Tests en parallèle :
```bash
php artisan test --parallel
```

## 📁 Structure du Projet

```
laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Livewire/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── js/
│   └── css/
├── routes/
├── scripts/          # Scripts utilitaires
└── tests/
```

## 🔧 Configuration Production

Pour déployer en production :

1. Configurer les variables d'environnement appropriées
2. Utiliser MySQL ou PostgreSQL
3. Activer le cache : `php artisan config:cache`
4. Optimiser : `php artisan optimize`
5. Configurer HTTPS et les certificats SSL

## 🐛 Dépannage

### Problèmes courants

**Erreur 500 :**
- Vérifier les logs : `tail -f storage/logs/laravel.log`
- Nettoyer le cache : `php artisan cache:clear`

**Assets non chargés :**
- Recompiler : `npm run build`

**Base de données vide :**
- Réinitialiser : `php artisan migrate:fresh --seed`

## 🤝 Contribution

Les contributions sont les bienvenues ! Veuillez suivre ces étapes :

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 License

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👏 Remerciements

- Laravel Team pour le framework extraordinaire
- Livewire Team pour l'interactivité sans JavaScript
- La communauté open source

---

**Développé avec ❤️ pour des équipes qui construisent ensemble**