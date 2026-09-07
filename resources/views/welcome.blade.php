<!DOCTYPE html>
<html lang="bn" :class="{ 'dark': isDark }" x-data="foodCourtApp()" x-init="initApp()" :style="'filter: brightness(' + (brightnessLevel / 100) + ');'">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿ POS & Admin | Enterprise Food Court OS</title>
    <!-- Brand Favicon, PWA Web App Manifest & Android Theme Color -->
    <link rel="icon" type="image/svg+xml" href="./favicon.svg">
    <link rel="alternate icon" href="./favicon.svg">
    <link rel="apple-touch-icon" href="./favicon.svg">
    <link rel="manifest" href="./manifest.json">
    <meta name="theme-color" content="#D70F64">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="FoodCourt POS">
    
    <!-- Google Fonts: Noto Sans Bengali (Primary), Plus Jakarta Sans (Latin), JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Noto Sans Bengali"', '"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        obsidian: {
                            800: '#1e1520',
                            850: '#170f19',
                            900: '#110b12',
                            925: '#0d080e',
                            950: '#080508',
                        },
                        brand: {
                            50:  '#fff0f5',
                            100: '#ffd6e7',
                            200: '#ffadd0',
                            300: '#ff73ae',
                            400: '#f5317f',
                            500: '#D70F64',
                            600: '#b5094f',
                            700: '#8f053c',
                            800: '#6b032b',
                            900: '#47021d',
                        },
                        gold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        bkash: '#E2136E',
                        nagad: '#F7941D',
                    },
                    boxShadow: {
                        'neon-brand':     '0 0 20px -2px rgba(215, 15, 100, 0.40)',
                        'neon-amber':     '0 0 20px -2px rgba(245, 158, 11, 0.35)',
                        'glass-dark':     '0 8px 32px 0 rgba(0, 0, 0, 0.5), inset 0 1px 0 0 rgba(255,255,255,0.06)',
                        'food-card-hover':'0 12px 28px -6px rgba(215, 15, 100, 0.28), 0 4px 12px rgba(0,0,0,0.2)',
                    },
                    borderRadius: {
                        'xl': '10px',
                        '2xl': '14px',
                        '3xl': '18px',
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        /* ── Base Resets ───────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            touch-action: manipulation;
            font-size: 15px;
        }

        body {
            font-family: 'Noto Sans Bengali', 'Plus Jakarta Sans', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            letter-spacing: 0.01em;
            line-height: 1.6;
        }

        /* ── Global Smooth Transition (NOT on scroll) ─────────── */
        button, a, input, select, textarea, [role="button"], .cursor-pointer,
        .transition-all, .transition-colors {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
            transition: background-color 200ms ease, border-color 200ms ease,
                        color 200ms ease, box-shadow 200ms ease,
                        transform 200ms cubic-bezier(0.34, 1.56, 0.64, 1),
                        opacity 200ms ease;
        }

        /* ── Foodpanda-inspired Background Gradients ─────────── */
        .dark-ambient-bg {
            background-color: #110b12;
            background-image:
                radial-gradient(ellipse at 15% 10%, rgba(215,15,100,0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 88% 8%,  rgba(245,158,11,0.07) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 95%, rgba(215,15,100,0.06) 0%, transparent 55%);
            background-attachment: fixed;
        }

        .light-ambient-bg {
            background-color: #faf5f8;
            background-image:
                radial-gradient(ellipse at 5%  0%,  rgba(215,15,100,0.07) 0%, transparent 45%),
                radial-gradient(ellipse at 95% 5%,  rgba(245,158,11,0.06) 0%, transparent 40%),
                linear-gradient(180deg, #fff8fb 0%, #faf0f5 100%);
            background-attachment: fixed;
        }

        /* ── Mobile GPU Optimization ─────────────────────────── */
        @media (max-width: 768px) {
            .glass-panel-dark  { background: rgba(20, 10, 22, 0.97) !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important; }
            .glass-panel-light { background: rgba(255, 248, 251, 0.99) !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important; }
            .backdrop-blur-xl, .backdrop-blur-md, .backdrop-blur-lg { backdrop-filter: none !important; -webkit-backdrop-filter: none !important; }
        }

        /* ── Glassmorphic Panels ─────────────────────────────── */
        .glass-panel-dark {
            background: rgba(24, 10, 26, 0.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(215, 15, 100, 0.12);
            box-shadow: 0 8px 32px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.05);
            transform: translateZ(0);
        }
        .glass-panel-light {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(215, 15, 100, 0.10);
            box-shadow: 0 4px 20px rgba(215,15,100,0.06), 0 1px 4px rgba(0,0,0,0.04);
            transform: translateZ(0);
        }

        /* ── Light Mode Typography (Eye Comfort) ─────────────── */
        html:not(.dark) { color: #18020f; font-weight: 400; }
        html:not(.dark) .text-slate-900, html:not(.dark) .text-slate-800,
        html:not(.dark) .text-zinc-900,  html:not(.dark) .text-zinc-800  { color: #100008 !important; font-weight: 700; }
        html:not(.dark) .text-slate-700, html:not(.dark) .text-slate-600,
        html:not(.dark) .text-zinc-700,  html:not(.dark) .text-zinc-600  { color: #2d0c1e !important; font-weight: 600; }
        html:not(.dark) .text-slate-500, html:not(.dark) .text-slate-400,
        html:not(.dark) .text-zinc-500,  html:not(.dark) .text-zinc-400  { color: #6b3050 !important; font-weight: 500; }
        html:not(.dark) .text-brand-500, html:not(.dark) .text-brand-400 { color: #b5094f !important; font-weight: 700; }
        html:not(.dark) .text-amber-500, html:not(.dark) .text-amber-400 { color: #b45309 !important; font-weight: 700; }
        html:not(.dark) input, html:not(.dark) select, html:not(.dark) textarea { color: #100008 !important; font-weight: 500; }
        html:not(.dark) input::placeholder { color: #9e6b82 !important; font-weight: 400; }

        /* ── Dark Mode Typography ────────────────────────────── */
        html.dark { color: #f5dce8; }
        html.dark .text-zinc-100 { color: #fdedf5 !important; }
        html.dark .text-zinc-200 { color: #f5dce8 !important; }
        html.dark .text-zinc-400 { color: #d4a0b8 !important; }

        /* ── Hover Effects Library ───────────────────────────── */
        /* Food Card hover: lift + pink glow */
        .food-card {
            transition: transform 220ms cubic-bezier(0.34,1.56,0.64,1),
                        box-shadow 220ms ease, border-color 200ms ease;
        }
        .food-card:hover {
            transform: translateY(-4px) scale(1.012);
            box-shadow: 0 14px 30px -6px rgba(215,15,100,0.28), 0 4px 12px rgba(0,0,0,0.15);
            border-color: rgba(215,15,100,0.45) !important;
        }

        /* Button hover: slight scale + shadow */
        .btn-primary {
            transition: transform 180ms cubic-bezier(0.34,1.56,0.64,1), box-shadow 180ms ease, filter 180ms ease;
        }
        .btn-primary:hover  { transform: translateY(-1px); filter: brightness(1.08); box-shadow: 0 6px 18px rgba(215,15,100,0.4); }
        .btn-primary:active { transform: scale(0.97); }

        /* Nav/Tab hover */
        .nav-tab { transition: background 180ms ease, color 180ms ease, transform 180ms ease; }
        .nav-tab:hover:not(.active) { transform: translateY(-1px); }

        /* Category pill hover */
        .cat-pill { transition: transform 180ms cubic-bezier(0.34,1.56,0.64,1), box-shadow 180ms ease, background 180ms ease; }
        .cat-pill:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(215,15,100,0.25); }
        .cat-pill:active { transform: scale(0.96); }

        /* Glass panel hover */
        .panel-hover { transition: box-shadow 220ms ease, border-color 220ms ease, transform 220ms ease; }
        .panel-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(215,15,100,0.14); border-color: rgba(215,15,100,0.18) !important; }

        /* List row hover */
        .list-row { transition: background 180ms ease, padding-left 180ms ease; }
        .list-row:hover { background: rgba(215,15,100,0.07) !important; padding-left: calc(1rem + 3px); }

        /* ── Scrollbars ──────────────────────────────────────── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(215,15,100,0.25); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(215,15,100,0.55); }
        .dark ::-webkit-scrollbar-thumb { background: rgba(215,15,100,0.22); }
        .dark ::-webkit-scrollbar-thumb:hover { background: rgba(215,15,100,0.50); }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Print / Receipt ─────────────────────────────────── */
        @media screen { #printable-receipt { display: none !important; } }
        @media print {
            body * { visibility: hidden; }
            #printable-receipt, #printable-receipt * { visibility: visible; }
            #printable-receipt { display: block !important; position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 15px; color: #000 !important; background: #fff !important; }
        }
    </style>
</head>
<body :class="isDark ? 'dark dark-ambient-bg text-zinc-100' : 'light-ambient-bg text-slate-950 font-medium'" 
      class="min-h-screen font-sans antialiased selection:bg-brand-500 selection:text-white pb-52 md:pb-12"
      @keydown.window.slash.prevent="$refs.searchInput && $refs.searchInput.focus()"
      @keydown.window.escape="showAdminLoginModal = false; showMobileCartSheet = false; showMobileNavDrawer = false; showBrightnessPopover = false; showItemModal = false; showOpenCourtModal = false; showCloseCourtModal = false; showZReportModal = false; searchQuery = ''">

    <!-- FLOATING TOAST NOTIFICATION -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
         class="fixed top-4 right-4 z-50 px-4 py-2.5 rounded-lg border shadow-2xl backdrop-blur-xl flex items-center gap-2 text-xs font-bold"
         :class="toast.type === 'success' ? 'bg-brand-950/90 text-brand-300 border-brand-500/40 shadow-neon-brand' : 'bg-obsidian-900/90 text-zinc-200 border-white/[0.1]'"
         x-cloak>
        <span x-text="toast.icon || 'âœ¨'"></span>
        <span x-text="toast.message"></span>
    </div>

    <!-- MAIN MOBILE APP SHELL (Dedicated Mobile-Comfort Experience) -->
    <div class="min-h-screen w-full flex flex-col px-3 pt-2 pb-56 transition-all duration-300"
         :class="viewMode === 'mobile' ? 'max-w-lg mx-auto' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8'">

        <!-- ================================================================= -->
        <!-- PROFESSIONAL EXECUTIVE MOBILE TOP BAR -->
        <!-- ================================================================= -->
        <header class="px-3.5 py-3 rounded-lg mb-3 border shadow-md backdrop-blur-md transition-all relative space-y-2.5"
                :class="isDark ? 'bg-obsidian-950/90 border-white/[0.08] shadow-black/40 text-white' : 'bg-white/95 border-slate-200/90 shadow-slate-200/60 text-slate-900'">
            
            <!-- Top Line: Brand Emblem, Stall Title, Time, and Status Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                
                <!-- Left / Row 1: Luxury Brand Badge & Stall Dropdown Switcher -->
                <div class="flex items-center justify-between gap-2.5 min-w-0 w-full sm:w-auto">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <!-- Cloche Luxury Crown Insignia -->
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-brand-600 via-teal-700 to-brand-900 p-[1.5px] shadow-md shadow-brand-500/20 ring-1 ring-brand-400/40 flex-shrink-0 cursor-pointer active:scale-95 transition-transform"
                             @click="activeTab = 'pos'">
                            <div class="w-full h-full rounded-md bg-gradient-to-br from-obsidian-900 via-brand-950 to-zinc-950 flex items-center justify-center text-lg">
                                ðŸ‘‘
                            </div>
                        </div>

                        <div class="min-w-0 flex-1">
                            <!-- Main Title / Stall Dropdown Selector -->
                            <div class="flex items-center gap-1.5 min-w-0">
                                <!-- Super Admin Dropdown Switcher (Clean & Non-overlapping) -->
                                <template x-if="currentUserRole === 'superadmin'">
                                    <div class="relative inline-flex items-center max-w-full">
                                        <select x-model="adminViewingOwnerId" @change="adminSwitchToOwner(adminViewingOwnerId)" 
                                                class="text-xs sm:text-sm font-bold bg-brand-500/10 dark:bg-brand-950/40 text-amber-500 dark:text-amber-400 border border-amber-500/30 rounded-xl px-2.5 py-1 cursor-pointer focus:ring-1 focus:ring-amber-400 w-[140px] xs:w-[180px] sm:w-[260px] truncate shadow-xs">
                                            <option value="all" class="bg-zinc-900 text-amber-400" x-text="lang === 'bn' ? 'ðŸŒ à¦¸à¦•à¦² à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ (à¦¸à¦®à§à¦®à¦¿à¦²à¦¿à¦¤)' : 'ðŸŒ All Food Courts (Combined)'"></option>
                                            <template x-for="owner in ownerAccounts" :key="owner.id">
                                                <option :value="owner.id" class="bg-zinc-900 text-white" x-text="owner.shopName"></option>
                                            </template>
                                        </select>
                                    </div>
                                </template>

                                <!-- Individual Stall Owner Title -->
                                <template x-if="currentUserRole !== 'superadmin'">
                                    <h1 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate" x-text="getActiveFoodCourtTitle()"></h1>
                                </template>
                            </div>

                            <!-- Subtitle: Live Dhaka Clock + Role / Stall Status -->
                            <div class="text-[10px] font-mono flex items-center gap-1.5 text-slate-400 mt-0.5">
                                <span class="inline-flex items-center gap-1 text-brand-500 font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                                    <span x-text="currentDhakaTime"></span>
                                </span>
                                <span>â€¢</span>
                                <span class="text-amber-400 font-bold truncate" x-text="currentUserRole === 'superadmin' ? (lang === 'bn' ? 'à¦®à§‡à¦‡à¦¨ à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨' : 'Main Admin') : (currentUserRole === 'owner' ? (adminUser.stallNo || (lang === 'bn' ? 'à¦¸à§à¦Ÿà¦² à¦®à¦¾à¦²à¦¿à¦•' : 'Stall Owner')) : (lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿ OS' : 'KhabarBari OS'))"></span>
                            </div>

                            <!-- Dedicated APK Download Button -->
                            <a href="./FoodCourtPOS.apk" download="FoodCourtPOS.apk" 
                               class="mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-brand-500/10 hover:bg-brand-500/20 text-brand-600 dark:text-brand-400 border border-brand-500/20 text-[9px] sm:text-[10px] font-bold uppercase tracking-wide cursor-pointer transition-colors w-fit">
                                <span class="text-xs">â¬‡ï¸</span>
                                <span x-text="lang === 'bn' ? 'à¦…à¦«à¦²à¦¾à¦‡à¦¨ APK à¦¡à¦¾à¦‰à¦¨à¦²à§‹à¦¡' : 'Download Offline APK'"></span>
                            </a>
                        </div>
                    </div>

                    <!-- Mobile-Only Compact Status Badge (if screen is tight) -->
                    <div class="sm:hidden flex items-center gap-1">
                        <!-- Open / Close Quick Action -->
                        <template x-if="!isCourtOpen">
                            <button type="button" @click="openCourtModal()"
                                    class="px-2.5 py-1.5 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 text-slate-950 font-bold text-[11px] shadow-sm flex items-center gap-1 cursor-pointer active:scale-95">
                                <span>ðŸŸ¢</span>
                                <span x-text="lang === 'bn' ? 'à¦“à¦ªà§‡à¦¨' : 'Open'"></span>
                            </button>
                        </template>
                        <template x-if="isCourtOpen">
                            <button type="button" @click="openCloseCourtModal()"
                                    class="px-2.5 py-1.5 rounded-xl bg-rose-500/20 text-rose-400 border border-rose-500/40 font-bold text-[11px] flex items-center gap-1 cursor-pointer active:scale-95">
                                <span>ðŸ”´</span>
                                <span x-text="lang === 'bn' ? 'à¦•à§à¦²à§‹à¦œ' : 'Close'"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Right / Action Toolbar: Buttons in a neat, wrap-safe row with clear spacing -->
                <div class="flex items-center flex-wrap gap-1.5 justify-end w-full sm:w-auto pt-1 sm:pt-0 border-t sm:border-t-0 border-white/[0.06]">
                    <!-- Desktop Open / Close Toggle (hidden on mobile since it's in top row) -->
                    <div class="hidden sm:flex items-center">
                        <template x-if="!isCourtOpen">
                            <button type="button" @click="openCourtModal()"
                                    class="px-2.5 py-1.5 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 text-slate-950 font-bold text-[11px] shadow-sm flex items-center gap-1 cursor-pointer active:scale-95 transition-all">
                                <span>ðŸŸ¢</span>
                                <span x-text="lang === 'bn' ? 'à¦“à¦ªà§‡à¦¨' : 'Open'"></span>
                            </button>
                        </template>
                        <template x-if="isCourtOpen">
                            <button type="button" @click="openCloseCourtModal()"
                                    class="px-2.5 py-1.5 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-400 border border-rose-500/40 font-bold text-[11px] flex items-center gap-1 cursor-pointer active:scale-95 transition-all">
                                <span>ðŸ”´</span>
                                <span x-text="lang === 'bn' ? 'à¦•à§à¦²à§‹à¦œ' : 'Close'"></span>
                            </button>
                        </template>
                    </div>

                    <!-- ðŸ“² Direct 1-Click Install App on Android (Hidden on very small screens since banner is there) -->
                    <button type="button" @click="triggerInstallApp(); playChime(600)" 
                            class="hidden xs:flex px-2.5 sm:px-3 py-1.5 rounded-xl bg-gradient-to-r from-brand-400 via-teal-500 to-brand-600 text-slate-950 text-[10px] sm:text-[11px] font-bold transition-all items-center gap-1 cursor-pointer active:scale-95 shadow-md shadow-brand-500/30 ring-1 ring-brand-300"
                            :title="lang === 'bn' ? 'à¦«à§‹à¦¨à§‡ à¦¸à¦°à¦¾à¦¸à¦°à¦¿ à¦…à§à¦¯à¦¾à¦ª à¦¹à¦¿à¦¸à§‡à¦¬à§‡ à¦‡à¦¨à¦¸à§à¦Ÿà¦² à¦•à¦°à§à¦¨' : 'Install App Directly on Phone'">
                        <span class="text-xs">ðŸ“²</span>
                        <span class="hidden sm:inline" x-text="lang === 'bn' ? 'à¦‡à¦¨à¦¸à§à¦Ÿà¦² à¦…à§à¦¯à¦¾à¦ª' : 'Install App'"></span>
                        <span class="sm:hidden" x-text="lang === 'bn' ? 'à¦…à§à¦¯à¦¾à¦ª' : 'App'"></span>
                    </button>

                    <!-- Language Switcher Button (Bangla <-> English) -->
                    <button type="button" @click="toggleLanguage(); playChime(520)" 
                            class="px-2.5 py-1.5 rounded-xl border text-[11px] font-bold transition-all flex items-center gap-1 cursor-pointer active:scale-95 shadow-sm"
                            :class="isDark ? 'bg-zinc-800 hover:bg-zinc-700 text-amber-300 border-zinc-700' : 'bg-slate-100 hover:bg-slate-200 text-amber-700 border-slate-200'"
                            :title="lang === 'bn' ? 'Switch to English' : 'à¦¬à¦¾à¦‚à¦²à¦¾ à¦­à¦¾à¦·à¦¾à§Ÿ à¦ªà¦°à¦¿à¦¬à¦°à§à¦¤à¦¨ à¦•à¦°à§à¦¨'">
                        <span class="text-xs" x-text="lang === 'bn' ? 'ðŸ‡§ðŸ‡©' : 'ðŸ‡¬ðŸ‡§'"></span>
                        <span class="font-mono uppercase font-bold" x-text="lang === 'bn' ? 'à¦¬à¦¾à¦‚' : 'EN'"></span>
                    </button>

                    <!-- Desktop / Mobile View Switcher Button -->
                    <button type="button" @click="viewMode = (viewMode === 'mobile' ? 'desktop' : 'mobile'); playChime(500)" 
                            class="px-2 py-1.5 rounded-xl border text-[11px] font-bold transition-all flex items-center gap-1 cursor-pointer active:scale-95"
                            :class="viewMode === 'mobile' ? (isDark ? 'bg-zinc-800 hover:bg-zinc-700 text-brand-400 border-zinc-700' : 'bg-slate-100 hover:bg-slate-200 text-brand-700 border-slate-200') : 'bg-brand-500 text-slate-950 font-bold shadow-sm'"
                            :title="viewMode === 'mobile' ? 'à¦¡à§‡à¦¸à§à¦•à¦Ÿà¦ª à¦­à¦¿à¦‰à¦¤à§‡ à¦¸à§à¦‡à¦š à¦•à¦°à§à¦¨' : 'à¦®à§‹à¦¬à¦¾à¦‡à¦² à¦­à¦¿à¦‰à¦¤à§‡ à¦¸à§à¦‡à¦š à¦•à¦°à§à¦¨'">
                        <span x-text="viewMode === 'mobile' ? 'ðŸ’»' : 'ðŸ“±'"></span>
                    </button>

                    <!-- Dark / Light Mode Toggle Button -->
                    <button type="button" @click="toggleTheme()" 
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl border flex items-center justify-center text-xs transition-colors cursor-pointer active:scale-95"
                            :class="isDark ? 'bg-zinc-800 text-amber-400 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200'"
                            title="Dark / Light Theme">
                        <span x-text="isDark ? 'ðŸŒ™' : 'â˜€ï¸'"></span>
                    </button>
                </div>

            </div>

            <!-- Super Admin Active Viewing Notice Bar (If viewing single stall) -->
            <template x-if="currentUserRole === 'superadmin' && adminViewingOwnerId && adminViewingOwnerId !== 'all'">
                <div class="pt-2 border-t flex items-center justify-between gap-2 text-[10px] font-bold"
                     :class="isDark ? 'border-white/[0.06] text-amber-300' : 'border-slate-100 text-amber-900'">
                    <span class="truncate">ðŸ‘‘ <span x-text="lang === 'bn' ? 'à¦¬à¦°à§à¦¤à¦®à¦¾à¦¨à§‡ à¦­à¦¿à¦‰ à¦•à¦°à¦›à§‡à¦¨:' : 'Currently Viewing:'"></span> <strong x-text="getOwnerById(adminViewingOwnerId)?.shopName"></strong></span>
                    <button type="button" @click="adminSwitchToOwner('all')" class="text-amber-400 hover:underline font-bold flex-shrink-0 cursor-pointer">
                        <span x-text="lang === 'bn' ? 'â†©ï¸ à¦¸à¦•à¦² à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡ à¦«à¦¿à¦°à§à¦¨' : 'â†©ï¸ Return to All Food Courts'"></span>
                    </button>
                </div>
            </template>

            <!-- Desktop View Mode: Dedicated Top Navigation Tab Pill Bar -->
            <div x-show="viewMode === 'desktop'" class="hidden md:flex items-center justify-between pt-2.5 border-t"
                 :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                <div class="flex items-center gap-2">
                    <button type="button" @click="activeTab = 'pos'; playChime(440)"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer"
                            :class="activeTab === 'pos' ? 'bg-gradient-to-r from-brand-500 to-teal-600 text-slate-950 shadow-md shadow-brand-500/25 ring-1 ring-brand-400' : (isDark ? 'text-zinc-300 hover:text-white hover:bg-white/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100')">
                        <span>ðŸ”</span>
                        <span x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦° à¦®à§‡à¦¨à§ (POS)' : 'Food Menu'"></span>
                    </button>
                    
                    <button type="button" @click="activeTab = 'ledger'; ledgerViewMode = 'memos'; playChime(550)"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer relative"
                            :class="activeTab === 'ledger' && ledgerViewMode !== 'raw_costs' ? 'bg-gradient-to-r from-brand-500 to-teal-600 text-slate-950 shadow-md shadow-brand-500/25 ring-1 ring-brand-400' : (isDark ? 'text-zinc-300 hover:text-white hover:bg-white/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100')">
                        <span>ðŸ“Š</span>
                        <span x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦–à¦¤à¦¿à§Ÿà¦¾à¦¨ (Ledger)' : 'Sales Ledger'"></span>
                        <span x-show="todayStats.totalOrders > 0" class="px-1.5 py-0.2 rounded-full font-mono text-[9px] font-bold bg-brand-400 text-slate-950" x-text="todayStats.totalOrders"></span>
                    </button>

                    <button type="button" @click="activeTab = 'ledger'; ledgerViewMode = 'raw_costs'; playChime(600)"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer"
                            :class="activeTab === 'ledger' && ledgerViewMode === 'raw_costs' ? 'bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-md shadow-amber-500/25 ring-1 ring-amber-300' : (isDark ? 'text-zinc-300 hover:text-white hover:bg-white/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100')">
                        <span>ðŸ¥©</span>
                        <span x-text="lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦“ à¦¬à¦¾à¦œà¦¾à¦° à¦–à¦°à¦š' : 'Raw Costs'"></span>
                    </button>

                    <button type="button" @click="activeTab = 'login'; playChime(500)"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer"
                            :class="activeTab === 'login' ? 'bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-md shadow-amber-500/25 ring-1 ring-amber-300' : (isDark ? 'text-zinc-300 hover:text-white hover:bg-white/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100')">
                        <span x-text="isAdminLoggedIn ? (currentUserRole === 'superadmin' ? 'ðŸ‘‘' : 'ðŸª') : 'ðŸ”'"></span>
                        <span x-text="isAdminLoggedIn ? (currentUserRole === 'superadmin' ? (lang === 'bn' ? 'à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦¹à¦¾à¦¬' : 'Admin Hub') : (lang === 'bn' ? 'à¦®à¦¾à¦²à¦¿à¦• à¦ªà§à¦°à§‹à¦«à¦¾à¦‡à¦²' : 'Owner Profile')) : (lang === 'bn' ? 'à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦²à¦—à¦‡à¦¨' : 'Admin Login')"></span>
                    </button>
                </div>

                <!-- Desktop Quick Stats Badge -->
                <div x-show="isAdminLoggedIn" class="flex items-center gap-3 text-xs font-mono">
                    <span class="text-slate-400"><span x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à¦¿:' : 'Today Sales:'"></span> <strong class="text-brand-400 font-bold" x-text="formatCurrency(todayStats.totalRevenue)"></strong></span>
                    <span>â€¢</span>
                    <span class="text-slate-400"><span x-text="lang === 'bn' ? 'à¦…à¦°à§à¦¡à¦¾à¦°:' : 'Orders:'"></span> <strong class="text-amber-400 font-bold" x-text="todayStats.totalOrders"></strong></span>
                </div>
            </div>

        </header>

                <!-- ================================================================= -->
        <!-- TAB 1: POINT OF SALE (POS) & FOOD CARDS -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'pos'" class="flex-1 space-y-3 sm:space-y-4">
            
            <div class="w-full space-y-3 sm:space-y-4">


                    <!-- Food Menu Header & Owner Action Bar -->
                    <div class="p-2.5 rounded-lg border flex flex-wrap items-center justify-between gap-2 transition-all shadow-sm"
                         :class="isDark ? 'glass-panel-dark border-white/[0.08]' : 'glass-panel-light border-slate-200/90'">
                        
                        <div class="flex items-center gap-2.5">
                            <span class="text-lg">ðŸ”</span>
                            <div>
                                <h2 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦° à¦®à§‡à¦¨à§' : 'Food Menu'"></h2>
                                <span class="text-[10px] text-slate-400 block" x-text="isAdminLoggedIn ? (lang === 'bn' ? 'à¦®à¦¾à¦²à¦¿à¦• à¦ªà§à¦¯à¦¾à¦¨à§‡à¦²: Cash, bKash à¦¬à¦¾ Nagad-à¦ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡ à¦•à¦°à§à¦¨' : 'Owner Panel: Sell with Cash, bKash or Nagad') : (lang === 'bn' ? 'à¦†à¦®à¦¾à¦¦à§‡à¦° à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦–à¦¾à¦¬à¦¾à¦° à¦®à§‡à¦¨à§ à¦“ à¦®à§‚à¦²à§à¦¯ à¦¤à¦¾à¦²à¦¿à¦•à¦¾' : 'Special Food Menu & Prices')"></span>
                            </div>
                        </div>

                        <!-- Owner Quick Actions: Add Food Item & Today's Sales (Visible ONLY after login) -->
                        <template x-if="isAdminLoggedIn">
                            <div class="flex items-center gap-2">
                                <!-- âž• ADD FOOD ITEM BUTTON -->
                                <button @click="openNewItemModal()" 
                                        title="à¦¨à¦¤à§à¦¨ à¦–à¦¾à¦¬à¦¾à¦° à¦†à¦‡à¦Ÿà§‡à¦® à¦¯à§à¦•à§à¦¤ à¦•à¦°à§à¦¨"
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all active:scale-95 bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 hover:to-teal-500 text-slate-950 shadow-md flex items-center gap-1.5 cursor-pointer">
                                    <span class="text-sm font-bold leading-none">âž•</span>
                                    <span x-text="lang === 'bn' ? 'à¦¨à¦¤à§à¦¨ à¦–à¦¾à¦¬à¦¾à¦° à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'Add Item'"></span>
                                </button>

                                <!-- Today's Sales Pill -->
                                <button @click="activeTab = 'ledger'; ledgerFilter = 'today'; playChime(600)"
                                        title="à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦“ à¦®à§‡à¦®à§‹ à¦°à§‡à¦•à¦°à§à¦¡ à¦¦à§‡à¦–à¦¤à§‡ à¦•à§à¦²à¦¿à¦• à¦•à¦°à§à¦¨"
                                        class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-2 cursor-pointer group"
                                        :class="isDark ? 'bg-brand-950/50 hover:bg-brand-900/60 text-brand-300 border-brand-500/30' : 'bg-brand-50 hover:bg-brand-100 text-brand-900 border-brand-300'">
                                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                                    <span class="font-sans text-[11px] text-slate-400 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ:' : 'Today:'"></span>
                                    <span class="font-mono font-bold text-xs sm:text-sm text-brand-400 group-hover:scale-105 transition-transform" x-text="formatCurrency(todayStats.totalRevenue)"></span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-black/20 font-mono text-brand-300" 
                                          x-text="todayStats.totalOrders + (lang === 'bn' ? ' à¦¬à¦¿à¦•à§à¦°à¦¿' : ' sold')"></span>
                                    <span class="text-xs text-slate-400 group-hover:text-brand-400">âž”</span>
                                </button>
                            </div>
                        </template>

                        <!-- If Not Logged In, Show Owner Login Button -->
                        <template x-if="!isAdminLoggedIn">
                            <button @click="activeTab = 'login'" 
                                    title="à¦®à¦¾à¦²à¦¿à¦• à¦ªà§à¦¯à¦¾à¦¨à§‡à¦² à¦“ à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¹à¦¿à¦¸à¦¾à¦¬ à¦¦à§‡à¦–à¦¤à§‡ à¦²à¦—à¦‡à¦¨ à¦•à¦°à§à¦¨"
                                    class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer"
                                    :class="isDark ? 'bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border-amber-500/40' : 'bg-amber-100 hover:bg-amber-200 text-amber-900 border-amber-300'">
                                <span>ðŸ”</span>
                                <span x-text="lang === 'bn' ? 'à¦®à¦¾à¦²à¦¿à¦• à¦²à¦—à¦‡à¦¨' : 'Owner Sign In'"></span>
                            </button>
                        </template>
                    </div>

                    <div class="space-y-3 sm:space-y-4">
                            <!-- Search, Category & Density Controls -->
                            <div class="p-3 sm:p-4 rounded-lg transition-all space-y-2.5 sm:space-y-3"
                                 :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                                
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-1">
                                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        <input type="text" 
                                               x-ref="searchInput"
                                               x-model.debounce.120ms="searchQuery" 
                                               :placeholder="t('searchPlaceholder')" 
                                               class="w-full text-xs sm:text-sm pl-9 sm:pl-10 pr-12 py-2 sm:py-2.5 rounded-xl border focus:outline-none transition-all"
                                               :class="isDark ? 'bg-obsidian-950/90 text-zinc-100 border-white/[0.08] focus:border-brand-500 focus:shadow-neon-brand placeholder-zinc-500' : 'bg-white text-slate-900 border-slate-200 focus:border-brand-500 placeholder-slate-400 shadow-xs'">
                                        <div class="absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center gap-1">
                                            <button x-show="searchQuery" @click="searchQuery = ''" class="text-slate-400 hover:text-white text-xs mr-1">âœ•</button>
                                            <span class="hidden sm:inline px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-zinc-800 text-zinc-400 border border-zinc-700">/</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <div class="flex items-center p-0.5 rounded-xl border"
                                             :class="isDark ? 'bg-zinc-900 border-zinc-700/70' : 'bg-white border-slate-200 shadow-xs'">
                                            <button @click="mobileLayout = 'grid'" 
                                                    :class="mobileLayout === 'grid' ? (isDark ? 'bg-zinc-700 text-brand-400' : 'bg-brand-50 text-brand-700 font-bold border border-brand-300/60') : 'text-slate-400'"
                                                    class="p-1.5 rounded-lg" title="Grid View">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                            </button>
                                            <button @click="mobileLayout = 'list'" 
                                                    :class="mobileLayout === 'list' ? (isDark ? 'bg-zinc-700 text-brand-400' : 'bg-brand-50 text-brand-700 font-bold border border-brand-300/60') : 'text-slate-400'"
                                                    class="p-1.5 rounded-lg" title="List View">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Filters (Horizontal Fluid Scroll) -->
                                <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5 hide-scrollbar touch-pan-x">
                                    <template x-for="cat in categories" :key="cat.key">
                                        <button @click="selectedCategory = cat.key; playChime(500)"
                                                :class="selectedCategory === cat.key ? (isDark ? 'bg-brand-500 text-slate-950 font-extrabold shadow-neon-brand' : 'bg-gradient-to-r from-brand-600 to-teal-700 text-white font-extrabold shadow-md shadow-brand-600/25 border border-brand-500') : (isDark ? 'bg-zinc-800/70 text-zinc-400 hover:text-white border border-white/[0.04]' : 'bg-white text-slate-700 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/90 shadow-xs')"
                                                class="px-3 sm:px-3.5 py-1.5 rounded-xl text-[11px] sm:text-xs whitespace-nowrap transition-all flex items-center gap-1.5 flex-shrink-0">
                                            <span x-text="cat.icon"></span>
                                            <span x-text="lang === 'bn' ? cat.nameBn : cat.nameEn"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- VIEW 1: RESPONSIVE 2-COLUMN GRID -->
                            <template x-if="mobileLayout === 'grid'">
                                <div class="grid w-full"
                                     :class="viewMode === 'mobile' ? 'grid-cols-2 gap-2.5' : 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4'">
                                    <template x-for="item in filteredMenuItems" :key="item.id">
                                        <div class="food-card rounded-lg sm:rounded-xl overflow-hidden flex flex-col justify-between group border relative cursor-pointer"
                                             :class="isDark ? 'bg-obsidian-900/90 border-white/[0.08]' : 'bg-white border-slate-200/80 shadow-sm'">
                                            
                                            <div class="relative h-28 sm:h-36 w-full overflow-hidden bg-zinc-900 flex-shrink-0">
                                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200 ease-out" loading="lazy" decoding="async">
                                                
                                                <div class="absolute inset-x-0 top-0 p-1.5 flex items-center justify-between pointer-events-none gap-1">
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 rounded bg-black/80 backdrop-blur-md text-brand-400 border border-white/10" x-text="'#' + item.code"></span>
                                                        <template x-if="currentUserRole === 'superadmin' && (adminViewingOwnerId === 'all' || !adminViewingOwnerId)">
                                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-black/80 backdrop-blur-md text-amber-300 border border-amber-500/40" x-text="item.foodCourtName || 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ'"></span>
                                                        </template>
                                                        <span x-show="isAdminLoggedIn"
                                                              class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-black/80 backdrop-blur-md text-amber-300 border border-amber-500/40 shadow-xs flex items-center gap-0.5"
                                                              :title="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à¦¿à¦° à¦¸à¦‚à¦–à§à¦¯à¦¾' : 'Today Sold Quantity'">
                                                            <span>ðŸ”¥</span>
                                                            <span x-text="getItemTodaySoldCount(item) + (lang === 'bn' ? 'à¦Ÿà¦¿' : ' sold')"></span>
                                                        </span>
                                                    </div>
                                                    
                                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded backdrop-blur-md whitespace-nowrap shadow-xs"
                                                          :class="item.stock > 10 ? 'bg-brand-500 text-slate-950' : (item.stock > 0 ? 'bg-amber-500 text-slate-950' : 'bg-rose-600 text-white')"
                                                          x-text="item.stock > 0 ? (item.stock + (lang === 'bn' ? ' à¦¬à¦¾à¦•à¦¿' : ' left')) : (lang === 'bn' ? 'à¦¶à§‡à¦·' : 'Sold')">
                                                    </span>
                                                </div>

                                                <div class="absolute right-1.5 bottom-1.5 bg-black/80 backdrop-blur-md px-1.5 py-0.5 rounded text-[9px] font-bold text-amber-400 border border-amber-500/30 flex items-center gap-0.5">
                                                    <span>â˜…</span>
                                                    <span>4.9</span>
                                                </div>
                                            </div>

                                            <div class="p-2 sm:p-3 flex-1 flex flex-col justify-between space-y-1.5 sm:space-y-2">
                                                <div>
                                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-zinc-100 group-hover:text-brand-500 dark:group-hover:text-brand-400 transition-colors leading-snug line-clamp-1" 
                                                        x-text="lang === 'bn' ? (item.nameBn || item.name) : item.name"></h4>
                                                    <p class="hidden md:block text-[11px] text-slate-500 dark:text-zinc-400 line-clamp-1 mt-0.5 font-light" 
                                                       x-text="lang === 'bn' ? (item.descBn || item.description || '') : (item.description || '')"></p>
                                                </div>

                                                <div class="pt-2 border-t flex flex-col gap-1.5"
                                                     :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                                                    
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-baseline gap-0.5">
                                                            <span class="text-xs font-bold text-brand-500 dark:text-brand-400">à§³</span>
                                                            <span class="text-sm sm:text-base font-bold font-mono tracking-tight text-slate-900 dark:text-white" x-text="Number(item.price).toLocaleString()"></span>
                                                        </div>
                                                        <template x-if="isAdminLoggedIn">
                                                            <button @click.stop="openEditItemModal(item)" 
                                                                    title="à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¬à¦¿à¦¬à¦°à¦£ à¦¬à¦¾ à¦®à§‚à¦²à§à¦¯ à¦ªà¦°à¦¿à¦¬à¦°à§à¦¤à¦¨"
                                                                    class="p-1 rounded-md text-zinc-400 hover:text-amber-400 hover:bg-white/10 text-xs transition-colors cursor-pointer">
                                                                âœï¸
                                                            </button>
                                                        </template>
                                                    </div>

                                                    <!-- Quantity Selector & 3 Direct Payment Sell Buttons (Visible ONLY after Owner Login) -->
                                                    <template x-if="isAdminLoggedIn">
                                                        <div class="space-y-1.5 w-full pt-1" @click.stop>
                                                            <!-- Quantity Control & Price Auto-Sum -->
                                                            <div class="flex items-center justify-between gap-1 p-1 rounded-xl border"
                                                                 :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                                                                <div class="flex items-center gap-1">
                                                                    <span class="text-[10px] text-slate-400 font-sans font-bold" x-text="lang === 'bn' ? 'à¦ªà¦°à¦¿à¦®à¦¾à¦£:' : 'Qty:'"></span>
                                                                    <div class="flex items-center rounded-lg border border-white/10 overflow-hidden"
                                                                         :class="isDark ? 'bg-zinc-900' : 'bg-white'">
                                                                        <button type="button" @click="stepItemSaleQty(item.id, -1); playChime(350)" class="w-7 h-7 flex items-center justify-center text-sm font-bold text-zinc-300 hover:text-white hover:bg-white/10 active:scale-95 transition-all">-</button>
                                                                        <span class="w-7 text-center font-bold font-mono text-brand-400 text-xs" x-text="getItemSaleQty(item.id)"></span>
                                                                        <button type="button" @click="stepItemSaleQty(item.id, 1); playChime(450)" class="w-7 h-7 flex items-center justify-center text-sm font-bold text-zinc-300 hover:text-white hover:bg-white/10 active:scale-95 transition-all">+</button>
                                                                    </div>

                                                                </div>
                                                                <div class="text-right font-mono">
                                                                    <span class="text-[9px] text-slate-400 block leading-none font-sans" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ' : 'Total'"></span>
                                                                    <span class="text-xs font-bold text-amber-400" x-text="'à§³' + (item.price * getItemSaleQty(item.id)).toLocaleString()"></span>
                                                                </div>
                                                            </div>

                                                            <!-- 3 Direct Payment Sell Buttons: Cash, bKash, Nagad -->
                                                            <div class="grid grid-cols-3 gap-1 w-full">
                                                                <button @click="instantSaleWithPayment(item, 'Cash', getItemSaleQty(item.id))" 
                                                                        title="à¦•à§à¦¯à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡"
                                                                        class="py-1.5 px-0.5 rounded-lg text-[10px] sm:text-[11px] font-bold transition-all active:scale-95 bg-brand-500 hover:bg-brand-400 text-slate-950 shadow-xs flex items-center justify-center gap-0.5 cursor-pointer">
                                                                    <span>ðŸ’µ</span>
                                                                    <span>Cash</span>
                                                                </button>
                                                                <button @click="instantSaleWithPayment(item, 'bKash', getItemSaleQty(item.id))" 
                                                                        title="à¦¬à¦¿à¦•à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡"
                                                                        class="py-1.5 px-0.5 rounded-lg text-[10px] sm:text-[11px] font-bold transition-all active:scale-95 bg-[#E2136E] hover:bg-[#c90f61] text-white shadow-xs flex items-center justify-center gap-0.5 cursor-pointer">
                                                                    <span>ðŸŒ¸</span>
                                                                    <span>bKash</span>
                                                                </button>
                                                                <button @click="instantSaleWithPayment(item, 'Nagad', getItemSaleQty(item.id))" 
                                                                        title="à¦¨à¦—à¦¦ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡"
                                                                        class="py-1.5 px-0.5 rounded-lg text-[10px] sm:text-[11px] font-bold transition-all active:scale-95 bg-[#F7941D] hover:bg-[#e08212] text-white shadow-xs flex items-center justify-center gap-0.5 cursor-pointer">
                                                                    <span>ðŸŠ</span>
                                                                    <span>Nagad</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <!-- VIEW 2: FAST COMPACT ROW LIST VIEW -->
                            <template x-if="mobileLayout === 'list'">
                                <div class="space-y-2 w-full">
                                    <template x-for="item in filteredMenuItems" :key="item.id">
                                        <div class="p-2 sm:p-2.5 rounded-lg border flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-3 transition-all group"
                                             :class="isDark ? 'bg-obsidian-900/90 border-white/[0.08] hover:border-brand-500/40' : 'bg-white border-slate-200/80 hover:border-slate-300 shadow-xs'">
                                            
                                            <!-- Top/Left: Image & Details -->
                                            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                                <div class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden bg-zinc-900 flex-shrink-0">
                                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                                    <span class="absolute bottom-1 right-1 text-[8px] font-mono font-bold px-1 rounded bg-black/80 text-brand-400" x-text="'#' + item.code"></span>
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-zinc-100 truncate" x-text="lang === 'bn' ? (item.nameBn || item.name) : item.name"></h4>
                                                    <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                                        <span class="text-[10px] text-slate-500 dark:text-zinc-400" x-text="getCategoryName(item.category)"></span>
                                                        <span class="text-[10px] font-bold" :class="item.stock > 10 ? 'text-brand-500' : 'text-amber-500'" x-text="'â€¢ ' + (lang === 'bn' ? item.stock + ' à¦¬à¦¾à¦•à¦¿' : item.stock + ' left')"></span>
                                                        <span x-show="isAdminLoggedIn"
                                                              class="text-[10px] font-bold text-amber-400 font-mono bg-amber-500/15 px-1.5 py-0.2 rounded-md border border-amber-500/30" 
                                                              x-text="'ðŸ”¥ ' + getItemTodaySoldCount(item) + (lang === 'bn' ? ' à¦¬à¦¿à¦•à§à¦°à¦¿' : ' sold')"></span>
                                                    </div>
                                                    <div class="flex items-baseline gap-1 mt-1">
                                                        <span class="text-xs font-bold text-brand-500">à§³</span>
                                                        <span class="text-sm font-mono font-bold text-slate-900 dark:text-white" x-text="Number(item.price).toLocaleString()"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bottom/Right: Quantity Stepper & 3 Direct Payment Buttons (Admin Only) -->
                                            <template x-if="isAdminLoggedIn">
                                                <div class="flex items-center justify-between sm:justify-end gap-1.5 sm:gap-2 pt-1.5 sm:pt-0 border-t sm:border-t-0 border-white/[0.06] flex-shrink-0" @click.stop>
                                                    <!-- Quantity Stepper -->
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-[10px] text-slate-400 font-sans sm:hidden" x-text="lang === 'bn' ? 'à¦ªà¦°à¦¿à¦®à¦¾à¦£:' : 'Qty:'"></span>
                                                        <div class="flex items-center rounded-lg border border-white/10 overflow-hidden"
                                                             :class="isDark ? 'bg-zinc-900' : 'bg-slate-100'">
                                                            <button type="button" @click="stepItemSaleQty(item.id, -1); playChime(350)" class="w-6 h-6 flex items-center justify-center text-xs font-bold text-zinc-300 hover:text-white hover:bg-white/10">-</button>
                                                            <span class="w-6 text-center font-bold font-mono text-brand-400 text-xs" x-text="getItemSaleQty(item.id)"></span>
                                                            <button type="button" @click="stepItemSaleQty(item.id, 1); playChime(450)" class="w-6 h-6 flex items-center justify-center text-xs font-bold text-zinc-300 hover:text-white hover:bg-white/10">+</button>
                                                        </div>
                                                        <!-- Subtotal Preview -->
                                                        <div class="text-right font-mono min-w-[45px] sm:min-w-[50px]">
                                                            <span class="text-[8px] text-slate-400 block font-sans leading-none sm:hidden" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ' : 'Total'"></span>
                                                            <span class="text-xs font-bold text-amber-400" x-text="'à§³' + (item.price * getItemSaleQty(item.id)).toLocaleString()"></span>
                                                        </div>
                                                    </div>

                                                    <button @click="openEditItemModal(item)" 
                                                            title="à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¬à¦¿à¦¬à¦°à¦£ à¦¬à¦¾ à¦®à§‚à¦²à§à¦¯ à¦ªà¦°à¦¿à¦¬à¦°à§à¦¤à¦¨"
                                                            class="p-1 sm:p-1.5 rounded-xl border text-xs text-zinc-400 hover:text-amber-400 border-zinc-700 hover:bg-white/10 transition-all cursor-pointer">
                                                        âœï¸
                                                    </button>

                                                    <!-- Payment Buttons -->
                                                    <div class="flex items-center gap-1">
                                                        <button @click="instantSaleWithPayment(item, 'Cash', getItemSaleQty(item.id))" 
                                                                title="à¦•à§à¦¯à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿"
                                                                class="px-2 sm:px-2.5 py-1.5 rounded-xl text-[10px] sm:text-xs font-bold transition-all active:scale-95 bg-brand-500 hover:bg-brand-400 text-slate-950 shadow-xs flex items-center gap-0.5 cursor-pointer">
                                                            <span>ðŸ’µ</span>
                                                            <span>Cash</span>
                                                        </button>
                                                        <button @click="instantSaleWithPayment(item, 'bKash', getItemSaleQty(item.id))" 
                                                                title="à¦¬à¦¿à¦•à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿"
                                                                class="px-2 sm:px-2.5 py-1.5 rounded-xl text-[11px] sm:text-xs font-bold transition-all active:scale-95 bg-[#E2136E] hover:bg-[#c90f61] text-white shadow-xs flex items-center gap-1 cursor-pointer">
                                                            <span>ðŸŒ¸</span>
                                                            <span>bKash</span>
                                                        </button>
                                                        <button @click="instantSaleWithPayment(item, 'Nagad', getItemSaleQty(item.id))" 
                                                                title="à¦¨à¦—à¦¦ à¦¬à¦¿à¦•à§à¦°à¦¿"
                                                                class="px-2 sm:px-2.5 py-1.5 rounded-xl text-[11px] sm:text-xs font-bold transition-all active:scale-95 bg-[#F7941D] hover:bg-[#e08212] text-white shadow-xs flex items-center gap-1 cursor-pointer">
                                                            <span>ðŸŠ</span>
                                                            <span>Nagad</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>

                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                </div>
        </main>

        <!-- ================================================================= -->
        <!-- TAB 2: ADMIN EXECUTIVE DASHBOARD & ANALYTICS -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'admin-dashboard' || activeTab === 'analytics'" class="flex-1 space-y-4">
            
            <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-4 gap-2.5 sm:gap-4">
                <div class="p-3.5 sm:p-5 rounded-lg border transition-all" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-zinc-400" x-text="t('kpiTotalRevenue')"></span>
                        <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-brand-500/15 text-brand-400 flex items-center justify-center text-xs sm:text-base font-bold">à§³</div>
                    </div>
                    <div class="mt-2 sm:mt-3">
                        <h3 class="text-base sm:text-2xl font-bold font-mono text-slate-900 dark:text-white truncate" x-text="formatCurrency(analyticsData.totalRevenue)"></h3>
                        <span class="text-[10px] sm:text-xs text-brand-500 font-bold">â–² +14.2%</span>
                    </div>
                </div>

                <div class="p-3.5 sm:p-5 rounded-lg border transition-all" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-zinc-400" x-text="t('kpiTotalOrders')"></span>
                        <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-blue-500/15 text-blue-400 flex items-center justify-center text-xs sm:text-base font-bold">ðŸ“¦</div>
                    </div>
                    <div class="mt-2 sm:mt-3">
                        <h3 class="text-base sm:text-2xl font-bold font-mono text-slate-900 dark:text-white" x-text="analyticsData.totalOrders"></h3>
                        <span class="text-[10px] sm:text-xs text-blue-500 font-bold">â–² +8.6%</span>
                    </div>
                </div>

                <div class="p-3.5 sm:p-5 rounded-lg border transition-all" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-zinc-400" x-text="t('kpiAov')"></span>
                        <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-amber-500/15 text-amber-400 flex items-center justify-center text-xs sm:text-base font-bold">ðŸŽ¯</div>
                    </div>
                    <div class="mt-2 sm:mt-3">
                        <h3 class="text-base sm:text-2xl font-bold font-mono text-slate-900 dark:text-white truncate" x-text="formatCurrency(analyticsData.averageOrderValue)"></h3>
                        <span class="text-[10px] sm:text-xs text-amber-500 font-bold">â–² +à§³45</span>
                    </div>
                </div>

                <div class="p-3.5 sm:p-5 rounded-lg border transition-all" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] sm:text-xs font-bold text-slate-500 dark:text-zinc-400" x-text="t('kpiProfit')"></span>
                        <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-purple-500/15 text-purple-400 flex items-center justify-center text-xs sm:text-base font-bold">ðŸ“Š</div>
                    </div>
                    <div class="mt-2 sm:mt-3">
                        <h3 class="text-base sm:text-2xl font-bold font-mono text-purple-400 truncate" x-text="formatCurrency(analyticsData.totalProfit)"></h3>
                        <span class="text-[10px] sm:text-xs text-purple-500 font-mono">~58% margin</span>
                    </div>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="p-4 sm:p-6 rounded-lg border transition-all space-y-3" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h4 class="font-extrabold text-sm sm:text-base text-slate-900 dark:text-white" x-text="t('revenueTrendTitle')"></h4>
                        <p class="text-[11px] text-slate-500 dark:text-zinc-400" x-text="t('revenueTrendSubtitle')"></p>
                    </div>
                    <div class="flex items-center gap-1 p-0.5 rounded-lg border text-xs" :class="isDark ? 'bg-obsidian-950 border-white/[0.08]' : 'bg-slate-100 border-slate-200'">
                        <button @click="analyticsViewMode = '7d'" :class="analyticsViewMode === '7d' ? (isDark ? 'bg-brand-500 text-slate-950 font-bold' : 'bg-white font-bold text-slate-900') : 'text-slate-400'" class="px-2.5 py-1 rounded">7 Days</button>
                        <button @click="analyticsViewMode = 'months'" :class="analyticsViewMode === 'months' ? (isDark ? 'bg-brand-500 text-slate-950 font-bold' : 'bg-white font-bold text-slate-900') : 'text-slate-400'" class="px-2.5 py-1 rounded">12 Months</button>
                    </div>
                </div>

                <template x-if="analyticsViewMode === '7d'">
                    <div class="pt-2">
                        <svg viewBox="0 0 700 200" class="w-full h-36 sm:h-48 overflow-visible">
                            <defs>
                                <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#10b981" stop-opacity="0.45"/>
                                    <stop offset="100%" stop-color="#10b981" stop-opacity="0.0"/>
                                </linearGradient>
                            </defs>
                            <path :d="chartData.areaPath" fill="url(#chartGrad)"/>
                            <path :d="chartData.linePath" fill="none" stroke="#10b981" stroke-width="3.5" stroke-linecap="round"/>
                            <template x-for="(pt, idx) in chartData.points" :key="idx">
                                <g>
                                    <circle :cx="pt.x" :cy="pt.y" r="4.5" class="fill-slate-950 stroke-brand-400 stroke-[2.5]"/>
                                    <text :x="pt.x" y="195" text-anchor="middle" class="text-[10px] fill-slate-400 font-mono" x-text="pt.label"></text>
                                </g>
                            </template>
                        </svg>
                    </div>
                </template>

                <template x-if="analyticsViewMode === 'months'">
                    <div class="grid grid-cols-6 sm:grid-cols-12 gap-1.5 pt-4 items-end h-36 sm:h-44">
                        <template x-for="m in monthlySalesData" :key="m.monthKey">
                            <div class="flex flex-col items-center gap-1 h-full justify-end group">
                                <div class="w-full bg-brand-500/25 rounded-t group-hover:bg-brand-500 transition-colors" :style="`height: ${(m.sales / 1000000) * 100}%;`"></div>
                                <span class="text-[9px] text-slate-500 font-mono" x-text="lang === 'bn' ? m.nameBn : m.nameEn"></span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Daily Sold Items Pie Chart & Category Velocity -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 sm:gap-4">
                <!-- SVG Interactive Donut Pie Chart Card -->
                <div class="lg:col-span-6 p-4 sm:p-6 rounded-lg border transition-all space-y-4" 
                     :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-900 dark:text-white flex items-center gap-2">
                                <span>ðŸ¥§</span>
                                <span x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦–à¦¾à¦¬à¦¾à¦° à¦¬à¦¿à¦•à§à¦°à¦¿à¦° à¦ªà¦¾à¦‡à¦šà¦¾à¦°à§à¦Ÿ' : 'Daily Sold Items Pie Chart'"></span>
                            </h4>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¸à¦°à§à¦¬à¦¾à¦§à¦¿à¦• à¦¬à¦¿à¦•à§à¦°à¦¿à¦¤ à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦…à¦¨à§à¦ªà¦¾à¦¤' : 'Distribution of top sold items today'"></p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-brand-500/15 text-brand-500 border border-brand-500/30" 
                              x-text="(dailySoldItemsData.totalQuantity || 0) + (lang === 'bn' ? ' à¦Ÿà¦¿ à¦¬à¦¿à¦•à§à¦°à¦¿' : ' sold')">
                        </span>
                    </div>

                    <!-- SVG Donut Chart with Center Metrics -->
                    <div class="flex flex-col sm:flex-row items-center justify-around gap-6 py-2">
                        <div class="relative w-44 h-44 sm:w-48 sm:h-48 flex-shrink-0">
                            <svg viewBox="0 0 200 200" class="w-full h-full transform -rotate-90">
                                <!-- Background Track Circle -->
                                <circle cx="100" cy="100" r="70" 
                                        fill="transparent" 
                                        :stroke="isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)'" 
                                        stroke-width="24" />

                                <!-- Dynamic Slices for Each Item -->
                                <template x-for="(slice, idx) in dailySoldItemsData.items" :key="idx">
                                    <circle cx="100" cy="100" r="70" 
                                            fill="transparent" 
                                            :stroke="slice.color" 
                                            stroke-width="24" 
                                            :stroke-dasharray="slice.strokeDasharray" 
                                            :stroke-dashoffset="slice.strokeDashoffset" 
                                            class="transition-all duration-700 ease-out hover:stroke-width-[28] hover:opacity-90 cursor-pointer" />
                                </template>
                            </svg>

                            <!-- Center Donut Label -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                <span class="text-[9px] font-bold text-slate-400 dark:text-zinc-500 uppercase tracking-wider" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦–à¦¾à¦¬à¦¾à¦°' : 'Total Items'"></span>
                                <span class="text-xl sm:text-2xl font-bold font-mono text-slate-900 dark:text-white" x-text="dailySoldItemsData.totalQuantity"></span>
                                <span class="text-[10px] font-bold text-brand-500 font-mono" x-text="formatCurrency(dailySoldItemsData.totalRevenue)"></span>
                            </div>
                        </div>

                        <!-- Mini Legend List on Right of Donut -->
                        <div class="space-y-1.5 flex-1 w-full">
                            <template x-for="item in dailySoldItemsData.items" :key="item.nameBn">
                                <div class="flex items-center justify-between text-xs p-1.5 rounded-xl border transition-all"
                                     :class="isDark ? 'bg-obsidian-950/60 border-white/[0.06] hover:bg-white/[0.04]' : 'bg-slate-50 border-slate-200/80 hover:bg-slate-100'">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" :style="`background-color: ${item.color}; box-shadow: 0 0 8px ${item.glow};`"></span>
                                        <span class="font-bold text-slate-900 dark:text-zinc-100 truncate text-[11px]" x-text="lang === 'bn' ? item.nameBn : item.nameEn"></span>
                                    </div>
                                    <div class="flex items-center gap-2 font-mono flex-shrink-0 text-right">
                                        <span class="text-[10px] font-bold text-slate-500 dark:text-zinc-400" x-text="item.quantity + ' pcs'"></span>
                                        <span class="px-1.5 py-0.2 rounded font-bold text-[10px] text-white" :style="`background-color: ${item.color};`" x-text="item.percent + '%'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Top Items Progress Breakdown Card -->
                <div class="lg:col-span-6 p-4 sm:p-6 rounded-lg border transition-all space-y-3" 
                     :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-900 dark:text-white flex items-center gap-2">
                                <span>ðŸ”¥</span>
                                <span x-text="lang === 'bn' ? 'à¦¶à§€à¦°à§à¦· à¦¬à¦¿à¦•à§à¦°à¦¿à¦¤ à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¤à¦¾à¦²à¦¿à¦•à¦¾ à¦“ à¦†à§Ÿ' : 'Top Items Volume & Revenue'"></span>
                            </h4>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦­à¦²à¦¿à¦‰à¦® à¦…à¦¨à§à¦¯à¦¾à§Ÿà§€ à¦°à§à¦¯à¦¾à¦™à§à¦•à¦¿à¦‚' : 'Ranked by sales volume today'"></p>
                        </div>
                        <span class="text-xs font-bold text-amber-500 font-mono">Live Velocity</span>
                    </div>

                    <div class="space-y-2.5 pt-1">
                        <template x-for="(item, idx) in dailySoldItemsData.items" :key="item.nameBn">
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-800 dark:text-zinc-200 flex items-center gap-1.5">
                                        <span class="text-[10px] font-mono w-4 text-slate-400" x-text="'#' + (idx + 1)"></span>
                                        <span x-text="lang === 'bn' ? item.nameBn : item.nameEn"></span>
                                    </span>
                                    <div class="flex items-center gap-2 font-mono">
                                        <span class="text-slate-500 dark:text-zinc-400 text-[10px]" x-text="item.quantity + ' pcs'"></span>
                                        <span class="text-brand-500 font-bold" x-text="formatCurrency(item.revenue)"></span>
                                    </div>
                                </div>
                                <div class="w-full h-2 rounded-full overflow-hidden" :class="isDark ? 'bg-zinc-800' : 'bg-slate-200'">
                                    <div class="h-full rounded-full transition-all duration-500" 
                                         :style="`width: ${item.percent}%; background-color: ${item.color};`"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </main>

        <!-- ================================================================= -->
        <!-- TAB 3: ADMIN INVENTORY & STOCK -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'admin-inventory'" class="flex-1 space-y-4">
            <div class="p-4 sm:p-6 rounded-lg border transition-all space-y-4" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>ðŸ“¦</span>
                        <span x-text="lang === 'bn' ? 'à¦‡à¦¨à¦­à§‡à¦¨à§à¦Ÿà¦°à¦¿ à¦“ à¦¸à§à¦Ÿà¦•' : 'Stock & Inventory'"></span>
                    </h3>
                    <div class="flex items-center gap-2 font-mono text-[11px] sm:text-xs">
                        <div class="px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-400">
                            <span x-text="lang === 'bn' ? 'à¦•à¦® à¦¸à§à¦Ÿà¦•: ' : 'Low Stock: '"></span><span class="font-bold" x-text="lowStockCount"></span>
                        </div>
                        <div class="px-2.5 py-1 rounded-lg bg-brand-500/10 border border-brand-500/30 text-brand-400">
                            <span x-text="lang === 'bn' ? 'à¦­à§à¦¯à¦¾à¦²à§: ' : 'Total Value: '"></span><span class="font-bold" x-text="formatCurrency(totalInventoryValue)"></span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="border-b font-bold" :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08] text-zinc-400' : 'bg-slate-50 border-slate-200 text-slate-500'">
                            <tr>
                                <th class="p-2.5" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦°' : 'Food Item'"></th>
                                <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦®à§‚à¦²à§à¦¯' : 'Price'"></th>
                                <th class="p-2.5 text-center" x-text="lang === 'bn' ? 'à¦¸à§à¦Ÿà¦•' : 'Stock'"></th>
                                <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦°à¦¿à¦¸à§à¦Ÿà¦•' : 'Restock'"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" :class="isDark ? 'divide-white/[0.04]' : 'divide-slate-100'">
                            <template x-for="item in menuItems" :key="item.id">
                                <tr class="transition-colors" :class="isDark ? 'hover:bg-white/[0.03]' : 'hover:bg-slate-50/70'">
                                    <td class="p-2.5">
                                        <div class="flex items-center gap-2">
                                            <img :src="item.image" class="w-8 h-8 rounded-lg object-cover">
                                            <div>
                                                <div class="font-bold text-slate-900 dark:text-white" x-text="lang === 'bn' ? (item.nameBn || item.name) : item.name"></div>
                                                <div class="text-[9px] font-mono text-slate-400" x-text="item.code"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2.5 text-right font-mono font-bold text-brand-500" x-text="formatCurrency(item.price)"></td>
                                    <td class="p-2.5 text-center font-mono font-bold">
                                        <input type="number" x-model.number="item.stock" @change="saveToStorage(); showToast(lang === 'bn' ? 'à¦¸à§à¦Ÿà¦• à¦†à¦ªà¦¡à§‡à¦Ÿ à¦¹à§Ÿà§‡à¦›à§‡' : 'Stock updated')" class="w-14 text-center py-1 rounded-lg border font-bold text-xs" :class="isDark ? 'bg-obsidian-950 border-white/[0.08] text-white' : 'bg-white border-slate-200 text-slate-900'">
                                    </td>
                                    <td class="p-2.5 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button @click="item.stock += 10; saveToStorage(); playChime(600); showToast(lang === 'bn' ? '+10 à¦°à¦¿à¦¸à§à¦Ÿà¦• à¦¸à¦®à§à¦ªà¦¨à§à¦¨' : '+10 Restocked')" class="px-2 py-1 rounded font-mono text-[10px] font-bold bg-zinc-800 text-zinc-300 cursor-pointer">+10</button>
                                            <button @click="item.stock += 50; saveToStorage(); playChime(800); showToast(lang === 'bn' ? '+50 à¦°à¦¿à¦¸à§à¦Ÿà¦• à¦¸à¦®à§à¦ªà¦¨à§à¦¨' : '+50 Restocked')" class="px-2 py-1 rounded font-mono text-[10px] font-bold bg-brand-500/20 text-brand-400 border border-brand-500/30 cursor-pointer">+50</button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- ================================================================= -->
        <!-- TAB 4: LIVE KITCHEN KOT -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'admin-kitchen'" class="flex-1 space-y-3">
            <div class="p-4 sm:p-6 rounded-lg border transition-all" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                <div class="flex items-center justify-between pb-3 border-b" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>ðŸ‘¨â€ðŸ³</span>
                        <span x-text="lang === 'bn' ? 'à¦²à¦¾à¦‡à¦­ à¦•à¦¿à¦šà§‡à¦¨ KOT' : 'Live Kitchen KDS'"></span>
                    </h3>
                    <button @click="simulateNewKitchenOrder()" class="px-3 py-1.5 rounded-xl bg-brand-500 text-slate-950 text-xs font-bold cursor-pointer" x-text="lang === 'bn' ? '+ à¦Ÿà§‡à¦¸à§à¦Ÿ à¦…à¦°à§à¦¡à¦¾à¦°' : '+ Test Order'"></button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 pt-3">
                    <div class="p-3 rounded-lg border flex flex-col min-h-[300px]" :class="isDark ? 'bg-obsidian-950/80 border-amber-500/30' : 'bg-slate-50 border-slate-200'">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-amber-500/20">
                            <span class="font-bold text-xs text-amber-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                                <span x-text="lang === 'bn' ? 'à¦¨à¦¤à§à¦¨ à¦…à¦°à§à¦¡à¦¾à¦° (Pending)' : 'New Orders (Pending)'"></span>
                            </span>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-mono font-bold bg-amber-500/20 text-amber-400" x-text="kitchenOrders.filter(k => k.status === 'pending').length"></span>
                        </div>
                        <div class="space-y-2.5 flex-1 overflow-y-auto hide-scrollbar">
                            <template x-for="kot in kitchenOrders.filter(k => k.status === 'pending')" :key="kot.id">
                                <div class="p-3 rounded-xl border space-y-2" :class="isDark ? 'bg-obsidian-900 border-amber-500/40 shadow-neon-amber' : 'bg-white border-amber-300'">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="font-mono font-bold text-white" x-text="kot.orderId"></span>
                                        <span class="text-[10px] text-zinc-400" x-text="kot.time"></span>
                                    </div>
                                    <div class="text-[11px] font-bold text-brand-400" x-text="kot.type + ' â€¢ ' + kot.customerRef"></div>
                                    <div class="py-1 border-t border-b border-dashed border-zinc-700 text-xs space-y-1">
                                        <template x-for="it in kot.items" :key="it.name">
                                            <div class="flex justify-between font-mono"><span class="text-zinc-200 truncate pr-2" x-text="it.name"></span><span class="font-bold text-amber-400" x-text="'x' + it.quantity"></span></div>
                                        </template>
                                    </div>
                                    <button @click="updateKitchenStatus(kot.id, 'cooking')" class="w-full py-1.5 rounded-lg bg-amber-500 text-slate-950 font-bold text-xs cursor-pointer" x-text="lang === 'bn' ? 'ðŸ‘¨â€ðŸ³ à¦°à¦¾à¦¨à§à¦¨à¦¾ à¦¶à§à¦°à§ (Cook)' : 'ðŸ‘¨â€ðŸ³ Start Cooking'"></button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="p-3 rounded-lg border flex flex-col min-h-[300px]" :class="isDark ? 'bg-obsidian-950/80 border-blue-500/30' : 'bg-slate-50 border-slate-200'">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-blue-500/20">
                            <span class="font-bold text-xs text-blue-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                <span x-text="lang === 'bn' ? 'à¦°à¦¾à¦¨à§à¦¨à¦¾ à¦šà¦²à¦›à§‡ (Cooking)' : 'In Cooking'"></span>
                            </span>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-mono font-bold bg-blue-500/20 text-blue-400" x-text="kitchenOrders.filter(k => k.status === 'cooking').length"></span>
                        </div>
                        <div class="space-y-2.5 flex-1 overflow-y-auto hide-scrollbar">
                            <template x-for="kot in kitchenOrders.filter(k => k.status === 'cooking')" :key="kot.id">
                                <div class="p-3 rounded-xl border space-y-2" :class="isDark ? 'bg-obsidian-900 border-blue-500/40' : 'bg-white border-blue-300'">
                                    <div class="flex items-center justify-between text-xs"><span class="font-mono font-bold text-white" x-text="kot.orderId"></span><span class="px-1.5 py-0.2 rounded bg-blue-500/20 text-blue-300 font-mono text-[9px] font-bold">COOKING</span></div>
                                    <button @click="updateKitchenStatus(kot.id, 'ready')" class="w-full py-1.5 rounded-lg bg-brand-500 text-slate-950 font-bold text-xs cursor-pointer" x-text="lang === 'bn' ? 'ðŸ”” à¦°à§‡à¦¡à¦¿ (Ready)' : 'ðŸ”” Mark Ready'"></button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="p-3 rounded-lg border flex flex-col min-h-[300px]" :class="isDark ? 'bg-obsidian-950/80 border-brand-500/30' : 'bg-slate-50 border-slate-200'">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-brand-500/20">
                            <span class="font-bold text-xs text-brand-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                                <span x-text="lang === 'bn' ? 'à¦°à§‡à¦¡à¦¿ (Ready)' : 'Ready for Pickup'"></span>
                            </span>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-mono font-bold bg-brand-500/20 text-brand-400" x-text="kitchenOrders.filter(k => k.status === 'ready').length"></span>
                        </div>
                        <div class="space-y-2.5 flex-1 overflow-y-auto hide-scrollbar">
                            <template x-for="kot in kitchenOrders.filter(k => k.status === 'ready')" :key="kot.id">
                                <div class="p-3 rounded-xl border space-y-2" :class="isDark ? 'bg-obsidian-900 border-brand-500/40 shadow-neon-brand' : 'bg-white border-brand-400'">
                                    <div class="flex items-center justify-between text-xs"><span class="font-mono font-bold text-white" x-text="kot.orderId"></span><span class="px-1.5 py-0.2 rounded bg-brand-500/20 text-brand-300 font-mono text-[9px] font-bold">READY</span></div>
                                    <button @click="updateKitchenStatus(kot.id, 'served')" class="w-full py-1.5 rounded-lg bg-zinc-800 text-zinc-300 font-bold text-xs cursor-pointer" x-text="lang === 'bn' ? 'âœ“ à¦¡à§‡à¦²à¦¿à¦­à¦¾à¦°à¦¿ à¦¸à¦®à§à¦ªà¦¨à§à¦¨ (Served)' : 'âœ“ Served & Done'"></button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- ================================================================= -->
        <!-- TAB 5: SALES LEDGER (Visible ONLY after Admin Login) -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'ledger'" class="flex-1 space-y-4">
            
            <!-- IF NOT LOGGED IN: SHOW AUTH GATE -->
            <template x-if="!isAdminLoggedIn">
                <div class="p-8 sm:p-12 rounded-xl border text-center max-w-lg mx-auto space-y-4 shadow-xl"
                     :class="isDark ? 'glass-panel-dark border-amber-500/30' : 'bg-white border-slate-200'">
                    <div class="w-16 h-16 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/40 flex items-center justify-center text-3xl mx-auto shadow-neon-amber">
                        ðŸ”’
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¹à¦¿à¦¸à¦¾à¦¬ à¦¦à§‡à¦–à¦¤à§‡ à¦²à¦—à¦‡à¦¨ à¦•à¦°à§à¦¨' : 'Sales Ledger Protected'"></h3>
                    <p class="text-xs text-slate-400 leading-relaxed" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿, à¦•à§à¦¯à¦¾à¦¶, à¦¬à¦¿à¦•à¦¾à¦¶ à¦“ à¦¨à¦—à¦¦à§‡à¦° à¦ªà§ƒà¦¥à¦• à¦¹à¦¿à¦¸à¦¾à¦¬ à¦à¦¬à¦‚ à¦®à§‡à¦®à§‹ à¦°à§‡à¦•à¦°à§à¦¡ à¦¶à§à¦§à§à¦®à¦¾à¦¤à§à¦° à¦²à¦—à¦‡à¦¨ à¦•à¦°à¦¾ à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦¦à§‡à¦–à¦¤à§‡ à¦ªà¦¾à¦°à§‡à¦¨à¥¤' : 'Only authenticated admins can view sales records, cash and mobile banking ledger.'"></p>
                    <button @click="activeTab = 'login'" 
                            class="px-6 py-3 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/25 active:scale-95 transition-all cursor-pointer inline-flex items-center gap-2">
                        <span>ðŸ”</span>
                        <span x-text="lang === 'bn' ? 'à¦²à¦—à¦‡à¦¨ à¦•à¦°à¦¤à§‡ à¦à¦–à¦¾à¦¨à§‡ à¦•à§à¦²à¦¿à¦• à¦•à¦°à§à¦¨' : 'Click to Log In'"></span>
                    </button>
                </div>
            </template>

            <!-- IF LOGGED IN: SHOW FULL SALES LEDGER -->
            <template x-if="isAdminLoggedIn">
                <div class="p-3 sm:p-6 rounded-xl border transition-all space-y-3 sm:space-y-4" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                    
                    <!-- Ledger Header & Controls -->
                    <div class="flex flex-wrap items-center justify-between gap-2.5">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <span>ðŸ§¾</span>
                                <span x-text="t('tabLedger')"></span>
                            </h3>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿ à¦“ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦šà§‡à¦° à¦¸à¦®à¦¨à§à¦¬à¦¿à¦¤ à¦¹à¦¿à¦¸à¦¾à¦¬, à¦•à§à¦¯à¦¾à¦¶-à¦¬à¦¿à¦•à¦¾à¦¶ à¦°à¦¿à¦ªà§‹à¦°à§à¦Ÿ à¦à¦¬à¦‚ à¦¨à¦¿à¦Ÿ à¦²à¦¾à¦­' : 'Integrated sales & raw item procurement ledger with net profit'"></p>
                        </div>

                        <div class="flex items-center flex-wrap gap-2 w-full sm:w-auto">
                            <!-- Quick Add Raw Item Cost Button -->
                            <button @click="openAddRawCostModal()" 
                                    class="px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 text-white font-bold text-xs shadow-md shadow-rose-500/25 flex items-center gap-1.5 cursor-pointer active:scale-95 transition-all">
                                <span>ðŸ¥©</span>
                                <span x-text="lang === 'bn' ? '+ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦¯à§‹à¦—' : '+ Add Raw Cost'"></span>
                            </button>

                            <button @click="exportToCSV()" class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer"
                                    :class="isDark ? 'bg-zinc-800 hover:bg-zinc-700 text-zinc-200 border-zinc-700' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 border-slate-200'">
                                <span>ðŸ“¥</span>
                                <span x-text="lang === 'bn' ? 'CSV à¦à¦•à§à¦¸à¦ªà§‹à¦°à§à¦Ÿ' : 'CSV Export'"></span>
                            </button>

                            <input type="text" x-model.debounce.120ms="ledgerSearch" :placeholder="t('searchLedgerPlaceholder')" 
                                   class="text-xs px-3 py-1.5 rounded-xl border focus:outline-none flex-1 sm:w-52 transition-all" 
                                   :class="isDark ? 'bg-obsidian-950 border-white/[0.08] text-white focus:border-brand-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:border-slate-400'">
                        </div>
                    </div>

                    <!-- Today's Financial & Sales KPI Banner: Sales + Raw Item Costs + Net Profit -->
                    <div :class="viewMode === 'mobile' ? 'grid grid-cols-2 gap-2 font-mono' : 'grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-2 sm:gap-3 font-mono'">
                        <!-- 1. Total Sales (Full width on mobile) -->
                        <div :class="viewMode === 'mobile' ? 'col-span-2 p-3' : 'col-span-2 sm:col-span-1 xl:col-span-1 p-3'"
                             class="rounded-lg border transition-all flex items-center justify-between"
                             :class="isDark ? 'bg-obsidian-950/80 border-brand-500/30' : 'bg-brand-50/70 border-brand-200'">
                            <div>
                                <span class="text-[10px] font-bold font-sans text-slate-400 dark:text-zinc-400 block" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Today Total Sales'"></span>
                                <div class="text-base sm:text-xl font-bold text-brand-500 dark:text-brand-400 mt-0.5" x-text="formatCurrency(todayStats.totalRevenue)"></div>
                            </div>
                            <span class="text-[10px] font-sans font-bold px-2 py-0.5 rounded-md bg-brand-500/15 text-brand-400 border border-brand-500/30 whitespace-nowrap flex-shrink-0" x-text="todayStats.totalOrders + (lang === 'bn' ? 'à¦Ÿà¦¿ à¦®à§‡à¦®à§‹' : ' orders')"></span>
                        </div>

                        <!-- 2. Raw Items Cost -->
                        <div :class="viewMode === 'mobile' ? 'col-span-1 p-2.5 sm:p-3' : 'col-span-1 xl:col-span-1 p-3'"
                             class="rounded-lg border transition-all relative group cursor-pointer"
                             @click="ledgerViewMode = 'raw_costs'; playChime(600)"
                             :class="isDark ? 'bg-obsidian-950/80 border-rose-500/30 hover:border-rose-500/60' : 'bg-rose-50/60 border-rose-200 hover:border-rose-300'">
                            <div class="flex items-center justify-between gap-1">
                                <span class="text-[10px] font-bold font-sans text-slate-400 dark:text-zinc-400 block truncate" x-text="lang === 'bn' ? 'ðŸ¥© à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š' : 'Raw Cost'"></span>
                                <button @click.stop="openAddRawCostModal()" title="à¦¨à¦¤à§à¦¨ à¦–à¦°à¦š à¦¯à§‹à¦— à¦•à¦°à§à¦¨" class="w-5 h-5 rounded-md bg-rose-500 text-white font-bold text-xs flex items-center justify-center cursor-pointer hover:scale-110 active:scale-95 transition-transform flex-shrink-0">+</button>
                            </div>
                            <div class="text-sm sm:text-base font-bold text-rose-500 dark:text-rose-400 mt-0.5 truncate" x-text="formatCurrency(todayStats.todayRawCost)"></div>
                            <span class="text-[9px] font-sans text-rose-400 font-semibold block truncate" x-text="(todayStats.todayRawCount || 0) + (lang === 'bn' ? 'à¦Ÿà¦¿ à¦†à¦‡à¦Ÿà§‡à¦®' : ' items bought')"></span>
                        </div>

                        <!-- 3. Net Operating Profit -->
                        <div :class="viewMode === 'mobile' ? 'col-span-1 p-2.5 sm:p-3' : 'col-span-1 xl:col-span-1 p-3'"
                             class="rounded-lg border transition-all"
                             :class="isDark ? 'bg-obsidian-950/80 border-teal-500/30' : 'bg-teal-50/60 border-teal-200'">
                            <span class="text-[10px] font-bold font-sans text-slate-400 dark:text-zinc-400 block truncate" x-text="lang === 'bn' ? 'ðŸ“ˆ à¦¨à¦¿à¦Ÿ à¦²à¦¾à¦­' : 'Net Profit'"></span>
                            <div class="text-sm sm:text-base font-bold text-teal-400 mt-0.5 truncate" x-text="formatCurrency(todayStats.todayNetProfit)"></div>
                            <span class="text-[9px] font-sans text-teal-400 font-bold block truncate" x-text="todayStats.todayProfitPercent + '% ' + (lang === 'bn' ? 'à¦®à¦¾à¦°à§à¦œà¦¿à¦¨' : 'margin')"></span>
                        </div>

                        <!-- 4. Cash Drawer Balance (Net Cash) -->
                        <div :class="viewMode === 'mobile' ? 'col-span-2 sm:col-span-1 p-2.5 sm:p-3' : 'col-span-1 xl:col-span-1 p-3'"
                             class="rounded-lg border transition-all"
                             :class="isDark ? 'bg-obsidian-950/80 border-amber-500/30' : 'bg-white border-slate-200'">
                            <div :class="viewMode === 'mobile' ? 'flex items-center justify-between' : ''">
                                <div>
                                    <span class="text-[10px] font-bold font-sans text-slate-400 dark:text-zinc-400 block truncate" x-text="lang === 'bn' ? 'ðŸ’µ à¦•à§à¦¯à¦¾à¦¶ à¦¡à§à¦°à§Ÿà¦¾à¦° à¦¬à§à¦¯à¦¾à¦²à§‡à¦¨à§à¦¸' : 'Net Cash Drawer'"></span>
                                    <div class="text-sm sm:text-base font-bold text-amber-500 mt-0.5 truncate" x-text="formatCurrency(todayStats.todayCashInHand)"></div>
                                </div>
                                <span class="text-[9px] font-sans text-slate-400 block truncate" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿ - à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦²' : 'Sales - Raw cost'"></span>
                            </div>
                        </div>

                        <!-- 5. bKash Sales -->
                        <div :class="viewMode === 'mobile' ? 'col-span-1 p-2.5 sm:p-3' : 'col-span-1 xl:col-span-1 p-3'"
                             class="rounded-lg border transition-all"
                             :class="isDark ? 'bg-obsidian-950/80 border-pink-500/30' : 'bg-pink-50/50 border-pink-200'">
                            <span class="text-[10px] font-bold font-sans text-slate-400 dark:text-zinc-400 block truncate" x-text="lang === 'bn' ? 'ðŸŒ¸ à¦¬à¦¿à¦•à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'bKash Sales'"></span>
                            <div class="text-sm sm:text-base font-bold text-pink-500 dark:text-pink-400 mt-0.5 truncate" x-text="formatCurrency(todayStats.bkashTotal)"></div>
                            <span class="text-[9px] font-sans text-slate-400 block truncate" x-text="lang === 'bn' ? 'à¦¡à¦¿à¦œà¦¿à¦Ÿà¦¾à¦² à¦¬à§à¦¯à¦¾à¦²à§‡à¦¨à§à¦¸' : 'Digital balance'"></span>
                        </div>

                        <!-- 6. Nagad Sales -->
                        <div :class="viewMode === 'mobile' ? 'col-span-1 p-2.5 sm:p-3' : 'col-span-1 xl:col-span-1 p-3'"
                             class="rounded-lg border transition-all"
                             :class="isDark ? 'bg-obsidian-950/80 border-amber-500/30' : 'bg-amber-50/50 border-amber-200'">
                            <span class="text-[10px] font-bold font-sans text-slate-400 dark:text-zinc-400 block truncate" x-text="lang === 'bn' ? 'ðŸŠ à¦¨à¦—à¦¦ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Nagad Sales'"></span>
                            <div class="text-sm sm:text-base font-bold text-amber-500 dark:text-amber-400 mt-0.5 truncate" x-text="formatCurrency(todayStats.nagadTotal)"></div>
                            <span class="text-[9px] font-sans text-slate-400 block truncate" x-text="lang === 'bn' ? 'à¦¡à¦¿à¦œà¦¿à¦Ÿà¦¾à¦² à¦¬à§à¦¯à¦¾à¦²à§‡à¦¨à§à¦¸' : 'Digital balance'"></span>
                        </div>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- VISUAL ANALYTICS: 1) PIE CHART OF SELLS OF ITEM + 2) SALES GROWTH GRAPH -->
                    <!-- ========================================================================= -->
                    <div :class="viewMode === 'mobile' ? 'grid grid-cols-1 gap-3.5 font-sans' : 'grid grid-cols-1 lg:grid-cols-12 gap-3 sm:gap-4 font-sans'">
                        
                        <!-- 1. PIE CHART: ITEM-WISE SALES PERCENTAGE -->
                        <div :class="viewMode === 'mobile' ? 'w-full' : 'lg:col-span-6'"
                             class="p-4 sm:p-5 rounded-xl border transition-all flex flex-col justify-between space-y-3.5 shadow-md"
                             :class="isDark ? 'glass-panel-dark border-brand-500/20' : 'bg-white border-slate-200'">
                            
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-xl flex-shrink-0">ðŸ¥§</span>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦° à¦¬à¦¿à¦•à§à¦°à¦¿à¦° à¦ªà¦¾à¦‡ à¦šà¦¾à¦°à§à¦Ÿ (Sales Pie Chart)' : 'Item Sales Pie Chart'"></h4>
                                        <p class="text-[10px] text-slate-500 dark:text-zinc-400 truncate" x-text="lang === 'bn' ? 'à¦•à§‹à¦¨ à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦•à¦¤ à¦¶à¦¤à¦¾à¦‚à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¹à¦²à§‹' : 'Distribution of items sold'"></p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-brand-500/20 text-brand-400 border border-brand-500/30 whitespace-nowrap flex-shrink-0"
                                      x-text="dailySoldItemsData.items.length + (lang === 'bn' ? ' à¦ªà¦¦à§‡à¦° à¦–à¦¾à¦¬à¦¾à¦°' : ' items')"></span>
                            </div>

                            <!-- Big Center Donut / Pie Chart (Directly in Center) -->
                            <div class="flex flex-col items-center justify-center py-2 w-full">
                                <div class="relative w-56 h-56 sm:w-64 sm:h-64 flex-shrink-0 flex items-center justify-center">
                                    <!-- Outer Glowing Colored Donut Ring -->
                                    <div class="w-56 h-56 sm:w-64 sm:h-64 rounded-full flex items-center justify-center p-5 sm:p-6 transition-all duration-700 relative shadow-2xl group"
                                         :style="'background: ' + dailySoldItemsData.conicGradient + '; box-shadow: 0 0 35px rgba(16, 185, 129, 0.28);'">
                                        
                                        <!-- Subtle Inner Border Highlight -->
                                        <div class="absolute inset-0 rounded-full border border-white/20 pointer-events-none"></div>

                                        <!-- Center Donut Core -->
                                        <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-full flex flex-col items-center justify-center text-center shadow-inner z-10 transition-colors border"
                                             :class="isDark ? 'bg-obsidian-950 text-white border-white/[0.08]' : 'bg-white text-slate-900 border-slate-200'">
                                            <span class="text-[10px] sm:text-[11px] text-slate-400 font-sans font-semibold leading-tight" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Total Sales'"></span>
                                            <span class="text-xl sm:text-2xl font-bold font-mono text-brand-400 my-0.5" x-text="dailySoldItemsData.totalQuantity + 'à¦Ÿà¦¿'"></span>
                                            <span class="text-xs sm:text-sm font-mono font-bold text-slate-300 dark:text-zinc-200" x-text="'à§³' + Number(dailySoldItemsData.totalRevenue).toLocaleString()"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Food Items Listed UNDER The Pie Chart -->
                            <div class="w-full pt-1 space-y-2">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 px-1 border-b border-white/[0.06] pb-1">
                                    <span x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¤à¦¾à¦²à¦¿à¦•à¦¾ à¦“ à¦¬à¦¿à¦•à§à¦°à¦¿à¦° à¦…à¦¨à§à¦ªà¦¾à¦¤' : 'Food Item Sales Breakdown'"></span>
                                    <span x-text="dailySoldItemsData.items.length + (lang === 'bn' ? 'à¦Ÿà¦¿ à¦†à¦‡à¦Ÿà§‡à¦®' : ' items')"></span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    <template x-for="item in dailySoldItemsData.items" :key="item.nameBn">
                                        <div class="flex items-center justify-between p-2.5 rounded-lg transition-all border group hover:scale-[1.01]"
                                             :class="isDark ? 'bg-obsidian-950/70 border-white/[0.06] hover:border-white/20' : 'bg-slate-50 border-slate-200/80 hover:border-slate-300'">
                                            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                                <span class="w-3.5 h-3.5 rounded-full flex-shrink-0 transition-transform group-hover:scale-110" :style="'background-color: ' + item.color + '; box-shadow: 0 0 10px ' + item.color"></span>
                                                <div class="min-w-0 truncate flex-1">
                                                    <span class="font-bold text-xs truncate block text-slate-800 dark:text-zinc-100" x-text="lang === 'bn' ? item.nameBn : item.nameEn"></span>
                                                    <div class="flex items-center gap-2 text-[10px] font-mono text-slate-400">
                                                        <span x-text="'à§³' + Number(item.revenue).toLocaleString()"></span>
                                                        <span>â€¢</span>
                                                        <span class="text-brand-400 font-bold" x-text="item.quantity + 'à¦Ÿà¦¿ à¦¬à¦¿à¦•à§à¦°à¦¿'"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-1.5 font-mono flex-shrink-0 ml-2">
                                                <span class="text-xs font-bold px-2 py-0.5 rounded-lg transition-colors"
                                                      :style="'background-color: ' + item.color + '22; color: ' + item.color + '; border: 1px solid ' + item.color + '55;'"
                                                      x-text="item.percent + '%'"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- 2. SALES GROWTH GRAPH: REAL-TIME REVENUE MOMENTUM -->
                        <div :class="viewMode === 'mobile' ? 'w-full' : 'lg:col-span-6'"
                             class="p-4 sm:p-5 rounded-xl border transition-all flex flex-col justify-between space-y-3.5 shadow-md"
                             :class="isDark ? 'glass-panel-dark border-cyan-500/20' : 'bg-white border-slate-200'">
                            
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-xl flex-shrink-0">ðŸ“ˆ</span>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿à¦° à¦—à§à¦°à§‹à¦¥ à¦“ à¦ªà§à¦°à¦¬à§ƒà¦¦à§à¦§à¦¿à¦° à¦—à§à¦°à¦¾à¦« (Sales Growth Graph)' : 'Sales Growth Momentum'"></h4>
                                        <p class="text-[10px] text-slate-500 dark:text-zinc-400 truncate" x-text="lang === 'bn' ? 'à¦¸à¦¾à¦°à¦¾à¦¦à¦¿à¦¨à§‡ à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¬à§ƒà¦¦à§à¦§à¦¿à¦° à¦—à¦¤à¦¿ à¦“ à¦®à§‹à¦Ÿ à¦ªà§à¦°à¦¬à§ƒà¦¦à§à¦§à¦¿' : 'Live cumulative revenue curve'"></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5 font-mono flex-shrink-0">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand-500/20 text-brand-400 border border-brand-500/30 flex items-center gap-0.5 whitespace-nowrap">
                                        <span>â–²</span>
                                        <span x-text="lang === 'bn' ? 'à¦—à§à¦°à§‹à¦¥ à¦¸à¦•à§à¦°à¦¿à§Ÿ' : 'Growth Active'"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Growth Key Highlights -->
                            <div class="grid grid-cols-3 gap-1.5 sm:gap-2 p-2.5 rounded-lg border font-mono text-center text-xs"
                                 :class="isDark ? 'bg-obsidian-950/70 border-white/[0.04]' : 'bg-slate-50 border-slate-200/60'">
                                <div class="min-w-0">
                                    <span class="text-[9px] text-slate-400 font-sans block truncate" x-text="lang === 'bn' ? 'à¦¸à¦°à§à¦¬à§‹à¦šà§à¦š à¦—à¦¤à¦¿' : 'Peak Velocity'"></span>
                                    <span class="font-bold text-brand-400 text-[11px] sm:text-sm truncate block" x-text="'à§³' + Number(salesGrowthChartData.peakVal || todayStats.totalRevenue).toLocaleString()"></span>
                                </div>
                                <div class="min-w-0 border-x border-white/[0.06] px-1">
                                    <span class="text-[9px] text-slate-400 font-sans block truncate" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Total Orders'"></span>
                                    <span class="font-bold text-amber-400 text-[11px] sm:text-sm truncate block" x-text="todayStats.totalOrders + ' à¦Ÿà¦¿'"></span>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-[9px] text-slate-400 font-sans block truncate" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ' : 'Today Total'"></span>
                                    <span class="font-bold text-cyan-400 text-[11px] sm:text-sm truncate block" x-text="'à§³' + Number(todayStats.totalRevenue).toLocaleString()"></span>
                                </div>
                            </div>

                            <!-- SVG Curved Line & Gradient Area Graph -->
                            <div class="pt-1 w-full max-w-full overflow-hidden">
                                <svg viewBox="-10 0 620 180" class="w-full h-32 sm:h-40 block">
                                    <defs>
                                        <linearGradient id="growthAreaGrad" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#06b6d4" stop-opacity="0.45"/>
                                            <stop offset="60%" stop-color="#10b981" stop-opacity="0.15"/>
                                            <stop offset="100%" stop-color="#10b981" stop-opacity="0.0"/>
                                        </linearGradient>
                                    </defs>
                                    
                                    <!-- Background grid lines -->
                                    <line x1="30" y1="40" x2="570" y2="40" stroke="currentColor" class="text-zinc-800/40" stroke-dasharray="3 3"/>
                                    <line x1="30" y1="90" x2="570" y2="90" stroke="currentColor" class="text-zinc-800/40" stroke-dasharray="3 3"/>
                                    <line x1="30" y1="140" x2="570" y2="140" stroke="currentColor" class="text-zinc-800/40" stroke-dasharray="3 3"/>

                                    <!-- Area Fill -->
                                    <path :d="salesGrowthChartData.areaPath" fill="url(#growthAreaGrad)"/>
                                    
                                    <!-- Glowing Main Curve -->
                                    <path :d="salesGrowthChartData.linePath" fill="none" stroke="#06b6d4" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    
                                    <!-- Data Nodes -->
                                    <template x-for="(node, i) in salesGrowthChartData.points" :key="i">
                                        <g class="group cursor-pointer">
                                            <circle :cx="node.x" :cy="node.y" r="5" class="fill-slate-950 stroke-cyan-400 stroke-[2.5] hover:scale-125 transition-transform"/>
                                            <text :x="node.x" :y="node.y - 10" text-anchor="middle" class="text-[9px] font-mono fill-slate-300 font-bold opacity-0 group-hover:opacity-100 transition-opacity" x-text="'à§³' + node.val.toLocaleString()"></text>
                                            <text :x="node.x" y="172" text-anchor="middle" class="text-[9px] font-mono fill-slate-400" x-text="node.label"></text>
                                        </g>
                                    </template>
                                </svg>
                            </div>
                        </div>

                    </div>

                <!-- Ledger Sub-View Switcher: Memos vs Item-wise Breakdown vs Raw Items Cost Menu vs P&L -->
                <div class="flex items-center p-1 rounded-lg border text-xs font-bold w-full sm:w-auto overflow-x-auto hide-scrollbar"
                     :class="isDark ? 'bg-obsidian-950 border-white/[0.08]' : 'bg-slate-100 border-slate-200'">
                    <button @click="ledgerViewMode = 'memos'; playChime(500)" 
                            :class="ledgerViewMode === 'memos' ? (isDark ? 'bg-brand-500 text-slate-950 shadow-xs' : 'bg-brand-600 text-white shadow-xs') : 'text-slate-400 hover:text-white'"
                            class="px-3.5 py-2 rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                        <span>ðŸ§¾</span>
                        <span x-text="lang === 'bn' ? 'à¦®à§‡à¦®à§‹ à¦°à§‡à¦•à¦°à§à¦¡ (' + todayStats.totalOrders + ')' : 'Order Memos (' + todayStats.totalOrders + ')'"></span>
                    </button>
                    <button @click="ledgerViewMode = 'items'; playChime(550)" 
                            :class="ledgerViewMode === 'items' ? (isDark ? 'bg-amber-400 text-slate-950 shadow-xs' : 'bg-amber-500 text-slate-950 shadow-xs') : 'text-slate-400 hover:text-white'"
                            class="px-3.5 py-2 rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                        <span>ðŸ“Š</span>
                        <span x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦° à¦¬à¦¿à¦•à§à¦°à¦¿ (' + todayStats.totalItemsSold + 'à¦Ÿà¦¿)' : 'Sold Items (' + todayStats.totalItemsSold + ')'"></span>
                    </button>
                    <button @click="ledgerViewMode = 'raw_costs'; playChime(600)" 
                            :class="ledgerViewMode === 'raw_costs' ? (isDark ? 'bg-rose-500 text-white shadow-xs' : 'bg-rose-600 text-white shadow-xs') : 'text-slate-400 hover:text-white'"
                            class="px-3.5 py-2 rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                        <span>ðŸ¥©</span>
                        <span x-text="lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦“ à¦¬à¦¾à¦œà¦¾à¦° à¦–à¦°à¦š (' + formatCurrency(todayStats.todayRawCost) + ')' : 'Raw Items Cost (' + formatCurrency(todayStats.todayRawCost) + ')'"></span>
                    </button>
                    <button @click="ledgerViewMode = 'profit_loss'; playChime(650)" 
                            :class="ledgerViewMode === 'profit_loss' ? (isDark ? 'bg-teal-400 text-slate-950 shadow-xs' : 'bg-teal-600 text-white shadow-xs') : 'text-slate-400 hover:text-white'"
                            class="px-3.5 py-2 rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                        <span>âš–ï¸</span>
                        <span x-text="lang === 'bn' ? 'à¦²à¦¾à¦­-à¦•à§à¦·à¦¤à¦¿ à¦–à¦¤à¦¿à§Ÿà¦¾à¦¨' : 'Profit & Loss'"></span>
                    </button>
                </div>

                <!-- SUB-VIEW 1: ORDER MEMOS & RECEIPTS -->
                <div x-show="ledgerViewMode === 'memos'" class="space-y-3 sm:space-y-4">

                <!-- Ledger Quick Filter Chips -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 hide-scrollbar">
                    <button @click="ledgerFilter = 'today'; playChime(500)" 
                            :class="ledgerFilter === 'today' ? 'bg-brand-500 text-slate-950 font-bold shadow-xs' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                        <span>ðŸ“…</span>
                        <span x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à¦¿ (' + todayStats.totalOrders + ')' : 'Today'"></span>
                    </button>

                    <button @click="ledgerFilter = 'all'; playChime(500)" 
                            :class="ledgerFilter === 'all' ? 'bg-brand-500 text-slate-950 font-bold shadow-xs' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                        <span>ðŸ“‹</span>
                        <span x-text="lang === 'bn' ? 'à¦¸à¦¬ à¦°à§‡à¦•à¦°à§à¦¡ (' + salesHistory.length + ')' : 'All Records'"></span>
                    </button>

                    <button @click="ledgerFilter = 'cash'; playChime(500)" 
                            :class="ledgerFilter === 'cash' ? 'bg-brand-500 text-slate-950 font-bold shadow-xs' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                        <span>ðŸ’µ</span>
                        <span x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦¶' : 'Cash'"></span>
                    </button>

                    <button @click="ledgerFilter = 'bkash'; playChime(500)" 
                            :class="ledgerFilter === 'bkash' ? 'bg-[#E2136E] text-white font-bold shadow-xs' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                        <span>ðŸŒ¸</span>
                        <span>bKash</span>
                    </button>

                    <button @click="ledgerFilter = 'nagad'; playChime(500)" 
                            :class="ledgerFilter === 'nagad' ? 'bg-[#F7941D] text-white font-bold shadow-xs' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                        <span>âš¡</span>
                        <span>Nagad</span>
                    </button>
                </div>

                <!-- VIEW 1: MOBILE CARD VIEW (Phone Screen Optimized) -->
                <div :class="viewMode === 'mobile' ? 'block space-y-2.5' : 'block sm:hidden space-y-2.5'">
                    <template x-if="filteredSalesHistory.length === 0">
                        <div class="p-6 text-center text-slate-400 text-xs">
                            <p x-text="lang === 'bn' ? 'à¦•à§‹à¦¨ à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦°à§‡à¦•à¦°à§à¦¡ à¦ªà¦¾à¦“à§Ÿà¦¾ à¦¯à¦¾à§Ÿà¦¨à¦¿' : 'No sales records found'"></p>
                        </div>
                    </template>

                    <template x-for="order in filteredSalesHistory" :key="order.id">
                        <div class="p-3 rounded-lg border transition-all space-y-2 shadow-xs"
                             :class="isDark ? 'bg-obsidian-950/90 border-white/[0.08]' : 'bg-white border-slate-200'">
                            
                            <!-- Card Header: Memo ID, Time, Type -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                                    <span class="font-mono font-bold text-xs text-slate-900 dark:text-white" x-text="order.orderId"></span>
                                    <template x-if="currentUserRole === 'superadmin' && (adminViewingOwnerId === 'all' || !adminViewingOwnerId)">
                                        <span class="text-[9px] px-1.5 py-0.2 rounded font-sans font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30" x-text="order.foodCourtName || 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ'"></span>
                                    </template>
                                    <span class="text-[10px] px-1.5 py-0.2 rounded font-medium"
                                          :class="isDark ? 'bg-zinc-800 text-zinc-300' : 'bg-slate-100 text-slate-600'"
                                          x-text="order.type || 'Takeaway'"></span>
                                </div>
                                <span class="text-[10px] font-mono text-slate-400" x-text="order.timestamp"></span>
                            </div>

                            <!-- Customer & Items Summary -->
                            <div class="text-xs space-y-0.5">
                                <div class="font-bold text-slate-900 dark:text-zinc-200 flex items-center gap-1">
                                    <span class="text-slate-400 text-[10px]">ðŸ‘¤</span>
                                    <span x-text="order.customerRef"></span>
                                </div>
                                <p class="text-[11px] text-slate-600 dark:text-zinc-400 line-clamp-2" x-text="order.itemsSummary"></p>
                            </div>

                            <!-- Bottom Row: Payment badge, Total amount, Actions -->
                            <div class="pt-2 border-t flex items-center justify-between gap-2"
                                 :class="isDark ? 'border-white/[0.06]' : 'border-slate-100'">
                                
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold" 
                                          :class="order.paymentMethod === 'bKash' ? 'bg-pink-500/20 text-pink-300 border border-pink-500/30' : (order.paymentMethod === 'Nagad' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : (order.paymentMethod === 'Card' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'bg-brand-500/20 text-brand-400 border border-brand-500/30'))" 
                                          x-text="order.paymentMethod">
                                    </span>
                                    <span class="font-mono font-bold text-sm text-brand-500 dark:text-brand-400" x-text="formatCurrency(order.grandTotal)"></span>
                                </div>

                                <div class="flex items-center gap-1">
                                    <button @click="previewReceipt(order)" 
                                            title="à¦°à¦¸à¦¿à¦¦ à¦¦à§‡à¦–à§à¦¨"
                                            class="px-2 py-1 rounded-lg bg-brand-500/15 hover:bg-brand-500/30 text-brand-400 border border-brand-500/30 text-xs font-bold transition-colors flex items-center gap-0.5">
                                        <span>ðŸ–¨ï¸</span>
                                        <span x-text="lang === 'bn' ? 'à¦°à¦¸à¦¿à¦¦' : 'Receipt'"></span>
                                    </button>

                                    <button @click="copyDigitalReceipt(order)" 
                                            title="WhatsApp à¦®à§‡à¦®à§‹ à¦•à¦ªà¦¿"
                                            class="px-2 py-1 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 border border-zinc-700 text-xs font-bold transition-colors flex items-center gap-0.5">
                                        <span>ðŸ“‹</span>
                                    </button>

                                    <button @click="voidOrder(order.id)" 
                                            title="à¦®à§‡à¦®à§‹ à¦¬à¦¾à¦¤à¦¿à¦² à¦•à¦°à§à¦¨" 
                                            class="p-1 rounded-lg bg-rose-500/15 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 text-xs transition-colors">
                                        ðŸ—‘ï¸
                                    </button>
                                </div>

                            </div>
                        </div>
                    </template>
                </div>

                <!-- VIEW 2: DESKTOP TABLE VIEW (Tablets & Desktops) -->
                <div :class="viewMode === 'mobile' ? 'hidden' : 'hidden sm:block overflow-x-auto'">
                    <table class="w-full text-left text-xs">
                        <thead class="border-b font-bold" :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08] text-zinc-400' : 'bg-slate-50 border-slate-200 text-slate-500'">
                            <tr>
                                <th class="p-2.5" x-text="lang === 'bn' ? 'à¦®à§‡à¦®à§‹ à¦¨à¦‚' : 'Order ID'"></th>
                                <th class="p-2.5" x-text="lang === 'bn' ? 'à¦¸à¦®à§Ÿ à¦“ à¦—à§à¦°à¦¾à¦¹à¦•' : 'Time & Customer'"></th>
                                <th class="p-2.5" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦° à¦†à¦‡à¦Ÿà§‡à¦®' : 'Food Items'"></th>
                                <th class="p-2.5" x-text="lang === 'bn' ? 'à¦ªà§‡à¦®à§‡à¦¨à§à¦Ÿ' : 'Payment'"></th>
                                <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦¸à¦°à§à¦¬à¦®à§‹à¦Ÿ à¦¬à¦¿à¦²' : 'Total Amount'"></th>
                                <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦°à¦¶à¦¿à¦¦ à¦“ à¦…à§à¦¯à¦¾à¦•à¦¶à¦¨' : 'Receipt & Actions'"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" :class="isDark ? 'divide-white/[0.04]' : 'divide-slate-100'">
                            <template x-for="order in filteredSalesHistory" :key="order.id">
                                <tr class="transition-colors" :class="isDark ? 'hover:bg-white/[0.03]' : 'hover:bg-slate-50/70'">
                                    <td class="p-2.5 font-mono font-bold text-slate-900 dark:text-white flex items-center gap-1.5 flex-wrap">
                                        <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                                        <span x-text="order.orderId"></span>
                                        <template x-if="currentUserRole === 'superadmin' && (adminViewingOwnerId === 'all' || !adminViewingOwnerId)">
                                            <span class="text-[9px] px-1.5 py-0.2 rounded font-sans font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30" x-text="order.foodCourtName || 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ'"></span>
                                        </template>
                                    </td>
                                    <td class="p-2.5">
                                        <div class="font-medium text-slate-900 dark:text-zinc-200" x-text="order.customerRef"></div>
                                        <div class="text-[10px] text-slate-400 font-mono" x-text="order.timestamp"></div>
                                    </td>
                                    <td class="p-2.5 font-medium text-slate-800 dark:text-zinc-300 max-w-[180px] truncate" x-text="order.itemsSummary"></td>
                                    <td class="p-2.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold" 
                                              :class="order.paymentMethod === 'bKash' ? 'bg-pink-500/20 text-pink-300 border border-pink-500/30' : (order.paymentMethod === 'Nagad' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : (order.paymentMethod === 'Card' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'bg-zinc-800 text-zinc-300 border border-zinc-700'))" 
                                              x-text="order.paymentMethod">
                                        </span>
                                    </td>
                                    <td class="p-2.5 text-right font-mono font-bold text-brand-500 text-sm" x-text="formatCurrency(order.grandTotal)"></td>
                                    <td class="p-2.5 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- View / Print Receipt -->
                                            <button @click="previewReceipt(order)" 
                                                    :title="lang === 'bn' ? 'à¦°à¦¶à¦¿à¦¦ à¦¦à§‡à¦–à§à¦¨ à¦“ à¦ªà§à¦°à¦¿à¦¨à§à¦Ÿ à¦•à¦°à§à¦¨' : 'View & Print Receipt'" 
                                                    class="px-2.5 py-1 rounded-lg bg-brand-500/15 hover:bg-brand-500/30 text-brand-400 border border-brand-500/30 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                                <span>ðŸ–¨ï¸</span>
                                                <span x-text="lang === 'bn' ? 'à¦°à¦¶à¦¿à¦¦' : 'Receipt'"></span>
                                            </button>

                                            <!-- Digital Copy (WhatsApp) -->
                                            <button @click="copyDigitalReceipt(order)" 
                                                    :title="lang === 'bn' ? 'WhatsApp à¦®à§‡à¦®à§‹ à¦•à¦ªà¦¿' : 'Copy Digital Memo'" 
                                                    class="px-2.5 py-1 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 border border-zinc-700 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                                <span>ðŸ“‹</span>
                                            </button>

                                            <!-- Void Order -->
                                            <button @click="voidOrder(order.id)" 
                                                    :title="lang === 'bn' ? 'à¦®à§‡à¦®à§‹ à¦¬à¦¾à¦¤à¦¿à¦² à¦•à¦°à§à¦¨' : 'Void Memo'" 
                                                    class="p-1 rounded-lg bg-rose-500/15 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 text-xs transition-colors cursor-pointer">
                                                ðŸ—‘ï¸
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- VIEW 2: MOBILE CARDS VIEW (Full Mobile Responsiveness for Memos) -->
                <div x-show="filteredSalesHistory.length > 0" 
                     :class="viewMode === 'mobile' ? 'block space-y-2.5' : 'block sm:hidden space-y-2.5'">
                    <template x-for="order in filteredSalesHistory" :key="order.id || order.orderId">
                        <div class="p-3.5 rounded-lg border transition-all space-y-2.5 shadow-sm"
                             :class="isDark ? 'glass-panel-dark border-white/[0.08]' : 'bg-white border-slate-200 text-slate-900'">
                            
                            <!-- Header: Memo ID, Food Court Tag & Total -->
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="w-2 h-2 rounded-full bg-brand-400 flex-shrink-0"></span>
                                    <span class="font-mono font-bold text-xs text-slate-900 dark:text-white truncate" x-text="order.orderId"></span>
                                    <template x-if="order.foodCourtName">
                                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30 truncate" x-text="order.foodCourtName"></span>
                                    </template>
                                </div>
                                <span class="font-mono font-bold text-sm text-brand-500 flex-shrink-0" x-text="formatCurrency(order.grandTotal)"></span>
                            </div>

                            <!-- Customer & Items Summary -->
                            <div class="text-xs space-y-1">
                                <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-zinc-400 font-mono">
                                    <span x-text="order.customerRef || 'à¦•à¦¾à¦‰à¦¨à§à¦Ÿà¦¾à¦° à¦¸à§‡à¦²'"></span>
                                    <span x-text="order.timestamp"></span>
                                </div>
                                <p class="text-xs font-medium text-slate-800 dark:text-zinc-200 line-clamp-2" x-text="order.itemsSummary"></p>
                            </div>

                            <!-- Payment & Actions Footer -->
                            <div class="flex items-center justify-between pt-2 border-t text-xs" :class="isDark ? 'border-white/[0.06]' : 'border-slate-100'">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                      :class="order.paymentMethod === 'bKash' ? 'bg-pink-500/20 text-pink-400 border border-pink-500/30' : (order.paymentMethod === 'Nagad' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : (order.paymentMethod === 'Card' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 'bg-brand-500/15 text-brand-400 border border-brand-500/30'))"
                                      x-text="order.paymentMethod">
                                </span>

                                <div class="flex items-center gap-1.5">
                                    <button type="button" @click="previewReceipt(order)" 
                                            class="px-2.5 py-1 rounded-xl bg-brand-500/20 hover:bg-brand-500/30 text-brand-400 border border-brand-500/30 text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                                        <span>ðŸ–¨ï¸</span>
                                        <span x-text="lang === 'bn' ? 'à¦°à¦¸à¦¿à¦¦' : 'Receipt'"></span>
                                    </button>
                                    <button type="button" @click="copyDigitalReceipt(order)" 
                                            class="p-1.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 border border-zinc-700 text-xs transition-colors cursor-pointer" title="WhatsApp Copy">
                                        ðŸ“‹
                                    </button>
                                    <button type="button" @click="voidOrder(order.id)" 
                                            class="p-1.5 rounded-xl bg-rose-500/15 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 text-xs transition-colors cursor-pointer" title="à¦¬à¦¾à¦¤à¦¿à¦²">
                                        ðŸ—‘ï¸
                                    </button>
                                </div>
                            </div>

                        </div>
                    </template>
                </div>

                </div> <!-- END OF SUB-VIEW 1: ORDER MEMOS & RECEIPTS -->

                <!-- ================================================================= -->
                <!-- SUB-VIEW 2: ITEM-WISE SALES BREAKDOWN (à¦•à§‹à¦¨ à¦†à¦‡à¦Ÿà§‡à¦® à¦•à¦¤à¦Ÿà¦¿ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¹à¦²à§‹) -->
                <!-- ================================================================= -->
                <div x-show="ledgerViewMode === 'items'" class="space-y-3 sm:space-y-4">
                    
                    <!-- Summary Card Banner -->
                    <div class="p-3.5 rounded-lg border flex flex-wrap items-center justify-between gap-3 shadow-xs"
                         :class="isDark ? 'bg-obsidian-950/90 border-amber-500/40 text-zinc-100' : 'bg-amber-50/80 border-amber-300 text-slate-900'">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl">ðŸ²</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦†à¦‡à¦Ÿà§‡à¦® à¦…à¦¨à§à¦¯à¦¾à§Ÿà§€ à¦¬à¦¿à¦•à§à¦°à¦¿à¦° à¦¬à¦¿à¦¸à§à¦¤à¦¾à¦°à¦¿à¦¤ à¦¤à¦¾à¦²à¦¿à¦•à¦¾' : 'Item-wise Quantity Sold Summary'"></h4>
                                <p class="text-[10px] text-slate-500 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦•à§‹à¦¨ à¦–à¦¾à¦¬à¦¾à¦°à¦Ÿà¦¿ à¦•à¦¤ à¦ªà¦¿à¦¸/à¦ªà§à¦²à§‡à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¹à¦²à§‹ à¦à¦¬à¦‚ à¦®à§‹à¦Ÿ à¦†à§Ÿ à¦•à¦¤' : 'Real-time breakdown of sold quantities & revenue'"></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 font-mono">
                            <span class="px-2.5 py-1 rounded-xl text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30"
                                  x-text="todayItemSalesBreakdown.items.length + ' ' + (lang === 'bn' ? 'à¦ªà§à¦°à¦•à¦¾à¦° à¦–à¦¾à¦¬à¦¾à¦°' : 'items')"></span>
                            <span class="px-2.5 py-1 rounded-xl text-xs font-bold bg-brand-500 text-slate-950 shadow-xs"
                                  x-text="'à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿: ' + todayItemSalesBreakdown.totalQty + ' ' + (lang === 'bn' ? 'à¦Ÿà¦¿' : 'pcs')"></span>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <template x-if="todayItemSalesBreakdown.items.length === 0">
                        <div class="p-8 text-center text-slate-400 text-xs rounded-lg border border-dashed border-zinc-700">
                            <span class="text-3xl block mb-2">ðŸ½ï¸</span>
                            <p class="font-bold" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡ à¦à¦–à¦¨à§‹ à¦•à§‹à¦¨à§‹ à¦–à¦¾à¦¬à¦¾à¦° à¦¬à¦¾ à¦•à§à¦‡à¦• à¦¸à§‡à¦² à¦°à§‡à¦•à¦°à§à¦¡ à¦•à¦°à¦¾ à¦¹à§Ÿà¦¨à¦¿' : 'No items sold today yet'"></p>
                            <p class="text-[10px] mt-1 text-slate-500" x-text="lang === 'bn' ? 'POS à¦®à§‡à¦¨à§ à¦¬à¦¾ à¦•à§à¦‡à¦• à¦¸à§‡à¦² à¦¦à¦¿à§Ÿà§‡ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡ à¦•à¦°à¦²à§‡à¦‡ à¦¸à§à¦¬à§Ÿà¦‚à¦•à§à¦°à¦¿à§Ÿà¦­à¦¾à¦¬à§‡ à¦à¦–à¦¾à¦¨à§‡ à¦¤à¦¾à¦²à¦¿à¦•à¦¾ à¦¤à§ˆà¦°à¦¿ à¦¹à¦¬à§‡à¥¤' : 'Record a sale to see live item-wise summary here.'"></p>
                        </div>
                    </template>

                    <!-- Items List (Mobile-Optimized Cards & Progressive Bars) -->
                    <div class="space-y-2">
                        <template x-for="(item, index) in todayItemSalesBreakdown.items" :key="item.name">
                            <div class="p-3 rounded-lg border transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 shadow-xs"
                                 :class="isDark ? 'bg-obsidian-950/90 border-white/[0.08] hover:border-brand-500/40' : 'bg-white border-slate-200 hover:border-slate-300'">
                                
                                <!-- Left: Serial, Food Name, Tag & Progress Bar -->
                                <div class="flex items-center gap-2.5 flex-1 min-w-0">
                                    <span class="w-6 h-6 rounded-lg bg-zinc-800 text-slate-300 font-mono font-bold text-xs flex items-center justify-center flex-shrink-0" x-text="'#' + (index + 1)"></span>
                                    
                                    <div class="min-w-0 flex-1 space-y-1">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <h5 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate" x-text="item.name"></h5>
                                            <span class="text-[9px] px-1.5 py-0.2 rounded font-mono font-bold"
                                                  :class="item.isQuickSale ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-brand-500/20 text-brand-400 border border-brand-500/30'"
                                                  x-text="item.isQuickSale ? 'âš¡ à¦•à§à¦‡à¦• à¦à¦¨à§à¦Ÿà§à¦°à¦¿' : 'ðŸ½ï¸ à¦®à§‡à¦¨à§ à¦†à¦‡à¦Ÿà§‡à¦®'"></span>
                                        </div>
                                        
                                        <!-- Share of Day Sales Progress Bar -->
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-gradient-to-r from-brand-500 to-teal-400 h-1.5 rounded-full transition-all duration-500"
                                                     :style="'width: ' + (todayItemSalesBreakdown.totalQty > 0 ? ((item.quantity / todayItemSalesBreakdown.totalQty) * 100) : 0) + '%'"></div>
                                            </div>
                                            <span class="text-[9px] font-mono text-slate-400 flex-shrink-0"
                                                  x-text="(todayItemSalesBreakdown.totalQty > 0 ? Math.round((item.quantity / todayItemSalesBreakdown.totalQty) * 100) : 0) + '% ' + (lang === 'bn' ? 'à¦…à¦‚à¦¶' : 'share')"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right: Large Bold Sold Count & Revenue -->
                                <div class="flex items-center justify-between sm:justify-end gap-3 pt-2 sm:pt-0 border-t sm:border-t-0 border-white/[0.04] sm:border-transparent flex-shrink-0 font-mono">
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-[10px] font-sans text-slate-400 font-bold" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿:' : 'Sold:'"></span>
                                        <span class="text-base sm:text-lg font-bold text-amber-500 dark:text-amber-400" x-text="item.quantity"></span>
                                        <span class="text-xs font-bold text-amber-500 dark:text-amber-400" x-text="lang === 'bn' ? 'à¦Ÿà¦¿' : 'pcs'"></span>
                                    </div>
                                    
                                    <div class="text-right">
                                        <span class="text-xs sm:text-sm font-bold text-brand-500 dark:text-brand-400" x-text="formatCurrency(item.revenue)"></span>
                                    </div>
                                </div>

                            </div>
                        </template>
                    </div>

                </div>

                <!-- ================================================================= -->
                <!-- SUB-VIEW 3: RAW ITEMS COST MENU (à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦“ à¦¬à¦¾à¦œà¦¾à¦° à¦–à¦°à¦šà§‡à¦° à¦¹à¦¿à¦¸à¦¾à¦¬) -->
                <!-- ================================================================= -->
                <div x-show="ledgerViewMode === 'raw_costs'" class="space-y-3 sm:space-y-4">
                    
                    <!-- Raw Cost Header Banner -->
                    <div class="p-3.5 sm:p-4 rounded-lg border flex flex-wrap items-center justify-between gap-3 shadow-xs"
                         :class="isDark ? 'bg-obsidian-950/90 border-rose-500/40 text-zinc-100' : 'bg-rose-50/80 border-rose-300 text-slate-900'">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl">ðŸ¥©</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm flex items-center gap-2">
                                    <span x-text="lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦“ à¦¬à¦¾à¦œà¦¾à¦° à¦–à¦°à¦šà§‡à¦° à¦¹à¦¿à¦¸à¦¾à¦¬' : 'Raw Materials Procurement Menu'"></span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-500 text-white" x-text="todayStats.todayRawCount + (lang === 'bn' ? 'à¦Ÿà¦¿ à¦à¦¨à§à¦Ÿà§à¦°à¦¿' : ' entries')"></span>
                                </h4>
                                <p class="text-[10px] text-slate-500 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦ªà§à¦°à¦¤à¦¿à¦¦à¦¿à¦¨à§‡à¦° à¦šà¦¾à¦², à¦®à¦¾à¦‚à¦¸, à¦¤à§‡à¦², à¦®à¦¸à¦²à¦¾, à¦¸à¦¬à¦œà¦¿ à¦“ à¦—à§à¦¯à¦¾à¦¸ à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦° à¦•à§‡à¦¨à¦¾à¦° à¦¹à¦¿à¦¸à¦¾à¦¬ à¦à¦¬à¦‚ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦–à¦¾à¦¤à¦¾à¦° à¦¸à¦®à¦¨à§à¦¬à§Ÿ' : 'Daily procurement logs of meat, rice, spices, oil, gas and ingredient costs'"></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button @click="openAddRawCostModal()" 
                                    class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 text-white font-bold text-xs shadow-lg shadow-rose-500/30 flex items-center gap-1.5 cursor-pointer active:scale-95 transition-all">
                                <span>âž•</span>
                                <span x-text="lang === 'bn' ? 'à¦¨à¦¤à§à¦¨ à¦–à¦°à¦š à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'Add Raw Material'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- 1-Tap Quick Presets Bar: Frequent Restaurant Ingredients -->
                    <div class="p-2.5 rounded-lg border space-y-2"
                         :class="isDark ? 'bg-obsidian-950/60 border-white/[0.06]' : 'bg-white/80 border-slate-200'">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-bold text-slate-500 dark:text-zinc-400 flex items-center gap-1.5">
                                <span>âš¡</span>
                                <span x-text="lang === 'bn' ? 'à¦¦à§à¦°à§à¦¤ à¦–à¦°à¦šà§‡à¦° à¦ªà§à¦°à¦¿à¦¸à§‡à¦Ÿ (à§§-à¦Ÿà§à¦¯à¦¾à¦ªà§‡ à¦ªà§‚à¦°à¦£ à¦•à¦°à§à¦¨):' : 'Quick Presets (1-Tap Fill):'"></span>
                            </span>
                            <span class="text-[10px] text-slate-400" x-text="lang === 'bn' ? 'à¦Ÿà§à¦¯à¦¾à¦ª à¦•à¦°à§‡ à¦¸à¦°à¦¾à¦¸à¦°à¦¿ à¦ªà¦°à¦¿à¦®à¦¾à¦£ à¦“ à¦Ÿà¦¾à¦•à¦¾ à¦¬à¦¸à¦¾à¦¨' : 'Tap to autofill name & price'"></span>
                        </div>
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 hide-scrollbar">
                            <template x-for="preset in rawItemPresets" :key="preset.name">
                                <button @click="openAddRawCostModal(preset)" 
                                        class="px-2.5 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer active:scale-95"
                                        :class="isDark ? 'bg-zinc-900/80 hover:bg-zinc-800 text-zinc-200 border-zinc-700/70 hover:border-rose-500/50' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200'">
                                    <span x-text="preset.icon"></span>
                                    <span x-text="preset.name"></span>
                                    <span class="text-[10px] font-mono text-rose-500 font-bold" x-text="'à§³' + preset.defaultPrice + '/' + preset.unit"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Raw Cost KPI Cards Summary -->
                    <div :class="viewMode === 'mobile' ? 'grid grid-cols-2 gap-2 font-mono' : 'grid grid-cols-2 sm:grid-cols-4 gap-2 font-mono'">
                        <div class="p-2.5 sm:p-3 rounded-lg border" :class="isDark ? 'bg-obsidian-950/80 border-rose-500/30' : 'bg-rose-50/50 border-rose-200'">
                            <span class="text-[10px] font-sans font-bold text-slate-400 dark:text-zinc-400 block" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š' : 'Today Total Raw Cost'"></span>
                            <div class="text-sm sm:text-base font-bold text-rose-500 mt-0.5" x-text="formatCurrency(todayStats.todayRawCost)"></div>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-lg border" :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-white border-slate-200'">
                            <span class="text-[10px] font-sans font-bold text-slate-400 dark:text-zinc-400 block" x-text="lang === 'bn' ? 'ðŸ’µ à¦•à§à¦¯à¦¾à¦¶à§‡ à¦ªà¦°à¦¿à¦¶à§‹à¦§à¦¿à¦¤' : 'Cash Paid'"></span>
                            <div class="text-sm sm:text-base font-bold text-brand-500 mt-0.5" x-text="formatCurrency(todayStats.todayRawCashCost)"></div>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-lg border" :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-white border-slate-200'">
                            <span class="text-[10px] font-sans font-bold text-slate-400 dark:text-zinc-400 block" x-text="lang === 'bn' ? 'ðŸ“± à¦¬à¦¿à¦•à¦¾à¦¶ / à¦¨à¦—à¦¦' : 'MFS Paid'"></span>
                            <div class="text-sm sm:text-base font-bold text-pink-500 mt-0.5" x-text="formatCurrency(todayStats.todayRawMfsCost)"></div>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-lg border" :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-white border-slate-200'">
                            <span class="text-[10px] font-sans font-bold text-slate-400 dark:text-zinc-400 block" x-text="lang === 'bn' ? 'â³ à¦¬à¦¾à¦•à¦¿ / à¦¬à¦•à§‡à§Ÿà¦¾ à¦•à§à¦°à§Ÿ' : 'Due / Credit'"></span>
                            <div class="text-sm sm:text-base font-bold text-amber-500 mt-0.5" x-text="formatCurrency(todayStats.todayRawDueCost)"></div>
                        </div>
                    </div>

                    <!-- Category & Date Filters + Search -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2">
                        <!-- Date & Payment Filters -->
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 hide-scrollbar">
                            <button @click="rawCostDateFilter = 'today'; playChime(500)" 
                                    :class="rawCostDateFilter === 'today' ? 'bg-rose-500 text-white font-bold' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                                    class="px-2.5 py-1 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                                <span>ðŸ“…</span>
                                <span x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦–à¦°à¦š' : 'Today'"></span>
                            </button>
                            <button @click="rawCostDateFilter = 'all'; playChime(500)" 
                                    :class="rawCostDateFilter === 'all' ? 'bg-rose-500 text-white font-bold' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                                    class="px-2.5 py-1 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                                <span>ðŸ“‹</span>
                                <span x-text="lang === 'bn' ? 'à¦¸à¦¬ à¦–à¦°à¦š (' + rawItemsCosts.length + ')' : 'All'"></span>
                            </button>
                            <button @click="rawCostDateFilter = 'cash'; playChime(500)" 
                                    :class="rawCostDateFilter === 'cash' ? 'bg-brand-500 text-slate-950 font-bold' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                                    class="px-2.5 py-1 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                                <span>ðŸ’µ</span>
                                <span x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦¶ à¦•à§à¦°à§Ÿ' : 'Cash'"></span>
                            </button>
                            <button @click="rawCostDateFilter = 'due'; playChime(500)" 
                                    :class="rawCostDateFilter === 'due' ? 'bg-amber-500 text-slate-950 font-bold' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                                    class="px-2.5 py-1 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                                <span>â³</span>
                                <span x-text="lang === 'bn' ? 'à¦¬à¦¾à¦•à¦¿' : 'Due'"></span>
                            </button>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text" x-model.debounce.120ms="rawCostSearch" 
                                   :placeholder="lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦¬à¦¾ à¦¬à¦¾à¦œà¦¾à¦°à§‡à¦° à¦¨à¦¾à¦® à¦¸à¦¾à¦°à§à¦š...' : 'Search raw item or vendor...'"
                                   class="text-xs px-3 py-1.5 rounded-xl border focus:outline-none w-full sm:w-60 transition-all"
                                   :class="isDark ? 'bg-obsidian-950 border-white/[0.08] text-white focus:border-rose-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:border-rose-400'">
                            <button x-show="rawCostSearch" @click="rawCostSearch = ''" class="absolute right-2.5 top-1.5 text-xs text-slate-400 hover:text-white">âœ•</button>
                        </div>
                    </div>

                    <!-- Category Pills -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 hide-scrollbar">
                        <template x-for="cat in rawCostCategories" :key="cat.key">
                            <button @click="rawCostCategoryFilter = cat.key; playChime(500)"
                                    :class="rawCostCategoryFilter === cat.key ? 'bg-rose-500 text-white font-bold shadow-xs' : (isDark ? 'bg-zinc-800/80 text-zinc-300 border-zinc-700/80' : 'bg-slate-100 text-slate-700 border-slate-200')"
                                    class="px-2.5 py-1 rounded-xl border text-[11px] font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                                <span x-text="cat.icon"></span>
                                <span x-text="lang === 'bn' ? cat.nameBn : cat.nameEn"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Empty State -->
                    <template x-if="filteredRawCosts.length === 0">
                        <div class="p-8 text-center text-slate-400 text-xs rounded-lg border border-dashed border-zinc-700 space-y-2">
                            <span class="text-3xl block">ðŸ¥©</span>
                            <p class="font-bold text-sm text-slate-300" x-text="lang === 'bn' ? 'à¦•à§‹à¦¨à§‹ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦¬à¦¾ à¦¬à¦¾à¦œà¦¾à¦° à¦–à¦°à¦šà§‡à¦° à¦°à§‡à¦•à¦°à§à¦¡ à¦ªà¦¾à¦“à§Ÿà¦¾ à¦¯à¦¾à§Ÿà¦¨à¦¿' : 'No raw item costs found'"></p>
                            <p class="text-[11px] text-slate-500" x-text="lang === 'bn' ? 'à¦‰à¦ªà¦°à§‡ "+ à¦¨à¦¤à§à¦¨ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦¯à§‹à¦— à¦•à¦°à§à¦¨" à¦¬à¦¾à¦Ÿà¦¨à§‡ à¦•à§à¦²à¦¿à¦• à¦•à¦°à§‡ à¦–à¦°à¦š à¦°à§‡à¦•à¦°à§à¦¡ à¦•à¦°à§à¦¨à¥¤' : 'Click + Add Raw Cost to record daily expenses.'"></p>
                            <button @click="openAddRawCostModal()" class="mt-2 px-4 py-2 rounded-xl bg-rose-500 text-white font-bold text-xs cursor-pointer shadow-md inline-flex items-center gap-1.5">
                                <span>âž•</span>
                                <span x-text="lang === 'bn' ? 'à¦ªà§à¦°à¦¥à¦® à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'Add First Raw Cost'"></span>
                            </button>
                        </div>
                    </template>

                    <!-- VIEW 1: DESKTOP TABLE VIEW -->
                    <div x-show="filteredRawCosts.length > 0" :class="viewMode === 'mobile' ? 'hidden' : 'hidden sm:block overflow-x-auto rounded-lg border'"
                         :class="isDark ? 'border-white/[0.08]' : 'border-slate-200'">
                        <table class="w-full text-left text-xs">
                            <thead class="border-b font-bold" :class="isDark ? 'bg-obsidian-950/90 border-white/[0.08] text-zinc-400' : 'bg-slate-50 border-slate-200 text-slate-500'">
                                <tr>
                                    <th class="p-2.5" x-text="lang === 'bn' ? 'à¦†à¦‡à¦Ÿà§‡à¦®à§‡à¦° à¦¨à¦¾à¦®' : 'Raw Item'"></th>
                                    <th class="p-2.5" x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦Ÿà¦¾à¦—à¦°à¦¿' : 'Category'"></th>
                                    <th class="p-2.5" x-text="lang === 'bn' ? 'à¦ªà¦°à¦¿à¦®à¦¾à¦£ à¦“ à¦¦à¦°' : 'Qty & Unit Price'"></th>
                                    <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦–à¦°à¦š' : 'Total Cost'"></th>
                                    <th class="p-2.5" x-text="lang === 'bn' ? 'à¦¬à¦¾à¦œà¦¾à¦° / à¦¸à¦°à¦¬à¦°à¦¾à¦¹à¦•à¦¾à¦°à§€' : 'Vendor / Market'"></th>
                                    <th class="p-2.5" x-text="lang === 'bn' ? 'à¦ªà§‡à¦®à§‡à¦¨à§à¦Ÿ' : 'Payment'"></th>
                                    <th class="p-2.5" x-text="lang === 'bn' ? 'à¦¤à¦¾à¦°à¦¿à¦– à¦“ à¦¸à¦®à§Ÿ' : 'Date & Time'"></th>
                                    <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦…à§à¦¯à¦¾à¦•à¦¶à¦¨' : 'Actions'"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y" :class="isDark ? 'divide-white/[0.04]' : 'divide-slate-100'">
                                <template x-for="item in filteredRawCosts" :key="item.id">
                                    <tr class="transition-colors" :class="isDark ? 'hover:bg-white/[0.03]' : 'hover:bg-slate-50/80'">
                                        <td class="p-2.5">
                                            <div class="font-bold text-slate-900 dark:text-white" x-text="item.name"></div>
                                            <div x-show="item.note" class="text-[10px] text-slate-400 truncate max-w-xs" x-text="item.note"></div>
                                        </td>
                                        <td class="p-2.5">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                                  :class="isDark ? 'bg-zinc-800 text-zinc-300 border border-zinc-700' : 'bg-slate-100 text-slate-600 border border-slate-200'"
                                                  x-text="getCategoryLabel(item.category)"></span>
                                        </td>
                                        <td class="p-2.5 font-mono">
                                            <span class="font-bold text-slate-900 dark:text-zinc-200" x-text="item.quantity + ' ' + item.unit"></span>
                                            <span class="text-[10px] text-slate-400" x-text="'@ à§³' + Number(item.unitPrice || 0).toLocaleString()"></span>
                                        </td>
                                        <td class="p-2.5 text-right font-mono font-bold text-rose-500 text-sm" x-text="formatCurrency(item.totalCost)"></td>
                                        <td class="p-2.5 font-medium text-slate-700 dark:text-zinc-300" x-text="item.vendor || 'à¦²à§‹à¦•à¦¾à¦² à¦¬à¦¾à¦œà¦¾à¦°'"></td>
                                        <td class="p-2.5">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                                  :class="item.paidVia === 'bKash' ? 'bg-pink-500/20 text-pink-300 border border-pink-500/30' : (item.paidVia === 'Nagad' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : (item.paidVia === 'Due' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-brand-500/20 text-brand-400 border border-brand-500/30'))"
                                                  x-text="item.paidVia"></span>
                                        </td>
                                        <td class="p-2.5 text-[10px] text-slate-400 font-mono" x-text="item.timestamp || item.date"></td>
                                        <td class="p-2.5 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button @click="editRawCost(item)" title="à¦à¦¡à¦¿à¦Ÿ à¦•à¦°à§à¦¨" class="p-1 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 text-xs transition-colors cursor-pointer">âœï¸</button>
                                                <button @click="deleteRawCost(item.id)" title="à¦®à§à¦›à§‡ à¦«à§‡à¦²à§à¦¨" class="p-1 rounded-lg bg-rose-500/15 hover:bg-rose-500/30 text-rose-400 text-xs transition-colors cursor-pointer">ðŸ—‘ï¸</button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- VIEW 2: MOBILE CARDS VIEW -->
                    <div x-show="filteredRawCosts.length > 0" :class="viewMode === 'mobile' ? 'block space-y-2' : 'block sm:hidden space-y-2'">
                        <template x-for="item in filteredRawCosts" :key="item.id">
                            <div class="p-3 rounded-lg border transition-all space-y-2 shadow-xs"
                                 :class="isDark ? 'bg-obsidian-950/90 border-white/[0.08]' : 'bg-white border-slate-200'">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <span class="w-2 h-2 rounded-full bg-rose-500 flex-shrink-0"></span>
                                        <h5 class="font-bold text-xs text-slate-900 dark:text-white truncate" x-text="item.name"></h5>
                                    </div>
                                    <span class="font-mono font-bold text-sm text-rose-500 flex-shrink-0" x-text="formatCurrency(item.totalCost)"></span>
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-slate-400">
                                    <span x-text="item.quantity + ' ' + item.unit + ' @ à§³' + Number(item.unitPrice).toLocaleString()"></span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                          :class="item.paidVia === 'bKash' ? 'bg-pink-500/20 text-pink-300' : (item.paidVia === 'Nagad' ? 'bg-amber-500/20 text-amber-300' : (item.paidVia === 'Due' ? 'bg-rose-500/20 text-rose-300' : 'bg-brand-500/20 text-brand-400'))"
                                          x-text="item.paidVia"></span>
                                </div>
                                <div class="flex items-center justify-between pt-1 border-t text-[10px] text-slate-400" :class="isDark ? 'border-white/[0.05]' : 'border-slate-100'">
                                    <span x-text="item.vendor || 'à¦²à§‹à¦•à¦¾à¦² à¦¬à¦¾à¦œà¦¾à¦°'"></span>
                                    <div class="flex items-center gap-1">
                                        <span x-text="item.timestamp || item.date"></span>
                                        <button @click="editRawCost(item)" class="p-1 text-xs">âœï¸</button>
                                        <button @click="deleteRawCost(item.id)" class="p-1 text-xs text-rose-400">ðŸ—‘ï¸</button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                </div>

                <!-- ================================================================= -->
                <!-- SUB-VIEW 4: DAILY PROFIT & LOSS STATEMENT (à¦²à¦¾à¦­-à¦•à§à¦·à¦¤à¦¿ à¦“ à¦¸à¦®à¦¨à§à¦¬à§Ÿ) -->
                <!-- ================================================================= -->
                <div x-show="ledgerViewMode === 'profit_loss'" class="space-y-4">
                    
                    <!-- P&L Header Banner -->
                    <div class="p-3.5 sm:p-5 rounded-lg border flex flex-wrap items-center justify-between gap-3 shadow-xs"
                         :class="isDark ? 'bg-obsidian-950/90 border-teal-500/40 text-zinc-100' : 'bg-teal-50/80 border-teal-300 text-slate-900'">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl">âš–ï¸</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-base" x-text="lang === 'bn' ? 'à¦¦à§ˆà¦¨à¦¿à¦• à¦†à§Ÿ-à¦¬à§à¦¯à§Ÿ à¦“ à¦¨à¦¿à¦Ÿ à¦²à¦¾à¦­-à¦•à§à¦·à¦¤à¦¿ à¦–à¦¤à¦¿à§Ÿà¦¾à¦¨' : 'Daily Income, Expense & Net P&L Statement'"></h4>
                                <p class="text-[10px] sm:text-xs text-slate-500 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ à¦–à¦¾à¦¬à¦¾à¦° à¦¬à¦¿à¦•à§à¦°à¦¿à¦° à¦†à§Ÿ à¦¥à§‡à¦•à§‡ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦“ à¦¬à¦¾à¦œà¦¾à¦° à¦–à¦°à¦šà§‡à¦° à¦¸à§à¦¬à§Ÿà¦‚à¦•à§à¦°à¦¿à§Ÿ à¦¸à¦®à¦¨à§à¦¬à§Ÿ' : 'Real-time reconciliation of total sales revenue vs raw procurement costs'"></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 font-mono">
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 font-sans block" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¨à¦¿à¦Ÿ à¦…à¦ªà¦¾à¦°à§‡à¦Ÿà¦¿à¦‚ à¦²à¦¾à¦­' : 'Net Operating Profit'"></span>
                                <span class="text-base sm:text-xl font-bold text-teal-400" x-text="formatCurrency(todayStats.todayNetProfit)"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Side by Side Comparative Financial Table -->
                    <div :class="viewMode === 'mobile' ? 'grid grid-cols-1 gap-3 font-mono text-xs' : 'grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 font-mono text-xs'">
                        
                        <!-- Left: INFLOW (Sales Revenue) -->
                        <div class="p-4 rounded-lg border space-y-3"
                             :class="isDark ? 'bg-obsidian-950/80 border-brand-500/30' : 'bg-white border-brand-200'">
                            <div class="flex items-center justify-between pb-2 border-b border-brand-500/20 font-sans">
                                <span class="font-bold text-sm text-brand-500 flex items-center gap-1.5">
                                    <span>ðŸ“¥</span>
                                    <span x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦°à¦¾à¦œà¦¸à§à¦¬ (Sales Revenue)' : 'Sales Inflow'"></span>
                                </span>
                                <span class="font-mono font-bold text-sm text-brand-500" x-text="formatCurrency(todayStats.totalRevenue)"></span>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between text-slate-300">
                                    <span x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿ (Cash Sales):' : 'Cash Sales:'"></span>
                                    <span class="font-bold text-slate-200" x-text="formatCurrency(todayStats.cashTotal)"></span>
                                </div>
                                <div class="flex justify-between text-pink-400">
                                    <span x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿ (bKash Sales):' : 'bKash Sales:'"></span>
                                    <span class="font-bold" x-text="formatCurrency(todayStats.bkashTotal)"></span>
                                </div>
                                <div class="flex justify-between text-amber-400">
                                    <span x-text="lang === 'bn' ? 'à¦¨à¦—à¦¦ à¦¬à¦¿à¦•à§à¦°à¦¿ (Nagad Sales):' : 'Nagad Sales:'"></span>
                                    <span class="font-bold" x-text="formatCurrency(todayStats.nagadTotal)"></span>
                                </div>
                                <div class="flex justify-between text-slate-400 pt-1 border-t border-white/[0.06]">
                                    <span x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦¸à¦®à§à¦ªà¦¨à§à¦¨ à¦®à§‡à¦®à§‹:' : 'Total Orders:'"></span>
                                    <span class="font-bold" x-text="todayStats.totalOrders + (lang === 'bn' ? 'à¦Ÿà¦¿' : ' pcs')"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: OUTFLOW (Raw Items Procurement Cost) -->
                        <div class="p-4 rounded-lg border space-y-3"
                             :class="isDark ? 'bg-obsidian-950/80 border-rose-500/30' : 'bg-white border-rose-200'">
                            <div class="flex items-center justify-between pb-2 border-b border-rose-500/20 font-sans">
                                <span class="font-bold text-sm text-rose-500 flex items-center gap-1.5">
                                    <span>ðŸ“¤</span>
                                    <span x-text="lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦“ à¦¬à¦¾à¦œà¦¾à¦° à¦–à¦°à¦š (Raw Procurement)' : 'Raw Costs Outflow'"></span>
                                </span>
                                <span class="font-mono font-bold text-sm text-rose-500" x-text="formatCurrency(todayStats.todayRawCost)"></span>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between text-slate-300">
                                    <span x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦¶à§‡ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦•à§à¦°à§Ÿ:' : 'Cash Raw Purchases:'"></span>
                                    <span class="font-bold text-slate-200" x-text="formatCurrency(todayStats.todayRawCashCost)"></span>
                                </div>
                                <div class="flex justify-between text-pink-400">
                                    <span x-text="lang === 'bn' ? 'à¦¡à¦¿à¦œà¦¿à¦Ÿà¦¾à¦² (MFS) à¦–à¦°à¦š:' : 'Digital MFS Purchases:'"></span>
                                    <span class="font-bold" x-text="formatCurrency(todayStats.todayRawMfsCost)"></span>
                                </div>
                                <div class="flex justify-between text-amber-400">
                                    <span x-text="lang === 'bn' ? 'à¦¬à¦•à§‡à§Ÿà¦¾ / à¦¬à¦¾à¦•à¦¿ à¦•à§à¦°à§Ÿ (Due):' : 'Due Purchases:'"></span>
                                    <span class="font-bold" x-text="formatCurrency(todayStats.todayRawDueCost)"></span>
                                </div>
                                <div class="flex justify-between text-slate-400 pt-1 border-t border-white/[0.06]">
                                    <span x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦†à¦‡à¦Ÿà§‡à¦®:' : 'Total Raw Items:'"></span>
                                    <span class="font-bold" x-text="todayStats.todayRawCount + (lang === 'bn' ? 'à¦Ÿà¦¿' : ' items')"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Executive Reconciliation Card: Net Profit & Cash Drawer Summary -->
                    <div class="p-4 sm:p-5 rounded-lg border font-mono space-y-3"
                         :class="isDark ? 'bg-obsidian-950 border-teal-500/40 text-white' : 'bg-slate-50 border-slate-300 text-slate-900'">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b" :class="isDark ? 'border-white/[0.08]' : 'border-slate-200'">
                            <div>
                                <span class="font-sans text-xs text-slate-400 block" x-text="lang === 'bn' ? 'à¦šà§‚à§œà¦¾à¦¨à§à¦¤ à¦¹à¦¿à¦¸à¦¾à¦¬ à¦¸à¦®à§€à¦•à¦°à¦£' : 'Final Equation'"></span>
                                <h4 class="font-bold text-sm sm:text-base text-teal-400" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿ - à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦¬à§à¦¯à§Ÿ = à¦¨à¦¿à¦Ÿ à¦…à¦ªà¦¾à¦°à§‡à¦Ÿà¦¿à¦‚ à¦²à¦¾à¦­' : 'Total Revenue - Raw Costs = Net Profit'"></h4>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-teal-400" x-text="formatCurrency(todayStats.todayNetProfit)"></span>
                                <span class="text-xs font-bold text-teal-400 block" x-text="'(' + todayStats.todayProfitPercent + '% ' + (lang === 'bn' ? 'à¦®à§à¦¨à¦¾à¦«à¦¾à¦° à¦¹à¦¾à¦°)' : 'profit margin)')"></span>
                            </div>
                        </div>

                        <div :class="viewMode === 'mobile' ? 'grid grid-cols-1 gap-2 text-xs pt-1' : 'grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs pt-1'">
                            <div class="p-2.5 rounded-xl border" :class="isDark ? 'bg-zinc-900/60 border-zinc-800' : 'bg-white border-slate-200'">
                                <span class="text-slate-400 block text-[10px]" x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¥à§‡à¦•à§‡ à¦•à§à¦¯à¦¾à¦¶ à¦–à¦°à¦š à¦¬à¦¾à¦¦' : 'Net Cash in Drawer'"></span>
                                <span class="font-bold text-sm text-amber-400" x-text="formatCurrency(todayStats.todayCashInHand)"></span>
                                <span class="text-[9px] text-slate-500 block" x-text="lang === 'bn' ? 'à¦¹à¦¾à¦¤à§‡ à¦¥à¦¾à¦•à¦¾ à¦¡à§à¦°à§Ÿà¦¾à¦° à¦•à§à¦¯à¦¾à¦¶' : 'Cash in drawer'"></span>
                            </div>
                            <div class="p-2.5 rounded-xl border" :class="isDark ? 'bg-zinc-900/60 border-zinc-800' : 'bg-white border-slate-200'">
                                <span class="text-slate-400 block text-[10px]" x-text="lang === 'bn' ? 'à¦¡à¦¿à¦œà¦¿à¦Ÿà¦¾à¦² à¦¬à§à¦¯à¦¾à¦²à§‡à¦¨à§à¦¸ (à¦¬à¦¿à¦•à¦¾à¦¶ + à¦¨à¦—à¦¦)' : 'Digital Net Balance'"></span>
                                <span class="font-bold text-sm text-pink-400" x-text="formatCurrency(todayStats.mfsTotal - todayStats.todayRawMfsCost)"></span>
                                <span class="text-[9px] text-slate-500 block" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à¦¾à¦¶/à¦¨à¦—à¦¦à§‡ à¦¨à¦¿à¦Ÿ à¦œà¦®à¦¾' : 'MFS net balance'"></span>
                            </div>
                            <div class="p-2.5 rounded-xl border" :class="isDark ? 'bg-zinc-900/60 border-zinc-800' : 'bg-white border-slate-200'">
                                <span class="text-slate-400 block text-[10px]" x-text="lang === 'bn' ? 'à¦¬à¦¾à¦•à¦¿/à¦ªà¦°à¦¿à¦¶à§‹à¦§à¦¯à§‹à¦—à§à¦¯ à¦¦à§‡à¦¨à¦¾' : 'Unpaid Supplier Due'"></span>
                                <span class="font-bold text-sm text-rose-400" x-text="formatCurrency(todayStats.todayRawDueCost)"></span>
                                <span class="text-[9px] text-slate-500 block" x-text="lang === 'bn' ? 'à¦¸à¦°à¦¬à¦°à¦¾à¦¹à¦•à¦¾à¦°à§€à¦•à§‡ à¦ªà§à¦°à¦¦à§‡à§Ÿ' : 'Payable to vendors'"></span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            </template>
        </main>

        <!-- ================================================================= -->
        <!-- TAB 6: MENU ENGINE -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'menu'" class="flex-1 space-y-4">
            <div class="p-4 sm:p-6 rounded-lg border transition-all space-y-4" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white" x-text="t('tabMenu')"></h3>
                    <button @click="openNewItemModal()" class="px-3.5 py-1.5 rounded-xl bg-brand-500 text-slate-950 font-bold text-xs cursor-pointer" x-text="lang === 'bn' ? '+ à¦¨à¦¤à§à¦¨ à¦†à¦‡à¦Ÿà§‡à¦®' : '+ Add Item'"></button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="border-b font-bold" :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08] text-zinc-400' : 'bg-slate-50 border-slate-200 text-slate-500'">
                            <tr>
                                <th class="p-2.5" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦°' : 'Food Item'"></th>
                                <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à§Ÿà¦®à§‚à¦²à§à¦¯ (à§³)' : 'Price (à§³)'"></th>
                                <th class="p-2.5 text-center" x-text="lang === 'bn' ? 'à¦®à¦¾à¦°à§à¦œà¦¿à¦¨' : 'Margin'"></th>
                                <th class="p-2.5 text-right" x-text="lang === 'bn' ? 'à¦…à§à¦¯à¦¾à¦•à¦¶à¦¨' : 'Action'"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" :class="isDark ? 'divide-white/[0.04]' : 'divide-slate-100'">
                            <template x-for="item in menuItems" :key="item.id">
                                <tr class="transition-colors" :class="isDark ? 'hover:bg-white/[0.03]' : 'hover:bg-slate-50/70'">
                                    <td class="p-2.5">
                                        <div class="flex items-center gap-2">
                                            <img :src="item.image" class="w-8 h-8 rounded-lg object-cover">
                                            <span class="font-bold text-slate-900 dark:text-white truncate max-w-[120px]" x-text="lang === 'bn' ? (item.nameBn || item.name) : item.name"></span>
                                        </div>
                                    </td>
                                    <td class="p-2.5 text-right font-mono">
                                        <input type="number" step="5" x-model.number="item.price" @change="saveToStorage(); showToast(lang === 'bn' ? 'à¦®à§‚à¦²à§à¦¯ à¦†à¦ªà¦¡à§‡à¦Ÿ à¦¹à§Ÿà§‡à¦›à§‡' : 'Price updated')" class="w-16 text-right py-1 px-1.5 rounded border font-bold text-brand-500 text-xs" :class="isDark ? 'bg-obsidian-950 border-white/[0.08]' : 'bg-white border-slate-200'">
                                    </td>
                                    <td class="p-2.5 text-center font-mono font-bold text-brand-400" x-text="getMarginPercent(item) + '%'"></td>
                                    <td class="p-2.5 text-right">
                                        <button @click="openEditItemModal(item)" class="p-1 rounded bg-zinc-800 text-zinc-300 text-xs cursor-pointer">âœï¸</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- ================================================================= -->
        <!-- TAB 7: EXPORT & SETTINGS -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'export' || activeTab === 'admin-settings'" class="flex-1 space-y-4">
            <div class="p-4 sm:p-6 rounded-lg border transition-all space-y-4" :class="isDark ? 'glass-panel-dark' : 'glass-panel-light'">
                <h3 class="font-bold text-base text-slate-900 dark:text-white" x-text="lang === 'bn' ? 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦¸à§‡à¦Ÿà¦¿à¦‚à¦¸ à¦“ CSV à¦à¦•à§à¦¸à¦ªà§‹à¦°à§à¦Ÿ' : 'Food Court Settings & CSV Export'"></h3>
                <div class="space-y-3 text-xs">
                    <div>
                        <label class="font-bold text-slate-600 dark:text-slate-400 block mb-1" x-text="lang === 'bn' ? 'à¦¸à§à¦Ÿà§‹à¦°à§‡à¦° à¦¨à¦¾à¦®' : 'Store Name'"></label>
                        <input type="text" x-model="posSettings.storeName" class="w-full p-2.5 rounded-xl border bg-obsidian-950 border-white/[0.08] text-white">
                    </div>
                    <div>
                        <label class="font-bold text-slate-600 dark:text-slate-400 block mb-1" x-text="lang === 'bn' ? 'à¦­à§à¦¯à¦¾à¦Ÿ à¦¹à¦¾à¦° (%)' : 'VAT Rate (%)'"></label>
                        <input type="number" x-model.number="posSettings.vatPercent" class="w-full p-2.5 rounded-xl border bg-obsidian-950 border-white/[0.08] text-white">
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl border" :class="isDark ? 'bg-obsidian-950 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                        <div>
                            <span class="font-bold text-slate-800 dark:text-zinc-200 block text-xs" x-text="lang === 'bn' ? 'à¦¸à§à¦¬à§Ÿà¦‚à¦•à§à¦°à¦¿à§Ÿ à¦°à¦¸à¦¿à¦¦ à¦ªà¦ªà¦†à¦ª (Auto Show Receipt)' : 'Auto Show Receipt Popup'"></span>
                            <span class="text-[10px] text-slate-500 dark:text-zinc-400" x-text="lang === 'bn' ? 'à¦¬à¦¨à§à¦§ à¦¥à¦¾à¦•à¦²à§‡ à¦¸à§à¦•à§à¦°à¦¿à¦¨ à¦†à¦Ÿà¦•à§‡ à¦¨à¦¾ à¦—à¦¿à§Ÿà§‡ à¦¦à§à¦°à§à¦¤ à¦ªà¦°à¦ªà¦° à¦¸à§‡à¦²à¦¸ à¦°à§‡à¦•à¦°à§à¦¡ à¦¹à¦¬à§‡' : 'Keep off for fast consecutive sales recording'"></span>
                        </div>
                        <input type="checkbox" x-model="posSettings.autoShowReceipt" class="w-5 h-5 accent-brand-500 rounded cursor-pointer">
                    </div>
                    <div class="flex items-center gap-2 pt-2">
                        <button @click="saveSettings(); showToast(lang === 'bn' ? 'à¦¸à§‡à¦Ÿà¦¿à¦‚à¦¸ à¦¸à¦‚à¦°à¦•à§à¦·à¦¿à¦¤ à¦¹à¦¯à¦¼à§‡à¦›à§‡ âœ“' : 'Settings saved âœ“')" class="flex-1 py-2.5 rounded-xl bg-brand-500 text-slate-950 font-bold cursor-pointer" x-text="lang === 'bn' ? 'à¦¸à§‡à¦­ à¦¸à§‡à¦Ÿà¦¿à¦‚à¦¸' : 'Save Settings'"></button>
                        <button @click="exportToCSV()" class="flex-1 py-2.5 rounded-xl bg-zinc-800 text-zinc-200 font-bold border border-zinc-700 cursor-pointer" x-text="lang === 'bn' ? 'CSV à¦¡à¦¾à¦‰à¦¨à¦²à§‹à¦¡' : 'Download CSV'"></button>
                    </div>
                </div>
            </div>
        </main>

        <!-- ================================================================= -->
        <!-- TAB: ADMIN LOGIN & MULTI-TENANT FOOD COURT HUB -->
        <!-- ================================================================= -->
        <main x-show="activeTab === 'login'" class="flex-1 max-w-4xl mx-auto w-full py-4 sm:py-6 px-2">
            
            <!-- ============================================================= -->
            <!-- 1. IF NOT LOGGED IN: MODERN PASSWORD-PROTECTED LOGIN SCREEN -->
            <!-- ============================================================= -->
            <template x-if="!isAdminLoggedIn">
                <div class="max-w-xl mx-auto p-6 sm:p-8 rounded-xl border shadow-2xl transition-all space-y-6"
                     :class="isDark ? 'glass-panel-dark border-amber-500/30' : 'bg-white border-slate-200 text-slate-900'">
                    
                    <div class="text-center space-y-2">
                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-3xl mx-auto shadow-neon-amber font-bold">
                            ðŸ”
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold tracking-tight" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿ à¦¸à¦¿à¦•à¦¿à¦‰à¦° à¦ªà§‹à¦°à§à¦Ÿà¦¾à¦²' : 'Khabarbari Secure Portal'"></h2>
                        <p class="text-xs text-slate-400" x-text="lang === 'bn' ? 'à¦®à§‡à¦‡à¦¨ à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦…à¦¥à¦¬à¦¾ à¦†à¦ªà¦¨à¦¾à¦° à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦à¦•à¦¾à¦‰à¦¨à§à¦Ÿà§‡ à¦²à¦—à¦‡à¦¨ à¦•à¦°à§à¦¨' : 'Sign in as Main Admin or Food Court Owner with your password'"></p>
                    </div>

                    <!-- Error Alert -->
                    <div x-show="adminLoginError" x-cloak class="p-3 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-400 text-xs font-bold text-center">
                        <span x-text="adminLoginError"></span>
                    </div>

                    <!-- Login Form -->
                    <form @submit.prevent="handleAdminLogin()" class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-300 block" x-text="lang === 'bn' ? 'à¦²à¦—à¦‡à¦¨ à¦‡à¦®à§‡à¦‡à¦²' : 'Login Email'"></label>
                            <input type="email" x-model="adminEmail" required placeholder="admin@foodcourt.com"
                                   class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-all font-mono"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-white/[0.1] focus:border-amber-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-amber-500'">
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-300 block" x-text="lang === 'bn' ? 'à¦ªà¦¾à¦¸à¦“à§Ÿà¦¾à¦°à§à¦¡' : 'Password'"></label>
                                <button type="button" @click="adminShowPassword = !adminShowPassword" class="text-[11px] text-amber-400 hover:underline cursor-pointer" x-text="adminShowPassword ? (lang === 'bn' ? 'à¦¹à¦¾à¦‡à¦¡' : 'Hide') : (lang === 'bn' ? 'à¦¦à§‡à¦–à¦¾à¦¨' : 'Show')"></button>
                            </div>
                            <input :type="adminShowPassword ? 'text' : 'password'" x-model="adminPassword" required placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢"
                                   class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none transition-all font-mono"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-white/[0.1] focus:border-amber-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-amber-500'">
                        </div>

                        <!-- 1-Click Fast Fill Testing Accounts -->
                        <div class="p-3 rounded-lg border text-xs space-y-2"
                             :class="isDark ? 'bg-zinc-900/60 border-zinc-800' : 'bg-slate-100 border-slate-200'">
                            <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider" x-text="lang === 'bn' ? 'âš¡ à¦¦à§à¦°à§à¦¤ à¦Ÿà§‡à¦¸à§à¦Ÿ à¦²à¦—à¦‡à¦¨ (Demo 1-Click Fill):' : 'âš¡ 1-Click Demo Accounts:'"></span>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1.5">
                                <button type="button" @click="adminEmail='admin@foodcourt.com'; adminPassword='admin123'; handleAdminLogin()" 
                                        class="p-2 rounded-xl border text-left cursor-pointer transition-all hover:scale-[1.02] active:scale-95"
                                        :class="isDark ? 'bg-amber-500/10 border-amber-500/30 text-amber-300' : 'bg-amber-50 border-amber-300 text-amber-900'">
                                    <div class="font-bold text-[11px] flex items-center gap-1">ðŸ‘‘ <span>Main Admin</span></div>
                                    <div class="text-[9px] opacity-75 font-mono">admin@foodcourt.com</div>
                                </button>
                                
                                <button type="button" @click="adminEmail='kacchi@foodcourt.com'; adminPassword='kacchi123'; handleAdminLogin()" 
                                        class="p-2 rounded-xl border text-left cursor-pointer transition-all hover:scale-[1.02] active:scale-95"
                                        :class="isDark ? 'bg-brand-500/10 border-brand-500/30 text-brand-300' : 'bg-brand-50 border-brand-300 text-brand-900'">
                                    <div class="font-bold text-[11px] flex items-center gap-1">ðŸ› <span x-text="lang === 'bn' ? 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿' : 'Kacchi Bari'"></span></div>
                                    <div class="text-[9px] opacity-75 font-mono">kacchi@foodcourt.com</div>
                                </button>

                                <button type="button" @click="adminEmail='burger@foodcourt.com'; adminPassword='burger123'; handleAdminLogin()" 
                                        class="p-2 rounded-xl border text-left cursor-pointer transition-all hover:scale-[1.02] active:scale-95"
                                        :class="isDark ? 'bg-pink-500/10 border-pink-500/30 text-pink-300' : 'bg-pink-50 border-pink-300 text-pink-900'">
                                    <div class="font-bold text-[11px] flex items-center gap-1">ðŸ” <span x-text="lang === 'bn' ? 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦à¦•à§à¦¸à¦ªà§à¦°à§‡à¦¸' : 'Burger Express'"></span></div>
                                    <div class="text-[9px] opacity-75 font-mono">burger@foodcourt.com</div>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full py-3.5 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 text-slate-950 font-bold text-sm shadow-xl shadow-amber-500/25 active:scale-98 transition-all cursor-pointer flex items-center justify-center gap-2">
                            <span>ðŸ”“</span>
                            <span x-text="lang === 'bn' ? 'à¦²à¦—à¦‡à¦¨ à¦•à¦°à§à¦¨' : 'Sign In'"></span>
                        </button>
                    </form>
                </div>
            </template>

            <!-- ============================================================= -->
            <!-- 2. IF LOGGED IN: ROLE-BASED DASHBOARD                         -->
            <!-- ============================================================= -->
            <template x-if="isAdminLoggedIn">
                <div class="space-y-6">

                    <!-- ===================================================== -->
                    <!-- A. MAIN ADMIN CENTRAL CONTROL HUB                     -->
                    <!-- ===================================================== -->
                    <template x-if="currentUserRole === 'superadmin'">
                        <div class="space-y-6">
                            
                            <!-- Main Admin Top Hero Card -->
                            <div class="p-6 sm:p-7 rounded-xl border shadow-2xl transition-all space-y-4"
                                 :class="isDark ? 'glass-panel-dark border-amber-500/40' : 'bg-white border-slate-200 text-slate-900'">
                                
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-3xl font-bold shadow-neon-amber flex-shrink-0">
                                            ðŸ‘‘
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white" x-text="lang === 'bn' ? 'à¦¸à§‡à¦¨à§à¦Ÿà§à¦°à¦¾à¦² à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦•à¦¨à§à¦Ÿà§à¦°à§‹à¦² à¦¹à¦¾à¦¬ (Main Admin)' : 'Central Food Court Control Hub'"></h2>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/40" x-text="lang === 'bn' ? 'à¦¸à§à¦ªà¦¾à¦° à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨' : 'Super Admin'"></span>
                                            </div>
                                            <p class="text-xs text-slate-400" x-text="lang === 'bn' ? 'à¦†à¦ªà¦¨à¦¿ à¦“à§Ÿà§‡à¦¬à¦¸à¦¾à¦‡à¦Ÿà§‡à¦° à¦ªà§à¦°à¦§à¦¾à¦¨ à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨à¥¤ à¦¸à¦•à¦² à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦®à¦¾à¦²à¦¿à¦•à§‡à¦° à¦¤à¦¥à§à¦¯, à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¹à¦¿à¦¸à¦¾à¦¬ à¦“ à¦–à¦¾à¦¦à§à¦¯ à¦¤à¦¾à¦²à¦¿à¦•à¦¾ à¦†à¦ªà¦¨à¦¾à¦° à¦¨à¦¿à§Ÿà¦¨à§à¦¤à§à¦°à¦£à§‡à¥¤' : 'Full administrative access: inspect, manage and oversee all food court stalls'"></p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="openAddOwnerModal()" 
                                                class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 text-slate-950 font-bold text-xs shadow-md flex items-center gap-1.5 cursor-pointer active:scale-95 transition-all">
                                            <span>âž•</span>
                                            <span x-text="lang === 'bn' ? 'à¦¨à¦¤à§à¦¨ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦®à¦¾à¦²à¦¿à¦•' : 'Add Food Court'"></span>
                                        </button>
                                        <button type="button" @click="logoutAdmin()" 
                                                class="px-3.5 py-2 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 border border-rose-500/30 font-bold text-xs flex items-center gap-1 cursor-pointer transition-all">
                                            <span>ðŸšª</span>
                                            <span x-text="lang === 'bn' ? 'à¦²à¦—à¦†à¦‰à¦Ÿ' : 'Logout'"></span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Aggregated KPI Summary Across ALL Food Courts -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                                    <div class="p-3.5 rounded-lg border text-center transition-all"
                                         :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                                        <span class="text-[11px] text-slate-400 block font-bold" x-text="lang === 'bn' ? 'ðŸª à¦®à§‹à¦Ÿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' : 'Total Food Courts'"></span>
                                        <span class="text-xl font-bold text-amber-400" x-text="ownerAccounts.length + ' à¦Ÿà¦¿'"></span>
                                    </div>
                                    <div class="p-3.5 rounded-lg border text-center transition-all"
                                         :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                                        <span class="text-[11px] text-slate-400 block font-bold" x-text="lang === 'bn' ? 'ðŸ’° à¦¸à¦®à§à¦®à¦¿à¦²à¦¿à¦¤ à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Total Combined Sales'"></span>
                                        <span class="text-xl font-bold text-brand-400" x-text="formatCurrency(getAllFoodCourtsTotalSales())"></span>
                                    </div>
                                    <div class="p-3.5 rounded-lg border text-center transition-all"
                                         :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                                        <span class="text-[11px] text-slate-400 block font-bold" x-text="lang === 'bn' ? 'ðŸ“¦ à¦¸à¦°à§à¦¬à¦®à§‹à¦Ÿ à¦…à¦°à§à¦¡à¦¾à¦°' : 'Total Orders'"></span>
                                        <span class="text-xl font-bold text-cyan-400" x-text="getAllFoodCourtsTotalOrders() + ' à¦Ÿà¦¿'"></span>
                                    </div>
                                    <div class="p-3.5 rounded-lg border text-center transition-all"
                                         :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                                        <span class="text-[11px] text-slate-400 block font-bold" x-text="lang === 'bn' ? 'ðŸ” à¦®à§‹à¦Ÿ à¦–à¦¾à¦¬à¦¾à¦° à¦†à¦‡à¦Ÿà§‡à¦®' : 'Total Food Items'"></span>
                                        <span class="text-xl font-bold text-pink-400" x-text="getAllFoodCourtsTotalItems() + ' à¦Ÿà¦¿'"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Food Courts Management & Stall Cards -->
                            <div class="p-6 sm:p-7 rounded-xl border shadow-2xl transition-all space-y-4"
                                 :class="isDark ? 'glass-panel-dark border-white/[0.08]' : 'bg-white border-slate-200 text-slate-900'">
                                
                                <div class="flex flex-wrap items-center justify-between gap-2 pb-2 border-b"
                                     :class="isDark ? 'border-white/[0.08]' : 'border-slate-200'">
                                    <div>
                                        <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                                            <span>ðŸª</span>
                                            <span x-text="lang === 'bn' ? 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦®à¦¾à¦²à¦¿à¦•à¦¦à§‡à¦° à¦¤à¦¾à¦²à¦¿à¦•à¦¾ à¦“ à¦¸à§à¦Ÿà¦² à¦®à¦¨à¦¿à¦Ÿà¦°' : 'Food Court Owners & Stalls'"></span>
                                            <span class="px-2 py-0.5 rounded-full text-xs font-mono bg-brand-500/20 text-brand-400 border border-brand-500/30" x-text="ownerAccounts.length + ' à¦Ÿà¦¿ à¦¸à§à¦Ÿà¦²'"></span>
                                        </h3>
                                        <p class="text-xs text-slate-400 mt-0.5" x-text="lang === 'bn' ? 'à¦¯à§‡à¦•à§‹à¦¨à§‹ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡à¦° à¦¹à¦¿à¦¸à¦¾à¦¬ à¦¦à§‡à¦–à¦¤à§‡ 'à¦à¦‡ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡ à¦¸à§à¦‡à¦š à¦•à¦°à§à¦¨' à¦¬à¦¾à¦Ÿà¦¨à§‡ à¦šà¦¾à¦ªà§à¦¨' : 'Click Switch to inspect specific stall\'s POS menu and ledger'"></p>
                                    </div>

                                    <!-- Quick Switch to All -->
                                    <button type="button" @click="adminSwitchToOwner('all')" 
                                            class="px-3 py-1.5 rounded-xl border text-xs font-bold cursor-pointer transition-all flex items-center gap-1.5"
                                            :class="adminViewingOwnerId === 'all' ? 'bg-amber-500 text-slate-950 font-bold border-amber-500' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200')">
                                        <span>ðŸŒ</span>
                                        <span x-text="lang === 'bn' ? 'à¦¸à¦•à¦² à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦­à¦¿à¦‰' : 'View All Combined'"></span>
                                        <span x-show="adminViewingOwnerId === 'all'">âœ“</span>
                                    </button>
                                </div>

                                <!-- Owner Cards Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                                    <template x-for="owner in ownerAccounts" :key="owner.id">
                                        <div class="p-4 rounded-lg border transition-all space-y-3 relative group"
                                             :class="[
                                                 adminViewingOwnerId === owner.id ? 'border-brand-500/80 bg-brand-500/10 shadow-neon-brand' : (isDark ? 'bg-obsidian-950/80 border-white/[0.08] hover:border-amber-500/40' : 'bg-slate-50 border-slate-200 hover:border-amber-400')
                                             ]">
                                            
                                            <!-- Top: Stall Title & Stall No -->
                                            <div class="flex items-start justify-between gap-2">
                                                <div class="flex items-center gap-2.5 min-w-0">
                                                    <div class="w-11 h-11 rounded-lg flex items-center justify-center font-bold text-xl flex-shrink-0"
                                                         :class="isDark ? 'bg-zinc-800 text-brand-400 border border-brand-500/30' : 'bg-white text-brand-600 border border-slate-200 shadow-sm'">
                                                        ðŸª
                                                    </div>
                                                    <div class="min-w-0">
                                                        <h4 class="font-bold text-sm text-slate-900 dark:text-white truncate" x-text="owner.shopName"></h4>
                                                        <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                                            <span class="font-bold text-brand-500" x-text="owner.stallNo || 'Stall #01'"></span>
                                                            <span>â€¢</span>
                                                            <span class="truncate" x-text="owner.name"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <span x-show="adminViewingOwnerId === owner.id" 
                                                      class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-brand-500 text-slate-950 shadow-sm" x-text="lang === 'bn' ? 'à¦¸à¦•à§à¦°à¦¿à§Ÿ à¦­à¦¿à¦‰' : 'Active'"></span>
                                            </div>

                                            <!-- Middle: Credentials & Stats -->
                                            <div class="p-2.5 rounded-xl border text-[11px] font-mono space-y-1"
                                                 :class="isDark ? 'bg-zinc-900/60 border-white/[0.06] text-zinc-300' : 'bg-white border-slate-200 text-slate-700'">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-slate-400 font-sans">à¦‡à¦®à§‡à¦‡à¦²:</span>
                                                    <span class="font-bold text-amber-400" x-text="owner.email"></span>
                                                </div>
                                                <div class="flex justify-between items-center">
                                                    <span class="text-slate-400 font-sans">à¦ªà¦¾à¦¸à¦“à§Ÿà¦¾à¦°à§à¦¡:</span>
                                                    <span class="font-bold text-slate-200" x-text="owner.password"></span>
                                                </div>
                                                <div class="flex justify-between items-center pt-1 border-t border-dashed" :class="isDark ? 'border-zinc-800' : 'border-slate-200'">
                                                    <span class="text-slate-400 font-sans">à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à¦¿:</span>
                                                    <span class="font-bold text-brand-400" x-text="formatCurrency(getFoodCourtStats(owner.id).sales)"></span>
                                                </div>
                                            </div>

                                            <!-- Bottom Action Buttons -->
                                            <div class="flex items-center gap-1.5 pt-1">
                                                <!-- Switch to this Food Court -->
                                                <button type="button" @click="adminSwitchToOwner(owner.id); activeTab = 'pos'"
                                                        class="flex-1 py-2 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-sm active:scale-95"
                                                        :class="adminViewingOwnerId === owner.id ? 'bg-brand-500 text-slate-950 font-bold' : 'bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 text-slate-950'">
                                                    <span>ðŸ‘ï¸</span>
                                                    <span x-text="lang === 'bn' ? 'à¦à¦‡ à¦¸à§à¦Ÿà¦²à§‡ à¦¸à§à¦‡à¦š à¦•à¦°à§à¦¨' : 'Switch to Stall'"></span>
                                                </button>

                                                <!-- Edit button -->
                                                <button type="button" @click="openEditOwnerModal(owner)" 
                                                        class="p-2 rounded-xl border text-xs font-bold transition-all cursor-pointer"
                                                        :class="isDark ? 'bg-zinc-800 text-zinc-300 hover:bg-zinc-700 border-zinc-700' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border-slate-200'"
                                                        title="à¦à¦¡à¦¿à¦Ÿ">
                                                    âœï¸
                                                </button>

                                                <!-- Delete button -->
                                                <button type="button" @click="deleteOwner(owner.id)" 
                                                        class="p-2 rounded-xl bg-rose-500/15 hover:bg-rose-500/30 text-rose-400 border border-rose-500/30 text-xs font-bold transition-all cursor-pointer"
                                                        title="à¦®à§à¦›à§à¦¨">
                                                    ðŸ—‘ï¸
                                                </button>
                                            </div>

                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>
                    </template>

                    <!-- ===================================================== -->
                    <!-- B. FOOD COURT OWNER PORTAL (ISOLATED TO OWN STALL)    -->
                    <!-- ===================================================== -->
                    <template x-if="currentUserRole === 'owner'">
                        <div class="p-6 sm:p-8 rounded-xl border shadow-2xl transition-all space-y-6"
                             :class="isDark ? 'glass-panel-dark border-brand-500/30' : 'bg-white border-slate-200 text-slate-900'">
                            
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-brand-400 to-teal-600 text-slate-950 flex items-center justify-center text-3xl font-bold shadow-neon-brand flex-shrink-0">
                                        ðŸª
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white" x-text="adminUser.shopName"></h2>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-500/20 text-brand-400 border border-brand-500/40" x-text="lang === 'bn' ? 'à¦®à¦¾à¦²à¦¿à¦• à¦…à§à¦¯à¦¾à¦•à¦¾à¦‰à¦¨à§à¦Ÿ' : 'Owner Account'"></span>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-0.5 font-mono" x-text="adminUser.name + ' â€¢ ' + adminUser.email"></p>
                                    </div>
                                </div>

                                <button type="button" @click="logoutAdmin()" 
                                        class="px-3.5 py-2 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 border border-rose-500/30 font-bold text-xs flex items-center gap-1 cursor-pointer transition-all">
                                    <span>ðŸšª</span>
                                    <span x-text="lang === 'bn' ? 'à¦²à¦—à¦†à¦‰à¦Ÿ' : 'Logout'"></span>
                                </button>
                            </div>

                            <!-- Privacy Reassurance Banner -->
                            <div class="p-3.5 rounded-lg border flex items-center gap-2.5 text-xs font-semibold"
                                 :class="isDark ? 'bg-brand-500/10 border-brand-500/30 text-brand-300' : 'bg-brand-50 border-brand-200 text-brand-800'">
                                <span class="text-base flex-shrink-0">ðŸ”’</span>
                                <span x-text="lang === 'bn' ? 'à¦¸à§à¦°à¦•à§à¦·à¦¿à¦¤ à¦¤à¦¥à§à¦¯ à¦¨à§€à¦¤à¦¿: à¦†à¦ªà¦¨à¦¿ à¦¶à§à¦§à§à¦®à¦¾à¦¤à§à¦° à¦†à¦ªà¦¨à¦¾à¦° à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡à¦° à¦–à¦¾à¦¦à§à¦¯ à¦†à¦‡à¦Ÿà§‡à¦®, à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¹à¦¿à¦¸à¦¾à¦¬ à¦à¦¬à¦‚ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦¦à§‡à¦–à¦¤à§‡ à¦“ à¦ªà¦°à¦¿à¦šà¦¾à¦²à¦¨à¦¾ à¦•à¦°à¦¤à§‡ à¦ªà¦¾à¦°à¦¬à§‡à¦¨à¥¤' : 'Privacy secured: you can only view and manage your own food court records.'"></span>
                            </div>

                            <!-- Owner Fast Sales Stats -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 p-3 rounded-lg border font-mono"
                                 :class="isDark ? 'bg-obsidian-950 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                                <div class="text-center p-2 rounded-xl" :class="isDark ? 'bg-zinc-900/50' : 'bg-white'">
                                    <span class="text-[10px] font-sans text-slate-400 block font-bold" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Today Total'"></span>
                                    <span class="text-base font-bold text-brand-400" x-text="formatCurrency(todayStats.totalRevenue)"></span>
                                </div>
                                <div class="text-center p-2 rounded-xl" :class="isDark ? 'bg-zinc-900/50' : 'bg-white'">
                                    <span class="text-[10px] font-sans text-slate-400 block font-bold">ðŸ’µ Cash</span>
                                    <span class="text-base font-bold text-brand-500" x-text="formatCurrency(todayStats.cashTotal)"></span>
                                </div>
                                <div class="text-center p-2 rounded-xl" :class="isDark ? 'bg-zinc-900/50' : 'bg-white'">
                                    <span class="text-[10px] font-sans text-slate-400 block font-bold">ðŸŒ¸ bKash</span>
                                    <span class="text-base font-bold text-pink-400" x-text="formatCurrency(todayStats.bkashTotal)"></span>
                                </div>
                                <div class="text-center p-2 rounded-xl" :class="isDark ? 'bg-zinc-900/50' : 'bg-white'">
                                    <span class="text-[10px] font-sans text-slate-400 block font-bold">ðŸŠ Nagad</span>
                                    <span class="text-base font-bold text-amber-400" x-text="formatCurrency(todayStats.nagadTotal)"></span>
                                </div>
                            </div>

                            <!-- Quick Owner Actions -->
                            <div class="space-y-2 pt-2">
                                <button type="button" @click="activeTab = 'pos'" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 text-slate-950 font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md">
                                    <span>ðŸ”</span>
                                    <span x-text="lang === 'bn' ? 'à¦†à¦®à¦¾à¦° à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦®à§‡à¦¨à§à¦¤à§‡ à¦¯à¦¾à¦¨ (Cash, bKash, Nagad à¦¬à¦¿à¦•à§à¦°à¦¿)' : 'Go to POS Menu (Sell with Cash/bKash/Nagad)'"></span>
                                </button>
                                <button type="button" @click="activeTab = 'ledger'" class="w-full py-3 rounded-xl border font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-pointer"
                                        :class="isDark ? 'bg-zinc-800 text-zinc-200 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-800 border-slate-200 hover:bg-slate-200'">
                                    <span>ðŸ“Š</span>
                                    <span x-text="lang === 'bn' ? 'à¦†à¦®à¦¾à¦° à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¹à¦¿à¦¸à¦¾à¦¬ à¦“ à¦®à§‡à¦®à§‹ à¦°à§‡à¦•à¦°à§à¦¡' : 'View Sales Ledger & Memos'"></span>
                                </button>
                                <button type="button" @click="openNewItemModal()" class="w-full py-3 rounded-xl border font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-pointer"
                                        :class="isDark ? 'bg-zinc-800 text-zinc-200 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-800 border-slate-200 hover:bg-slate-200'">
                                    <span>âž•</span>
                                    <span x-text="lang === 'bn' ? 'à¦¨à¦¤à§à¦¨ à¦–à¦¾à¦¬à¦¾à¦° à¦†à¦‡à¦Ÿà§‡à¦® à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'Add New Food Item'"></span>
                                </button>
                            </div>

                        </div>
                    </template>

                </div>
            </template>
        </main>

        <!-- ================================================================= -->
        <!-- FOOTER: COMPANY NAME, ADDRESS, PHONE NUMBER (ONLY THESE 3) -->
        <!-- ================================================================= -->
        <footer class="mt-8 mb-4 p-4 rounded-lg border transition-all text-center flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 text-xs"
                :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08] text-zinc-300' : 'bg-white border-slate-200 text-slate-700 shadow-xs'">
            
            <!-- 1. Company Name -->
            <div class="flex items-center gap-1.5 font-bold text-sm" :class="isDark ? 'text-white' : 'text-slate-900'">
                <span>ðŸª</span>
                <span x-text="posSettings.storeName"></span>
            </div>

            <span class="hidden sm:inline text-slate-400 dark:text-zinc-600">â€¢</span>

            <!-- 2. Address -->
            <div class="flex items-center gap-1.5 text-slate-500 dark:text-zinc-400">
                <span>ðŸ“</span>
                <span x-text="posSettings.address"></span>
            </div>

            <span class="hidden sm:inline text-slate-400 dark:text-zinc-600">â€¢</span>

            <!-- 3. Phone Number -->
            <div class="flex items-center gap-1.5 font-mono font-bold text-brand-500 dark:text-brand-400">
                <span>ðŸ“ž</span>
                <a :href="'tel:' + posSettings.hotline.replace(/\s+/g, '')" class="hover:underline" x-text="posSettings.hotline"></a>
            </div>

            <span class="hidden sm:inline text-slate-400 dark:text-zinc-600">â€¢</span>

            <!-- 4. APK Download -->
            <div class="flex items-center">
                <a href="./FoodCourtPOS.apk" download="FoodCourtPOS.apk" 
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-500/10 hover:bg-brand-500/20 text-brand-600 dark:text-brand-400 border border-brand-500/20 text-[10px] font-bold uppercase tracking-wide cursor-pointer transition-all active:scale-95 shadow-sm transform-gpu">
                    <span class="text-xs">â¬‡ï¸</span>
                    <span x-text="lang === 'bn' ? 'à¦…à¦«à¦²à¦¾à¦‡à¦¨ à¦…à§à¦¯à¦¾à¦ª (APK)' : 'Offline App (APK)'"></span>
                </a>
            </div>

        </footer>

        <!-- ================================================================= -->
        <!-- STICKY QUICK MOBILE CHECKOUT DOCK (Frictionless 1-Tap Record) -->
        <!-- ================================================================= -->
        <div x-show="cart.length > 0 && activeTab === 'pos' && posSubTab === 'menu'" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="z-40 p-2.5 rounded-lg border shadow-2xl backdrop-blur-xl transition-all space-y-2"
             :class="[
                 viewMode === 'mobile' ? 'mobile-sticky-cart fixed bottom-20 inset-x-3 max-w-lg mx-auto' : 'mobile-sticky-cart fixed bottom-20 inset-x-4 max-w-2xl mx-auto',
                 isDark ? 'bg-obsidian-950/95 border-brand-500/60 shadow-brand-950/50 text-white' : 'bg-white/95 border-brand-500/50 shadow-brand-500/20 text-slate-900'
             ]">
            
            <!-- Quick Summary & Payment Switcher -->
            <div class="flex items-center justify-between gap-2 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-brand-500 text-slate-950 flex items-center justify-center font-bold text-xs shadow-xs">
                        ðŸ›’
                    </div>
                    <div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-[11px] text-slate-400 font-sans" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦²:' : 'Bill:'"></span>
                            <span class="font-mono font-bold text-base text-brand-500 dark:text-brand-400" x-text="formatCurrency(calculatedGrandTotal)"></span>
                        </div>
                        <span class="text-[10px] text-slate-400 block font-mono" x-text="cart.reduce((s, i) => s + i.quantity, 0) + ' ' + (lang === 'bn' ? 'à¦Ÿà¦¿ à¦†à¦‡à¦Ÿà§‡à¦®' : 'items')"></span>
                    </div>
                </div>

                <!-- Instant Payment Selector -->
                <div class="flex items-center gap-1 p-0.5 rounded-xl border text-[11px] font-bold"
                     :class="isDark ? 'bg-obsidian-900 border-white/[0.08]' : 'bg-slate-100 border-slate-200'">
                    <button @click="paymentMethod = 'Cash'" 
                            :class="paymentMethod === 'Cash' ? 'bg-brand-500 text-slate-950 shadow-xs' : 'text-slate-400'"
                            class="px-2 py-1 rounded-lg transition-all cursor-pointer">
                        à¦•à§à¦¯à¦¾à¦¶
                    </button>
                    <button @click="paymentMethod = 'bKash'" 
                            :class="paymentMethod === 'bKash' ? 'bg-[#E2136E] text-white shadow-xs' : 'text-slate-400'"
                            class="px-2 py-1 rounded-lg transition-all cursor-pointer">
                        bKash
                    </button>
                    <button @click="paymentMethod = 'Nagad'" 
                            :class="paymentMethod === 'Nagad' ? 'bg-[#F7941D] text-white shadow-xs' : 'text-slate-400'"
                            class="px-2 py-1 rounded-lg transition-all cursor-pointer">
                        Nagad
                    </button>
                </div>
            </div>

            <!-- Direct 1-Tap Record Button & Details Trigger -->
            <div class="flex items-center gap-1.5">
                <button @click="submitOrder()" 
                        class="flex-1 py-3 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 text-slate-950 font-bold text-sm shadow-lg shadow-brand-500/25 active:scale-98 transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                    <span>âœ…</span>
                    <span x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡ à¦•à¦°à§à¦¨ (' + formatCurrency(calculatedGrandTotal) + ')' : 'Record Sale (' + formatCurrency(calculatedGrandTotal) + ')'"></span>
                </button>
                
                <button @click="showMobileCartSheet = true" 
                        title="à¦¬à¦¿à¦¸à§à¦¤à¦¾à¦°à¦¿à¦¤ à¦¬à¦¾ à¦•à§à¦¯à¦¾à¦¶ à¦¹à¦¿à¦¸à¦¾à¦¬"
                        class="px-3 py-3 rounded-xl border text-xs font-bold transition-all flex items-center justify-center cursor-pointer"
                        :class="isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'">
                    <span>âš™ï¸</span>
                </button>
            </div>
        </div>



        <!-- ================================================================= -->
        <!-- ULTRA-STYLISH FLOATING NAVIGATION DOCK (Responsive & Premium) -->
        <!-- ================================================================= -->
        <nav class="mobile-bottom-dock fixed bottom-3 inset-x-3 transition-all duration-300 z-40"
             :class="viewMode === 'mobile' ? 'max-w-lg mx-auto' : 'max-w-2xl mx-auto'">
            
            <div class="p-2 rounded-lg border shadow-2xl backdrop-blur-2xl flex items-center justify-between gap-1.5 transition-all"
                 :class="isDark ? 'bg-obsidian-950/90 border-white/[0.1] text-white shadow-black/60 shadow-neon-brand/20' : 'bg-white/95 border-slate-200/95 text-slate-900 shadow-slate-300/60'">
                
                <!-- 1. Menu (POS) Button -->
                <button type="button" @click="activeTab = 'pos'; playChime(440)" 
                        class="flex-1 py-2.5 px-2 rounded-xl flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 text-[11px] font-bold transition-all cursor-pointer group active:scale-95"
                        :class="activeTab === 'pos' 
                            ? 'bg-gradient-to-r from-brand-500 to-teal-600 text-slate-950 shadow-md shadow-brand-500/30 ring-1 ring-brand-400/50 scale-[1.02]' 
                            : (isDark ? 'text-zinc-400 hover:text-white hover:bg-white/[0.06] opacity-60 hover:opacity-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100 opacity-60 hover:opacity-100')">
                    <span class="text-lg leading-none transition-transform group-hover:scale-110">ðŸ”</span>
                    <span class="tracking-wide" x-text="lang === 'bn' ? 'à¦®à§‡à¦¨à§' : 'Menu'"></span>
                </button>

                <!-- 2. Sales Ledger Button -->
                <button type="button" @click="activeTab = 'ledger'; ledgerViewMode = 'memos'; playChime(550)" 
                        class="flex-1 py-2.5 px-2 rounded-xl flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 text-[11px] font-bold transition-all cursor-pointer group active:scale-95 relative"
                        :class="activeTab === 'ledger' && ledgerViewMode !== 'raw_costs' 
                            ? 'bg-gradient-to-r from-brand-500 to-teal-600 text-slate-950 shadow-md shadow-brand-500/30 ring-1 ring-brand-400/50 scale-[1.02]' 
                            : (isDark ? 'text-zinc-400 hover:text-white hover:bg-white/[0.06] opacity-60 hover:opacity-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100 opacity-60 hover:opacity-100')">
                    <span class="text-lg leading-none transition-transform group-hover:scale-110">ðŸ“Š</span>
                    <span class="tracking-wide" x-text="lang === 'bn' ? 'à¦–à¦¤à¦¿à§Ÿà¦¾à¦¨' : 'Ledger'"></span>
                    <span x-show="todayStats.totalOrders > 0" 
                          class="absolute -top-1 -right-1 px-1.5 py-0.2 rounded-full font-mono font-bold text-[9px] shadow-sm animate-pulse"
                          :class="activeTab === 'ledger' && ledgerViewMode !== 'raw_costs' ? 'bg-slate-950 text-brand-400 border border-brand-400' : 'bg-brand-500 text-slate-950'" 
                          x-text="todayStats.totalOrders"></span>
                </button>

                <!-- 3. Raw Costs Button -->
                <button type="button" @click="activeTab = 'ledger'; ledgerViewMode = 'raw_costs'; playChime(600)" 
                        class="flex-1 py-2.5 px-2 rounded-xl flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 text-[11px] font-bold transition-all cursor-pointer group active:scale-95"
                        :class="activeTab === 'ledger' && ledgerViewMode === 'raw_costs' 
                            ? 'bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-md shadow-amber-500/30 ring-1 ring-amber-300 scale-[1.02]' 
                            : (isDark ? 'text-zinc-400 hover:text-white hover:bg-white/[0.06] opacity-60 hover:opacity-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100 opacity-60 hover:opacity-100')">
                    <span class="text-lg leading-none transition-transform group-hover:scale-110">ðŸ¥©</span>
                    <span class="tracking-wide" x-text="lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦²' : 'Raw Cost'"></span>
                </button>

                <!-- 4. Admin / Owners Hub Button -->
                <button type="button" @click="activeTab = 'login'; playChime(500)" 
                        class="flex-1 py-2.5 px-2 rounded-xl flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 text-[11px] font-bold transition-all cursor-pointer group active:scale-95"
                        :class="activeTab === 'login' 
                            ? 'bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-md shadow-amber-500/30 ring-1 ring-amber-300 scale-[1.02]' 
                            : (isDark ? 'text-zinc-400 hover:text-white hover:bg-white/[0.06] opacity-60 hover:opacity-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100 opacity-60 hover:opacity-100')">
                    <span class="text-lg leading-none transition-transform group-hover:scale-110" x-text="isAdminLoggedIn ? (currentUserRole === 'superadmin' ? 'ðŸ‘‘' : 'ðŸª') : 'ðŸ”'"></span>
                    <span class="tracking-wide" x-text="isAdminLoggedIn ? (currentUserRole === 'superadmin' ? (lang === 'bn' ? 'à¦¹à¦¾à¦¬' : 'Hub') : (lang === 'bn' ? 'à¦ªà§à¦°à§‹à¦«à¦¾à¦‡à¦²' : 'Profile')) : (lang === 'bn' ? 'à¦²à¦—à¦‡à¦¨' : 'Login')"></span>
                </button>

            </div>
        </nav>

                <!-- ================================================================= -->
        <!-- MODAL: OPEN COURT (Start Daily Session) -->
        <!-- ================================================================= -->
        <div x-show="showOpenCourtModal" 
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-black/80 backdrop-blur-xl"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <div class="w-full max-w-md rounded-xl border shadow-2xl p-5 sm:p-7 space-y-4"
                 :class="isDark ? 'glass-panel-dark border-brand-500/40 text-white' : 'bg-white border-slate-200 text-slate-900'"
                 @click.outside="showOpenCourtModal = false">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-lg bg-brand-500/20 text-brand-400 border border-brand-500/30 flex items-center justify-center text-xl font-bold shadow-neon-brand">
                            ðŸŸ¢
                        </div>
                        <div>
                            <h3 class="font-bold text-base" x-text="lang === 'bn' ? 'à¦“à¦ªà§‡à¦¨ à¦•à¦¾à¦°à§à¦Ÿ (à¦¦à¦¿à¦¨ à¦¶à§à¦°à§)' : 'Open Cart (Start Day)'"></h3>
                            <p class="text-[11px] text-slate-400" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¸à§‡à¦¶à¦¨ à¦“ à¦•à§à¦¯à¦¾à¦¶ à¦¡à§à¦°à§Ÿà¦¾à¦° à¦¸à¦•à§à¦°à¦¿à§Ÿ à¦•à¦°à§à¦¨' : 'Activate daily register and begin selling'"></p>
                        </div>
                    </div>
                    <button type="button" @click="showOpenCourtModal = false" class="p-1.5 rounded-xl text-slate-400 hover:text-white bg-zinc-800 text-xs cursor-pointer">âœ•</button>
                </div>

                <!-- Active Food Court & Date Overview -->
                <div class="p-3.5 rounded-lg border text-xs font-mono space-y-1.5"
                     :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08] text-zinc-300' : 'bg-slate-50 border-slate-200 text-slate-700'">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-sans font-bold" x-text="lang === 'bn' ? 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦¸à§à¦Ÿà¦²:' : 'Stall Name:'"></span>
                        <span class="font-bold text-brand-400 text-sm" x-text="getActiveFoodCourtTitle()"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-sans font-bold" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¸à¦®à§Ÿ:' : 'Current Time:'"></span>
                        <span class="font-bold text-amber-400" x-text="currentDhakaTime"></span>
                    </div>
                </div>

                <!-- Opening Cash Float Form -->
                <div class="space-y-3 text-xs">
                    <div>
                        <label class="font-bold block mb-1" :class="isDark ? 'text-zinc-300' : 'text-slate-700'">
                            <span x-text="lang === 'bn' ? 'à¦“à¦ªà§‡à¦¨à¦¿à¦‚ à¦•à§à¦¯à¦¾à¦¶ à¦¡à§à¦°à§Ÿà¦¾à¦° à¦¬à§à¦¯à¦¾à¦²à§‡à¦¨à§à¦¸ (Opening Float à§³):' : 'Opening Cash Float (à§³):'"></span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 font-bold text-brand-500 text-sm">à§³</span>
                            <input type="number" min="0" step="50" x-model.number="openCourtForm.openingFloat" placeholder="0"
                                   class="w-full pl-8 pr-4 py-2.5 rounded-xl border focus:outline-none font-mono text-sm font-bold"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1" x-text="lang === 'bn' ? 'à¦¸à¦•à¦¾à¦²à§‡ à¦•à§à¦¯à¦¾à¦¶ à¦¬à¦¾à¦•à§à¦¸à§‡ à¦¥à¦¾à¦•à¦¾ à¦–à§à¦šà¦°à¦¾ à¦Ÿà¦¾à¦•à¦¾à¦° à¦ªà¦°à¦¿à¦®à¦¾à¦£ (à¦à¦šà§à¦›à¦¿à¦•)' : 'Starting cash in register (optional)'"></p>
                    </div>

                    <div>
                        <label class="font-bold block mb-1" :class="isDark ? 'text-zinc-300' : 'text-slate-700'" x-text="lang === 'bn' ? 'à¦¸à§‡à¦¶à¦¨ à¦¨à§‹à¦Ÿ (à¦à¦šà§à¦›à¦¿à¦•):' : 'Session Note (Optional):'"></label>
                        <input type="text" x-model="openCourtForm.note" placeholder="à¦¯à§‡à¦®à¦¨: à¦¸à¦•à¦¾à¦²à§‡à¦° à¦¶à¦¿à¦«à¦Ÿ"
                               class="w-full px-3.5 py-2.5 rounded-xl border focus:outline-none text-xs"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-2 pt-2 border-t" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <button type="button" @click="showOpenCourtModal = false"
                            class="flex-1 py-3 rounded-xl border font-bold text-xs cursor-pointer transition-all"
                            :class="isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                            x-text="lang === 'bn' ? 'à¦¬à¦¾à¦¤à¦¿à¦²' : 'Cancel'">
                    </button>
                    <button type="button" @click="confirmOpenCourt()"
                            class="flex-1 py-3 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 text-slate-950 font-bold text-xs shadow-lg shadow-brand-500/25 cursor-pointer active:scale-95 transition-all flex items-center justify-center gap-1.5">
                        <span>âœ“</span>
                        <span x-text="lang === 'bn' ? 'à¦“à¦ªà§‡à¦¨ à¦•à¦¾à¦°à§à¦Ÿ à¦•à¦°à§à¦¨ à¦“ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¶à§à¦°à§' : 'Open Cart & Start'"></span>
                    </button>
                </div>

            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL: CLOSE COURT & Z-REPORT (End Business Day Session) -->
        <!-- ================================================================= -->
        <div x-show="showCloseCourtModal" 
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-black/80 backdrop-blur-xl"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <div class="w-full max-w-lg rounded-xl border shadow-2xl p-5 sm:p-7 space-y-4 max-h-[90vh] overflow-y-auto"
                 :class="isDark ? 'glass-panel-dark border-rose-500/40 text-white' : 'bg-white border-slate-200 text-slate-900'"
                 @click.outside="showCloseCourtModal = false">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-3 border-b" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-lg bg-rose-500/20 text-rose-400 border border-rose-500/30 flex items-center justify-center text-xl font-bold shadow-md">
                            ðŸ
                        </div>
                        <div>
                            <h3 class="font-bold text-base" x-text="lang === 'bn' ? 'à¦•à§à¦²à§‹à¦œ à¦•à¦¾à¦°à§à¦Ÿ à¦“ à¦¦à¦¿à¦¨ à¦¸à¦®à¦¾à¦ªà§à¦¤ (Z-Report)' : 'Close Cart & Day End (Z-Report)'"></h3>
                            <p class="text-[11px] text-slate-400" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦¸à¦®à¦¾à¦ªà§à¦¤à¦¿ à¦“ à¦†à¦°à§à¦¥à¦¿à¦• à¦¸à¦®à¦¨à§à¦¬à§Ÿ à¦–à¦¤à¦¿à§Ÿà¦¾à¦¨' : 'Reconcile daily revenues and finalize day'"></p>
                        </div>
                    </div>
                    <button type="button" @click="showCloseCourtModal = false" class="p-1.5 rounded-xl text-slate-400 hover:text-white bg-zinc-800 text-xs cursor-pointer">âœ•</button>
                </div>

                <!-- Shift Details Header -->
                <div class="p-3.5 rounded-lg border text-xs font-mono space-y-1.5"
                     :class="isDark ? 'bg-obsidian-950/80 border-white/[0.08] text-zinc-300' : 'bg-slate-50 border-slate-200 text-slate-700'">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-sans font-bold" x-text="lang === 'bn' ? 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦¸à§à¦Ÿà¦²:' : 'Stall Name:'"></span>
                        <span class="font-bold text-amber-400 text-sm" x-text="getActiveFoodCourtTitle()"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-sans font-bold" x-text="lang === 'bn' ? 'à¦“à¦ªà§‡à¦¨à¦¿à¦‚ à¦¸à¦®à§Ÿ:' : 'Opening Time:'"></span>
                        <span class="font-bold text-brand-400" x-text="courtSession.openedAt || 'à¦†à¦œ à¦¸à¦•à¦¾à¦²'"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-sans font-bold" x-text="lang === 'bn' ? 'à¦•à§à¦²à§‹à¦œà¦¿à¦‚ à¦¸à¦®à§Ÿ:' : 'Closing Time:'"></span>
                        <span class="font-bold text-rose-400" x-text="currentDhakaTime"></span>
                    </div>
                </div>

                <!-- Live Z-Report Financial Breakdown Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 font-mono text-xs">
                    <div class="p-2.5 rounded-lg border text-center" :class="isDark ? 'bg-zinc-900/80 border-white/[0.06]' : 'bg-slate-50 border-slate-200'">
                        <span class="text-[10px] text-slate-400 font-sans font-bold block" x-text="lang === 'bn' ? 'ðŸ’° à¦®à§‹à¦Ÿ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Gross Sales'"></span>
                        <span class="text-base font-bold text-brand-400" x-text="formatCurrency(todayStats.totalRevenue)"></span>
                    </div>
                    <div class="p-2.5 rounded-lg border text-center" :class="isDark ? 'bg-zinc-900/80 border-white/[0.06]' : 'bg-slate-50 border-slate-200'">
                        <span class="text-[10px] text-slate-400 font-sans font-bold block" x-text="lang === 'bn' ? 'ðŸ’µ à¦•à§à¦¯à¦¾à¦¶ à¦¬à¦¿à¦•à§à¦°à¦¿' : 'Cash Total'"></span>
                        <span class="text-base font-bold text-brand-500" x-text="formatCurrency(todayStats.cashTotal)"></span>
                    </div>
                    <div class="p-2.5 rounded-lg border text-center" :class="isDark ? 'bg-zinc-900/80 border-white/[0.06]' : 'bg-slate-50 border-slate-200'">
                        <span class="text-[10px] text-slate-400 font-sans font-bold block" x-text="lang === 'bn' ? 'ðŸŒ¸ bKash' : 'bKash Total'"></span>
                        <span class="text-base font-bold text-pink-400" x-text="formatCurrency(todayStats.bkashTotal)"></span>
                    </div>
                    <div class="p-2.5 rounded-lg border text-center" :class="isDark ? 'bg-zinc-900/80 border-white/[0.06]' : 'bg-slate-50 border-slate-200'">
                        <span class="text-[10px] text-slate-400 font-sans font-bold block" x-text="lang === 'bn' ? 'ðŸŠ Nagad' : 'Nagad Total'"></span>
                        <span class="text-base font-bold text-amber-400" x-text="formatCurrency(todayStats.nagadTotal)"></span>
                    </div>
                    <div class="p-2.5 rounded-lg border text-center" :class="isDark ? 'bg-zinc-900/80 border-white/[0.06]' : 'bg-slate-50 border-slate-200'">
                        <span class="text-[10px] text-slate-400 font-sans font-bold block" x-text="lang === 'bn' ? 'ðŸ“¦ à¦®à§‹à¦Ÿ à¦…à¦°à§à¦¡à¦¾à¦°' : 'Total Orders'"></span>
                        <span class="text-base font-bold text-cyan-400" x-text="todayStats.totalOrders + ' à¦Ÿà¦¿'"></span>
                    </div>
                    <div class="p-2.5 rounded-lg border text-center" :class="isDark ? 'bg-zinc-900/80 border-white/[0.06]' : 'bg-slate-50 border-slate-200'">
                        <span class="text-[10px] text-slate-400 font-sans font-bold block" x-text="lang === 'bn' ? 'ðŸ“ˆ à¦¨à¦¿à¦Ÿ à¦²à¦¾à¦­' : 'Net Profit'"></span>
                        <span class="text-base font-bold text-teal-400" x-text="formatCurrency(todayStats.todayNetProfit)"></span>
                    </div>
                </div>

                <!-- Cash Drawer Reconciliation Summary -->
                <div class="p-3.5 rounded-lg border text-xs space-y-1.5"
                     :class="isDark ? 'bg-zinc-900/60 border-zinc-800' : 'bg-slate-50 border-slate-200'">
                    <div class="flex justify-between font-mono">
                        <span class="text-slate-400 font-sans" x-text="lang === 'bn' ? 'à¦¸à¦•à¦¾à¦²à§‡ à¦•à§à¦¯à¦¾à¦¶ à¦¡à§à¦°à§Ÿà¦¾à¦° (Float):' : 'Starting Float:'"></span>
                        <span class="font-bold text-slate-300" x-text="formatCurrency(courtSession.openingFloat || 0)"></span>
                    </div>
                    <div class="flex justify-between font-mono">
                        <span class="text-slate-400 font-sans" x-text="lang === 'bn' ? 'à¦†à¦œà¦•à§‡à¦° à¦•à§à¦¯à¦¾à¦¶ à¦•à¦¾à¦²à§‡à¦•à¦¶à¦¨:' : 'Today Cash Sales:'"></span>
                        <span class="font-bold text-brand-400" x-text="'+' + formatCurrency(todayStats.cashTotal)"></span>
                    </div>
                    <div class="pt-2 border-t flex justify-between font-mono font-bold text-sm"
                         :class="isDark ? 'border-zinc-800 text-white' : 'border-slate-200 text-slate-900'">
                        <span class="font-sans" x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦¶ à¦¬à¦¾à¦•à§à¦¸à§‡ à¦®à§‹à¦Ÿ à¦¥à¦¾à¦•à¦¾ à¦‰à¦šà¦¿à¦¤:' : 'Expected Cash in Drawer:'"></span>
                        <span class="text-amber-400 text-base" x-text="formatCurrency((Number(courtSession.openingFloat) || 0) + todayStats.cashTotal)"></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2 pt-2 border-t" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <button type="button" @click="confirmCloseCourt()"
                            class="w-full py-3.5 rounded-lg bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-500 text-white font-bold text-sm shadow-xl shadow-rose-500/30 cursor-pointer active:scale-95 transition-all flex items-center justify-center gap-2">
                        <span>ðŸ</span>
                        <span x-text="lang === 'bn' ? 'âœ“ à¦¨à¦¿à¦¶à§à¦šà¦¿à¦¤: à¦¦à¦¿à¦¨ à¦¸à¦®à¦¾à¦ªà§à¦¤ à¦“ à¦•à¦¾à¦°à§à¦Ÿ à¦•à§à¦²à§‹à¦œ à¦•à¦°à§à¦¨' : 'Confirm: Close Cart & End Day'"></span>
                    </button>
                    
                    <div class="flex items-center gap-2">
                        <button type="button" @click="printZReport()"
                                class="flex-1 py-2.5 rounded-xl border font-bold text-xs cursor-pointer transition-all flex items-center justify-center gap-1.5"
                                :class="isDark ? 'bg-zinc-800 text-zinc-200 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-800 border-slate-200 hover:bg-slate-200'">
                            <span>ðŸ–¨ï¸</span>
                            <span x-text="lang === 'bn' ? 'Z-Report à¦ªà§à¦°à¦¿à¦¨à§à¦Ÿ' : 'Print Z-Report'"></span>
                        </button>
                        <button type="button" @click="showCloseCourtModal = false"
                                class="flex-1 py-2.5 rounded-xl border font-bold text-xs cursor-pointer transition-all"
                                :class="isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'"
                                x-text="lang === 'bn' ? 'à¦¬à¦¾à¦¤à¦¿à¦²' : 'Cancel'">
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL: MOBILE CART BOTTOM SHEET (showMobileCartSheet) -->
        <!-- ================================================================= -->
        <div x-show="showMobileCartSheet" 
             class="fixed inset-0 z-[70] flex items-end justify-center bg-black/80 backdrop-blur-xl"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-full"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-full">

            <div class="w-full max-w-lg rounded-t-[32px] border-t border-x shadow-2xl p-5 sm:p-6 space-y-4 max-h-[88vh] overflow-y-auto"
                 :class="isDark ? 'glass-panel-dark border-brand-500/40 text-white' : 'bg-white border-slate-200 text-slate-900'"
                 @click.outside="showMobileCartSheet = false">

                <!-- Drawer Pull Bar & Header -->
                <div class="text-center space-y-2 pb-2 border-b" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <div class="w-12 h-1.5 rounded-full bg-zinc-600 mx-auto"></div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-left">
                            <span class="text-xl">ðŸ›’</span>
                            <div>
                                <h3 class="font-bold text-sm sm:text-base" x-text="lang === 'bn' ? 'à¦†à¦ªà¦¨à¦¾à¦° à¦–à¦¾à¦¬à¦¾à¦° à¦•à¦¾à¦°à§à¦Ÿ' : 'Your Food Cart'"></h3>
                                <p class="text-[10px] text-slate-400 font-mono" x-text="cart.reduce((s, i) => s + i.quantity, 0) + ' ' + (lang === 'bn' ? 'à¦Ÿà¦¿ à¦†à¦‡à¦Ÿà§‡à¦® à¦¸à¦¿à¦²à§‡à¦•à§à¦Ÿà§‡à¦¡' : 'items selected')"></p>
                            </div>
                        </div>
                        <button type="button" @click="showMobileCartSheet = false" class="p-1.5 rounded-xl text-slate-400 hover:text-white bg-zinc-800 text-xs cursor-pointer">âœ•</button>
                    </div>
                </div>

                <!-- Empty Cart Notice -->
                <div x-show="cart.length === 0" class="py-8 text-center text-slate-400 text-xs">
                    <span class="text-3xl block mb-2">ðŸ›ï¸</span>
                    <p x-text="lang === 'bn' ? 'à¦†à¦ªà¦¨à¦¾à¦° à¦•à¦¾à¦°à§à¦Ÿ à¦¬à¦°à§à¦¤à¦®à¦¾à¦¨à§‡ à¦–à¦¾à¦²à¦¿' : 'Cart is empty'"></p>
                </div>

                <!-- Cart Items List -->
                <div x-show="cart.length > 0" class="space-y-2 max-h-60 overflow-y-auto pr-1">
                    <template x-for="item in cart" :key="item.id">
                        <div class="p-3 rounded-lg border flex items-center justify-between gap-2"
                             :class="isDark ? 'bg-obsidian-950/80 border-white/[0.06]' : 'bg-slate-50 border-slate-200'">
                            <div class="min-w-0 flex-1">
                                <h5 class="font-bold text-xs truncate" x-text="item.nameBn || item.name"></h5>
                                <span class="text-[11px] font-mono text-brand-500" x-text="'à§³' + item.price + ' Ã— ' + item.quantity + ' = à§³' + (item.price * item.quantity)"></span>
                            </div>
                            <div class="flex items-center gap-1.5 flex-shrink-0">
                                <button type="button" @click="decrementCart(item.id)" 
                                        class="w-7 h-7 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-white font-bold text-sm flex items-center justify-center cursor-pointer active:scale-95">-</button>
                                <span class="w-6 text-center font-mono font-bold text-xs" x-text="item.quantity"></span>
                                <button type="button" @click="incrementCart(item.id)" 
                                        class="w-7 h-7 rounded-xl bg-brand-500 hover:bg-brand-400 text-slate-950 font-bold text-sm flex items-center justify-center cursor-pointer active:scale-95">+</button>
                                <button type="button" @click="removeFromCart(item.id)" 
                                        class="w-7 h-7 rounded-xl bg-rose-500/20 text-rose-400 font-bold text-xs flex items-center justify-center cursor-pointer ml-1">ðŸ—‘ï¸</button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Payment Switcher -->
                <div x-show="cart.length > 0" class="space-y-1.5 pt-2 border-t" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <label class="text-[11px] font-bold text-slate-400 block" x-text="lang === 'bn' ? 'à¦ªà§‡à¦®à§‡à¦¨à§à¦Ÿ à¦®à¦¾à¦§à§à¦¯à¦® à¦¨à¦¿à¦°à§à¦¬à¦¾à¦šà¦¨ à¦•à¦°à§à¦¨:' : 'Select Payment Method:'"></label>
                    <div class="grid grid-cols-3 gap-2 text-xs font-bold">
                        <button type="button" @click="paymentMethod = 'Cash'" 
                                :class="paymentMethod === 'Cash' ? 'bg-brand-500 text-slate-950 shadow-md font-bold' : (isDark ? 'bg-zinc-800 text-zinc-300' : 'bg-slate-100 text-slate-700')"
                                class="py-2.5 rounded-xl border border-transparent transition-all cursor-pointer text-center">
                            ðŸ’µ à¦•à§à¦¯à¦¾à¦¶
                        </button>
                        <button type="button" @click="paymentMethod = 'bKash'" 
                                :class="paymentMethod === 'bKash' ? 'bg-[#E2136E] text-white shadow-md font-bold' : (isDark ? 'bg-zinc-800 text-zinc-300' : 'bg-slate-100 text-slate-700')"
                                class="py-2.5 rounded-xl border border-transparent transition-all cursor-pointer text-center">
                            ðŸŒ¸ bKash
                        </button>
                        <button type="button" @click="paymentMethod = 'Nagad'" 
                                :class="paymentMethod === 'Nagad' ? 'bg-[#F7941D] text-white shadow-md font-bold' : (isDark ? 'bg-zinc-800 text-zinc-300' : 'bg-slate-100 text-slate-700')"
                                class="py-2.5 rounded-xl border border-transparent transition-all cursor-pointer text-center">
                            ðŸŠ Nagad
                        </button>
                    </div>
                </div>

                <!-- Order Total Summary & Submit -->
                <div x-show="cart.length > 0" class="space-y-3 pt-2">
                    <div class="p-3.5 rounded-lg border font-mono flex items-center justify-between"
                         :class="isDark ? 'bg-obsidian-950 border-brand-500/30' : 'bg-brand-50 border-brand-200'">
                        <span class="text-xs font-sans font-bold" x-text="lang === 'bn' ? 'à¦¸à¦°à§à¦¬à¦®à§‹à¦Ÿ à¦ªà§à¦°à¦¦à§‡à§Ÿ à¦¬à¦¿à¦²:' : 'Total Payable:'"></span>
                        <span class="text-lg font-bold text-brand-400" x-text="formatCurrency(calculatedGrandTotal)"></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="clearCart(); showMobileCartSheet = false" 
                                class="px-4 py-3 rounded-lg border font-bold text-xs text-rose-400 border-rose-500/30 bg-rose-500/10 cursor-pointer">
                            à¦®à§à¦›à§à¦¨
                        </button>
                        <button type="button" @click="submitOrder(); showMobileCartSheet = false" 
                                class="flex-1 py-3.5 rounded-lg bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 text-slate-950 font-bold text-sm shadow-xl shadow-brand-500/30 cursor-pointer active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span>âœ…</span>
                            <span x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡ à¦•à¦°à§à¦¨ (' + formatCurrency(calculatedGrandTotal) + ')' : 'Record Sale (' + formatCurrency(calculatedGrandTotal) + ')'"></span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL: ADD / EDIT FOODCOURT OWNER (Super Admin Only) -->
        <!-- ================================================================= -->
        <div x-show="showAddOwnerModal"
             class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/80 backdrop-blur-xl"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <div class="w-full max-w-md rounded-xl border shadow-2xl p-5 sm:p-7 space-y-4 max-h-[90vh] overflow-y-auto"
                 :class="isDark ? 'glass-panel-dark border-brand-500/30' : 'bg-white border-slate-200'"
                 @click.outside="showAddOwnerModal = false">

                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center text-base font-bold">ðŸª</div>
                        <div>
                            <h3 class="font-bold text-sm text-slate-900 dark:text-white"
                                x-text="ownerFormMode === 'add' ? 'à¦¨à¦¤à§à¦¨ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦®à¦¾à¦²à¦¿à¦• à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'à¦®à¦¾à¦²à¦¿à¦•à§‡à¦° à¦¤à¦¥à§à¦¯ à¦¸à¦®à§à¦ªà¦¾à¦¦à¦¨à¦¾ à¦•à¦°à§à¦¨'"></h3>
                            <p class="text-[10px] text-slate-400" x-text="ownerFormMode === 'add' ? 'à¦¨à¦¤à§à¦¨ à¦®à¦¾à¦²à¦¿à¦•à§‡à¦° à¦²à¦—à¦‡à¦¨ à¦¤à¦¥à§à¦¯ à¦¸à§‡à¦Ÿ à¦•à¦°à§à¦¨' : 'à¦®à¦¾à¦²à¦¿à¦•à§‡à¦° à¦¤à¦¥à§à¦¯ à¦ªà¦°à¦¿à¦¬à¦°à§à¦¤à¦¨ à¦•à¦°à§à¦¨'"></p>
                        </div>
                    </div>
                    <button @click="showAddOwnerModal = false" class="p-1 rounded-lg text-slate-400 hover:text-white cursor-pointer">âœ•</button>
                </div>

                <!-- Error / Success alerts -->
                <div x-show="ownerFormError" x-cloak class="p-3 rounded-xl bg-rose-500/15 border border-rose-500/40 text-rose-400 text-xs font-bold" x-text="ownerFormError"></div>
                <div x-show="ownerFormSuccess" x-cloak class="p-3 rounded-xl bg-brand-500/15 border border-brand-500/40 text-brand-400 text-xs font-bold" x-text="ownerFormSuccess"></div>

                <!-- Form -->
                <div class="space-y-3 text-xs">
                    <!-- Full Name -->
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦®à¦¾à¦²à¦¿à¦•à§‡à¦° à¦ªà§‚à¦°à§à¦£ à¦¨à¦¾à¦® *' : 'Owner Full Name *'"></label>
                        <input type="text" x-model="ownerForm.name" placeholder="à¦¯à§‡à¦®à¦¨: à¦°à¦¹à¦¿à¦® à¦–à¦¾à¦¨"
                               class="w-full px-3 py-2.5 rounded-xl border focus:outline-none transition-all font-medium"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                    </div>

                    <!-- Shop / Foodcourt Name -->
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡à¦° à¦¨à¦¾à¦® *' : 'Food Cart Name *'"></label>
                        <input type="text" x-model="ownerForm.shopName" placeholder="à¦¯à§‡à¦®à¦¨: à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦•à¦¿à¦‚à¦¡à¦® à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ"
                               class="w-full px-3 py-2.5 rounded-xl border focus:outline-none transition-all font-medium"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦¸à§à¦Ÿà¦² à¦¨à¦®à§à¦¬à¦°' : 'Stall Number'"></label>
                            <input type="text" x-model="ownerForm.stallNo" placeholder="Stall #03"
                                   class="w-full px-3 py-2.5 rounded-xl border focus:outline-none font-mono"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦«à§‹à¦¨ à¦¨à¦®à§à¦¬à¦°' : 'Phone Number'"></label>
                            <input type="text" x-model="ownerForm.phone" placeholder="+880 1711..."
                                   class="w-full px-3 py-2.5 rounded-xl border focus:outline-none font-mono"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦²à¦—à¦‡à¦¨ à¦‡à¦®à§‡à¦‡à¦² *' : 'Login Email *'"></label>
                        <input type="email" x-model="ownerForm.email" placeholder="owner@foodcourt.com"
                               :disabled="ownerFormMode === 'edit' && ownerForm.role === 'superadmin'"
                               class="w-full px-3 py-2.5 rounded-xl border focus:outline-none transition-all font-mono"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                    </div>

                    <!-- Password + Confirm Password (side by side) -->
                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦ªà¦¾à¦¸à¦“à¦¯à¦¼à¦¾à¦°à§à¦¡ *' : 'Password *'"></label>
                            <input type="password" x-model="ownerForm.password" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢"
                                   class="w-full px-3 py-2.5 rounded-xl border focus:outline-none transition-all font-mono"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦ªà¦¾à¦¸à¦“à¦¯à¦¼à¦¾à¦°à§à¦¡ à¦¨à¦¿à¦¶à§à¦šà¦¿à¦¤ *' : 'Confirm Password *'"></label>
                            <input type="password" x-model="ownerForm.confirmPassword" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢"
                                   class="w-full px-3 py-2.5 rounded-xl border focus:outline-none transition-all font-mono"
                                   :class="[
                                       isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600',
                                       ownerForm.password && ownerForm.confirmPassword && ownerForm.password !== ownerForm.confirmPassword ? '!border-rose-500' : ''
                                   ]">
                        </div>
                    </div>

                    <!-- Password match indicator -->
                    <div x-show="ownerForm.password && ownerForm.confirmPassword"
                         class="text-[11px] font-bold"
                         :class="ownerForm.password === ownerForm.confirmPassword ? 'text-brand-400' : 'text-rose-400'"
                         x-text="ownerForm.password === ownerForm.confirmPassword ? 'âœ“ à¦ªà¦¾à¦¸à¦“à¦¯à¦¼à¦¾à¦°à§à¦¡ à¦®à¦¿à¦²à§‡à¦›à§‡' : 'âœ— à¦ªà¦¾à¦¸à¦“à¦¯à¦¼à¦¾à¦°à§à¦¡ à¦®à¦¿à¦²à¦›à§‡ à¦¨à¦¾'">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2 pt-2 border-t" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <button @click="showAddOwnerModal = false"
                            class="flex-1 py-2.5 rounded-xl border font-bold text-xs cursor-pointer transition-all"
                            :class="isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'">
                        à¦¬à¦¾à¦¤à¦¿à¦²
                    </button>
                    <button @click="saveOwner()"
                            class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 text-slate-950 font-bold text-xs shadow-md cursor-pointer transition-all"
                            x-text="ownerFormMode === 'add' ? 'âœ“ à¦®à¦¾à¦²à¦¿à¦• à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'âœ“ à¦ªà¦°à¦¿à¦¬à¦°à§à¦¤à¦¨ à¦¸à¦‚à¦°à¦•à§à¦·à¦£'">
                    </button>
                </div>
            </div>
        </div>
        <!-- ================================================================= -->
        <!-- MODAL: ADD / EDIT MENU ITEM -->
        <!-- ================================================================= -->
        <div x-show="showItemModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-xl"
             x-cloak>
            <div class="w-full max-w-md p-5 rounded-lg border shadow-2xl space-y-3"
                 :class="isDark ? 'glass-panel-dark' : 'bg-white border-slate-200'"
                 @click.outside="showItemModal = false">
                
                <div class="flex items-center justify-between pb-2.5 border-b"
                     :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <div class="flex items-center gap-2">
                        <span class="text-base" x-text="editingItem && editingItem.id ? 'âœï¸' : 'âž•'"></span>
                        <h4 class="font-bold text-sm sm:text-base text-slate-900 dark:text-white" 
                            x-text="editingItem && editingItem.id ? (lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦° à¦†à¦‡à¦Ÿà§‡à¦® à¦à¦¡à¦¿à¦Ÿ' : 'Edit Menu Item') : (lang === 'bn' ? 'à¦¨à¦¤à§à¦¨ à¦–à¦¾à¦¬à¦¾à¦° à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'Add New Food Item')"></h4>
                    </div>
                    <button @click="showItemModal = false" class="p-1 rounded-lg text-slate-400 hover:text-white cursor-pointer">âœ•</button>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¨à¦¾à¦® (à¦¬à¦¾à¦‚à¦²à¦¾) *' : 'Food Name (Bangla) *'"></label>
                        <input type="text" x-model="editingItem.nameBn" placeholder="à¦¯à§‡à¦®à¦¨: à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿" 
                               class="w-full px-3 py-2 rounded-xl border focus:outline-none transition-all"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                    </div>
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¨à¦¾à¦® (English)' : 'Food Name (English)'"></label>
                        <input type="text" x-model="editingItem.name" placeholder="e.g. Special Kacchi Biryani" 
                               class="w-full px-3 py-2 rounded-xl border focus:outline-none transition-all"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦Ÿà¦¾à¦—à¦°à¦¿' : 'Category'"></label>
                            <select x-model="editingItem.category" 
                                    class="w-full px-2.5 py-2 rounded-xl border focus:outline-none font-medium cursor-pointer"
                                    :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                                <option value="biryani_rice" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ à¦“ à¦­à¦¾à¦¤ (Rice)' : 'Biryani & Rice'"></option>
                                <option value="burgers_fastfood" x-text="lang === 'bn' ? 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦“ à¦«à¦¾à¦¸à§à¦Ÿà¦«à§à¦¡ (Burger)' : 'Burgers & Fast Food'"></option>
                                <option value="streetfood_chaat">à¦šà¦¾à¦Ÿ à¦“ à¦«à§à¦šà¦•à¦¾ (Streetfood)</option>
                                <option value="beverages_cha" x-text="lang === 'bn' ? 'à¦šà¦¾ à¦“ à¦•à¦«à¦¿ (Beverages)' : 'Tea & Beverages'"></option>
                                <option value="sweets_falooda" x-text="lang === 'bn' ? 'à¦«à¦¾à¦²à§à¦¦à¦¾ à¦“ à¦®à¦¿à¦·à§à¦Ÿà¦¿ (Desserts)' : 'Desserts & Sweets'"></option>
                            </select>
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à§Ÿà¦®à§‚à¦²à§à¦¯ (à§³) *' : 'Selling Price (à§³) *'"></label>
                            <input type="number" x-model.number="editingItem.price" required min="1" placeholder="250" 
                                   class="w-full px-3 py-2 rounded-xl border font-mono font-bold focus:outline-none transition-all"
                                   :class="isDark ? 'bg-obsidian-950 text-brand-400 border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-brand-600 border-slate-200 focus:border-brand-600'">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦¸à§à¦Ÿà¦• à¦ªà¦°à¦¿à¦®à¦¾à¦£' : 'Stock Quantity'"></label>
                            <input type="number" x-model.number="editingItem.stock" min="0" placeholder="50" 
                                   class="w-full px-3 py-2 rounded-xl border font-mono focus:outline-none transition-all"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-brand-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-brand-600'">
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦›à¦¬à¦¿ à¦¨à¦¿à¦°à§à¦¬à¦¾à¦šà¦¨' : 'Quick Image'"></label>
                            <div class="flex items-center gap-1">
                                <button type="button" @click="editingItem.image = 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=300&q=65&auto=format'" title="à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿" class="px-1.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-xs">ðŸ›</button>
                                <button type="button" @click="editingItem.image = 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=300&q=65&auto=format'" title="à¦¬à¦¾à¦°à§à¦—à¦¾à¦°" class="px-1.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-xs">ðŸ”</button>
                                <button type="button" @click="editingItem.image = 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=300&q=65&auto=format'" title="à¦«à§à¦šà¦•à¦¾" class="px-1.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-xs">ðŸ¥Ÿ</button>
                                <button type="button" @click="editingItem.image = 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=300&q=65&auto=format'" title="à¦šà¦¾" class="px-1.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-xs">â˜•</button>
                                <button type="button" @click="editingItem.image = 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=300&q=65&auto=format'" title="à¦«à¦¾à¦²à§à¦¦à¦¾" class="px-1.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-xs">ðŸ§</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2 border-t" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <button @click="showItemModal = false" 
                            class="flex-1 py-2.5 rounded-xl border font-bold text-xs cursor-pointer transition-all"
                            :class="isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'" 
                            x-text="lang === 'bn' ? 'à¦¬à¦¾à¦¤à¦¿à¦²' : 'Cancel'"></button>
                    <button @click="saveMenuItem()" 
                            class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 hover:from-brand-400 hover:to-teal-500 text-slate-950 font-bold text-xs shadow-md cursor-pointer transition-all" 
                            x-text="lang === 'bn' ? 'à¦¸à¦‚à¦°à¦•à§à¦·à¦£ à¦•à¦°à§à¦¨ âœ“' : 'Save Item âœ“'"></button>
                </div>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL: ADD & EDIT RAW ITEM PROCUREMENT EXPENSE -->
        <!-- ================================================================= -->
        <div x-show="showRawCostModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-xl"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="w-full max-w-md rounded-xl border shadow-2xl p-4 sm:p-6 space-y-4 max-h-[92vh] overflow-y-auto"
                 :class="isDark ? 'glass-panel-dark border-rose-500/30' : 'bg-white border-slate-200'"
                 @click.outside="showRawCostModal = false">
                
                <div class="flex items-center justify-between pb-3 border-b" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-500 flex items-center justify-center text-sm font-bold">ðŸ¥©</div>
                        <div>
                            <h3 class="font-bold text-sm sm:text-base text-slate-900 dark:text-white" 
                                x-text="editingRawCostId ? (lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦à¦¡à¦¿à¦Ÿ à¦•à¦°à§à¦¨' : 'Edit Raw Material Cost') : (lang === 'bn' ? 'à¦¨à¦¤à§à¦¨ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦¯à§‹à¦— à¦•à¦°à§à¦¨' : 'Add Raw Material Cost')"></h3>
                            <p class="text-[10px] text-slate-400" x-text="lang === 'bn' ? 'à¦®à¦¾à¦‚à¦¸, à¦šà¦¾à¦², à¦¤à§‡à¦², à¦®à¦¸à¦²à¦¾ à¦¬à¦¾ à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯ à¦•à§à¦°à§Ÿà§‡à¦° à¦¬à¦¿à¦¬à¦°à¦£ à¦“ à¦­à¦¾à¦‰à¦šà¦¾à¦°' : 'Record ingredient procurement & expense'"></p>
                        </div>
                    </div>
                    <button @click="showRawCostModal = false" class="p-1 rounded-lg text-slate-400 hover:text-white cursor-pointer">âœ•</button>
                </div>

                <div class="space-y-3 text-xs">
                    <!-- Raw Item Name -->
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² / à¦†à¦‡à¦Ÿà§‡à¦®à§‡à¦° à¦¨à¦¾à¦® *' : 'Raw Item Name *'"></label>
                        <input type="text" x-model="rawCostForm.name" placeholder="à¦¯à§‡à¦®à¦¨: à¦–à¦¾à¦¸à¦¿à¦° à¦®à¦¾à¦‚à¦¸, à¦¸à§Ÿà¦¾à¦¬à¦¿à¦¨ à¦¤à§‡à¦², à¦¬à¦¾à¦¸à¦®à¦¤à§€ à¦šà¦¾à¦²" 
                               class="w-full px-3 py-2 rounded-xl border focus:outline-none transition-all font-medium"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦•à§à¦¯à¦¾à¦Ÿà¦¾à¦—à¦°à¦¿ / à¦§à¦°à¦¨' : 'Category'"></label>
                        <select x-model="rawCostForm.category" 
                                class="w-full px-2.5 py-2 rounded-xl border focus:outline-none font-medium cursor-pointer"
                                :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                            <option value="meat">ðŸ¥© à¦®à¦¾à¦‚à¦¸, à¦®à§à¦°à¦—à¦¿ à¦“ à¦¡à¦¿à¦® (Meat & Poultry)</option>
                            <option value="rice_flour">ðŸš à¦šà¦¾à¦², à¦®à§Ÿà¦¦à¦¾ à¦“ à¦¸à§à¦œà¦¿ (Rice & Grains)</option>
                            <option value="oil_spices" x-text="lang === 'bn' ? 'ðŸ›¢ï¸ à¦¤à§‡à¦², à¦˜à¦¿ à¦“ à¦®à¦¸à¦²à¦¾ (Oil & Spices)' : 'ðŸ›¢ï¸ Oil, Ghee & Spices'"></option>
                            <option value="vegetables" x-text="lang === 'bn' ? 'ðŸ¥¦ à¦¶à¦¾à¦•à¦¸à¦¬à¦œà¦¿ à¦“ à¦•à¦¾à¦à¦šà¦¾à¦¬à¦¾à¦œà¦¾à¦° (Vegetables)' : 'ðŸ¥¦ Vegetables & Groceries'"></option>
                            <option value="dairy" x-text="lang === 'bn' ? 'ðŸ¥› à¦¦à§à¦§, à¦›à¦¾à¦¨à¦¾ à¦“ à¦®à¦¿à¦·à§à¦Ÿà¦¿ (Dairy & Curd)' : 'ðŸ¥› Milk & Dairy'"></option>
                            <option value="packaging" x-text="lang === 'bn' ? 'ðŸ“¦ à¦ªà§à¦¯à¦¾à¦•à§‡à¦œà¦¿à¦‚ à¦¬à¦•à§à¦¸ à¦“ à¦«à§Ÿà§‡à¦² (Packaging)' : 'ðŸ“¦ Packaging Boxes & Foil'"></option>
                            <option value="gas_utility">ðŸ”¥ à¦—à§à¦¯à¦¾à¦¸ à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦° à¦“ à¦œà§à¦¬à¦¾à¦²à¦¾à¦¨à¦¿ (Gas & Fuel)</option>
                            <option value="other" x-text="lang === 'bn' ? 'ðŸ§¾ à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯ à¦«à§à¦Ÿà¦«à¦°à¦®à¦¾à¦¶ à¦“ à¦–à¦°à¦š (Other)' : 'ðŸ§¾ Other Expenses'"></option>
                        </select>
                    </div>

                    <!-- Quantity, Unit, Unit Price Grid -->
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦ªà¦°à¦¿à¦®à¦¾à¦£ *' : 'Quantity *'"></label>
                            <input type="number" step="any" min="0.1" x-model.number="rawCostForm.quantity" @input="calculateRawTotal()"
                                   class="w-full px-2.5 py-2 rounded-xl border focus:outline-none font-mono font-bold"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦à¦•à¦•' : 'Unit'"></label>
                            <select x-model="rawCostForm.unit" 
                                    class="w-full px-2 py-2 rounded-xl border focus:outline-none font-medium cursor-pointer"
                                    :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                                <option value="à¦•à§‡à¦œà¦¿">à¦•à§‡à¦œà¦¿ (kg)</option>
                                <option value="à¦²à¦¿à¦Ÿà¦¾à¦°">à¦²à¦¿à¦Ÿà¦¾à¦° (L)</option>
                                <option value="à¦¬à¦¸à§à¦¤à¦¾">à¦¬à¦¸à§à¦¤à¦¾ (Bag)</option>
                                <option value="à¦ªà§à¦¯à¦¾à¦•à§‡à¦Ÿ">à¦ªà§à¦¯à¦¾à¦•à§‡à¦Ÿ (Pkt)</option>
                                <option value="à¦¡à¦œà¦¨">à¦¡à¦œà¦¨ (Doz)</option>
                                <option value="à¦•à§‡à¦¸">à¦•à§‡à¦¸ (Case)</option>
                                <option value="à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦°">à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦° (Cyl)</option>
                                <option value="à¦ªà¦¿à¦¸">à¦ªà¦¿à¦¸ (Pcs)</option>
                                <option value="à¦—à§à¦°à¦¾à¦®">à¦—à§à¦°à¦¾à¦® (gm)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦ªà§à¦°à¦¤à¦¿ à¦à¦•à¦•à§‡à¦° à¦¦à¦° (à§³)' : 'Unit Price'"></label>
                            <input type="number" min="0" x-model.number="rawCostForm.unitPrice" @input="calculateRawTotal()"
                                   class="w-full px-2.5 py-2 rounded-xl border focus:outline-none font-mono font-bold"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                        </div>
                    </div>

                    <!-- Total Cost & Payment Method -->
                    <div class="grid grid-cols-2 gap-2.5 p-3 rounded-lg border"
                         :class="isDark ? 'bg-obsidian-950/60 border-rose-500/30' : 'bg-rose-50/50 border-rose-200'">
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦®à§‹à¦Ÿ à¦–à¦°à¦š (à§³) *' : 'Total Cost (à§³) *'"></label>
                            <input type="number" min="0" x-model.number="rawCostForm.totalCost"
                                   class="w-full px-3 py-2 rounded-xl border focus:outline-none font-mono font-bold text-rose-500 text-sm"
                                   :class="isDark ? 'bg-obsidian-950 border-zinc-700 focus:border-rose-500' : 'bg-white border-rose-300 focus:border-rose-500'">
                            <span class="text-[9px] text-slate-400 mt-0.5 block" x-text="lang === 'bn' ? 'à¦¦à¦° à¦…à¦¨à§à¦¯à¦¾à§Ÿà§€ à¦…à¦Ÿà§‹ à¦¹à¦¿à¦¸à§‡à¦¬ à¦¹à§Ÿ' : 'Auto computed'"></span>
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦ªà¦°à¦¿à¦¶à§‹à¦§à§‡à¦° à¦®à¦¾à¦§à§à¦¯à¦®' : 'Payment Method'"></label>
                            <select x-model="rawCostForm.paidVia" 
                                    class="w-full px-2.5 py-2 rounded-xl border focus:outline-none font-bold cursor-pointer"
                                    :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-white text-slate-900 border-slate-200 focus:border-rose-500'">
                                <option value="Cash">ðŸ’µ à¦•à§à¦¯à¦¾à¦¶ (Cash)</option>
                                <option value="bKash">ðŸŒ¸ à¦¬à¦¿à¦•à¦¾à¦¶ (bKash)</option>
                                <option value="Nagad">ðŸŠ à¦¨à¦—à¦¦ (Nagad)</option>
                                <option value="Due">â³ à¦¬à¦¾à¦•à¦¿ / à¦¬à¦¾à¦•à¦¿à¦¤à§‡ à¦•à§à¦°à§Ÿ (Due)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Supplier / Vendor & Date -->
                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦¬à¦¾à¦œà¦¾à¦° / à¦¸à¦°à¦¬à¦°à¦¾à¦¹à¦•à¦¾à¦°à§€' : 'Supplier / Vendor'"></label>
                            <input type="text" x-model="rawCostForm.vendor" placeholder="à¦¯à§‡à¦®à¦¨: à¦•à¦¾à¦“à¦°à¦¾à¦¨ à¦¬à¦¾à¦œà¦¾à¦° à¦†à§œà§Ž" 
                                   class="w-full px-3 py-2 rounded-xl border focus:outline-none transition-all"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                        </div>
                        <div>
                            <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦•à§à¦°à§Ÿà§‡à¦° à¦¤à¦¾à¦°à¦¿à¦–' : 'Purchase Date'"></label>
                            <input type="date" x-model="rawCostForm.date" 
                                   class="w-full px-2.5 py-2 rounded-xl border focus:outline-none transition-all font-mono"
                                   :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                        </div>
                    </div>

                    <!-- Note / Remarks -->
                    <div>
                        <label class="text-slate-600 dark:text-slate-400 font-bold block mb-1" x-text="lang === 'bn' ? 'à¦¨à§‹à¦Ÿ / à¦­à¦¾à¦‰à¦šà¦¾à¦° à¦¬à¦¿à¦¬à¦°à¦£' : 'Note / Voucher Details'"></label>
                        <input type="text" x-model="rawCostForm.note" placeholder="à¦¯à§‡à¦®à¦¨: à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿à¦° à¦«à§à¦°à§‡à¦¶ à¦–à¦¾à¦¸à¦¿, à¦­à¦¾à¦‰à¦šà¦¾à¦° #à§®à§ª" 
                               class="w-full px-3 py-2 rounded-xl border focus:outline-none transition-all"
                               :class="isDark ? 'bg-obsidian-950 text-white border-zinc-700 focus:border-rose-500' : 'bg-slate-50 text-slate-900 border-slate-200 focus:border-rose-500'">
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-3 border-t" :class="isDark ? 'border-white/[0.08]' : 'border-slate-100'">
                    <button @click="showRawCostModal = false" 
                            class="flex-1 py-2.5 rounded-xl border font-bold text-xs cursor-pointer transition-all"
                            :class="isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200'" 
                            x-text="lang === 'bn' ? 'à¦¬à¦¾à¦¤à¦¿à¦²' : 'Cancel'"></button>
                    <button @click="saveRawCost()" 
                            class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-400 hover:to-rose-500 text-white font-bold text-xs shadow-md cursor-pointer transition-all" 
                            x-text="lang === 'bn' ? 'à¦¸à¦‚à¦°à¦•à§à¦·à¦£ à¦•à¦°à§à¦¨ âœ“' : 'Save Raw Cost âœ“'"></button>
                </div>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL: INTERACTIVE RECEIPT PREVIEW & BILL DOWNLOAD -->
        <!-- ================================================================= -->
        <div x-show="showReceiptModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-xl"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="w-full max-w-sm rounded-xl border shadow-2xl overflow-hidden flex flex-col max-h-[90vh]"
                 :class="isDark ? 'glass-panel-dark border-brand-500/30' : 'bg-white border-slate-200 text-slate-900'"
                 @click.outside="showReceiptModal = false">
                
                <!-- Modal Top Action Bar -->
                <div class="p-3 sm:p-4 border-b flex items-center justify-between"
                     :class="isDark ? 'border-white/[0.08] bg-obsidian-950/80' : 'border-slate-100 bg-slate-50'">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center text-xs font-bold">ðŸ§¾</div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦² à¦“ à¦®à§‡à¦®à§‹ à¦­à¦¿à¦‰à§Ÿà¦¾à¦°' : 'Invoice Receipt'"></h4>
                            <p class="text-[9px] font-mono text-brand-500" x-text="currentReceiptOrder ? currentReceiptOrder.orderId : ''"></p>
                        </div>
                    </div>
                    <button @click="showReceiptModal = false" class="p-1.5 rounded-lg text-slate-400 hover:text-white text-xs">âœ•</button>
                </div>

                <!-- Live Thermal Receipt Paper Preview -->
                <div class="p-4 flex-1 overflow-y-auto space-y-3 font-mono bg-zinc-100 dark:bg-zinc-950 text-slate-900 dark:text-zinc-100 text-xs select-text">
                    
                    <div class="bg-white dark:bg-zinc-900 p-4 rounded-lg shadow-inner border border-slate-200 dark:border-zinc-800 space-y-2.5">
                        
                        <!-- Header -->
                        <div class="text-center pb-2 border-b border-dashed border-zinc-400 dark:border-zinc-700">
                            <h3 class="font-bold text-sm tracking-tight text-slate-900 dark:text-white" x-text="posSettings.storeName"></h3>
                            <p class="text-[10px] text-zinc-500" x-text="posSettings.address"></p>
                            <p class="text-[9px] text-zinc-500" x-text="'BIN: ' + posSettings.bin"></p>
                            <p class="text-[9px] text-zinc-500" x-text="'Hotline: ' + posSettings.hotline"></p>
                        </div>

                        <!-- Order Info -->
                        <div class="text-[10px] space-y-0.5 pb-2 border-b border-dashed border-zinc-400 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300">
                            <div class="flex justify-between">
                                <span>à¦®à§‡à¦®à§‹ à¦¨à¦‚:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="currentReceiptOrder ? currentReceiptOrder.orderId : ''"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>à¦¤à¦¾à¦°à¦¿à¦– à¦“ à¦¸à¦®à§Ÿ:</span>
                                <span x-text="currentReceiptOrder ? currentReceiptOrder.timestamp : ''"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>à¦…à¦°à§à¦¡à¦¾à¦° à¦§à¦°à¦¨:</span>
                                <span class="font-bold text-brand-500" x-text="currentReceiptOrder ? currentReceiptOrder.type : ''"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>à¦—à§à¦°à¦¾à¦¹à¦• / à¦Ÿà§‡à¦¬à¦¿à¦²:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="currentReceiptOrder ? currentReceiptOrder.customerRef : ''"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>à¦ªà§‡à¦®à§‡à¦¨à§à¦Ÿ à¦®à§‡à¦¥à¦¡:</span>
                                <span class="font-bold text-slate-900 dark:text-white" x-text="currentReceiptOrder ? currentReceiptOrder.paymentMethod : ''"></span>
                            </div>
                        </div>

                        <!-- Itemized Table -->
                        <div class="space-y-1.5 py-1 text-[11px] border-b border-dashed border-zinc-400 dark:border-zinc-700">
                            <div class="flex justify-between font-bold text-[9px] text-zinc-500 uppercase tracking-wider pb-1">
                                <span>à¦†à¦‡à¦Ÿà§‡à¦®</span>
                                <span>à¦®à§‹à¦Ÿ</span>
                            </div>
                            <template x-for="it in (currentReceiptOrder ? currentReceiptOrder.items : [])" :key="it.name">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 dark:text-white truncate" x-text="it.nameBn || it.name"></div>
                                        <div class="text-[9px] text-zinc-500" x-text="'à§³' + it.price + ' Ã— ' + it.quantity"></div>
                                    </div>
                                    <span class="font-bold text-slate-900 dark:text-white flex-shrink-0" x-text="'à§³' + (it.price * it.quantity).toFixed(0)"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Calculations -->
                        <div class="space-y-1 text-[11px] pb-2 border-b border-dashed border-zinc-400 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300">
                            <div class="flex justify-between">
                                <span>à¦¸à¦¾à¦¬à¦Ÿà§‹à¦Ÿà¦¾à¦²:</span>
                                <span x-text="'à§³' + (currentReceiptOrder ? (currentReceiptOrder.subtotal || 0).toFixed(0) : '0')"></span>
                            </div>
                            <template x-if="currentReceiptOrder && currentReceiptOrder.discount > 0">
                                <div class="flex justify-between text-rose-500">
                                    <span>à¦¡à¦¿à¦¸à¦•à¦¾à¦‰à¦¨à§à¦Ÿ:</span>
                                    <span x-text="'-à§³' + (currentReceiptOrder.discount || 0).toFixed(0)"></span>
                                </div>
                            </template>
                            <div class="flex justify-between">
                                <span x-text="'à¦­à§à¦¯à¦¾à¦Ÿ (' + (posSettings.vatPercent || 5) + '%):'"></span>
                                <span x-text="'à§³' + (currentReceiptOrder ? (currentReceiptOrder.tax || 0).toFixed(0) : '0')"></span>
                            </div>
                            <div class="flex justify-between text-xs font-bold text-slate-900 dark:text-white pt-1 border-t border-zinc-300 dark:border-zinc-700">
                                <span>à¦¸à¦°à§à¦¬à¦®à§‹à¦Ÿ à¦ªà§à¦°à¦¦à§‡à¦¯à¦¼ à¦¬à¦¿à¦²:</span>
                                <span class="text-brand-500 font-mono" x-text="currentReceiptOrder ? formatCurrency(currentReceiptOrder.grandTotal) : 'à§³à§¦'"></span>
                            </div>
                        </div>

                        <!-- Footer Thank You & Barcode -->
                        <div class="text-center pt-1 space-y-1">
                            <p class="text-[10px] text-zinc-500">à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿à¦¤à§‡ à¦†à¦¸à¦¾à¦° à¦œà¦¨à§à¦¯ à¦§à¦¨à§à¦¯à¦¬à¦¾à¦¦!</p>
                            <div class="text-[8px] tracking-[0.3em] font-mono text-zinc-400">||| | |||| | ||| |||| | | ||</div>
                        </div>

                    </div>

                </div>

                <!-- Modal Action Buttons (Print & Copy) -->
                <div class="p-3 border-t space-y-2"
                     :class="isDark ? 'border-white/[0.08] bg-obsidian-950' : 'border-slate-200 bg-slate-50'">
                    
                    <!-- Direct Print -->
                    <button @click="printReceiptDirect()" 
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 text-slate-950 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-lg shadow-brand-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span x-text="lang === 'bn' ? 'à¦ªà§à¦°à¦¿à¦¨à§à¦Ÿ à¦®à§‡à¦®à§‹ (Thermal Print)' : 'Print Receipt Slip'"></span>
                    </button>

                    <!-- Copy Digital e-Receipt for WhatsApp / SMS -->
                    <button @click="copyDigitalReceipt(currentReceiptOrder)" 
                            class="w-full py-2 rounded-xl border text-xs font-bold transition-colors flex items-center justify-center gap-1.5"
                            :class="isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700 hover:bg-zinc-700' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                        <span>ðŸ“‹</span>
                        <span x-text="lang === 'bn' ? 'à¦¡à¦¿à¦œà¦¿à¦Ÿà¦¾à¦² à¦®à§‡à¦®à§‹ à¦•à¦ªà¦¿ à¦•à¦°à§à¦¨ (WhatsApp)' : 'Copy e-Receipt (WhatsApp)'"></span>
                    </button>
                </div>

            </div>
        </div>

        <!-- ================================================================= -->
        <!-- FLOATING LAST-ORDER SUCCESS QUICK ACTION BANNER -->
        <!-- ================================================================= -->
        <div x-show="showLastOrderBanner && lastCompletedOrder" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             class="fixed top-3 inset-x-3 sm:inset-x-auto sm:right-4 sm:max-w-md z-50 p-3 rounded-lg border shadow-2xl backdrop-blur-xl flex items-center justify-between gap-2.5"
             :class="isDark ? 'bg-obsidian-950/95 border-brand-500/50 text-white shadow-brand-500/20' : 'bg-white/95 border-brand-500/40 text-slate-900 shadow-xl'">
            <div class="flex items-center gap-2.5 min-w-0">
                <span class="w-8 h-8 rounded-xl bg-brand-500 text-slate-950 flex items-center justify-center font-bold text-sm flex-shrink-0">âœ“</span>
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5 font-bold text-xs truncate">
                        <span x-text="lastCompletedOrder ? lastCompletedOrder.orderId : ''"></span>
                        <span class="text-brand-500 font-mono font-bold" x-text="lastCompletedOrder ? formatCurrency(lastCompletedOrder.grandTotal) : ''"></span>
                    </div>
                    <p class="text-[10px] text-slate-400 dark:text-zinc-400 truncate" x-text="lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡ à¦¸à¦®à§à¦ªà¦¨à§à¦¨!' : 'Sale recorded!'"></p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 flex-shrink-0">
                <button @click="previewReceipt(lastCompletedOrder)" 
                        class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-brand-500/15 hover:bg-brand-500/30 text-brand-400 border border-brand-500/30 transition-colors flex items-center gap-1 cursor-pointer">
                    <span>ðŸ–¨ï¸</span>
                    <span x-text="lang === 'bn' ? 'à¦°à¦¸à¦¿à¦¦' : 'Receipt'"></span>
                </button>
                <button @click="copyDigitalReceipt(lastCompletedOrder)" 
                        title="WhatsApp à¦®à§‡à¦®à§‹ à¦•à¦ªà¦¿ à¦•à¦°à§à¦¨"
                        class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-zinc-800 text-zinc-300 border border-zinc-700 hover:bg-zinc-700 transition-colors cursor-pointer">
                    <span>ðŸ“‹</span>
                </button>
                <button @click="showLastOrderBanner = false" class="text-slate-400 hover:text-white text-xs px-1 cursor-pointer">âœ•</button>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- ================================================================= -->
        <!-- MODAL: 1-CLICK ANDROID APP INSTALL GUIDE (showInstallGuideModal) -->
        <!-- ================================================================= -->
        <div x-show="showInstallGuideModal" 
             class="fixed inset-0 z-[80] flex items-center justify-center p-4 bg-black/85 backdrop-blur-xl"
             x-cloak
             x-transition>
            <div class="w-full max-w-sm rounded-xl border shadow-2xl p-6 space-y-4 text-center transition-all"
                 :class="isDark ? 'glass-panel-dark border-brand-500/40 text-white' : 'bg-white border-slate-200 text-slate-900'"
                 @click.outside="showInstallGuideModal = false">
                
                <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-brand-500 to-teal-600 text-slate-950 flex items-center justify-center text-2xl font-bold mx-auto shadow-neon-brand">
                    ðŸ“²
                </div>

                <div class="space-y-1">
                    <h3 class="font-bold text-base" x-text="lang === 'bn' ? 'à¦«à§‹à¦¨à§‡ à§§-à¦•à§à¦²à¦¿à¦•à§‡ à¦…à§à¦¯à¦¾à¦ª à¦‡à¦¨à¦¸à§à¦Ÿà¦² à¦•à¦°à§à¦¨' : 'Install App on Phone (1-Click)'"></h3>
                    <p class="text-xs text-slate-400" x-text="lang === 'bn' ? 'à¦ªà§à¦²à§‡ à¦¸à§à¦Ÿà§‹à¦° à¦›à¦¾à§œà¦¾à¦‡ à¦¸à¦°à¦¾à¦¸à¦°à¦¿ à¦«à§‹à¦¨à§‡ à¦…à§à¦¯à¦¾à¦ª à¦¹à¦¿à¦¸à§‡à¦¬à§‡ à¦šà¦²à¦¬à§‡ (à§§à§¦à§¦% à¦…à¦«à¦²à¦¾à¦‡à¦¨ à¦“ à¦«à§à¦°à¦¿)' : 'No Play Store required. Works 100% offline.'"></p>
                </div>

                <!-- 2 Easy Steps Visual Guide -->
                <div class="p-3.5 rounded-lg border text-left space-y-2.5 text-xs font-bold"
                     :class="isDark ? 'bg-zinc-900/80 border-white/[0.08]' : 'bg-slate-50 border-slate-200'">
                    <div class="flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-full bg-brand-500 text-slate-950 flex items-center justify-center text-xs font-bold flex-shrink-0">à§§</span>
                        <div>
                            <span class="text-white dark:text-white" x-text="lang === 'bn' ? 'à¦•à§à¦°à§‹à¦® à¦¬à§à¦°à¦¾à¦‰à¦œà¦¾à¦°à§‡à¦° à¦‰à¦ªà¦°à§‡ à¦¡à¦¾à¦¨à¦¦à¦¿à¦•à§‡à¦° à¦¤à¦¿à¦¨à¦Ÿà¦¿ à¦¡à¦Ÿà§‡ (â‹®) à¦šà¦¾à¦ª à¦¦à¦¿à¦¨' : 'Tap the 3 dots (â‹®) icon at top right in Chrome'"></span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-full bg-brand-500 text-slate-950 flex items-center justify-center text-xs font-bold flex-shrink-0">à§¨</span>
                        <div>
                            <span class="text-brand-400 font-bold" x-text="lang === 'bn' ? '"Install app" à¦…à¦¥à¦¬à¦¾ "Add to Home screen" à¦ à¦šà¦¾à¦ª à¦¦à¦¿à¦¨' : 'Tap "Install app" or "Add to Home screen"'"></span>
                        </div>
                    </div>
                </div>

                <button type="button" @click="showInstallGuideModal = false"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-brand-500 to-teal-600 text-slate-950 font-bold text-xs shadow-md shadow-brand-500/25 active:scale-95 transition-all cursor-pointer">
                    <span x-text="lang === 'bn' ? 'à¦¬à§à¦à§‡à¦›à¦¿, à¦‡à¦¨à¦¸à§à¦Ÿà¦² à¦•à¦°à¦¬' : 'Got it, Let's Install'"></span>
                </button>
            </div>
        </div>

        <!-- PRINTABLE DAILY Z-REPORT (For physical printer window.print) -->
        <div id="printable-zreport" class="font-mono text-black p-4 max-w-xs mx-auto border border-dashed border-gray-400 bg-white text-xs" style="display: none;">
            <div class="text-center pb-2 border-b border-dashed border-black">
                <h2 class="text-sm font-extrabold" x-text="posSettings.storeName"></h2>
                <p class="text-[10px] font-bold" x-text="getActiveFoodCourtTitle()"></p>
                <p class="text-[10px]" x-text="'*** DAILY Z-REPORT (à¦¦à¦¿à¦¨ à¦¸à¦®à¦¾à¦ªà§à¦¤à¦¿à¦° à¦¹à¦¿à¦¸à¦¾à¦¬) ***'"></p>
                <p class="text-[9px]" x-text="'Date: ' + (courtSession.openedDate || new Date().toLocaleDateString())"></p>
            </div>
            <div class="py-1.5 text-[10px] border-b border-dashed border-black space-y-0.5">
                <div class="flex justify-between"><span>Shift Open:</span><span x-text="courtSession.openedAt || '10:00 AM'"></span></div>
                <div class="flex justify-between"><span>Shift Close:</span><span x-text="courtSession.closedAt || currentDhakaTime"></span></div>
                <div class="flex justify-between"><span>Opening Float:</span><span x-text="formatCurrency(courtSession.openingFloat || 0)"></span></div>
            </div>
            <div class="py-1.5 text-[10px] border-b border-dashed border-black space-y-1">
                <div class="flex justify-between font-bold"><span>Total Orders:</span><span x-text="todayStats.totalOrders"></span></div>
                <div class="flex justify-between"><span>Cash Sales:</span><span x-text="formatCurrency(todayStats.cashTotal)"></span></div>
                <div class="flex justify-between"><span>bKash Sales:</span><span x-text="formatCurrency(todayStats.bkashTotal)"></span></div>
                <div class="flex justify-between"><span>Nagad Sales:</span><span x-text="formatCurrency(todayStats.nagadTotal)"></span></div>
                <div class="flex justify-between font-bold text-xs pt-1 border-t border-dotted border-black">
                    <span>GROSS SALES:</span><span x-text="formatCurrency(todayStats.totalRevenue)"></span>
                </div>
            </div>
            <div class="py-1.5 text-[10px] border-b border-dashed border-black space-y-0.5">
                <div class="flex justify-between"><span>Raw Material Costs:</span><span x-text="formatCurrency(todayStats.todayRawCost)"></span></div>
                <div class="flex justify-between font-bold"><span>ESTIMATED NET PROFIT:</span><span x-text="formatCurrency(todayStats.todayNetProfit)"></span></div>
            </div>
            <div class="pt-4 text-center text-[9px] text-gray-500">
                <p>Manager Signature: __________________</p>
                <p class="mt-1">Generated via Khabarbari POS OS</p>
            </div>
        </div>

                <!-- PRINTABLE THERMAL RECEIPT (For physical printer window.print) -->
        <!-- ================================================================= -->
        <div id="printable-receipt" class="font-mono text-black p-4 max-w-xs mx-auto border border-dashed border-gray-400 bg-white text-xs">
            <div class="text-center pb-2 border-b border-dashed border-black">
                <h2 class="text-sm font-extrabold" x-text="posSettings.storeName"></h2>
                <p class="text-[10px]" x-text="posSettings.address"></p>
                <p class="text-[9px]" x-text="'BIN: ' + posSettings.bin"></p>
                <p class="text-[9px]" x-text="'Hotline: ' + posSettings.hotline"></p>
            </div>

            <div class="py-1.5 text-[10px] border-b border-dashed border-black space-y-0.5">
                <div class="flex justify-between"><span>à¦®à§‡à¦®à§‹:</span><span class="font-bold" x-text="currentReceiptOrder ? currentReceiptOrder.orderId : ''"></span></div>
                <div class="flex justify-between"><span>à¦¤à¦¾à¦°à¦¿à¦–:</span><span x-text="currentReceiptOrder ? currentReceiptOrder.timestamp : ''"></span></div>
                <div class="flex justify-between"><span>à¦§à¦°à¦¨:</span><span class="font-bold" x-text="currentReceiptOrder ? currentReceiptOrder.type : ''"></span></div>
                <div class="flex justify-between"><span>à¦Ÿà§‡à¦¬à¦¿à¦²/à¦¨à¦¾à¦®:</span><span x-text="currentReceiptOrder ? currentReceiptOrder.customerRef : ''"></span></div>
                <div class="flex justify-between"><span>à¦ªà§‡à¦®à§‡à¦¨à§à¦Ÿ:</span><span class="font-bold" x-text="currentReceiptOrder ? currentReceiptOrder.paymentMethod : ''"></span></div>
            </div>

            <div class="py-1.5 border-b border-dashed border-black text-[10px] space-y-1">
                <template x-for="it in (currentReceiptOrder ? currentReceiptOrder.items : [])" :key="it.name">
                    <div class="flex justify-between">
                        <span x-text="(it.nameBn || it.name) + ' x' + it.quantity"></span>
                        <span class="font-bold" x-text="'à§³' + (it.price * it.quantity).toFixed(0)"></span>
                    </div>
                </template>
            </div>

            <div class="py-1.5 border-b border-dashed border-black text-[11px] space-y-0.5">
                <div class="flex justify-between"><span>à¦¸à¦¾à¦¬à¦Ÿà§‹à¦Ÿà¦¾à¦²:</span><span x-text="'à§³' + (currentReceiptOrder ? currentReceiptOrder.subtotal.toFixed(0) : '0')"></span></div>
                <template x-if="currentReceiptOrder && currentReceiptOrder.discount > 0">
                    <div class="flex justify-between"><span>à¦¡à¦¿à¦¸à¦•à¦¾à¦‰à¦¨à§à¦Ÿ:</span><span x-text="'-à§³' + currentReceiptOrder.discount.toFixed(0)"></span></div>
                </template>
                <div class="flex justify-between"><span>à¦­à§à¦¯à¦¾à¦Ÿ:</span><span x-text="'à§³' + (currentReceiptOrder ? currentReceiptOrder.tax.toFixed(0) : '0')"></span></div>
                <div class="flex justify-between font-bold text-xs pt-1 border-t border-dashed border-black">
                    <span>à¦¸à¦°à§à¦¬à¦®à§‹à¦Ÿ à¦¬à¦¿à¦²:</span>
                    <span x-text="currentReceiptOrder ? formatCurrency(currentReceiptOrder.grandTotal) : 'à§³à§¦'"></span>
                </div>
            </div>

            <div class="text-center pt-2 text-[9px]">
                <p>à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿à¦¤à§‡ à¦†à¦¸à¦¾à¦° à¦œà¦¨à§à¦¯ à¦§à¦¨à§à¦¯à¦¬à¦¾à¦¦!</p>
                <p class="font-bold">Powered by KhabarBari OS</p>
            </div>
        </div>

    </div>

    <!-- STATE ENGINE -->
    <script>
        function foodCourtApp() {
            return {
                isDark: true,
                lang: 'bn',
                viewMode: 'desktop', // 'desktop' or 'mobile'
                mobileLayout: 'grid', // 'grid' or 'list'
                deferredInstallPrompt: null,
                showInstallAppBanner: true,

                showInstallGuideModal: false,

                triggerInstallApp() {
                    if (this.deferredInstallPrompt) {
                        this.deferredInstallPrompt.prompt();
                        this.deferredInstallPrompt.userChoice.then((choiceResult) => {
                            if (choiceResult.outcome === 'accepted') {
                                this.showToast(this.lang === 'bn' ? 'ðŸŽ‰ à¦…à§à¦¯à¦¾à¦ª à¦¸à¦«à¦²à¦­à¦¾à¦¬à§‡ à¦«à§‹à¦¨à§‡ à¦‡à¦¨à¦¸à§à¦Ÿà¦² à¦¹à¦šà§à¦›à§‡!' : 'ðŸŽ‰ App installing on phone!');
                                this.showInstallAppBanner = false;
                            }
                            this.deferredInstallPrompt = null;
                        });
                    } else {
                        this.showInstallGuideModal = true;
                    }
                },
                activeTab: 'pos',
                posFastSaleMode: true, // 1-Tap Fast Sale without manual inputs
                salesRevision: 0, // Reactive trigger for instant sum updates
                analyticsViewMode: 'months',
                searchQuery: '',
                selectedCategory: 'all',
                orderType: 'Dine-in',
                customerRef: '',
                discountPercent: 0,
                paymentMethod: 'Cash',
                cashGiven: 0,
                mfsTrxId: '',
                currentDhakaTime: '',
                currentOrderNumber: Math.floor(1000 + Math.random() * 9000),
                soundEnabled: true,

                // Screen Brightness State
                brightnessLevel: 90, // default 90% comfortable glare-free
                showBrightnessPopover: false,

                // Mobile Navigation Drawer
                showMobileNavDrawer: false,

                // Toast Notification State
                toast: {
                    show: false,
                    message: '',
                    icon: 'âœ¨',
                    type: 'success',
                    timer: null
                },

                // Admin State
                isAdminLoggedIn: false,
                showAdminMenubar: true,
                showAdminLoginModal: false,
                adminEmail: '',
                adminPassword: '',
                adminShowPassword: false,
                adminLoginError: '',
                adminUser: { name: 'Super Admin', email: 'admin@foodcourt.com', shopName: 'à¦¸à§‡à¦¨à§à¦Ÿà§à¦°à¦¾à¦² à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦¹à¦¾à¦¬' },

                // Court Status State (Open Court / Close Court)
                isCourtOpen: false,             // whether current court/stall is open for sales
                showOpenCourtModal: false,      // modal to open court
                showCloseCourtModal: false,     // modal to close court (Z-Report)
                courtSession: {
                    sessionId: '',
                    openedAt: '',
                    openedDate: '',
                    closedAt: '',
                    openingFloat: 0,
                    closingNotes: ''
                },
                openCourtForm: {
                    openingFloat: 0,
                    note: ''
                },
                closedSessionsHistory: [],      // past closed day sessions

                // Multi-Tenant Accounts & Role Engine
                currentUserRole: 'guest',       // 'guest' | 'superadmin' | 'owner'
                currentOwnerId: null,           // id of the logged in owner
                adminViewingOwnerId: 'all',     // 'all' or specific owner id when superadmin views data
                accounts: [],                   // reactive accounts list
                showAddOwnerModal: false,
                ownerFormMode: 'add',           // 'add' | 'edit'
                editingOwnerId: null,
                ownerForm: { id: '', name: '', shopName: '', stallNo: '', phone: '', email: '', password: '', confirmPassword: '' },
                ownerFormError: '',
                ownerFormSuccess: '',

                // Cart & Sheet State
                cart: [],
                showMobileCartSheet: false,

                // Settings
                posSettings: {
                    storeName: 'à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿ POS & à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ',
                    hubLocation: 'à¦¢à¦¾à¦•à¦¾ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦¹à¦¾à¦¬',
                    hotline: '+880 1711-234567',
                    address: 'à¦§à¦¾à¦¨à¦®à¦¨à§à¦¡à¦¿ à§¨à§­, à¦¢à¦¾à¦•à¦¾-à§§à§¨à§¦à§¯',
                    email: 'info@khabarbari.com',
                    bin: '002938491-0101',
                    vatPercent: 5,
                    currency: 'à§³',
                    autoShowReceipt: false
                },

                // Contact Us Form
                contactForm: {
                    name: '',
                    emailPhone: '',
                    message: '',
                    sending: false
                },

                // Categories with rich icons
                categories: [
                    { key: 'all', icon: 'ðŸ½ï¸', nameBn: 'à¦¸à¦¬ à¦–à¦¾à¦¬à¦¾à¦°', nameEn: 'All Foods' },
                    { key: 'biryani_rice', icon: 'ðŸš', nameBn: 'à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ à¦“ à¦°à¦¾à¦‡à¦¸', nameEn: 'Biryani & Rice' },
                    { key: 'burgers_fastfood', icon: 'ðŸ”', nameBn: 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦“ à¦«à¦¾à¦¸à§à¦Ÿà¦«à§à¦¡', nameEn: 'Burgers & Fast Food' },
                    { key: 'street_fuchka', icon: 'ðŸ¥Ÿ', nameBn: 'à¦«à§à¦šà¦•à¦¾ à¦“ à¦šà¦Ÿà¦ªà¦Ÿà¦¿', nameEn: 'Fuchka & Street' },
                    { key: 'beverages_cha', icon: 'â˜•', nameBn: 'à¦šà¦¾, à¦²à¦¾à¦šà§à¦›à¦¿ à¦“ à¦¡à§à¦°à¦¿à¦‚à¦•à¦¸', nameEn: 'Tea & Drinks' },
                    { key: 'sweets_falooda', icon: 'ðŸ¨', nameBn: 'à¦«à¦¾à¦²à§à¦¦à¦¾ à¦“ à¦®à¦¿à¦·à§à¦Ÿà¦¿', nameEn: 'Falooda & Sweets' }
                ],

                menuItems: [],
                salesHistory: [],

                // KOT Orders
                kitchenOrders: [
                    {
                        id: 'kot_1',
                        orderId: 'MEMO-9843',
                        time: '2m ago',
                        status: 'pending',
                        type: 'Dine-in',
                        customerRef: 'Table 06',
                        items: [
                            { name: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿', quantity: 2 },
                            { name: 'à¦à¦¤à¦¿à¦¹à§à¦¯à¦¬à¦¾à¦¹à§€ à¦¶à¦¾à¦¹à§€ à¦ªà§à¦¦à¦¿à¦¨à¦¾ à¦¬à§‹à¦°à¦¹à¦¾à¦¨à¦¿', quantity: 2 }
                        ]
                    },
                    {
                        id: 'kot_2',
                        orderId: 'MEMO-9842',
                        time: '7m ago',
                        status: 'cooking',
                        type: 'Takeaway',
                        customerRef: 'à¦°à¦¾à¦•à¦¿à¦¬à§à¦² à¦¹à¦¾à¦¸à¦¾à¦¨',
                        items: [
                            { name: 'à¦¨à¦¾à¦—à¦¾ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦¸à§à¦®à§‹à¦•à¦¿ à¦šà¦¿à¦•à§‡à¦¨ à¦¬à¦¾à¦°à§à¦—à¦¾à¦°', quantity: 2 }
                        ]
                    },
                    {
                        id: 'kot_3',
                        orderId: 'MEMO-9841',
                        time: '14m ago',
                        status: 'ready',
                        type: 'Dine-in',
                        customerRef: 'Table 11',
                        items: [
                            { name: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¸à§à¦ªà¦¾à¦‡à¦¸à¦¿ à¦¦à¦‡ à¦«à§à¦šà¦•à¦¾ (à§§à§¦ à¦ªà¦¿à¦¸)', quantity: 3 }
                        ]
                    }
                ],

                // POS Sub Tab & Quick Amount Sale Engine
                posSubTab: 'menu', // 'menu' or 'quick-amount'
                quickAmount: '',
                quickAmountNote: '',
                quickAmountPayment: 'Cash',
                quickAmountQty: 1,
                quickAmountPresets: [20, 50, 80, 100, 150, 200, 300, 500],
                quickNoteSuggestions: ['à¦šà¦¾ / à¦•à¦«à¦¿', 'à¦¨à¦¾à¦¸à§à¦¤à¦¾', 'à¦¦à§à¦ªà§à¦°à§‡à¦° à¦–à¦¾à¦¬à¦¾à¦°', 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦•à¦®à§à¦¬à§‹', 'à¦ªà¦¾à¦°à§à¦¸à§‡à¦² à¦¬à¦¿à¦²'],

                // Floating Last Order Notification / Action Banner
                lastCompletedOrder: null,
                showLastOrderBanner: false,
                lastOrderTimer: null,

                // Filters & Modals
                ledgerSearch: '',
                ledgerFilter: 'today', // 'today', 'all', 'cash', 'bkash', 'nagad'
                ledgerViewMode: 'memos', // 'memos' or 'items'
                showItemModal: false,
                showReceiptModal: false,
                editingItem: { id: null, name: '', nameBn: '', code: 'KB-01', category: 'biryani_rice', image: '', costPrice: 150, price: 280, stock: 40 },
                currentReceiptOrder: null,

                // Raw Items Cost Procurement State
                showRawCostModal: false,
                editingRawCostId: null,
                rawCostSearch: '',
                rawCostCategoryFilter: 'all',
                rawCostDateFilter: 'today', // 'today', 'all', 'cash', 'due'
                rawCostForm: {
                    id: null,
                    name: '',
                    category: 'meat',
                    quantity: 1,
                    unit: 'à¦•à§‡à¦œà¦¿',
                    unitPrice: 0,
                    totalCost: 0,
                    date: new Date().toISOString().split('T')[0],
                    paidVia: 'Cash',
                    vendor: '',
                    note: ''
                },
                rawCostCategories: [
                    { key: 'all', icon: 'ðŸ“‹', nameBn: 'à¦¸à¦•à¦² à¦–à¦°à¦š', nameEn: 'All Costs' },
                    { key: 'meat', icon: 'ðŸ¥©', nameBn: 'à¦®à¦¾à¦‚à¦¸ à¦“ à¦¡à¦¿à¦®', nameEn: 'Meat & Poultry' },
                    { key: 'rice_flour', icon: 'ðŸš', nameBn: 'à¦šà¦¾à¦² à¦“ à¦®à§Ÿà¦¦à¦¾', nameEn: 'Rice & Grains' },
                    { key: 'oil_spices', icon: 'ðŸ›¢ï¸', nameBn: 'à¦¤à§‡à¦² à¦“ à¦®à¦¸à¦²à¦¾', nameEn: 'Oil & Spices' },
                    { key: 'vegetables', icon: 'ðŸ¥¦', nameBn: 'à¦¶à¦¾à¦•à¦¸à¦¬à¦œà¦¿ à¦“ à¦•à¦¾à¦à¦šà¦¾à¦¬à¦¾à¦œà¦¾à¦°', nameEn: 'Vegetables' },
                    { key: 'dairy', icon: 'ðŸ¥›', nameBn: 'à¦¦à§à¦§ à¦“ à¦®à¦¿à¦·à§à¦Ÿà¦¿', nameEn: 'Dairy & Curd' },
                    { key: 'packaging', icon: 'ðŸ“¦', nameBn: 'à¦ªà§à¦¯à¦¾à¦•à§‡à¦œà¦¿à¦‚ à¦¬à¦•à§à¦¸', nameEn: 'Packaging' },
                    { key: 'gas_utility', icon: 'ðŸ”¥', nameBn: 'à¦—à§à¦¯à¦¾à¦¸ à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦°', nameEn: 'Gas & Fuel' },
                    { key: 'other', icon: 'ðŸ§¾', nameBn: 'à¦…à¦¨à§à¦¯à¦¾à¦¨à§à¦¯ à¦–à¦°à¦š', nameEn: 'Other Expense' }
                ],
                rawItemPresets: [
                    { name: 'à¦¬à§à¦°à§Ÿà¦²à¦¾à¦° à¦®à§à¦°à¦—à¦¿', category: 'meat', unit: 'à¦•à§‡à¦œà¦¿', defaultPrice: 195, icon: 'ðŸ—' },
                    { name: 'à¦¦à§‡à¦¶à¦¿ à¦–à¦¾à¦¸à¦¿à¦° à¦®à¦¾à¦‚à¦¸', category: 'meat', unit: 'à¦•à§‡à¦œà¦¿', defaultPrice: 850, icon: 'ðŸ¥©' },
                    { name: 'à¦ªà§‹à¦²à¦¾à¦“ à¦šà¦¾à¦² (à¦šà¦¿à¦¨à¦¿à¦—à§à¦à§œà¦¾)', category: 'rice_flour', unit: 'à¦•à§‡à¦œà¦¿', defaultPrice: 140, icon: 'ðŸš' },
                    { name: 'à¦¬à¦¾à¦¸à¦®à¦¤à§€ à¦²à¦‚ à¦—à§à¦°à§‡à¦‡à¦¨ à¦šà¦¾à¦²', category: 'rice_flour', unit: 'à¦•à§‡à¦œà¦¿', defaultPrice: 180, icon: 'ðŸŒ¾' },
                    { name: 'à¦¤à§€à¦° à¦¸à§Ÿà¦¾à¦¬à¦¿à¦¨ à¦¤à§‡à¦² (à§« à¦²à¦¿à¦Ÿà¦¾à¦°)', category: 'oil_spices', unit: 'à¦²à¦¿à¦Ÿà¦¾à¦°', defaultPrice: 165, icon: 'ðŸ›¢ï¸' },
                    { name: 'à¦«à¦¾à¦°à§à¦®à§‡à¦° à¦²à¦¾à¦² à¦¡à¦¿à¦® (à§§ à¦•à§‡à¦¸)', category: 'meat', unit: 'à¦•à§‡à¦¸', defaultPrice: 1050, icon: 'ðŸ¥š' },
                    { name: 'à¦ªà§‡à¦à§Ÿà¦¾à¦œ, à¦°à¦¸à§à¦¨ à¦“ à¦†à¦¦à¦¾', category: 'vegetables', unit: 'à¦•à§‡à¦œà¦¿', defaultPrice: 110, icon: 'ðŸ§…' },
                    { name: 'à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦®à¦¸à¦²à¦¾', category: 'oil_spices', unit: 'à¦ªà§à¦¯à¦¾à¦•à§‡à¦Ÿ', defaultPrice: 320, icon: 'ðŸŒ¶ï¸' },
                    { name: 'à§§à§¨ à¦•à§‡à¦œà¦¿ à¦°à¦¾à¦¨à§à¦¨à¦¾à¦° à¦—à§à¦¯à¦¾à¦¸ à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦°', category: 'gas_utility', unit: 'à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦°', defaultPrice: 1450, icon: 'ðŸ”¥' },
                    { name: 'à¦«à§à¦¡ à¦Ÿà§‡à¦•à¦…à§à¦¯à¦¾à¦“à§Ÿà§‡ à¦ªà§à¦¯à¦¾à¦•à§‡à¦œà¦¿à¦‚ à¦¬à¦•à§à¦¸', category: 'packaging', unit: 'à¦ªà¦¿à¦¸', defaultPrice: 8, icon: 'ðŸ“¦' }
                ],
                rawItemsCosts: [],

                // Reactive Selling Quantities for Food Cards
                itemSaleQty: {},
                getItemSaleQty(id) {
                    if (!id) return 1;
                    return (this.itemSaleQty && this.itemSaleQty[id]) ? this.itemSaleQty[id] : 1;
                },
                setItemSaleQty(id, val) {
                    if (!id) return;
                    const q = Math.max(1, Math.min(99, parseInt(val) || 1));
                    this.itemSaleQty = { ...this.itemSaleQty, [id]: q };
                },
                stepItemSaleQty(id, delta) {
                    if (!id) return;
                    const current = this.getItemSaleQty(id);
                    this.setItemSaleQty(id, current + delta);
                },

                dict: {
                    bn: {
                        brandName: 'à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿ POS',
                        hubLocation: 'à¦¢à¦¾à¦•à¦¾ à¦¹à¦¾à¦¬',
                        posTerminalStatus: 'à¦…à¦¨à¦²à¦¾à¦‡à¦¨',
                        todaySalesLabel: 'à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à¦¿',
                        ordersCountLabel: 'à¦…à¦°à§à¦¡à¦¾à¦°',
                        tabPos: 'à¦•à§à¦¯à¦¾à¦¶ à¦°à§‡à¦œà¦¿à¦¸à§à¦Ÿà¦¾à¦°',
                        tabAnalytics: 'à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦°à¦¿à¦ªà§‹à¦°à§à¦Ÿ',
                        tabLedger: 'à¦¸à§‡à¦²à¦¸ à¦²à§‡à¦œà¦¾à¦°',
                        tabMenu: 'à¦®à§‡à¦¨à§ à¦“ à¦ªà§à¦°à¦¾à¦‡à¦¸à¦¿à¦‚',
                        tabExport: 'à¦à¦•à§à¦¸à¦ªà§‹à¦°à§à¦Ÿ à¦“ à¦¸à§‡à¦Ÿà¦¿à¦‚à¦¸',
                        addNewItemBtn: 'à¦¨à¦¤à§à¦¨ à¦†à¦‡à¦Ÿà§‡à¦®',
                        searchPlaceholder: 'à¦–à¦¾à¦¬à¦¾à¦° à¦–à§à¦à¦œà§à¦¨ à¦¬à¦¾ à¦¶à¦°à§à¦Ÿà¦•à¦¾à¦Ÿ ( / )...',
                        activeTicketTitle: 'à¦šà¦²à¦¤à¦¿ à¦…à¦°à§à¦¡à¦¾à¦° à¦Ÿà¦¿à¦•à¦¿à¦Ÿ',
                        reactiveCalcSubtitle: 'à¦°à¦¿à§Ÿà§‡à¦²-à¦Ÿà¦¾à¦‡à¦® à¦•à§à¦¯à¦¾à¦²à¦•à§à¦²à§‡à¦Ÿà¦°',
                        clearBtn: 'à¦®à§à¦›à§à¦¨',
                        dineInLabel: 'à¦¡à¦¾à¦‡à¦¨-à¦‡à¦¨',
                        takeawayLabel: 'à¦ªà¦¾à¦°à§à¦¸à§‡à¦²',
                        customerRefPlaceholder: 'à¦Ÿà§‡à¦¬à¦¿à¦² à¦¬à¦¾ à¦¨à¦¾à¦®...',
                        emptyCartTitle: 'à¦•à§‹à¦¨ à¦–à¦¾à¦¬à¦¾à¦° à¦¸à¦¿à¦²à§‡à¦•à§à¦Ÿ à¦•à¦°à¦¾ à¦¹à§Ÿà¦¨à¦¿',
                        emptyCartDesc: 'à¦®à§‡à¦¨à§ à¦¥à§‡à¦•à§‡ à¦†à¦‡à¦Ÿà§‡à¦®à§‡ à¦Ÿà§à¦¯à¦¾à¦ª à¦•à¦°à§‡ à¦…à¦°à§à¦¡à¦¾à¦° à¦¶à§à¦°à§ à¦•à¦°à§à¦¨',
                        discountLabel: 'à¦¡à¦¿à¦¸à¦•à¦¾à¦‰à¦¨à§à¦Ÿ',
                        subtotalLabel: 'à¦¸à¦¾à¦¬à¦Ÿà§‹à¦Ÿà¦¾à¦²',
                        vatLabel: 'à¦­à§à¦¯à¦¾à¦Ÿ',
                        grandTotalLabel: 'à¦¸à¦°à§à¦¬à¦®à§‹à¦Ÿ à¦¬à¦¿à¦²',
                        selectPaymentMethodLabel: 'à¦ªà§‡à¦®à§‡à¦¨à§à¦Ÿ à¦®à§‡à¦¥à¦¡',
                        completeOrderBtn: 'à¦…à¦°à§à¦¡à¦¾à¦° à¦¸à¦®à§à¦ªà¦¨à§à¦¨ à¦“ à¦°à¦¶à¦¿à¦¦ à¦ªà§à¦°à¦¿à¦¨à§à¦Ÿ',
                        kpiTotalRevenue: 'à¦®à§‹à¦Ÿ à¦¸à¦‚à¦—à§ƒà¦¹à§€à¦¤ à¦¬à¦¿à¦•à§à¦°à§Ÿ',
                        kpiTotalOrders: 'à¦®à§‹à¦Ÿ à¦¸à¦®à§à¦ªà¦¨à§à¦¨ à¦…à¦°à§à¦¡à¦¾à¦°',
                        kpiAov: 'à¦—à§œ à¦…à¦°à§à¦¡à¦¾à¦° à¦¸à¦¾à¦‡à¦œ',
                        kpiProfit: 'à¦†à¦¨à§à¦®à¦¾à¦¨à¦¿à¦• à¦¨à¦¿à¦Ÿ à¦²à¦¾à¦­',
                        revenueTrendTitle: 'à¦¦à§ˆà¦¨à¦¿à¦• à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦Ÿà§à¦°à§‡à¦¨à§à¦¡',
                        revenueTrendSubtitle: 'à¦¸à¦¾à¦¤ à¦¦à¦¿à¦¨à§‡à¦° à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦ªà§à¦°à¦¬à§ƒà¦¦à§à¦§à¦¿',
                        searchLedgerPlaceholder: 'à¦®à§‡à¦®à§‹ à¦¨à¦‚ à¦¬à¦¾ à¦ªà§‡à¦®à§‡à¦¨à§à¦Ÿ à¦¸à¦¾à¦°à§à¦š...',
                        menuSubtitle: 'à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¬à¦¿à¦•à§à¦°à§Ÿà¦®à§‚à¦²à§à¦¯ à¦“ à¦¸à§à¦Ÿà¦• à¦†à¦ªà¦¡à§‡à¦Ÿ à¦•à¦°à§à¦¨'
                    },
                    en: {
                        brandName: 'KhabarBari POS',
                        hubLocation: 'Dhaka Hub',
                        posTerminalStatus: 'Online',
                        todaySalesLabel: "Today's Sales",
                        ordersCountLabel: 'Orders',
                        tabPos: 'Daily Sales POS',
                        tabAnalytics: 'Sales Analytics',
                        tabLedger: 'Sales Ledger',
                        tabMenu: 'Menu Engine',
                        tabExport: 'Export & Settings',
                        addNewItemBtn: 'Add Item',
                        searchPlaceholder: 'Search foods or press ( / )...',
                        activeTicketTitle: 'Active Ticket',
                        reactiveCalcSubtitle: 'Real-time calculation',
                        clearBtn: 'Clear',
                        dineInLabel: 'Dine-in',
                        takeawayLabel: 'Takeout',
                        customerRefPlaceholder: 'Table # or Name...',
                        emptyCartTitle: 'No items in ticket yet',
                        emptyCartDesc: 'Tap any menu item to build ticket',
                        discountLabel: 'Discount',
                        subtotalLabel: 'Subtotal',
                        vatLabel: 'VAT',
                        grandTotalLabel: 'Grand Total',
                        selectPaymentMethodLabel: 'Payment Method',
                        completeOrderBtn: 'Complete Order & Print',
                        kpiTotalRevenue: 'Total Gross Revenue',
                        kpiTotalOrders: 'Total Orders',
                        kpiAov: 'Avg Ticket Value',
                        kpiProfit: 'Estimated Net Profit',
                        revenueTrendTitle: 'Daily Revenue Trend',
                        revenueTrendSubtitle: '7-day velocity curve',
                        searchLedgerPlaceholder: 'Search order # or payment...',
                        menuSubtitle: 'Update prices and stock'
                    }
                },

                t(key) {
                    return this.dict[this.lang][key] || key;
                },

                setBrightness(val) {
                    this.brightnessLevel = val;
                    this.saveBrightness();
                    this.showToast(`à¦¬à§à¦°à¦¾à¦‡à¦Ÿà¦¨à§‡à¦¸: ${val}%`, 'ðŸ’¡');
                },

                cycleBrightness() {
                    const levels = [100, 90, 80, 70, 60];
                    let currentIdx = levels.indexOf(this.brightnessLevel);
                    let nextLevel = (currentIdx === -1 || currentIdx === levels.length - 1) ? levels[0] : levels[currentIdx + 1];
                    this.setBrightness(nextLevel);
                },

                saveBrightness() {
                    localStorage.setItem('khabarbari_brightness', this.brightnessLevel);
                },

                showToast(msg, icon = 'âœ¨', type = 'success') {
                    if (this.toast.timer) clearTimeout(this.toast.timer);
                    this.toast.message = msg;
                    this.toast.icon = icon;
                    this.toast.type = type;
                    this.toast.show = true;
                    this.toast.timer = setTimeout(() => {
                        this.toast.show = false;
                    }, 2000);
                },

                _audioCtx: null,
                getAudioContext() {
                    if (!this._audioCtx && (window.AudioContext || window.webkitAudioContext)) {
                        this._audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    }
                    if (this._audioCtx && this._audioCtx.state === 'suspended') {
                        this._audioCtx.resume();
                    }
                    return this._audioCtx;
                },

                playChime(freq = 520, duration = 0.08) {
                    if (!this.soundEnabled) return;
                    try {
                        const ctx = this.getAudioContext();
                        if (!ctx) return;
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, ctx.currentTime);
                        gain.gain.setValueAtTime(0.06, ctx.currentTime);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration);
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start();
                        osc.stop(ctx.currentTime + duration);
                    } catch(e) {}
                },

                playSuccessChime() {
                    if (!this.soundEnabled) return;
                    try {
                        this.playChime(523, 0.1);
                        setTimeout(() => this.playChime(659, 0.1), 100);
                        setTimeout(() => this.playChime(784, 0.18), 200);
                    } catch(e) {}
                },

                toggleTheme() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('khabarbari_theme', this.isDark ? 'dark' : 'light');
                    this.showToast(this.isDark ? 'à¦¡à¦¾à¦°à§à¦• à¦®à§‹à¦¡ à¦¸à¦•à§à¦°à¦¿à§Ÿ ðŸŒ™' : 'à¦¸à¦«à¦Ÿ à¦²à¦¾à¦‡à¦Ÿ à¦®à§‹à¦¡ à¦¸à¦•à§à¦°à¦¿à§Ÿ â˜€ï¸');
                },

                setLanguage(selectedLang) {
                    this.lang = selectedLang;
                    document.documentElement.lang = selectedLang;
                    localStorage.setItem('khabarbari_lang', selectedLang);
                    this.showToast(selectedLang === 'bn' ? 'à¦¬à¦¾à¦‚à¦²à¦¾ à¦­à¦¾à¦·à¦¾ à¦¨à¦¿à¦°à§à¦¬à¦¾à¦šà¦¨ à¦•à¦°à¦¾ à¦¹à§Ÿà§‡à¦›à§‡ ðŸ‡§ðŸ‡©' : 'Language set to English ðŸ‡¬ðŸ‡§');
                },

                toggleLanguage() {
                    const nextLang = this.lang === 'bn' ? 'en' : 'bn';
                    this.setLanguage(nextLang);
                },

                initApp() {
                    const savedTheme = localStorage.getItem('khabarbari_theme');
                    if (savedTheme) {
                        this.isDark = savedTheme === 'dark';
                    }

                    const savedBrightness = localStorage.getItem('khabarbari_brightness');
                    if (savedBrightness) {
                        this.brightnessLevel = Number(savedBrightness);
                    }

                    const savedLang = localStorage.getItem('khabarbari_lang');
                    if (savedLang) this.setLanguage(savedLang);

                    const savedAdmin = localStorage.getItem('khabarbari_admin_session');
                    if (savedAdmin) {
                        try {
                            const parsed = JSON.parse(savedAdmin);
                            this.isAdminLoggedIn = parsed.isLoggedIn || false;
                            if (parsed.user) this.adminUser = parsed.user;
                            // Backward compat: if role missing default to superadmin
                            this.currentUserRole = parsed.role || (this.isAdminLoggedIn ? 'superadmin' : 'guest');
                            if (parsed.ownerId) this.currentOwnerId = parsed.ownerId;
                        } catch(e) {}
                    }

                    const savedSettings = localStorage.getItem('khabarbari_settings_v3');
                    if (savedSettings) {
                        try {
                            this.posSettings = { ...this.posSettings, ...JSON.parse(savedSettings) };
                        } catch(e) {}
                    }

                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                    this.loadStoredData();

                    // Register Offline-First Service Worker
                    if ('serviceWorker' in navigator) {
                        navigator.serviceWorker.register('./sw.js').then((reg) => {
                            console.log('[PWA] Service Worker active! App works 100% offline.');
                        }).catch((err) => {
                            console.log('[PWA] Service worker registration error:', err);
                        });
                    }

                    // Android 1-Click Install App / APK Prompt
                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        this.deferredInstallPrompt = e;
                        this.showInstallAppBanner = true;
                    });
                },

                updateTime() {
                    const now = new Date();
                    const newTime = now.toLocaleTimeString('en-US', { 
                        timeZone: 'Asia/Dhaka',
                        hour: '2-digit', 
                        minute: '2-digit',
                        hour12: true
                    });
                    if (this.currentDhakaTime !== newTime) {
                        this.currentDhakaTime = newTime;
                    }
                },

                openAdminLoginModal() {
                    this.adminLoginError = '';
                    this.adminEmail = this.adminEmail || 'admin@foodcourt.com';
                    this.adminPassword = '';
                    this.showAdminLoginModal = true;
                },

                quickFillAdminDemo() {
                    this.adminEmail = 'admin@foodcourt.com';
                    this.adminPassword = 'admin123';
                    this.adminLoginError = '';
                },

                // ---- MULTI-TENANT ACCOUNTS & STALL GETTERS ----
                get ownerAccounts() {
                    return Array.isArray(this.accounts) ? this.accounts.filter(a => a.role === 'owner') : [];
                },

                getOwnerById(ownerId) {
                    if (!ownerId) return null;
                    return (this.accounts || []).find(a => a.id === ownerId) || null;
                },

                getActiveFoodCourtTitle() {
                    if (this.currentUserRole === 'owner') {
                        return this.adminUser.shopName || this.posSettings.storeName;
                    }
                    if (this.currentUserRole === 'superadmin') {
                        if (this.adminViewingOwnerId === 'all' || !this.adminViewingOwnerId) {
                            return (this.lang === 'bn' ? 'à¦¸à§‡à¦¨à§à¦Ÿà§à¦°à¦¾à¦² à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦¹à¦¾à¦¬ (à¦¸à¦•à¦² à¦¸à§à¦Ÿà¦²)' : 'Central Food Court Hub (All Stalls)');
                        }
                        const owner = this.getOwnerById(this.adminViewingOwnerId);
                        return owner ? owner.shopName : this.posSettings.storeName;
                    }
                    return this.lang === 'bn' ? (this.posSettings.storeName || 'à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿ POS & à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ') : 'KhabarBari POS & Food Cart';
                },

                getAccounts() {
                    try {
                        const saved = localStorage.getItem('khabarbari_accounts_v3');
                        if (saved) {
                            const parsed = JSON.parse(saved);
                            if (Array.isArray(parsed) && parsed.length > 0) return parsed;
                        }
                    } catch(e) {}

                    // Pre-seeded Multi-Food Court Stalls
                    const defaults = [
                        {
                            id: 'superadmin',
                            name: 'Super Admin',
                            shopName: 'à¦¸à§‡à¦¨à§à¦Ÿà§à¦°à¦¾à¦² à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦•à¦¨à§à¦Ÿà§à¦°à§‹à¦² à¦¹à¦¾à¦¬',
                            stallNo: 'Main Control',
                            phone: '+880 1711-000000',
                            email: 'admin@foodcourt.com',
                            password: 'admin123',
                            role: 'superadmin'
                        },
                        {
                            id: 'fc_kacchi',
                            name: 'à¦¤à¦¾à¦¨à¦­à§€à¦° à¦†à¦¹à¦®à§‡à¦¦',
                            shopName: 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ',
                            stallNo: 'Stall #01',
                            phone: '+880 1711-112233',
                            email: 'kacchi@foodcourt.com',
                            password: 'kacchi123',
                            role: 'owner'
                        },
                        {
                            id: 'fc_burger',
                            name: 'à¦«à¦¾à¦°à¦¹à¦¾à¦¨ à¦šà§Œà¦§à§à¦°à§€',
                            shopName: 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦à¦•à§à¦¸à¦ªà§à¦°à§‡à¦¸ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ',
                            stallNo: 'Stall #02',
                            phone: '+880 1722-445566',
                            email: 'burger@foodcourt.com',
                            password: 'burger123',
                            role: 'owner'
                        }
                    ];
                    localStorage.setItem('khabarbari_accounts_v3', JSON.stringify(defaults));
                    return defaults;
                },

                saveAccounts(accountsList) {
                    this.accounts = accountsList;
                    localStorage.setItem('khabarbari_accounts_v2', JSON.stringify(accountsList));
                },

                // ---- OPEN COURT & CLOSE COURT (DAILY OPERATIONAL CYCLE) ----
                openCourtModal() {
                    this.openCourtForm = {
                        openingFloat: 0,
                        note: ''
                    };
                    this.showOpenCourtModal = true;
                },

                confirmOpenCourt() {
                    const now = new Date();
                    const timeStr = this.currentDhakaTime || now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                    const dateStr = now.toLocaleDateString('en-CA');

                    this.isCourtOpen = true;
                    this.courtSession = {
                        sessionId: 'sess_' + Date.now(),
                        openedAt: timeStr,
                        openedDate: dateStr,
                        closedAt: '',
                        openingFloat: Number(this.openCourtForm.openingFloat || 0),
                        closingNotes: this.openCourtForm.note || ''
                    };

                    this.saveCourtStatus();
                    this.showOpenCourtModal = false;
                    const courtName = this.getActiveFoodCourtTitle();
                    this.showToast((this.lang === 'bn' ? 'ðŸŸ¢ ' + courtName + ' à¦“à¦ªà§‡à¦¨ à¦¸à¦®à§à¦ªà¦¨à§à¦¨! à¦†à¦œà¦•à§‡à¦° à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¶à§à¦°à§ à¦•à¦°à§à¦¨' : 'ðŸŸ¢ ' + courtName + ' is now OPEN! Ready for sales'), 'ðŸŸ¢');
                    this.playSuccessChime();
                },

                openCloseCourtModal() {
                    this.showCloseCourtModal = true;
                },

                confirmCloseCourt() {
                    const now = new Date();
                    const closeTimeStr = this.currentDhakaTime || now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                    
                    this.isCourtOpen = false;
                    this.courtSession.closedAt = closeTimeStr;

                    // Create archived Z-Report record for this closed day
                    const sessionSummary = {
                        ...this.courtSession,
                        foodCourtId: this.getEffectiveOwnerId() || 'all',
                        foodCourtName: this.getActiveFoodCourtTitle(),
                        salesTotal: this.todayStats.totalRevenue,
                        ordersTotal: this.todayStats.totalOrders,
                        cashTotal: this.todayStats.cashTotal,
                        bkashTotal: this.todayStats.bkashTotal,
                        nagadTotal: this.todayStats.nagadTotal,
                        rawCostTotal: this.todayStats.todayRawCost,
                        netProfit: this.todayStats.todayNetProfit,
                        closedAtTimestamp: Date.now()
                    };

                    this.closedSessionsHistory.unshift(sessionSummary);
                    this.saveCourtStatus();
                    this.showCloseCourtModal = false;
                    this.showToast((this.lang === 'bn' ? 'ðŸ à¦†à¦œà¦•à§‡à¦° à¦¦à¦¿à¦¨ à¦¸à¦«à¦²à¦­à¦¾à¦¬à§‡ à¦¸à¦®à¦¾à¦ªà§à¦¤ à¦“ à¦•à¦¾à¦°à§à¦Ÿ à¦•à§à¦²à§‹à¦œ à¦¹à§Ÿà§‡à¦›à§‡!' : 'ðŸ Cart closed for today! Z-Report saved'), 'ðŸ');
                    this.playChime(420);
                },

                saveCourtStatus() {
                    try {
                        const ownerId = this.getEffectiveOwnerId() || 'global';
                        const data = {
                            isCourtOpen: this.isCourtOpen,
                            courtSession: this.courtSession,
                            closedSessionsHistory: this.closedSessionsHistory
                        };
                        localStorage.setItem('khabarbari_fc_' + ownerId + '_court_status', JSON.stringify(data));
                    } catch(e) {}
                },

                loadCourtStatus() {
                    try {
                        const ownerId = this.getEffectiveOwnerId() || 'global';
                        const raw = localStorage.getItem('khabarbari_fc_' + ownerId + '_court_status');
                        if (raw) {
                            const parsed = JSON.parse(raw);
                            this.isCourtOpen = parsed.isCourtOpen === true;
                            this.courtSession = parsed.courtSession || { sessionId: '', openedAt: '', openedDate: '', closedAt: '', openingFloat: 0 };
                            this.closedSessionsHistory = parsed.closedSessionsHistory || [];
                        } else {
                            this.isCourtOpen = false;
                            this.courtSession = { sessionId: '', openedAt: '', openedDate: '', closedAt: '', openingFloat: 0 };
                            this.closedSessionsHistory = [];
                        }
                    } catch(e) {}
                },

                printZReport() {
                    window.print();
                },

                // Multi-Tenant Cross-Stall Financial Aggregate Getters
                getAllFoodCourtsTotalSales() {
                    let total = 0;
                    this.ownerAccounts.forEach(owner => {
                        total += this.getFoodCourtStats(owner.id).sales;
                    });
                    return total;
                },

                getAllFoodCourtsTotalOrders() {
                    let total = 0;
                    this.ownerAccounts.forEach(owner => {
                        total += this.getFoodCourtStats(owner.id).orders;
                    });
                    return total;
                },

                getAllFoodCourtsTotalItems() {
                    let total = 0;
                    this.ownerAccounts.forEach(owner => {
                        try {
                            const raw = localStorage.getItem('khabarbari_fc_' + owner.id + '_menu');
                            if (raw) {
                                const list = JSON.parse(raw);
                                if (Array.isArray(list)) total += list.length;
                            }
                        } catch(e) {}
                    });
                    return Math.max(total, this.menuItems.length);
                },

                getFoodCourtStats(ownerId) {
                    let sales = 0;
                    let orders = 0;
                    try {
                        const raw = localStorage.getItem('khabarbari_fc_' + ownerId + '_sales');
                        if (raw) {
                            const list = JSON.parse(raw);
                            if (Array.isArray(list)) {
                                orders = list.length;
                                sales = list.reduce((s, o) => s + (Number(o.grandTotal) || 0), 0);
                            }
                        }
                    } catch(e) {}
                    return { sales, orders };
                },

                // Secure Authentication Handler
                handleAdminLogin() {
                    const email = (this.adminEmail || '').trim().toLowerCase();
                    const password = (this.adminPassword || '').trim();

                    if (!email || !password) {
                        this.adminLoginError = (this.lang === 'bn' ? 'à¦‡à¦®à§‡à¦‡à¦² à¦“ à¦ªà¦¾à¦¸à¦“à§Ÿà¦¾à¦°à§à¦¡ à¦ªà§à¦°à¦¦à¦¾à¦¨ à¦•à¦°à§à¦¨' : 'Please enter email and password');
                        return;
                    }

                    if (!this.accounts || this.accounts.length === 0) {
                        this.accounts = this.getAccounts();
                    }

                    const found = this.accounts.find(a => (a.email || '').toLowerCase() === email);

                    if (!found || found.password !== password) {
                        this.adminLoginError = this.lang === 'bn'
                            ? 'à¦­à§à¦² à¦‡à¦®à§‡à¦‡à¦² à¦¬à¦¾ à¦ªà¦¾à¦¸à¦“à§Ÿà¦¾à¦°à§à¦¡! à¦…à¦¨à§à¦—à§à¦°à¦¹ à¦•à¦°à§‡ à¦¸à¦ à¦¿à¦• à¦¤à¦¥à§à¦¯ à¦¦à¦¿à¦¨à¥¤'
                            : 'Incorrect email or password. Please try again.';
                        return;
                    }

                    this.isAdminLoggedIn = true;
                    this.currentUserRole = found.role || 'owner';
                    this.currentOwnerId = found.role === 'superadmin' ? null : found.id;
                    this.adminViewingOwnerId = found.role === 'superadmin' ? 'all' : found.id;
                    this.adminUser = { 
                        name: found.name, 
                        email: found.email, 
                        shopName: found.shopName || (found.name + ' à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ'),
                        stallNo: found.stallNo || ''
                    };

                    localStorage.setItem('khabarbari_admin_session', JSON.stringify({
                        isLoggedIn: true,
                        user: this.adminUser,
                        role: this.currentUserRole,
                        ownerId: this.currentOwnerId,
                        adminViewingOwnerId: this.adminViewingOwnerId
                    }));

                    this.showAdminLoginModal = false;
                    this.adminLoginError = '';
                    this.loadStoredData();

                    if (found.role === 'superadmin') {
                        this.activeTab = 'login'; // Main Admin lands on Central Multi-Tenant Hub!
                        this.showToast((this.lang === 'bn' ? 'ðŸ‘‘ à¦¸à§à¦ªà¦¾à¦° à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦¸à§‡à¦¨à§à¦Ÿà§à¦°à¦¾à¦² à¦•à¦¨à§à¦Ÿà§à¦°à§‹à¦² à¦ªà§à¦¯à¦¾à¦¨à§‡à¦²à§‡ à¦¸à§à¦¬à¦¾à¦—à¦¤à¦®!' : 'Welcome Super Admin to Central Control!'), 'ðŸ‘‘');
                    } else {
                        this.activeTab = 'pos'; // Food Court Owner lands on their POS to start selling!
                        this.showToast((this.lang === 'bn' ? 'à¦¸à§à¦¬à¦¾à¦—à¦¤à¦® ' + found.name + '! ðŸ” ' + found.shopName + ' à¦ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¶à§à¦°à§ à¦•à¦°à§à¦¨' : 'Welcome ' + found.name + '! Start selling at ' + found.shopName), 'âœ…');
                    }
                    this.playSuccessChime();
                },

                // Super Admin switches viewing context
                adminSwitchToOwner(ownerId) {
                    if (this.currentUserRole !== 'superadmin') return;
                    this.adminViewingOwnerId = ownerId;
                    this.loadStoredData();
                    if (ownerId === 'all') {
                        this.showToast((this.lang === 'bn' ? 'ðŸŒ à¦¸à¦•à¦² à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡à¦° à¦¸à¦®à§à¦®à¦¿à¦²à¦¿à¦¤ à¦­à¦¿à¦‰ à¦¸à¦•à§à¦°à¦¿à§Ÿ' : 'Switched to All Food Courts View'), 'ðŸŒ');
                    } else {
                        const owner = this.getOwnerById(ownerId);
                        this.showToast((this.lang === 'bn' ? 'ðŸª ' + (owner?.shopName || 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ') + ' à¦ à¦¸à§à¦‡à¦š à¦•à¦°à¦¾ à¦¹à§Ÿà§‡à¦›à§‡' : 'Switched to ' + (owner?.shopName || 'Food Court')), 'ðŸ‘ï¸');
                    }
                    this.playChime(600);
                },

                logoutAdmin() {
                    this.isAdminLoggedIn = false;
                    this.currentUserRole = 'guest';
                    this.currentOwnerId = null;
                    this.adminViewingOwnerId = 'all';
                    this.showOwnerManagement = false;
                    localStorage.removeItem('khabarbari_admin_session');
                    this.activeTab = 'login';
                    this.loadStoredData();
                    this.showToast(this.lang === 'bn' ? 'à¦¸à¦«à¦²à¦­à¦¾à¦¬à§‡ à¦²à¦—à¦†à¦‰à¦Ÿ à¦¹à§Ÿà§‡à¦›à§‡à¥¤ à¦†à¦¬à¦¾à¦° à¦¦à§‡à¦–à¦¾ à¦¹à¦¬à§‡! ðŸ‘‹' : 'Successfully logged out ðŸ‘‹');
                },

                // Food Court Owner CRUD
                openAddOwnerModal() {
                    this.ownerFormMode = 'add';
                    this.editingOwnerId = null;
                    this.ownerForm = { id: '', name: '', shopName: '', stallNo: 'Stall #' + (this.ownerAccounts.length + 1).toString().padStart(2, '0'), phone: '', email: '', password: '', confirmPassword: '' };
                    this.ownerFormError = '';
                    this.ownerFormSuccess = '';
                    this.showAddOwnerModal = true;
                },

                openEditOwnerModal(owner) {
                    this.ownerFormMode = 'edit';
                    this.editingOwnerId = owner.id;
                    this.ownerForm = { ...owner, confirmPassword: owner.password };
                    this.ownerFormError = '';
                    this.ownerFormSuccess = '';
                    this.showAddOwnerModal = true;
                },

                saveOwner() {
                    const { name, shopName, stallNo, phone, email, password, confirmPassword } = this.ownerForm;
                    this.ownerFormError = '';
                    this.ownerFormSuccess = '';

                    if (!name.trim() || !email.trim() || !password.trim()) {
                        this.ownerFormError = (this.lang === 'bn' ? 'à¦¨à¦¾à¦®, à¦‡à¦®à§‡à¦‡à¦² à¦“ à¦ªà¦¾à¦¸à¦“à§Ÿà¦¾à¦°à§à¦¡ à¦†à¦¬à¦¶à§à¦¯à¦•à¥¤' : 'Name, email and password are required.');
                        return;
                    }
                    if (password !== confirmPassword) {
                        this.ownerFormError = (this.lang === 'bn' ? 'à¦ªà¦¾à¦¸à¦“à§Ÿà¦¾à¦°à§à¦¡ à¦¦à§à¦Ÿà¦¿ à¦®à¦¿à¦²à¦›à§‡ à¦¨à¦¾à¥¤' : 'Passwords do not match.');
                        return;
                    }
                    if (password.length < 4) {
                        this.ownerFormError = (this.lang === 'bn' ? 'à¦ªà¦¾à¦¸à¦“à§Ÿà¦¾à¦°à§à¦¡ à¦•à¦®à¦ªà¦•à§à¦·à§‡ à§ª à¦…à¦•à§à¦·à¦°à§‡à¦° à¦¹à¦¤à§‡ à¦¹à¦¬à§‡à¥¤' : 'Password must be at least 4 characters.');
                        return;
                    }

                    const accountsList = [...this.getAccounts()];

                    if (this.ownerFormMode === 'add') {
                        if (accountsList.find(a => (a.email || '').toLowerCase() === email.toLowerCase().trim())) {
                            this.ownerFormError = (this.lang === 'bn' ? 'à¦à¦‡ à¦‡à¦®à§‡à¦‡à¦² à¦‡à¦¤à¦¿à¦®à¦§à§à¦¯à§‡ à¦¬à§à¦¯à¦¬à¦¹à§ƒà¦¤ à¦¹à§Ÿà§‡à¦›à§‡à¥¤' : 'Email already registered.');
                            return;
                        }
                        const newOwner = {
                            id: 'fc_' + Date.now(),
                            name: name.trim(),
                            shopName: shopName.trim() || (name.trim() + ' à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ'),
                            stallNo: stallNo.trim() || ('Stall #' + (this.ownerAccounts.length + 1)),
                            phone: phone.trim() || '',
                            email: email.trim().toLowerCase(),
                            password: password,
                            role: 'owner'
                        };
                        accountsList.push(newOwner);
                        this.saveAccounts(accountsList);

                        // Seed initial starter menu for the new stall
                        const starterMenu = [
                            {
                                id: 'item_' + Date.now() + '_1',
                                name: 'Signature Dish',
                                nameBn: newOwner.shopName + ' à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¡à¦¿à¦¶',
                                code: 'SP-01',
                                category: 'biryani_rice',
                                image: 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=300&q=65&auto=format',
                                costPrice: 120,
                                price: 250,
                                stock: 50,
                                foodCourtId: newOwner.id,
                                foodCourtName: newOwner.shopName
                            }
                        ];
                        localStorage.setItem('khabarbari_fc_' + newOwner.id + '_menu', JSON.stringify(starterMenu));
                        localStorage.setItem('khabarbari_fc_' + newOwner.id + '_sales', JSON.stringify([]));
                        localStorage.setItem('khabarbari_fc_' + newOwner.id + '_raw', JSON.stringify([]));

                        this.ownerFormSuccess = (this.lang === 'bn' ? 'âœ“ à¦¨à¦¤à§à¦¨ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ à¦“ à¦®à¦¾à¦²à¦¿à¦• à¦¸à¦«à¦²à¦­à¦¾à¦¬à§‡ à¦¨à¦¿à¦¬à¦¨à§à¦§à¦¿à¦¤ à¦¹à§Ÿà§‡à¦›à§‡à¥¤' : 'Food court added successfully.');
                        this.showToast((newOwner.shopName + ' à¦¯à§‹à¦— à¦•à¦°à¦¾ à¦¹à§Ÿà§‡à¦›à§‡'), 'âœ…');
                    } else {
                        const idx = accountsList.findIndex(a => a.id === this.editingOwnerId);
                        if (idx === -1) {
                            this.ownerFormError = 'à¦®à¦¾à¦²à¦¿à¦• à¦ªà¦¾à¦“à§Ÿà¦¾ à¦¯à¦¾à§Ÿà¦¨à¦¿à¥¤';
                            return;
                        }
                        if (accountsList.find(a => (a.email || '').toLowerCase() === email.toLowerCase().trim() && a.id !== this.editingOwnerId)) {
                            this.ownerFormError = 'à¦à¦‡ à¦‡à¦®à§‡à¦‡à¦² à¦…à¦¨à§à¦¯ à¦à¦•à¦Ÿà¦¿ à¦à¦•à¦¾à¦‰à¦¨à§à¦Ÿà§‡ à¦¬à§à¦¯à¦¬à¦¹à§ƒà¦¤à¥¤';
                            return;
                        }
                        accountsList[idx] = {
                            ...accountsList[idx],
                            name: name.trim(),
                            shopName: shopName.trim() || accountsList[idx].shopName,
                            stallNo: stallNo.trim() || accountsList[idx].stallNo,
                            phone: phone.trim() || accountsList[idx].phone,
                            email: email.trim().toLowerCase(),
                            password: password
                        };
                        this.saveAccounts(accountsList);
                        this.ownerFormSuccess = (this.lang === 'bn' ? 'âœ“ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡à¦° à¦¤à¦¥à§à¦¯ à¦¸à¦«à¦²à¦­à¦¾à¦¬à§‡ à¦†à¦ªà¦¡à§‡à¦Ÿ à¦¹à§Ÿà§‡à¦›à§‡à¥¤' : 'Updated successfully.');
                        this.showToast((accountsList[idx].shopName + ' à¦†à¦ªà¦¡à§‡à¦Ÿ à¦¹à§Ÿà§‡à¦›à§‡'), 'âœ…');
                    }

                    this.playSuccessChime();
                    setTimeout(() => { this.showAddOwnerModal = false; }, 800);
                },

                deleteOwner(ownerId) {
                    if (this.currentUserRole !== 'superadmin') return;
                    const accountsList = this.getAccounts();
                    const owner = accountsList.find(a => a.id === ownerId);
                    if (!owner || owner.role === 'superadmin') {
                        this.showToast((this.lang === 'bn' ? 'à¦¸à§à¦ªà¦¾à¦° à¦…à§à¦¯à¦¾à¦¡à¦®à¦¿à¦¨ à¦®à§à¦›à§‡ à¦«à§‡à¦²à¦¾ à¦¯à¦¾à¦¬à§‡ à¦¨à¦¾à¥¤' : 'Cannot delete Super Admin'), 'âš ï¸');
                        return;
                    }
                    if (!confirm(this.lang === 'bn' ? 'à¦†à¦ªà¦¨à¦¿ à¦•à¦¿ à¦¸à¦¤à§à¦¯à¦¿à¦‡ "' + owner.shopName + '" à¦®à§à¦›à§‡ à¦«à§‡à¦²à¦¤à§‡ à¦šà¦¾à¦¨? à¦à¦‡ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿà§‡à¦° à¦¸à¦•à¦² à¦–à¦¾à¦¦à§à¦¯ à¦¤à¦¾à¦²à¦¿à¦•à¦¾ à¦“ à¦¸à§‡à¦²à¦¸ à¦°à§‡à¦•à¦°à§à¦¡ à¦®à§à¦›à§‡ à¦¯à¦¾à¦¬à§‡à¥¤' : 'Delete this food court and all its data?')) {
                        return;
                    }
                    // Clean up scoped storage
                    localStorage.removeItem('khabarbari_fc_' + ownerId + '_menu');
                    localStorage.removeItem('khabarbari_fc_' + ownerId + '_sales');
                    localStorage.removeItem('khabarbari_fc_' + ownerId + '_raw');

                    const filtered = accountsList.filter(a => a.id !== ownerId);
                    this.saveAccounts(filtered);
                    if (this.adminViewingOwnerId === ownerId) {
                        this.adminViewingOwnerId = 'all';
                    }
                    this.loadStoredData();
                    this.showToast((owner.shopName + ' à¦®à§à¦›à§‡ à¦«à§‡à¦²à¦¾ à¦¹à§Ÿà§‡à¦›à§‡'), 'ðŸ—‘ï¸');
                    this.playChime(420);
                },

                // Storage scoped data loader and saver
                getEffectiveOwnerId() {
                    if (this.currentUserRole === 'owner') return this.currentOwnerId;
                    if (this.currentUserRole === 'superadmin' && this.adminViewingOwnerId && this.adminViewingOwnerId !== 'all') {
                        return this.adminViewingOwnerId;
                    }
                    return null;
                },

                saveToStorage() {
                    try {
                        const ownerId = this.getEffectiveOwnerId();
                        if (ownerId) {
                            localStorage.setItem('khabarbari_fc_' + ownerId + '_menu', JSON.stringify(this.menuItems));
                            localStorage.setItem('khabarbari_fc_' + ownerId + '_sales', JSON.stringify(this.salesHistory));
                            localStorage.setItem('khabarbari_fc_' + ownerId + '_raw', JSON.stringify(this.rawItemsCosts));
                        } else {
                            // Super Admin in 'all' view saves fallback
                            localStorage.setItem('khabarbari_menu_items_v6', JSON.stringify(this.menuItems));
                            localStorage.setItem('khabarbari_sales_history_v6', JSON.stringify(this.salesHistory));
                            localStorage.setItem('khabarbari_raw_costs_v1', JSON.stringify(this.rawItemsCosts));
                        }
                    } catch(e) {}
                },

                loadStoredData() {
                    this.accounts = this.getAccounts();
                    this.ensureDefaultStallsSeeded();
                    this.loadCourtStatus();

                    const ownerId = this.getEffectiveOwnerId();

                    if (ownerId) {
                        // LOAD SPECIFIC FOOD COURT DATA
                        const storedMenu = localStorage.getItem('khabarbari_fc_' + ownerId + '_menu');
                        const storedSales = localStorage.getItem('khabarbari_fc_' + ownerId + '_sales');
                        const storedRaw = localStorage.getItem('khabarbari_fc_' + ownerId + '_raw');

                        if (storedMenu) {
                            try { this.menuItems = JSON.parse(storedMenu); } catch(e) { this.menuItems = []; }
                        } else {
                            this.menuItems = [];
                        }

                        if (storedSales) {
                            try { this.salesHistory = JSON.parse(storedSales); } catch(e) { this.salesHistory = []; }
                        } else {
                            this.salesHistory = [];
                        }

                        if (storedRaw) {
                            try { this.rawItemsCosts = JSON.parse(storedRaw); } catch(e) { this.rawItemsCosts = []; }
                        } else {
                            this.rawItemsCosts = [];
                        }
                    } else {
                        // SUPER ADMIN 'ALL' VIEW: COMBINE AND AGGREGATE ALL FOOD COURTS
                        let combinedMenu = [];
                        let combinedSales = [];
                        let combinedRaw = [];

                        this.ownerAccounts.forEach(owner => {
                            try {
                                const m = localStorage.getItem('khabarbari_fc_' + owner.id + '_menu');
                                if (m) {
                                    const items = JSON.parse(m);
                                    if (Array.isArray(items)) {
                                        items.forEach(it => {
                                            combinedMenu.push({ ...it, foodCourtId: owner.id, foodCourtName: owner.shopName });
                                        });
                                    }
                                }
                                const s = localStorage.getItem('khabarbari_fc_' + owner.id + '_sales');
                                if (s) {
                                    const sales = JSON.parse(s);
                                    if (Array.isArray(sales)) {
                                        sales.forEach(sl => {
                                            combinedSales.push({ ...sl, foodCourtId: owner.id, foodCourtName: owner.shopName });
                                        });
                                    }
                                }
                                const r = localStorage.getItem('khabarbari_fc_' + owner.id + '_raw');
                                if (r) {
                                    const costs = JSON.parse(r);
                                    if (Array.isArray(costs)) {
                                        costs.forEach(c => {
                                            combinedRaw.push({ ...c, foodCourtId: owner.id, foodCourtName: owner.shopName });
                                        });
                                    }
                                }
                            } catch(e) {}
                        });

                        this.menuItems = combinedMenu.length > 0 ? combinedMenu : this.getDefaultKacchiItems();
                        this.salesHistory = combinedSales.sort((a, b) => (b.id > a.id ? 1 : -1));
                        this.rawItemsCosts = combinedRaw;
                    }
                },

                // Initial Seeding of realistic Food Court Menus
                ensureDefaultStallsSeeded() {
                    if (!localStorage.getItem('khabarbari_fc_fc_kacchi_menu')) {
                        localStorage.setItem('khabarbari_fc_fc_kacchi_menu', JSON.stringify(this.getDefaultKacchiItems()));
                    }
                    if (!localStorage.getItem('khabarbari_fc_fc_burger_menu')) {
                        localStorage.setItem('khabarbari_fc_fc_burger_menu', JSON.stringify(this.getDefaultBurgerItems()));
                    }
                    if (!localStorage.getItem('khabarbari_fc_fc_kacchi_sales')) {
                        const todayDateKey = new Date().toLocaleDateString('en-CA');
                        localStorage.setItem('khabarbari_fc_fc_kacchi_sales', JSON.stringify([
                            {
                                id: 'ord_k1',
                                orderId: 'MEMO-9842',
                                timestamp: 'Today, 02:45 PM',
                                orderDate: todayDateKey,
                                fullDate: todayDateKey,
                                type: 'Dine-in',
                                customerRef: 'Table 04',
                                paymentMethod: 'bKash',
                                foodCourtId: 'fc_kacchi',
                                foodCourtName: 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ',
                                items: [
                                    { id: 'k1', name: 'Special Mutton Kacchi Biryani', nameBn: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿', price: 450, quantity: 2, costPrice: 240 }
                                ],
                                itemsSummary: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ (x2) [bKash]',
                                totalQty: 2,
                                subtotal: 900,
                                discount: 0,
                                tax: 45,
                                grandTotal: 945,
                                profit: 420
                            }
                        ]));
                    }
                    if (!localStorage.getItem('khabarbari_fc_fc_burger_sales')) {
                        const todayDateKey = new Date().toLocaleDateString('en-CA');
                        localStorage.setItem('khabarbari_fc_fc_burger_sales', JSON.stringify([
                            {
                                id: 'ord_b1',
                                orderId: 'MEMO-7120',
                                timestamp: 'Today, 01:15 PM',
                                orderDate: todayDateKey,
                                fullDate: todayDateKey,
                                type: 'Takeaway',
                                customerRef: 'à¦•à¦¾à¦‰à¦¨à§à¦Ÿà¦¾à¦° à¦¸à§‡à¦²',
                                paymentMethod: 'Cash',
                                foodCourtId: 'fc_burger',
                                foodCourtName: 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦à¦•à§à¦¸à¦ªà§à¦°à§‡à¦¸ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ',
                                items: [
                                    { id: 'b1', name: 'Naga Crispy Chicken Burger', nameBn: 'à¦¨à¦¾à¦—à¦¾ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦šà¦¿à¦•à§‡à¦¨ à¦¬à¦¾à¦°à§à¦—à¦¾à¦°', price: 260, quantity: 2, costPrice: 110 },
                                    { id: 'b3', name: 'Peri Peri French Fries', nameBn: 'à¦ªà§‡à¦°à¦¿ à¦ªà§‡à¦°à¦¿ à¦®à¦¸à¦²à¦¾à¦¦à¦¾à¦° à¦«à§à¦°à¦¾à¦‡', price: 130, quantity: 1, costPrice: 45 }
                                ],
                                itemsSummary: 'à¦¨à¦¾à¦—à¦¾ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦¬à¦¾à¦°à§à¦—à¦¾à¦° (x2), à¦ªà§‡à¦°à¦¿ à¦ªà§‡à¦°à¦¿ à¦«à§à¦°à¦¾à¦‡ (x1) [Cash]',
                                totalQty: 3,
                                subtotal: 650,
                                discount: 0,
                                tax: 0,
                                grandTotal: 650,
                                profit: 385
                            }
                        ]));
                    }
                },

                getDefaultKacchiItems() {
                    return [
                        { id: 'k1', name: 'Special Mutton Kacchi Biryani', nameBn: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿', code: 'KB-01', category: 'biryani_rice', image: 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 240, price: 450, stock: 48, foodCourtId: 'fc_kacchi', foodCourtName: 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' },
                        { id: 'k2', name: 'Traditional Shahi Borhani', nameBn: 'à¦à¦¤à¦¿à¦¹à§à¦¯à¦¬à¦¾à¦¹à§€ à¦¶à¦¾à¦¹à§€ à¦¬à§‹à¦°à¦¹à¦¾à¦¨à¦¿', code: 'KB-02', category: 'beverages_cha', image: 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 35, price: 90, stock: 65, foodCourtId: 'fc_kacchi', foodCourtName: 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' },
                        { id: 'k3', name: 'Old Dhaka Beef Tehari', nameBn: 'à¦ªà§à¦°à¦¾à¦¨ à¦¢à¦¾à¦•à¦¾à¦° à¦¸à¦°à¦¿à¦·à¦¾à¦° à¦¤à§‡à¦²à§‡ à¦¬à¦¿à¦« à¦¤à§‡à¦¹à¦¾à¦°à¦¿', code: 'KB-03', category: 'biryani_rice', image: 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 180, price: 320, stock: 35, foodCourtId: 'fc_kacchi', foodCourtName: 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' },
                        { id: 'k4', name: 'Zafrani Shahi Firni', nameBn: 'à¦œà¦¾à¦«à¦°à¦¾à¦¨à¦¿ à¦¶à¦¾à¦¹à§€ à¦«à¦¿à¦°à¦¨à¦¿ (à¦®à¦¾à¦Ÿà¦¿à¦° à¦ªà¦¾à¦¤à§à¦°à§‡)', code: 'KB-04', category: 'sweets_falooda', image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 40, price: 95, stock: 40, foodCourtId: 'fc_kacchi', foodCourtName: 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' }
                    ];
                },

                getDefaultBurgerItems() {
                    return [
                        { id: 'b1', name: 'Naga Crispy Chicken Burger', nameBn: 'à¦¨à¦¾à¦—à¦¾ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦šà¦¿à¦•à§‡à¦¨ à¦¬à¦¾à¦°à§à¦—à¦¾à¦° (à¦šà¦¿à¦œà¦¿)', code: 'BX-01', category: 'burgers_fastfood', image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 110, price: 260, stock: 55, foodCourtId: 'fc_burger', foodCourtName: 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦à¦•à§à¦¸à¦ªà§à¦°à§‡à¦¸ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' },
                        { id: 'b2', name: 'Double Patty Smoky Beef Burger', nameBn: 'à¦¡à¦¾à¦¬à¦² à¦ªà§à¦¯à¦¾à¦Ÿà¦¿ à¦¸à§à¦®à§‹à¦•à¦¿ à¦¬à¦¿à¦« à¦¬à¦¾à¦°à§à¦—à¦¾à¦°', code: 'BX-02', category: 'burgers_fastfood', image: 'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 160, price: 350, stock: 42, foodCourtId: 'fc_burger', foodCourtName: 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦à¦•à§à¦¸à¦ªà§à¦°à§‡à¦¸ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' },
                        { id: 'b3', name: 'Peri Peri French Fries', nameBn: 'à¦ªà§‡à¦°à¦¿ à¦ªà§‡à¦°à¦¿ à¦®à¦¸à¦²à¦¾à¦¦à¦¾à¦° à¦«à§à¦°à¦¾à¦‡', code: 'BX-03', category: 'burgers_fastfood', image: 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 45, price: 130, stock: 70, foodCourtId: 'fc_burger', foodCourtName: 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦à¦•à§à¦¸à¦ªà§à¦°à§‡à¦¸ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' },
                        { id: 'b4', name: 'Oreo Chocolate Milkshake', nameBn: 'à¦“à¦°à¦¿à¦“ à¦¡à¦¾à¦°à§à¦• à¦šà¦•à¦²à§‡à¦Ÿ à¦®à¦¿à¦²à§à¦•à¦¶à§‡à¦•', code: 'BX-04', category: 'beverages_cha', image: 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?auto=format&fit=crop&w=300&q=65&auto=format', costPrice: 65, price: 180, stock: 30, foodCourtId: 'fc_burger', foodCourtName: 'à¦¬à¦¾à¦°à§à¦—à¦¾à¦° à¦à¦•à§à¦¸à¦ªà§à¦°à§‡à¦¸ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ' }
                    ];
                },

                saveSettings() {
                    localStorage.setItem('khabarbari_settings_v3', JSON.stringify(this.posSettings));
                },

                get lowStockCount() {
                    return this.menuItems.filter(m => m.stock <= 20).length;
                },

                get totalInventoryValue() {
                    return this.menuItems.reduce((s, m) => s + ((m.costPrice || 0) * (m.stock || 0)), 0);
                },

                updateKitchenStatus(kotId, newStatus) {
                    const found = this.kitchenOrders.find(k => k.id === kotId);
                    if (found) {
                        found.status = newStatus;
                        this.playChime(660);
                        this.showToast(`à¦…à¦°à§à¦¡à¦¾à¦° à¦¸à§à¦Ÿà§à¦¯à¦¾à¦Ÿà¦¾à¦¸: ${newStatus.toUpperCase()}`);
                    }
                },

                simulateNewKitchenOrder() {
                    const randMemo = 'MEMO-' + Math.floor(1000 + Math.random() * 9000);
                    this.kitchenOrders.unshift({
                        id: 'kot_' + Date.now(),
                        orderId: randMemo,
                        time: 'Just now',
                        status: 'pending',
                        type: 'Dine-in',
                        customerRef: 'Table ' + Math.floor(1 + Math.random() * 15),
                        items: [
                            { name: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿', quantity: 1 }
                        ]
                    });
                    this.playChime(440);
                    this.showToast('à¦¨à¦¤à§à¦¨ à¦Ÿà§‡à¦¸à§à¦Ÿ à¦•à¦¿à¦šà§‡à¦¨ à¦Ÿà¦¿à¦•à¦¿à¦Ÿ à¦ªà§à¦°à¦¸à§à¦¤à§à¦¤ ðŸ‘¨â€ðŸ³');
                },

                getCategoryName(key) {
                    const found = this.categories.find(c => c.key === key);
                    if (!found) return key;
                    return this.lang === 'bn' ? found.nameBn : found.nameEn;
                },

                formatCurrency(amount) {
                    return (this.posSettings.currency || 'à§³') + Number(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
                },

                get filteredMenuItems() {
                    return this.menuItems.filter(item => {
                        const matchesCategory = this.selectedCategory === 'all' || item.category === this.selectedCategory;
                        const query = this.searchQuery.toLowerCase();
                        const matchesSearch = !this.searchQuery || 
                                              (item.name && item.name.toLowerCase().includes(query)) ||
                                              (item.nameBn && item.nameBn.includes(query)) ||
                                              (item.code && item.code.toLowerCase().includes(query));
                        return matchesCategory && matchesSearch;
                    });
                },

                addToCart(item) {
                    const existing = this.cart.find(i => i.id === item.id);
                    if (existing) {
                        existing.quantity++;
                    } else {
                        this.cart.push({
                            id: item.id,
                            name: item.name,
                            nameBn: item.nameBn || item.name,
                            price: item.price,
                            costPrice: item.costPrice,
                            image: item.image,
                            quantity: 1
                        });
                    }
                    this.playChime(700);
                    this.showToast(`${item.nameBn || item.name} (+1)`, 'ðŸ›’');
                },

                decrementCart(itemId) {
                    const idx = this.cart.findIndex(i => i.id === itemId);
                    if (idx > -1) {
                        if (this.cart[idx].quantity > 1) {
                            this.cart[idx].quantity--;
                        } else {
                            this.cart.splice(idx, 1);
                        }
                        this.playChime(350);
                    }
                },

                getCartItemQty(itemId) {
                    const item = this.cart.find(i => i.id === itemId);
                    return item ? item.quantity : 0;
                },

                clearCart() {
                    this.cart = [];
                    this.discountPercent = 0;
                    this.customerRef = '';
                    this.showToast('à¦•à¦¾à¦°à§à¦Ÿ à¦®à§à¦›à§‡ à¦«à§‡à¦²à¦¾ à¦¹à§Ÿà§‡à¦›à§‡');
                },

                get calculatedSubtotal() {
                    return this.cart.reduce((sum, i) => sum + (i.price * i.quantity), 0);
                },

                get calculatedDiscount() {
                    return (this.calculatedSubtotal * (this.discountPercent / 100));
                },

                get calculatedTax() {
                    const vatRate = (this.posSettings.vatPercent || 5) / 100;
                    return (this.calculatedSubtotal - this.calculatedDiscount) * vatRate;
                },

                get calculatedGrandTotal() {
                    return Math.max(0, Math.round(this.calculatedSubtotal - this.calculatedDiscount + this.calculatedTax));
                },

                appendQuickDigit(val) {
                    if (val === 'clear') {
                        this.quickAmount = '';
                    } else if (val === 'backspace') {
                        this.quickAmount = String(this.quickAmount).slice(0, -1);
                    } else if (val === '00') {
                        if (this.quickAmount && this.quickAmount !== '0') {
                            this.quickAmount = String(this.quickAmount) + '00';
                        }
                    } else {
                        if (this.quickAmount === '0') this.quickAmount = '';
                        this.quickAmount = String(this.quickAmount) + val;
                    }
                    this.playChime(600, 0.05);
                },

                setQuickPreset(amount) {
                    const curr = Number(this.quickAmount || 0);
                    this.quickAmount = String(curr + amount);
                    this.playChime(650, 0.06);
                },

                submitQuickAmountSale() {
                    // Enforce Open Court check
                    if (!this.isCourtOpen) {
                        this.showToast((this.lang === 'bn' ? 'à¦•à¦¾à¦°à§à¦Ÿ à¦¬à¦°à§à¦¤à¦®à¦¾à¦¨à§‡ à¦¬à¦¨à§à¦§ à¦°à§Ÿà§‡à¦›à§‡! à¦¬à¦¿à¦•à§à¦°à¦¿ à¦•à¦°à¦¤à§‡ à¦ªà§à¦°à¦¥à¦®à§‡ "à¦“à¦ªà§‡à¦¨ à¦•à¦¾à¦°à§à¦Ÿ" à¦•à¦°à§à¦¨' : 'Cart is closed! Please open cart first'), 'ðŸ”’', 'error');
                        this.openCourtModal();
                        return;
                    }

                    const amount = Number(this.quickAmount);
                    if (!amount || amount <= 0) {
                        this.showToast('à¦¬à¦¿à¦•à§à¦°à§Ÿ à¦ªà¦°à¦¿à¦®à¦¾à¦£ à¦¦à¦¿à¦¨ (Amount required)', 'âš ï¸', 'error');
                        return;
                    }
                    const qty = Math.max(1, Number(this.quickAmountQty) || 1);
                    const now = new Date();
                    const memoNumber = 'MEMO-' + this.currentOrderNumber;
                    const note = (this.quickAmountNote || '').trim() || (this.lang === 'bn' ? 'à¦•à§à¦‡à¦• à¦«à§à¦¡ à¦¸à§‡à¦²' : 'Quick Food Sale');
                    const todayDateKey = now.toLocaleDateString('en-CA');
                    const newOrder = {
                        id: 'ord_' + Date.now(),
                        orderId: memoNumber,
                        orderDate: todayDateKey,
                        fullDate: todayDateKey,
                        timestamp: now.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ' ' + now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        type: 'Takeaway',
                        customerRef: this.lang === 'bn' ? 'à¦•à¦¾à¦‰à¦¨à§à¦Ÿà¦¾à¦° à¦•à§à¦¯à¦¾à¦¶' : 'Counter Cash',
                        paymentMethod: this.quickAmountPayment || 'Cash',
                        items: [
                            { name: note, nameBn: note, price: Math.round(amount / qty), quantity: qty, costPrice: Math.round((amount / qty) * 0.55) }
                        ],
                        itemsSummary: `${note} (x${qty}) - à§³${amount}`,
                        totalQty: qty,
                        subtotal: amount,
                        discount: 0,
                        tax: 0,
                        grandTotal: amount,
                        profit: Math.round(amount * 0.45)
                    };

                    this.salesHistory = [newOrder, ...this.salesHistory];
                    this.salesRevision++;
                    this.currentReceiptOrder = newOrder;
                    this.lastCompletedOrder = newOrder;
                    this.showLastOrderBanner = true;
                    if (this.lastOrderTimer) clearTimeout(this.lastOrderTimer);
                    this.lastOrderTimer = setTimeout(() => { this.showLastOrderBanner = false; }, 4000);

                    this.saveToStorage();
                    this.quickAmount = '';
                    this.quickAmountNote = '';
                    this.quickAmountQty = 1;
                    this.currentOrderNumber = Math.floor(1000 + Math.random() * 9000);
                    this.playSuccessChime();
                    
                    const runningTotal = this.todayStats.totalRevenue;
                    this.showToast(this.lang === 'bn' 
                        ? `âœ“ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¯à§‹à¦— à¦¹à§Ÿà§‡à¦›à§‡! +à§³${amount.toLocaleString()} (${qty}à¦Ÿà¦¿ à¦–à¦¾à¦¬à¦¾à¦°) â€¢ à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ: à§³${runningTotal.toLocaleString()}` 
                        : `âœ“ Sale added! +à§³${amount.toLocaleString()} â€¢ Total: à§³${runningTotal.toLocaleString()}`, 'âœ…');

                    if (this.posSettings.autoShowReceipt) {
                        this.previewReceipt(newOrder);
                    }
                },

                instantSaleWithPayment(item, paymentMethod = 'Cash', qty = null) {
                    if (!this.isAdminLoggedIn) {
                        this.activeTab = 'login';
                        this.showToast((this.lang === 'bn' ? 'à¦¬à¦¿à¦•à§à¦°à¦¿ à¦°à§‡à¦•à¦°à§à¦¡ à¦•à¦°à¦¤à§‡ à¦…à¦¨à§à¦—à§à¦°à¦¹ à¦•à¦°à§‡ à¦²à¦—à¦‡à¦¨ à¦•à¦°à§à¦¨' : 'Please log in to record sales'), 'ðŸ”’');
                        return;
                    }

                    // Enforce Open Court check
                    if (!this.isCourtOpen) {
                        this.showToast((this.lang === 'bn' ? 'à¦•à¦¾à¦°à§à¦Ÿ à¦¬à¦°à§à¦¤à¦®à¦¾à¦¨à§‡ à¦¬à¦¨à§à¦§ à¦°à§Ÿà§‡à¦›à§‡! à¦¬à¦¿à¦•à§à¦°à¦¿ à¦•à¦°à¦¤à§‡ à¦ªà§à¦°à¦¥à¦®à§‡ "à¦“à¦ªà§‡à¦¨ à¦•à¦¾à¦°à§à¦Ÿ" à¦•à¦°à§à¦¨' : 'Cart is closed! Please open cart first'), 'ðŸ”’', 'error');
                        this.openCourtModal();
                        return;
                    }

                    const quantity = Math.max(1, Math.min(999, Number(qty || this.getItemSaleQty(item.id) || 1)));
                    const now = new Date();
                    const memoNumber = 'MEMO-' + this.currentOrderNumber;
                    const itemName = item.nameBn || item.name;
                    const todayDateKey = now.toLocaleDateString('en-CA');
                    const paymentEmoji = paymentMethod === 'bKash' ? 'ðŸŒ¸' : (paymentMethod === 'Nagad' ? 'ðŸŠ' : 'ðŸ’µ');
                    const itemTotalPrice = Number(item.price) * quantity;
                    const itemTotalCost = Number(item.costPrice || 0) * quantity;

                    const newOrder = {
                        id: 'ord_' + Date.now(),
                        orderId: memoNumber,
                        orderDate: todayDateKey,
                        fullDate: todayDateKey,
                        timestamp: now.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ' ' + now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        type: this.orderType || 'Takeaway',
                        customerRef: this.customerRef || (this.lang === 'bn' ? 'à¦•à¦¾à¦‰à¦¨à§à¦Ÿà¦¾à¦° à¦¸à§‡à¦²' : 'Counter Sale'),
                        paymentMethod: paymentMethod, // 'Cash', 'bKash', or 'Nagad'
                        foodCourtId: item.foodCourtId || this.getEffectiveOwnerId() || 'fc_kacchi',
                        foodCourtName: item.foodCourtName || (this.getEffectiveOwnerId() ? this.getOwnerById(this.getEffectiveOwnerId())?.shopName : null) || 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ',
                        items: [
                            { id: item.id, name: item.name, nameBn: item.nameBn || item.name, price: item.price, quantity: quantity, costPrice: item.costPrice }
                        ],
                        itemsSummary: `${itemName} (x${quantity}) [${paymentMethod}]`,
                        totalQty: quantity,
                        subtotal: itemTotalPrice,
                        discount: 0,
                        tax: 0,
                        grandTotal: itemTotalPrice,
                        profit: (itemTotalPrice - itemTotalCost)
                    };

                    this.salesHistory = [newOrder, ...this.salesHistory];
                    this.salesRevision++;
                    this.currentReceiptOrder = newOrder;
                    this.lastCompletedOrder = newOrder;
                    this.showLastOrderBanner = true;
                    if (this.lastOrderTimer) clearTimeout(this.lastOrderTimer);
                    this.lastOrderTimer = setTimeout(() => { this.showLastOrderBanner = false; }, 4000);

                    if (item.stock > 0) {
                        item.stock = Math.max(0, item.stock - quantity);
                    }

                    // Reset quantity for this item back to 1 for next sale
                    this.setItemSaleQty(item.id, 1);

                    this.saveToStorage();
                    this.currentOrderNumber = Math.floor(1000 + Math.random() * 9000);
                    this.playSuccessChime();
                    
                    const runningTotal = this.todayStats.totalRevenue;

                    this.showToast(this.lang === 'bn'
                        ? `âœ“ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¸à¦«à¦²! ${paymentEmoji} ${paymentMethod}-à¦ ${itemName} Ã—${quantity} (+à§³${itemTotalPrice.toLocaleString()}) â€¢ à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ: à§³${runningTotal.toLocaleString()}`
                        : `âœ“ Sale recorded! ${paymentMethod}: ${itemName} Ã—${quantity} (+à§³${itemTotalPrice.toLocaleString()}) â€¢ Total: à§³${runningTotal.toLocaleString()}`, 'âœ…');

                    if (this.posSettings.autoShowReceipt) {
                        this.previewReceipt(newOrder);
                    }
                },

                instantSingleItemSale(item) {
                    this.instantSaleWithPayment(item, 'Cash');
                },

                submitOrder() {
                    if (this.cart.length === 0) return;

                    // Enforce Open Court check
                    if (!this.isCourtOpen) {
                        this.showToast((this.lang === 'bn' ? 'à¦•à¦¾à¦°à§à¦Ÿ à¦¬à¦°à§à¦¤à¦®à¦¾à¦¨à§‡ à¦¬à¦¨à§à¦§ à¦°à§Ÿà§‡à¦›à§‡! à¦¬à¦¿à¦•à§à¦°à¦¿ à¦•à¦°à¦¤à§‡ à¦ªà§à¦°à¦¥à¦®à§‡ "à¦“à¦ªà§‡à¦¨ à¦•à¦¾à¦°à§à¦Ÿ" à¦•à¦°à§à¦¨' : 'Court is closed! Please open court first'), 'ðŸ”’', 'error');
                        this.openCourtModal();
                        return;
                    }

                    const now = new Date();
                    const memoNumber = 'MEMO-' + this.currentOrderNumber;
                    const todayDateKey = now.toLocaleDateString('en-CA');
                    const newOrder = {
                        id: 'ord_' + Date.now(),
                        orderId: memoNumber,
                        orderDate: todayDateKey,
                        fullDate: todayDateKey,
                        timestamp: now.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ' ' + now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        type: this.orderType || 'Takeaway',
                        customerRef: this.customerRef || (this.lang === 'bn' ? 'à¦•à¦¾à¦‰à¦¨à§à¦Ÿà¦¾à¦° à¦—à§‡à¦¸à§à¦Ÿ' : 'Counter Guest'),
                        paymentMethod: this.paymentMethod || 'Cash',
                        foodCourtId: this.getEffectiveOwnerId() || (this.cart[0]?.foodCourtId || 'fc_kacchi'),
                        foodCourtName: (this.getEffectiveOwnerId() ? this.getOwnerById(this.getEffectiveOwnerId())?.shopName : null) || (this.cart[0]?.foodCourtName || 'à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ'),
                        items: JSON.parse(JSON.stringify(this.cart)),
                        itemsSummary: this.cart.map(i => `${i.nameBn || i.name} (x${i.quantity})`).join(', '),
                        totalQty: this.cart.reduce((s, i) => s + i.quantity, 0),
                        subtotal: this.calculatedSubtotal,
                        discount: this.calculatedDiscount,
                        tax: this.calculatedTax,
                        grandTotal: this.calculatedGrandTotal,
                        profit: this.cart.reduce((s, i) => s + ((i.price - i.costPrice) * i.quantity), 0) - this.calculatedDiscount
                    };

                    this.salesHistory = [newOrder, ...this.salesHistory];
                    this.salesRevision++;
                    this.currentReceiptOrder = newOrder;
                    this.lastCompletedOrder = newOrder;
                    this.showLastOrderBanner = true;
                    if (this.lastOrderTimer) clearTimeout(this.lastOrderTimer);
                    this.lastOrderTimer = setTimeout(() => { this.showLastOrderBanner = false; }, 4000);

                    this.kitchenOrders.unshift({
                        id: 'kot_' + Date.now(),
                        orderId: memoNumber,
                        time: 'Just now',
                        status: 'pending',
                        type: this.orderType,
                        customerRef: newOrder.customerRef,
                        items: this.cart.map(i => ({ name: i.nameBn || i.name, quantity: i.quantity }))
                    });

                    this.cart.forEach(cartItem => {
                        const menuItem = this.menuItems.find(m => m.id === cartItem.id);
                        if (menuItem && menuItem.stock > 0) {
                            menuItem.stock = Math.max(0, menuItem.stock - cartItem.quantity);
                        }
                    });

                    this.saveToStorage();
                    this.clearCart();
                    this.showMobileCartSheet = false;
                    this.currentOrderNumber = Math.floor(1000 + Math.random() * 9000);
                    this.playSuccessChime();
                    
                    const runningTotal = this.todayStats.totalRevenue;
                    this.showToast(this.lang === 'bn' 
                        ? `âœ“ à¦¬à¦¿à¦•à§à¦°à¦¿ à¦¯à§‹à¦— à¦¹à§Ÿà§‡à¦›à§‡! ${memoNumber} (+à§³${newOrder.grandTotal.toLocaleString()}) â€¢ à¦†à¦œà¦•à§‡à¦° à¦®à§‹à¦Ÿ: à§³${runningTotal.toLocaleString()}` 
                        : `âœ“ Sale added! ${memoNumber} â€¢ Total: à§³${runningTotal.toLocaleString()}`, 'ðŸŽ‰');

                    if (this.posSettings.autoShowReceipt) {
                        this.previewReceipt(newOrder);
                    }
                },

                previewReceipt(order) {
                    if (!order) return;
                    this.currentReceiptOrder = order;
                    this.showReceiptModal = true;
                    this.playChime(600);
                },

                printReceiptDirect() {
                    window.print();
                },

                copyDigitalReceipt(order) {
                    if (!order) return;
                    const storeName = (this.posSettings && this.posSettings.storeName) ? this.posSettings.storeName : 'à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿ à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ';
                    const hotline = (this.posSettings && this.posSettings.hotline) ? this.posSettings.hotline : '+880 1711-234567';
                    const memoId = order.orderId || 'MEMO';
                    const oTime = order.timestamp || '';
                    const oType = order.type || 'Dine-in';
                    const oCust = order.customerRef || 'Guest';
                    const oPay = order.paymentMethod || 'Cash';
                    const subtotal = Number(order.subtotal || 0).toFixed(0);
                    const discount = Number(order.discount || 0).toFixed(0);
                    const tax = Number(order.tax || 0).toFixed(0);
                    const grandTotal = Number(order.grandTotal || 0).toFixed(0);

                    let text = 'ðŸ§¾ *' + storeName + '*\n';
                    text += 'ðŸ“Œ à¦®à§‡à¦®à§‹: *#' + memoId + '* | ' + oTime + '\n';
                    text += 'ðŸ½ï¸ à¦§à¦°à¦¨: ' + oType + ' | à¦—à§à¦°à¦¾à¦¹à¦•: ' + oCust + '\n';
                    text += '---------------------------------\n';
                    const items = Array.isArray(order.items) ? order.items : [];
                    items.forEach(function(it, idx) {
                        const name = it.nameBn || it.name || 'Item';
                        const price = Number(it.price || 0);
                        const qty = Number(it.quantity || 1);
                        text += (idx + 1) + '. ' + name + ' (x' + qty + ') - à§³' + (price * qty).toFixed(0) + '\n';
                    });
                    text += '---------------------------------\n';
                    text += 'à¦¸à¦¾à¦¬à¦Ÿà§‹à¦Ÿà¦¾à¦²: à§³' + subtotal + '\n';
                    if (Number(discount) > 0) {
                        text += 'à¦¡à¦¿à¦¸à¦•à¦¾à¦‰à¦¨à§à¦Ÿ: -à§³' + discount + '\n';
                    }
                    text += 'à¦­à§à¦¯à¦¾à¦Ÿ: à§³' + tax + '\n';
                    text += '*à¦¸à¦°à§à¦¬à¦®à§‹à¦Ÿ à¦¬à¦¿à¦²: à§³' + grandTotal + '* (' + oPay + ')\n';
                    text += '---------------------------------\n';
                    text += 'à¦–à¦¾à¦¬à¦¾à¦°à¦¬à¦¾à§œà¦¿à¦¤à§‡ à¦†à¦¸à¦¾à¦° à¦œà¦¨à§à¦¯ à¦§à¦¨à§à¦¯à¦¬à¦¾à¦¦! ðŸŒŸ\n';
                    text += 'Hotline: ' + hotline;

                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(text).then(() => {
                            this.playChime(800);
                            this.showToast('à¦¡à¦¿à¦œà¦¿à¦Ÿà¦¾à¦² à¦®à§‡à¦®à§‹ à¦•à¦ªà¦¿ à¦¹à§Ÿà§‡à¦›à§‡ (WhatsApp à¦ à¦ªà§‡à¦¸à§à¦Ÿ à¦•à¦°à§à¦¨)', 'ðŸ“‹');
                        }).catch(() => {
                            this.showToast('à¦•à§à¦²à¦¿à¦ªà¦¬à§‹à¦°à§à¦¡à§‡ à¦•à¦ªà¦¿ à¦•à¦°à¦¾ à¦¯à¦¾à§Ÿà¦¨à¦¿', 'âš ï¸');
                        });
                    } else {
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                        this.playChime(800);
                        this.showToast('à¦¡à¦¿à¦œà¦¿à¦Ÿà¦¾à¦² à¦®à§‡à¦®à§‹ à¦•à¦ªà¦¿ à¦¹à§Ÿà§‡à¦›à§‡', 'ðŸ“‹');
                    }
                },

                copyToClipboard(text, label = 'à¦•à¦ªà¦¿ à¦¹à§Ÿà§‡à¦›à§‡') {
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(text).then(() => {
                            this.playChime(750);
                            this.showToast(label + ' âœ“', 'ðŸ“‹');
                        }).catch(() => {
                            this.showToast('à¦•à¦ªà¦¿ à¦•à¦°à¦¾ à¦¯à¦¾à§Ÿà¦¨à¦¿', 'âš ï¸');
                        });
                    } else {
                        const ta = document.createElement('textarea');
                        ta.value = text;
                        document.body.appendChild(ta);
                        ta.select();
                        document.execCommand('copy');
                        document.body.removeChild(ta);
                        this.playChime(750);
                        this.showToast(label + ' âœ“', 'ðŸ“‹');
                    }
                },

                sendContactMessage() {
                    if (!this.contactForm.name || !this.contactForm.message) {
                        this.showToast('à¦¦à§Ÿà¦¾ à¦•à¦°à§‡ à¦†à¦ªà¦¨à¦¾à¦° à¦¨à¦¾à¦® à¦“ à¦¬à¦¾à¦°à§à¦¤à¦¾ à¦²à¦¿à¦–à§à¦¨', 'âš ï¸', 'error');
                        return;
                    }
                    this.contactForm.sending = true;
                    setTimeout(() => {
                        this.contactForm.sending = false;
                        this.contactForm.name = '';
                        this.contactForm.emailPhone = '';
                        this.contactForm.message = '';
                        this.playSuccessChime();
                        this.showToast(this.lang === 'bn' ? 'à¦¬à¦¾à¦°à§à¦¤à¦¾ à¦¸à¦«à¦²à¦­à¦¾à¦¬à§‡ à¦ªà¦¾à¦ à¦¾à¦¨à§‹ à¦¹à§Ÿà§‡à¦›à§‡! à¦§à¦¨à§à¦¯à¦¬à¦¾à¦¦à¥¤' : 'Message sent successfully! Thank you.', 'âœ‰ï¸');
                    }, 500);
                },

                get todaySalesList() {
                    const _rev = this.salesRevision; // Forces instant Alpine reactive update
                    const list = Array.isArray(this.salesHistory) ? this.salesHistory : [];
                    const todayDateKey = new Date().toLocaleDateString('en-CA'); // 'YYYY-MM-DD'
                    const todayStr = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    const matches = list.filter(o => {
                        if (!o) return false;
                        if (o.orderDate === todayDateKey || o.fullDate === todayDateKey) return true;
                        if (o.timestamp && (o.timestamp.includes('Today') || o.timestamp.includes(todayStr))) return true;
                        if (o.id && o.id.startsWith('ord_')) {
                            const time = Number(o.id.replace('ord_', ''));
                            if (!isNaN(time) && (Date.now() - time) < 24 * 3600 * 1000) return true;
                        }
                        return false;
                    });
                    return matches.length > 0 ? matches : list;
                },

                _cachedTodayStats: null,
                _cachedTodayStatsRev: -1,

                get todayStats() {
                    const rev = this.salesRevision + '_' + (this.salesHistory ? this.salesHistory.length : 0) + '_' + (this.rawItemsCosts ? this.rawItemsCosts.length : 0) + '_' + (this.getEffectiveOwnerId() || 'all');
                    if (this._cachedTodayStats && this._cachedTodayStatsRev === rev) {
                        return this._cachedTodayStats;
                    }
                    const todayList = this.todaySalesList;
                    const totalRevenue = todayList.reduce((s, o) => s + (Number(o.grandTotal) || 0), 0);
                    const totalOrders = todayList.length;
                    const totalItemsSold = todayList.reduce((s, o) => {
                        if (o.totalQty) return s + Number(o.totalQty);
                        if (Array.isArray(o.items)) {
                            return s + o.items.reduce((sum, it) => sum + (Number(it.quantity) || 1), 0);
                        }
                        return s + 1;
                    }, 0);
                    const cashTotal = todayList.filter(o => (o.paymentMethod || '').toLowerCase() === 'cash').reduce((s, o) => s + (Number(o.grandTotal) || 0), 0);
                    const bkashTotal = todayList.filter(o => (o.paymentMethod || '').toLowerCase() === 'bkash').reduce((s, o) => s + (Number(o.grandTotal) || 0), 0);
                    const nagadTotal = todayList.filter(o => (o.paymentMethod || '').toLowerCase() === 'nagad').reduce((s, o) => s + (Number(o.grandTotal) || 0), 0);
                    const mfsTotal = bkashTotal + nagadTotal;

                    // Today's Raw Items Cost
                    const todayStr = new Date().toISOString().split('T')[0];
                    const todayCosts = (this.rawItemsCosts || []).filter(c => {
                        if (!c) return false;
                        return c.date === todayStr || (c.timestamp && c.timestamp.includes('Today'));
                    });
                    const todayRawCost = todayCosts.reduce((s, c) => s + (Number(c.totalCost) || 0), 0);
                    const todayRawCashCost = todayCosts.filter(c => (c.paidVia || '').toLowerCase() === 'cash').reduce((s, c) => s + (Number(c.totalCost) || 0), 0);
                    const todayRawMfsCost = todayCosts.filter(c => ['bkash', 'nagad'].includes((c.paidVia || '').toLowerCase())).reduce((s, c) => s + (Number(c.totalCost) || 0), 0);
                    const todayRawDueCost = todayCosts.filter(c => (c.paidVia || '').toLowerCase() === 'due').reduce((s, c) => s + (Number(c.totalCost) || 0), 0);
                    const todayRawCount = todayCosts.length;

                    // Profitability & Net Cash in Drawer
                    const todayNetProfit = Math.max(0, totalRevenue - todayRawCost);
                    const todayProfitPercent = totalRevenue > 0 ? Math.round((todayNetProfit / totalRevenue) * 100) : 0;
                    const todayCashInHand = cashTotal - todayRawCashCost;

                    const res = {
                        totalRevenue,
                        totalOrders,
                        totalItemsSold,
                        cashTotal,
                        bkashTotal,
                        nagadTotal,
                        mfsTotal,
                        todayRawCost,
                        todayRawCashCost,
                        todayRawMfsCost,
                        todayRawDueCost,
                        todayRawCount,
                        todayNetProfit,
                        todayProfitPercent,
                        todayCashInHand
                    };
                    this._cachedTodayStats = res;
                    this._cachedTodayStatsRev = rev;
                    return res;
                },

                get filteredRawCosts() {
                    const list = this.rawItemsCosts || [];
                    const search = (this.rawCostSearch || '').toLowerCase().trim();
                    const cat = this.rawCostCategoryFilter || 'all';
                    const dFilter = this.rawCostDateFilter || 'today';
                    const todayStr = new Date().toISOString().split('T')[0];

                    return list.filter(item => {
                        if (!item) return false;

                        // Date / Status filter
                        if (dFilter === 'today') {
                            const isToday = item.date === todayStr || (item.timestamp && item.timestamp.includes('Today'));
                            if (!isToday) return false;
                        } else if (dFilter === 'cash') {
                            if ((item.paidVia || '').toLowerCase() !== 'cash') return false;
                        } else if (dFilter === 'due') {
                            if ((item.paidVia || '').toLowerCase() !== 'due') return false;
                        }

                        // Category filter
                        if (cat !== 'all' && item.category !== cat) {
                            return false;
                        }

                        // Search query
                        if (search) {
                            const name = (item.name || '').toLowerCase();
                            const vendor = (item.vendor || '').toLowerCase();
                            const note = (item.note || '').toLowerCase();
                            if (!name.includes(search) && !vendor.includes(search) && !note.includes(search)) {
                                return false;
                            }
                        }

                        return true;
                    });
                },

                getCategoryLabel(key) {
                    const cat = (this.rawCostCategories || []).find(c => c.key === key);
                    if (!cat) return key;
                    return (cat.icon ? cat.icon + ' ' : '') + (this.lang === 'bn' ? cat.nameBn : cat.nameEn);
                },

                openAddRawCostModal(preset = null) {
                    this.editingRawCostId = null;
                    const todayStr = new Date().toISOString().split('T')[0];
                    if (preset) {
                        this.rawCostForm = {
                            id: null,
                            name: preset.name,
                            category: preset.category || 'meat',
                            quantity: 1,
                            unit: preset.unit || 'à¦•à§‡à¦œà¦¿',
                            unitPrice: preset.defaultPrice || 100,
                            totalCost: preset.defaultPrice || 100,
                            date: todayStr,
                            paidVia: 'Cash',
                            vendor: '',
                            note: ''
                        };
                    } else {
                        this.rawCostForm = {
                            id: null,
                            name: '',
                            category: 'meat',
                            quantity: 1,
                            unit: 'à¦•à§‡à¦œà¦¿',
                            unitPrice: 0,
                            totalCost: 0,
                            date: todayStr,
                            paidVia: 'Cash',
                            vendor: '',
                            note: ''
                        };
                    }
                    this.showRawCostModal = true;
                    this.playChime(600);
                },

                calculateRawTotal() {
                    const q = Math.max(0, Number(this.rawCostForm.quantity) || 0);
                    const p = Math.max(0, Number(this.rawCostForm.unitPrice) || 0);
                    this.rawCostForm.totalCost = Math.round(q * p);
                },

                editRawCost(item) {
                    if (!item) return;
                    this.editingRawCostId = item.id;
                    this.rawCostForm = {
                        id: item.id,
                        name: item.name || '',
                        category: item.category || 'meat',
                        quantity: item.quantity || 1,
                        unit: item.unit || 'à¦•à§‡à¦œà¦¿',
                        unitPrice: item.unitPrice || 0,
                        totalCost: item.totalCost || 0,
                        date: item.date || new Date().toISOString().split('T')[0],
                        paidVia: item.paidVia || 'Cash',
                        vendor: item.vendor || '',
                        note: item.note || ''
                    };
                    this.showRawCostModal = true;
                    this.playChime(550);
                },

                saveRawCost() {
                    if (!this.rawCostForm.name || !this.rawCostForm.name.trim()) {
                        this.showToast(this.lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦²à§‡à¦° à¦¨à¦¾à¦® à¦²à¦¿à¦–à§à¦¨' : 'Please enter item name', 'âš ï¸', 'error');
                        return;
                    }
                    if (Number(this.rawCostForm.totalCost) <= 0) {
                        this.showToast(this.lang === 'bn' ? 'à¦¸à¦ à¦¿à¦• à¦®à§‹à¦Ÿ à¦–à¦°à¦š à¦¦à¦¿à¦¨' : 'Please enter valid total cost', 'âš ï¸', 'error');
                        return;
                    }

                    const timeStr = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    const todayStr = new Date().toISOString().split('T')[0];

                    if (this.editingRawCostId) {
                        const idx = this.rawItemsCosts.findIndex(c => c.id === this.editingRawCostId);
                        if (idx !== -1) {
                            this.rawItemsCosts[idx] = {
                                ...this.rawItemsCosts[idx],
                                name: this.rawCostForm.name.trim(),
                                category: this.rawCostForm.category,
                                quantity: Number(this.rawCostForm.quantity) || 1,
                                unit: this.rawCostForm.unit,
                                unitPrice: Number(this.rawCostForm.unitPrice) || 0,
                                totalCost: Number(this.rawCostForm.totalCost) || 0,
                                date: this.rawCostForm.date || todayStr,
                                paidVia: this.rawCostForm.paidVia,
                                vendor: (this.rawCostForm.vendor || '').trim(),
                                note: (this.rawCostForm.note || '').trim()
                            };
                        }
                        this.showToast(this.lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦†à¦ªà¦¡à§‡à¦Ÿ à¦¹à§Ÿà§‡à¦›à§‡ âœ“' : 'Raw cost updated âœ“', 'ðŸ¥©');
                    } else {
                        const newItem = {
                            id: 'raw_' + Date.now(),
                            name: this.rawCostForm.name.trim(),
                            category: this.rawCostForm.category,
                            quantity: Number(this.rawCostForm.quantity) || 1,
                            unit: this.rawCostForm.unit,
                            unitPrice: Number(this.rawCostForm.unitPrice) || 0,
                            totalCost: Number(this.rawCostForm.totalCost) || 0,
                            date: this.rawCostForm.date || todayStr,
                            timestamp: (this.rawCostForm.date === todayStr ? 'Today, ' : '') + timeStr,
                            paidVia: this.rawCostForm.paidVia,
                            vendor: (this.rawCostForm.vendor || '').trim() || (this.lang === 'bn' ? 'à¦²à§‹à¦•à¦¾à¦² à¦¬à¦¾à¦œà¦¾à¦°' : 'Local Market'),
                            note: (this.rawCostForm.note || '').trim()
                        };
                        this.rawItemsCosts.unshift(newItem);
                        this.showToast(this.lang === 'bn' ? 'à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦š à¦¸à¦‚à¦°à¦•à§à¦·à¦¿à¦¤ à¦¹à§Ÿà§‡à¦›à§‡ âœ“' : 'Raw cost saved âœ“', 'ðŸ¥©');
                    }

                    this.saveToStorage();
                    this.showRawCostModal = false;
                    this.editingRawCostId = null;
                    this.playChime(680);
                },

                deleteRawCost(id) {
                    if (!confirm(this.lang === 'bn' ? 'à¦†à¦ªà¦¨à¦¿ à¦•à¦¿ à¦à¦‡ à¦•à¦¾à¦à¦šà¦¾à¦®à¦¾à¦² à¦–à¦°à¦šà§‡à¦° à¦°à§‡à¦•à¦°à§à¦¡à¦Ÿà¦¿ à¦®à§à¦›à§‡ à¦«à§‡à¦²à¦¤à§‡ à¦šà¦¾à¦¨?' : 'Are you sure you want to delete this raw cost entry?')) {
                        return;
                    }
                    this.rawItemsCosts = this.rawItemsCosts.filter(c => c.id !== id);
                    this.saveToStorage();
                    this.showToast(this.lang === 'bn' ? 'à¦–à¦°à¦šà§‡à¦° à¦à¦¨à§à¦Ÿà§à¦°à¦¿ à¦®à§à¦›à§‡ à¦«à§‡à¦²à¦¾ à¦¹à§Ÿà§‡à¦›à§‡' : 'Raw cost deleted', 'ðŸ—‘ï¸');
                    this.playChime(420);
                },

                _cachedBreakdown: null,
                _cachedBreakdownRev: -1,

                get todayItemSalesBreakdown() {
                    const rev = this.salesRevision + '_' + (this.salesHistory ? this.salesHistory.length : 0);
                    if (this._cachedBreakdown && this._cachedBreakdownRev === rev) {
                        return this._cachedBreakdown;
                    }
                    const itemMap = {};
                    let totalQty = 0;
                    let totalRevenue = 0;

                    const list = this.todaySalesList;
                    list.forEach(order => {
                        if (!order || !Array.isArray(order.items)) return;
                        order.items.forEach(it => {
                            const name = (it.nameBn || it.name || (this.lang === 'bn' ? 'à¦•à§à¦‡à¦• à¦«à§à¦¡ à¦¸à§‡à¦²' : 'Quick Food Sale')).trim();
                            const qty = Math.max(1, Number(it.quantity || 1));
                            const price = Number(it.price || 0);
                            const itemTotal = (price * qty) || Number(order.grandTotal) || 0;

                            if (!itemMap[name]) {
                                itemMap[name] = {
                                    id: it.id || null,
                                    name: name,
                                    price: price,
                                    quantity: 0,
                                    revenue: 0,
                                    isQuickSale: !it.id
                                };
                            }
                            itemMap[name].quantity += qty;
                            itemMap[name].revenue += itemTotal;
                            totalQty += qty;
                            totalRevenue += itemTotal;
                        });
                    });

                    const items = Object.values(itemMap).sort((a, b) => b.quantity - a.quantity);
                    const res = {
                        totalQty,
                        totalRevenue,
                        uniqueItemCount: items.length,
                        items
                    };
                    this._cachedBreakdown = res;
                    this._cachedBreakdownRev = rev;
                    return res;
                },

                _cachedSoldMap: null,
                _cachedSoldMapRev: -1,

                get todaySoldMap() {
                    const rev = this.salesRevision + '_' + (this.salesHistory ? this.salesHistory.length : 0);
                    if (this._cachedSoldMap && this._cachedSoldMapRev === rev) {
                        return this._cachedSoldMap;
                    }
                    const map = {};
                    const list = this.todaySalesList;
                    list.forEach(order => {
                        if (!order || !Array.isArray(order.items)) return;
                        order.items.forEach(it => {
                            const qty = Number(it.quantity || 1);
                            if (it.id) {
                                map[it.id] = (map[it.id] || 0) + qty;
                            }
                            const nameBn = (it.nameBn || it.name || '').trim().toLowerCase();
                            if (nameBn) {
                                map[nameBn] = (map[nameBn] || 0) + qty;
                            }
                            const nameEn = (it.name || '').trim().toLowerCase();
                            if (nameEn) {
                                map[nameEn] = (map[nameEn] || 0) + qty;
                            }
                        });
                    });
                    this._cachedSoldMap = map;
                    this._cachedSoldMapRev = rev;
                    return map;
                },

                getItemTodaySoldCount(item) {
                    if (!item) return 0;
                    const map = this.todaySoldMap;
                    if (item.id && map[item.id] !== undefined) return map[item.id];
                    const nameBn = (item.nameBn || item.name || '').trim().toLowerCase();
                    if (nameBn && map[nameBn] !== undefined) return map[nameBn];
                    const nameEn = (item.name || '').trim().toLowerCase();
                    if (nameEn && map[nameEn] !== undefined) return map[nameEn];
                    return 0;
                },

                get metrics() {
                    return { 
                        todayRevenue: this.todayStats.totalRevenue, 
                        todayOrders: this.todayStats.totalOrders 
                    };
                },

                get analyticsData() {
                    const totalRevenue = this.salesHistory.reduce((s, o) => s + (o.grandTotal || 0), 0);
                    const totalOrders = this.salesHistory.length;
                    const averageOrderValue = totalOrders > 0 ? totalRevenue / totalOrders : 0;
                    const totalProfit = this.salesHistory.reduce((s, o) => s + (o.profit || (o.grandTotal * 0.58)), 0);
                    return { totalRevenue, totalOrders, averageOrderValue, totalProfit };
                },

                get monthlySalesData() {
                    return [
                        { monthKey: 'jan', nameBn: 'à¦œà¦¾à¦¨à§', nameEn: 'Jan', sales: 420000 },
                        { monthKey: 'feb', nameBn: 'à¦«à§‡à¦¬à§à¦°à§', nameEn: 'Feb', sales: 485000 },
                        { monthKey: 'mar', nameBn: 'à¦®à¦¾à¦°à§à¦š', nameEn: 'Mar', sales: 540000 },
                        { monthKey: 'apr', nameBn: 'à¦à¦ªà§à¦°à¦¿à¦²', nameEn: 'Apr', sales: 610000 },
                        { monthKey: 'may', nameBn: 'à¦®à§‡', nameEn: 'May', sales: 590000 },
                        { monthKey: 'jun', nameBn: 'à¦œà§à¦¨', nameEn: 'Jun', sales: 680000 },
                        { monthKey: 'jul', nameBn: 'à¦œà§à¦²à¦¾à¦‡', nameEn: 'Jul', sales: 750000 },
                        { monthKey: 'aug', nameBn: 'à¦†à¦—à¦¸à§à¦Ÿ', nameEn: 'Aug', sales: 820000 },
                        { monthKey: 'sep', nameBn: 'à¦¸à§‡à¦ªà§à¦Ÿà§‡', nameEn: 'Sep', sales: 890000 },
                        { monthKey: 'oct', nameBn: 'à¦…à¦•à§à¦Ÿà§‹', nameEn: 'Oct', sales: 780000 },
                        { monthKey: 'nov', nameBn: 'à¦¨à¦­à§‡', nameEn: 'Nov', sales: 840000 },
                        { monthKey: 'dec', nameBn: 'à¦¡à¦¿à¦¸à§‡', nameEn: 'Dec', sales: 960000 }
                    ];
                },

                get chartData() {
                    const days = this.lang === 'bn' ? ['à¦¶à¦¨à¦¿', 'à¦°à¦¬à¦¿', 'à¦¸à§‹à¦®', 'à¦®à¦™à§à¦—à¦²', 'à¦¬à§à¦§', 'à¦¬à§ƒà¦¹à¦ƒ', 'à¦¶à§à¦•à§à¦°'] : ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
                    const values = [18500, 24200, 21800, 29400, 36800, 48500, 62000];
                    const width = 700;
                    const height = 180;
                    const maxVal = 70000;

                    const points = values.map((v, i) => {
                        const x = 30 + (i * ((width - 60) / (values.length - 1)));
                        const y = height - ((v / maxVal) * (height - 40));
                        return { x, y, val: v, label: days[i] };
                    });

                    let linePath = `M ${points[0].x} ${points[0].y}`;
                    for (let i = 1; i < points.length; i++) {
                        const prev = points[i - 1];
                        const curr = points[i];
                        const cpX = (prev.x + curr.x) / 2;
                        linePath += ` C ${cpX} ${prev.y}, ${cpX} ${curr.y}, ${curr.x} ${curr.y}`;
                    }

                    const areaPath = `${linePath} L ${points[points.length - 1].x} 190 L ${points[0].x} 190 Z`;
                    return { points, linePath, areaPath };
                },

                get salesGrowthChartData() {
                    const _rev = this.salesRevision;
                    const list = Array.isArray(this.salesHistory) ? [...this.salesHistory].reverse() : [];
                    const width = 600;
                    const height = 180;

                    let points = [];
                    let cumulative = 0;

                    if (list.length === 0) {
                        const baseValues = [0, 5200, 12400, 21800, 31500, 42000, 56000];
                        const timeLabels = ['à§§à§¦:à§¦à§¦', 'à§§à§¨:à§¦à§¦', 'à§¦à§¨:à§¦à§¦', 'à§¦à§ª:à§¦à§¦', 'à§¦à§¬:à§¦à§¦', 'à§¦à§®:à§¦à§¦', 'à¦à¦–à¦¨'];
                        const maxVal = 65000;
                        points = baseValues.map((v, i) => {
                            const x = 35 + (i * ((width - 70) / (baseValues.length - 1)));
                            const y = height - 25 - ((v / maxVal) * (height - 50));
                            return { x, y, val: v, label: timeLabels[i] };
                        });
                        cumulative = 56000;
                    } else {
                        const sampleOrders = list.slice(-8); // recent up to 8 sales points
                        const totalSampleRevenue = sampleOrders.reduce((sum, o) => sum + Number(o.grandTotal || 0), 0);
                        const maxVal = Math.max(1000, totalSampleRevenue * 1.15);
                        
                        points.push({
                            x: 35,
                            y: height - 25,
                            val: 0,
                            label: 'à¦¶à§à¦°à§'
                        });

                        sampleOrders.forEach((o, idx) => {
                            cumulative += Number(o.grandTotal || 0);
                            const x = 35 + ((idx + 1) * ((width - 70) / sampleOrders.length));
                            const y = height - 25 - ((cumulative / maxVal) * (height - 50));
                            const timeStr = o.timestamp ? o.timestamp.split(' ').slice(-1)[0] : `#${idx+1}`;
                            points.push({ x, y, val: cumulative, label: timeStr });
                        });
                    }

                    let linePath = `M ${points[0].x} ${points[0].y}`;
                    for (let i = 1; i < points.length; i++) {
                        const prev = points[i - 1];
                        const curr = points[i];
                        const cpX = (prev.x + curr.x) / 2;
                        linePath += ` C ${cpX} ${prev.y}, ${cpX} ${curr.y}, ${curr.x} ${curr.y}`;
                    }

                    const areaPath = `${linePath} L ${points[points.length - 1].x} ${height - 5} L ${points[0].x} ${height - 5} Z`;

                    return {
                        points,
                        linePath,
                        areaPath,
                        cumulativeRevenue: cumulative,
                        salesCount: list.length,
                        peakVal: Math.max(...points.map(p => p.val))
                    };
                },

                get dailySoldItemsData() {
                    const _rev = this.salesRevision;
                    const itemMap = {};
                    let totalQuantity = 0;
                    let totalRevenue = 0;

                    const list = Array.isArray(this.salesHistory) ? this.salesHistory : [];
                    list.forEach(order => {
                        if (!order || !Array.isArray(order.items)) return;
                        order.items.forEach(item => {
                            const key = item.nameBn || item.name || 'Item';
                            const qty = Number(item.quantity || 1);
                            const rev = Number(item.price || 0) * qty;
                            if (!itemMap[key]) {
                                itemMap[key] = {
                                    nameBn: item.nameBn || item.name,
                                    nameEn: item.name || item.nameBn,
                                    quantity: 0,
                                    revenue: 0
                                };
                            }
                            itemMap[key].quantity += qty;
                            itemMap[key].revenue += rev;
                            totalQuantity += qty;
                            totalRevenue += rev;
                        });
                    });

                    // If no sales recorded yet in session, provide realistic base breakdown
                    if (totalQuantity === 0) {
                        const defaults = [
                            { nameBn: 'à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿', nameEn: 'Shahi Mutton Kacchi', quantity: 38, revenue: 14440 },
                            { nameBn: 'à¦¨à¦¾à¦—à¦¾ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦šà¦¿à¦•à§‡à¦¨ à¦¬à¦¾à¦°à§à¦—à¦¾à¦°', nameEn: 'Naga Crispy Burger', quantity: 26, revenue: 6760 },
                            { nameBn: 'à¦¸à§à¦ªà¦¾à¦‡à¦¸à¦¿ à¦¦à¦‡ à¦«à§à¦šà¦•à¦¾', nameEn: 'Spicy Dahi Fuchka', quantity: 34, revenue: 5440 },
                            { nameBn: 'à¦à¦¤à¦¿à¦¹à§à¦¯à¦¬à¦¾à¦¹à§€ à¦¶à¦¾à¦¹à§€ à¦¬à§‹à¦°à¦¹à¦¾à¦¨à¦¿', nameEn: 'Traditional Borhani', quantity: 42, revenue: 3780 },
                            { nameBn: 'à¦°à§Ÿà§‡à¦² à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦«à¦¾à¦²à§à¦¦à¦¾', nameEn: 'Royal Special Falooda', quantity: 18, revenue: 3960 }
                        ];
                        defaults.forEach(d => {
                            itemMap[d.nameBn] = d;
                            totalQuantity += d.quantity;
                            totalRevenue += d.revenue;
                        });
                    }

                    const palette = [
                        { color: '#10b981', glow: 'rgba(16, 185, 129, 0.5)' }, // brand / Green
                        { color: '#f59e0b', glow: 'rgba(245, 158, 11, 0.5)' }, // Amber / Gold
                        { color: '#ec4899', glow: 'rgba(236, 72, 153, 0.5)' }, // Pink / bKash
                        { color: '#3b82f6', glow: 'rgba(59, 130, 246, 0.5)' }, // Vivid Blue
                        { color: '#8b5cf6', glow: 'rgba(139, 92, 246, 0.5)' }, // Purple
                        { color: '#f97316', glow: 'rgba(249, 115, 22, 0.5)' }, // Orange / Nagad
                        { color: '#06b6d4', glow: 'rgba(6, 182, 212, 0.5)' }   // Cyan / Teal
                    ];

                    const r = 58;
                    const circumference = 2 * Math.PI * r; // ~364.4247
                    let currentAngle = 0;

                    const items = Object.values(itemMap)
                        .sort((a, b) => b.quantity - a.quantity)
                        .slice(0, 6)
                        .map((item, idx) => {
                            const percent = totalQuantity > 0 ? (item.quantity / totalQuantity) * 100 : 0;
                            const sliceLength = (percent / 100) * circumference;
                            const strokeDasharray = `${sliceLength.toFixed(2)} ${circumference.toFixed(2)}`;
                            const strokeDashoffset = (-((currentAngle / 100) * circumference)).toFixed(2);
                            currentAngle += percent;
                            const styleColor = palette[idx % palette.length];
                            return {
                                ...item,
                                percent: Math.round(percent),
                                color: styleColor.color,
                                glow: styleColor.glow,
                                strokeDasharray,
                                strokeDashoffset
                            };
                        });

                    // Generate CSS conic-gradient string for 100% guaranteed colorful pie chart in every browser
                    let gradientStops = [];
                    let curPercent = 0;

                    if (items.length === 0) {
                        gradientStops.push('#10b981 0% 100%');
                    } else {
                        items.forEach((it, i) => {
                            const s = curPercent;
                            const isLast = (i === items.length - 1);
                            const e = isLast ? 100 : curPercent + it.percent;
                            const gap = (items.length > 1 && !isLast) ? 0.8 : 0;
                            const ce = isLast ? 100 : Math.max(s, e - gap);
                            gradientStops.push(`${it.color} ${s.toFixed(1)}% ${ce.toFixed(1)}%`);
                            if (gap > 0 && !isLast) {
                                gradientStops.push(`rgba(0,0,0,0.3) ${ce.toFixed(1)}% ${e.toFixed(1)}%`);
                            }
                            curPercent = e;
                        });
                    }

                    const conicGradient = `conic-gradient(${gradientStops.join(', ')})`;

                    return {
                        totalQuantity,
                        totalRevenue,
                        circumference,
                        conicGradient,
                        items
                    };
                },

                get filteredSalesHistory() {
                    const s = (this.ledgerSearch || '').toLowerCase().trim();
                    let list = Array.isArray(this.salesHistory) ? this.salesHistory : [];

                    // Filter tabs
                    if (this.ledgerFilter === 'today') {
                        const todayStr = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        list = list.filter(o => o && o.timestamp && (o.timestamp.includes('Today') || o.timestamp.includes(todayStr)));
                    } else if (this.ledgerFilter === 'cash') {
                        list = list.filter(o => o && (o.paymentMethod || '').toLowerCase() === 'cash');
                    } else if (this.ledgerFilter === 'bkash') {
                        list = list.filter(o => o && (o.paymentMethod || '').toLowerCase() === 'bkash');
                    } else if (this.ledgerFilter === 'nagad') {
                        list = list.filter(o => o && (o.paymentMethod || '').toLowerCase() === 'nagad');
                    }

                    if (!s) return list;
                    return list.filter(o => {
                        if (!o) return false;
                        const memo = (o.orderId || '').toLowerCase();
                        const summary = (o.itemsSummary || '').toLowerCase();
                        const customer = (o.customerRef || '').toLowerCase();
                        const payment = (o.paymentMethod || '').toLowerCase();
                        return memo.includes(s) || summary.includes(s) || customer.includes(s) || payment.includes(s);
                    });
                },

                getMarginPercent(item) {
                    if (!item || !item.price) return 0;
                    return (((item.price - (item.costPrice || 0)) / item.price) * 100).toFixed(0);
                },

                openNewItemModal() {
                    this.editingItem = { 
                        id: null, 
                        name: '', 
                        nameBn: '', 
                        code: 'KB-' + Math.floor(10 + Math.random() * 90), 
                        category: 'biryani_rice', 
                        image: 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=300&q=65&auto=format', 
                        costPrice: 120, 
                        price: 250, 
                        stock: 40 
                    };
                    this.showItemModal = true;
                },

                openEditItemModal(item) {
                    this.editingItem = JSON.parse(JSON.stringify(item || {}));
                    this.showItemModal = true;
                },

                saveMenuItem() {
                    if (!this.editingItem.name && !this.editingItem.nameBn) {
                        this.showToast('à¦…à¦¨à§à¦—à§à¦°à¦¹ à¦•à¦°à§‡ à¦–à¦¾à¦¬à¦¾à¦°à§‡à¦° à¦¨à¦¾à¦® à¦²à¦¿à¦–à§à¦¨', 'âš ï¸');
                        return;
                    }
                    if (this.editingItem.id) {
                        const idx = this.menuItems.findIndex(m => m.id === this.editingItem.id);
                        if (idx > -1) this.menuItems[idx] = JSON.parse(JSON.stringify(this.editingItem));
                    } else {
                        const activeOwner = this.getEffectiveOwnerId() ? this.getOwnerById(this.getEffectiveOwnerId()) : null;
                        const newItem = {
                            id: 'item_' + Date.now(),
                            ...this.editingItem,
                            code: this.editingItem.code || ('KB-' + Math.floor(10 + Math.random() * 90)),
                            foodCourtId: activeOwner ? activeOwner.id : 'fc_kacchi',
                            foodCourtName: activeOwner ? activeOwner.shopName : (this.posSettings.storeName || 'à¦«à§à¦¡à¦•à¦¾à¦°à§à¦Ÿ')
                        };
                        this.menuItems.unshift(newItem);
                    }
                    this.showItemModal = false;
                    this.saveToStorage();
                    this.playSuccessChime();
                    this.showToast(this.lang === 'bn' ? 'âœ“ à¦–à¦¾à¦¬à¦¾à¦° à¦†à¦‡à¦Ÿà§‡à¦® à¦¸à¦«à¦²à¦­à¦¾à¦¬à§‡ à¦¸à¦‚à¦°à¦•à§à¦·à¦¿à¦¤ à¦¹à§Ÿà§‡à¦›à§‡' : 'âœ“ Food item saved successfully', 'ðŸ”');
                },

                exportToCSV() {
                    let csvContent = "data:text/csv;charset=utf-8,Memo ID,Timestamp,Type,Customer,Items,Qty,Payment,Total\r\n";
                    const list = Array.isArray(this.salesHistory) ? this.salesHistory : [];
                    list.forEach(o => {
                        if (!o) return;
                        const memo = (o.orderId || '').replace(/"/g, '""');
                        const time = (o.timestamp || '').replace(/"/g, '""');
                        const type = (o.type || '').replace(/"/g, '""');
                        const cust = (o.customerRef || '').replace(/"/g, '""');
                        const summary = (o.itemsSummary || '').replace(/"/g, '""');
                        const qty = o.totalQty || 0;
                        const pay = (o.paymentMethod || '').replace(/"/g, '""');
                        const total = o.grandTotal || 0;
                        csvContent += `"${memo}","${time}","${type}","${cust}","${summary}","${qty}","${pay}","${total}"\r\n`;
                    });
                    const link = document.createElement("a");
                    link.setAttribute("href", encodeURI(csvContent));
                    link.setAttribute("download", `Sales_Report_${new Date().toISOString().slice(0,10)}.csv`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    this.showToast('CSV à¦«à¦¾à¦‡à¦² à¦¡à¦¾à¦‰à¦¨à¦²à§‹à¦¡ à¦¶à§à¦°à§ à¦¹à§Ÿà§‡à¦›à§‡ ðŸ“¥');
                },

                voidOrder(orderId) {
                    if (confirm('à¦®à§‡à¦®à§‹à¦Ÿà¦¿ à¦¬à¦¾à¦¤à¦¿à¦² à¦•à¦°à¦¤à§‡ à¦šà¦¾à¦¨?')) {
                        this.salesHistory = this.salesHistory.filter(o => o.id !== orderId);
                        this.saveToStorage();
                        this.showToast('à¦®à§‡à¦®à§‹à¦Ÿà¦¿ à¦¬à¦¾à¦¤à¦¿à¦² à¦•à¦°à¦¾ à¦¹à§Ÿà§‡à¦›à§‡ ðŸ—‘ï¸', 'ðŸ—‘ï¸', 'info');
                    }
                },



                initDemoRawCosts() {
                    const todayStr = new Date().toISOString().split('T')[0];
                    this.rawItemsCosts = [
                        {
                            id: 'raw_1',
                            name: 'à¦¦à§‡à¦¶à¦¿ à¦–à¦¾à¦¸à¦¿à¦° à¦«à§à¦°à§‡à¦¶ à¦®à¦¾à¦‚à¦¸',
                            category: 'meat',
                            quantity: 15,
                            unit: 'à¦•à§‡à¦œà¦¿',
                            unitPrice: 850,
                            totalCost: 12750,
                            date: todayStr,
                            timestamp: 'Today, 08:30 AM',
                            paidVia: 'Cash',
                            vendor: 'à¦•à¦¾à¦“à¦°à¦¾à¦¨ à¦¬à¦¾à¦œà¦¾à¦° à¦®à¦¾à¦‚à¦¸à§‡à¦° à¦†à§œà§Ž',
                            note: 'à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿à¦° à¦œà¦¨à§à¦¯ à¦–à¦¾à¦¸à¦¿à¦° à¦°à¦¾à¦¨'
                        },
                        {
                            id: 'raw_2',
                            name: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¸à§à¦—à¦¨à§à¦§à¦¿ à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¾à¦¸à¦®à¦¤à§€ à¦šà¦¾à¦²',
                            category: 'rice_flour',
                            quantity: 25,
                            unit: 'à¦•à§‡à¦œà¦¿',
                            unitPrice: 180,
                            totalCost: 4500,
                            date: todayStr,
                            timestamp: 'Today, 09:15 AM',
                            paidVia: 'Cash',
                            vendor: 'à¦¹à¦¾à¦œà§€ à¦°à¦¾à¦‡à¦¸ à¦à¦œà§‡à¦¨à§à¦¸à¦¿',
                            note: 'à¦ªà§à¦°à¦¿à¦®à¦¿à§Ÿà¦¾à¦® à¦²à¦‚ à¦—à§à¦°à§‡à¦‡à¦¨ à¦¬à¦¾à¦¸à¦®à¦¤à§€'
                        },
                        {
                            id: 'raw_3',
                            name: 'à¦¤à§€à¦° à¦–à¦¾à¦à¦Ÿà¦¿ à¦¸à§Ÿà¦¾à¦¬à¦¿à¦¨ à¦¤à§‡à¦² (à§« à¦²à¦¿à¦Ÿà¦¾à¦°)',
                            category: 'oil_spices',
                            quantity: 2,
                            unit: 'à¦¡à§à¦°à¦¾à¦®',
                            unitPrice: 820,
                            totalCost: 1640,
                            date: todayStr,
                            timestamp: 'Today, 09:30 AM',
                            paidVia: 'bKash',
                            vendor: 'à¦¬à¦¾à¦¬à¦° à¦†à¦²à§€ à¦œà§‡à¦¨à¦¾à¦°à§‡à¦² à¦¸à§à¦Ÿà§‹à¦°',
                            note: 'à¦°à¦¾à¦¨à§à¦¨à¦¾ à¦“ à¦«à§à¦°à¦¾à¦‡à¦‚à§Ÿà§‡à¦° à¦œà¦¨à§à¦¯'
                        },
                        {
                            id: 'raw_4',
                            name: 'à¦«à¦¾à¦°à§à¦®à§‡à¦° à¦²à¦¾à¦² à¦¡à¦¿à¦® (à§§ à¦•à§‡à¦¸ / à§§à§¦à§¦ à¦ªà¦¿à¦¸)',
                            category: 'meat',
                            quantity: 1,
                            unit: 'à¦•à§‡à¦¸',
                            unitPrice: 1050,
                            totalCost: 1050,
                            date: todayStr,
                            timestamp: 'Today, 10:00 AM',
                            paidVia: 'Cash',
                            vendor: 'à¦­à¦¾à¦‡ à¦­à¦¾à¦‡ à¦ªà§‹à¦²à§à¦Ÿà§à¦°à¦¿ à¦¹à¦¾à¦¬',
                            note: 'à¦šà¦Ÿà¦ªà¦Ÿà¦¿, à¦«à§à¦šà¦•à¦¾ à¦“ à¦¬à¦¾à¦°à§à¦—à¦¾à¦°à§‡à¦° à¦œà¦¨à§à¦¯'
                        },
                        {
                            id: 'raw_5',
                            name: 'à¦¦à§‡à¦¶à¦¿ à¦ªà§‡à¦à§Ÿà¦¾à¦œ, à¦°à¦¸à§à¦¨ à¦“ à¦†à¦¦à¦¾ à¦•à¦®à§à¦¬à§‹',
                            category: 'vegetables',
                            quantity: 10,
                            unit: 'à¦•à§‡à¦œà¦¿',
                            unitPrice: 120,
                            totalCost: 1200,
                            date: todayStr,
                            timestamp: 'Today, 10:15 AM',
                            paidVia: 'Cash',
                            vendor: 'à¦²à§‹à¦•à¦¾à¦² à¦•à¦¾à¦à¦šà¦¾à¦¬à¦¾à¦œà¦¾à¦°',
                            note: 'à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ à¦“ à¦—à§à¦°à§‡à¦­à¦¿à¦° à¦¬à¦¾à¦Ÿà¦¾ à¦®à¦¸à¦²à¦¾'
                        },
                        {
                            id: 'raw_6',
                            name: 'à¦¬à¦¸à§à¦¨à§à¦§à¦°à¦¾ à§§à§¨ à¦•à§‡à¦œà¦¿ à¦à¦²à¦ªà¦¿à¦œà¦¿ à¦—à§à¦¯à¦¾à¦¸ à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦°',
                            category: 'gas_utility',
                            quantity: 1,
                            unit: 'à¦¸à¦¿à¦²à¦¿à¦¨à§à¦¡à¦¾à¦°',
                            unitPrice: 1450,
                            totalCost: 1450,
                            date: todayStr,
                            timestamp: 'Today, 11:00 AM',
                            paidVia: 'Cash',
                            vendor: 'à¦®à§‡à¦¸à¦¾à¦°à§à¦¸ à¦°à¦¹à¦®à¦¾à¦¨ à¦—à§à¦¯à¦¾à¦¸ à¦•à¦°à§à¦¨à¦¾à¦°',
                            note: 'à¦®à§‡à¦‡à¦¨ à¦•à¦¿à¦šà§‡à¦¨ à¦“à¦­à§‡à¦¨ à¦°à¦¿à¦«à¦¿à¦²'
                        }
                    ];
                },

                resetDemoData() {
                    this.menuItems = [
                        { 
                            id: 'item_1', 
                            name: 'Special Mutton Kacchi Biryani', 
                            nameBn: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿', 
                            code: 'KB-01',
                            category: 'biryani_rice', 
                            image: 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 240, 
                            price: 450, 
                            stock: 48, 
                            description: 'Aromatic basmati rice with tender mutton chunks', 
                            descBn: 'à¦¸à§à¦—à¦¨à§à¦§à¦¿ à¦œà¦¾à¦«à¦°à¦¾à¦¨à¦¿ à¦¬à¦¾à¦¸à¦®à¦¤à§€ à¦šà¦¾à¦² à¦“ à¦–à¦¾à¦¸à¦¿à¦° à¦®à¦¾à¦‚à¦¸' 
                        },
                        { 
                            id: 'item_2', 
                            name: 'Old Dhaka Beef Tehari', 
                            nameBn: 'à¦ªà§à¦°à¦¾à¦¨ à¦¢à¦¾à¦•à¦¾à¦° à¦¸à¦°à¦¿à¦·à¦¾à¦° à¦¬à¦¿à¦« à¦¤à§‡à¦¹à¦¾à¦°à¦¿', 
                            code: 'KB-02',
                            category: 'biryani_rice', 
                            image: 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 150, 
                            price: 280, 
                            stock: 55, 
                            description: 'Chinigura rice with mustard oil and tender beef', 
                            descBn: 'à¦–à¦¾à¦à¦Ÿà¦¿ à¦¸à¦°à¦¿à¦·à¦¾à¦° à¦¤à§‡à¦² à¦“ à¦šà¦¿à¦¨à¦¿à¦—à§à¦à§œà¦¾ à¦šà¦¾à¦²' 
                        },
                        { 
                            id: 'item_3', 
                            name: 'Naga Crispy Chicken Burger', 
                            nameBn: 'à¦¨à¦¾à¦—à¦¾ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦¸à§à¦®à§‹à¦•à¦¿ à¦šà¦¿à¦•à§‡à¦¨ à¦¬à¦¾à¦°à§à¦—à¦¾à¦°', 
                            code: 'KB-03',
                            category: 'burgers_fastfood', 
                            image: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 120, 
                            price: 260, 
                            stock: 36, 
                            description: 'Fiery naga chicken patty with fresh lettuce', 
                            descBn: 'à¦•à§à¦°à¦¾à¦žà§à¦šà¦¿ à¦šà¦¿à¦•à§‡à¦¨ à¦“ à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦à¦¾à¦² à¦¨à¦¾à¦—à¦¾ à¦¸à¦¸' 
                        },
                        { 
                            id: 'item_4', 
                            name: 'Cheesy Oven Baked Pasta', 
                            nameBn: 'à¦šà¦¿à¦œà¦¿ à¦“à¦­à§‡à¦¨ à¦¬à§‡à¦•à¦¡ à¦šà¦¿à¦•à§‡à¦¨ à¦ªà¦¾à¦¸à§à¦¤à¦¾', 
                            code: 'KB-04',
                            category: 'burgers_fastfood', 
                            image: 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 140, 
                            price: 320, 
                            stock: 28, 
                            description: 'Creamy white sauce with roasted chicken & mozzarella', 
                            descBn: 'à¦¸à§à¦®à§‹à¦•à¦¡ à¦šà¦¿à¦•à§‡à¦¨ à¦“ à¦¬à§‡à¦•à¦¡ à¦®à§‹à¦œà¦¾à¦°à§‡à¦²à¦¾ à¦šà¦¿à¦œ' 
                        },
                        { 
                            id: 'item_5', 
                            name: 'Special Spicy Doi Fuchka (10 Pcs)', 
                            nameBn: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¸à§à¦ªà¦¾à¦‡à¦¸à¦¿ à¦¦à¦‡ à¦«à§à¦šà¦•à¦¾ (à§§à§¦ à¦ªà¦¿à¦¸)', 
                            code: 'KB-05',
                            category: 'street_fuchka', 
                            image: 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 50, 
                            price: 160, 
                            stock: 65, 
                            description: 'Crispy puchka shells with sweet curd and tamarind sauce', 
                            descBn: 'à¦®à§à¦šà¦®à§à¦šà§‡ à¦«à§à¦šà¦•à¦¾, à¦®à¦¿à¦·à§à¦Ÿà¦¿ à¦¦à¦‡ à¦“ à¦¤à§‡à¦à¦¤à§à¦² à¦¸à¦¸' 
                        },
                        { 
                            id: 'item_6', 
                            name: 'Naga Crispy Chicken Wings (6 Pcs)', 
                            nameBn: 'à¦¨à¦¾à¦—à¦¾ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦šà¦¿à¦•à§‡à¦¨ à¦‰à¦‡à¦‚à¦¸ (à§¬ à¦ªà¦¿à¦¸)', 
                            code: 'KB-06',
                            category: 'burgers_fastfood', 
                            image: 'https://images.unsplash.com/photo-1527477321055-436158a2573d?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 95, 
                            price: 240, 
                            stock: 42, 
                            description: 'Golden wings glazed in fiery naga garlic sauce', 
                            descBn: 'à¦—à§‹à¦²à§à¦¡à§‡à¦¨ à¦•à§à¦°à¦¿à¦¸à§à¦ªà¦¿ à¦‰à¦‡à¦‚à¦¸ à¦“ à¦¨à¦¾à¦—à¦¾ à¦¡à¦¿à¦ª' 
                        },
                        { 
                            id: 'item_7', 
                            name: 'Dhaka Special Shahi Chotpoti', 
                            nameBn: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦šà¦Ÿà¦ªà¦Ÿà¦¿ à¦¡à¦¿à¦® à¦“ à¦¨à¦¿à¦®à¦•à¦¿à¦¸à¦¹', 
                            code: 'KB-07',
                            category: 'street_fuchka', 
                            image: 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 45, 
                            price: 130, 
                            stock: 58, 
                            description: 'Spiced chickpeas topped with boiled egg', 
                            descBn: 'à¦˜à¦¨ à¦¡à¦¾à¦¬à¦²à¦¿ à¦®à¦Ÿà¦° à¦“ à¦¡à¦¿à¦®à§‡à¦° à¦—à§à¦°à§‡à¦Ÿà¦¿à¦‚' 
                        },
                        { 
                            id: 'item_8', 
                            name: 'Traditional Mint Borhani', 
                            nameBn: 'à¦à¦¤à¦¿à¦¹à§à¦¯à¦¬à¦¾à¦¹à§€ à¦¶à¦¾à¦¹à§€ à¦ªà§à¦¦à¦¿à¦¨à¦¾ à¦¬à§‹à¦°à¦¹à¦¾à¦¨à¦¿', 
                            code: 'KB-08',
                            category: 'beverages_cha', 
                            image: 'https://images.unsplash.com/photo-1556881286-fc6915169721?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 35, 
                            price: 90, 
                            stock: 85, 
                            description: 'Cooling yogurt beverage infused with fresh mint', 
                            descBn: 'à¦–à¦¾à¦à¦Ÿà¦¿ à¦Ÿà¦•à¦¦à¦‡ à¦“ à¦¤à¦¾à¦œà¦¾ à¦ªà§à¦¦à¦¿à¦¨à¦¾à¦° à¦¬à§‹à¦°à¦¹à¦¾à¦¨à¦¿' 
                        },
                        { 
                            id: 'item_9', 
                            name: 'Royal Pesta & Kaju Lacchi', 
                            nameBn: 'à¦°à§Ÿà§‡à¦² à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦ªà§‡à¦¸à§à¦¤à¦¾ à¦®à¦¿à¦·à§à¦Ÿà¦¿ à¦²à¦¾à¦šà§à¦›à¦¿', 
                            code: 'KB-09',
                            category: 'beverages_cha', 
                            image: 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 50, 
                            price: 130, 
                            stock: 70, 
                            description: 'Sweet curd blended with ice & pistachio flakes', 
                            descBn: 'à¦˜à¦¨ à¦®à¦¿à¦·à§à¦Ÿà¦¿ à¦¦à¦‡ à¦“ à¦°à§‹à¦¸à§à¦Ÿà§‡à¦¡ à¦ªà§‡à¦¸à§à¦¤à¦¾ à¦¬à¦¾à¦¦à¦¾à¦®' 
                        },
                        { 
                            id: 'item_10', 
                            name: 'Royal Mixed Fruit Falooda', 
                            nameBn: 'à¦°à§Ÿà§‡à¦² à¦®à¦¿à¦•à§à¦¸à¦¡ à¦«à§à¦°à§à¦Ÿ à¦†à¦‡à¦¸à¦•à§à¦°à¦¿à¦® à¦«à¦¾à¦²à§à¦¦à¦¾', 
                            code: 'KB-10',
                            category: 'sweets_falooda', 
                            image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 85, 
                            price: 220, 
                            stock: 35, 
                            description: 'Layered falooda with ice cream, fruits & jelly', 
                            descBn: 'à¦­à§à¦¯à¦¾à¦¨à¦¿à¦²à¦¾ à¦†à¦‡à¦¸à¦•à§à¦°à¦¿à¦®, à¦¤à¦¾à¦œà¦¾ à¦«à¦² à¦“ à¦œà§‡à¦²à¦¿' 
                        },
                        { 
                            id: 'item_11', 
                            name: 'Special Matka Malai Cha', 
                            nameBn: 'à¦®à¦¾à¦Ÿà¦¿à¦° à¦­à¦¾à¦à§œà§‡à¦° à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦®à¦¾à¦²à¦¾à¦‡ à¦šà¦¾', 
                            code: 'KB-11',
                            category: 'beverages_cha', 
                            image: 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 18, 
                            price: 50, 
                            stock: 130, 
                            description: 'Slow simmered milk tea in clay cup', 
                            descBn: 'à¦˜à¦¨ à¦¦à§à¦§à§‡à¦° à¦•à§œà¦¾ à¦²à¦¿à¦•à¦¾à¦° à¦“ à¦®à¦¾à¦²à¦¾à¦‡' 
                        },
                        { 
                            id: 'item_12', 
                            name: 'Beef Seekh Kebab with Naan', 
                            nameBn: 'à¦¬à¦¿à¦« à¦¶à¦¿à¦• à¦•à¦¾à¦¬à¦¾à¦¬ à¦“ à¦¬à¦¾à¦Ÿà¦¾à¦° à¦¨à¦¾à¦¨', 
                            code: 'KB-12',
                            category: 'biryani_rice', 
                            image: 'https://images.unsplash.com/photo-1599488615731-7e5c2823ff28?auto=format&fit=crop&w=300&q=65&auto=format',
                            costPrice: 130, 
                            price: 270, 
                            stock: 32, 
                            description: 'Smoky grilled seekh kebab with butter naan', 
                            descBn: 'à¦¸à§à¦®à§‹à¦•à¦¿ à¦¶à¦¿à¦• à¦•à¦¾à¦¬à¦¾à¦¬ à¦“ à¦¤à¦¨à§à¦¦à§à¦°à¦¿ à¦¨à¦¾à¦¨' 
                        }
                    ];

                    this.salesHistory = [
                        {
                            id: 'ord_1',
                            orderId: 'MEMO-9842',
                            timestamp: 'Today, 02:45 PM',
                            type: 'Dine-in',
                            customerRef: 'Table 04',
                            paymentMethod: 'bKash',
                            items: [
                                { name: 'Special Mutton Kacchi Biryani', nameBn: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿', price: 450, quantity: 2, costPrice: 240 }
                            ],
                            itemsSummary: 'à¦¸à§à¦ªà§‡à¦¶à¦¾à¦² à¦¶à¦¾à¦¹à§€ à¦–à¦¾à¦¸à¦¿à¦° à¦•à¦¾à¦šà§à¦šà¦¿ à¦¬à¦¿à¦°à¦¿à§Ÿà¦¾à¦¨à¦¿ (x2)',
                            totalQty: 2,
                            subtotal: 900,
                            discount: 0,
                            tax: 45,
                            grandTotal: 945,
                            profit: 420
                        }
                    ];

                    this.saveToStorage();
                }
            }
        }
    </script>



</body>
</html>
