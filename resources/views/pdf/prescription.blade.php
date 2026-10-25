<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>Prescription #{{ $prescription->prescription_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', 'Noto Sans', sans-serif; font-size: 12px; color: #1e293b; line-height: 1.5; margin: 25px; }
        .header { border-bottom: 2px solid #0f766e; padding-bottom: 12px; margin-bottom: 15px; }
        .clinic-name { font-size: 22px; font-weight: bold; color: #0f766e; }
        .doctor-info { font-size: 14px; font-weight: bold; color: #1e293b; }
        .patient-bar { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 10px; margin-bottom: 20px; }
        .rx-symbol { font-size: 28px; font-family: serif; font-weight: bold; color: #0f766e; margin-bottom: 10px; }
        .med-item { margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #e2e8f0; }
        .med-name { font-size: 13px; font-weight: bold; color: #0f172a; }
        .med-dosage { color: #475569; font-size: 12px; }
        .footer { margin-top: 50px; border-top: 1px solid #cbd5e1; padding-top: 15px; font-size: 11px; }
        .signature-box { float: right; width: 200px; text-align: center; }
        .signature-line { border-bottom: 1px solid #333; margin-bottom: 5px; height: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%;">
                    <div class="doctor-info">Dr. {{ $prescription->doctor->user->name ?? 'Attending Clinician' }}</div>
                    <div>{{ $prescription->doctor->qualification ?? 'MBBS, Specialist' }}</div>
                    <div>Specialization: {{ $prescription->doctor->specialization ?? 'General Medicine' }}</div>
                    <div>Reg No: {{ $prescription->doctor->license_number ?? 'BMDC-000' }}</div>
                </td>
                <td style="width: 40%; text-align: right;">
                    <div class="clinic-name">{{ $prescription->organization->name ?? 'Hospital & Medical Center' }}</div>
                    <div>{{ $prescription->branch->name ?? '' }}</div>
                    <div>Emergency: {{ $prescription->branch->phone ?? '10666' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="patient-bar">
        <table style="width: 100%;">
            <tr>
                <td><strong>Patient:</strong> {{ $prescription->patient->full_name }}</td>
                <td><strong>MRN:</strong> {{ $prescription->patient->mrn }}</td>
                <td><strong>Age/Gender:</strong> {{ $prescription->patient->date_of_birth ? $prescription->patient->date_of_birth->age : 'N/A' }} Y / {{ ucfirst($prescription->patient->gender ?? '') }}</td>
                <td><strong>Date:</strong> {{ $prescription->created_at->format('d M, Y') }}</td>
            </tr>
            @if($prescription->patient->allergies)
            <tr>
                <td colspan="4" style="color: #dc2626; padding-top: 5px;">
                    <strong>Allergies / Clinical Warnings:</strong> {{ $prescription->patient->allergies }}
                </td>
            </tr>
            @endif
        </table>
    </div>

    <div class="rx-symbol">&#8478;</div>

    <div style="min-height: 250px;">
        @foreach($prescription->items as $index => $item)
        <div class="med-item">
            <div class="med-name">{{ $index + 1 }}. {{ $item->medicine_name }} {{ $item->dosage ? "({$item->dosage})" : '' }}</div>
            <div class="med-dosage">
                Frequency: <strong>{{ $item->frequency }}</strong> &nbsp;|&nbsp; 
                Duration: <strong>{{ $item->duration }}</strong> &nbsp;|&nbsp; 
                Instruction: <em>{{ $item->instructions ?? 'As directed' }}</em>
            </div>
        </div>
        @endforeach

        @if($prescription->advice)
        <div style="margin-top: 25px; background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px; border-radius: 4px;">
            <strong>General Advice / Instructions:</strong><br>
            {{ $prescription->advice }}
        </div>
        @endif

        @if($prescription->follow_up_date)
        <div style="margin-top: 15px; color: #0f766e; font-weight: bold;">
            Next Follow-up Date: {{ $prescription->follow_up_date->format('d M, Y') }}
        </div>
        @endif
    </div>

    <div class="footer">
        <div class="signature-box">
            <div class="signature-line">
                @if($prescription->is_signed)
                <span style="color: #047857; font-size: 11px; font-weight: bold;">[DIGITALLY SIGNED]</span><br>
                <span style="font-size: 9px; color: #64748b;">{{ $prescription->signed_at?->format('Y-m-d H:i:s') }}</span>
                @endif
            </div>
            Dr. {{ $prescription->doctor->user->name ?? 'Doctor' }}<br>
            Authorized Clinician Signature
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
