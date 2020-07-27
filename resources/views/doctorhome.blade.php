@extends('layouts.app')
@include('header')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <h1>日程未調整患者リスト</h1>
            <p>
                下記リストは～
            </p>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalForCreate">
                新規患者登録
            </button>

            <div id="external-events">
                @foreach ($patientList as $patient)
                <div class="card fc-event">
                    <div class="fc-event-main">患者名</div>
                </div>
                @endforeach

                {{-- 要素追加時テンプレート --}}
                <div id="template" class="card fc-event" hidden>
                    <div class="fc-event-main">患者名</div>
                </div>
            </div>

            <!-- Begin modal window for click event -->
            <div id="modalForCreate" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">新規患者登録</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <div class="card">
                                    <input id="name" type="text" name="name" class="form-control"
                                        placeholder="患者の名前を入力してください。">
                                    <input id="memo" type="textbox" class="form-control" placeholder="患者メモ">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="createNewPatient()">
                                    新規登録
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    キャンセル
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End modal window -->
        </div>
        <div class="col-8">
            <div id="calendar-container">
                <div id="calendar" />
            </div>
        </div>
    </div>
</div>
<!-- Begin modal window for click event -->
{{-- <div id="modalForClick" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">予定の詳細</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="selectedEvent != null">
                        <div class="card">
                            <p>診察日程</p>
                            <p>
                                {{
                                                selectedEvent.start
                                                    | moment("YYYY.MM.DD HH:mm")
                                            }}
～
{{ selectedEvent.end | moment("HH:mm") }}
</p>
</div>
<div class="card">
    <p>患者名</p>
    <p>{{ selectedEvent.name }}</p>
</div>
</div>
<div class="modal-footer" v-if="selectedEvent">
    <button type="button" class="btn btn-primary" v-if="selectedEvent.payment_method_id != null" v-on:click="toVideo">
        ビデオ診療開始
    </button>

    {{ selectedEvent.payment_method_id }}
    <button type="button" class="btn btn-primary" v-if="!selectedEvent.payment_method_id" disabled>
        料金支払い待ち
    </button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        閉じる
    </button>
</div>
</div>
</div>
</div> --}}
<!-- End modal window -->

@endsection @section('style')
<link href="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css" rel="stylesheet" />
<style>
    #external-events {
        z-index: 2;
        top: 20px;
        left: 20px;
        width: 150px;
        background: #eee;
    }

    #external-events .fc-event {
        cursor: grab;
        margin: 3px 0;
    }

    #calendar-container {
        position: relative;
        z-index: 1;
    }

    #calendar {
        max-width: 1100px;
        margin: 20px auto;
    }
</style>
@endsection @include('footer') @section('script')
<script src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/core/locales/ja"></script>
<script defer>
    var users = [];
    var events = [];
    var calendarHeight = 0;

    document.addEventListener("resize", function() {
        calendarHeight = `${innerHeight}px`;
    });

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
                    title: eventEl.innerText,
                    id: Math.round((new Date()).getTime() / 1000),
                    host_id: "{{ \Auth::id() }}",
                    guest_id: eventEl.id
                };
            }
        });

        // initialize the calendar
        var calendar = new Calendar(calendarEl, {
            plugins: ["interaction","timeGrid"],
            header: {
                left: "title",
                center: "",
                right: "prev,next"
            },
            height: calendarHeight,
            allDaySlot: true,
            forceEventDuration: true,
            defaultTimedEventDuration: "00:30",
            defaultView: "timeGridWeek",
            slotDuration: "00:30:00",
            minTime: "8:00",
            maxTime: "19:00",
            firstDay: 1,
            locale: "jaLocale",
            editable: true,
            selectable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            events: getEvents(),


            select: function(info) {
                // カレンダーセルクリック、範囲指定された時のコールバック
                console.log("select");
            },

            eventReceive: function(info) {
                // イベントがexternal-eventからドロップされた時のコールバック
                console.log("eventReceive");
                $.ajax({
                    type: "POST",
                    url: "api/events",
                    datatype: "json",
                    data: {
                        api_token: "{{ \Auth::user()->api_token }}",
                        event: buildEvent(info.event)
                    }
                }).done(function (r) {
                    console.log(r);
                    $(`#${info.event.extendedProps.guest_id}`).remove();
                }).fail(function(e) {
                    // 予定の削除
                    console.error("error");
                });
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
                var clickCnt = 0;
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

    // 患者情報の新規登録
    function createNewPatient() {
        var eventId = Math.round((new Date()).getTime() / 1000);
        console.log(eventId);
        var name = $('#name').val();
        // if (name == "") return;
        var data = {
            api_token: "{{ \Auth::user()->api_token }}",
            name: name,
            email: eventId + "@example.com",
            password: eventId
        }
        $.ajax({
            type: 'GET',
            url: 'api/user/create',
            datatype: "json",
            data: data
        }).done(function(r) {
            users.push(r);
            console.table(users);
            var newElement = $('#template').clone(true);
            newElement.attr("id", r.id);
            newElement.prop('hidden', false);
            newElement.text(name);
            newElement.appendTo('#external-events');
            $("#modalForCreate").modal("hide");
        }).fail(function (e) {
            console.error("ajax failed");
            alert("患者の新規登録に失敗しました。");
        });

    }

    // スケジュール新規登録
    function createNewEvent() {

    }

    function buildEvent(event) {
        return {
            allDay: event.allDay,
            backgroundColor: event.backgroundColor,
            textColor: event.textColor,
            start: event.start,
            end: event.end,
            id: event.id,
            guest_id: event.extendedProps.guest_id,
            host_id: event.extendedProps.host_id,
            title: event.title
        };
    }

    function getEvents() {
        $.ajax({
            type: 'GET',
            url: 'api/events?userID={{ \Auth::id() }}',
            datatype: "json",
            data: {
                api_token: "{{ \Auth::user()->api_token }}"
            }
        }).done(function(r) {
            console.table(r);
            calendar.events = r;
        }).fail(function (e) {
            alert("カレンダーの取得に失敗しました。");
        });
    }

</script>
@endsection
