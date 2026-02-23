<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Bootstrap the application so we can use Eloquent
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\TblUser;

try {
    $count = TblUser::count();
    echo "tblusers count: " . $count . PHP_EOL;
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
