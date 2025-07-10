<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership Card</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        .card-container {
            width: 8.5cm;
            height: 5.4cm;
            margin: 0 auto;
            border: 1px solid #333;
            border-radius: 0.3cm;
            padding: 0.1cm;
            position: relative;
            background-color: #fff;
            box-sizing: border-box;
            overflow: hidden;
            box-shadow: 0 0.1cm 0.3cm rgba(0,0,0,0.2);
        }
        .card-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #29204E 0%, #453976 50%, #786CA1 100%);
            opacity: 0.08;
            z-index: 0;
        }
        .card-content {
            position: relative;
            z-index: 1;
            height: 100%;
        }
        .card-header {
            background: linear-gradient(120deg, #29204E 0%, #453976 100%);
            color: white;
            padding: 0.2cm 0;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px solid #786CA1;
        }
        .card-logo {
            width: 1.2cm;
            height: 1.2cm;
            margin-right: 0.3cm;
        }
        .card-org {
            text-align: center;
        }
        .card-org strong {
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            letter-spacing: 0.5px;
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
            border: 2px solid #29204E;
            border-radius: 0.15cm;
            overflow: hidden;
            margin-bottom: 0.2cm;
            box-shadow: 0 0.05cm 0.1cm rgba(0,0,0,0.2);
            background-color: white;
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
            color: #29204E;
        }
        .signature-line {
            margin-top: 0.2cm;
            border-bottom: 1px solid #453976;
            width: 3cm;
            text-align: center;
            margin: 0.2cm auto 0.05cm;
        }
        .signature-text {
            font-size: 8px;
            text-align: center;
            color: #555;
        }
        .card-footer {
            background: linear-gradient(120deg, #786CA1 0%, #29204E 100%);
            text-align: center;
            font-size: 8px;
            padding: 0.1cm;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            color: white;
        }
        .card-footer p {
            margin: 0.02cm 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        .qr-code-container {
            position: absolute;
            right: 0.3cm;
            top: 1.8cm;
            width: 1.5cm;
            height: 1.5cm;
            overflow: hidden;
            background: white;
            border-radius: 0.1cm;
            box-shadow: 0 0.05cm 0.1cm rgba(0,0,0,0.1);
            padding: 0.05cm;
        }
        .qr-code-container img {
            width: 100%;
            height: 100%;
        }
        .watermark {
            position: absolute;
            right: 0.5cm;
            bottom: 0.5cm;
            width: 3cm;
            height: 3cm;
            opacity: 0.04;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-background"></div>
        <div class="watermark">
            <img src="{{ public_path('img/logo.png') }}" style="width:100%; height:100%;" alt="Watermark">
        </div>
        <div class="card-content">
            <div class="card-header">
                <img src="{{ public_path('img/logo.png') }}" alt="MMS Logo" class="card-logo">
                <div class="card-org">
                    <strong>MAJELIS MUSYAWARAH SUNDA</strong><br>
                    <small>Kartu Anggota</small>
                </div>
            </div>
            
            <div class="card-body">
                <div class="photo-container">
                    @if ($member->getPhotoDocument())
                        <img src="{{ public_path('storage/' . $member->getPhotoDocument()->file_path) }}" alt="Member Photo">
                    @else
                        <div style="width: 100%; height: 100%; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                            <span style="color: #999;">No Photo</span>
                        </div>
                    @endif
                </div>
                
                <div class="member-details">
                    <table class="member-details-table">
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $member->full_name }}</td>
                        </tr>
                        <tr>
                            <td>ID Anggota</td>
                            <td>: {{ $member->registration_number }}</td>
                        </tr>
                        <tr>
                            <td>Divisi</td>
                            <td>: {{ $member->division->name ?? 'Not Assigned' }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>: {{ $member->position->name ?? 'Not Assigned' }}</td>
                        </tr>
                        <tr>
                            <td>Kota</td>
                            <td>: {{ $member->city ?? 'Not Specified' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Penerbitan Kartu</td>
                            <td>: {{ $member->card_generated_at ? $member->card_generated_at->format('d/m/Y') : now()->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
                
            
            </div>
            
            @if(isset($qrCodeImage))
            <div class="qr-code-container">
                <img src="{{ $qrCodeImage }}" alt="QR Code">
            </div>
            @endif
            
            <div class="card-footer">
                <p>Kartu ini milik Majelis Musyawarah Sunda</p>
                <p>Berlaku Hingga: {{ ($member->card_generated_at ? Carbon\Carbon::parse($member->card_generated_at)->addYears(2)->format('d/m/Y') : now()->addYears(2)->format('d/m/Y')) }}</p>
            </div>
        </div>
    </div>
</body>
</html>