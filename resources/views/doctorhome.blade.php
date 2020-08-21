@extends('layouts.app')
@include('header')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <h2 class="title mt-3 font-size-14vw">日程未調整患者リスト</h2>
            <div class="mt-3 font-size-10vw">
                <p>
                    下記リストは「病状説明日程調整」の未対応案件です。
                </p>
                <p>
                    対応可能な日程のスケジューラーに依頼案件をドロップしてください。
                </p>
            </div>
            <div class="text-right m-3 mb-5">
                <button class="btn btn-primary btn-main font-size-10vw" data-toggle="modal"
                    data-target="#modalForCreate">
                    新規患者登録
                </button>
            </div>

            <div id="external-events">
                @foreach ($patientList as $patient)
                <div class="fc-ex-event fc-event mb-3" id="user{{$patient->id}}" guest_id="{{ $patient->id }}"
                    title="{{ $patient->name }}さん">
                    <div class="row p-4 text-center d-flex align-items-center">
                        <div class="col-lg-1 col-md-4 patient-number">
                            {{ $patient->id }}
                        </div>
                        <div class="col-lg-4 col-md-8 patient-name">
                            {{ $patient->name }}
                        </div>
                        <div class="col-lg-2 patient-city"></div>
                    </div>
                </div>
                @endforeach

                {{-- 要素追加時テンプレート --}}
                <div id="template" class="fc-event fc-ex-event mb-3" hidden>
                    <div class="row p-4 text-center d-flex align-items-center">
                        <div class="col-lg-1 col-md-4 patient-number"></div>
                        <div class="col-lg-4 col-md-8 patient-name"></div>
                        <div class="col-lg-2 patient-city"></div>
                        {{-- <div class="col-lg-5 patient-memo"></div> --}}
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
<div id="modalForCreate" class="modal p-5" tabindex="-1" role="dialog">
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
                        <div class="row mb-3">
                            <div class="col-2" style="font-size: 15px; padding: 8px 0px 0px 18px !important;">
                                <label for="start-time">開始時間</label>
                            </div>
                            <div class="col-4">
                                <input type="datetime-local" class="form-control">
                            </div>
                            <div class="col-2" style="font-size: 15px; padding: 8px 0px 0px 18px !important;">
                                <label for="end-time">終了時間</label>
                            </div>
                            <div class="col-4">
                                <input type="datetime-local" class="form-control">
                            </div>
                        </div>
                        <input id="name" type="text" name="name" class="form-control mb-3" placeholder="名前を入力してください。">
                        <input id="phone" type="text" name="phone" class="form-control mb-3"
                            placeholder="電話番号を入力してください。">
                        <input id="email" type="email" name="email" class="form-control mb-3"
                            placeholder="メールアドレスを入力してください。">
                        {{-- <input id="memo" type="textbox" class="form-control mb-3" placeholder="メモがあれば入力してください。"> --}}
                    </div>
                    <div class="m-3">
                        <button type="button" class="btn btn-primary btn-block" onclick="createNewPatient()">
                            新規登録
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal window -->

<!-- Begin modal window for click event -->
<div id="modalForClick" class="modal p-5" tabindex="-1" role="dialog">
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
                        <a href="mailto:" id="mail-to">
                            <button class="btn btn-success btn-block mb-3" id="mail-button">メール送信する</button>
                        </a>
                        <a id="video-link">
                            <button class="btn btn-primary btn-block" id="video-button">診察を開始する</button>
                            <button class="btn btn-secondary btn-block" id="video-dummy-button"
                                hidden>この診察は終了しました。</button>
                        </a>
                        <button class="btn-delete btn btn-block mt-3" onclick="deleteEvent()">削除する</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal window -->

<!-- Begin modal window for select calendar -->
<div id="modalForSelect" class="modal p-5" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">診察スケジュール / 新規追加</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="return createNewEvent()">
                <div class="modal-body">
                    <div class="card">
                        <div class="container">
                            <p class="h2 font-weight-bold mb-3">◆診察日程</p>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label for="start-time">開始時間</label>
                                </div>
                                <div class="col-4">
                                    <input type="datetime-local" name="start-time" id="search-start-time"
                                        class="form-control">
                                </div>
                                <div class="col-2">
                                    <label for="end-time">終了時間</label>
                                </div>
                                <div class="col-4">
                                    <input type="datetime-local" name="end-time" id="search-end-time"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <input type="hidden" name="id" id="search-patient-id">
                                    <input id="search-patient-name" type="text" name="name" class="form-control mb-3"
                                        placeholder="患者の名前を入力してください。" onkeyup="search(this)">

                                    <div style="z-index: 1060; positon: relative;">
                                        <table class="table table-hover table-sm">
                                            <tbody id="search-patient-list">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="m-5">
                                        <button type="button" class="btn btn-primary btn-block"
                                            onclick="createNewEvent()">
                                            新規登録
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        /* font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif; */
        font-family: 'メイリオ', 'Meiryo', "Yu Gothic", "游ゴシック", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", sans-serif;

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
        /* font-size: 3.2rem; */
        font-size: 2.2vw;
        font-weight: 900;
        /* font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif; */
        font-family: 'メイリオ', 'Meiryo', "Yu Gothic", "游ゴシック", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", sans-serif;
        color: #006092;
    }

    .fc-event {
        margin-left: -3px;
        /* font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif; */
        font-family: 'メイリオ', 'Meiryo', "Yu Gothic", "游ゴシック", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", sans-serif;
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
        /* font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif; */
        font-family: 'メイリオ', 'Meiryo', "Yu Gothic", "游ゴシック", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", sans-serif;
    }

    .fc-time {
        color: #006092;
        font-size: 1.5rem;
        font-weight: 800;
        /* font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif; */
        font-family: 'メイリオ', 'Meiryo', "Yu Gothic", "游ゴシック", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", sans-serif;
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
        /* font-size: 2.5rem; */
        font-size: 1.5vw;
        /* font-family: Noto, Hiragino Sans, Helvetica, Arial, sans-serif; */
        font-family: 'メイリオ', 'Meiryo', "Yu Gothic", "游ゴシック", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", sans-serif;
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

    /* スクロールの幅の設定 */
    .fc-scroller::-webkit-scrollbar {
        width: 12px;
        height: 10px;
    }

    /* スクロールの背景の設定 */
    .fc-scroller::-webkit-scrollbar-track {
        border: none;
        border-radius: 16px;
        box-shadow: 0 0 4px #aaa inset;
    }

    /* スクロールのつまみ部分の設定 */
    .fc-scroller::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background: #006092;
    }

    .search-list {
        cursor: pointer;
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

        var current_day = new Date();
        var current_hours = current_day.getHours();
        var first_scroll_time = current_hours + ":00" + ":00"
        console.log(first_scroll_time);

        // 外部イベントの初期化
        new Draggable(containerEl, {
            itemSelector: ".fc-event",
            eventData: function(eventEl) {
                console.log("ドラッグ開始");
                console.log(eventEl);
                var title = eventEl.attributes.title.value;
                var eventId = btoa(encodeURIComponent(title) + Math.round((new Date()).getTime() / 1000));
                console.log(eventId);
                return {
                    title: title,
                    // id: eventEl.attributes.id.value,
                    // event_id: Math.round((new Date()).getTime() / 1000),
                    event_id: eventId,
                    host_id: parseInt("{{ \Auth::id() }}"),
                    // host_id: eventEl.attributes.guest_id.value,
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
            axisFormat: "HH:mm",
            timeFormat: "HH:mm",
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
            minTime: "8:00",
            maxTime: "20:00",
            contentHeight: 900,
            // scrollTime: first_scroll_time,
            firstDay: 1,
            // locale: "jaLocale",
            editable: true,
            selectable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            events: events,

            select: function(info) {
                // カレンダーセルクリック、範囲指定された時のコールバック
                var start = formatDate(new Date(info.start), "yyyy-MM-ddThh:mm");
                var end = formatDate(new Date(info.end), "yyyy-MM-ddThh:mm");
                document.getElementById('search-start-time').value = start;
                document.getElementById('search-end-time').value = end;
                $("#modalForSelect").modal('show');
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
                    $(`#user${info.event.extendedProps.guest_id}`).remove();
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
                // イベントがクリックされた時の処理
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
                            var from = formatDate(date, "H:mm");
                            var to = formatDate(new Date(info.event.end), "H:mm");
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
                                $("#mail-button").prop("hidden", true);
                            } else {
                                // 今日以後のイベントは診察対象
                                $("#video-link").attr("href", `video/${info.event.extendedProps.event_id}`);
                                $("#video-button").prop("hidden", false);
                                $("#video-dummy-button").prop("hidden", true);
                                $("#mail-button").prop("hidden", false);
                                // メール作成
                                var email = "";
                                $.ajax({
                                    type: "GET",
                                    url: `api/patient/${info.event.extendedProps.guest_id}`,
                                    datatype: "json",
                                    data: {
                                        api_token: "{{ \Auth::user()->api_token }}"
                                    }
                                }).done(function(user) {
                                    email = user.email;
                                    console.log(`${info.event.title}さんのeamil: ${email}`);
                                    var mailto = `${email}`;
                                    var subject = `{{ $clinicName }}よりお知らせ`;
                                    var body = `${info.event.title}%0D%0A%0D%0Aオンライン診療の時間が設定されました。下記詳細をご確認ください。%0D%0A%0D%0A診療時間：${formatDate(info.event.start, 'yyyy-MM-ddThh:mm')} - ${formatDate(info.event.end, 'yyyy-MM-ddThh:mm')}%0D%0AURL：https://re-medy.jp/video/${info.event.extendedProps.event_id}`;
                                    $("#mail-to").attr("href", `mailto:${mailto}?subject=${subject}&body=${body}`);
                                }).fail(function (e) {
                                    alert("新規予定の作成に失敗しました。");
                                });
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
        const reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
        // var eventId = Math.round((new Date()).getTime() / 1000);
        // console.log(eventId);
        var name = $('#name').val();
        if (name == "") {
            alert("名前を入力してください。");
            return;
        }
        var email = $('#email').val();
        if (!reg.test(email)) {
            alert("正しいメールアドレスを入力してください。");
            return;
        }
        // var memo = $('#memo').val();
        var data = {
            api_token: "{{ \Auth::user()->api_token }}",
            name: name,
            email: email,
            password: cutDomain(email)
        }
        $.ajax({
            type: 'POST',
            url: 'api/user',
            datatype: "json",
            data: data
        }).done(function(r) {
            var newElement = $('#template').clone(true);
            newElement.attr("id", `user${r.id}`);
            newElement.attr("guest_id", r.id);
            newElement.attr("title", `${name}さん`);
            newElement.prop('hidden', false);
            newElement.find(".patient-number").text(`${r.id}`);
            newElement.find(".patient-name").text(`${name}`);
            // newElement.find(".patient-memo").text(`${memo}`);
            newElement.appendTo('#external-events');
            $("#modalForCreate").modal("hide");

        }).fail(function (e) {
            console.error("ajax failed");
            alert("患者の登録に失敗しました。");
        });

    }

    // スケジュール新規登録
    function createNewEvent() {
        var id = $('#search-patient-id').val();
        if (id == "") {
            alert("入力された患者は登録されていません。候補から選択してください。");
            return false;
        }
        // var eventId = Math.round((new Date()).getTime() / 1000);
        var name = $('#search-patient-name').val();
        if (name == "") return;
        var start = $('#search-start-time').val();
        var end = $('#search-end-time').val();
        var data = {
            api_token: "{{ \Auth::user()->api_token }}",
            event: {
                title: `${name}さん`,
                extendedProps: {
                    // event_id: eventId,
                    guest_id: id,
                    host_id: {{\Auth::id()}},
                },
                start: new Date(start),
                end: new Date(end)
            }
        };
        $.ajax({
            type: "POST",
            url: `api/events`,
            datatype: "json",
            data: data
        }).done(function(r) {
            calendar.addEvent(r);
            $('#search-patient-id').val("");
            $('#search-patient-name').val("");
            $('#search-start-time').val("");
            $('#search-end-time').val("");
            $("#modalForSelect").modal("hide");
        }).fail(function (e) {
            alert("新規予定の作成に失敗しました。");
        });
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
            url: `api/events/${info.event.extendedProps.event_id}`,
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

    // 患者の検索
    function search(e) {
        document.getElementById('search-patient-id').value = "";
        $.ajax({
            type: "GET",
            url: `api/patient?name=${e.value}`,
            datatype: "json",
            data: {
                api_token: "{{ \Auth::user()->api_token }}",
            }
        }).done(function(e) {
            var el = document.getElementById('search-patient-list');
            while (el.firstChild) {
                el.removeChild(el.firstChild);
            }
            e.forEach(user => {
                var userName = user.name;
                var newTr = document.createElement('tr');
                var newTd = document.createElement('td');
                newTd.innerText = userName;
                newTd.setAttribute("search-patient-id", user.id);
                newTr.appendChild(newTd);
                newTr.classList.add("search-list");
                newTr.addEventListener("click", (e) => {
                    var name = e.target.innerText;
                    var id = e.target.getAttribute('search-patient-id');
                    document.getElementById('search-patient-name').value = name;
                    document.getElementById('search-patient-id').value = id;
                    var el = document.getElementById('search-patient-list');
                    while (el.firstChild) {
                        el.removeChild(el.firstChild);
                    }
                })
                el.appendChild(newTr);
            });
        }).fail(function(e) {
            console.error(e);
        });
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
        format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
        format = format.replace(/H/g, date.getHours());
        format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
        format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
        format = format.replace(/SSS/g, ('00' + date.getMilliseconds()).slice(-3));
        return format;
    };

    function cutDomain(email) {
        console.log(email);
        var index =  String(email).indexOf("@");
        console.log(index);
        var str = String(email).substring(0, index);
        console.log(str);
        return str;
    }

</script>
@endsection
