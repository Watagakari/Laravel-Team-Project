<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All User Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #958433;
        }

        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #fff;
            width: 250px;
            transition: all 0.3s ease;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            padding: 15px;
            display: block;
            transition: all 0.2s;
        }

        .sidebar a:hover {
            background: #f0f0f0;
        }

        .sidebar.collapsed a,
        .sidebar.collapsed .user-info {
            display: none;
        }

        .post {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .user-info {
            font-size: 14px;
            color: #666;
        }

        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .btn-toggle {
            background-color: var(--primary);
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
        }

        .btn-toggle:hover {
            background-color: #7d702c;
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <h4 class="text-center py-3" style="color: var(--primary);">ForkLet</h4>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="/personal">Personal Post</a>
            <a href="/library">Library</a>
            <div class="text-center mt-3 user-info">
                <strong>{{ Auth::user()->name }}</strong><br>
                <small>@{{ Auth::user()->username }}</small>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block mt-2">Log Out</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <div class="header">
                <button class="btn-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="m-0" style="color: var(--primary);">For You</h2>
                <div class="user-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="avatar" class="rounded-circle" width="40" height="40">
                </div>
            </div>

            <div class="container mt-4">
                @foreach ($posts as $post)
                    <div class="post">
                        <h4>{{ $post['title'] }}</h4>
                        <form action="/library/save/{{ $post->id }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm mt-2">
                                <i class="fas fa-bookmark"></i> Save to Library
                            </button>
                        </form>
                        <p class="user-info">
                            {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post['location'] }}
                        </p>
                        <p>{{ $post['body'] }}</p>
                        @if ($post->image_path)
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                        @endif
                    </div>
                @endforeach
            </div>
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
