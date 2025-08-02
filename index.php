<!--index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">
      <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h3 class="text-center mb-3">Login</h3>

                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger">'.htmlspecialchars($GET['error']).'</div>';
                    }
                    ?>

                    <form method="POST" action="process_login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">username</label>
                            <input type="text" name="username" class="form-control" required>
                            <label for="password" class="form-label">password</label>
                            <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>
                </form>
            </div>
          </div>
        </div>
      </div>

</body>
</html>