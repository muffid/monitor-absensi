<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$data['username']}} - Absensi | Smart Attendance System</title>

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
              <div class="flex flex-row justify-between items-center ">
                <label for="my-drawer" class=" flex flex-row items-center gap-2 cursor-pointer drawer-button"><i class='bx bx-menu text-2xl'></i>Menu</label>
                <h1 class="text-xs lg:text-base">SAS - Smart Attendance System | Polaris Adv</h1>
               
              
            </div>

            </div> 
            @include('admin.sidebar')
          </div>


          {{-- content --}}
          <div class="grid  grid-cols-1 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 mt-6 w-full gap-4 md:gap-8">
            @foreach ($data['karyawan'] as $key => $value)
                <?php $encryptId = encrypt($value['id']); ?>
                <div onclick="event.preventDefault(); window.location.href = '{{ route('info', ['id' => $encryptId, 'date' => $data['date']]) }}';" class="flex flex-row items-center p-4 gap-4 rounded-lg hover:shadow-xl shadow-slate-950 bg-slate-900 cursor-pointer hover:scale-105 transition-transform ease-out">
                    <img src={{$value['img']}} alt="logo" class="w-16 h-full object-cover rounded-full">
                    <div class="flex flex-col items-start">
                        <h1 class="text-xl font-bold">{{$value['nama']}}</h1>
                        <h1 class="text-slate-400 text-sm">{{$value['full_name']}}</h1>
                        <h1 class="text-slate-500 text-xs">{{$value['id']}}</h1>
                    </div>
                </div>
            @endforeach
          </div>
         
     </div>
        
    </body>
    
  
</html>

