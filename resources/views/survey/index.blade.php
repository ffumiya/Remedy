@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col">
            <h1>患者アンケート一覧</h1>
        </div>
        <div class="col">
            {{-- <label for="">絞り込み</label>
            <div class="btn-group btn-group-toggle ml-2" data-toggle="buttons">
                <label class="btn btn-lg btn-outline-info">
                    <input type="checkbox" autocomplete="off">未回収
                </label>
                <label class="btn btn-lg btn-outline-info">
                    <input type="checkbox" autocomplete="off">未読
                </label>
                <label class="btn btn-lg btn-outline-info">
                    <input type="checkbox" autocomplete="off">既読
                </label>
                <label class="btn btn-lg btn-outline-info">
                    <input type="checkbox" autocomplete="off">コメントあり
                </label>
            </div> --}}
        </div>
        <div class="col">
            <form action="/survey">
                @csrf
                <div class="form-row align-items-center">
                    {{-- <div class="col-auto">
                        <label for="name">患者名で検索</label>
                    </div> --}}
                    <div class="col">
                        <input type="text" name="name" id="name" class="form-control" placeholder="患者名を入力してください"
                            value="{{ old('name', $name) }}">
                    </div>
                    <div class="col-auto">
                        <input type="submit" class="btn btn-lg btn-primary" value="検索">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <table class="table table-hover text-center">
            <tr>
                <th>新着</th>
                <th>No.</th>
                <th>患者名</th>
                <th>患者本人</th>
                <th>患者以外</th>
                <th>診療日時</th>
                <th>更新日時</th>
            </tr>
            @foreach ($surveys as $survey)
            <tr onclick="location.href='/survey/{{$survey->event_id}}'">
                <td>
                    @if ($survey->checked_at == null)
                    未読
                    @endif
                </td>
                <td>{{ $survey->event_id }}</td>
                <td>{{ $survey->name }}</td>
                <td>
                    @if ($survey->count > 0)
                    回答あり
                    @else
                    未回答
                    @endif
                </td>
                <td>
                    @if ($survey->other_count > 0)
                    回答あり({{ $survey->other_count }})
                    @else
                    未回答
                    @endif
                </td>
                <td>{{ $survey->start }}</td>
                <td>{{ $survey->updated_at }}</td>
            </tr>
            @endforeach
            @if (count($surveys) == 0)
            <tr>
                <td colspan="7">該当するアンケートが存在しません。</td>
            </tr>
            @endif
        </table>
        {{ $surveys->links() }}
    </div>
</div>
@endsection

@include('footer')

@section('script')
<script defer>
</script>
@endsection
