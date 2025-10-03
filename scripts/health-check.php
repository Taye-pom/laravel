<?php

// Script de vérification de santé de l'application
// Usage: php scripts/health-check.php

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

echo "\n🏥 Vérification de santé de l'application\n";
echo "=========================================\n\n";

$checks = [];

// 1. Vérifier la connexion à la base de données
try {
    DB::connection()->getPdo();
    $checks['database'] = ['status' => '✅', 'message' => 'Base de données connectée'];
} catch (Exception $e) {
    $checks['database'] = ['status' => '❌', 'message' => 'Erreur de connexion: ' . $e->getMessage()];
}

// 2. Vérifier les tables essentielles
$requiredTables = ['users', 'projects', 'tasks', 'developers', 'migrations'];
foreach ($requiredTables as $table) {
    if (DB::getSchemaBuilder()->hasTable($table)) {
        $checks["table_$table"] = ['status' => '✅', 'message' => "Table '$table' existe"];
    } else {
        $checks["table_$table"] = ['status' => '❌', 'message' => "Table '$table' manquante"];
    }
}

// 3. Vérifier les statistiques
try {
    $stats = [
        'users' => User::count(),
        'admins' => User::where('role', 'admin')->count(),
        'developers' => User::where('role', 'developer')->count(),
        'projects' => Project::count(),
        'tasks' => Task::count(),
    ];
    
    $checks['stats'] = [
        'status' => '📊', 
        'message' => sprintf(
            "Utilisateurs: %d | Admins: %d | Développeurs: %d | Projets: %d | Tâches: %d",
            $stats['users'],
            $stats['admins'],
            $stats['developers'],
            $stats['projects'],
            $stats['tasks']
        )
    ];
} catch (Exception $e) {
    $checks['stats'] = ['status' => '❌', 'message' => 'Erreur lors du calcul des statistiques'];
}

// 4. Vérifier les fichiers importants
$requiredFiles = [
    '.env' => 'Configuration environnement',
    'database/database.sqlite' => 'Base de données SQLite',
    'public/build/manifest.json' => 'Assets compilés',
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists(__DIR__ . '/../' . $file)) {
        $checks[$file] = ['status' => '✅', 'message' => "$description présent"];
    } else {
        $checks[$file] = ['status' => '❌', 'message' => "$description manquant"];
    }
}

// 5. Vérifier la configuration
$appKey = config('app.key');
if (!empty($appKey)) {
    $checks['app_key'] = ['status' => '✅', 'message' => 'Clé d\'application configurée'];
} else {
    $checks['app_key'] = ['status' => '❌', 'message' => 'Clé d\'application manquante'];
}

// Afficher les résultats
echo "📋 Résultats de la vérification:\n";
echo "--------------------------------\n";
foreach ($checks as $check => $result) {
    echo $result['status'] . " " . $result['message'] . "\n";
}

// Résumé
$errors = array_filter($checks, fn($check) => $check['status'] === '❌');
$errorCount = count($errors);

echo "\n" . str_repeat('=', 40) . "\n";
if ($errorCount === 0) {
    echo "✅ L'application est en bonne santé!\n";
} else {
    echo "⚠️  {$errorCount} problème(s) détecté(s)\n";
    echo "\nPour corriger, exécutez:\n";
    echo "  ./scripts/reset-app.sh\n";
}
echo str_repeat('=', 40) . "\n\n";