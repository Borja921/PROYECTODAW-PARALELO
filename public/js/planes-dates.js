document.addEventListener('DOMContentLoaded', function () {
    const startEl = document.getElementById('start_date');
    const endEl = document.getElementById('end_date');
    const diasSelect = document.getElementById('dias');
    const dateError = document.getElementById('dateError');
    const dateWarning = document.getElementById('dateWarning');

    function clearMessages() {
        if (dateError) { dateError.style.display = 'none'; dateError.textContent = ''; }
        if (dateWarning) { dateWarning.style.display = 'none'; dateWarning.textContent = ''; }
    }

    if (!startEl || !endEl) return;

    const fpEnd = flatpickr(endEl, {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        allowInput: false,
        onChange(selectedDates) {
            clearMessages();
            if (selectedDates && selectedDates[0] && startPicker.selectedDates[0]) {
                updateDays(startPicker.selectedDates[0], selectedDates[0]);
            }
        }
    });

    const startPicker = flatpickr(startEl, {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        allowInput: false,
        onChange(selectedDates) {
            clearMessages();
            if (selectedDates && selectedDates[0]) {
                fpEnd.set('minDate', selectedDates[0]);
                if (fpEnd.selectedDates[0]) {
                    updateDays(selectedDates[0], fpEnd.selectedDates[0]);
                }
            }
        }
    });

    function updateDays(s, e) {
        if (!s || !e) return;
        if (s > e) {
            if (dateError) {
                dateError.textContent = 'La fecha de inicio no puede ser posterior a la fecha de fin.';
                dateError.style.display = 'block';
            }
            return;
        }
        const days = Math.round((e - s) / (24 * 60 * 60 * 1000)) + 1; // inclusive

        // mostrar duración calculada al usuario
        if (dateWarning) {
            dateWarning.textContent = `Duración calculada: ${days} día(s).`;
            dateWarning.style.display = 'block';
        }

        // si existe select de dias (legacy), tratar de autoajustar
        if (diasSelect) {
            const exists = Array.from(diasSelect.options).some(o => o.value === String(days));
            if (exists) {
                diasSelect.value = String(days);
                if (dateWarning) { dateWarning.style.display = 'none'; }
            }
        }

        // si hay una función de filtrado global, actualizar automáticamente
        if (typeof window.filtrarDestinos === 'function') {
            // pequeña demora para permitir que los selects se actualicen visualmente
            setTimeout(() => window.filtrarDestinos(), 100);
        }

        // Actualizar estado de botones del wizard (si existe)
        try { if (typeof updateSaveButtonState === 'function') updateSaveButtonState(); } catch (e) { }
    }

});