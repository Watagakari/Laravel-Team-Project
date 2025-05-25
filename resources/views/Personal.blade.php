<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Personal Post</title>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    rel="stylesheet"
  />
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
        <h4 id="sidebarTitle" class="text-[#958433] font-cursive font-bold text-2xl px-6 py-6 select-none flex items-center gap-3" style="font-family: cursive;">
          <span>ForkLet</span>
        </h4>
        <nav class="flex flex-col space-y-2 px-3">
          <a href="/home" class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
            <i class="fas fa-home text-sm w-5 text-center"></i>
            <span class="sidebar-text">Home</span>
          </a>
          <a href="/profile" class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
            <i class="fas fa-user text-sm w-5 text-center"></i>
            <span class="sidebar-text">Profile</span>
          </a>
          <a href="/personal" class="flex items-center gap-3 bg-[#958433] text-white rounded-full px-5 py-2.5 font-semibold text-sm leading-5">
            <i class="fas fa-pencil-alt text-sm w-5 text-center"></i>
            <span class="sidebar-text">Personal Post</span>
          </a>
          <a href="/library" class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
            <i class="fas fa-book text-sm w-5 text-center"></i>
            <span class="sidebar-text">Library</span>
          </a>
        </nav>
      </div>
      <div class="border-t border-[#E6E6E6] px-6 py-6 mt-auto flex flex-col items-center gap-4">
        <img
          id="sidebarAvatar"
          src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
          alt="User avatar"
          class="w-10 h-10 rounded-full object-cover"
          width="40"
          height="40"
        />
        <p id="sidebarUserName" class="font-semibold text-[#3E3E3E] text-sm leading-5 select-text">
          {{ Auth::user()->name }}
        </p>
        <form id="sidebarLogoutForm" action="/logout" method="POST" class="w-full text-center">
          @csrf
          <button
            type="submit"
            class="flex items-center justify-center gap-2 text-[#958433] font-semibold text-sm leading-5 hover:underline w-full"
          >
            <i class="fas fa-sign-out-alt"></i> <span class="sidebar-text">Log Out</span>
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
          Personal Post
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
      <main class="flex-1 overflow-auto p-6 bg-[#F7F8FA] max-w-4xl mx-auto w-full">
        <section class="bg-white rounded-lg p-6 shadow mb-6">
          <h2 class="text-xl font-semibold mb-4">Create a New Post</h2>
          <form action="/create-post" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input
              type="text"
              name="title"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#958433]"
              placeholder="Post Title"
              required
            />
            <textarea
              name="body"
              rows="5"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#958433]"
              placeholder="Body Content"
              required
            ></textarea>
            <input
              type="text"
              name="cp"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#958433]"
              placeholder="Contact Person"
              required
            />
            <input
              type="text"
              name="location"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#958433]"
              placeholder="Location"
              required
            />
            <input
              type="file"
              name="image"
              accept="image/*"
              class="w-full"
            />
            <button
              type="submit"
              class="w-full bg-[#958433] text-white font-semibold py-2 rounded hover:bg-[#7a6f28] transition"
            >
              Save Post
            </button>
          </form>
        </section>

        <section class="bg-white rounded-lg p-6 shadow">
          <h2 class="text-xl font-semibold mb-4">Your Posts</h2>
          @foreach ($posts as $post)
          <article class="mb-6 border border-gray-200 rounded-lg p-4">
            <h4 class="font-semibold text-[#3E3E3E] text-lg mb-2">{{ $post['title'] }}</h4>
            <p class="text-[#7D7D7D] text-sm mb-2">
              Posted By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post['location'] }}
            </p>
            <p class="text-[#3E3E3E] mb-4">{{ $post['body'] }}</p>
            @if ($post->image_path)
            <img
              src="{{ asset('storage/' . $post->image_path) }}"
              alt="Post Image"
              class="rounded-lg max-h-[400px] w-full object-cover mb-4"
            />
            @endif
            <div class="flex justify-between items-center">
              <a href="/edit-post/{{ $post->id }}" class="text-[#958433] font-semibold hover:underline">Edit</a>
              <form action="/delete-post/{{ $post->id }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700 transition">
                  Delete
                </button>
              </form>
            </div>
          </article>
          @endforeach
        </section>
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