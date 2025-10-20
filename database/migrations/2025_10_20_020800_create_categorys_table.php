<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // id kategori
            $table->string('name', 100); // nama kategori
            $table->enum('type', ['income', 'expense']); // jenis kategori (pemasukan/pengeluaran)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // admin pembuat kategori
            $table->timestamps(); // created_at & updated_at
        });

        // (Opsional) Jika kamu masih menggunakan sistem modules & permissions
        $actions = [
            'index' => 'admin.category.index',
            'create' => 'admin.category.create',
            'edit' => 'admin.category.edit',
            'delete' => 'admin.category.destroy',
        ];

        DB::table('modules')->insert([
            'name' => 'categories',
            'actions' => json_encode($actions),
        ]);

        $permissions = array_map(function ($action) {
            return [
                'name' => $action,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $actions);

        DB::table('permissions')->insert($permissions);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};