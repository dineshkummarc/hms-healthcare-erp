@extends('layouts.public')

@section('title', $organization->name . ' - Official Healthcare Portal')

@section('content')
<!-- Microsite Hero with Brand Color -->
<div class="py-16 text-white" style="background-color: {{ $organization->primary_color ?? '#0284c7' }};">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="text-xs uppercase font-bold tracking-wider opacity-80">Certified Healthcare Facility</span>
                <h1 class="text-3xl sm:text-5xl font-black mt-2">{{ $organization->name }}</h1>
                <p class="text-white/80 text-sm mt-2 max-w-xl">
                    {{ ucfirst($organization->business_type) }} serving patients across {{ $organization->branches->count() }} specialized branches and care centers.
                </p>
            </div>
            <div>
                <a href="{{ route('booking.form') }}" class="px-6 py-3 bg-white text-slate-900 font-bold rounded-xl shadow-lg hover:bg-slate-100 transition inline-block text-sm">
                    Book Consultation Here &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Branches -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Our Hospital Branches & Units</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($organization->branches as $branch)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-lg text-slate-900">{{ $branch->name }}</h3>
                    @if($branch->is_main)
                        <span class="px-2 py-0.5 bg-cyan-100 text-cyan-800 rounded text-[10px] font-bold">Main Facility</span>
                    @endif
                </div>
                <div class="text-xs text-slate-600 space-y-1 mb-4">
                    <div>Address: {{ $branch->address ?? 'City Center' }}, {{ $branch->city }}</div>
                    <div>Phone: {{ $branch->phone ?? '24/7 Helpline' }}</div>
                    <div>Currency: {{ $branch->currency }} (Tax: {{ $branch->tax_rate }}%)</div>
                </div>
                <div class="pt-3 border-t border-slate-100 text-xs text-slate-500">
                    Departments: {{ $branch->departments->pluck('name')->join(', ') }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Doctor Directory -->
    <div>
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Consulting Physicians & Specialists</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($organization->doctors as $doctor)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-base text-slate-900">Dr. {{ $doctor->user->name ?? 'Physician' }}</h3>
                    <div class="text-xs font-semibold text-cyan-700 mt-0.5">{{ $doctor->specialization }}</div>
                    <div class="text-xs text-slate-500 mt-1">{{ $doctor->qualification }}</div>
                    <div class="text-xs text-slate-600 mt-3">{{ $doctor->bio ?? 'Dedicated healthcare professional with verified clinical credentials.' }}</div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                    <span class="font-bold text-slate-800">Fee: ${{ number_format($doctor->consultation_fee, 2) }}</span>
                    <a href="{{ route('booking.form') }}" class="text-cyan-600 font-bold hover:underline">Select & Book &rarr;</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
