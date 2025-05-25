<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For You</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #f9f9f9, #e9ecef);
        }
        .sidebar {
            width: 250px;
            background: white;
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            padding: 20px;
        }
        .sidebar a {
            color: #333;
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: 0.2s;
        }
        .sidebar a:hover {
            background: #f0f0f0;
        }
        .content {
            margin-left: 270px;
            padding: 40px 20px;
        }
        .post {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .user-info {
            font-size: 14px;
            color: #888;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">ForkLet</h4>
        <a href="#">Home</a>
        <a href="#">Profile</a>
        <a href="/personal">Personal Post</a>
        <a href="/library">Library</a>
        <div class="mt-4 text-center">
            <strong>{{ auth()->user()->name }}</strong><br>
            <small>{{ '@' . auth()->user()->username }}</small>
            <form action="/logout" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm btn-block">Log Out</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mb-4 text-center text-secondary">For You</h2>

        @foreach ($posts as $post)
            <div class="post">
                <div class="d-flex align-items-center mb-2">
                    @if ($post->user->avatar)
                        <img src="{{ asset('storage/' . $post->user->avatar) }}" class="avatar">
                    @else
                        <img src="https://via.placeholder.com/40" class="avatar">
                    @endif
                    <div>
                        <strong>{{ $post->user->name }}</strong><br>
                        <small class="text-muted">{{ '@' . $post->user->username }}</small>
                    </div>
                </div>

                <h4>{{ $post->title }}</h4>
                <p class="user-info">
                    {{ $post->created_at->diffForHumans() }} • {{ $post->location }}
                </p>
                <p>{{ $post->body }}</p>

                @if ($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid rounded mb-3" style="max-height: 400px; object-fit: cover;">
                @endif

                <form action="/library/save/{{ $post->id }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-bookmark"></i> Save to Library
                    </button>
                </form>
            </div>
        @endforeach
    </div>

</body>
</html>
