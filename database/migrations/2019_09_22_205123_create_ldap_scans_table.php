<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLdapScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ldap_scans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->timestamp('started_at');
            $table->timestamp('completed_at');
            $table->unsignedInteger('domain_id');
            $table->boolean('success')->default(false);
            $table->integer('total_synchronized')->default(0);
            $table->text('synchronized')->nullable();
            $table->text('exception')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ldap_scans');
    }
}
