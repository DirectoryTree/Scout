<?php

use App\LdapConnection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLdapConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ldap_connections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->unique();
            $table->string('username');
            $table->string('password');
            $table->string('hosts');
            $table->string('base_dn');
            $table->integer('port')->default(389);
            $table->integer('timeout')->default(5);
            $table->boolean('use_tls');
            $table->boolean('use_ssl');
            $table->boolean('follow_referrals')->default(false);

            $table->tinyInteger('status')->default(LdapConnection::STATUS_OFFLINE);
            $table->tinyInteger('type')->default(LdapConnection::TYPE_ACTIVE_DIRECTORY);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ldap_connections');
    }
}
