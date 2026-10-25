@extends('layouts.public')

@section('title', 'GrandHealth ERP - Complete Multi-Tenant Healthcare Platform')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-cyan-50/50 via-white to-slate-50 py-20 lg:py-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-cyan-100/80 text-cyan-800 text-xs font-semibold uppercase tracking-wider mb-6">
                <span class="w-2 h-2 rounded-full bg-cyan-600 animate-pulse"></span>
                Next-Gen Healthcare Operating System
            </div>
            <h1 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-none mb-6">
                Enterprise Healthcare ERP & Hospital Operating System
            </h1>
            <p class="text-lg sm:text-xl text-slate-600 leading-relaxed mb-8">
                A unified, multi-tenant, multi-branch medical platform built for individual chambers, multi-specialty hospitals, diagnostic centers, and hospital networks. Powered by real database models, modular architecture, and assistive clinical workflows.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('page.show', 'demo') }}" class="px-8 py-4 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5">
                    Explore Live Interactive Demo &rarr;
                </a>
                <a href="{{ route('booking.form') }}" class="px-8 py-4 bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 font-bold rounded-xl shadow-sm transition">
                    Book Online Appointment
                </a>
                <a href="{{ route('setup.wizard') }}" class="px-6 py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow transition">
                    Launch Setup Wizard
                </a>
            </div>
        </div>

        <!-- Dashboard Preview Cards -->
        <div class="mt-16 bg-white rounded-2xl shadow-2xl border border-slate-200/80 p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-slate-100 gap-4">
                <div>
                    <span class="text-xs uppercase font-bold text-cyan-600 tracking-wider">Live System Overview</span>
                    <h3 class="text-xl font-bold text-slate-900">Grand City General Hospital - Main Branch</h3>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-semibold">Active Tenant</span>
                    <span class="px-3 py-1 bg-cyan-100 text-cyan-800 rounded-full text-xs font-semibold">38 Modules Active</span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xs text-slate-500 font-medium">Daily OPD Consultations</div>
                    <div class="text-2xl font-black text-slate-900 mt-1">128 Patients</div>
                    <div class="text-xs text-emerald-600 mt-1">&uarr; 14% vs last week</div>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xs text-slate-500 font-medium">Inpatient Bed Occupancy</div>
                    <div class="text-2xl font-black text-slate-900 mt-1">42 / 50 Beds</div>
                    <div class="text-xs text-cyan-600 mt-1">84% Capacity</div>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xs text-slate-500 font-medium">Laboratory Turnaround</div>
                    <div class="text-2xl font-black text-slate-900 mt-1">2.4 Hours</div>
                    <div class="text-xs text-emerald-600 mt-1">Optimal LIS Velocity</div>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xs text-slate-500 font-medium">Daily Collections</div>
                    <div class="text-2xl font-black text-emerald-700 mt-1">$14,250.00</div>
                    <div class="text-xs text-slate-500 mt-1">Reconciled double-entry</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Supported Healthcare Businesses Section -->
<section class="py-16 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl font-bold text-slate-900">Tailored to Any Healthcare Facility</h2>
            <p class="text-slate-600 mt-2">Adapt the ERP in seconds by enabling or disabling modules to match your exact business profile.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 text-center">
            @php
            $businessTypes = [
                ['name' => 'General Hospitals', 'icon' => '🏥'],
                ['name' => 'Private Chambers', 'icon' => '🩺'],
                ['name' => 'Specialty Clinics', 'icon' => '🔬'],
                ['name' => 'Diagnostic Labs', 'icon' => '🧪'],
                ['name' => 'Dental Centers', 'icon' => '🦷'],
                ['name' => 'Eye Clinics', 'icon' => '👁️'],
                ['name' => 'Maternity Homes', 'icon' => '👶'],
                ['name' => 'Physiotherapy', 'icon' => '🏃'],
                ['name' => 'Pharmacies', 'icon' => '💊'],
                ['name' => 'Ambulance Fleets', 'icon' => '🚑'],
                ['name' => 'Telemedicine', 'icon' => '📱'],
                ['name' => 'Hospital Chains', 'icon' => '🌐'],
            ];
            @endphp

            @foreach($businessTypes as $b)
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/60 hover:border-cyan-400 hover:shadow-md transition">
                <div class="text-3xl mb-2">{{ $b['icon'] }}</div>
                <div class="text-xs font-bold text-slate-800">{{ $b['name'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 38 Modules Grid Highlights -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div>
                <span class="text-xs uppercase font-bold text-cyan-600 tracking-wider">Modular Architecture</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-1">38 Production-Ready Modules</h2>
                <p class="text-slate-600 mt-2">Each module operates with its own database entities, controllers, policies, and Filament UI.</p>
            </div>
            <a href="{{ route('page.show', 'modules') }}" class="text-cyan-600 font-bold hover:underline mt-4 md:mt-0 text-sm">
                View All 38 Module Specifications &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(array_slice($modules, 0, 9) as $key => $m)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-3">
                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-md {{ $m['category'] === 'core' ? 'bg-slate-100 text-slate-700' : 'bg-cyan-100 text-cyan-800' }}">
                        {{ $m['category'] }}
                    </span>
                    @if($m['is_core'])
                        <span class="text-[10px] font-bold text-amber-600">Core</span>
                    @endif
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $m['name'] }}</h3>
                <p class="text-slate-600 text-xs leading-relaxed mb-4">{{ $m['description'] }}</p>
                <div class="text-[11px] text-slate-400 font-mono">key: {{ $key }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="py-20 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase font-bold text-cyan-600 tracking-wider">Transparent Commercial Plans</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Flexible SaaS Plans for Any Size</h2>
            <p class="text-slate-600 mt-2">Deploy on your own cloud or subscribe as an organization tenant.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($plans as $plan)
            <div class="bg-slate-50 rounded-2xl p-8 border border-slate-200 flex flex-col justify-between hover:border-cyan-500 transition">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">{{ $plan->name }}</h3>
                    <p class="text-xs text-slate-500 mt-1">{{ $plan->description }}</p>
                    <div class="mt-6 mb-6">
                        <span class="text-4xl font-extrabold text-slate-900">${{ number_format($plan->price_monthly, 0) }}</span>
                        <span class="text-slate-500 text-xs font-semibold">/ month</span>
                    </div>

                    <ul class="space-y-3 text-xs text-slate-600 mb-8">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-500 font-bold">&#10003;</span> Up to {{ $plan->max_branches }} Branch{{ $plan->max_branches > 1 ? 'es' : '' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-500 font-bold">&#10003;</span> Up to {{ $plan->max_staff }} Staff & Clinician accounts
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-500 font-bold">&#10003;</span> Up to {{ number_format($plan->max_patients) }} Registered Patients
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-500 font-bold">&#10003;</span> Storage quota: {{ number_format($plan->storage_quota_mb / 1024, 1) }} GB
                        </li>
                    </ul>
                </div>

                <a href="{{ route('setup.wizard') }}" class="w-full py-3 text-center bg-cyan-600 hover:bg-cyan-700 text-white font-bold text-xs rounded-xl shadow transition">
                    Start with {{ $plan->name }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Demo Organizations Preview -->
<section class="py-16 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-2xl font-bold">Featured Demo Hospitals & Microsites</h2>
            <p class="text-slate-400 text-xs mt-1">Explore live tenant microsites created automatically by the organization website builder.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($organizations as $org)
            <div class="bg-slate-800/80 rounded-xl p-5 border border-slate-700 flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-base text-cyan-400">{{ $org->name }}</h4>
                    <p class="text-xs text-slate-400 mt-1">Type: {{ ucfirst($org->business_type) }} | Currency: {{ $org->currency }}</p>
                    <div class="text-xs text-slate-500 mt-2">Branches: {{ $org->branches->pluck('name')->join(', ') }}</div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-700">
                    <a href="{{ route('hospital.microsite', $org->slug) }}" class="text-xs font-semibold text-white bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded-lg inline-block">
                        View Public Microsite &rarr;
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
