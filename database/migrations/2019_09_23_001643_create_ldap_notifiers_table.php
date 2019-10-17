<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLdapNotifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ldap_notifiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->morphs('notifiable');
            $table->string('notifiable_name');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('system')->default(false);
            $table->boolean('enabled')->default(false);
            $table->boolean('all_users')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ldap_notifiers');
    }
}
