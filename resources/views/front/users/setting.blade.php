<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Setting
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('user.setting.update') }}" method="post">
                        @csrf
                        <div>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            @error('default_work_time')
                                 {{ $message }}
                                 <br>
                            @enderror
                            <label for="default_work_time">基本稼働時間</label>
                            <input type="text" name="default_work_time" id="default_work_time" value="{{ $user->default_work_time }}">
                        </div>
                        <button type="submit">保存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/time.js') }}"></script>