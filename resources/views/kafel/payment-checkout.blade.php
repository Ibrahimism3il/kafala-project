<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الدفع عبر Stripe</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h2>الرجاء الانتظار... يتم تجهيز بوابة الدفع</h2>

    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");

        fetch("{{ route('payment.createStripeSession') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                payment_id: {{ $payment->id }}
            })
        })
        .then(res => res.json())
        .then(data => {
            stripe.redirectToCheckout({
                sessionId: data.id
            });
        })
        .catch(error => {
            alert("حدث خطأ أثناء الاتصال بـ Stripe");
            console.error(error);
        });
    </script>
</body>
</html>
