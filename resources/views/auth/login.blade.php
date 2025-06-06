@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h4 class="mb-4 text-center">Login</h4>
            <div id="loginErrors" class="alert alert-danger d-none"></div>
            <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" required>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" required>
                    <div class="invalid-feedback">Password is required.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('loginForm');
    const errorBox = document.getElementById('loginErrors');

    form.addEventListener('submit', (e) => {
        errorBox.classList.add('d-none');
        errorBox.innerHTML = '';

        const email = form.email.value.trim();
        const password = form.password.value;

        if (!email || !password) {
            e.preventDefault();
            errorBox.classList.remove('d-none');
            errorBox.textContent = 'Email and password are required.';
            return;
        }
    });
});
</script>
@endpush