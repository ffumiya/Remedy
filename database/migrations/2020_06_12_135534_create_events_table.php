<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Events object reference from https://fullcalendar.io/docs/event-object;
        Schema::create(Event::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements(Event::ID);
            $table->string(Event::EVENT_ID);
            $table->bigInteger(Event::HOST_ID)->nullable(); // 医師
            $table->bigInteger(Event::GUEST_ID)->nullable(); //患者
            $table->string(Event::GROUP_ID)->default(""); // 子ID
            $table->boolean(Event::ALL_DAY)->default(false); // 終日
            $table->timestamp(Event::START)->nullable(); //開始時間
            $table->timestamp(Event::DESIRED_TIME)->nullable(); //希望開始時間
            $table->timestamp(Event::END)->nullable(); //終了時間
            $table->string(Event::TITLE);
            $table->string(Event::URL)->default("");
            $table->string(Event::CLASS_NAMES)->nullable();
            $table->boolean(Event::EDITABLE)->default(true);
            $table->boolean(Event::START_EDITABLE)->default(true);
            $table->boolean(Event::DURATION_EDITABLE)->default(true);
            $table->boolean(Event::RESOURCE_EDITABLE)->default(true);
            $table->string(Event::RENDERING)->nullable();
            $table->boolean(Event::OVERLAP)->default(true); // 禁止期間
            $table->string(Event::CONSTRAIT)->nullable(); // 親ID
            $table->string(Event::COLOR)->nullable();
            $table->string(Event::BACKGROUND_COLOR)->nullable();
            $table->string(Event::BORDER_COLOR)->nullable();
            $table->string(Event::TEXT_COLOR)->nullable();
            $table->bigInteger(Event::EXTENDED_PROPS)->nullable();
            $table->string(Event::SOURCE)->nullable();
            $table->bigInteger(Event::PRICE)->default(0);
            $table->string(Event::PAYMENT_METHOD_ID)->nullable();
            $table->string(Event::ZOOM_START_URL)->nullable();
            $table->string(Event::ZOOM_JOIN_URL)->nullable();
            $table->string(Event::ZOOM_START_PASSWORD)->nullable();
            $table->string(Event::ZOOM_JOIN_PASSWORD)->nullable();
            $table->string(Event::SURVEY_TOKEN)->nullable();
            $table->timestamp(Event::SURVEY_RECEIVED_AT)->nullable();
            $table->timestamp(Event::SURVEY_CHECKED_AT)->nullable();
            $table->integer(Event::SURVEY_SATISFACTION_LEVEL)->nullable();
            $table->text(Event::SURVEY_COMMENT_1)->nullable();
            $table->text(Event::SURVEY_COMMENT_2)->nullable();
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
        Schema::dropIfExists(Event::TABLE_NAME);
    }
}
