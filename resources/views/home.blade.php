<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>All User Posts</title>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    rel="stylesheet"
  />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary: #958433;
    }
  </style>
</head>
<body class="bg-[#F7F8FA] text-[#3E3E3E] font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside id="sidebar" class="flex flex-col bg-[#FCFBEF] border-r border-[#E6E6E6] transition-all duration-300 w-72">
      <div>
        <h4 class="text-[#958433] font-cursive font-bold text-2xl px-6 py-6 select-none" style="font-family: cursive;">
          ForkLet
        </h4>
        <nav class="flex flex-col space-y-2 px-3">
          <a href="/home" class="flex items-center gap-3 bg-[#958433] text-white rounded-full px-5 py-2.5 font-semibold text-sm leading-5">
            <i class="fas fa-home text-sm"></i>
            Home
          </a>
          <a href="/profile" class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
            <i class="fas fa-user text-sm"></i>
            Profile
          </a>
          <a href="/personal" class="flex items-center gap-3 text-[#3E3E3E] font-semibold text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
            <i class="fas fa-pencil-alt text-sm"></i>
            Personal Post
          </a>
          <a href="/library" class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
            <i class="fas fa-book text-sm"></i>
            Library
          </a>
        </nav>
      </div>
      <div class="border-t border-[#E6E6E6] px-6 py-6 mt-auto">
        <div class="flex items-center gap-3">
          <img
            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
            alt="User avatar"
            class="w-10 h-10 rounded-full object-cover"
            width="40"
            height="40"
          />
          <div>
            <p class="font-semibold text-[#3E3E3E] text-sm leading-5 select-text">
              {{ Auth::user()->name }}
            </p>
          </div>
        </div>
        <form action="/logout" method="POST" class="mt-4">
          @csrf
          <button
            type="submit"
            class="flex items-center gap-2 text-[#958433] font-semibold text-sm leading-5 hover:underline"
          >
            <i class="fas fa-sign-out-alt"></i> Log Out
          </button>
        </form>
      </div>
    </aside>

    <!-- Main content -->
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
          For You
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

      <!-- Content -->
      <main class="flex-1 overflow-auto p-6 bg-[#F7F8FA]">
        @foreach ($posts as $post)
        <article
          class="bg-white rounded-lg p-6 shadow max-w-4xl mx-auto mb-6"
          aria-label="Post by {{ $post->user->name }}"
        >
          <h4 class="font-semibold text-[#3E3E3E] text-lg mb-2">{{ $post['title'] }}</h4>
          <form action="/library/save/{{ $post->id }}" method="POST" class="mb-4">
            @csrf
            <button
              type="submit"
              class="inline-flex items-center gap-2 border border-[#958433] text-[#958433] text-sm font-semibold px-3 py-1.5 rounded hover:bg-[#958433] hover:text-white transition"
            >
              <i class="fas fa-bookmark"></i> Save to Library
            </button>
          </form>
          <p class="text-[#7D7D7D] text-sm mb-3">
            {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post['location'] }}
          </p>
          <p class="text-[#3E3E3E] text-base mb-4">{{ $post['body'] }}</p>
          @if ($post->image_path)
          <img
            src="{{ asset('storage/' . $post->image_path) }}"
            alt="Post image"
            class="rounded-lg max-h-[400px] w-full object-cover"
          />
          @endif
        </article>
        @endforeach
      </main>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');

    toggleBtn.addEventListener('click', () => {
      if (sidebar.classList.contains('w-72')) {
        sidebar.classList.remove('w-72');
        sidebar.classList.add('w-16');
        // Hide text in sidebar links except icons
        sidebar.querySelectorAll('a').forEach((link) => {
          link.querySelectorAll('span, svg, i').forEach((el) => {
            el.style.display = 'inline-block';
          });
          // Hide text nodes by setting opacity 0 and width 0
          link.childNodes.forEach((node) => {
            if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
              node.textContent = '';
            }
          });
        });
        // Hide sidebar header text
        const headerText = sidebar.querySelector('h4');
        if (headerText) headerText.textContent = 'F';
      } else {
        sidebar.classList.remove('w-16');
        sidebar.classList.add('w-72');
        // Restore sidebar links text
        const links = [
          { href: '/home', icon: 'fa-home', text: 'Home' },
          { href: '/profile', icon: 'fa-user', text: 'Profile' },
          { href: '/personal', icon: 'fa-pencil-alt', text: 'Personal Post' },
          { href: '/library', icon: 'fa-book', text: 'Library' },
        ];
        const navLinks = sidebar.querySelectorAll('a');
        navLinks.forEach((link, i) => {
          link.textContent = '';
          const icon = document.createElement('i');
          icon.className = `fas ${links[i].icon} text-sm`;
          link.appendChild(icon);
          link.insertAdjacentText('beforeend', ' ' + links[i].text);
          link.classList.remove('justify-center');
        });
        // Restore sidebar header text
        const headerText = sidebar.querySelector('h4');
        if (headerText) headerText.textContent = 'ForkLet';
      }
    });
  </script>
</body>
</html>