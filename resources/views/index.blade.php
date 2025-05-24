<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
    }
    .container-fluid {
      height: 100%;
    }
    .left-panel {
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      overflow-y: auto;
    }
    .right-panel {
      background: linear-gradient(to bottom right, #7f712a, #e2b278);
      color: #000;
      font-family: 'Georgia', serif;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 2rem;
    }
    .card {
      border-radius: 15px;
      padding: 30px;
      background-color: #f0f0f0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 1.5rem;
      width: 100%;
      max-width: 500px;
    }
    button[type="submit"] {
      background-color: #b59f40;
      border: none;
    }
    button[type="submit"]:hover {
      background-color: #9e8a30;
    }
    .form-switch-link {
      font-size: 0.9rem;
      cursor: pointer;
      color: #6c757d;
    }
    .form-switch-link:hover {
      text-decoration: underline;
    }
    .post {
      background-color: #e9e9e9;
      padding: 1rem;
      border-radius: 8px;
      margin-top: 1rem;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row h-100">
    <!-- Left Panel -->
    <div class="col-md-6 left-panel">
        <div class="card">
          <h2 class="text-center">Welcome</h2>
          <h5 class="text-center mb-4">Create an account</h5>

          <!-- Register Form -->
          <form id="registerForm" action="/register/create" method="POST">
            @csrf
            <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" class="btn w-100 text-white">Submit</button>
          </form>

          <!-- Login Form (hidden by default) -->
          <form id="loginForm" action="/login" method="POST" class="d-none">
            @csrf
            <input type="text" name="loginname" class="form-control mb-3" placeholder="Name" required>
            <input type="password" name="loginpassword" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" class="btn w-100 text-white">Login</button>
          </form>

          <div class="text-center mt-3">
            <span id="toggleFormText" class="form-switch-link">Already have an account? Log In</span>
          </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="col-md-6 right-panel">
      <p class="fs-5 fw-bold">Lorem Ipsum</p>
      <p class="fs-4">Dolor amet</p>
    </div>
  </div>
</div>

<script>
  const registerForm = document.getElementById('registerForm');
  const loginForm = document.getElementById('loginForm');
  const toggleText = document.getElementById('toggleFormText');

  if (toggleText) {
    toggleText.addEventListener('click', () => {
      registerForm.classList.toggle('d-none');
      loginForm.classList.toggle('d-none');
      toggleText.textContent = registerForm.classList.contains('d-none')
        ? "Don't have an account? Register"
        : "Already have an account? Log In";
    });
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
