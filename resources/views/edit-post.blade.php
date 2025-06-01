<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f7f6f3;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            padding: 36px 32px 32px 32px;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(149, 132, 51, 0.08);
        }
        h1 {
            margin-top: 0;
            font-size: 2rem;
            color: #958433;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 24px;
        }
        label {
            display: block;
            font-size: 1rem;
            color: #3E3E3E;
            margin-bottom: 6px;
            font-weight: 500;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            font-size: 1rem;
            background: #faf9f6;
            transition: border-color 0.2s;
        }
        input[type="text"]:focus, textarea:focus, input[type="file"]:focus {
            border-color: #958433;
            outline: none;
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        .img-preview {
            display: block;
            margin-bottom: 20px;
            max-width: 100%;
            max-height: 220px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(149, 132, 51, 0.08);
            object-fit: cover;
        }
        button {
            padding: 14px 32px;
            font-size: 1rem;
            background-color: #958433;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(149, 132, 51, 0.08);
            transition: background 0.2s, transform 0.1s;
        }
        button:hover {
            background-color: #7a6a29;
            transform: translateY(-2px) scale(1.03);
        }
        @media (max-width: 600px) {
            .container {
                padding: 18px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-edit" style="color:#958433;"></i> Edit Post</h1>
        <form action="/edit-post/{{ $post->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="title">Post Title</label>
            <input type="text" id="title" name="title" value="{{ $post->title }}" placeholder="Post Title" required>

            <label for="body">Post Content</label>
            <textarea id="body" name="body" placeholder="Post Content" required>{{ $post->body }}</textarea>

            <label for="cp">Contact Person</label>
            <input type="text" id="cp" name="cp" value="{{ $post->cp }}" placeholder="Contact Person" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="{{ $post->location }}" placeholder="Location" required>

            @if ($post->image_path)
                <label>Current Image</label>
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Current Image" class="img-preview">
            @endif

            <label for="image">Change Image</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit"><i class="fas fa-save"></i> Save Changes</button>
        </form>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</body>
</html>
