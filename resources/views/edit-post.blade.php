<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            margin-top: 0;
            font-size: 28px;
            color: #333;
        }
        input[type="text"], textarea {
            width: 95%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            height: 150px;
        }
        button {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Post</h1>
        <form action="/edit-post/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="title" value="{{ $post->title }}" placeholder="Post Title" required>
            <textarea name="body" placeholder="Post Content" required>{{ $post->body }}</textarea>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
