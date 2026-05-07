<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>



    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <style>

        .login-card-body {
            padding:37px !important;
        }
    </style>
</head>



<body class="hold-transition login-page" style="background: linear-gradient(135deg, #667eea, #764ba2);">

<div class="login-box">
        @if(request()->is('candidate/login'))
            <h2 style="margin-left:66px;">Candidate Login</h2>
        @else
            <h2 style="margin-left:85px;">Admin Login</h2>
        @endif

    <div class="card">
        <div class="card-body login-card-body">

            <p style="font-size: large;font-weight: 600;" class="login-box-msg">Login</p>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(request()->is('candidate/login'))
                 <form action="{{ url('/candidate/login') }}" method="post">
              @else
                 <form action="{{ url('/admin/login') }}" method="post">
             @endif

            
                @csrf

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            Sign In
                        </button>
                    </div>
                </div>

            </form>

            <div class="row mt-2">
                <div class="col-12 text-right">
                        <a href="{{ url('/forgot-password') }}">
                            Forgot Password?
                        </a>
                  
                </div>
            </div>


            <p class="mb-1 text-left">
                <a href="{{ url('/candidate/register') }}">Create a new account</a>
            </p>

        </div>
    </div>
</div>



</body>
</html>