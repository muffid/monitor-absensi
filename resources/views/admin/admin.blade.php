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
                <h1 class="text-xs lg:text-base">SAS - Smart Attendance System | Polaris Adv</h1>
                <h1 class="hidden md:inline-block" id="reload-message"></h1>
              
            </div>

            </div> 
            @include('admin.sidebar')
          </div>


          {{-- content --}}
          <div class="flex flex-col w-full gap-6 mt-6 items-center justify-center">
            
              <div class="grid  grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 mt-6 w-full gap-4">
                @foreach ($data['absensi'] as $key => $value)
                <div class="flex flex-row items-center justify-between py-4 px-8 bg-slate-900 rounded-xl gap-x-6 mx-auto w-full ">
                    <div class="flex flex-col items-center gap-y-1">
                        <div class="w-16 h-16 rounded-full">
                            <?php 
                                $email = $value['nama']; // Ganti dengan alamat email yang sesuai
                                $hash = md5(strtolower(trim($email)));
                                $avatarUrl = $value['img'];
                            ?>
                            <?php $encryptId = encrypt($value['id']); ?>
                            <img  onclick="event.preventDefault(); window.location.href = '{{ route('info', ['id' => $encryptId, 'date' => $value['date']]) }}';" src={{$avatarUrl}} alt="logo" class="w-full h-full rounded-full object-cover cursor-pointer">
                        </div>
                        <h1 class="font-bold text-center text-xl cursor-pointer" onclick="event.preventDefault(); window.location.href = '{{ route('info', ['id' => $encryptId, 'date' => $value['date']]) }}';">{{$value['nama']}}</h1>
                        {{-- <h1 class="text-xs ">{{$value['nama_lengkap']}}</h1> --}}
                        <h1 class="py-1 px-2  text-xs rounded-md font-semibold
                            @if($value['status'] == "Kerja")
                                text-green-900 bg-green-400
                            @elseif($value['status'] == "Off Work")
                                text-red-900 bg-red-400
                            @elseif($value['status'] == "Istirahat")
                                text-yellow-900 bg-yellow-400
                            @else
                                text-blue-900 bg-blue-400
                            @endif
                            ">{{$value['status']}}
                        </h1>
                    </div>
                    <div class="grid grid-cols-3 md:grid-cols-4 lg:gap-8 gap-4">
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Absen</h1>
                            <h1 class="text-lg">{{$value['jam_masuk']}}</h1>
                        </div>
    
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Pulang</h1>
                            <h1 class="text-lg">{{$value['jam_keluar']}}</h1>
                        </div>
                        
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Rehat</h1>
                            <h1 class="text-lg">{{$value['jam_rest']}}</h1>
                        </div>
                        
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Kembali</h1>
                            <h1 class="text-lg">{{$value['jam_kembali']}}</h1>
                        </div>
    
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Tot Rehat</h1>
                            <h1 class="text-lg">{{$value['jam_rehat']}} {{$value['menit_rehat']}}</h1>
                        </div>
    
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Tot Kerja</h1>
                            <h1 class="text-lg">{{$value['jam']}} {{$value['menit']}}</h1>
                        </div>
                    </div>
                  </div> 
                @endforeach
              </div>
             <div class="w-full py-2 flex items-center justify-center border-b-2 border-slate-500 "></div>
             <div class="grid  grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 mt-6 w-full gap-4">
                @foreach ($data['absensi_magang'] as $key => $value)
                <div class="flex flex-row items-center justify-between py-4 px-8 bg-slate-900 rounded-xl gap-x-6 mx-auto w-full ">
                    <div class="flex flex-col items-center gap-y-1">
                        <div class="w-16 h-16 rounded-full">
                            <?php 
                                $email = $value['nama']; // Ganti dengan alamat email yang sesuai
                                $hash = md5(strtolower(trim($email)));
                                $avatarUrl = $value['img'];

                            ?>
                             <?php $encryptId = encrypt($value['id']); ?>
                            <img  onclick="event.preventDefault(); window.location.href = '{{ route('info', ['id' => $encryptId, 'date' => $value['date']]) }}';" src={{$avatarUrl}} alt="logo" class="w-full h-full rounded-full object-cover cursor-pointer">
                        </div>
                        <h1 class="font-bold text-center text-xl cursor-pointer" onclick="event.preventDefault(); window.location.href = '{{ route('info', ['id' => $encryptId, 'date' => $value['date']]) }}';">{{$value['nama']}}</h1>
                        {{-- <h1 class="text-xs ">{{$value['nama_lengkap']}}</h1> --}}
                        <h1 class="py-1 px-2  text-xs rounded-md font-semibold
                            @if($value['status'] == "Kerja")
                                text-green-900 bg-green-400
                            @elseif($value['status'] == "Off Work")
                                text-red-900 bg-red-400
                            @elseif($value['status'] == "Istirahat")
                                text-yellow-900 bg-yellow-400
                            @else
                                text-blue-900 bg-blue-400
                            @endif
                            ">{{$value['status']}}
                        </h1>
                    </div>
                    <div class="grid grid-cols-3 md:grid-cols-4 lg:gap-8 gap-4">
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Absen</h1>
                            <h1 class="text-lg">{{$value['jam_masuk']}}</h1>
                        </div>
    
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Pulang</h1>
                            <h1 class="text-lg">{{$value['jam_keluar']}}</h1>
                        </div>
                        
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Rehat</h1>
                            <h1 class="text-lg">{{$value['jam_rest']}}</h1>
                        </div>
                        
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Kembali</h1>
                            <h1 class="text-lg">{{$value['jam_kembali']}}</h1>
                        </div>
    
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Tot Rehat</h1>
                            <h1 class="text-lg">{{$value['jam_rehat']}} {{$value['menit_rehat']}}</h1>
                        </div>
    
                        <div class="flex flex-col">
                            <h1 class="text-sm text-slate-500">Tot Kerja</h1>
                            <h1 class="text-lg">{{$value['jam']}} {{$value['menit']}}</h1>
                        </div>
                    </div>
                  </div> 
                @endforeach
              </div>
          </div>
     </div>
    </body>
    <script>
      
    var count = 60;
    function showMessage() {
        document.getElementById('reload-message').innerText = 'Data akan diperbarui setelah ' + count + ' detik';
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

