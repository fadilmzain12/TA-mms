@extends('member.layouts.app')

@section('title', 'Membership Card')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Membership Card</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="printCard()">
                <i class="bi bi-printer"></i> Print Card
            </button>
            <a href="{{ route('member.card.generate') }}" class="btn btn-sm btn-outline-success">
                <i class="bi bi-download"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-member shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Member Card</h6>
            </div>
            <div class="card-body p-0">
                <div class="id-card-container" id="printArea">
                    <div class="id-card">
                        <div class="card-background"></div>
                        <div class="watermark">
                            <img src="{{ asset('img/logo.png') }}" style="width:100%; height:100%;" alt="Watermark">
                        </div>
                        <div class="card-content">
                            <div class="id-card-header">
                                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="id-card-logo">
                                <div class="id-card-org">
                                    <h5 class="mb-0">Majelis Musyawarah Sunda</h5>
                                    <p class="small mb-0">Kartu Anggota</p>
                                </div>
                            </div>
                            
                            <div class="id-card-body">
                                <div class="id-card-photo">
                                    @if ($photoDocument)
                                        <img src="{{ asset('storage/' . $photoDocument->file_path) }}" 
                                            alt="{{ $member->full_name }}" class="img-fluid rounded">
                                    @else
                                        <div class="no-photo-placeholder rounded mx-auto d-flex align-items-center justify-content-center" 
                                            style="width: 120px; height: 150px; background-color: #f5f5f5; border: 2px solid #29204E;">
                                            <i class="bi bi-person fa-3x text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="id-card-details">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="fw-bold field-name">Nama</td>
                                            <td>: {{ $member->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold field-name">ID Anggota</td>
                                            <td>: {{ $member->registration_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold field-name">Divisi</td>
                                            <td>: {{ $member->division->name ?? 'Not Assigned' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold field-name">Jabatan</td>
                                            <td>: {{ $member->position->name ?? 'Not Assigned' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold field-name">Kota</td>
                                            <td>: {{ $member->city ?? 'Not Specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold field-name">
                                            Tanggal Penerbitan Kartu</td>
                                            <td>: {{ $generatedAt->format('d/m/Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                
                                @if($showQrCode && isset($qrCodeImage))
                                <div class="id-card-qrcode text-center mt-2">
                                    <img src="{{ $qrCodeImage }}" alt="QR Code" class="qr-code-img">
                                </div>
                                @endif
                                
                            </div>
                            
                            <div class="id-card-footer">
                                <p class="small mb-0">Kartu ini milik Majelis Musyawarah Sunda</p>
                                <p class="small mb-0">Berlaku Hingga: {{ $generatedAt->addYears(2)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .id-card-container {
        padding: 20px;
        display: flex;
        justify-content: center;
    }
    
    .id-card {
        width: 340px;
        background-color: #fff;
        border: 1px solid #333;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        position: relative;
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
    
    .watermark {
        position: absolute;
        right: 20px;
        bottom: 70px;
        width: 120px;
        height: 120px;
        opacity: 0.04;
        z-index: 0;
    }
    
    .id-card-header {
        background: linear-gradient(120deg, #29204E 0%, #453976 100%);
        color: white;
        padding: 15px;
        display: flex;
        align-items: center;
        border-bottom: 3px solid #786CA1;
    }
    
    .id-card-logo {
        width: 50px;
        height: 50px;
        margin-right: 15px;
    }
    
    .id-card-org h5 {
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        letter-spacing: 0.5px;
    }
    
    .id-card-body {
        padding: 15px;
        position: relative;
        z-index: 2;
    }
    
    .id-card-photo {
        text-align: center;
        margin-bottom: 15px;
    }
    
    .id-card-photo img {
        width: 120px;
        height: 150px;
        object-fit: cover;
        border: 2px solid #29204E;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .id-card-details {
        font-size: 14px;
    }
    
    .id-card-details td {
        padding: 2px 0;
    }
    
    .field-name {
        color: #29204E;
    }
    
    .id-card-qrcode {
        margin: 10px auto;
        background: white;
        padding: 5px;
        border-radius: 4px;
        display: inline-block;
    }
    
    .qr-code-img {
        max-width: 100px;
        max-height: 100px;
    }
    
    .signature-line {
        border-bottom: 1px solid #453976;
        width: 150px;
        margin: 0 auto 5px;
    }
    
    .id-card-footer {
        background: linear-gradient(120deg, #786CA1 0%, #29204E 100%);
        color: white;
        padding: 10px;
        text-align: center;
        font-size: 12px;
    }
    
    .id-card-footer p {
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        #printArea, #printArea * {
            visibility: visible;
        }
        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .id-card {
            width: 100%;
            max-width: 340px;
            margin: 0 auto;
            box-shadow: none;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        .card-member {
            box-shadow: none !important;
            border: none !important;
        }
        .id-card-container {
            padding: 0;
        }
        .id-card-logo {
            object-fit: contain;
        }
        .id-card-header, .id-card-footer {
            color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        .field-name {
            color: #29204E !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    function printCard() {
        window.print();
    }
</script>
@endsection