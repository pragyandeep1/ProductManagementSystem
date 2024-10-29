<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PMS Admin - Register</title>
    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="public/css/all.min.css">
    <link rel="stylesheet" href="public/css/bootstrap.css">
    <link rel="stylesheet" href="public/css/sb-admin.css">
    <link rel="icon" href="{{ asset('img/logo-icon.webp') }}">

</head>
<body class="intro-bg">
    <div class="auth-container">
        <div class="card">
            <div class="auth-content">
                <div class="auth-header">
                    <img src="public/img/login_logo.webp" alt="" class="img-fluid">
                </div>
                <h5>Register</h5>
                <form method="POST" action="{{ route('register') }}" id="introForm" class="formular">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-md-3 col-form-label">{{ __('Name') }}</label>
                        <div class="col-md-9">
                            <input id="name" type="text"
                                class="text-input form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email"
                            class="col-md-3 col-form-label">{{ __('Email Address') }}</label>

                        <div class="col-md-9">
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-1" class="col-md-3 col-form-label">{{ __('Password') }}</label>

                        <div class="col-md-9">
                            <input id="password-1" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm"
                            class="col-md-3 col-form-label">{{ __('Confirm Password') }}</label>

                        <div class="col-md-9">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="public/js/jquery.min.js"></script>
    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/sb-admin-2.js"></script>
    <script src="public/js/hideShowPassword.min.js"></script>
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
