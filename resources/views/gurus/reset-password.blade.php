@extends('adminlte::page')

@section('title', 'Reset Password Guru')

@section('content')
<style>
    /* Styling Tema Biscuit & Warm Gray */
    .custom-card {
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(141, 110, 99, 0.08) !important;
        border: 1px solid #EFEBE9 !important;
        overflow: hidden;
        margin-top: 20px;
    }

    .custom-card-header {
        /* Warna Header: Biscuit Warm Brown Gradient */
        background: linear-gradient(135deg, #D7CCC8 0%, #A1887F 100%);
        color: #3E2723;
        padding: 22px 20px;
        text-align: center;
        border: none;
    }

    .custom-card-header h3 {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
        color: #3E2723;
    }

    .custom-card-header p {
        font-size: 0.85rem;
        margin: 4px 0 0 0;
        color: #4E342E;
        opacity: 0.9;
    }

    .custom-card-body {
        padding: 28px 24px;
        background-color: #FAFAFA;
    }

    .form-group-modern {
        margin-bottom: 20px;
    }

    .form-group-modern label {
        font-size: 0.88rem;
        font-weight: 600;
        color: #5D4037;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-modern {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #D7CCC8;
        border-radius: 10px;
        font-size: 0.93rem;
        transition: all 0.2s ease-in-out;
        outline: none;
        background-color: #FFFFFF;
        color: #3E2723;
    }

    .form-control-modern:focus {
        background-color: #FFFFFF;
        border-color: #8D6E63;
        box-shadow: 0 0 0 3px rgba(141, 110, 99, 0.15);
    }

    .custom-card-footer {
        background: #F5F5F5;
        padding: 16px 24px;
        border-top: 1px solid #EFEBE9;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
    }

    .btn-custom-cancel {
        color: #757575;
        font-weight: 600;
        text-decoration: none;
        padding: 9px 18px;
        border-radius: 10px;
        transition: background 0.2s;
    }

    .btn-custom-cancel:hover {
        background: #E0E0E0;
        color: #424242;
        text-decoration: none;
    }

    .btn-custom-submit {
        /* Warna Tombol: Soft Biscuit Brown */
        background: #8D6E63;
        color: #FFFFFF;
        border: none;
        padding: 9px 22px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-custom-submit:hover {
        background: #6D4C41;
    }

    .alert-custom {
        background-color: #FFEBEE;
        border-left: 4px solid #E57373;
        color: #C62828;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        margin-bottom: 20px;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card custom-card">
            
            <div class="custom-card-header">
                <h3>Reset Password Guru 🔒</h3>
                <p>Silakan buat kata sandi baru untuk akun ini</p>
            </div>
            
            <form action="{{ route('guru.update-password', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="custom-card-body">
                    
                    @if ($errors->any())
                        <div class="alert-custom">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group-modern">
                        <label for="password">Password Baru <span class="text-danger">*</span></label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="form-control-modern" 
                            placeholder="6-8 karakter" 
                            maxlength="8" 
                            required>
                    </div>

                    <div class="form-group-modern">
                        <label for="password_confirmation">Ulangi Password Baru <span class="text-danger">*</span></label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            class="form-control-modern" 
                            placeholder="6-8 karakter" 
                            maxlength="8" 
                            required>
                    </div>

                </div>

                <div class="custom-card-footer">
                    <a href="{{ route('guru.index') }}" class="btn-custom-cancel">Batal</a>
                    <button type="submit" class="btn-custom-submit">Kirim Password</button>
                </div>
            </form>

        </div>
    </div>
</div>
@stop