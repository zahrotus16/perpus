<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

$defaults = [
    'app_name' => 'DigiLib',
    'app_logo' => null,
    'loan_limit' => '3',
    'fine_per_day' => '1000',
];

foreach ($defaults as $key => $value) {
    Setting::updateOrCreate(['key' => $key], ['value' => $value]);
}

echo "Settings seeded successfully.";
