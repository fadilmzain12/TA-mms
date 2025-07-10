<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .card-container {
            width: 8.5cm;
            height: 5.4cm;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 0.1cm;
            position: relative;
            background-color: #fff;
            box-sizing: border-box;
        }
        .card-header {
            background-color: #4e73df;
            color: white;
            text-align: center;
            padding: 0.2cm 0;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-logo {
            width: 1cm;
            height: 1cm;
            margin-right: 0.3cm;
        }
        .card-org {
            text-align: center;
        }
        .card-body {
            padding: 0.2cm;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .photo-container {
            width: 2.5cm;
            height: 3cm;
            border: 2px solid #4e73df;
            overflow: hidden;
            margin-bottom: 0.2cm;
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .member-details {
            width: 100%;
            font-size: 10px;
        }
        .member-details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .member-details-table td {
            padding: 0.05cm 0;
        }
        .member-details-table td:first-child {
            font-weight: bold;
            width: 2.5cm;
        }
        .qr-code-container {
            margin: 0.2cm auto;
            text-align: center;
        }
        .qr-code-img {
            width: 1.8cm;
            height: 1.8cm;
        }
        .signature-line {
            margin-top: 0.2cm;
            border-bottom: 1px solid #333;
            width: 3cm;
            text-align: center;
            margin: 0.2cm auto 0.05cm;
        }
        .signature-text {
            font-size: 8px;
            text-align: center;
        }
        .card-footer {
            background-color: #f5f5f5;
            text-align: center;
            font-size: 8px;
            padding: 0.1cm;
            position: absolute;
            bottom: 0.1cm;
            left: 0.1cm;
            right: 0.1cm;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-header">
            <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="card-logo">
            <div class="card-org">
                <strong>MAJELIS MUSYAWARAH SUNDA</strong><br>
                <small>Member Identification Card</small>
            </div>
        </div>
        
        <div class="card-body">
            <div class="photo-container">
                @if(isset($photoUrl))
                    <img src="{{ public_path(str_replace('/storage', 'storage/app/public', parse_url($photoUrl, PHP_URL_PATH))) }}" alt="{{ $member->full_name }}">
                @else
                    <div style="width: 100%; height: 100%; background-color: #eee; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #999;">No Photo</span>
                    </div>
                @endif
            </div>
            
            <div class="member-details">
                <table class="member-details-table">
                    <tr>
                        <td>Name</td>
                        <td>: {{ $member->full_name }}</td>
                    </tr>
                    <tr>
                        <td>ID Number</td>
                        <td>: {{ $member->registration_number }}</td>
                    </tr>
                    <tr>
                        <td>Division</td>
                        <td>: {{ $member->division->name ?? 'Not Assigned' }}</td>
                    </tr>
                    <tr>
                        <td>Position</td>
                        <td>: {{ $member->position->name ?? 'Not Assigned' }}</td>
                    </tr>
                    <tr>
                        <td>Issue Date</td>
                        <td>: {{ $generatedAt->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
            
            @if($showQrCode && isset($qrCodeImage))
            <div class="qr-code-container">
                <img src="{{ $qrCodeImage }}" alt="QR Code" class="qr-code-img">
            </div>
            @endif
            
            <div class="signature-line"></div>
            <div class="signature-text">Chairman Signature</div>
        </div>
        
        <div class="card-footer">
            <p style="margin: 0;">This card is the property of Majelis Musyawarah Sunda</p>
            <p style="margin: 0;">Valid until: {{ $generatedAt->copy()->addYears(2)->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>