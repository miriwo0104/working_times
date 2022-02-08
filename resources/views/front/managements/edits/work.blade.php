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
                        <h1>勤務情報編集</h1>
                    </div>
                    <div>
                        <form action="{{ route('management.edit.update.work', ['days_id' => $works->days_id, 'works_id' => $works->id]) }}" method="post">
                            @csrf
                            <div>
                                <div>
                                    @error('start_date_time')
                                        {{ $message }}
                                        <br>
                                    @enderror
                                    <label for="start_date_time">勤務開始時間</label>
                                    <input type="text" name="start_date_time" id="start_date_time" value="{{ $works->start_date_time }}">
                                </div>
                                <div>
                                    @error('end_date_time')
                                        {{ $message }}
                                        <br>
                                    @enderror
                                    <label for="end_date_time">勤務終了時間</label>
                                    <input type="text" name="end_date_time" id="end_date_time" value="{{ $works->end_date_time }}">
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