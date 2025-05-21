<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="w-100">
          <div class="card text-center">
            <p><strong>Login Successful</strong></p>
            <form action="/logout" method="POST">
              @csrf
              <button type="submit" class="btn w-100 text-white">Log Out</button>
            </form>
          </div>

          <div class="card">
            <h2>Create a New Post</h2>
            <form action="/create-post" method="POST">
              @csrf
              <input type="text" name="title" class="form-control mb-3" placeholder="Post Title" required>
              <textarea name="body" class="form-control mb-3" placeholder="Body Content" rows="5" required></textarea>
              <button type="submit" class="btn w-100 text-white">Save Post</button>
            </form>
          </div>

          <div class="card">
            <h2>User Posts</h2>
            @foreach ($posts as $post)
              <div class="post">
                <h4>{{ $post['title'] }}</h4>
                <h6>Posted By {{ $post->user->name }}</h6>
                <p>{{ $post['body'] }}</p>
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <a href="/edit-post/{{ $post->id }}">Edit</a>
                  <form action="/delete-post/{{ $post->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
</body>
</html>