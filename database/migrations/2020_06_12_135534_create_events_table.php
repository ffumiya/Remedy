<?php

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
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('event_id');
            $table->string('id');
            $table->bigInteger('host_id'); // 開催者(医療機関)
            $table->bigInteger('guest_id')->nullable(); //患者
            $table->string('groupId')->default(""); // 子ID
            $table->boolean('allDay')->default(false); // 終日
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->string('title');
            $table->string('url')->default("");
            $table->string('classNames')->nullable();
            $table->boolean('editable')->default(true);
            $table->boolean('startEditable')->default(true);
            $table->boolean('durationEditable')->default(true);
            $table->boolean('resourceEditable')->default(true);
            $table->string('rendering')->nullable();
            $table->boolean('overlap')->default(true); // 禁止期間
            $table->string('constrait')->nullable(); // 親ID
            $table->string('color')->nullable();
            $table->string('backgroundColor')->nullable();
            $table->string('borderColor')->nullable();
            $table->string('textColor')->nullable();
            $table->bigInteger('extendedProps')->nullable();
            $table->string('source')->nullable();
            $table->bigInteger('price')->default(0);
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('events');
    }
}
