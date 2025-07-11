@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <style>
        :root {
            --primary-green: #198754;
        }
        .register-header {
            background: var(--primary-green) !important;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .register-header h1, .register-header p {
            color: #fff !important;
        }
        .input-group-text, .form-check-input:checked {
            background-color: #e6f4ec !important;
            color: var(--primary-green) !important;
            border-color: #b6e2ce !important;
        }
        .form-label, .form-check-label {
            color: var(--primary-green) !important;
        }
        .btn-green, .btn-green:active, .btn-green:focus {
            background: var(--primary-green) !important;
            color: #fff !important;
            border: none !important;
        }
        .btn-green:hover {
            background: #146c43 !important;
            color: #fff !important;
        }
        .form-control:focus {
            border-color: var(--primary-green) !important;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15) !important;
        }
        .alert {
            border-left: 4px solid var(--primary-green) !important;
        }
        a {
            color: var(--primary-green);
        }
        a:hover {
            color: #146c43;
        }
    </style>
@endsection
@section('content')
    <x-app.header />
    <section class="ec-page-content section-space-p" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-12  text-center mb-4">
                    <div class="register-header py-4 mb-0">
                        <h1 class="mb-1">Get Started with <span style="font-weight:700;">Sohoj Ecommerce</span></h1>
                        <p class="mb-0">Create your free account</p>
                    </div>
                    <div class="alert alert-primary mx-auto mt-4" role="alert" style="max-width: 622px;">
                        Join SohjojEcommerce and start shopping or selling easily.
                    </div>
                </div>
                <div class="col-md-7 col-12">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="{{ route('register') }}" novalidate>
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input id="name" type="text" placeholder="First name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="given-name" autofocus>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="l_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input id="l_name" type="text" placeholder="Last name" class="form-control @error('l_name') is-invalid @enderror" name="l_name" value="{{ old('l_name') }}" required autocomplete="family-name">
                                        </div>
                                        @error('l_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" minlength="8">
                                            <button class="btn btn-green toggle-password" type="button"><i class="fas fa-eye"></i></button>
                                        </div>
                                        <div class="form-text">Minimum 8 characters</div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            <button class="btn btn-green toggle-password" type="button"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label ms-2" for="terms">
                                        I agree to the <a href="{{ url('page/policies') }}" target="_blank">Terms & Conditions</a> and
                                        <a href="#">Privacy Policy</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-grid gap-3">
                                    <button type="submit" class="btn btn-green btn-lg rounded-4">
                                        {{ __('Register') }}
                                    </button>
                                    <div class="text-center mt-2">
                                        <p class="mb-0">Already have an account?
                                            <a class="fw-semibold" href="{{ route('login') }}">Login here</a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
@endsection
