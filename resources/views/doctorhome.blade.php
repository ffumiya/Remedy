@extends('layouts.app')
@include('header')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <h1 class="logo mt-5">Remedy</h1>
            <h2 class="title mt-3">日程未調整患者リスト</h2>
            <div class="mt-3">
                <p>
                    下記リストは「病状説明日程調整」の未対応案件です。
                </p>
                <p>
                    対応可能な日程のスケジューラーに以来案件をドロップしてください。
                </p>
            </div>
            <div class="text-right m-3 mb-5">
                <button class="btn btn-primary btn-main" data-toggle="modal" data-target="#modalForCreate">
                    新規患者登録
                </button>
            </div>

            <div id="external-events">
                @foreach ($patientList as $patient)
                <div class="card fc-event mb-3">
                    <div class="fc-event-main">患者名</div>
                </div>
                @endforeach

                {{-- 要素追加時テンプレート --}}
                <div id="template" class="fc-event fc-ex-event mb-3" hidden>
                    <div class="row p-4 text-center d-flex align-items-center">
                        <div class="col-lg-1 col-md-4 patient-number"></div>
                        <div class="col-lg-4 col-md-8 patient-name"></div>
                        <div class="col-lg-2 patient-city"></div>
                        <div class="col-lg-5 patient-memo"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div id="calendar-container">
                <div id="calendar" />
            </div>
        </div>
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
                    <div class="m-3">
                        <input id="name" type="text" name="name" class="form-control mb-3"
                            placeholder="患者の名前を入力してください。">
                        <input id="memo" type="textbox" class="form-control mb-3" placeholder="患者メモ">
                    </div>
                    <div class="m-3">
                        <button type="button" class="btn btn-primary btn-block" onclick="createNewPatient()">
                            新規登録
                        </button>
                    </div>
                </div>
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    キャンセル
                </button> --}}
            </form>
        </div>
    </div>
</div>
<!-- End modal window -->

<!-- Begin modal window for click event -->
<div id="modalForClick" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">患者様基本情報 / 診察スケジュール</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row m-3">
                    <div class="col">
                        <div class="card p-3">
                            <p class="h4 font-weight-bold primary">◆診察日程</p>
                            <p class="select-event-time"></p>

                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3">
                            <p class="h4 font-weight-bold primary">◆患者名</p>
                            <p id="patient-name"></p>
                            <small id="patient-age"></small>
                        </div>
                    </div>
                </div>
                <div class="row m-5">
                    <div class="col">
                        <a id="video-link">
                            <button class="btn btn-primary btn-block" id="video-button">診察を開始する</button>
                            <button class="btn btn-secondary btn-block" id="video-dummy-button"
                                hidden>この診察は終了しました。</button>
                        </a>
                        <button class="btn-delete btn btn-block mt-3" onclick="deleteEvent()">削除する</button>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    閉じる
                </button>
            </div> --}}
        </div>
    </div>
</div>
<!-- End modal window -->

<!-- Begin modal window for select calendar -->
<div id="modalForSelect" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">診察スケジュール / 新規追加</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="card">
                        <p class="h4 font-weight-bold">◆診察日程</p>
                        <p class="select-event-time"></p>
                        <input id="name" type="text" name="name" class="form-control" placeholder="患者の名前を入力してください。">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">
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
@endsection
@include('footer')


@section('style')
<link href="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css" rel="stylesheet" />
<style>
    @media(min-width: 1200px) {
        .container {
            max-width: 1600px;
        }
    }

    p {
        font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif;
    }

    #external-events {
        z-index: 2;
        top: 20px;
        left: 20px;
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

    .primary {
        color: #006092;
    }

    .card {
        box-shadow: 5px 5px 10px -5px gray;
        border-radius: 12px;
    }

    .fc-toolbar h2 {
        font-size: 3.2rem;
        font-weight: 900;
        font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif;
        color: #006092;
    }

    .fc-event {
        margin-left: -3px;
        font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif;
        color: black;
        background-color: whitesmoke;
        border-radius: 3px;
        border-color: whitesmoke;
        border-left-color: #006092;
        border-radius: 0;
        border-left-width: 3px;
        box-shadow: 5px 5px 10px -5px gray;
    }

    .fc-ex-event {
        border-radius: 10px;
        border-width: 0;
        border: none;
        background-color: white;
        font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif;
    }

    .fc-time {
        color: #006092;
        font-size: 1.2rem;
        font-weight: 800;
        font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif;
    }

    .fc-title {
        font-size: 1.6rem;
    }

    .fc table {
        border-width: 0;
    }

    .fc th {
        border-width: 0;
    }

    .fc td {
        border-width: 0;
        padding: 2px;
    }

    .fc-day-header {
        color: darkgray;
        font-size: 3.0rem;
        font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif;
    }

    .fc-today {
        color: #006092;
        font-weight: 900;
    }

    .patient-number {
        color: #006092;
        font-size: 2.6rem;
        font-weight: 900;
        padding: 0px 6px;
    }

    .patient-name {
        color: #006092;
        font-size: 1.8rem;
        font-weight: bold;
        padding: 0px 6px;
    }

    .patient-city {
        color: #006092;
        font-size: 1.4rem;
        font-weight: bold;
        padding: 0px 6px;
    }

    .patient-memo {
        color: #006092;
        font-size: 1.6rem;
        font-weight: bold;
        padding: 0px 6px;
    }

    .modal-header {
        background-color: #006092;
    }

    .modal-title {
        font-size: 1.6rem;
        color: white;
    }

    .btn {
        box-shadow: 5px 5px 10px -5px gray;
        border-radius: 30px;
    }

    .btn-primary {
        background-color: #006092;
    }

    .btn-main {
        font-size: 1.8rem;
        border-radius: 10px;
        padding: 6px 32px;
    }

    .btn-delete {
        background-color: #b4b4b4;
        font-weight: bold;
    }

    .close {
        font-size: 2.6rem;
        color: white;
    }

    .logo {
        font-size: 3.4rem;
        font-weight: 500;
        color: #006092;
    }

    .title {
        font-size: 2.0rem;
        font-weight: bold;
    }
</style>
@endsection

@section('script')
<script src="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/core/locales/ja"></script>
<script defer>
    var events = @json( $events );
    console.table(events);
    var calendarHeight = 0;
    var calendar = null;

    document.addEventListener("resize", function() {
        calendarHeight = `${innerHeight}px`;
    });

    document.addEventListener("DOMContentLoaded", function() {
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;

        var containerEl = document.getElementById("external-events");
        var calendarEl = document.getElementById("calendar");
        var checkbox = document.getElementById("drop-remove");


        // 外部イベントの初期化
        new Draggable(containerEl, {
            itemSelector: ".fc-event",
            eventData: function(eventEl) {
                return {
                    title: `${eventEl.attributes.title.value}`,
                    id: eventEl.attributes.id.value,
                    event_id: eventEl.attributes.id.value,
                    host_id: "{{ \Auth::id() }}",
                    guest_id: eventEl.attributes.guest_id.value,
                };
            }
        });

        // カレンダーの初期化
        calendar = new Calendar(calendarEl, {
            plugins: ["interaction","timeGrid"],
            header: {
                left: "title",
                center: "",
                right: "prev,today,next"
            },
            axisFormat: "H:mm",
            timeFormat: "H:mm",
            columnHeaderFormat: {
               weekday: 'short',
               day: 'numeric',
               omitCommas: false,

            },
            titleFormat: {
                year: "numeric",
                month: "numeric",
            },
            height: calendarHeight,
            allDaySlot: false,
            weekends: true,
            weekMode: 'liquid',
            forceEventDuration: true,
            defaultTimedEventDuration: "00:30",
            defaultView: "timeGridWeek",
            slotDuration: "00:10:00",
            minTime: "9:00",
            maxTime: "17:00",
            firstDay: 1,
            // locale: "jaLocale",
            editable: true,
            selectable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            events: events,

            select: function(info) {
                // カレンダーセルクリック、範囲指定された時のコールバック
                console.log("select");
                console.log(info);
                // $("#modalForSelect").modal('show');
            },

            eventReceive: function(info) {
                // 外部イベントがドロップされた時のコールバック
                console.log(info.event);
                $.ajax({
                    type: "POST",
                    url: "api/events",
                    datatype: "json",
                    data: {
                        api_token: "{{ \Auth::user()->api_token }}",
                        event: buildEvent(info.event)
                    }
                }).done(function (r) {
                    console.log("cteated event.");
                    $(`#${info.event.id}`).remove();
                }).fail(function(e) {
                    // 予定の削除
                    calendar.getEventById(info.event.id).remove();
                    console.error("予定の追加に失敗しました。");
                });
            },

            eventDrop: function(info) {
                // イベントがドロップされた時のコールバック
                console.log(info);
                updateEvent(info);
            },

            eventResize: function(info) {
                // イベントがリサイズ（引っ張ったり縮めたり）された時のコールバック
                console.log("eventResize");
                updateEvent(info);
            },

            eventRender: function(info) {
                //wired listener to handle click counts instead of event type
                var clickCnt = 0;
                info.el.addEventListener("click", function() {
                    clickCnt++;
                    if (clickCnt === 1) {
                        oneClickTimer = setTimeout(function() {
                            clickCnt = 0;
                            // シングルクリックされた時の処理
                            console.log("single click");
                            console.log(info.event);
                            var date = new Date(info.event.start);
                            var month = date.getMonth() + 1;
                            var day = date.getDate();
                            var from = formatDate(date, "HH:mm");
                            var to = formatDate(new Date(info.event.end), "HH:mm");
                            $(".select-event-time").html(`${month}月${day}日 ${from}～${to}`);
                            $("#patient-name").html(`${info.event.title}`);
                            const isSmallerThanToday = (date) => {
                                var today = new Date();
                                if (date.getFullYear() < today.getFullYear())  return true;
                                if (date.getMonth() < today.getMonth()) return true;
                                if (date.getDate() < today.getDate()) return true;
                                return false;
                            }
                            if (isSmallerThanToday(info.event.start)) {
                                // 昨日以前のイベントは診察対象外
                                $("#video-link").attr("href", null);
                                $("#video-button").prop("hidden", true);
                                $("#video-dummy-button").prop("hidden", false);
                            } else {
                                // 今日以後のイベントは診察対象
                                $("#video-link").attr("href", `video/${info.event.extendedProps.event_id}`);
                                $("#video-button").prop("hidden", false);
                                $("#video-dummy-button").prop("hidden", true);
                            }
                            // イベント削除用にIDを仕込み
                            $("#modalForClick").attr("event-id", `${info.event.id}`);
                            $("#modalForClick").modal('show');
                        }, 250);
                    } else if (clickCnt === 2) {
                        clearTimeout(oneClickTimer);
                        clickCnt = 0;
                        // ダブルクリックされた時の処理
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
        if (name == "") return;
        var memo = $('#memo').val();
        var data = {
            api_token: "{{ \Auth::user()->api_token }}",
            name: name,
            email: eventId + "@example.com",
            password: eventId
        }
        $.ajax({
            type: 'POST',
            url: 'api/user',
            datatype: "json",
            data: data
        }).done(function(r) {
            var newElement = $('#template').clone(true);
            newElement.attr("id", eventId);
            newElement.attr("guest_id", r.id);
            newElement.attr("title", `${name}さん`);
            newElement.prop('hidden', false);
            newElement.find(".patient-number").text(`${r.id}`);
            newElement.find(".patient-name").text(`${name}`);
            newElement.find(".patient-memo").text(`${memo}`);
            newElement.appendTo('#external-events');
            $("#modalForCreate").modal("hide");
        }).fail(function (e) {
            console.error("ajax failed");
            alert("患者の登録に失敗しました。");
        });

    }

    // スケジュール新規登録
    function createNewEvent() {
    }

    // サーバ用のデータに変換する
    function buildEvent(event) {
        return {
            allDay: event.allDay,
            start: event.start,
            end: event.end,
            id: event.id,
            extendedProps: event.extendedProps,
            title: event.title
        };
    }

    // イベントの更新
    function updateEvent(info) {
        $.ajax({
            type: "PUT",
            url: `api/events/${info.event.id}`,
            datatype: "json",
            data: {
                api_token: "{{ \Auth::user()->api_token }}",
                event: buildEvent(info.event)
            }
        }).done(function (r) {
            console.log(r);
        }).fail(function(e) {
            info.revert();
            alert("予定の更新に失敗しました。");
        });
    }

    // イベントの削除
    function deleteEvent() {
        var id = $("#modalForClick").attr("event-id");
        console.log(id);
        var event = calendar.getEventById(id);
        if (confirm(`${event.title}の予定を削除してもいいですか？`)) {
            $.ajax({
                type: "DELETE",
                url: `api/events/${event.extendedProps.event_id}`,
                datatype: "json",
                data: {
                    api_token: "{{ \Auth::user()->api_token }}",
                }
            }).done(function() {
                event.remove();
                $("#modalForClick").modal("hide");
            }).fail(function(e) {
                alert("予定の削除に失敗しました。");
                console.error(e);
            });

        }
    }

    // 今日の日付と比較し、過去の日付ならfalseを返す
    function lowerThanToday(date) {
        var today = new Date();
        if (date.getFullYear() < today.getFullYear()) {
            return false;
        }
        if (date.getMonth() < today.getMonth()) {
            return false;
        }
        if (date.getDate() < today.getDate()) {
            return false;
        }
        return true;
    }

    function formatDate (date, format) {
        format = format.replace(/yyyy/g, date.getFullYear());
        format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
        format = format.replace(/dd/g, ('0' + date.getDate()).slice(-2));
        format = format.replace(/HH/g, ('0' + date.getHours()).slice(-2));
        format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
        format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
        format = format.replace(/SSS/g, ('00' + date.getMilliseconds()).slice(-3));
        return format;
    };

</script>
@endsection
