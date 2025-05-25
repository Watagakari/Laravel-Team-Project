<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>For You</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(to bottom right, #f8f9fa, #eaeef2);
    }
    .sidebar {
      width: 250px;
      transition: margin-left 0.3s;
    }
    .sidebar.collapsed {
      margin-left: -250px;
    }
    .post-card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
    .toggle-btn {
      border: none;
      background: transparent;
    }
  </style>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar bg-white shadow-sm position-fixed h-100">
      <h4 class="text-center py-3 text-success">ForkLet</h4>
      <a href="#" class="d-block px-4 py-2 text-dark">Home</a>
      <a href="#" class="d-block px-4 py-2 text-dark">Profile</a>
      <a href="/personal" class="d-block px-4 py-2 text-dark">Personal Post</a>
      <a href="/library" class="d-block px-4 py-2 text-dark">Library</a>
      <div class="text-center mt-3">
        <strong>John Doe</strong><br>
        <small>@johndoe</small><br>
        <form action="/logout" method="POST" class="mt-2">
          <button type="submit" class="btn btn-danger btn-sm">Log Out</button>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1" style="margin-left:250px;" id="main-content">
      <!-- Header -->
      <div class="sticky-top bg-white d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
        <div class="d-flex align-items-center">
          <button id="toggleSidebar" class="toggle-btn mr-3">
            <i class="fas fa-bars"></i>
          </button>
          <h4 class="mb-0 text-success">For You</h4>
        </div>
        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&h=150&fit=crop&crop=face" class="avatar border border-success">
      </div>

      <!-- Post List -->
      <div class="container py-4">
        <div id="postContainer"></div>
      </div>
    </div>
  </div>

  <!-- Post Data and JS -->
  <script>
    const posts = [
      {
        id: 1,
        author: "Alexander Chen",
        username: "@alexchen",
        avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face",
        content: "Just launched our new sustainable packaging initiative! 🌱",
        image: "https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=600&fit=crop",
        time: "2h",
        location: "San Francisco, CA"
      },
      {
        id: 2,
        author: "Maya Rodriguez",
        username: "@mayarod",
        avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b5bc?w=150&h=150&fit=crop&crop=face",
        content: "Behind the scenes at our latest photoshoot. ✨",
        image: "https://images.unsplash.com/photo-1721322800607-8c38375eef04?w=800&h=600&fit=crop",
        time: "4h",
        location: "New York, NY"
      },
      {
        id: 3,
        author: "David Park",
        username: "@davidpark",
        avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face",
        content: "Weekend getaway to the mountains. 🏔️",
        image: "https://images.unsplash.com/photo-1472396961693-142e6e269027?w=800&h=600&fit=crop",
        time: "6h",
        location: "Rocky Mountains, CO"
      }
    ];

    const postContainer = document.getElementById("postContainer");
    posts.forEach(post => {
      const postHTML = `
        <div class="post-card mb-4">
          <div class="d-flex align-items-center mb-2">
            <img src="${post.avatar}" class="avatar mr-2">
            <div>
              <strong>${post.author}</strong> <br>
              <small class="text-muted">${post.username} • ${post.time} • ${post.location}</small>
            </div>
          </div>
          <p>${post.content}</p>
          <img src="${post.image}" class="img-fluid rounded mb-2" style="max-height: 400px; object-fit: cover;">
          <button class="btn btn-outline-primary btn-sm">
            <i class="fas fa-bookmark"></i> Save to Library
          </button>
        </div>
      `;
      postContainer.innerHTML += postHTML;
    });

    // Sidebar Toggle
    document.getElementById("toggleSidebar").addEventListener("click", function () {
      const sidebar = document.getElementById("sidebar");
      const mainContent = document.getElementById("main-content");
      sidebar.classList.toggle("collapsed");
      if (sidebar.classList.contains("collapsed")) {
        mainContent.style.marginLeft = "0";
      } else {
        mainContent.style.marginLeft = "250px";
      }
    });
  </script>
</body>
</html>
