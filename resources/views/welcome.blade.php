<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login Page</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="bg-[#202330] text-slate-300">
        <div class="flex flex-col justify-center items-center h-screen md:max-w-[400px] mx-auto w-screen p-16 md:p-8">
            @if (session('fail'))
                <div class="alert alert-warning my-8 text-center">
                   Login Gagal
                </div>
            @endif 
            <form method="post"  action="{{ route('login') }}">
          <div class="w-full border border-slate-700 p-8 rounded-xl flex flex-col items-center gap-y-6">
           

            <i class='bx bx-user-circle text-4xl mb-6'></i>
            <h1 class="text-3xl font-bold">login</h1>
            
                @csrf
                <input required type="text" name="username" id="username" placeholder="username" class='w-full p-2 border rounded border-slate-700 focus:outline-none bg-transparent text-slate-400 text-center' />
                <input required type="password" name="password" id="password" placeholder="password" class='w-full p-2 border rounded border-slate-700 focus:outline-none bg-transparent text-slate-400 text-center' />
                <button type="submit" class="py-2 px-4 bg-blue-900 rounded">login</button>
            </form>
          </div>
        </div>
      
    </body>
</html>
