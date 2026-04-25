@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Tab Content Container -->
    <div id="tab-content">
        <!-- Content will be loaded dynamically -->
    </div>
</div>

<script>
    // Tab switching functionality
    function switchTab(tabName) {
        // Update URL without page reload
        const url = `/patient/${tabName === 'dashboard' ? '' : tabName}`;
        history.pushState({tab: tabName}, '', url);

        // Show loading indicator
        const contentDiv = document.getElementById('tab-content');
        contentDiv.innerHTML = `
            <div class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
            </div>
        `;

        // Load content via AJAX
        fetch(`/patient/ajax/${tabName}`)
            .then(response => response.text())
            .then(html => {
                contentDiv.innerHTML = html;
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
    }

    // Handle browser back/forward
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.tab) {
            switchTab(e.state.tab);
        }
    });

    // Initialize with dashboard tab
    document.addEventListener('DOMContentLoaded', function() {
        const path = window.location.pathname;
        const tabMatch = path.match(/\/patient(?:\/(\w+))?/);
        const initialTab = tabMatch && tabMatch[1] ? tabMatch[1] : 'dashboard';
        switchTab(initialTab);
    });
</script>
@endsection
