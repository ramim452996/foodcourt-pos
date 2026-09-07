import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    c = f.read()

# 1. Update fonts
c = c.replace('<!-- Fonts: Inter (English) + Noto Sans Bengali (বাংলা) + JetBrains Mono -->', '<!-- Fonts: Times New Roman (English) + Sonar Bangla (Bengali) fallback to Noto Sans Bengali -->')
c = c.replace('<link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Bengali:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap\" rel=\"stylesheet\">', '<link href=\"https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap\" rel=\"stylesheet\">')
c = c.replace('sans: [\'\"Inter\"\', \'\"Noto Sans Bengali\"\', \'system-ui\', \'sans-serif\'],', 'sans: [\'\"Times New Roman\"\', \'\"Sonar Bangla\"\', \'\"Noto Sans Bengali\"\', \'system-ui\', \'serif\'],')

c = c.replace('''/* ── Font: Inter for English, Noto Sans Bengali for বাংলা ── */
        body {
            font-family: 'Inter', 'Noto Sans Bengali', system-ui, sans-serif;''', '''/* ── Font: Times New Roman for English, Sonar Bangla for বাংলা ── */
        @font-face {
            font-family: 'AppFont-Latin';
            src: local('Times New Roman');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'AppFont-Bengali';
            src: local('Sonar Bangla'), local('Noto Sans Bengali');
            unicode-range: U+0980-09FF; /* Bengali block */
        }

        body {
            font-family: 'AppFont-Latin', 'AppFont-Bengali', 'Times New Roman', 'Sonar Bangla', 'Noto Sans Bengali', system-ui, serif;''')

# 2. Add Clear History Button
c = c.replace('''                    <button @click="ledgerFilter = 'nagad'; playChime(500)" 
                            :class="ledgerFilter === 'nagad' ? 'bg-[#F7941D] text-white font-black shadow-xs' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                        <span>⚡</span>
                        <span>Nagad</span>
                    </button>
                </div>''', '''                    <button @click="ledgerFilter = 'nagad'; playChime(500)" 
                            :class="ledgerFilter === 'nagad' ? 'bg-[#F7941D] text-white font-black shadow-xs' : (isDark ? 'bg-zinc-800 text-zinc-300 border-zinc-700' : 'bg-slate-100 text-slate-700 border-slate-200')"
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer">
                        <span>⚡</span>
                        <span>Nagad</span>
                    </button>
                    
                    <!-- Clear History Button -->
                    <button @click="clearTransactionHistory()" 
                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer bg-rose-50 text-rose-600 border-rose-200 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-900/50 hover:shadow-sm">
                        <span>🗑️</span>
                        <span x-text="lang === 'bn' ? 'ইতিহাস মুছুন' : 'Clear History'"></span>
                    </button>
                </div>''')

# 3. Add JS Function
c = c.replace('''                        this.showInstallGuideModal = true;
                    }
                },
                activeTab: 'pos',''', '''                        this.showInstallGuideModal = true;
                    }
                },
                
                clearTransactionHistory() {
                    const confirmMsg = this.lang === 'bn' ? 
                        'আপনি কি নিশ্চিত যে সমস্ত লেনদেনের ইতিহাস মুছে ফেলতে চান? এটি পুনরায় ফিরিয়ে আনা সম্ভব নয়।' : 
                        'Are you sure you want to clear all transaction history? This cannot be undone.';
                    if (confirm(confirmMsg)) {
                        this.salesHistory = [];
                        this.closedSessionsHistory = [];
                        
                        if (this.businessConfig && this.businessConfig.stallOwners) {
                            this.businessConfig.stallOwners.forEach(owner => {
                                localStorage.removeItem('khabarbari_fc_' + owner.id + '_sales');
                            });
                        }
                        localStorage.removeItem('khabarbari_sales_history_v6');
                        localStorage.removeItem('khabarbari_fc_closed_sessions');
                        
                        this.showToast(this.lang === 'bn' ? 'সমস্ত ইতিহাস সফলভাবে মুছে ফেলা হয়েছে' : 'All history cleared successfully', 'success');
                        this.triggerSalesUpdate();
                    }
                },
                activeTab: 'pos', ''')

# 4. Food card styling
c = c.replace('<div class="food-card rounded-xl sm:rounded-2xl overflow-hidden flex flex-col justify-between group border relative"', '<div class="food-card rounded-[24px] sm:rounded-[32px] p-2 overflow-hidden flex flex-col justify-between group border relative"')
c = c.replace(':class="isDark ? \'bg-obsidian-900/90 border-white/[0.08]\' : \'bg-white border-slate-200/80 shadow-sm\'">', ':class="isDark ? \'bg-obsidian-900/90 border-white/[0.08]\' : \'bg-[#faf4f8]/80 backdrop-blur-md border-white shadow-sm hover:shadow-md\'\">')
c = c.replace('<div class="relative h-28 sm:h-36 w-full overflow-hidden bg-zinc-900 flex-shrink-0">', '<div class="relative h-32 sm:h-40 w-full overflow-hidden bg-zinc-100 dark:bg-zinc-900 rounded-[20px] sm:rounded-[24px] flex-shrink-0">')

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(c)
