@extends('layouts.public')

@section('title', 'Appointment Confirmed - ' . $appointment->appointment_number)

@section('content')
<div class="py-16 bg-slate-100">
    <div class="max-w-xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-slate-200 text-center">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 font-bold">
                &#10003;
            </div>

            <span class="text-xs uppercase font-bold text-emerald-600 tracking-wider">Booking Successful</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Appointment Confirmed!</h1>
            <p class="text-xs text-slate-500 mt-1 mb-6">Please keep your token number for reception check-in.</p>

            <div class="bg-cyan-50 border border-cyan-200 rounded-2xl p-6 text-left space-y-3 mb-6">
                <div class="flex justify-between items-center border-b border-cyan-100 pb-3">
                    <span class="text-xs font-semibold text-slate-500">Appointment Token:</span>
                    <span class="text-base font-black text-cyan-800">{{ $appointment->appointment_number }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold text-slate-500">Queue Token #:</span>
                    <span class="text-lg font-black text-slate-900">Slot #{{ $appointment->token_number }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold text-slate-500">Patient:</span>
                    <span class="text-sm font-bold text-slate-800">{{ $appointment->patient->full_name }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold text-slate-500">Doctor:</span>
                    <span class="text-sm font-bold text-slate-800">Dr. {{ $appointment->doctor->user->name ?? 'Doctor' }} ({{ $appointment->doctor->specialization }})</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold text-slate-500">Date & Time:</span>
                    <span class="text-sm font-bold text-slate-800">{{ $appointment->appointment_date->format('M d, Y') }} at {{ date('h:i A', strtotime($appointment->start_time)) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold text-slate-500">Location:</span>
                    <span class="text-sm text-slate-700">{{ $appointment->branch->name }}</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-cyan-100">
                    <span class="text-xs font-semibold text-slate-500">Consultation Fee:</span>
                    <span class="text-sm font-bold text-emerald-700">${{ number_format($appointment->fee, 2) }}</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('home') }}" class="w-full py-3 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-800 transition">
                    Return to Homepage
                </a>
                <a href="javascript:window.print()" class="w-full py-3 bg-slate-100 text-slate-800 font-bold text-xs rounded-xl hover:bg-slate-200 transition">
                    Print Confirmation
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
