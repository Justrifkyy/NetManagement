<?php

use Illuminate\Support\Facades\DB;

require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create a helper to add index safely
$addIndex = function($table, $column) {
    try {
        $indexName = $table . '_' . $column . '_index';
        DB::statement("CREATE INDEX {$indexName} ON {$table}({$column})");
        echo "[✓] Added index on {$table}.{$column}\n";
    } catch (\Exception $e) {
        if (str_contains($e->getMessage(), 'Duplicate')) {
            echo "[~] Index already exists on {$table}.{$column}\n";
        } else {
            echo "[✗] Error on {$table}.{$column}: " . $e->getMessage() . "\n";
        }
    }
};

echo "Adding performance indexes...\n\n";

// Add missing indexes
$addIndex('leads', 'status');
$addIndex('leads', 'marketing_id');
$addIndex('tickets', 'status');
$addIndex('tickets', 'customer_id');
$addIndex('invoices', 'status');
$addIndex('invoices', 'subscription_id');
$addIndex('subscriptions', 'customer_id');
$addIndex('subscriptions', 'status');
$addIndex('customers', 'user_id');
$addIndex('sessions', 'last_activity');
$addIndex('audit_logs', 'user_id');

echo "\n✓ Indexes migration complete!\n";
