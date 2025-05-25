<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>For You - ForkLet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        :root {
            --primary: #958433;
            --bg-light: #f8f9fa;
            --text-dark: #333;
            --card-bg: #fff;
        }

        body {
            background-color: var(--bg-light);
        }

        .sidebar {
            background: var(--card-bg);
            min-height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar a {
            text-decoration: none;
            color: var(--text-dark);
            padding: 15px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #f0f0f0;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .post {
            background: var(--card-bg);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .post:hover {
            transform: scale(1.01);
        }

        .user-info {
            font-size: 14px;
            color: #666;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar col-md-3 p-3" id="sidebar">
            <div class="text-center mb-4">
                <h3 class="text-primary" style="color: var(--primary);">ForkLet</h3>
                <button class="toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="/personal">Personal Post</a>
            <a href="/library">Library</a>
            <div class="text-center mt-3">
                <strong>{{ Auth::user()->name }}</strong><br>
                <small>{{ '@' . Str::slug(Auth::user()->name) }}</small><br>
                <form action="/logout" method="POST">
                    @csrf
                    </form>
                    <div style="position: absolute; bottom: 30px; left: 0; width: 100%; padding: 0 16px;">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block mt-2">Log Out</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container col-md-9 mt-5">
            <h2 class="text-center mb-4" style="color: var(--primary);">For You</h2>
            @forelse ($posts as $post)
                <div class="post">
                    <h4>{{ $post->title }}</h4>
                    <form action="/library/save/{{ $post->id }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-bookmark"></i> Save to Library
                        </button>
                    </form>
                    <p class="user-info mt-2">
                        {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post->location }}
                    </p>
                    <p>{{ $post->body }}</p>
                    @if ($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                    @endif
                </div>
            @empty
                <p class="text-muted">No posts available.</p>
            @endforelse
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }
    </script>
</body>
</html>
