# 🚀 Guide de Déploiement - Yachad

## 📋 Prérequis pour la Production

- Serveur Linux (Ubuntu/Debian recommandé)
- PHP 8.2+ avec extensions : BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- Composer
- Node.js 18+ et npm
- Nginx ou Apache
- MySQL 8.0+ ou PostgreSQL 13+
- Supervisor (pour les queues)
- Redis (optionnel, pour le cache)

## 🔧 Étapes de Déploiement

### 1. Préparation du Serveur

```bash
# Mettre à jour le système
sudo apt update && sudo apt upgrade -y

# Installer les dépendances
sudo apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd
sudo apt install -y nginx mysql-server composer nodejs npm git supervisor redis-server
```

### 2. Configuration de la Base de Données

```bash
# Se connecter à MySQL
sudo mysql -u root -p

# Créer la base de données et l'utilisateur
CREATE DATABASE yachad_production;
CREATE USER 'yachad_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON yachad_production.* TO 'yachad_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Déployer le Code

```bash
# Cloner le repository
cd /var/www
sudo git clone [votre-repo] yachad
sudo chown -R www-data:www-data yachad
cd yachad

# Installer les dépendances
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data npm install
sudo -u www-data npm run build
```

### 4. Configuration de l'Environnement

```bash
# Copier et éditer le fichier .env
sudo -u www-data cp .env.example .env
sudo -u www-data nano .env
```

Modifier les variables suivantes dans `.env` :
```env
APP_NAME=Yachad
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yachad_production
DB_USERNAME=yachad_user
DB_PASSWORD=strong_password_here

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

MAIL_MAILER=smtp
MAIL_HOST=votre-serveur-smtp
MAIL_PORT=587
MAIL_USERNAME=votre-email
MAIL_PASSWORD=votre-mot-de-passe
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@votre-domaine.com
```

### 5. Finaliser l'Installation

```bash
# Générer la clé d'application
sudo -u www-data php artisan key:generate

# Exécuter les migrations
sudo -u www-data php artisan migrate --force

# Seed initial (optionnel - seulement pour les données de démonstration)
# sudo -u www-data php artisan db:seed --force

# Optimiser l'application
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan optimize

# Créer le lien symbolique pour le storage
sudo -u www-data php artisan storage:link
```

### 6. Configuration Nginx

Créer le fichier `/etc/nginx/sites-available/yachad` :

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/yachad/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Activer le site :
```bash
sudo ln -s /etc/nginx/sites-available/yachad /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 7. Configuration SSL avec Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d votre-domaine.com
```

### 8. Configuration Supervisor pour les Queues

Créer `/etc/supervisor/conf.d/yachad-worker.conf` :

```ini
[program:yachad-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/yachad/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/yachad/storage/logs/worker.log
stopwaitsecs=3600
```

Activer :
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start yachad-worker:*
```

### 9. Configuration du Cron

Ajouter au crontab :
```bash
sudo crontab -e -u www-data
```

Ajouter :
```cron
* * * * * cd /var/www/yachad && php artisan schedule:run >> /dev/null 2>&1
```

### 10. Permissions Finales

```bash
# S'assurer que les permissions sont correctes
sudo chown -R www-data:www-data /var/www/yachad
sudo chmod -R 755 /var/www/yachad
sudo chmod -R 775 /var/www/yachad/storage
sudo chmod -R 775 /var/www/yachad/bootstrap/cache
```

## 🔒 Sécurité Additionnelle

1. **Firewall**
   ```bash
   sudo ufw allow 22/tcp
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw enable
   ```

2. **Fail2ban**
   ```bash
   sudo apt install fail2ban
   ```

3. **Monitoring**
   - Installer New Relic ou Datadog
   - Configurer les alertes

## 📊 Maintenance

### Mise à jour de l'Application

```bash
cd /var/www/yachad
sudo -u www-data git pull origin main
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data npm install && npm run build
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan queue:restart
```

### Backup de la Base de Données

```bash
# Script de backup quotidien
mysqldump -u yachad_user -p yachad_production | gzip > /backup/yachad_$(date +%Y%m%d).sql.gz
```

### Monitoring des Logs

```bash
# Logs Laravel
tail -f /var/www/yachad/storage/logs/laravel.log

# Logs Nginx
tail -f /var/log/nginx/error.log

# Logs des workers
tail -f /var/www/yachad/storage/logs/worker.log
```

## 🚨 Troubleshooting

### Erreur 500
1. Vérifier les permissions : `sudo chown -R www-data:www-data /var/www/yachad`
2. Vérifier les logs : `tail -f storage/logs/laravel.log`
3. Régénérer le cache : `php artisan config:clear && php artisan config:cache`

### Problèmes de Performance
1. Activer OPcache dans PHP
2. Configurer Redis correctement
3. Optimiser les requêtes avec le debugbar en développement

### Livewire ne fonctionne pas
1. Vérifier que les assets sont compilés : `npm run build`
2. Vérifier la configuration HTTPS
3. Nettoyer le cache Livewire : `php artisan livewire:clear`

## ✅ Checklist de Déploiement

- [ ] Serveur configuré avec PHP 8.2+
- [ ] Base de données créée et configurée
- [ ] Code déployé et permissions correctes
- [ ] Fichier .env configuré pour la production
- [ ] Migrations exécutées
- [ ] Assets compilés
- [ ] Nginx configuré et SSL activé
- [ ] Supervisor configuré pour les queues
- [ ] Cron configuré
- [ ] Backup automatique configuré
- [ ] Monitoring en place
- [ ] Tests de production passés

---

**Note :** Ce guide assume un déploiement sur Ubuntu/Debian. Adaptez selon votre environnement.