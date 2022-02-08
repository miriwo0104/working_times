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
                        <h1>休憩情報編集</h1>
                    </div>
                    <div>
                        <form action="{{ route('management.edit.update.rest', ['days_id' => $rests->days_id, 'rests_id' => $rests->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="rests_id" value="">
                            <div>
                                <div>
                                    @error('start_date_time')
                                        {{ $message }}
                                        <br>
                                    @enderror
                                    <label for="start_date_time">休憩開始時間</label>
                                    <input type="text" name="start_date_time" id="start_date_time" value="{{ $rests->start_date_time }}">
                                </div>
                                <div>
                                    @error('end_date_time')
                                        {{ $message }}
                                        <br>
                                    @enderror
                                    <label for="end_date_time">休憩終了時間</label>
                                    <input type="text" name="end_date_time" id="end_date_time" value="{{ $rests->end_date_time }}">
                                    <div>※yyyy-mm-dd HH:MM:SSの形式で入力してください</div>
                                </div>
                                <button class="btn btn-primary" type="submit">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>