document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-drawer-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const isCollapsed = document.body.classList.toggle('drawer-collapsed');
            toggle.setAttribute('aria-expanded', String(!isCollapsed));
        });
    });
});
