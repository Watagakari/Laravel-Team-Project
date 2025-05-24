<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All User Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Optional: Bootstrap for styling -->
</head>
<body>
    <div class="container mt-5">
        <div class="card text-center mb-4">
            <p><strong>Login Successful</strong></p>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Log Out</button>
            </form>
        </div>

        <div class="card">
            <h2 class="card-header">User  Posts</h2>
            <div class="card-body">
                @foreach ($posts as $post)
                    <div class="post mb-4 border p-3 rounded">
                        <h4>{{ $post['title'] }}</h4>
                        <h6>Posted By: {{ $post->user->name }}</h6>
                        <p><strong>Contact Person:</strong> {{ $post['cp'] }}</p>
                        <p><strong>Location:</strong> {{ $post['location'] }}</p>
                        <p>{{ $post['body'] }}</p>
                        @if ($post->image_path)
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid" style="max-width: 100%; height: auto;">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
