<div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <ul class="menu p-4 w-80 h-full bg-slate-200  text-base-content">
      <!-- Sidebar content here -->
      <li class="py-2" onclick="window.location.href = '{{ route('admin') }}'"><span><i class='bx bx-home-alt '> Dashboard</i></span> </li>
      <li class="py-2" onclick="window.location.href = '{{ route('absensi') }}'"><i class='bx bx-calendar-check '> Absensi</i></li>
      <li class="py-2" onclick="window.location.href = '{{ route('manage') }}'"><i class='bx bx-user-check '> Kelola User</i></li>
      <li class="py-2"><i class='bx bx-user-circle'>Akun (soon)</i></li>
      <li class="py-2" onclick="window.location.href = '{{ route('logout') }}'"><i class='bx bx-user-circle'>Logout</i></li>
    </ul>
  </div>