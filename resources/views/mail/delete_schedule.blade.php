<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remedy事務局よりお知らせ</title>
</head>

<body>
    <h2>○○病院よりオンライン診療がキャンセルされました</h2>

    <table>
        <tr>
            <th>日にち</th>
            <td>{{ $start->format('Y年m月d日') }}</td>
        </tr>
        <tr>
            <th>時間</th>
            <td>{{ $start->format('H:i') }}～{{ $end->format('H:i') }}</td>
        </tr>
    </table>
    <p>
        診療が必要となった際は改めて担当医へご連絡ください。
    </p>
</body>

</html>
