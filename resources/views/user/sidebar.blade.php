<div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <ul class="menu p-4 w-80 h-full bg-slate-200  text-base-content">
      <!-- Sidebar content here -->
      
      <li class="py-2" onclick="window.location.href = '{{ route('user') }}'"><span><i class='bx bx-home-alt '> Dashboard</i></span> </li>
      <li class="py-2" onclick="event.preventDefault(); window.location.href = '{{ route('myabsensi', ['date' => $data['date']]) }}';"><i class='bx bx-calendar-check '> Absensi</i></li>
      <li class="py-2" onclick="window.location.href = '{{ route('logout') }}'"><i class='bx bx-user-circle'>Logout</i></li>
    </ul>
  </div>