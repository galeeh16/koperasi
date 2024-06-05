<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('assets/external/login.css') }}?v=1.1.1" />
    <link rel="stylesheet" href="{{ URL::asset('assets/external/sweetalert/sweetalert2.min.css') }}" />
    <style>
        :root {
            --bs-body-bg-rgb: 255, 233, 253;
            --bs-primary-rgb: 13, 110, 253;
            --bd-accent-rgb: 255, 228, 132;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bd-pink-rgb: 214, 51, 132;
        }

        .filter-black {
            filter: invert(60%) sepia(95%) saturate(1013%) hue-rotate(216deg) brightness(100%) contrast(94%);
        }

        .text-gradient {
            background-image: linear-gradient(to right, #3838ff, #920dff, #f70fff, #ff0f77);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        .animate-banner {
            transform: rotateX(15deg) rotateY(-5deg) rotate(10deg);
            perspective: 900px;
            animation: animateBanner;
            animation-duration: 10s;
            animation-iteration-count: infinite;
            transition: all .4s ease-in-out
        }

        .img-banner {
            filter: drop-shadow(10px 10px 4px #8c959f71);
            -webkit-filter: drop-shadow(14px 10px 4px #8c959f71);
            -ms-filter: drop-shadow(14px 10px 4px #8c959f71);
            transition: all .12s ease-in-out;
            animation-name: animateImage;
            animation-duration: 10s;
            animation-iteration-count: infinite
        }

        .bg-blue {
            background-image: linear-gradient(180deg, rgba(var(--bs-body-bg-rgb), .01), rgba(var(--bs-body-bg-rgb), 1) 185%),
                radial-gradient(ellipse at top left, rgba(var(--bs-primary-rgb), .5), transparent 50%),
                radial-gradient(ellipse at top right, rgba(var(--bd-accent-rgb), .5), transparent 50%),
                radial-gradient(ellipse at center right, rgba(var(--bd-violet-rgb), .4), transparent 50%),
                radial-gradient(ellipse at center left, rgba(var(--bd-pink-rgb), .4), transparent 50%);
            background-size: 150% 150%;
            background-repeat: no-repeat;
        }

        p span.typed-text {
            font-weight: 500;
            /* letter-spacing: 1px; */
            color: #6b32dd;
        }

        p span.cursor {
            display: inline-block;
            background-color: #ec419a;
            margin-left: 0.1rem;
            width: 2px;
            animation: blink 1s infinite;
        }

        p span.cursor.typing {
            animation: none;
        }

        @keyframes blink {
            0% {
                background-color: #ec419a;
            }

            49% {
                background-color: #ec419a;
            }

            50% {
                background-color: transparent;
            }

            99% {
                background-color: transparent;
            }

            100% {
                background-color: #ec419a;
            }
        }

        @media screen and (max-width: 1366px) {
            .animate-banner {
                max-width: 580px;
            }
        }

        @media screen and (min-width: 1420px) {
            .text-typing {
                font-size: 28px;
            }
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 700px;
            border-radius: 15px;
        }

        @media screen and (max-width: 480px) {

            .modal-content {
                display: flex;
                width: 100%;
            }
        }

        .modal-header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1rem;
            padding-top: 0;
            border-top-left-radius: 0.3rem;
            border-top-right-radius: 0.3rem;
        }

        .modal-header .close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
        }

        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
        }

        .modal-body {
            position: relative;
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1rem;
        }


        .modal-footer {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            padding: 1rem;
        }

        .modal-footer> :not(:first-child) {
            margin-left: 0.25rem;
        }

        .modal-footer> :not(:last-child) {
            margin-right: 0.25rem;
        }

        .modal-scrollbar-measure {
            position: absolute;
            top: -9999px;
            width: 50px;
            height: 50px;
            overflow: scroll;
        }

        .text-danger {
            color: red;
            margin-top: 5px;
        }

        .content p {
            padding-left: 0;
            padding-top: 1rem;
            font-size: 1rem;
        }

        .content .requirement-list {
            margin-top: 10px;
        }

        .requirement-list li {
            list-style: none;
            font-size: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .requirement-list li>svg {
            font-size: 0.6rem;
            fill: #ef4444;
            width: 20px;
        }

        .requirement-list li>svg.active {
            fill: #34a053;
        }

        .requirement-list li>span {
            position: relative;
            color: #424348;
        }

        .requirement-list li>span.active {
            color: #34a053;
        }

        .requirement-list li>span.active::after {
            position: absolute;
            content: url("data:image/svg+xml, %3Csvg id='uppercase' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2334a053' viewBox='0 0 448 512'%3E%3Cpath d='M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z' /%3E%3C/svg%3E");
            top: 0;
            right: -25px;
        }
		dialog#signonviewer button#togglePasswords { display:none !important; }
		@-moz-document url-prefix(about:preferences){
			#showPasswords {display:none!important}
		}
    </style>
</head>

<body>
    <div>
        <div class="flex">
            <div class="left-container h-100">
                <div style="width: 400px; max-width: 400px;">
                    {{-- <a href="{{ url('/') }}" style="text-align: center; display: block;">
                    <img src="{{ asset('image/ic_kopnuspos_putih.svg') }}" alt="Logo" class="filter-black" style="width: 250px;" />
                    </a> --}}
                    <h2 class="text-gradient" style="margin-bottom: 10px; margin-top: 20px; font-size: 32px; font-weight: bold; text-align: center;">
                        KOSIPA
                    </h2>

                    <h3 style="margin-top: 20px; font-size: 26px; text-align: center; color: #2c2c34; margin-bottom: 30px;">
                        Sign in to your Account</h3>

                    <div style="position: relative; margin-bottom: 26px; margin-top: 0px; height: 50px;" id="error">
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="input" placeholder="Masukkan Username" name="username" id="username" value="{{ old('username') }}" maxlength="30" required autocomplete="off" aria-autocomplete="none" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <div class="form-group" style="position: relative;">
                            <label for="password">Password</label>
                            <input type="password" class="input" placeholder="Masukkan Password" name="password" id="password" maxlength="30" required autocomplete="off" aria-autocomplete="none" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="form-group" style="display: flex; justify-content: flex-end;">
                            {{-- <label class="container-checkbox" style="font-weight: 400">Ingat Saya
                                <input type="checkbox" name="remember_me" id="remember_me" name="remember_me" @if (isset($_COOKIE['remember_me'])) {{ $_COOKIE['remember_me'] }} @endif autocomplete="off" aria-autocomplete="none" role="presentation" />
                                <span class="checkmark"></span>
                            </label> --}}

                            {{-- <a href="{{ url('/lupa-password') }}" class="text-orange">Lupa Password?</a> --}}
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn" id="btn-submit">SIGN IN</button>
                        </div>
                    </form>

                    <div style="margin-top: 40px; text-align: center;">
                        Belum mempunyai akun? <a href="{{ url('/register') }}" style="color: var(--primary)">Register</a>
                    </div>
                </div>
            </div>
            <div class="bg-blue right-container" style="overflow: hidden;">


                <p class="copyright" style="display: inline-flex; align-items: center; justify-content: center; gap: 7px; color: #847b98;">
                    &copy; <span id="year-copy"></span> Created
                    with
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#ff4596" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                    </svg>
                    by E-Koperasi
                </p>
            </div>
        </div>
    </div>

</body>


</html>
