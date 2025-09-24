<div x-data="{
    colors: {
        'success': { 
            text: 'text-green-600 dark:text-white', 
            icon: 'circle-check-big', 
            progress: 'bg-green-600 dark:bg-green-600' 
        },
        'info': { 
            text: 'text-blue-600 dark:text-white', 
            icon: 'info', 
            progress: 'bg-blue-600 dark:bg-blue-600' 
        },
        'warning': { 
            text: 'text-yellow-600 dark:text-white', 
            icon: 'alert-triangle', 
            progress: 'bg-yellow-600 dark:bg-yellow-600' 
        },
        'error': { 
            text: 'text-red-600 dark:text-white', 
            icon: 'x-circle', 
            progress: 'bg-red-600 dark:bg-red-600' 
        },
        'neutral': { 
            text: 'text-gray-600 dark:text-white', 
            icon: 'circle-help', 
            progress: 'bg-gray-600 dark:bg-gray-600' 
        }
    },
    alerts: [],
    add(message, type = 'neutral', duration = 5000) { 
        this.alerts.push({
            id: Date.now(),
            message,
            type,
            duration,
            remaining: duration,
            isPaused: false,
            isVisible: false,
        });
        this.updateAlerts();
    },
    updateAlerts() {
        this.alerts.forEach((alert, index) => {
            if (!alert.isVisible) {
                setTimeout(() => {
                    this.alerts[index].isVisible = true;
                    this.startTimer(alert.id);
                }, index * 80); 
            }
        });
    },
    startTimer(id) {
        const alert = this.alerts.find(a => a.id === id);
        if (!alert || alert.isPaused) return;

        let start = null;
        const animate = (timestamp) => {
            if (!start) start = timestamp;
            const elapsed = timestamp - start;

            if (!alert.isPaused) {
                alert.remaining = Math.max(0, alert.remaining - elapsed);
            }

            if (alert.remaining > 0) {
                start = timestamp;
                if (!alert.isPaused) requestAnimationFrame(animate);
            } else {
                this.remove(alert.id);
            }
        };
        requestAnimationFrame(animate);
    },
    togglePause(id) {
        const alert = this.alerts.find(a => a.id === id);
        if (alert) {
            alert.isPaused = !alert.isPaused;
            if (!alert.isPaused) this.startTimer(id);
        }
    },
    remove(id) {
        const alert = this.alerts.find(a => a.id === id);
        if (alert) {
            alert.isVisible = false;
            setTimeout(() => {
                this.alerts = this.alerts.filter(a => a.id !== id);
            }, 500); // faster removal for lighter UX
        }
    }
}" 
x-init="
@if(session()->has('success')) add('{{ session('success') }}','success'); @endif
@if(session()->has('info')) add('{{ session('info') }}','info'); @endif
@if(session()->has('warning')) add('{{ session('warning') }}','warning'); @endif
@if(session()->has('error')) add('{{ session('error') }}','error'); @endif
@if(session()->has('status')) add('{{ session('status') }}','success'); @endif
"
class="fixed inset-x-0 top-4 z-[9999] flex flex-col items-center p-4 space-y-2 pointer-events-none">

    <template x-for="alert in alerts" :key="alert.id">
        <div x-show="alert.isVisible" 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 -translate-y-full sm:translate-x-full"
            x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
            x-transition:leave-end="opacity-0 -translate-y-full sm:translate-x-full"
            @mouseenter="togglePause(alert.id)" 
            @mouseleave="togglePause(alert.id)"
            class="pointer-events-auto max-w-sm w-full bg-white/90 dark:bg-gray-900 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 dark:border-gray-800 overflow-hidden"
            role="alert">
            
            <div class="p-4 flex items-center justify-between space-x-4">
                <!-- Icon -->
                <div class="flex-shrink-0" :class="colors[alert.type].text">
                    <i :data-lucide="colors[alert.type].icon" class="w-6 h-6"></i>
                </div>

                <!-- Message -->
                <div class="flex-1 text-sm font-medium pr-4" 
                    :class="colors[alert.type].text" 
                    x-text="alert.message"></div>

                <!-- Controls -->
                <div class="flex-shrink-0 flex items-center space-x-2">
                    <button @click="togglePause(alert.id)"
                        :class="colors[alert.type].text + ' hover:opacity-70 transition-colors duration-200 focus:outline-none'">
                        <i :data-lucide="alert.isPaused ? 'play' : 'pause'" class="w-5 h-5"></i>
                    </button>
                    <button @click="remove(alert.id)"
                        :class="colors[alert.type].text + ' hover:opacity-70 transition-colors duration-200 focus:outline-none'">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Progress bar -->
            <div class="h-1" :class="colors[alert.type].progress"
                :style="{ width: (alert.remaining / alert.duration) * 100 + '%' }"></div>
        </div>
    </template>
</div>
