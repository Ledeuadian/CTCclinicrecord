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
                        <!-- Student Navigation (Limited) -->
                        <x-nav-link :href="route('patients.dashboard')" :active="request()->routeIs('patients.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('patients.health.records')" :active="request()->routeIs('patients.health.records')">
                            {{ __('Health Records') }}
                        </x-nav-link>

                        <x-nav-link :href="route('patients.appointments')" :active="request()->routeIs('patients.appointments')">
                            {{ __('Appointments') }}
                        </x-nav-link>
                    @elseif(Auth::user()->user_type == 2)
                        <!-- Faculty & Staff Navigation with Toggle -->
                        @if(request()->routeIs('staff.*'))
                            <!-- Staff Duties Mode -->
                            <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('staff.appointments')" :active="request()->routeIs('staff.appointments')">
                                {{ __('Appointments') }}
                            </x-nav-link>

                            <x-nav-link :href="route('staff.patients')" :active="request()->routeIs('staff.patients')">
                                {{ __('Patients') }}
                            </x-nav-link>

                            <x-nav-link :href="route('staff.health-records')" :active="request()->routeIs('staff.health-records')">
                                {{ __('Health Records') }}
                            </x-nav-link>

                            <x-nav-link :href="route('staff.medications')" :active="request()->routeIs('staff.medications')">
                                {{ __('Medicines') }}
                            </x-nav-link>

                            <x-nav-link :href="route('staff.prescriptions')" :active="request()->routeIs('staff.prescriptions')">
                                {{ __('Prescriptions') }}
                            </x-nav-link>

                            <x-nav-link :href="route('staff.reports')" :active="request()->routeIs('staff.reports')">
                                {{ __('Reports') }}
                            </x-nav-link>
                        @else
                            <!-- Personal Page Mode -->
                            <x-nav-link :href="route('patients.dashboard')" :active="request()->routeIs('patients.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('patients.health.records')" :active="request()->routeIs('patients.health.records')">
                                {{ __('Health Records') }}
                            </x-nav-link>

                            <x-nav-link :href="route('patients.appointments')" :active="request()->routeIs('patients.appointments')">
                                {{ __('Appointments') }}
                            </x-nav-link>
                        @endif
                    @else
                        <!-- Doctor Navigation (Full Access) -->
                        <x-nav-link :href="route('doctor.dashboard')" :active="request()->routeIs('doctor.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.appointments')" :active="request()->routeIs('doctor.appointments')">
                            {{ __('Appointments') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.patients')" :active="request()->routeIs('doctor.patients')">
                            {{ __('Patients') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.health-records')" :active="request()->routeIs('doctor.health-records')">
                            {{ __('Health Records') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.medications')" :active="request()->routeIs('doctor.medications')">
                            {{ __('Medicines') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.prescriptions')" :active="request()->routeIs('doctor.prescriptions')">
                            {{ __('Prescriptions') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.reports')" :active="request()->routeIs('doctor.reports')">
                            {{ __('Reports') }}
                        </x-nav-link>
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
                            <x-dropdown-link :href="route('patients.profile')">
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
                <!-- Student Mobile Navigation (Limited) -->
                <x-responsive-nav-link :href="route('patients.dashboard')" :active="request()->routeIs('patients.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('patients.health.records')" :active="request()->routeIs('patients.health.records')">
                    {{ __('Health Records') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('patients.appointments')" :active="request()->routeIs('patients.appointments')">
                    {{ __('Appointments') }}
                </x-responsive-nav-link>
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
                    <x-responsive-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('staff.appointments')" :active="request()->routeIs('staff.appointments')">
                        {{ __('Appointments') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('staff.patients')" :active="request()->routeIs('staff.patients')">
                        {{ __('Patients') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('staff.health-records')" :active="request()->routeIs('staff.health-records')">
                        {{ __('Health Records') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('staff.medications')" :active="request()->routeIs('staff.medications')">
                        {{ __('Medicines') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('staff.prescriptions')" :active="request()->routeIs('staff.prescriptions')">
                        {{ __('Prescriptions') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('staff.reports')" :active="request()->routeIs('staff.reports')">
                        {{ __('Reports') }}
                    </x-responsive-nav-link>
                @else
                    <!-- Personal Page Mobile Navigation -->
                    <x-responsive-nav-link :href="route('patients.dashboard')" :active="request()->routeIs('patients.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('patients.health.records')" :active="request()->routeIs('patients.health.records')">
                        {{ __('Health Records') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('patients.appointments')" :active="request()->routeIs('patients.appointments')">
                        {{ __('Appointments') }}
                    </x-responsive-nav-link>
                @endif
            @else
                <!-- Doctor Mobile Navigation (Full Access) -->
                <x-responsive-nav-link :href="route('doctor.dashboard')" :active="request()->routeIs('doctor.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('doctor.appointments')" :active="request()->routeIs('doctor.appointments')">
                    {{ __('Appointments') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('doctor.patients')" :active="request()->routeIs('doctor.patients')">
                    {{ __('Patients') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('doctor.health-records')" :active="request()->routeIs('doctor.health-records')">
                    {{ __('Health Records') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('doctor.medications')" :active="request()->routeIs('doctor.medications')">
                    {{ __('Medicines') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('doctor.prescriptions')" :active="request()->routeIs('doctor.prescriptions')">
                    {{ __('Prescriptions') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('doctor.reports')" :active="request()->routeIs('doctor.reports')">
                    {{ __('Reports') }}
                </x-responsive-nav-link>
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
                    <x-responsive-nav-link :href="route('patients.profile')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @else
                    <!-- Doctor Mobile Profile -->
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            onKeyDown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.closest('form').submit(); }">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
