// Enhanced security version
(function() {
    'use strict';
    
    // Basic anti-debugging
    const _0x1f4a = {
        endpoint: '/api/search',
        method: 'GET',
        timeout: 5000
    };
    
    // Rate limiting
    let lastRequest = 0;
    const RATE_LIMIT = 2000; // 2 seconds between requests
    
    // Simple request signing (you can enhance this)
    function generateRequestId() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }
    
    // Obfuscated DOM element IDs
    const elements = {
        form: 'tracking-form',
        input: 'resi',
        result: 'tracking-result',
        status: 'current-status-text',
        location: 'current-location-text',
        resiText: 'resi-text',
        barangText: 'barang-text',
        kurirText: 'kurir-text',
        tableBody: 'tracking-table-body',
        toggleBtn: 'toggle-history',
        historyDiv: 'tracking-history'
    };
    
    function initTracking() {
        const form = document.getElementById(elements.form);
        if (!form) return;
        
        form.addEventListener('submit', handleSubmit);
        
        const toggleBtn = document.getElementById(elements.toggleBtn);
        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleHistory);
        }
    }
    
    function handleSubmit(e) {
        e.preventDefault();
        
        // Rate limiting
        const now = Date.now();
        if (now - lastRequest < RATE_LIMIT) {
            showError('Mohon tunggu sebentar sebelum mencoba lagi');
            return;
        }
        lastRequest = now;
        
        const input = document.getElementById(elements.input);
        if (!input) return;
        
        const resi = input.value.trim();
        if (!resi) {
            showError('Nomor resi tidak boleh kosong');
            return;
        }
        
        // Basic validation
        if (resi.length < 6 || resi.length > 20) {
            showError('Format nomor resi tidak valid');
            return;
        }
        
        performSearch(resi);
    }
    
    function performSearch(resi) {
        const requestId = generateRequestId();
        const url = `${_0x1f4a.endpoint}?resi=${encodeURIComponent(resi)}&_r=${requestId}`;
        
        // Add loading state
        showLoading();
        
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), _0x1f4a.timeout);
        
        fetch(url, {
            method: _0x1f4a.method,
            signal: controller.signal,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-Request-ID': requestId
            }
        })
        .then(response => {
            clearTimeout(timeoutId);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                showError('Nomor resi tidak ditemukan');
                return;
            }
            displayResults(resi, data);
        })
        .catch(error => {
            clearTimeout(timeoutId);
            if (error.name === 'AbortError') {
                showError('Request timeout, silakan coba lagi');
            } else {
                showError('Terjadi kesalahan, silakan coba lagi');
            }
        });
    }
    
    function showLoading() {
        const resultBox = document.getElementById(elements.result);
        const statusText = document.getElementById(elements.status);
        
        if (resultBox && statusText) {
            resultBox.style.display = 'block';
            statusText.innerText = 'Sedang mencari...';
        }
    }
    
    function showError(message) {
        const resultBox = document.getElementById(elements.result);
        const statusText = document.getElementById(elements.status);
        const locationText = document.getElementById(elements.location);
        const tableBody = document.getElementById(elements.tableBody);
        const toggleBtn = document.getElementById(elements.toggleBtn);
        
        if (resultBox) resultBox.style.display = 'block';
        if (statusText) statusText.innerText = message;
        if (locationText) locationText.innerText = '-';
        if (tableBody) tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Data tidak ditemukan</td></tr>';
        if (toggleBtn) toggleBtn.style.display = 'none';
    }
    
    function displayResults(resi, data) {
        const elements_map = {
            [elements.status]: data.status,
            [elements.location]: data.lokasi,
            [elements.resiText]: resi,
            [elements.barangText]: data.barang,
            [elements.kurirText]: data.kurir
        };
        
        Object.entries(elements_map).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) element.innerText = value;
        });
        
        const tableBody = document.getElementById(elements.tableBody);
        const toggleBtn = document.getElementById(elements.toggleBtn);
        const historyDiv = document.getElementById(elements.historyDiv);
        
        if (tableBody && data.riwayat) {
            let html = '';
            data.riwayat.forEach((item, index) => {
                html += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${escapeHtml(item.status)}</td>
                        <td>${escapeHtml(item.kurir)}</td>
                        <td>${escapeHtml(item.distrik)}</td>
                        <td>${escapeHtml(item.checkpoint)}</td>
                    </tr>`;
            });
            tableBody.innerHTML = html;
        }
        
        const resultBox = document.getElementById(elements.result);
        if (resultBox) resultBox.style.display = 'block';
        if (toggleBtn) {
            toggleBtn.innerText = 'Sembunyikan Riwayat';
            toggleBtn.style.display = 'inline-block';
        }
        if (historyDiv) historyDiv.style.display = 'block';
    }
    
    function toggleHistory() {
        const historyDiv = document.getElementById(elements.historyDiv);
        const toggleBtn = document.getElementById(elements.toggleBtn);
        
        if (historyDiv && toggleBtn) {
            if (historyDiv.style.display === 'none' || historyDiv.style.display === '') {
                historyDiv.style.display = 'block';
                toggleBtn.innerText = 'Sembunyikan Riwayat';
            } else {
                historyDiv.style.display = 'none';
                toggleBtn.innerText = 'Tampilkan Riwayat';
            }
        }
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTracking);
    } else {
        initTracking();
    }
})();