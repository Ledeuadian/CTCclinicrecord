<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="data:image/svg+xml;utf8, {!! rawurlencode(view('components.application-logo')->render()) !!}" type="image/svg+xml">

        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="#3b82f6">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="CKC Clinic">

        <!-- PWA Manifest -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        <!-- Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then(reg => console.log('Service Worker registered'))
                        .catch(err => console.log('Service Worker registration failed:', err));
                });
            }

            // PWA Install Handler
            let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                const btn = document.getElementById('pwa-install-btn');
                if (btn) btn.style.display = 'inline-flex';
            });

            window.addEventListener('appinstalled', () => {
                const btn = document.getElementById('pwa-install-btn');
                if (btn) btn.style.display = 'none';
                deferredPrompt = null;
            });

            function installPWA() {
                if (!deferredPrompt) return;
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    }
                    deferredPrompt = null;
                });
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main id="main-content">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>

        @if(request()->routeIs('staff.*') || request()->routeIs('doctor.*') || request()->routeIs('patients.*'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Determine which section we're in
            const currentPath = window.location.pathname;
            let sectionPrefix = '';
            if (currentPath.includes('/staff/')) sectionPrefix = 'staff';
            else if (currentPath.includes('/doctor/')) sectionPrefix = 'doctor';
            else if (currentPath.includes('/patient/')) sectionPrefix = 'patients';

            // Select nav links for current section
            const sectionLinks = document.querySelectorAll('nav a[href*="/' + sectionPrefix + '/"], nav a[href*="' + sectionPrefix + '."]');

            sectionLinks.forEach(link => {
                link.addEventListener('click', async function(e) {
                    const href = this.getAttribute('href');
                    // Skip form actions, edit/create, and methods other than GET
                    if (href.includes('/edit') || href.includes('/store') ||
                        href.includes('/update') || href.includes('/delete') ||
                        href.includes('/destroy') || href.includes('/generate') ||
                        href.includes('/export') || href.includes('/view/') ||
                        this.getAttribute('method') || this.closest('form') || href.includes('#')) {
                        return;
                    }

                    e.preventDefault();

                    // Update active state
                    sectionLinks.forEach(l => {
                        l.classList.remove('text-blue-600', 'bg-blue-50', 'border-blue-600');
                        l.classList.add('text-gray-500', 'border-transparent');
                    });
                    this.classList.add('text-blue-600', 'bg-blue-50', 'border-blue-600');
                    this.classList.remove('text-gray-500', 'border-transparent');

                    // Show loading
                    const mainContent = document.getElementById('main-content');
                    if (mainContent) {
                        mainContent.innerHTML = '<div class="flex items-center justify-center py-20"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div><span class="ml-3 text-gray-600">Loading...</span></div>';
                    }

                    try {
                        const response = await fetch(href, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html, application/xhtml+xml'
                            }
                        });

                        if (!response.ok) throw new Error('HTTP ' + response.status);

                        const html = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Extract the content area from response
                        const sourceContent = doc.querySelector('#main-content') ||
                                              doc.querySelector('.container') ||
                                              doc.body;

                        if (mainContent && sourceContent) {
                            mainContent.innerHTML = sourceContent.innerHTML;

                            // Execute any scripts found in the loaded content
                            const newScripts = mainContent.querySelectorAll('script');
                            newScripts.forEach(script => {
                                const newScript = document.createElement('script');
                                if (script.src) {
                                    newScript.src = script.src;
                                } else {
                                    newScript.textContent = script.textContent;
                                }
                                document.body.appendChild(newScript);
                            });

                            // Re-bind nav links in new content
                            bindNavLinks();
                        }

                        // Update URL without reload
                        history.pushState({path: href}, '', href);
                        if (doc.title) document.title = doc.title;

                    } catch (error) {
                        console.error('Tab loading error:', error);
                        if (mainContent) {
                            mainContent.innerHTML = '<div class="p-6"><div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Failed to load content. <a href="' + href + '" class="underline">Reload page</a></div></div>';
                        }
                    }
                });
            });

            function bindNavLinks() {
                const newSectionLinks = document.querySelectorAll('nav a[href*="/' + sectionPrefix + '/"], nav a[href*="' + sectionPrefix + '."]');
                newSectionLinks.forEach(link => {
                    if (!link.dataset.bound) {
                        link.dataset.bound = 'true';
                        link.addEventListener('click', arguments.callee.caller);
                    }
                });
            }

            // Handle browser back/forward
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.path) {
                    window.location.href = e.state.path;
                }
            });
        });
        </script>
        @endif

        <!-- Scripts Section -->
        @yield('scripts')
        @stack('scripts')
        @stack('modals')
    </body>
</html>
