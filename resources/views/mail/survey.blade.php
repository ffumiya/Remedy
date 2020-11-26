<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $clinic_name }}/からアンケートのお願い　Remedyご案内事務局</title>
</head>

<body>
    <div>
        <p>{{ $patient_name }} 様</p>
        <p>オンライン診療サービス「Remedy」のご案内事務局です。</p>
        <p>{{ $clinic_name }} からアンケートの依頼が来ております。</p>
        <p>下記URLからアンケートにご回答ください。</p>
    </div>
    <div>
        <a href="{{ $survey_url }}" target="_blank">{{ $survey_url }}</a>
    </div>

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
