@extends('adminlte::auth.login')

@push('css')
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body, .login-page, .login-box, .login-logo, input, button, label {
        font-family: 'Nunito', sans-serif !important;
    }

    .login-logo, 
    .login-logo a, 
    .login-logo b {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #2c3e50 !important;
        white-space: nowrap !important; 
    }

    .login-logo img {
        max-height: 40px !important;
        width: auto !important;
    }

    .card-primary.card-outline, 
    .card-outline {
        border-top: 3px solid #F37F30 !important;
    }

    .btn-primary, 
    .btn-primary:active, 
    .btn-primary:focus {
        background-color: #F37F30 !important;
        border-color: #F37F30 !important;
        color: #ffffff !important;
        box-shadow: none !important;
        font-weight: 700 !important;
    }

    .btn-primary:hover {
        background-color: #d96d24 !important;
        border-color: #d96d24 !important;
    }

    .form-control:focus {
        border-color: #F37F30 !important;
        box-shadow: 0 0 0 0.2rem rgba(243, 127, 48, 0.25) !important;
    }
</style>
@endpush

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let emailInput = document.querySelector('input[name="email"]');
        if (emailInput) {
            emailInput.setAttribute('type', 'text');
            emailInput.setAttribute('placeholder', 'NIPY / Username');
        }

        let icon = document.querySelector('.fa-envelope');
        if (icon) {
            icon.classList.remove('fa-envelope');
            icon.classList.add('fa-user');
        }
    });
</script>
@endpush