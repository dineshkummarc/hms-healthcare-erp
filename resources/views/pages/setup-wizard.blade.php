@extends('layouts.public')

@section('title', 'Healthcare Organization Setup Wizard - GrandHealth ERP')

@section('content')
<div class="py-12 bg-slate-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-slate-200">
            <div class="text-center mb-8">
                <span class="text-xs uppercase font-bold text-cyan-600 tracking-wider">Tenant Provisioning Engine</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">7-Step Healthcare Onboarding Wizard</h1>
                <p class="text-xs text-slate-500 mt-2">Initialize your hospital, clinic, or diagnostic practice with recommended modules.</p>
            </div>

            <form action="{{ route('setup.complete') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Step 1: Business Model Selection -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-3">Step 1: Choose Healthcare Business Type</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @php
                        $types = [
                            'hospital' => 'General / Multispecialty Hospital',
                            'clinic' => 'Outpatient Clinic',
                            'chamber' => 'Doctor Private Chamber',
                            'diagnostic' => 'Diagnostic & Pathology Lab',
                            'dental' => 'Dental Care Center',
                            'specialty' => 'Eye / Maternity / Therapy Center',
                        ];
                        @endphp
                        @foreach($types as $key => $label)
                        <label class="p-3 border rounded-xl cursor-pointer hover:border-cyan-500 transition block text-xs {{ $key === 'hospital' ? 'border-cyan-500 bg-cyan-50/50' : 'border-slate-200' }}">
                            <input type="radio" name="business_type" value="{{ $key }}" {{ $key === 'hospital' ? 'checked' : '' }} class="mr-1 text-cyan-600">
                            <strong>{{ $label }}</strong>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Step 2: Organization Info -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-3">Step 2: Organization & Branch Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization / Hospital Name *</label>
                            <input type="text" name="organization_name" required placeholder="e.g. Metro Care Hospital" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Primary Branch Name *</label>
                            <input type="text" name="branch_name" required placeholder="e.g. Main Medical Campus" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Billing Currency *</label>
                            <select name="currency" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                <option value="USD">USD ($)</option>
                                <option value="BDT">BDT (৳)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="AED">AED (د.إ)</option>
                                <option value="SAR">SAR (﷼)</option>
                                <option value="INR">INR (₹)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Default Locale</label>
                            <select class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                <option value="en">English (LTR)</option>
                                <option value="bn">Bengali / বাংলা (LTR)</option>
                                <option value="ar">Arabic / العربية (RTL)</option>
                                <option value="hi">Hindi / हिन्दी (LTR)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Administrator Credentials -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-3">Step 3: Administrator Account Setup</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Admin Full Name *</label>
                            <input type="text" name="admin_name" required placeholder="Dr. Admin" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Admin Email Address *</label>
                            <input type="email" name="admin_email" required placeholder="admin@metrocare.test" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Security Password *</label>
                        <input type="password" name="admin_password" required placeholder="Minimum 8 characters" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>
                </div>

                <!-- Launch Checklist -->
                <div>
                    <button type="submit" class="w-full py-4 bg-cyan-600 hover:bg-cyan-700 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-cyan-600/30 transition">
                        Provision Organization & Launch GrandHealth ERP &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
