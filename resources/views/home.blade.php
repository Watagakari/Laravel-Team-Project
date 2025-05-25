<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All User Posts</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <style>
    :root {
      --primary: #958433;
    }

    body {
      background-color: #f8f9fa;
      margin: 0;
    }

    .wrapper {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
    font-family: Poppins;
    background-color: #fff;
    width: 250px;
    transition: width 0.3s ease;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    position: relative;
    }

    .sidebar.collapsed {
      width: 70px;
    }

    .sidebar h4 {
      color: var(--primary);
      padding: 1rem;
      text-align: center;
    }

    .sidebar a {
      text-decoration: none;
      color: #333;
      padding: 15px;
      display: block;
      transition: all 0.2s;
    }

    .sidebar a:hover {
      background: #f0f0f0;
    }

    .sidebar .user-info {
      font-size: 14px;
      color: #666;
      padding: 0 1rem;
    }

    .sidebar.collapsed a,
    .sidebar.collapsed .user-info,
    .sidebar.collapsed .logout-area {
      display: none;
    }

    .logout-area {
      position: absolute;
      bottom: 1rem;
      width: 100%;
      padding: 0 1rem;
    }

    .header {
      background-color: #ffffff;
      border-bottom: 1px solid #dee2e6;
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .btn-toggle {
      background-color: var(--primary);
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 5px;
    }

    .btn-toggle:hover {
      background-color: #7d702c;
    }

    .btn-outline-primary {
      border-color: var(--primary);
      color: var(--primary);
    }

    .btn-outline-primary:hover {
      background-color: var(--primary);
      color: white;
    }

    .post {
      background: #ffffff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .user-avatar img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }

  </style>
</head>
<body>
  <div class="header">
    <button class="btn-toggle" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </button>
    <h2 class="m-0" style="color: var(--primary);">For You</h2>
    <div class="user-avatar">
      <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="avatar" />
    </div>
  </div>

  <div class="wrapper">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
      <h4 class="text-center py-3" style="color: var(--primary);">ForkLet</h4>
      <a href="/home">Home</a>
      <a href="/profile">Profile</a>
      <a href="/personal">Personal Post</a>
      <a href="/library">Library</a>

      <div class="user-info mt-3">
        <strong>{{ Auth::user()->name }}</strong><br>

      </div>

      <div class="logout-area">
        <form action="/logout" method="POST">
          @csrf
          <button type="submit" class="btn btn-block" style="background-color: #958433; color: #fff;">Log Out</button>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
      @foreach ($posts as $post)
        <div class="post">
          <h4>{{ $post['title'] }}</h4>
          <form action="/library/save/{{ $post->id }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-primary btn-sm mt-2">
              <i class="fas fa-bookmark"></i> Save to Library
            </button>
          </form>
          <p class="user-info">
            {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post['location'] }}
          </p>
          <p>{{ $post['body'] }}</p>
          @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
          @endif
        </div>
      @endforeach
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
    }
  </script>
</body>
</html>
