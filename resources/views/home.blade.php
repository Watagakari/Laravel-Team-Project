<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All User Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background: #fff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
            padding: 15px;
            display: block;
        }
        .sidebar a:hover {
            background: #f0f0f0;
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
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar col-3">
            <h3 class="text-center">ForkLet</h3>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="/personal">Personal Post</a>
            <a href="/library">Library</a>
            <div class="text-center mt-3">
                <strong>John Doe</strong><br>
                <small>@johndoe</small><br>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block mt-2">Log Out</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container col-9 mt-5">
            <h2 class="text-center">For You</h2>
            @foreach ($posts as $post)
                <div class="post">
                    <h4>{{ $post['title'] }}</h4>
                    <form action="/library/save/{{ $post->id }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-outline-primary btn-sm mt-2">
        <i class="fas fa-bookmark"></i> Save to Library
    </button>
</form>
                    <p class="user-info">{{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post['location'] }}</p>
                    <p>{{ $post['body'] }}</p>
                    @if ($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
