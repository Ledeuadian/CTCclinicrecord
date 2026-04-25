<nav x-data="{ open: false, staffMode: '{{ session('staff_mode', 'personal') }}' }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->user_type == 1)
                        <!-- Student Navigation (with AJAX tab switching) -->
                        <a href="#" onclick="navigateToPatientTab('dashboard'); return false;"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('patients.dashboard') || request()->routeIs('patient.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Dashboard') }}
                        </a>

                        <a href="#" onclick="navigateToPatientTab('health-records'); return false;"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors">
                            {{ __('Health Records') }}
                        </a>

                        <a href="#" onclick="navigateToPatientTab('appointments'); return false;"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors">
                            {{ __('Appointments') }}
                        </a>

                        <a href="#" onclick="navigateToPatientTab('certificates'); return false;"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors">
                            {{ __('Certificates') }}
                        </a>
                    @elseif(Auth::user()->user_type == 2)
                        <!-- Faculty & Staff Navigation with Toggle -->
                        @if(request()->routeIs('staff.*'))
                            <!-- Staff Duties Mode -->
                            <a href="{{ route('staff.dashboard') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.dashboard') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                {{ __('Dashboard') }}
                            </a>

                            <a href="{{ route('staff.appointments') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.appointments') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Appointments') }}
                            </a>

                            <a href="{{ route('staff.patients') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.patients') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('Patients') }}
                            </a>

                            <a href="{{ route('staff.health-records') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.health-records') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Health Records') }}
                            </a>

                            <a href="{{ route('staff.medications') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.medications') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                                {{ __('Medicines') }}
                            </a>

                            <a href="{{ route('staff.prescriptions') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.prescriptions') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('Prescriptions') }}
                            </a>

                            <a href="{{ route('staff.reports') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.reports') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                {{ __('Reports') }}
                            </a>

                            <a href="{{ route('staff.certificate-requests') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('staff.certificate-requests') ? 'text-blue-600 bg-blue-50' : '' }}"
                               data-turbo-frame="staff-content">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Certificates') }}
                            </a>
                        @else
                            <!-- Personal Page Mode -->
                            <a href="{{ route('patients.dashboard') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('patients.dashboard') ? 'text-blue-600 bg-blue-50' : '' }}">
                                {{ __('Dashboard') }}
                            </a>

                            <a href="{{ route('patients.health.records') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('patients.health.records') ? 'text-blue-600 bg-blue-50' : '' }}">
                                {{ __('Health Records') }}
                            </a>

                            <a href="{{ route('patients.appointments') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('patients.appointments') ? 'text-blue-600 bg-blue-50' : '' }}">
                                {{ __('Appointments') }}
                            </a>

                            <a href="{{ route('patients.certificates.index') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('patients.certificates.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                {{ __('Certificates') }}
                            </a>
                        @endif
                    @else
                        <!-- Doctor Navigation (Full Access) -->
                        <a href="{{ route('doctor.dashboard') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.dashboard') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Dashboard') }}
                        </a>

                        <a href="{{ route('doctor.appointments') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.appointments') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Appointments') }}
                        </a>

                        <a href="{{ route('doctor.patients') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.patients') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Patients') }}
                        </a>

                        <a href="{{ route('doctor.health-records') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.health-records') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Health Records') }}
                        </a>

                        <a href="{{ route('doctor.medications') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.medications') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Medicines') }}
                        </a>

                        <a href="{{ route('doctor.prescriptions') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.prescriptions') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Prescriptions') }}
                        </a>

                        <a href="{{ route('doctor.reports') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.reports') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Reports') }}
                        </a>

                        <a href="{{ route('doctor.certificate-requests') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('doctor.certificate-requests') ? 'text-blue-600 bg-blue-50' : '' }}">
                            {{ __('Certificates') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Staff Mode Toggle Button -->
                @if(Auth::user()->user_type == 2)
                    <div class="mr-3">
                        @if(request()->routeIs('staff.*'))
                            <a href="{{ route('patients.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                My Profile
                            </a>
                        @else
                            <a href="{{ route('staff.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Staff Duties
                            </a>
                        @endif
                    </div>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2)
                            <!-- Student and Faculty & Staff Profile Links -->
                            <x-dropdown-link :href="'#'" onclick="navigateToPatientTab('profile'); return false;">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @else
                            <!-- Doctor Profile Links -->
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->user_type == 1)
                <!-- Student Mobile Navigation (with AJAX tab switching) -->
                <a href="#" onclick="navigateToPatientTab('dashboard'); return false;" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Dashboard') }}
                </a>

                <a href="#" onclick="navigateToPatientTab('health-records'); return false;" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Health Records') }}
                </a>

                <a href="#" onclick="navigateToPatientTab('appointments'); return false;" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Appointments') }}
                </a>

                <a href="#" onclick="navigateToPatientTab('certificates'); return false;" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Certificates') }}
                </a>
            @elseif(Auth::user()->user_type == 2)
                <!-- Faculty & Staff Mobile Toggle -->
                <div class="px-4 py-3">
                    @if(request()->routeIs('staff.*'))
                        <a href="{{ route('patients.dashboard') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Switch to My Profile
                        </a>
                    @else
                        <a href="{{ route('staff.dashboard') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Switch to Staff Duties
                        </a>
                    @endif
                </div>

                @if(request()->routeIs('staff.*'))
                    <!-- Staff Duties Mobile Navigation -->
                    <a href="{{ route('staff.dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Dashboard') }}
                    </a>

                    <a href="{{ route('staff.appointments') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Appointments') }}
                    </a>

                    <a href="{{ route('staff.patients') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Patients') }}
                    </a>

                    <a href="{{ route('staff.health-records') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Health Records') }}
                    </a>

                    <a href="{{ route('staff.medications') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Medicines') }}
                    </a>

                    <a href="{{ route('staff.prescriptions') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Prescriptions') }}
                    </a>

                    <a href="{{ route('staff.reports') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Reports') }}
                    </a>
                @else
                    <!-- Personal Page Mobile Navigation -->
                    <a href="{{ route('patients.dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Dashboard') }}
                    </a>

                    <a href="{{ route('patients.health.records') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Health Records') }}
                    </a>

                    <a href="{{ route('patients.appointments') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Appointments') }}
                    </a>
                @endif
            @else
                <!-- Doctor Mobile Navigation (Full Access) -->
                <a href="{{ route('doctor.dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Dashboard') }}
                </a>

                <a href="{{ route('doctor.appointments') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Appointments') }}
                </a>

                <a href="{{ route('doctor.patients') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Patients') }}
                </a>

                <a href="{{ route('doctor.health-records') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Health Records') }}
                </a>

                <a href="{{ route('doctor.medications') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Medicines') }}
                </a>

                <a href="{{ route('doctor.prescriptions') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Prescriptions') }}
                </a>

                <a href="{{ route('doctor.reports') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                    {{ __('Reports') }}
                </a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2)
                    <!-- Student and Faculty & Staff Mobile Profile -->
                    <a href="#" onclick="navigateToPatientTab('profile'); return false;" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Profile') }}
                    </a>
                @else
                    <!-- Doctor Mobile Profile -->
                    <a href="{{ route('profile.edit') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">
                        {{ __('Profile') }}
                    </a>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}"
                            class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            onKeyDown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.closest('form').submit(); }">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // Navigate to patient tab (AJAX-based navigation within patient shell)
    function navigateToPatientTab(tab) {
        const currentPath = window.location.pathname;

        // If already on a patient shell page, use AJAX to switch tabs
        if (currentPath.startsWith('/patient') && typeof switchTab === 'function') {
            switchTab(tab);
            return;
        }

        // Otherwise navigate to the shell page - the shell will handle AJAX loading
        const url = '/patient/' + (tab === 'dashboard' ? 'dashboard' : tab);
        window.location.href = url;
    }
</script>
