# Guide de Test de l'Application Laravel - Yachad

## 🚀 Démarrage de l'Application

1. **Démarrer le serveur de développement :**
   ```bash
   php artisan serve
   ```
   L'application sera accessible sur : http://localhost:8000

2. **Alternative : Utiliser le script de développement complet :**
   ```bash
   composer run dev
   ```
   Ceci démarre le serveur, les workers de queue et Vite en parallèle.

## 👥 Comptes de Test Disponibles

L'application est livrée avec plusieurs comptes de test pré-configurés :

### 1. Administrateur
- **Email :** admin@devcollab.com
- **Mot de passe :** password123
- **Accès :** Dashboard admin, gestion des utilisateurs, projets, rapports

### 2. Développeur Senior
- **Email :** developer@devcollab.com
- **Mot de passe :** password123
- **Nom :** John Doe
- **Accès :** Dashboard développeur, gestion des tâches, profil, time tracking

### 3. Développeur Frontend
- **Email :** sarah@devcollab.com
- **Mot de passe :** password123
- **Nom :** Sarah Chen
- **Accès :** Dashboard développeur, gestion des tâches

### 4. Utilisateur Standard
- **Email :** user@devcollab.com
- **Mot de passe :** password123
- **Accès :** Dashboard utilisateur basique

## 🧪 Scénarios de Test

### 1. Test de la Page d'Accueil
1. Accédez à http://localhost:8000
2. Vérifiez que la page d'accueil s'affiche correctement
3. Testez les liens de navigation
4. Cliquez sur "Login" ou "Sign Up"

### 2. Test de l'Authentification
1. **Connexion :**
   - Cliquez sur "Login" dans la navigation
   - Entrez les identifiants d'un compte de test
   - Vérifiez la redirection vers le bon dashboard selon le rôle

2. **Inscription :**
   - Cliquez sur "Sign Up"
   - Créez un nouveau compte avec un rôle spécifique
   - Vérifiez la création du compte et la redirection

3. **Déconnexion :**
   - Une fois connecté, cliquez sur le bouton de déconnexion
   - Vérifiez la redirection vers la page d'accueil

### 3. Test du Dashboard Admin
1. Connectez-vous avec le compte admin
2. Vérifiez l'accès aux sections :
   - Vue d'ensemble avec statistiques
   - Gestion des utilisateurs
   - Gestion des projets
   - Rapports
   - Section développeurs

3. **Gestion des utilisateurs :**
   - Modifiez le rôle d'un utilisateur
   - Supprimez un utilisateur test

4. **Gestion des projets :**
   - Créez un nouveau projet
   - Assignez des développeurs
   - Modifiez le statut d'un projet

### 4. Test du Dashboard Développeur
1. Connectez-vous avec le compte développeur
2. Vérifiez l'accès aux sections :
   - Dashboard avec statistiques personnelles
   - Mes tâches
   - Profil
   - Time tracking
   - Rapports

3. **Gestion des tâches :**
   - Visualisez les tâches assignées
   - Changez le statut d'une tâche
   - Ajoutez des notes sur une tâche

4. **Profil développeur :**
   - Mettez à jour vos compétences
   - Ajoutez des liens (GitHub, LinkedIn, Portfolio)

### 5. Test des Fonctionnalités Communes
1. **Navigation :**
   - Testez tous les liens du menu
   - Vérifiez la cohérence de la navigation

2. **Responsive Design :**
   - Testez l'application sur différentes tailles d'écran
   - Vérifiez l'adaptation mobile

3. **Paramètres utilisateur :**
   - Accédez aux paramètres du profil
   - Changez le mot de passe
   - Mettez à jour les informations personnelles

## 🔍 Points de Vérification Importants

### Interface Utilisateur
- ✅ Toutes les pages se chargent sans erreur
- ✅ Les formulaires fonctionnent correctement
- ✅ Les messages d'erreur et de succès s'affichent
- ✅ La navigation est cohérente et intuitive
- ✅ Le design est responsive

### Fonctionnalités
- ✅ L'authentification fonctionne (login/logout)
- ✅ Les rôles et permissions sont respectés
- ✅ Les opérations CRUD sur les entités fonctionnent
- ✅ Les statistiques se mettent à jour correctement
- ✅ Les filtres et la pagination fonctionnent

### Performance
- ✅ Les pages se chargent rapidement
- ✅ Pas d'erreurs JavaScript dans la console
- ✅ Les requêtes AJAX/Livewire fonctionnent

## 🐛 Dépannage

### Problèmes Courants

1. **Erreur 500 :**
   - Vérifiez les logs : `tail -f storage/logs/laravel.log`
   - Videz le cache : `php artisan cache:clear`

2. **Assets non chargés :**
   - Compilez les assets : `npm run build`
   - Ou lancez le serveur de développement : `npm run dev`

3. **Base de données vide :**
   - Lancez les migrations : `php artisan migrate:fresh --seed`

4. **Connexion impossible :**
   - Vérifiez que le fichier `.env` existe
   - Assurez-vous que `APP_KEY` est défini

## 📊 Données de Test

L'application est pré-remplie avec :
- 4 utilisateurs de différents rôles
- Plusieurs projets avec différents statuts
- Des tâches assignées aux développeurs
- Des statistiques réalistes

## 🎯 Checklist Finale

- [ ] Page d'accueil accessible
- [ ] Connexion fonctionne pour tous les rôles
- [ ] Dashboard admin complet et fonctionnel
- [ ] Dashboard développeur complet et fonctionnel
- [ ] Création/modification/suppression d'entités
- [ ] Navigation fluide et sans erreur
- [ ] Interface responsive
- [ ] Déconnexion fonctionne
- [ ] Pas d'erreur dans la console JavaScript
- [ ] Performance acceptable

## 💡 Conseils

1. Testez d'abord avec les comptes existants avant de créer de nouveaux comptes
2. Explorez toutes les fonctionnalités de chaque rôle
3. Notez tout comportement inattendu
4. Vérifiez la console du navigateur pour les erreurs JavaScript
5. Testez sur différents navigateurs si possible

---

**Note :** Ce guide est conçu pour tester l'application en environnement de développement. Pour la production, des tests supplémentaires de sécurité et de performance seraient nécessaires.