@if (session('status'))
    <div class="bg-green-500 text-white p-3 text-center">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-500 text-white p-3 text-center">
        {{ session('error') }}
    </div>
@endif