<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Details</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }
        h1 {
            margin-bottom: 18px;
        }
        .field {
            margin-bottom: 18px;
        }
        .field strong {
            display: block;
            margin-bottom: 6px;
            color: #334155;
        }
        .field p {
            margin: 0;
            color: #475569;
            white-space: pre-wrap;
            line-height: 1.65;
        }
        .back-link {
            display: inline-block;
            margin-top: 24px;
            padding: 12px 20px;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            text-decoration: none;
        }
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
                <strong>Reported by</strong>
                <p>{{ $report->user->first_name ?? $report->user_id }}</p>
            </div>
            <div class="field">
                <strong>Date</strong>
                <p>{{ $report->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="field">
                <strong>Description</strong>
                <p>{{ $report->description }}</p>
            </div>
            <a href="{{ route('labtechniciandashboard') }}" class="back-link">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
