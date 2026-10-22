<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Dishub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #004085;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: black;
        }
        .login-container img {
            width: 100px;
            margin-bottom: 1rem;
        }
        .login-container h2 {
            margin-bottom: 1.5rem;
            color: #004085;
            font-weight: bold;
        }
        .form-control {
            border: 1px solid #004085;
            color: black;
        }
        .form-control::placeholder {
            color: #6c757d;
        }
        .btn-login {
            background: #FFC107;
            color: black;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
        }
        .btn-login:hover {
            background: #FFA000;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="gambar/logo-dishub.png" alt="Logo Dishub">
        <h2>Login Admin</h2>

        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'username') {
                echo '<div class="alert alert-danger text-center" role="alert">
                        Username anda salah!
                    </div>';
            } elseif ($_GET['error'] == 'password') {
                echo '<div class="alert alert-danger text-center" role="alert">
                        Password anda salah!
                    </div>';
            } elseif ($_GET['error'] == 'both') {
                echo '<div class="alert alert-danger text-center" role="alert">
                        Username dan password anda salah!
                    </div>';
            }
        }
        ?>

        <form action="process_admin_login.php" method="post">
            <div class="mb-3">
                <input type="text" name="username" id="username" 
                class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" 
                class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
    </div>

</body>
</html>
