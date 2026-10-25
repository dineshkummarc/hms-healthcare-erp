@extends('layouts.public')

@section('title', 'Book Doctor Appointment Online - GrandHealth ERP')

@section('content')
<div class="py-12 bg-slate-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-slate-200">
            <div class="text-center mb-8">
                <span class="text-xs uppercase font-bold text-cyan-600 tracking-wider">Patient Self-Scheduling</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Book an Outpatient Consultation</h1>
                <p class="text-xs text-slate-500 mt-2">Atomic queue scheduling with collision protection.</p>
            </div>

            <form action="{{ route('booking.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Doctor & Specialty *</label>
                    <select name="doctor_id" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">-- Choose Doctor --</option>
                        @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" data-branch="{{ $doc->branch_id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                            Dr. {{ $doc->user->name ?? 'Doctor' }} — {{ $doc->specialization }} ({{ $doc->branch->name ?? 'Main Branch' }}) - ${{ number_format($doc->consultation_fee, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Hospital Branch / Facility *</label>
                    <select name="branch_id" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">-- Choose Branch --</option>
                        @foreach($organizations as $org)
                            <optgroup label="{{ $org->name }}">
                                @foreach($org->branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->city }})
                                </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Preferred Date *</label>
                        <input type="date" name="appointment_date" min="{{ date('Y-m-d') }}" value="{{ old('appointment_date', date('Y-m-d')) }}" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Time Slot *</label>
                        <select name="start_time" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="09:00:00">09:00 AM</option>
                            <option value="09:30:00">09:30 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="10:30:00">10:30 AM</option>
                            <option value="11:00:00">11:00 AM</option>
                            <option value="11:30:00">11:30 AM</option>
                            <option value="14:00:00">02:00 PM</option>
                            <option value="14:30:00">02:30 PM</option>
                            <option value="15:00:00">03:00 PM</option>
                            <option value="15:30:00">03:30 PM</option>
                            <option value="16:00:00">04:00 PM</option>
                        </select>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">Patient Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Patient Full Name *</label>
                            <input type="text" name="patient_name" value="{{ old('patient_name') }}" required placeholder="e.g. John Doe" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mobile Phone Number *</label>
                            <input type="tel" name="patient_phone" value="{{ old('patient_phone') }}" required placeholder="e.g. +1 555-0199" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email (for digital receipt & confirmations)</label>
                        <input type="email" name="patient_email" value="{{ old('patient_email') }}" placeholder="patient@example.com" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Reason for Visit / Symptoms</label>
                        <textarea name="reason" rows="2" placeholder="Briefly describe your symptoms or reason for visit" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">{{ old('reason') }}</textarea>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-cyan-600 hover:bg-cyan-700 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-cyan-600/30 transition">
                        Confirm and Reserve Appointment &rarr;
                    </button>
                    <p class="text-[11px] text-slate-400 text-center mt-3">
                        Your appointment token will be generated instantly. No payment is required until reception check-in.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
