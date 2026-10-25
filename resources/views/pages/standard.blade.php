@extends('layouts.public')

@section('title', $title . ' - GrandHealth ERP')

@section('content')
<div class="py-16 bg-gradient-to-b from-slate-100 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="text-xs uppercase font-bold text-cyan-600 tracking-wider">Enterprise Healthcare ERP</span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 mt-2 mb-4">{{ $title }}</h1>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Detailed commercial specifications, active workflows, database entity relationships, and architectural considerations for {{ strtolower($title) }}.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($slug === 'demo')
        <!-- Special Interactive Demo Page -->
        <div class="bg-cyan-900 text-white rounded-3xl p-8 lg:p-12 shadow-xl mb-12">
            <h2 class="text-2xl sm:text-3xl font-extrabold mb-4">Interactive Demo Environment Access</h2>
            <p class="text-cyan-200 text-sm max-w-2xl mb-8">
                Explore the platform with pre-seeded synthetic clinical data. Each role accesses a scoped interface tailored to their clinical and administrative duties.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-slate-900">
                <div class="bg-white p-5 rounded-xl border border-cyan-700">
                    <span class="text-xs font-bold uppercase text-cyan-600">Super Administrator</span>
                    <h4 class="font-bold text-base mt-1">Platform Admin</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Full control across all organizations, modules, and platform subscriptions.</p>
                    <div class="text-xs font-mono bg-slate-100 p-2 rounded mb-3">
                        Email: <strong>superadmin@grandhealth.test</strong><br>
                        Password: <strong>password</strong>
                    </div>
                    <a href="/admin/login" class="text-xs font-bold text-cyan-700 hover:underline">Log into Platform Admin &rarr;</a>
                </div>

                <div class="bg-white p-5 rounded-xl border border-cyan-700">
                    <span class="text-xs font-bold uppercase text-emerald-600">Attending Clinician</span>
                    <h4 class="font-bold text-base mt-1">Doctor Portal</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Consultation queue, vitals recording, E-Prescriptions, and clinical notes.</p>
                    <div class="text-xs font-mono bg-slate-100 p-2 rounded mb-3">
                        Email: <strong>doctor@grandhealth.test</strong><br>
                        Password: <strong>password</strong>
                    </div>
                    <a href="/doctor/login" class="text-xs font-bold text-emerald-700 hover:underline">Log into Doctor Portal &rarr;</a>
                </div>

                <div class="bg-white p-5 rounded-xl border border-cyan-700">
                    <span class="text-xs font-bold uppercase text-blue-600">Patient Self-Service</span>
                    <h4 class="font-bold text-base mt-1">Patient Portal</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Book slots, download prescriptions, view lab reports, and pay invoices.</p>
                    <div class="text-xs font-mono bg-slate-100 p-2 rounded mb-3">
                        Email: <strong>patient@grandhealth.test</strong><br>
                        Password: <strong>password</strong>
                    </div>
                    <a href="/portal/login" class="text-xs font-bold text-blue-700 hover:underline">Log into Patient Portal &rarr;</a>
                </div>
            </div>
        </div>
    @endif

    @if($slug === 'modules')
        <!-- All 38 Modules List -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Complete Directory of 38 Integrated Modules</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($modules as $key => $m)
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-slate-100 text-slate-700">{{ $m['category'] }}</span>
                        @if($m['is_core'])
                            <span class="text-[10px] font-bold text-amber-600">Core Engine</span>
                        @endif
                    </div>
                    <h3 class="text-base font-bold text-slate-900">{{ $m['name'] }}</h3>
                    <p class="text-xs text-slate-600 mt-2 mb-3">{{ $m['description'] }}</p>
                    @if(!empty($m['dependencies']))
                        <div class="text-[11px] text-slate-400">
                            Requires: <span class="font-mono">{{ implode(', ', $m['dependencies']) }}</span>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Standard content sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-2xl border border-slate-200">
                <h3 class="text-xl font-bold text-slate-900 mb-4">Functional Capabilities & Clinical Guardrails</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-4">
                    GrandHealth ERP was engineered according to strict enterprise healthcare criteria. In compliance with clinical safety protocols, critical operations are transaction-safe, patient history is immutable, and sensitive access is logged in the compliance audit trail.
                </p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2">
                        <span class="text-cyan-600 font-bold">&#9679;</span>
                        <span><strong>Tenant & Branch Scoping:</strong> Strict organizational query constraints across database transactions.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-cyan-600 font-bold">&#9679;</span>
                        <span><strong>Concurrency Protection:</strong> Atomic slot assignment prevents double-booking of doctor appointment slots and hospital beds.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-cyan-600 font-bold">&#9679;</span>
                        <span><strong>Assistive AI Only:</strong> Artificial intelligence functions provide administrative summarization and messaging support; clinicians remain the sole prescribers and diagnosticians.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-cyan-600 font-bold">&#9679;</span>
                        <span><strong>Universal Localization:</strong> Full UTF-8 Unicode PDF generation and localized RTL support for Bengali, English, Arabic, and Hindi.</span>
                    </li>
                </ul>
            </div>

            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-3">Available Demonstrative Doctors</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($doctors as $doc)
                    <div class="bg-white p-4 rounded-xl border border-slate-200/80">
                        <div class="font-bold text-sm text-slate-900">Dr. {{ $doc->user->name ?? 'Doctor' }}</div>
                        <div class="text-xs text-cyan-600 font-medium">{{ $doc->specialization }}</div>
                        <div class="text-[11px] text-slate-500 mt-1">{{ $doc->department->name ?? 'Department' }} | Fee: ${{ number_format($doc->consultation_fee, 2) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 sticky top-24">
                <h4 class="font-bold text-slate-900 mb-3">Quick Navigation</h4>
                <div class="space-y-2 text-xs">
                    <a href="{{ route('booking.form') }}" class="block p-3 bg-cyan-50 text-cyan-800 rounded-xl font-semibold hover:bg-cyan-100 transition">
                        &rarr; Book Patient Appointment
                    </a>
                    <a href="{{ route('setup.wizard') }}" class="block p-3 bg-slate-100 text-slate-800 rounded-xl font-semibold hover:bg-slate-200 transition">
                        &rarr; Register New Organization
                    </a>
                    <a href="{{ route('page.show', 'demo') }}" class="block p-3 bg-emerald-50 text-emerald-800 rounded-xl font-semibold hover:bg-emerald-100 transition">
                        &rarr; View Live Demo Accounts
                    </a>
                    <a href="/admin/login" class="block p-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                        &rarr; Filament Admin Dashboard
                    </a>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-200 text-xs text-slate-500">
                    GrandHealth ERP Version 1.0.0<br>
                    PHP 8.5 / Laravel 12 / Filament 5
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
