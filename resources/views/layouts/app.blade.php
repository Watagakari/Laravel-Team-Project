<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ForkLet')</title>

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Custom CSS --}}
    <style>
        :root {
            --primary: #958433;
        }

        .font-cursive {
            font-family: cursive;
        }

        /* Ensure sidebar bottom section fixed */
        #sidebarBottom {
            bottom: 0;
            width: 18rem;
            background-color: #FCFBEF;
            border-top: 1px solid #E6E6E6;
            padding: 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            position: fixed;
            left: 0;
            z-index: 50;
            transition: width 0.3s;
        }

        /* Adjust width when sidebar collapsed */
        #sidebar.collapsed #sidebarBottom {
            width: 5rem;
            padding: 1.5rem 0.5rem;
        }
    </style>
</head>

<body class="bg-[#F7F8FA] text-[#3E3E3E] font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="flex flex-col bg-[#FCFBEF] border-r border-[#E6E6E6] transition-all duration-300 w-72 relative">
            <div>
                <h4 id="sidebarTitle"
                    class="text-[#958433] font-cursive font-bold text-2xl px-6 py-6 select-none flex items-center gap-3">
                    <span>ForkLet</span>
                </h4>
                <nav class="flex flex-col space-y-2 px-3">
                    <a href="/home"
                        class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
                        <i class="fas fa-home text-sm w-5 text-center"></i>
                        <span class="sidebar-text">Home</span>
                    </a>
                    <a href="/profile"
                        class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
                        <i class="fas fa-user text-sm w-5 text-center"></i>
                        <span class="sidebar-text">Profile</span>
                    </a>
                    <a href="/personal"
                        class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
                        <i class="fas fa-pencil-alt text-sm w-5 text-center"></i>
                        <span class="sidebar-text">Personal Post</span>
                    </a>
                    <a href="/library"
                        class="flex items-center gap-3 text-[#3E3E3E] text-sm leading-5 px-5 py-2.5 rounded-full hover:bg-[#F8F5EF] transition">
                        <i class="fas fa-book text-sm w-5 text-center"></i>
                        <span class="sidebar-text">Library</span>
                    </a>
                </nav>
            </div>
            <div id="sidebarBottom" class="mt-auto">
                <img id="sidebarAvatar" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                    alt="User avatar" class="w-10 h-10 rounded-full object-cover" width="40" height="40" />
                <p id="sidebarUserName" class="font-semibold text-[#3E3E3E] text-sm leading-5 select-text m-0">
                    {{ Auth::user()->name }}
                </p>
                <form id="sidebarLogoutForm" action="/logout" method="POST" class="w-full text-center m-0">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center gap-2 text-[#958433] font-semibold text-sm leading-5 hover:underline w-full">
                        <i class="fas fa-sign-out-alt"></i> <span class="sidebar-text">Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header
                class="flex items-center justify-between bg-white border-b border-[#E6E6E6] px-6 py-4 sticky top-0 z-30">
                <button id="toggleSidebarBtn" aria-label="Toggle sidebar"
                    class="text-[#3E3E3E] text-xl focus:outline-none" title="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="font-semibold text-[#958433] text-lg leading-6 font-cursive select-none">
                    @yield('header_title', 'ForkLet')
                </h2>
                <div>
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="User avatar"
                        class="w-10 h-10 rounded-full object-cover" width="40" height="40" />
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const sidebarTitle = document.getElementById('sidebarTitle');
        const sidebarUserName = document.getElementById('sidebarUserName');
        const sidebarLogoutForm = document.getElementById('sidebarLogoutForm');
        const sidebarBottom = document.getElementById('sidebarBottom');

        toggleBtn.addEventListener('click', () => {
            if (sidebar.classList.contains('w-72')) {
                // Collapse sidebar
                sidebar.classList.remove('w-72');
                sidebar.classList.add('w-20', 'collapsed');

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
                sidebar.classList.remove('w-20', 'collapsed');
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

        // Set active nav link based on current path
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('bg-[#958433]', 'text-white');
                    link.classList.remove('text-[#3E3E3E]', 'hover:bg-[#F8F5EF]');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
