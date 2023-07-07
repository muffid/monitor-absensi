<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$data['username']}} - Dashboard | Smart Attendance System</title>

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
    <body class="bg-[#202330] text-slate-300 min-h-screen ">

     <div class="flex flex-col p-6 gap-y-2" >
        <div class="drawer">
            <input id="my-drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
              <!-- Page content here -->
              <div class="flex flex-row justify-between items-center gap-4 ">
                <label for="my-drawer" class=" flex flex-row items-center gap-2 cursor-pointer drawer-button"><i class='bx bx-menu text-2xl'></i>Menu</label>
            </div>

            </div> 
            @include('user.sidebar')
          </div>


          {{-- content --}}
          <div class="flex flex-col gap-3">
            <div class="flex flex-col items-center gap-1 mt-4">
                <img src={{$data['img']}} alt="logo" class="w-20 h-20 rounded-full object-cover">
                <h1 class="text-2xl font-bold text-center mt-2">{{$data['username']}}</h1>
                <h1 class="text-center text-sm text-slate-500">{{$data['nama_lengkap']}}</h1>

                <h1 class=" mt-1 py-1 px-2  text-xs rounded-md font-semibold
                    @if($data['absensi']['status'] == "Kerja")
                        text-green-900 bg-green-400
                    @elseif($data['absensi']['status'] == "Off Work")
                        text-red-900 bg-red-400
                    @elseif($data['absensi']['status'] == "Istirahat")
                        text-yellow-900 bg-yellow-400
                    @else
                        text-blue-900 bg-blue-400
                    @endif
                    ">{{$data['absensi']['status']}}
                </h1>

                <div class="grid grid-cols-3 mt-8  gap-6">
                    <div class="flex flex-col items-start bg-slate-900 p-6 rounded-lg gap-2">
                        <h1 class="text-sm text-slate-500 ">Masuk</h1>
                        <h1 class="text-xl text-white font-semibold">{{$data['absensi']['jam_masuk']}}</h1>
                    </div>
                    <div class="flex flex-col items-start  bg-slate-900 p-6 rounded-lg gap-2">
                        <h1 class="text-sm text-slate-500 ">Pulang</h1>
                        <h1 class="text-xl text-white font-semibold">{{$data['absensi']['jam_keluar']}}</h1>
                    </div>
                    <div class="flex flex-col items-start  bg-slate-900 p-6 rounded-lg gap-2">
                        <h1 class="text-sm text-slate-500 ">Rehat</h1>
                        <h1 class="text-xl text-white font-semibold">{{$data['absensi']['jam_rest']}}</h1>
                    </div>
                    <div class="flex flex-col items-start  bg-slate-900 p-6 rounded-lg gap-2">
                        <h1 class="text-sm text-slate-500 ">Kembali</h1>
                        <h1 class="text-xl text-white font-semibold">{{$data['absensi']['jam_kembali']}}</h1>
                    </div>
                    <div class="flex flex-col items-start  bg-slate-900 p-6 rounded-lg gap-2" >
                        <h1 class="text-sm text-slate-500 ">Tot Rehat</h1>
                        <h1 class="text-xl text-white font-semibold">{{$data['absensi']['jam_rehat']}} <span>{{$data['absensi']['menit_rehat']}}</span></h1>
                    </div>
                    <div class="flex flex-col items-start  bg-slate-900 p-6 rounded-lg gap-2">
                        <h1 class="text-sm text-slate-500 ">Jam Kerja</h1>
                        <h1 class="text-xl text-white font-semibold">{{$data['absensi']['jam']}} <span>{{$data['absensi']['menit']}}</span></h1>
                    </div>
                </div>
                <h1 id="reload-message" class="text-xs text-slate-400 mt-4"></h1>
                
            </div>
          </div>
        
     </div>
    </body>
  <script>
    var count = 60;
    function showMessage() {
        document.getElementById('reload-message').innerText = 'update in ' + count + ' seconds';
        count--;
        if(count < 0){
            count = 0;
        }
    }

    setTimeout(function() {
        showMessage();
        setInterval(showMessage, 1000);
        setTimeout(function() {
            location.reload();
        }, 60000);
    }, 1000);
  </script>
</html>

