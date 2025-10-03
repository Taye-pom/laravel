<?php

// Script pour créer rapidement un nouvel utilisateur
// Usage: php scripts/create-user.php

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Developer;
use Illuminate\Support\Facades\Hash;

echo "\n🚀 Création d'un nouvel utilisateur\n";
echo "==================================\n\n";

// Demander les informations
echo "Nom complet: ";
$name = trim(fgets(STDIN));

echo "Email: ";
$email = trim(fgets(STDIN));

echo "Mot de passe (min 6 caractères): ";
$password = trim(fgets(STDIN));

echo "Rôle (admin/developer/user/project_manager): ";
$role = trim(fgets(STDIN));

// Valider le rôle
$validRoles = ['admin', 'developer', 'user', 'project_manager'];
if (!in_array($role, $validRoles)) {
    echo "❌ Rôle invalide. Les rôles valides sont: " . implode(', ', $validRoles) . "\n";
    exit(1);
}

try {
    // Créer l'utilisateur
    $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
        'role' => $role,
    ]);

    // Si c'est un développeur, créer son profil
    if ($role === 'developer') {
        echo "\n📝 Configuration du profil développeur\n";
        
        echo "Titre (ex: Full Stack Developer): ";
        $title = trim(fgets(STDIN));
        
        echo "Niveau d'expérience (Junior/Mid-Level/Senior): ";
        $experience = trim(fgets(STDIN));
        
        echo "Compétences (séparées par des virgules): ";
        $skills = trim(fgets(STDIN));
        
        Developer::create([
            'user_id' => $user->id,
            'title' => $title ?: 'Developer',
            'experience_level' => $experience ?: 'Junior',
            'skills' => $skills ?: '',
            'bio' => '',
            'rating' => 0,
            'active_tasks' => 0,
            'completed_projects' => 0,
            'hours_logged' => 0,
        ]);
    }

    echo "\n✅ Utilisateur créé avec succès!\n";
    echo "📧 Email: {$user->email}\n";
    echo "👤 Rôle: {$user->role}\n";
    echo "\n🔐 Connexion: http://localhost:8000/login\n";

} catch (Exception $e) {
    echo "\n❌ Erreur lors de la création: " . $e->getMessage() . "\n";
    exit(1);
}