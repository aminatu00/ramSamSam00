<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #081b29;
        }

        .wrapper {
            position: relative;
            width: 750px;
            height: 450px;
            background: transparent;
            border: 2px solid #0ef;
            box-shadow: 0 0 25px #0ef;
            overflow: hidden;
        }

        .wrapper .form-box {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .wrapper .form-box.login {
            left: 0;
            padding: 0 60px 0 40px;
        }

        .wrapper .form-box.register {
            left: 0;
            right: 0;
            padding: 0 40px 0 60px;
            display: none;
        }

        .form-box h2 {
            font-size: 32px;
            color: #fff;
            text-align: center;
        }

        .form-box .input-box {
            position: relative;
            width: 100%;
            height: 40px;
            margin: 35px 0;
            color:#fff;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border-bottom: 2px solid #fff;
            padding-right: 23px;
            font-size: 16px;
            color: #fff;
            font-weight: 500;
            transition: .5s;
        }

        .input-box input:focus,
        .input-box input:valid {
            border-bottom-color: #0ef;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
            color: #0ef;
        }

        .input-box i {
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            font-size: 18px;
            color: #fff;
            transition: .5s;
        }

        .input-box input:focus~i,
        .input-box input:valid~i {
            color: #0ef;
        }

        .btn {
            position: relative;
            width: 100%;
            height: 45px;
            background: transparent;
            border: 2px solid #0ef;
            outline: none;
            border-radius: 40px;
            cursor: pointer;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            z-index: 1;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 300%;
            background: linear-gradient(#081b29, #0ef, #081b29, #0ef);
            z-index: -1;
            transition: .5s;
        }

        .btn:hover::before {
            top: 0;
        }

        .form-box .logreg-link {
            font-size: 14.5px;
            color: #fff;
            text-align: center;
            margin: 20px 0 10px;
        }

        .logreg-link p a {
            color: #0ef;
            text-decoration: none;
            font-weight: 600;
        }

        .logreg-link p a:hover {
            text-decoration: underline;
        }

        .wrapper .info-text {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .wrapper .info-text.login {
            right: 0;
            text-align: right;
            padding: 0 40px 60px 150px;
        }

        .info-text h2 {
            font-size: 36px;
            color: #fff;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .info-text p {
            font-size: 16px;
            color: #fff;
        }

        .wrapper .bg-animate {
            position: absolute;
            top: 0;
            right: 0;
            width: 850px;
            height: 600px;
            background: linear-gradient(45deg, #081b29, #0ef);
            border-bottom: 3px solid #0ef;
            transform: rotate(10deg) skewY(40deg);
            transform-origin: bottom right;
        }

        .forgot-password-link {
            font-size: 10px;
        }

        .text-white {
            color: #fff;
            display: inline-block;
            margin-bottom: 40px;
            transition: .5s;
            margin-left: 90px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <span class="bg-animate"></span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="input-box">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <label>Email</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <label>Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-white">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
                <div>
                    <button type="submit" class="btn">Login</button>
                </div>
                <div class="logreg-link">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="register-link">Sign-up</a></p>
                </div>
            </form>
        </div>
        <div class="info-text login">
            <h2 style="margin-bottom: 60px; font-size: 36px;">Bienvenue</h2>
            <p>"Rejoignez notre forum pédagogique pour une expérience d'apprentissage collaborative et enrichissante !"</p>
        </div>
    </div>
</body>
