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
            --sidebar-bg: #f8f9fa;
            --highlight-bg: #b2a254;
        }

        body {
            background-color:rgb(187, 167, 129);
        }

        .sidebar {
            background-color: #fff;
            width: 280px;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            position: fixed;
        }

        .sidebar h4 {
            padding: 1.5rem;
            font-weight: bold;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #333;
            text-decoration: none;
            border-radius: 999px;
            margin: 8px 12px;
            transition: 0.2s ease;
        }

        .sidebar a:hover {
            background-color: #f0f0f0;
        }

        .sidebar a.active {
            background-color: var(--primary);
            color: white;
            font-weight: bold;
        }

        .header {
            margin-left: 250px;
            background-color: #fff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header h2 {
            color: var(--primary);
            font-weight: bold;
        }

        .content {
            margin-left: 250px;
            padding: 2rem;
        }

        .post {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
}


        .post h4 {
            margin-bottom: 10px;
        }

        .post img {
            border-radius: 12px;
            max-height: 400px;
            object-fit: cover;
            width: 100%;
        }

        .user-info {
            font-size: 14px;
            color: #777;
        }

        .user-avatar img {
            border-radius: 50%;
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        .logout-btn {
            padding: 12px 24px;
            margin: 1rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <h4 style="color: var(--primary);">ForkLet</h4>
        <a href="#" class="active"><i class="fas fa-home mr-2"></i> Home</a>
        <a href="#"><i class="fas fa-user mr-2"></i> Profile</a>
        <a href="/personal"><i class="fas fa-pencil-alt mr-2"></i> Personal Post</a>
        <a href="/library"><i class="fas fa-book mr-2"></i> Library</a>
        <div class="mt-auto text-center mb-4">
            <div><strong>{{ Auth::user()->name }}</strong></div>
            <form action="/logout" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="btn logout-btn" style="background-color: #958433; color: white;">Log Out</button>
            </form>
        </div>
    </div>

    <!-- Header -->
    <div class="header">
        <h2>For You</h2>
        <div class="user-avatar">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="avatar" width="40" height="40">
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        @foreach ($posts as $post)
            <div class="post">
                <h4>{{ $post['title'] }}</h4>
                <form action="/library/save/{{ $post->id }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm mt-2 mb-2">
                        <i class="fas fa-bookmark"></i> Save to Library
                    </button>
                </form>
                <p class="user-info">
                    {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post['location'] }}
                </p>
                <p>{{ $post['body'] }}</p>
                @if ($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image">
                @endif
            </div>
        @endforeach
    </div>
</body>
</html>
