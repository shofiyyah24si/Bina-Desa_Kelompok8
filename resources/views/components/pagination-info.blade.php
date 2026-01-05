{{-- Pagination Info Component --}}
@if($data->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="pagination-info">
        <small class="text-muted">
            Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari {{ $data->total() }} data
        </small>
    </div>
    
    <div class="pagination-wrapper">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>

<style>
.pagination-wrapper .pagination {
    margin: 0;
}

.pagination-wrapper .page-link {
    color: #191B47;
    border: 1px solid #e0e6ed;
    border-radius: 8px !important;
    margin: 0 2px;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 500;
}

.pagination-wrapper .page-link:hover {
    background-color: #F6CFB5;
    border-color: #F6CFB5;
    color: #191B47;
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #191B47;
    border-color: #191B47;
    color: white;
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

@media (max-width: 768px) {
    .pagination-info {
        font-size: 12px;
    }
    
    .pagination-wrapper .page-link {
        padding: 6px 10px;
        font-size: 12px;
    }
}
</style>
@endif