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
            <h2>User Posts</h2>
            @foreach ($posts as $post)
              <div class="post">
                <h4>{{ $post['title'] }}</h4>
                <h6>Posted By {{ $post->user->name }}</h6>
                <p>{{ $post['body'] }}</p>
            @endforeach
          </div>
        </div>
</body>
</html>
