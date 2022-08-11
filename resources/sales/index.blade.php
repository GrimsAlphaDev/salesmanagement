@extends('../layouts/main')

@section('currentpage', 'Dashboard')

@section('content')
    <div class="flex flex-col justify-center items-center">
        <h1 class="text-3xl font-bold text-center">Welcome, {{ Auth::user()->name }}</h1>
        <p class="text-center">
            This is the Sales Management Web Service.
        </p>
    </div>
@endsection