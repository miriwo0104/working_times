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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>