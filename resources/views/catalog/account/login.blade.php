@extends('catalog.common.base')

@push('setTitle')
    User Login
@endpush

@section('content')

<style>
     .login-form-wrapper {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login_heading {
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
        }
        .login-input,
        .login_btn {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .login_btn {
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login_btn:hover {
            background-color: #000;
        }

        .login-form-toggle {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-form-toggle a {
            text-decoration: none;
            color: #4e73df;
        }

        .login-form-toggle a:hover {
            text-decoration: underline;
        }

        .login-form-container {
            display: none;
        }

        .login-form-container.active {
            display: block;
        }

        .login-form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-form-header a {
            color: #4e73df;
            text-decoration: none;
        }

</style>

<section class="container py-5 d-flex justify-content-center">
    <div class="login-form-wrapper">
        <!-- Login Form -->
        <div class="login-form-container active" id="loginForm">
            <h2 class="login_heading">Login</h2>
            <!-- alert message -->
            @include('catalog.common.alert')
            <form action="" method="post">
                @csrf
                <input type="email" class="login-input" name="email" id="email" placeholder="Email" required>
                <input type="password" class="login-input" name="password" id="password" placeholder="Password" required>
                <div class="form-check py-2">
                    <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" onclick="setCookies()">
                    <label class="form-check-label" for="remember_me">
                      Remember Me
                    </label>
                  </div>
                <button type="submit" class="login_btn">Login</button>
                <a href="{{ $forgot_password }}">Forgot Password?</a>
            </form>
            <div class="login-form-toggle">
                <p>Don't have an account? <a href="#register" onclick="toggleForm()">Sign up</a></p>
            </div>
        </div>

        <!-- Register Form -->
        <div class="login-form-container" id="registerForm">
            <h2 class="login_heading">Register</h2>
            <form action="{{ $register }}" method="post">
                @csrf
                <input class="login-input" type="text" name="name" placeholder="Full Name" value="{{ old('name') }}">
                @error('name')
                    <div>
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    </div>
                @enderror

                <input class="login-input" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                @error('email')
                    <div>
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    </div>
                @enderror
                @if(session('email_error'))
                    <div>
                        <span class="text-danger">
                        {{ session('email_error') }}
                        </span>
                    </div>
                @endif

                <input class="login-input" type="password" name="password" placeholder="Password">
                @error('password')
                <div>
                    <span class="text-danger">
                            {{$message}}
                        </span>
                    </div>
                @enderror

                <input class="login-input" type="password" name="confirm_password" placeholder="Confirm Password" value="">
                @error('confirm_password')
                    <div>
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    </div>
                @enderror
                @if(session('password_not_match'))
                    <div>
                        <span class="text-danger">
                        {{ session('password_not_match') }}
                        </span>
                    </div>
                @endif

                @if(session('registerError'))
                    <div class="d-none" id="registerError">{{ session('registerError') }}</div>
                @endif
                <button type="submit" class="login_btn">Register</button>
            </form>
            <div class="login-form-toggle">
                <p>Already have an account? <a href="#" onclick="toggleForm()">Login</a></p>
            </div>

        </div>
        
        <!-- Social Media login -->
        <p class="text-center m-0">Or</p>
        <div class="text-center">
            <a href="{{ route('catalog.googlelogin') }}"><img src="{{ asset('icon/signin-with-google.png') }}" alt="" style="width: 60%;"></a>
        </div>

    </div>
</section>

<script>
    function toggleForm() {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        loginForm.classList.toggle('active');
        registerForm.classList.toggle('active');
    }

    // getting error after register if exist
    let registerError = document.getElementById('registerError');
    if(registerError){
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        loginForm.classList.toggle('active');
        registerForm.classList.toggle('active');
    }

    // setup remember me
    function setCookies(){
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        const baseURL = `${window.location.origin}`; // Get base URL dynamically
        const path = `${baseURL}/admin/login`;

        document.cookie="myEmail="+email+";path="+path;
        document.cookie="myPassword="+password+";path="+path;
    }

    window.addEventListener('load', function() {
        getCookiesData();
    });

    function getCookiesData(){
        let getEmail = getCookie('myEmail');
        let getPassword = getCookie('myPassword');

        document.getElementById('email').value = getEmail;
        document.getElementById('password').value = getPassword;
    }

    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
        return "";
    }


</script>

@endsection