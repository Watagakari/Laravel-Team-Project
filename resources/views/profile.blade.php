<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Profile Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                         alt="User avatar"
                         class="rounded-circle"
                         width="60"
                         height="60">
                    <div>
                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                    <div class="ms-auto">
                        <!-- Delete Account Button with Modal Trigger -->
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Edit Account
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/profile/update" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">New Username</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', Auth::user()->name) }}"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password"
                                   class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/profile/delete" method="POST" class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Delete Account Confirmation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to permanently delete this account? All posts and data will be lost.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS (modal needs JS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
