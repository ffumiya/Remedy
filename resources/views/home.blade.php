@extends('layouts.app')
@section('content')
<div class="home-container">
    <div class="row">
        <div class="col-2" style="padding-right: 2%;">
            <div class="text-right m-3 mb-5">
                <button class="btn btn-primary btn-main font-size-8vw" data-toggle="modal" data-target="#modalForCreate"
                    style="width: 100% !important; box-sizing: border-box;">
                    新規患者登録
                </button>
            </div>
            <h2 class="title mt-3 font-size-12vw">日程未調整患者リスト</h2>
            <div class="mt-3 font-size-8vw">
                <p>
                    「病状説明日程調整」の未対応案件のリストです。
                </p>
                <p>
                    対応する患者さんの名前を右のカレンダーにドラッグ＆ドロップしてください。
                </p>
            </div>

            <div id="external-events" class="pt-2 pb-2">
                @foreach ($patientList as $patient)
                <div class="fc-ex-event fc-event mb-3" id="user{{$patient->id}}" guest_id="{{ $patient->id }}"
                    title="{{ $patient->name }}さん">
                    <div class="row p-4 text-center d-flex align-items-center">
                        <div class="col-lg-1 col-md-4 patient-number">
                            {{ $patient->id }}
                        </div>
                        <div class="col-lg-8 col-md-8 patient-name text-left ml-4">
                            {{ $patient->name }}
                        </div>
                        {{-- <div class="col-lg-2 patient-city"></div> --}}
                    </div>
                </div>
                @endforeach

                {{-- 要素追加時テンプレート --}}
                <div id="template" class="fc-event fc-ex-event mb-3" hidden>
                    <div class="row p-4 text-center d-flex align-items-center" style="font-size:0.5px;">
                        <div class="col-lg-2 col-md-2 patient-number"></div>
                        <div class="col-lg-10 col-md-10 patient-name"></div>
                        {{-- <div class="col-lg-2 patient-city"></div> --}}
                        {{-- <div class="col-lg-5 patient-memo"></div> --}}
                    </div>
                </div>

            </div>
        </div>
        <div class="col-10">
            <div id="calendar-container">
                <div id="calendar" />
            </div>
        </div>
    </div>
</div>

<!-- Begin modal window for register patient -->
<div id="modalForCreate" class="modal p-5" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="margin: 10vh auto!important;">
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
                        <label class="label-font">名前<span style="color:red;">※必須</span></label>
                        <input id="name" type="text" name="name" class="form-control mb-3">
                        <label class="label-font">患者メールアドレス<span style="color:red;">※必須</span></label>
                        <input id="email" type="email" name="email" class="form-control mb-3">
                        <div id="fg-family-email" class="form-group">
                            <label class="label-font">家族メールアドレス</label>
                            <input id="family-email" type="email" name="family_email[]"
                                class="family-email form-control mb-3" hidden>
                            <input type="email" name="family_email[]" class="family-email form-control mb-3">
                        </div>
                        {{-- <input id="memo"  type="textbox" class="form-control mb-3" placeholder="メモがあれば入力してください。"> --}}
                        <!-- </div> -->

                        <div class="text-center mb-3" id="plus_button">
                            <input type="button" class="btn-circle-flat" onclick="clickPlus()" value="＋">
                        </div>

                        <!-- <div class="row mb-3"> -->
                        <div class="row">
                            <div class="col-2" style="font-size: 1vw; padding: 10px 0px 0px 15px !important;">
                                <!-- <div class="col-2" style="font-size: 1vw;;"> -->

                                <label for="start-time">開始時間</label>
                            </div>
                            <div class="col-4" style="padding:0px 0px 0px 5px !important;">
                                <!-- <div class="col-4"> -->
                                <input type="datetime-local" name="start-time" id="start-time" class="form-control"
                                    style="padding:0px 1px 0px 1px !important">
                            </div>
                            <div class="col-2" style="font-size: 1vw; padding: 10px 0px 0px 15px !important;">
                                <!-- <div class="col-2" style="font-size: 1vw;"> -->
                                <label for="end-time">終了時間</label>
                            </div>
                            <div class="col-4" style="padding:0 !important;">
                                <!-- <div class="col-4"> -->
                                <input type="datetime-local" name="end-time" id="end-time" class="form-control"
                                    style="padding:0px 1px 0px 1px !important;">
                            </div>
                        </div>
                    </div>
                    <div class="m-3">
                        <button type="button" class="btn btn-primary btn-block"
                            style="margin-top: 20px; font-size:1vw !important;" onclick="createNewPatient()">
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
                <div class="row m-3">
                    <div class="col">
                        <div class="card p-3 mb-3">
                            <p class="mb-2">◆Zoom参加パスワード</p>
                            <p class="mb-2 pl-4" id="zoom-password"></p>
                        </div>
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
    <div class="modal-dialog">
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
                                <!-- <div class="col-2" style="padding-right:0px !important;"> -->
                                <div class="col-2" style="font-size: 1vw; padding: 10px 0px 0px 15px !important;">

                                    <label for="start-time">開始時間</label>
                                </div>
                                <div class="col-4" style="padding:0px 0px 0px 5px !important;">
                                    <input type="datetime-local" name="start-time" id="search-start-time"
                                        class="form-control" style="padding:0px 1px 0px 1px !important" />
                                </div>
                                <div class="col-2" style="font-size: 1vw; padding: 10px 0px 0px 15px !important;">
                                    <label for="end-time">終了時間</label>
                                </div>
                                <div class="col-4" style="padding:0 !important;">
                                    <input type="datetime-local" name="end-time" id="search-end-time"
                                        class="form-control" style="padding:0px 1px 0px 1px !important;" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col" style="padding-right:0px !important;">
                                    <input type="hidden" name="id" id="search-patient-id">
                                    <label style="font-size: 1.1vw;">患者名</label>
                                    <input id="search-patient-name" type="text" name="name" class="form-control mb-3"
                                        onkeyup="searchPatient(this)">

                                    <div style="z-index: 1060; positon: relative;">
                                        <table class="table table-hover table-sm">
                                            <tbody id="search-patient-list">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col" style="padding:0px !important;">
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

@section('style')
<link href="https://unpkg.com/@fullcalendar/core@4.3.1/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/timegrid@4.3.0/main.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@fullcalendar/list@4.3.0/main.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/doctor_home.css">
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

    // document.addEventListener("resize", function() {
        // calendarHeight = `${innerHeight}px`;
    // });

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

        // 外部イベントの初期化(ドラッグ時の処理)
        new Draggable(containerEl, {
            itemSelector: ".fc-event",
            eventData: function(eventEl) {
                return buildExternalEvent(eventEl);
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
            // height: calendarHeight,
            allDaySlot: false,
            weekends: true,
            weekMode: 'liquid',
            forceEventDuration: true,
            defaultTimedEventDuration: "00:30",
            defaultView: "timeGridWeek",
            slotDuration: "00:10:00",
            minTime: "8:00",
            maxTime: "20:00",
            calendarHeight: 630,
            height: 630,
            contentHeight: 630,
            scrollTime: first_scroll_time,
            firstDay: 1,
            locale: "jaLocale", //日本語化
            nowIndicator: true,
            editable: true,
            selectable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            events: events,

            // カレンダーセルクリック、範囲指定された時のコールバック
            select: function(info) {
                $('#search-start-time').val(formatDate(new Date(info.start), "yyyy-MM-ddThh:mm"));
                $('#search-end-time').val(formatDate(new Date(info.end), "yyyy-MM-ddThh:mm"));
                $("#modalForSelect").modal('show');
            },
            // 外部イベントがドロップされた時のコールバック
            eventReceive: function(info) {
                if (confirm('予定を作成すると患者さんへメールが送信されます')) {
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
                        calendar.getEventById(info.event.id).remove();
                        calendar.addEvent(r);
                        $(`#user${info.event.extendedProps.guest_id}`).remove();
                    }).fail(function(e) {
                        // 予定の削除
                        calendar.getEventById(info.event.id).remove();
                        console.error("予定の追加に失敗しました。");
                    });
                } else {
                    calendar.getEventById(info.event.id).remove();
                }
            },
            // イベントがドロップされた時のコールバック
            eventDrop: function(info) {
                updateEvent(info);
            },
            // イベントがリサイズ（引っ張ったり縮めたり）された時のコールバック
            eventResize: function(info) {
                updateEvent(info);
            },

            // イベントがクリックされた時の処理
            eventRender: function(info) {
                var clickCnt = 0;
                info.el.addEventListener("click", function() {
                    clickCnt++;
                    if (clickCnt === 1) {
                        oneClickTimer = setTimeout(function() {
                            clickCnt = 0;
                            // シングルクリックされた時の処理
                            console.log(info.event);
                            var date = new Date(info.event.start);
                            var month = date.getMonth() + 1;
                            var day = date.getDate();
                            var from = formatDate(date, "H:mm");
                            var to = formatDate(new Date(info.event.end), "H:mm");
                            var zoom_password = info.event.extendedProps.zoom_start_password ?
                                info.event.extendedProps.zoom_start_password : "取得中";
                            $(".select-event-time").html(`${month}月${day}日 ${from}～${to}`);
                            $("#patient-name").html(`${info.event.title}`);
                            $("#zoom-password").html(zoom_password);
                            const isSmallerThanToday = (date) => {
                                var today = new Date();
                                today.setDate(today.getDate() -1);
                                return today > date;
                            }
                            if (isSmallerThanToday(info.event.start)) {
                                // 昨日以前のイベントは診察対象外
                                $("#video-link").attr("href", null);
                                $("#video-button").prop("hidden", true);
                                $("#video-dummy-button").prop("hidden", false);
                                $("#mail-button").prop("hidden", true);
                            } else {
                                // 今日以後のイベントは診察対象
                                $("#video-link").attr("href", `${info.event.extendedProps.zoom_start_url}`);
                                // Zoom用にクリックイベントを仕込む
                                event_id = info.event.extendedProps.event_id;
                                $("#video-button").on('click', function () {
                                    $.ajax({
                                        type: "POST",
                                        url: `api/events/sendSurvey/${event_id}`,
                                        datatype: "json",
                                        data: {
                                            api_token: "{{ \Auth::user()->api_token }}",
                                        }
                                    }).done(function(e) {
                                        console.error(e);
                                    }).fail(function(e) {
                                        console.error(e);
                                    });
                                });
                                $("#video-button").prop("hidden", false);
                                $("#video-dummy-button").prop("hidden", true);
                                $("#mail-button").prop("hidden", false);
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

        // calendar.updateEvent;
        calendar.render();
    });

    // 患者情報の新規登録
    function createNewPatient() {
        const reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
        var name = $('#name').val();
        if (name == "") {
            alert("名前を入力してください。");
            return;
        }
        var email = $('#email').val();
        if (!reg.test(email)) {
            alert("患者のメールアドレスを正しく入力してください。");
            return;
        }
        var family_email = [];
        var family_email_error = "";
        $(".family-email").each(function (i, element) {
            console.log(element);
            if ($(element).prop("hidden")) {
            } else {
                if ($(element).val() == "") {
                    return;
                } else if (!reg.test($(element).val())) {
                    family_email_error = "ご家族のメールアドレスを正しく入力してください。\n"
                    + $(element).val();
                    return;
                } else {
                    family_email.push($(element).val());
                }
            }
        });
        if (family_email_error != "") {
            alert(family_email_error);
            return;
        }
        var data = {
            api_token: "{{ \Auth::user()->api_token }}",
            name: name,
            email: email,
            family_email: family_email,
            password: cutDomain(email),
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
            newElement.appendTo('#external-events');
            $("#modalForCreate").modal("hide");

            var start_time = $("#start-time").val();
            if (start_time != "") {
                start_time = new Date(start_time);
                console.log(start_time);
                var end_time = $("#end-time").val();
                if (end_time != "") {
                    end_time = new Date(end_time);
                } else {
                    end_time = new Date(start_time.valueOf());
                    end_time.setMinutes(end_time.getMinutes() + {{ config('zoom.default_meeting_time') }});
                }
                console.log(end_time);
                alert(`${start_time}〜の予定を作成します。\n作成すると患者さんへメールが送信されます`);
                var result = createEvent(`${name}さん`, r.id, start_time, end_time);
                if (result) {
                    $(`#user${r.id}`).remove();
                }
            }
        }).fail(function (e) {
            console.error(e);
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
        var name = $('#search-patient-name').val();
        if (name == "") return;
        var title = `${name}さん`;
        var start = $('#search-start-time').val();
        var end = $('#search-end-time').val();
        var result = createEvent(title, id, new Date(start), new Date(end));
        if (result) {
            $("#modalForSelect").modal("hide");
        }
    }

    //サーバ用のデータに変換する
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

    // クライアント用のイベントデータを作成
    function buildExternalEvent(event) {
        console.log(event);
        var title = event.attributes.title.value;
        var eventId = createEventId(title);
        var data =  {
            title: title,
            event_id: eventId,
            host_id: parseInt("{{ \Auth::id() }}"),
            guest_id: event.attributes.guest_id.value,
        };
        console.log(data);
        return data;
    }

    // イベントの作成
    function createEvent(title, guest_id, start, end) {
        var data = {
            api_token: "{{ \Auth::user()->api_token }}",
            event: {
                title: title,
                extendedProps: {
                    event_id: createEventId(title),
                    guest_id: guest_id,
                    host_id: {{\Auth::id()}},
                },
                start: start,
                end: end
            }
        };
        $.ajax({
            type: "POST",
            url: `api/events`,
            datatype: "json",
            data: data
        }).done(function(r) {
            calendar.addEvent(r);
            formInitialize();
            return true;
        }).fail(function (e) {
            alert("新規予定の作成に失敗しました。");
            console.error(e);
            return false;
        });
    }

    // イベントの更新
    function updateEvent(info) {
        if (confirm('予定を更新すると患者さんへメールが送信されます')) {
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
                console.error(e);
                info.revert();
                alert("予定の更新に失敗しました。");
            });
        } else {
            info.revert();
        }
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
    function searchPatient(e) {
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

    // 日付をinputが要求する形式にフォーマットする
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

    // メールアドレスの@マーク移行を削除
    function cutDomain(email) {
        var index =  String(email).indexOf("@");
        var str = String(email).substring(0, index);
        return str;
    }

    function createEventId(title) {
        return btoa(encodeURIComponent(title) + Math.round((new Date()).getTime() / 1000));
    }

    // 家族メールアドレスの追加表示処理
    function clickPlus(){
        var count = 0;
        $(".family-email").each(function () {
            count++;
        });
        if (count > 5) {
            alert("家族用のメールアドレスは5件までしか登録できません。")
            return;
        }
        var parent = $("#fg-family-email");
        var element = $("#family-email").clone(true);
        element.prop("hidden", false);
        parent.append(element);
        // count++;
        // if (count > 5) {
        //     $("#plus_button").prop("hidden", true);
        // }
    }

    // 入力項目の初期化
    function formInitialize() {
        $(".form-control").each(function (i, e) {
            $(e).val("");
        })
    }

    // 「年」と「月」を入れるサブ関数 '2021/1' -> '2021年1月'
    function dateTranslate(yearMonth){
        // 月が１桁か２桁かで場合分け
        var translatedYearMonth = "";
        if(yearMonth.length==6){
            translatedYearMonth = yearMonth.substr(0,4) + "年" + yearMonth[5] + "月";
        }else{
            translatedYearMonth = yearMonth.substr(0,4) + "年" + yearMonth.substring(5) + "月";
        }
        return translatedYearMonth;
    };

    // 時間の「時」を「:00」にするサブ関数 '8時' -> '8:00'
    function timeTranslate(time){
        index = time.indexOf('時');
        hour = time.substr(0,index);
        translatedTime = hour + ':00';
        return translatedTime;
    }
    
    window.onload = function () {
        // // HTML読み込み後に年と月を日本語表記に変更
        var yearMonth = document.getElementsByTagName("h2")[1].textContent;
        // カレンダーが月を跨いでいる場合
        if( yearMonth.indexOf('–') !== -1) {
            index = yearMonth.indexOf('–');
            previousYearMonth = yearMonth.substring(0,index-1);
            formerYearMonth = yearMonth.substring(index+2);
            document.getElementsByTagName("h2")[1].textContent = dateTranslate(previousYearMonth) + '〜' + dateTranslate(formerYearMonth);
        // カレンダーが月を跨いでいない場合
        }else{
            document.getElementsByTagName("h2")[1].textContent = dateTranslate(yearMonth);
        } 
        time = document.getElementsByClassName("fc-axis")[2].textContent;

        // カレンダーの横軸にある時間の一部変更 8時→8:00
        for(let i = 2; i < 70; i = i + 6){
            time = document.getElementsByClassName("fc-axis")[i].textContent;
            document.getElementsByClassName("fc-axis")[i].textContent = timeTranslate(time)
        }



        // // カレンダーの曜日を２行にして、英語を日本語に翻訳する処理 11 Wed -> 11 \n 水
        // // 各曜日ごと
        // for(let i = 0; i < 7; i++){
        // //　文字列の中から日付と曜日を抽出 
        //     var date = document.getElementsByClassName("fc-day-header")[i].textContent;   // ex)date="1 Wed","13 Mon" etc 
        //     var english_week_of_day = "";
        //     // 日にちが１桁か２桁かで場合わけ
        //     if(date[1]=""){
        //         day = date[0];
        //         english_week_of_day = date.substring(2,5);
        //     }else{
        //         day = date.substring(0, 2);
        //         english_week_of_day = date.substring(3,6);
        //     };

        //     // 曜日を翻訳
        //     const WEEK_OF_DAY_DICTIONARY= {'Mon':'月', 'Tue':'火', 'Wed':'水', 'Thu':'木', 'Fri':'金', 'Sat':'土', 'Sun':'日'};
        //     japanese_week_of_day = WEEK_OF_DAY_DICTIONARY[english_week_of_day];

        //     // 日付と曜日を結合
        //     document.getElementsByClassName("fc-day-header")[i].innerHTML=
        //     '<span>' + day + '</span></br>' + 
        //     '<span style="font-size:1.2vw;">' + japanese_week_of_day +'</span>';
        // }
    };

</script>
@endsection
