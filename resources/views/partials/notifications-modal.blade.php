<div id="notify-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" data-close-notify></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-sm bg-surface-container-lowest shadow-lg overflow-y-auto">
        <div class="sticky top-0 bg-surface-container-lowest p-4 border-b border-outline-variant/10 flex items-center justify-between">
            <h3 class="font-bold">Notifications</h3>
            <div class="flex gap-2">
                <button id="notify-refresh" class="p-1 rounded-full hover:bg-surface-variant/30">
                    <span class="material-symbols-outlined">refresh</span>
                </button>
                <button id="notify-mark-all" class="p-1 rounded-full hover:bg-surface-variant/30">
                    <span class="material-symbols-outlined">done_all</span>
                </button>
                <button id="notify-close" class="p-1 rounded-full hover:bg-surface-variant/30">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>
        <div id="notify-list" class="divide-y divide-outline-variant/10">
            <!-- Notifications will be loaded here -->
            <div class="p-4 text-center text-on-surface-variant">Loading notifications...</div>
        </div>
    </div>
</div>

<script>
(function() {
    const modal = document.getElementById('notify-modal');
    const list = document.getElementById('notify-list');
    const btnOpen = document.querySelector('[data-toggle-notify]');
    const btnClose = document.getElementById('notify-close');
    const btnRefresh = document.getElementById('notify-refresh');
    const btnMarkAll = document.getElementById('notify-mark-all');

    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function render(items) {
        list.innerHTML = items.length ? items.map(i => `
            <div class="p-4 hover:bg-surface-variant/5 flex gap-3 ${i.read ? 'opacity-70' : ''}">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">notifications</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold">${i.title}</p>
                    <p class="text-sm text-on-surface-variant">${i.message}</p>
                    ${i.data?.route ? `<a class="text-xs text-primary font-bold hover:underline" href="${i.data.route}">View</a>` : ''}
                </div>
                <div class="text-[10px] text-on-surface-variant/70">${i.created}</div>
            </div>
        `).join('') : '<div class="p-4 text-center text-on-surface-variant">No notifications</div>';
    }

    async function fetchUnread(showOnNew = false) {
        try {
            const res = await fetch('{{ route("ui.notifications.unread") }}', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            const json = await res.json();
            render(json.items || []);
            
            const lastCount = parseInt(sessionStorage.getItem('notify_count') || '0', 10);
            if (showOnNew && json.count > lastCount) {
                openModal();
            }
            
            sessionStorage.setItem('notify_count', String(json.count));
            const badge = document.getElementById('notify-badge');
            if (badge) {
                badge.textContent = json.count > 9 ? '9+' : (json.count || '');
                badge.classList.toggle('hidden', !(json.count > 0));
            }
        } catch (e) {
            list.innerHTML = '<div class="p-4 text-error text-sm">Failed to load notifications.</div>';
        }
    }

    async function markAllRead() {
        try {
            await fetch('{{ route("ui.notifications.read_all") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });
            await fetchUnread(false);
            closeModal();
        } catch (e) {
            // ignore
        }
    }

    if (btnOpen) btnOpen.addEventListener('click', (e) => {
        e.preventDefault();
        fetchUnread(false).then(openModal);
    });
    
    if (btnClose) btnClose.addEventListener('click', closeModal);
    document.querySelectorAll('[data-close-notify]').forEach(el => {
        el.addEventListener('click', closeModal);
    });
    
    if (btnRefresh) btnRefresh.addEventListener('click', () => fetchUnread(false));
    if (btnMarkAll) btnMarkAll.addEventListener('click', markAllRead);

    // Initial load and periodic polling
    fetchUnread(false);
    setInterval(() => fetchUnread(true), 30000);
})();
</script>
