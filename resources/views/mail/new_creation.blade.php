<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remedy事務局よりお知らせ</title>
</head>

<body>
    <h2>○○病院よりオンライン診療が登録されました</h2>
    <p>お時間になりましたら、下記URLより参加ください</p>
    <p>なお、オンライン診療を行うには予めZoomアプリをインストールしてください。</p>

    <table>
        <tr>
            <th>日にち</th>
            <td>{{ $start->format('Y年m月d日') }}</td>
        </tr>
        <tr>
            <th>時間</th>
            <td>{{ $start->format('H:i') }}～{{ $end->format('H:i') }}</td>
        </tr>
        <tr>
            <th>Zoom URL</th>
            <td><a href="{{ $remedy_url }}">{{ $zoom_url }}</a></td>
        </tr>
    </table>
</body>

</html>
