<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 420px;
            padding: 42px;
            border-radius: 22px;
            background: #ffffff;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.08);
            animation: fadeUp 0.6s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card h2 {
            text-align: center;
            margin-bottom: 32px;
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .field {
            position: relative;
            margin-bottom: 22px;
        }

        .field input {
            width: 100%;
            padding: 16px 14px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            transition: 0.3s;
        }

        .field input::placeholder {
            color: transparent;
        }

        .field label {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 14px;
            pointer-events: none;
            transition: 0.3s;
            background: #ffffff;
            padding: 0 6px;
        }

        .field input:focus + label,
        .field input:not(:placeholder-shown) + label {
            top: -8px;
            font-size: 12px;
            color: #374151;
        }

        .field input:focus {
            outline: none;
            border-color: #d1d5db;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.04);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            border-radius: 18px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            color: #111827;
        }

        .btn-login:hover {
            background: #f9fafb;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
        }

        .footer {
            margin-top: 26px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }

        .footer a {
            color: #111827;
            text-decoration: none;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* ===== Notification Alerts ===== */
        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .alert-icon {
            font-size: 18px;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <h2>Task Reminder</h2>

        {{-- Notifikasi sukses registrasi --}}
        @if (session('success'))
            <div class="alert alert-success">
                <span class="alert-icon">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Notifikasi error login --}}
        @if ($errors->any())
            <div class="alert alert-error">
                <span class="alert-icon">⚠️</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <input type="email" name="email" placeholder="Email" required>
                <label>Email</label>
            </div>

            <div class="field">
                <input type="password" name="password" placeholder="Password" required>
                <label>Password</label>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="footer">
            Belum punya akun?
            <a href="{{ route('register') }}">Register</a>
        </div>
    </div>

</body>
</html>
