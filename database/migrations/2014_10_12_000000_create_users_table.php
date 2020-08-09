<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(User::NAME);
            $table->string(User::BIRTHDAY)->nullable();
            $table->integer(User::SEX)->nullable();
            $table->integer(User::HEIGHT)->nullable();
            $table->integer(User::WEIGHT)->nullable();
            $table->string(User::EMAIL)->unique()->nullable();
            $table->timestamp(User::EMAIL_VERIFIED_AT)->nullable();
            $table->string(User::PASSWORD)->nullable();
            $table->string(User::API_TOKEN, 80)->unique();
            $table->integer(User::ROLE)->default(config('role.patient.value'));
            $table->bigInteger(User::CLINIC_ID)->nullable();
            $table->rememberToken()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(User::TABLE_NAME);
    }
}
