<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Survey;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->bigInteger(Survey::EVENT_ID);
            $table->string(Survey::NAME);
            $table->integer(Survey::ROLE);
            $table->integer(Survey::SATISFACTION_LEVEL);
            $table->text(Survey::COMMENT)->nullable();
            $table->dateTime(Survey::CHECKED_AT)->nullable();
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
        Schema::dropIfExists('surveys');
    }
}
