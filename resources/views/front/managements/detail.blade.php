<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            勤務時間詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <h1>{{ $days['date'] }}の勤怠詳細情報</h1>
                    </div>
                    <div>
                        <h5>作業の詳細情報</h5>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">開始時間</th>
                                        <th scope="col">終了時間</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($days['works'] as $work)
                                        <tr>
                                            <td>{{ $work['start_date_time'] }}</td>
                                            <td>{{ $work['end_date_time'] }}</td>
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-info">編集</button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-danger">削除</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <h5>休憩の詳細情報</h5>
                    </div>
                    <div>
                        @if (isset($days['rests'][0]))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">開始時間</th>
                                        <th scope="col">終了時間</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($days['rests'] as $rest)
                                        <tr>
                                            <td>{{ $rest['start_date_time'] }}</td>
                                            <td>{{ $rest['end_date_time'] }}</td>
                                            <td>
                                                <a href="">
                                                    <button class="btn btn-info">編集</button>
                                                </a>
                                                <a href="">
                                                    <button class="btn btn-danger">削除</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6>休憩情報はありません</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>