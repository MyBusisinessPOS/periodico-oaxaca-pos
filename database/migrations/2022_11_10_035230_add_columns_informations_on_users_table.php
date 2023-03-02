<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInformationsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
            $table->string('phone', 15)->nullable()->after('last_name');
            $table->string('business_name')->nullable()->after('remember_token');
            $table->string('address')->nullable()->after('business_name');
            $table->string('address_2')->nullable()->after('address');
            $table->string('state')->nullable()->after('address_2');
            $table->string('city')->nullable()->after('state');
            $table->string('postal_code')->nullable()->after('city');
            $table->softDeletes()->after('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('address_2');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
            $table->dropSoftDeletes();
        });
    }
}
