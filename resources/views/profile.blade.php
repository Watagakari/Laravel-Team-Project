<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profile</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary: #958433;
    }
    .font-cursive {
      font-family: cursive;
    }
  </style>
</head>
<body class="bg-[#F7F8FA] text-[#3E3E3E] font-sans">
<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside id="sidebar" class="flex flex-col bg-[#FCFBEF] border-r border-[#E6E6E6] transition-all duration-300 w-72">
    <div>
      <h4 id="sidebarTitle" class="text-[#958433] font-cursive font-bold text-2xl px-6 py-6 select-none flex items-center gap-3">
        <span>ForkLet</span>
      </h4>

      <nav class="flex flex-col space-y-2 px-3">
        <a href="/home" class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
          <i class="fas fa-home w-5 text-center"></i>
          <span class="sidebar-text">Home</span>
        </a>
        <a href="/profile" class="flex items-center gap-3 bg-[#958433] text-white rounded-full px-5 py-2.5 font-semibold text-sm leading-5">
          <i class="fas fa-user w-5 text-center"></i>
          <span class="sidebar-text">Profile</span>
        </a>
        <a href="/personal" class="flex items-center gap-3 text-[#3E3E3E] text-sm font-semibold leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
          <i class="fas fa-pencil-alt w-5 text-center"></i>
          <span class="sidebar-text">Personal Post</span>
        </a>
        <a href="/library" class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
          <i class="fas fa-book w-5 text-center"></i>
          <span class="sidebar-text">Library</span>
        </a>
      </nav>
    </div>
    <div class="border-t border-[#E6E6E6] px-6 py-6 mt-auto flex flex-col items-center gap-4">
      <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="User avatar" class="w-10 h-10 rounded-full object-cover" />
      <p id="sidebarUserName" class="font-semibold text-[#3E3E3E] text-sm leading-5">{{ Auth::user()->name }}</p>
      <form id="sidebarLogoutForm" action="/logout" method="POST" class="w-full text-center">
        @csrf
        <button type="submit" class="flex items-center justify-center gap-2 text-[#958433] font-semibold text-sm leading-5 hover:underline w-full">
          <i class="fas fa-sign-out-alt"></i> <span class="sidebar-text">Log Out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">
    <!-- Header -->
    <header class="flex items-center justify-between bg-white border-b border-[#E6E6E6] px-6 py-4 sticky top-0 z-30">
      <button
        id="toggleSidebarBtn"
        aria-label="Toggle sidebar"
        class="text-[#3E3E3E] text-xl focus:outline-none"
        title="Toggle sidebar"
      >
        <i class="fas fa-bars"></i>
      </button>
      <h2 class="font-semibold text-[#958433] text-lg leading-6 font-cursive select-none" style="font-family: cursive;">
        Profile Editor
      </h2>
      <div>
        <img
          src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
          alt="User avatar"
          class="w-10 h-10 rounded-full object-cover"
          width="40"
          height="40"
        />
      </div>
    </header>

    <main class="p-6 flex-1 overflow-auto">
      <div class="max-w-xl mx-auto bg-white shadow rounded-lg p-6">

        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="User avatar" class="w-20 h-20 rounded-full object-cover mb-4" />

        @if ($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Form Update Profil -->
        <form action="/profile/update" method="POST" class="space-y-4">
          @csrf
          @method('PUT')

          <div>
            <label for="name" class="block text-sm font-semibold">New Username</label>
            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                   class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-[#958433]" required>
          </div>

          <div>
            <label for="password" class="block text-sm font-semibold">New Password</label>
            <input type="password" name="password" id="password"
                   class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-[#958433]" required>
          </div>

          <div class="flex justify-end mt-6">
            <button type="submit"
                    class="bg-[#958433] hover:bg-[#7c702a] text-white font-semibold px-4 py-2 rounded">
              Save Changes
            </button>
          </div>
        </form>

        <!-- Form Hapus Akun -->
        <form action="/profile/delete" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this account? All posts and data will be lost.');" class="mt-4">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded w-full">
            Delete Account
          </button>
        </form>
      </div>
    </main>
  </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');
    const sidebarTitle = document.getElementById('sidebarTitle');
    const sidebarUserName = document.getElementById('sidebarUserName');
    const sidebarLogoutForm = document.getElementById('sidebarLogoutForm');

    toggleBtn.addEventListener('click', () => {
      if (sidebar.classList.contains('w-72')) {
        // Collapse sidebar
        sidebar.classList.remove('w-72');
        sidebar.classList.add('w-20');

        // Change sidebar title to single letter and center it
        sidebarTitle.classList.add('justify-center', 'px-0');
        sidebarTitle.innerHTML = '<span>F</span>';

        // Hide all sidebar text except icons
        sidebar.querySelectorAll('nav a').forEach((link) => {
          link.classList.add('justify-center', 'px-0');
          const icon = link.querySelector('i');
          icon.classList.add('mx-auto');
          // Hide text spans
          const textSpan = link.querySelector('.sidebar-text');
          if (textSpan) textSpan.style.display = 'none';
        });

        // Hide username text and logout form completely
        sidebarUserName.style.display = 'none';
        sidebarLogoutForm.style.display = 'none';
      } else {
        // Expand sidebar
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-72');

        // Restore sidebar title
        sidebarTitle.classList.remove('justify-center', 'px-0');
        sidebarTitle.innerHTML = '<span>ForkLet</span>';

        // Restore nav links text and alignment
        sidebar.querySelectorAll('nav a').forEach((link) => {
          link.classList.remove('justify-center', 'px-0');
          const icon = link.querySelector('i');
          icon.classList.remove('mx-auto');
          const textSpan = link.querySelector('.sidebar-text');
          if (textSpan) textSpan.style.display = 'inline';
        });

        // Show username and logout form
        sidebarUserName.style.display = 'block';
        sidebarLogoutForm.style.display = 'block';
      }
    });
  </script>
</body>
</html>
