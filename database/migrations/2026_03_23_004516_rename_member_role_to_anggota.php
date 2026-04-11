<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add 'anggota' to the enum possibilities first
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'member', 'anggota', 'petugas', 'kepala') NOT NULL DEFAULT 'member'");
        
        // 2. Update existing 'member' records to 'anggota'
        DB::table('users')->where('role', 'member')->update(['role' => 'anggota']);
        
        // 3. Remove 'member' from the enum and set 'anggota' as default
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'anggota', 'petugas', 'kepala') NOT NULL DEFAULT 'anggota'");
    }

    public function down(): void
    {
        // 1. Add back 'member' to enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'member', 'anggota', 'petugas', 'kepala') NOT NULL DEFAULT 'anggota'");
        
        // 2. Revert records
        DB::table('users')->where('role', 'anggota')->update(['role' => 'member']);
        
        // 3. Remove 'anggota' from enum and set 'member' as default
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'member', 'petugas', 'kepala') NOT NULL DEFAULT 'member'");
    }
};
