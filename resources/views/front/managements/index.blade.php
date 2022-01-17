<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勤務時間登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 id="time"></h1>
                    @if ( !isset($days) || $days['working_flag'] === config('const.flag.false') )
                    {{-- 出勤前のみ下記ボタンを表示 --}}
                        <form action={{ route('management.start.work') }} method="post">
                            @csrf
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit">
                                    出勤
                                </button>
                            </div>
                        </form>
                    @endif
                    @if (
                        isset($days) &&
                        $days['working_flag'] === config('const.flag.true') &&
                        $days['resting_flag'] === config('const.flag.false')
                    )
                        <div>出勤時間: {{ $days['works']['start_date_time'] }}</div>
                        {{-- 出勤中のみ下記ボタンを表示 --}}
                        <form action={{ route('management.end.work') }} method="post">
                            @csrf
                            <div class="d-grid gap-2">
                                <button class="btn btn-danger" type="submit">
                                    退勤
                                </button>
                            </div>
                        </form>
                    @endif
                    @if (
                        isset($days) &&
                        $days['working_flag'] === config('const.flag.true') &&
                        $days['resting_flag'] === config('const.flag.false') 
                    )
                    {{-- 出勤中のみ下記ボタンを表示 --}}
                        <form action={{ route('management.start.rest') }} method="post">
                            @csrf
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" type="submit">
                                    休憩開始
                                </button>
                            </div>
                        </form>
                    @endif
                    @if (
                        isset($days) &&
                        $days['working_flag'] === config('const.flag.true') &&
                        $days['resting_flag'] === config('const.flag.true')
                    )
                        <div>出勤時間: {{ $days['works']['start_date_time'] }}</div>
                        <div>休憩開始時間: {{ $days['rests']['start_date_time'] }}</div>
                        {{-- 休憩中のみ下記ボタンを表示 --}}
                        <form action={{ route('management.end.rest') }} method="post">
                            @csrf
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" type="submit">
                                    休憩終了
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <h5>過去の勤怠情報</h5>
                    </div>
                    @if (isset($pastDays))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">日にち</th>
                                    <th scope="col">稼働時間（h）</th>
                                    <th scope="col">実稼働時間（h）</th>
                                    <th scope="col">休憩時間（h）</th>
                                    <th scope="col">残業時間（h）</th>
                                </tr>
                            </thead>
                            @foreach ($pastDays as $pastDay)
                                <tbody>
                                    <tr>
                                        <td>{{ $pastDay['date'] }}</td>
                                        <td>{{ $pastDay['total_work_hour'] }}</td>
                                        <td>{{ $pastDay['total_actual_work_hour'] }}</td>
                                        <td>{{ $pastDay['total_rest_hour'] }}</td>
                                        <td>{{ $pastDay['total_overtime_hour'] }}</td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/time.js') }}"></script>