<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('p_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Role::class)
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade');

            $table->foreignIdFor(Permission::class)
                ->references('id')
                ->on('permissions')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_role_permissions');
    }
};
