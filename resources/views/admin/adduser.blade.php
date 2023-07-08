<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tambah user baru</title>

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
               
            <h1 class="text-center text-red-500">gagal menyimpan</h1>
              
            @endif 
            @if (session('success'))
                
                  <h1 class="text-center text-green-500">user ditambahkan!</h1>
                
            @endif 
            <form action="/upload" method="POST"  enctype="multipart/form-data">
                <h1 onclick="window.location.href = '{{ route('admin') }}'" class="text-center text-blue-300 mb-6 mt-4 cursor-pointer text-sm"><span><i class='bx bx-home'></i></span> Kembali ke dashboard</h1>
          <div class="w-full border border-slate-700 p-8 rounded-xl flex flex-col items-center gap-y-6">
           
            <h1 class="text-3xl font-bold">User Baru</h1>
            
           
                @csrf
                <input required type="text" name="id" id="id" placeholder="id" class='w-full p-2 border rounded border-slate-700 focus:outline-none bg-transparent text-slate-400' />
                <input required type="text" name="username" id="username" placeholder="username" class='w-full p-2 border rounded border-slate-700 focus:outline-none bg-transparent text-slate-400 ' />
                <input required type="text" name="nama_lengkap" id="nama_lengkap" placeholder="nama lengkap" class='w-full p-2 border rounded border-slate-700 focus:outline-none bg-transparent text-slate-400 ' />
                <div class="space-x-2 text-sm">
                    <label for="user" class="inline-flex items-center">
                      <input  type="radio" id="user" name="role" value="user" class="form-radio text-indigo-600">
                      <span class="ml-2 cursor-pointer">Karyawan</span>
                    </label>
                    <label for="magang" class="inline-flex items-center">
                      <input type="radio" id="magang" name="role" value="magang" class="form-radio text-indigo-600">
                      <span class="ml-2 cursor-pointer">Magang</span>
                    </label>
                  </div>
                
                <div class="relative">
                    <input type="file" id="file" name="image" class="opacity-0 absolute left-0 top-0 w-full "
                      onchange="previewFile()">
                
                    <div id="file-preview" class="file-preview text-slate-300 py-2 px-4 border cursor-pointer border-gray-600 rounded-lg shadow-sm flex justify-between items-center">
                      <span id="file-name" class="text-sm ">Pilih file...</span>
                        
                    </div>
                   
                  </div>
                  <div id="image-preview-container ">
                    <img id="image-preview" class="image-preview w-24 h-24 object-cover rounded-lg" src="https://iili.io/HsqJcNI.png" alt="">
                </div>
                <div class="flex flex-row items-center gap-4">
                    <button onclick="window.location.href = '{{ route('admin') }}'" class="bg-red-600 py-2 px-4 cursor-pointer text-sm rounded">Batal</button>
                    <button id="saveButton" type="submit" class="bg-green-700 text-sm cursor-pointer text-white font-semibold py-2 px-4 rounded">
                       simpan
                    </button>
                </div>
            </form>
                  
           
          </div>
        </div>
      
    </body>
   
<script>
     function previewFile() {
        var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var preview = document.getElementById("image-preview");
                preview.src = reader.result;
                preview.style.display = "block";
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
    }
</script>
   
</html>
