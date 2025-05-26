<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Elegant Registration Form</title>
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-container {
      max-width: 500px;
      margin: 60px auto;
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      margin-bottom: 30px;
      font-weight: 600;
      text-align: center;
    }

    .btn-primary {
      width: 100%;
      padding: 10px;
      font-weight: 500;
    }

    .form-text a {
      text-decoration: none;
      color: #0d6efd;
    }

    .form-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2 class="form-title">Create Account</h2>
    <form>
      <div class="mb-3">
        <label for="fullName" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullName" placeholder="John Doe" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="••••••••" required>
      </div>

      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirmPassword" placeholder="••••••••" required>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="termsCheck" required>
        <label class="form-check-label" for="termsCheck">
          I agree to the <a href="#">terms and conditions</a>
        </label>
      </div>

      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p class="form-text mt-3 text-center">
      Already have an account? <a href="#">Login here</a>
    </p>
  </div>

  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
