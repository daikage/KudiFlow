<header class="bg-emerald-50/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-40 flex justify-between items-center w-full px-4 md:px-8 py-3">
  <div class="flex items-center gap-3 md:gap-6">
    {{-- NEW: Mobile menu button --}}
    <button id="open-sidebar" class="md:hidden p-2 rounded-lg hover:bg-surface-variant/30" aria-label="Open menu">
      <span class="material-symbols-outlined">menu</span>
    </button>
    {{-- ... existing left section (search, etc.) ... --}}
  </div>

  {{-- ... existing right section (support, auth buttons, avatar, notifications) ... --}}
</header>

{{-- NEW: JS to toggle mobile sidebar --}}
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('open-sidebar');
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const closeBtn = document.getElementById('close-sidebar');

    function openSidebar() {
      if (!sidebar || !overlay) return;
      sidebar.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
      document.documentElement.classList.add('overflow-hidden', 'md:overflow-auto');
    }
    function closeSidebar() {
      if (!sidebar || !overlay) return;
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
      document.documentElement.classList.remove('overflow-hidden');
    }

    openBtn && openBtn.addEventListener('click', openSidebar);
    overlay && overlay.addEventListener('click', closeSidebar);
    closeBtn && closeBtn.addEventListener('click', closeSidebar);

    // Close on ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeSidebar();
    });
  });
</script>