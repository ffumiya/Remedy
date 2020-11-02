@extends('layouts.app')

@include('header')

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
        <table class="table table-striped text-center">
            <tr>
                <th></th>
                <th>No.</th>
                <th>患者名</th>
                <th>満足度</th>
                <th>コメント</th>
                <th>診療日時</th>
                <th>回答日時</th>
                <th></th>
            </tr>
            @foreach ($events as $event) <tr>
                <td>
                    @if ($event->survey_received_at == null)
                    未回収
                    @elseif ($event->survey_checked_at == null)
                    未読
                    @endif
                </td>
                <td>{{ $event->id }}</td>
                <td>{{ $event->name }}</td>
                <td>
                    {{ $event->survey_satisfaction_level }}
                </td>
                <td>
                    @if ($event->survey_comment_1 != null | $event->survey_comment_2 != null)
                    あり
                    @endif
                </td>
                <td>{{ $event->start }}</td>
                <td>{{ $event->survey_received_at }}</td>
                <td>
                    @if ($event->survey_comment_1 != null | $event->survey_comment_2 != null)
                    <a href="{{ route('survey.show', $event->id) }}" class="btn btn-success"><span
                            class="font-weight-bold">詳細</span></a>
                    @endif
                </td>
            </tr>
            @endforeach
            @if (count($events) == 0)
            <tr>
                <td colspan="7">該当するアンケートが存在しません。</td>
            </tr>
            @endif
        </table>
        {{ $events->links() }}
    </div>
</div>
@endsection

@include('footer')

@section('script')
<script defer>
</script>
@endsection
