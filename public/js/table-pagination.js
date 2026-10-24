document.addEventListener('DOMContentLoaded', () => {
    const rowsPerPage = 10;

    document.querySelectorAll('main table').forEach((table) => {
        const rows = Array.from(table.tBodies).flatMap((body) => Array.from(body.rows));

        if (rows.length <= rowsPerPage) {
            return;
        }

        const pagination = document.createElement('nav');
        pagination.className = 'table-pagination';
        pagination.setAttribute('aria-label', 'Table pagination');
        table.insertAdjacentElement('afterend', pagination);

        const pageCount = Math.ceil(rows.length / rowsPerPage);
        let currentPage = 1;

        const render = () => {
            const firstRow = (currentPage - 1) * rowsPerPage;
            const lastRow = firstRow + rowsPerPage;

            rows.forEach((row, index) => {
                row.hidden = index < firstRow || index >= lastRow;
            });

            pagination.replaceChildren();

            const addButton = (label, page, disabled = false, active = false) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = label;
                button.disabled = disabled;
                button.classList.toggle('is-active', active);
                button.setAttribute('aria-label', label);
                button.addEventListener('click', () => {
                    currentPage = page;
                    render();
                });
                pagination.append(button);
            };

            addButton('Previous', currentPage - 1, currentPage === 1);

            for (let page = 1; page <= pageCount; page += 1) {
                addButton(String(page), page, false, page === currentPage);
            }

            addButton('Next', currentPage + 1, currentPage === pageCount);
        };

        render();
    });
});
