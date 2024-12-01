<!-- resources/views/auth/login.blade.php -->

<form action="{{ route('login') }}" method="POST" class="login-form">
    @csrf

    <!-- Email input -->
    <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" value="{{ old('email') }}" required>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password input -->
    <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <!-- Remember Me checkbox (optional) -->
    <div class="checkbox-group">
        <label>
            <input type="checkbox" name="remember"> Remember Me
        </label>
    </div>

    <button type="submit" class="btn-submit">Login</button>

    <!-- Link to registration page -->
    <p class="register-link">Don't have an account? <a href="{{ route('registerForm') }}">Register here</a></p>
</form>

<!-- Inline CSS for styling -->
<style>
    /* Basic styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-form {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .input-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        background-color: #fafafa;
    }

    .input-group input:focus {
        border-color: #007BFF;
        outline: none;
    }

    .error {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

    .checkbox-group {
        margin-bottom: 15px;
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }

    .register-link {
        text-align: center;
        font-size: 14px;
        margin-top: 15px;
    }

    .register-link a {
        color: #007BFF;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>
