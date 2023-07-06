<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$data['username']}} - manage user | Smart Attendance System</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="bg-[#202330] text-slate-300 min-h-screen relative ">
        <div id="popup" class=" hidden fixed  w-screen h-screen rounded-lg p-4 flex-col items-center justify-center bg-slate-900/60">
           <div class="flex flex-col bg-slate-900 py-4 px-8 gap-2 rounded-lg mx-auto my-auto border border-white items-center">
                <h1 class="font-bold text-orange-500 text-xl"><span><i class='bx bxs-key'></i></span> Reset Password</h1>
                <p>Password akan direset menjadi default "111"</p>
                <p>lanjutkan ?</p>
                <div class="flex flex-row items-center justify-between gap-4 mt-2">
                    <h1 class="text-emerald-500 text-sm">ya, lanjutkan</h1>
                    <h1 onclick="closeConfirmation()" id="batal" class="text-orange-500 text-sm">batal</h1>
                </div>
           </div>
        </div>

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
            <div class="flex flex-col items-start gap-4 xl:px-8 mt-8  ">
                @foreach ($data['karyawan'] as $key => $value)
                    <div class="flex flex-row justify-between items-center gap-4 px-4 py-2 rounded-lg bg-slate-900 w-full lg:max-w-[1200px] mx-auto">
                        <div class=" flex flex-row items-center gap-2">
                                <img src={{$value['img']}} alt="logo" class="w-12 h-full object-cover rounded-full">
                                <h1 class="text-xl font-bold ml-8">{{$value['nama']}}</h1>
                                <h1 class="text-slate-400 text-sm hidden lg:inline-block">{{$value['full_name']}}</h1>
                                {{-- <h1 class="text-slate-500 text-xs">{{$value['id']}}</h1> --}}
                            </div>
                            <div class=" flex flex-row items-center gap-4 text-xs">
                                <h1 onclick="showConfirmation({{$value['id']}},'reset')" class="py-1 px-2 border border-orange-500 rounded cursor-pointer" title="reset password"><i class='bx bxs-key'></i></h1>
                                <h1 class="py-1 px-2 border border-green-600 rounded cursor-pointer" title="edit user"><i class='bx bxs-user-detail'></i></h1>
                                <h1 class="py-1 px-2 border border-yellow-600 rounded cursor-pointer" title="ganti kartu"><i class='bx bx-transfer'></i></h1>
                                <h1 class="py-1 px-2 border border-red-600 rounded cursor-pointer" title="hapus kartu"><i class='bx bxs-trash'></i></h1>
                            </div>
                    </div>
                @endforeach
            </div>
    </body>
    <script>
      function exportToExcel() {
        var wb = XLSX.utils.table_to_book(document.getElementById('tableRekap'), { sheet: 'Sheet JS' });
        XLSX.writeFile(wb, document.title+".xlsx");
      }

      function showConfirmation(id, action){
        console.log(id+" "+action);
        var popUp = document.getElementById("popup");
        popUp.classList.remove('hidden');
        popUp.classList.add('flex');
      }

      function closeConfirmation(){
        var popUp = document.getElementById("popup");
        popUp.classList.remove('flex');
        popUp.classList.add('hidden');
      }
    </script>
  
</html>

