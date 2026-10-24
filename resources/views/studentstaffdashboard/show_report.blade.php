<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Details</title>
    <style>
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f8fafc; color: #0f172a; }
        .container { max-width: 920px; margin: 40px auto; padding: 20px; }
        .card { background: white; border-radius: 20px; padding: 32px; box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08); }
        h1 { margin-bottom: 18px; }
        .field { margin-bottom: 20px; }
        .field strong { display: block; margin-bottom: 8px; color: #334155; }
        .field p { margin: 0; line-height: 1.7; color: #475569; }
        .back-link { display: inline-block; margin-top: 24px; padding: 12px 20px; border-radius: 12px; background: #2563eb; color: white; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Report Details</h1>
            <div class="field">
                <strong>Device</strong>
                <p>{{ $report->device->device_name ?? $report->device_reg_no }}</p>
            </div>
            <div class="field">
                <strong>Device Registration</strong>
                <p>{{ $report->device_reg_no }}</p>
            </div>
            <div class="field">
                <strong>Description</strong>
                <p>{{ $report->description }}</p>
            </div>
            <div class="field">
                <strong>Date</strong>
                <p>{{ $report->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <a href="{{ route('studentdashboard') }}" class="back-link">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
