<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css') }}?v=1.1.1" />
    <link rel="stylesheet" href="{{ asset('assets/external/select2/select2.min.css') }}">
    <!-- Custom css ku -->
    <link rel="stylesheet" href="{{ asset('assets/external/mycss.css') }}" />
</head>

<body>
    <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="card shadow" style="width: 600px;">
            <div class="card-body">
                <h3 class="text-center mb-5">
                    <a href="{{ url('login') }}">KOSIPA</a>
                </h3>

                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <div>
                        <x-label for="username">Username</x-label>
                        <x-input-text name="username" id="username" :value="old('username')" required autofocus autocomplete="username"></x-input-text>
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div class="mt-3">
                        <x-label for="name">Name</x-label>
                        <x-input-text name="name" id="name" :value="old('name')" required autofocus autocomplete="name"></x-input-text>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-3">
                        <x-label for="password">Password</x-label>
                        <x-input-text type="password" name="password" id="password" :value="old('password')" required autofocus autocomplete="new-password"></x-input-text>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-3">
                        <x-label for="password_confirmation">Confirm Password</x-label>
                        <x-input-text type="password" name="password_confirmation" id="password_confirmation" :value="old('password_confirmation')" required autofocus autocomplete="new-password"></x-input-text>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-3">
                        <x-label for="register_as">Daftar Sebagai</x-label>
                        <x-input-select id="register_as" name="register_as" data-placeholder="Pilih Sebagai">
                            <option></option>
                            <option value="non_anggota">Non Anggota</option>
                            <option value="anggota">Anggota</option>
                        </x-input-select>
                        <x-input-error :messages="$errors->get('register_as')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-button type="submit" class="btn-primary w-100">Register</x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    <script src="{{ asset('assets/external/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#register_as').select2({
                minimumResultsForSearch: -1,
            });
        });
    </script>
</body>
</html>
