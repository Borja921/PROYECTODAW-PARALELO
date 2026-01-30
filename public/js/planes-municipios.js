(function () {
    const CSV_URL = 'https://datosabiertos.jcyl.es/web/jcyl/risp/es/sector-publico/municipios/1284278782067.csv';
    const STORAGE_KEY = 'jcyl_municipios_v1';
    const TTL_MS = 24 * 60 * 60 * 1000; // 24h TTL

    // ----------------- Helpers: storage con TTL -----------------
    function getStored() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return null;
            const parsed = JSON.parse(raw);
            if (!parsed || !parsed.data) return null;
            if (parsed.ts && (Date.now() - parsed.ts) > TTL_MS) {
                localStorage.removeItem(STORAGE_KEY);
                return null;
            }
            return parsed.data;
        } catch (e) {
            console.warn('Error leyendo cache local:', e);
            return null;
        }
    }

    function setStored(data) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify({ ts: Date.now(), data }));
        } catch (e) {
            // en entornos donde localStorage falla, ignorar silenciosamente
            console.warn('No se pudo escribir cache local', e);
        }
    }

    function clearStored() {
        try { localStorage.removeItem(STORAGE_KEY); } catch (e) { }
    }

    // ----------------- Fetch con timeout -----------------
    function fetchWithTimeout(url, options = {}, timeout = 7000) {
        const controller = new AbortController();
        const signal = controller.signal;
        const config = Object.assign({}, options, { signal });
        return new Promise((resolve, reject) => {
            const timer = setTimeout(() => {
                controller.abort();
                reject(new Error('timeout'));
            }, timeout);

            fetch(url, config).then(res => {
                clearTimeout(timer);
                resolve(res);
            }).catch(err => {
                clearTimeout(timer);
                reject(err);
            });
        });
    }

    // ----------------- CSV parsing / mapping -----------------
    function parseCSV(text) {
        // eliminar BOM si existe
        text = text.replace(/^\uFEFF/, '');
        const lines = text.split(/\r?\n/).filter(Boolean);
        if (lines.length === 0) return { headers: [], rows: [] };

        const firstLine = lines[0];
        const commaCount = (firstLine.match(/,/g) || []).length;
        const semicolonCount = (firstLine.match(/;/g) || []).length;
        const delimiter = semicolonCount > commaCount ? ';' : ',';

        const escapeRegex = (s) => s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const splitRegex = new RegExp(escapeRegex(delimiter) + '(?=(?:[^\"]*\"[^\"]*\")*[^\"]*$)');

        const splitRow = (row) => row.split(splitRegex).map(cell => cell.replace(/^\"|\"$/g, '').trim());

        const headers = splitRow(lines[0]).map(h => h.trim());
        const rows = lines.slice(1).map(line => splitRow(line));
        return { headers, rows };
    }

    function findIndex(headers, candidates) {
        const low = headers.map(h => (h || '').toLowerCase());
        for (const c of candidates) {
            const idx = low.indexOf(c.toLowerCase());
            if (idx !== -1) return idx;
        }
        return -1;
    }

    function buildMapping(headers, rows) {
        const provinciaCandidates = ['provincia', 'provincia_nombre', 'provincia_nombre_oficial', 'provincia_ine', 'prov'];
        const municipioCandidates = ['municipio', 'nombre', 'nombre_municipio', 'municipio_nombre', 'municipio_ine'];

        const pIdx = findIndex(headers, provinciaCandidates);
        const mIdx = findIndex(headers, municipioCandidates);

        if (pIdx === -1 || mIdx === -1) {
            throw new Error('No se pudieron detectar las columnas de provincia y municipio en el CSV.');
        }

        const map = new Map();
        rows.forEach(cells => {
            const prov = (cells[pIdx] || '').trim();
            const mun = (cells[mIdx] || '').trim();
            if (!prov || !mun) return;
            const key = prov;
            if (!map.has(key)) map.set(key, new Set());
            map.get(key).add(mun);
        });

        const result = {};
        Array.from(map.keys()).sort((a, b) => a.localeCompare(b, 'es')).forEach(k => {
            result[k] = Array.from(map.get(k)).sort((a, b) => a.localeCompare(b, 'es'));
        });
        return result;
    }

    // ----------------- UI helpers -----------------
    function showError(message, targetId) {
        const el = document.getElementById(targetId);
        if (!el) return;
        el.textContent = message;
        el.style.display = 'block';
    }

    function clearError(targetId) {
        const el = document.getElementById(targetId);
        if (!el) return;
        el.textContent = '';
        el.style.display = 'none';
    }

    function showStatus(msg) {
        const el = document.getElementById('municipiosStatus');
        if (!el) return;
        el.textContent = msg;
        el.style.display = msg ? 'block' : 'none';
    }

    // ----------------- Main data loader -----------------
    async function fetchAndBuild() {
        // Prioridad 1: datos inyectados por servidor
        if (window.__MUNICIPIOS__ && Object.keys(window.__MUNICIPIOS__).length > 0) {
            try { setStored(window.__MUNICIPIOS__); } catch (e) {}
            return window.__MUNICIPIOS__;
        }

        // Prioridad 2: cache local con TTL
        const cached = getStored();
        if (cached) return cached;

        // Prioridad 3: endpoint interno
        try {
            const apiResp = await fetchWithTimeout('/api/municipios', {}, 5000);
            if (apiResp.ok) {
                const map = await apiResp.json();
                if (map && typeof map === 'object' && Object.keys(map).length > 0) {
                    setStored(map);
                    return map;
                }
            }
        } catch (e) {
            console.warn('Imposible obtener /api/municipios (timeout o error), intentando CSV remoto', e);
        }

        // Prioridad 4: CSV remoto
        try {
            const resp = await fetchWithTimeout(CSV_URL, {}, 10000);
            if (!resp.ok) throw new Error('Error al descargar CSV: ' + resp.status);
            const text = await resp.text();
            const { headers, rows } = parseCSV(text);
            const mapping = buildMapping(headers, rows);
            setStored(mapping);
            return mapping;
        } catch (e) {
            throw e;
        }
    }

    // ----------------- DOM population -----------------
    function populateProvincias(mapping, preselectProv) {
        const provinciaSelect = document.getElementById('provincia');
        if (!provinciaSelect) return;
        provinciaSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Elige una provincia --';
        provinciaSelect.appendChild(placeholder);

        const provinces = Object.keys(mapping || {});
        if (provinces.length === 0) {
            placeholder.textContent = '-- No se encontraron provincias --';
            provinciaSelect.disabled = true;
            showError('No se encontraron provincias en los datos.', 'provinciaError');
            return;
        }

        provinces.forEach(prov => {
            const opt = document.createElement('option');
            opt.value = prov;
            opt.textContent = prov;
            provinciaSelect.appendChild(opt);
        });

        provinciaSelect.disabled = false;

        // intentar preselección por data-selected, atributo value existente, o parámetro URL
        const dataSelected = provinciaSelect.dataset.selected || provinciaSelect.getAttribute('data-selected') || preselectProv;
        const urlParams = new URLSearchParams(window.location.search);
        const qprov = urlParams.get('provincia') || dataSelected;
        if (qprov && mapping[qprov]) {
            provinciaSelect.value = qprov;
        }
    }

    function populateMunicipios(mapping, provincia, preselectMun) {
        const municipioSelect = document.getElementById('municipio');
        if (!municipioSelect) return;
        municipioSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Elige un municipio --';
        municipioSelect.appendChild(placeholder);

        if (!provincia || !mapping[provincia]) {
            municipioSelect.disabled = true;
            return;
        }

        mapping[provincia].forEach(mun => {
            const opt = document.createElement('option');
            opt.value = mun;
            opt.textContent = mun;
            municipioSelect.appendChild(opt);
        });

        municipioSelect.disabled = false;

        // intentar preselección por data-selected o atributo value
        const dataSelected = municipioSelect.dataset.selected || municipioSelect.getAttribute('data-selected') || preselectMun;
        if (dataSelected) {
            if (Array.from(municipioSelect.options).some(o => o.value === dataSelected)) {
                municipioSelect.value = dataSelected;
            }
        }
    }

    // ----------------- Public API -----------------
    async function init() {
        const provinciaSelect = document.getElementById('provincia');
        const municipioSelect = document.getElementById('municipio');
        if (!provinciaSelect || !municipioSelect) return;

        provinciaSelect.disabled = true;
        municipioSelect.disabled = true;
        clearError('provinciaError');
        clearError('municipioError');
        showStatus('Cargando municipios...');

        try {
            const mapping = await fetchAndBuild();
            populateProvincias(mapping);

            // Si había un valor seleccionado en la UI (p.e. after form submit), úsalo
            const preProv = provinciaSelect.value || provinciaSelect.dataset.selected || null;
            if (preProv && mapping[preProv]) {
                populateMunicipios(mapping, preProv, municipioSelect.dataset.selected || municipioSelect.getAttribute('data-selected'));
            }

            provinciaSelect.addEventListener('change', function () {
                clearError('provinciaError');
                clearError('municipioError');
                populateMunicipios(mapping, provinciaSelect.value);
            });

            showStatus('Municipios cargados.');
            setTimeout(() => showStatus(''), 2000);
        } catch (err) {
            console.error('Error cargando municipios:', err);
            showError('No se pudieron cargar municipios. ' + (err && err.message ? err.message : ''), 'provinciaError');
            const provinciaSelect = document.getElementById('provincia');
            if (provinciaSelect) {
                provinciaSelect.innerHTML = '<option value="">-- Error al cargar provincias --</option>';
                provinciaSelect.disabled = true;
            }
            showStatus('');
        }
    }

    async function refresh() {
        clearStored();
        showStatus('Refrescando datos...');
        try {
            await init();
            showStatus('Datos actualizados.');
            setTimeout(() => showStatus(''), 1500);
        } catch (e) {
            showError('Fallo al refrescar: ' + (e && e.message ? e.message : ''), 'provinciaError');
        }
    }

    // exponer utilidades para debug / admin
    window.Municipios = window.Municipios || {};
    window.Municipios.refresh = refresh;
    window.Municipios.clearCache = clearStored;

    document.addEventListener('DOMContentLoaded', init);
})();
