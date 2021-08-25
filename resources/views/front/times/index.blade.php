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
                    <form action={{ route('time.management.register_start_work') }} method="post">
                        @csrf
                        <button>
                            出勤
                        </button>
                    </form>
                    <form action={{ route('time.management.register_end_work') }} method="post">
                        @csrf
                        <button>
                            退勤
                        </button>
                    </form>
                    {{-- 出勤登録済み & 退勤前のみ下記ボタンを表示 --}}
                    @if (true)
                        <form action={{ route('time.management.register_start_rest') }} method="post">
                            @csrf
                            <button>
                                休憩開始
                            </button>
                        </form>
                        <form action={{ route('time.management.register_end_rest') }} method="post">
                            @csrf
                            <button>
                                休憩終了
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/time.js') }}"></script>