<!-- resources/views/admin/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Admin Login</h2>

        <!-- Display error messages if any -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <!-- Set default username as 'admin' -->
                <input type="text" name="username" id="username" class="form-control" value="admin" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <!-- Set default password as '123123123' -->
                <input type="password" name="password" id="password" class="form-control" value="123123123" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
