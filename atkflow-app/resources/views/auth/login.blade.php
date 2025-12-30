<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ATKflow</title>

    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/css/demo.css') }}">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f4f5ff 0%, #f7fbff 60%, #fef9ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            max-width: 400px;
            width: 100%;
        }

        .app-brand-text.demo {
            text-transform: none;
        }
    </style>
</head>
<body>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y d-flex justify-content-center">
        <div class="authentication-inner auth-card">
            <!-- Login card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-3">
                        <span class="app-brand-logo demo d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width:40px; height:40px;">
                            <span class="fw-bold">A</span>
                        </span>
                        <span class="app-brand-text demo ms-2 text-capitalize">ATKflow</span>
                    </div>
                    <h4 class="mb-1">Selamat datang 👋</h4>
                    <p class="mb-4 text-muted">Silakan login untuk mengelola ATK.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                    </form>

                    <p class="text-center text-muted small mb-0">
                        Demo login: <code>admin@atkflow.test</code> / <code>password123</code>
                    </p>
                </div>
            </div>
            <!-- /Login card -->
        </div>
    </div>
</div>

<script src="{{ asset('sneat-1.0.0/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/js/main.js') }}"></script>
</body>
</html>
