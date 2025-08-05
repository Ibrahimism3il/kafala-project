<!-- resources/views/payment/success.blade.php -->

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نجاح الدفع</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
</head>
<body class="text-center mt-5">

    <div class="container">
        <h1 class="text-success">✅ تم الدفع بنجاح</h1>
        <p>شكرًا لك على كفالتك.</p>
        <a href="{{ route('kafel.dashboard') }}" class="btn btn-primary mt-3">العودة إلى لوحة التحكم</a>
    </div>

</body>
</html>
