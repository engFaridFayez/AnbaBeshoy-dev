
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>طلبات الطعام | دير أنبا بيشوي</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Tahoma, Arial, sans-serif;
            background: #f4f1f8;
            color: #241b32;
        }

        header {
            background: #39245c;
            color: white;
            padding: 32px 20px;
            text-align: center;
        }

        header h1 {
            margin: 0 0 10px;
        }

        header p {
            margin: 0;
            color: #ded4ee;
        }

        main {
            max-width: 1000px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .meals {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .meal-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #241b3210;
        }

        .meal-icon {
            font-size: 38px;
        }

        .meal-card h2 {
            margin: 15px 0;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .open {
            color: #176b40;
            background: #dff6e8;
        }

        .closed {
            color: #8b3030;
            background: #fde8e8;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: 0;
            border-radius: 9px;
            background: #6842a0;
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        button:disabled {
            background: #c8c2d1;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <header>
        <h1>دير القديس الأنبا بيشوي</h1>
        <p>نظام طلبات الطعام</p>
    </header>

    <main>
        <h2>وجبات اليوم</h2>

        <div class="meals">
            @foreach ($meals as $meal)
                <article class="meal-card">
                    <div class="meal-icon">
                        {{ $meal['icon'] }}
                    </div>

                    <h2>{{ $meal['name'] }}</h2>

                    @if ($meal['status'] === 'open')
                        <span class="status open">الطلبات مفتوحة</span>
                    @else
                        <span class="status closed">الطلبات مغلقة</span>
                    @endif

                    <button
                        type="button"
                        @disabled($meal['status'] !== 'open')
                    >
                        {{ $meal['status'] === 'open'
                            ? 'اطلب وجبتك'
                            : 'الطلب غير متاح' }}
                    </button>
                </article>
            @endforeach
        </div>
    </main>
</body>
</html>
