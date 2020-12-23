<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $clinic_name }}/次回の診察日程について　Remedyご案内事務局</title>
</head>

<body>
    <div>
        <p>{{ $patient_name }} 様</p>
        <p>オンライン診療サービス「Remedy」のご案内事務局です。</p>
        <p>{{ $clinic_name }} 様での次回の診療予定が変更されました。</p>
        <p>当日の診療についてご確認ください。</p>
    </div>

    <hr>

    <div>
        <p>【病院名】{{ $clinic_name }}</p>
        <p>【日　時】{{ $start->format('Y年m月d日 H時:i分') }}開始</p>
        <p>【診　療】当日はオンライン診療サービス「Remedy」で実施します。</p>
    </div>

    <div>
        <p>
            診療までにビデオ通話サービスZOOMをダウンロードし、時間になりましたら、以下のURLをクリックしてお待ちください。
        </p>
        <p>▼当日はこちらのURLをクリックしてお待ちください。</p>
        <a href="{{ $zoom_url }}" target="_blank">{{ $zoom_url }}</a>
    </div>

    <div>
        <p>▼当日までにZOOMをダウンロードしてください。</p>
        <p>---iPhoneをご利用の方はこちら---</p>
        <a href="https://apps.apple.com/us/app/id546505307">https://apps.apple.com/us/app/id546505307</a>
        <br>
        <p>---androidをご利用の方はこちら---</p>
        <a
            href="https://play.google.com/store/apps/details?id=us.zoom.videomeetings">https://play.google.com/store/apps/details?id=us.zoom.videomeetings</a>
        <br>
        <p>---パソコンをご利用の方はこちら---</p>
        <a href="https://zoom.us/download">https://zoom.us/download</a>
    </div>

    <hr>

    <p>
        ※本メールは送信専用となっておりますため、ご連絡頂いてもご返信が出来かねますので予めご了承ください。
        なお、日程変更・ご不明な点等がございましたらご利用の病院までお問合せください。
    </p>

    <hr>

    <p>病状説明専門のオンライン診療サービス「Remedy」</p>
    <p>ご案内事務局</p>
    <hr>
</body>

</html>
