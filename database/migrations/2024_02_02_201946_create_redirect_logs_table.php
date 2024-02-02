<?php

// database/migrations/2022_01_31_000000_create_redirect_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectLogsTable extends Migration
{
    public function up()
    {
        Schema::create('redirect_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('redirect_id')->constrained('testbd');
            $table->ipAddress('ip');
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->json('query_params')->nullable();
            $table->timestamp('access_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('redirect_logs');
    }
}

