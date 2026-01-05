{{-- Filter and Search Component --}}
<div class="filter-search-container mb-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-3">
            <form method="GET" action="{{ request()->url() }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    {{-- Search Input --}}
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">🔍 Pencarian</label>
                        <input type="text" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="{{ $searchPlaceholder ?? 'Cari data...' }}"
                               value="{{ $filters['search'] ?? '' }}">
                    </div>

                    {{-- Dynamic Filter Slots --}}
                    {{ $slot }}

                    {{-- Per Page --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">📄 Per Halaman</label>
                        <select name="per_page" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
                            @foreach($perPageOptions as $option)
                                <option value="{{ $option }}" {{ ($filters['per_page'] ?? 10) == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-fill filter-btn">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ request()->url() }}" 
                               class="btn btn-outline-secondary btn-sm reset-btn" 
                               title="Reset semua filter"
                               data-bs-toggle="tooltip">
                                <i class="fas fa-redo-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.filter-search-container .form-label {
    color: #191B47;
    margin-bottom: 4px;
}

.filter-search-container .form-control,
.filter-search-container .form-select {
    border: 1px solid #e0e6ed;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.filter-search-container .form-control:focus,
.filter-search-container .form-select:focus {
    border-color: #191B47;
    box-shadow: 0 0 0 0.2rem rgba(25, 27, 71, 0.1);
}

.filter-search-container .btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.filter-search-container .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.filter-search-container .btn:hover::before {
    left: 100%;
}

.filter-search-container .btn-primary {
    background: linear-gradient(135deg, #191B47, #242A61);
    border: none;
    box-shadow: 0 4px 12px rgba(25, 27, 71, 0.3);
}

.filter-search-container .btn-primary:hover {
    background: linear-gradient(135deg, #242A61, #2d3875);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(25, 27, 71, 0.4);
}

.filter-search-container .reset-btn {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: 2px solid #dee2e6;
    color: #6c757d;
    width: 42px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.filter-search-container .reset-btn:hover {
    background: linear-gradient(135deg, #F6CFB5, #f4c2a1);
    border-color: #F6CFB5;
    color: #191B47;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 20px rgba(246, 207, 181, 0.4);
}

.filter-search-container .reset-btn i {
    font-size: 14px;
    transition: all 0.3s ease;
}

.filter-search-container .reset-btn:hover i {
    transform: rotate(-360deg) scale(1.1);
    color: #28a745;
}

.filter-search-container .filter-btn {
    background: linear-gradient(135deg, #191B47, #242A61);
    border: none;
    position: relative;
    overflow: hidden;
}

.filter-search-container .filter-btn:hover {
    background: linear-gradient(135deg, #242A61, #2d3875);
    transform: translateY(-2px);
}

.filter-search-container .filter-btn i {
    margin-right: 6px;
    transition: all 0.3s ease;
}

.filter-search-container .filter-btn:hover i {
    transform: scale(1.1);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .filter-search-container .col-md-2:last-child {
        margin-top: 15px;
    }
    
    .filter-search-container .reset-btn {
        width: 38px;
        height: 34px;
    }
    
    .filter-search-container .filter-btn {
        font-size: 13px;
    }
}
</style>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Add smooth animation for reset button
    const resetBtn = document.querySelector('.reset-btn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            // Add loading animation
            const icon = this.querySelector('i');
            icon.style.animation = 'spin 0.5s ease-in-out';
            
            setTimeout(() => {
                if (icon) icon.style.animation = '';
            }, 500);
        });
    }
});

// CSS Animation for spin
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>