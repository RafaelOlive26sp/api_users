<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('privilege_id')->default(3)
                    ->constrained('access_privileges')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       if (Schema::hasColumn('users', 'privilege_id')) {
           Schema::table('users', function (Blueprint $table) {
               $table->dropForeign('users_privilege_id_foreign');
               $table->dropColumn('privilege_id');
           });
       }
    }
};
