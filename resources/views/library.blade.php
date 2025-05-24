<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Library</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Your Saved Posts</h2>
        @if($posts->count())
            @foreach($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $post->title }}</h5>
                        <p>{{ $post->body }}</p>
                        <form action="{{ route('library.unsave', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p>You haven’t saved any posts yet.</p>
        @endif

    </div>
</body>
</html>
