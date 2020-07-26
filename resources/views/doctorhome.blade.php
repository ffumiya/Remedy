@extends('layouts.app')

@section('content')
<div id='external-events'>
    <p>
        <strong>Draggable Events</strong>
    </p>

    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>My Event 1</div>
    </div>
    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>My Event 2</div>
    </div>
    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>My Event 3</div>
    </div>
    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>My Event 4</div>
    </div>
    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
        <div class='fc-event-main'>My Event 5</div>
    </div>

    <p>
        <input type='checkbox' id='drop-remove' />
        <label for='drop-remove'>remove after drop</label>
    </p>
</div>

<div id='calendar-container'>
    <div id='calendar'></div>
</div>
@endsection

@section('style')
<link href='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css' rel='stylesheet' />
<style>
    html,
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        font-size: 14px;
    }

    #external-events {
        position: fixed;
        z-index: 2;
        top: 20px;
        left: 20px;
        width: 150px;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #eee;
    }

    #external-events .fc-event {
        cursor: move;
        margin: 3px 0;
    }

    #calendar-container {
        position: relative;
        z-index: 1;
        margin-left: 200px;
    }

    #calendar {
        max-width: 1100px;
        margin: 20px auto;
    }
</style>
@endsection

@section('script')
<script src='https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/list@4.3.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/core/locales/ja'></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById("external-events");
    var calendarEl = document.getElementById("calendar");
    var checkbox = document.getElementById("drop-remove");

    // initialize the external events
    new Draggable(containerEl, {
    itemSelector: ".fc-event",
    eventData: function(eventEl) {
    return {
    title: eventEl.innerText
    };
    }
    });

    // initialize the calendar
    var calendar = new Calendar(calendarEl, {
    plugins: ["interaction", "dayGrid", "timeGrid", "list"],
    header: {
    left: "prev,next today",
    center: "title",
    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
    },
    allDaySlot: true,
    forceEventDuration: true,
    eventColor: "lavender",
    defaultTimedEventDuration: "00:30",
    defaultView: "timeGridWeek",
    slotDuration: "00:10:00",
    minTime: "9:00",
    maxTime: "19:00",
    locale: "jaLocale",
    editable: true,
    selectable: true,
    droppable: true, // this allows things to be dropped onto the calendar
    buttonText: {
    today: "今日",
    month: "月",
    week: "週",
    day: "日",
    list: "リスト"
    },

    events: "/admin/events/source",

    select: function(info) {
    // カレンダーセルクリック、範囲指定された時のコールバック
    console.log("select");
    },

    eventReceive: function(info) {
    // イベントがexternal-eventからドロップされた時のコールバック
    console.log("eventReceive");
    },

    eventDrop: function(info) {
    // イベントがドロップされた時のコールバック
    console.log("eventDrop");
    },

    eventResize: function(info) {
    // イベントがリサイズ（引っ張ったり縮めたり）された時のコールバック
    console.log("eventResize");
    },

    eventRender: function(info) {
    //wired listener to handle click counts instead of event type
    info.el.addEventListener("click", function() {
    clickCnt++;
    if (clickCnt === 1) {
    oneClickTimer = setTimeout(function() {
    clickCnt = 0;

    // SINGLE CLICK
    console.log("single click");
    }, 400);
    } else if (clickCnt === 2) {
    clearTimeout(oneClickTimer);
    clickCnt = 0;

    // DOUBLE CLICK
    console.log("double click");
    }
    });
    }
    });

    calendar.render();
    });
</script>
@endsection
