@extends('layouts.auth')

@section('auth')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h6 class="h5 mb-0 mt-4">Reset Password</h6>
                    <p class="text-muted mt-1 mb-5">
                        Enter your email address and we'll send you an email with instructions to reset your password.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}" class="authentication-form">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Email Address <sup class="text-danger">*</sup></label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-dual" data-feather="mail"></i>
                                    </span>
                                </div>
                                <input
                                    type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="hello@coderthemes.com">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"> Send Password Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('login') }}" class="btn btn-dark">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
