<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
   
        <title>{{$data['username']}} - rekaps | Smart Attendance System</title>
       
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
            @include('user.sidebar')
          </div>


          {{-- content --}}
         <div class="flex flex-col items-start gap-8 xl:px-8 mt-8">
            <div class="flex flex-row items-end justify-between w-full">
                <div class="flex flex-row items-center gap-4">
                    <img src={{$data['img']}} alt="logo" class="w-16 h-full object-cover rounded-full">
                    <div>
                        <h1 class="text-3xl">{{$data['username']}}</h1>
                        <h1 class="text-sm text-slate-500">{{$data['nama_lengkap']}}</h1>
                        <h1>Month : {{$data['date']}}</h1>
                    </div>
                </div>
                <button onclick="exportToExcel()" class="py-1 rounded px-3 bg-cyan-700"><i class='bx bxs-file-export'></i> <span class="text-sm">Export</span></button>
            </div>

            <div class="bg-slate-900 shadow overflow-x-scroll lg:overflow-hidden sm:rounded-lg w-full">
              <table id="tableRekap" class="min-w-full divide-y divide-gray-500 table-auto text-sm lg:text-base">
                <thead>
                  <tr>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      No
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Tanggal
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Absen
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Pulang
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Istrahat
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Kembali
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Lama Rehat
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Total Jam Kerja
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Jam Kerja Normal
                    </th>
                    <th class="px-6 py-3 bg-slate-700 text-left text-xs leading-4 font-medium text-gray-50 uppercase tracking-wider">
                      Overtime
                    </th>
                  </tr>
                 
                </thead>
                <tbody class=" divide-y divide-gray-700 text-slate-400">
                  <?php $no = 1; 
                 
                 for($i = 0; $i<sizeof($data['tabel']['Tanggal']); $i++){ ?>
                 
                  <tr>
                      <td class="px-6 py-4 whitespace-no-wrap">
                       {{$i+1}}
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Tanggal'][$i]}}
                      </td>
                  
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Masuk'][$i]}}
                      </td>
                 
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Pulang'][$i]}}
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Rehat'][$i]}}
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Kembali'][$i]}}
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Jam_Rehat'][$i]."j ".$data['tabel']['Min_Rehat'][$i]."m"}}
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Jam_Kerja_Actual'][$i]}}
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Jam_Kerja'][$i]}}
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap">
                        {{$data['tabel']['Overtime'][$i]}}
                      </td>
              </tr>
              <?php } $no++; ?>
             
                  <tr class="text-green-500">
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" py-2 px-6 ">Total (jam) </td>
                      <td class="py-2 px-6">{{$data['rekap']['Total_Actual']}}</td>
                  </tr>
                  <tr class="text-green-500">
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" py-2 px-6 ">kerja normal (jam)</td>
                      <td class="py-2 px-6">{{$data['rekap']['Total_Jam']}}</td>
                  </tr>
                  <tr class="text-green-500">
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" text-center"></td>
                      <td class=" py-2 px-6 ">overtime (jam)</td>
                      <td class="py-2 px-6">{{$data['rekap']['Total_Over']}}</td>
                  </tr>
                  <!-- Tambahkan baris lainnya sesuai dengan data yang Anda miliki -->
                </tbody>
              </table>

        
              </div>
            
         </div>
     </div>
        
    </body>
    <script>
      function exportToExcel() {
        
        var wb = XLSX.utils.table_to_book(document.getElementById('tableRekap'), { sheet: 'Sheet JS' });
        XLSX.writeFile(wb, document.title+".xlsx");
      }
    </script>
  
</html>

