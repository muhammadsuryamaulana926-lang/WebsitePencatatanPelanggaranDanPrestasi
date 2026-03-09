<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Kesiswaan</title>
     <link rel="icon" href="{{ asset('img/logo smk.jpeg') }}" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .login-wrapper {
            display: flex;
            height: 100vh;
        }
        
        .left-section {
            flex: 1;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .logo-illustration {
            width: 250px;
            height: 250px;
            border-radius: 20px;
            object-fit: contain;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            background: white;
            padding: 20px;
        }
        
        .right-section {
            flex: 1;
            background: linear-gradient(135deg, #59a9ebff 0%, #799ec3ff 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .welcome-text {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header img {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
            border-radius: 50%;
        }
        
        .login-header h3 {
            color: #2d3436;
            margin-bottom: 5px;
            font-size: 20px;
        }
        
        .login-header p {
            color: #636e72;
            font-size: 14px;
        }
        
        .form-control {
            border-radius: 25px;
            padding: 15px 20px;
            border: 1px solid #e0e0e0;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }
        
        .form-select {
            border-radius: 25px;
            padding: 15px 20px;
            border: 1px solid #e0e0e0;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .form-select:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            border: none;
            border-radius: 25px;
            padding: 15px;
            width: 100%;
            color: white;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }
        
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }
        
        .role-info {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #636e72;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            
            .left-section {
                flex: 0.3;
            }
            
            .logo-illustration {
                width: 150px;
                height: 150px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Section - Logo Illustration -->
        <div class="left-section">
            <img src="{{ asset('img/logo smk.jpeg') }}" alt="Logo SMK" class="logo-illustration">
        </div>
        
        <!-- Right Section - Login Form -->
        <div class="right-section">
            <a href="/dashboard" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            
            <div class="welcome-text">SELAMAT DATANG</div>
            
            <div class="login-container">
                    <div class="login-header">
                        <img src="{{ asset('img/logo smk.jpeg') }}" alt="Logo SMK">
                        <h3>Login Sistem</h3>
                        <p>Sistem Informasi Kesiswaan</p>
                    </div>
                    
                    <div class="role-info">
                        <strong>Level:</strong> Admin, Guru, BK, Wali Kelas, Kepala Sekolah, Kesiswaan, Siswa, Orang Tua
                    </div>
                    
                    <form method="POST" action="/login">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="level" required>
                                <option value="">Pilih Level</option>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                                <option value="bk">BK (Bimbingan Konseling)</option>
                                <option value="walikelas">Wali Kelas</option>
                                <option value="kepalasekolah">Kepala Sekolah</option>
                                <option value="siswa">Siswa</option>
                                <option value="ortu">Orang Tua</option>
                                <option value="kesiswaan">Kesiswaan</option>
                            </select>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <button type="submit" class="btn-submit">
                            SUBMIT
                        </button>
                    </form>
                </div>
        </div>
    </div>
</body>
</html>