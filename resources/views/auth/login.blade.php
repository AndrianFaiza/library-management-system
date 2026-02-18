<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .login-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-submit {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login">
            <h2>Welcome</h2>
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="login-group">
                        <label for="email">Email</label>
                        <input type="text" class="email" id="email" name="email" placeholder="Email">
                </div>
                <div class="login-group">
                    <label for="password">Password</label>
                    <input type="password" class="password" id="password" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn-submit">Log in</button>
            </form>

        </div>
    </div>
</body>
</html>