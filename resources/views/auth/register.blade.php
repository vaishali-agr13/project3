<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <style>
         .register-card-body {
            padding : 37px !important;
         }
        </style>
</head>


@if(session('pending_apply'))
<div id="applyPopup" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999;">
    
    <div style="background:white; width:350px; padding:20px; border-radius:10px; text-align:center; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
        
        <h3 style="margin-bottom:10px;">Complete Your Application</h3>
        <p style="font-size:14px; color:#555;">
            You were applying for a job. Please complete registration to continue.
        </p>

      

        <button onclick="closePopup()" 
            style="margin-top:10px; background:#ccc; padding:8px 12px; border:none; border-radius:5px;">
            Ok
        </button>

    </div>
</div>
@endif

<body class="hold-transition register-page" style="background: linear-gradient(135deg, #667eea, #764ba2);">

<div class="register-box">
    <div class="register-logo">
        
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p style="font-size: large;font-weight: 600;" class="login-box-msg">Create a new account</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                </div>

            

                <button type="submit" class="btn btn-primary btn-block">
                    Register
                </button>
            </form>

            <p class="mt-3 text-center">
                <a href="{{ url('candidate/login') }}">Already have an account? Login</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>

<script>
function closePopup() {
    document.getElementById('applyPopup').style.display = 'none';
}
</script>