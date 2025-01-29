<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact')->nullable()->after('email');
            $table->string('company')->nullable()->after('contact');
            $table->string('country')->nullable()->after('company');
            $table->string('role')->default('subscriber')->after('country');
            $table->string('plan')->default('basic')->after('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['contact', 'company', 'country', 'role', 'plan']);
        });
    }
};
