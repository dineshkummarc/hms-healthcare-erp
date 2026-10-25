<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GrandHealth ERP - Modern Clinic & Hospital Management')</title>
    <meta name="description" content="Complete Multi-Tenant, Multi-Branch, Modular, AI-Powered Healthcare ERP built for modern hospitals, specialty clinics, laboratories, and private chambers.">
    <!-- Tailwind CSS CDN for instant rendering -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="flex flex-col min-h-full text-slate-800">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-cyan-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md shadow-cyan-600/20">
                            +
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-slate-900">GrandHealth<span class="text-cyan-600">ERP</span></span>
                    </a>
                </div>

                <nav class="hidden md:flex items-center space-x-6 text-sm font-medium text-slate-600">
                    <a href="{{ route('page.show', 'features') }}" class="hover:text-cyan-600 transition">Features</a>
                    <a href="{{ route('page.show', 'modules') }}" class="hover:text-cyan-600 transition">Modules (38)</a>
                    <a href="{{ route('page.show', 'pricing') }}" class="hover:text-cyan-600 transition">Pricing</a>
                    <a href="{{ route('page.show', 'ai-capabilities') }}" class="hover:text-cyan-600 transition">AI & Automation</a>
                    <a href="{{ route('page.show', 'demo') }}" class="hover:text-cyan-600 transition font-semibold text-cyan-700">Live Demo</a>
                    <a href="{{ route('booking.form') }}" class="text-emerald-700 hover:text-emerald-800 transition font-semibold flex items-center gap-1">
                        <span>Book Appointment</span>
                    </a>
                </nav>

                <div class="flex items-center space-x-3">
                    <a href="/portal/login" class="text-xs font-semibold px-3 py-2 text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg">
                        Patient Portal
                    </a>
                    <a href="/doctor/login" class="text-xs font-semibold px-3 py-2 text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg">
                        Doctor Portal
                    </a>
                    <a href="/admin/login" class="text-xs font-semibold px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 shadow-sm transition">
                        Staff Login
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @if(session('status'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-8">
                <div class="col-span-2">
                    <div class="flex items-center space-x-2 text-white font-extrabold text-xl mb-4">
                        <span class="w-8 h-8 bg-cyan-500 rounded-lg flex items-center justify-center text-white text-base">+</span>
                        <span>GrandHealth ERP</span>
                    </div>
                    <p class="text-slate-400 text-sm max-w-sm mb-4">
                        Commercial-grade Clinic and Hospital Management platform designed for enterprise healthcare organizations, multi-branch hospitals, and private practice clinics.
                    </p>
                    <div class="text-xs text-slate-500">
                        Lead Developer: <span class="text-slate-300">Imran Ahmed</span> (<a href="https://imrandev.bd" target="_blank" class="text-cyan-400 underline">https://imrandev.bd</a>)
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-3">Core Modules</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('page.show', 'clinic-management') }}" class="hover:text-white">Clinic Management</a></li>
                        <li><a href="{{ route('page.show', 'hospital-management') }}" class="hover:text-white">Hospital Management</a></li>
                        <li><a href="{{ route('page.show', 'appointment-management') }}" class="hover:text-white">Appointments</a></li>
                        <li><a href="{{ route('page.show', 'emr') }}" class="hover:text-white">Electronic Medical Records</a></li>
                        <li><a href="{{ route('page.show', 'prescriptions') }}" class="hover:text-white">E-Prescriptions</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-3">Diagnostics & Ops</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('page.show', 'laboratory') }}" class="hover:text-white">Laboratory Information</a></li>
                        <li><a href="{{ route('page.show', 'radiology') }}" class="hover:text-white">Radiology & PACS</a></li>
                        <li><a href="{{ route('page.show', 'pharmacy') }}" class="hover:text-white">Pharmacy & Inventory</a></li>
                        <li><a href="{{ route('page.show', 'billing-accounting') }}" class="hover:text-white">Billing & Ledger</a></li>
                        <li><a href="{{ route('page.show', 'multi-branch') }}" class="hover:text-white">Multi-Branch Network</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-3">Platform & Legal</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('page.show', 'security-privacy') }}" class="hover:text-white">Security & Privacy</a></li>
                        <li><a href="{{ route('page.show', 'terms') }}" class="hover:text-white">Terms of Service</a></li>
                        <li><a href="{{ route('page.show', 'privacy') }}" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="{{ route('page.show', 'documentation') }}" class="hover:text-white">Documentation</a></li>
                        <li><a href="{{ route('setup.wizard') }}" class="text-cyan-400 font-semibold hover:underline">Setup Wizard</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} GrandHealth ERP. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="{{ route('page.show', 'cookie-policy') }}" class="hover:text-slate-400">Cookie Policy</a>
                    <a href="{{ route('page.show', 'support') }}" class="hover:text-slate-400">Support</a>
                    <a href="/api/v1/health" target="_blank" class="text-emerald-500 font-mono">System API Health: Online</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
