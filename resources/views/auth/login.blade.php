<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>pms admin- Login</title>
    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ asset('/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/sb-admin.css') }}">
    <link rel="icon" href="{{ asset('img/logo-icon.webp') }}">
</head>

<body class="intro-bg">
    <div class="auth-container">
        <div class="card">
            <div class="auth-content">
                <div class="auth-header">
                    <img src="{{ asset('img/login_logo.webp') }}" alt="" class="img-fluid">
                </div>
                <h5>Hello! let's get started</h5>
                <p>Login to continue.</p>
                <form method="POST" action="{{ route('login') }}" id="introForm" class="formular">
                    @csrf
                    <div class="mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Email Address" required
                            autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input id="password-1" type="password"
                            class="form-control text-input login-field  login-field-password @error('password') is-invalid @enderror"
                            name="password" placeholder="Password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-block btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="forgot-btn float-end" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/sb-admin-2.js') }}"></script>
    <script src="{{ asset('/js/hideShowPassword.min.js') }}"></script>

    <script>
        $('#password-1').hidePassword(true);
        $('#password-2').showPassword('focus', {
            toggle: {
                className: 'my-toggle'
            }
        });
        $('#show-password').change(function() {
            $('#password-3').hideShowPassword($(this).prop('checked'));
        });
    </script>
</body>

</html>
