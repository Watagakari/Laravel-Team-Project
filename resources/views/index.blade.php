<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.05);
        }
        h2, h3, h5 {
            margin-top: 0;
        }
        input, textarea, button {
            width: 97%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .post {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">

    @auth
        <div class="card">
            <p><strong>Login Successful</strong></p>
            <form action="/logout" method="POST">
                @csrf
                <button>Log Out</button>
            </form>
        </div>

        <div class="card">
            <h2>Create a New Post</h2>
            <form action="/create-post" method="POST">
                @csrf
                <input type="text" name="title" placeholder="Post Title" required>
                <textarea name="body" placeholder="Body Content" rows="5" required></textarea>
                <button>Save Post</button>
            </form>
        </div>

        <div class="card">
            <h2>User Posts</h2>
            @foreach ($posts as $post)
                <div class="post">
                    <h3>{{ $post['title'] }}</h3>
                    <h5>Posted By {{ $post->user->name }}</h5>
                    <p>{{ $post['body'] }}</p>
                    <p><a href="/edit-post/{{ $post->id }}">Edit</a></p>
                    <form action="/delete-post/{{ $post->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <h2>Register</h2>
            <form action="/register" method="POST">
                @csrf
                <input name="name" type="text" placeholder="Name" required>
                <input name="email" type="email" placeholder="Email" required>
                <input name="password" type="password" placeholder="Password" required>
                <button>Submit</button>
            </form>
        </div>

        <div class="card">
            <h2>Login</h2>
            <form action="/login" method="POST">
                @csrf
                <input name="loginname" type="text" placeholder="Name" required>
                <input name="loginpassword" type="password" placeholder="Password" required>
                <button>Login</button>
            </form>
        </div>
    @endauth

    </div>
</body>
</html>
