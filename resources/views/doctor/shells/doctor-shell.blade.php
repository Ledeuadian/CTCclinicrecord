@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Doctor Mode Indicator -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-blue-800 font-medium">Doctor Mode</span>
                <span class="text-blue-600 text-sm ml-2">- Managing patient care</span>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="flex flex-wrap border-b border-gray-200">
            <button onclick="switchTab('dashboard')" id="tab-dashboard"
                class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </span>
            </button>
            <button onclick="switchTab('appointments')" id="tab-appointments"
                class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Appointments
                </span>
            </button>
            <button onclick="switchTab('patients')" id="tab-patients"
                class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Patients
                </span>
            </button>
            <button onclick="switchTab('health-records')" id="tab-health-records"
                class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Health Records
                </span>
            </button>
            <button onclick="switchTab('medications')" id="tab-medications"
                class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    Medications
                </span>
            </button>
            <button onclick="switchTab('prescriptions')" id="tab-prescriptions"
                class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Prescriptions
                </span>
            </button>
            <button onclick="switchTab('reports')" id="tab-reports"
                class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Reports
                </span>
            </button>
        </div>
    </div>

    <!-- Tab Content Container -->
    <div id="tab-content">
        <!-- Content will be loaded dynamically -->
    </div>
</div>

<script>
    // Tab switching functionality
    function switchTab(tabName) {
        // Update URL without page reload
        const url = `/doctor/${tabName === 'dashboard' ? '' : tabName}`;
        history.pushState({tab: tabName}, '', url);

        // Update active tab styling
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-600', 'border-blue-600');
            btn.classList.add('text-gray-500', 'border-transparent');
        });

        const activeBtn = document.getElementById(`tab-${tabName}`);
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-500', 'border-transparent');
            activeBtn.classList.add('text-blue-600', 'border-blue-600');
        }

        // Show loading indicator
        const contentDiv = document.getElementById('tab-content');
        contentDiv.innerHTML = `
            <div class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        `;

        // Load content via AJAX
        fetch(`/doctor/ajax/${tabName}`)
            .then(response => response.text())
            .then(html => {
                contentDiv.innerHTML = html;
                // Reinitialize any JavaScript needed for the loaded content
                initTabScripts(tabName);
            })
            .catch(error => {
                contentDiv.innerHTML = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <p class="font-bold">Error loading content</p>
                        <p>${error.message}</p>
                    </div>
                `;
            });
    }

    function initTabScripts(tabName) {
        // Add any tab-specific script initialization here
        if (tabName === 'health-records') {
            // Initialize health records sub-tabs if needed
        }
    }

    // Handle browser back/forward
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.tab) {
            switchTab(e.state.tab);
        }
    });

    // Initialize with dashboard tab
    document.addEventListener('DOMContentLoaded', function() {
        // Get initial tab from URL or default to dashboard
        const path = window.location.pathname;
        const tabMatch = path.match(/\/doctor(?:\/(\w+))?/);
        const initialTab = tabMatch && tabMatch[1] ? tabMatch[1] : 'dashboard';
        switchTab(initialTab);
    });
</script>

<style>
    .tab-btn.active {
        @apply text-blue-600 border-blue-600;
    }
</style>
@endsection
