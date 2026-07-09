@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="content-area p-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-1">Contact Messages</h2>
                <p class="text-muted mb-0">Manage client inquiries and communication</p>
            </div>
            <div class="col-md-6">
                <div class="text-end">
                    <button class="btn btn-outline-primary modern-btn me-2" data-bs-toggle="modal" data-bs-target="#bulkActionModal">
                        <i class="bi bi-gear"></i> Bulk Actions
                    </button>
                    <button class="btn btn-primary modern-btn" onclick="refreshMessages()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon icon-blue">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="ms-3">
                        <div class="small text-muted">Total Messages</div>
                        <div class="h4 mb-0">{{ number_format($contacts->total()) }}</div>
                        <div class="small text-success">
                            <i class="bi bi-arrow-up"></i> {{ $contacts->where('created_at', '>=', now()->subWeek())->count() }} this week
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon icon-orange">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div class="ms-3">
                        <div class="small text-muted">New Messages</div>
                        <div class="h4 mb-0">{{ number_format($contacts->where('status', 'new')->count()) }}</div>
                        <div class="small text-warning">
                            <i class="bi bi-clock"></i> Needs attention
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon icon-green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <div class="small text-muted">Replied</div>
                        <div class="h4 mb-0">{{ number_format($contacts->where('status', 'replied')->count()) }}</div>
                        <div class="small text-success">
                            <i class="bi bi-arrow-up"></i> 
                            @if($contacts->total() > 0)
                                {{ round(($contacts->where('status', 'replied')->count()/$contacts->total())*100, 1) }}% response rate
                            @else
                                0% response rate
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon icon-purple">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="ms-3">
                        <div class="small text-muted">Avg Response Time</div>
                        <div class="h4 mb-0">4.2h</div>
                        <div class="small text-success">
                            <i class="bi bi-arrow-down"></i> 15% faster
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Filters -->
        <div class="col-12">
            <div class="filter-card">
                <form method="GET" action="{{ route('admin.contacts.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Search Messages</label>
                            <div class="search-container">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search" class="form-control search-input" 
                                       placeholder="Search by name, email, subject..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Service</label>
                            <select name="service" class="form-select">
                                <option value="">All Services</option>
                                <option value="laravel" {{ request('service') == 'laravel' ? 'selected' : '' }}>Laravel Services</option>
                                <option value="api" {{ request('service') == 'api' ? 'selected' : '' }}>API Integration</option>
                                <option value="payment" {{ request('service') == 'payment' ? 'selected' : '' }}>Payment Systems</option>
                                <option value="consultation" {{ request('service') == 'consultation' ? 'selected' : '' }}>Consultation</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date Range</label>
                            <select name="date_range" class="form-select">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary modern-btn">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary modern-btn">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bulk Actions Bar (Hidden by default) -->
        <div class="col-12" id="bulkActionsBar" style="display: none;">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <strong><span id="selectedCount">0</span></strong> messages selected
                    <button class="btn btn-link btn-sm p-0 ms-2" onclick="selectAllVisible()" title="Select all visible">
                        <i class="bi bi-check-all"></i> Select All Visible
                    </button>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm modern-btn" onclick="bulkAction('read')" data-original-text="Mark as Read">
                        <i class="bi bi-eye"></i> Mark as Read
                    </button>
                    <button class="btn btn-primary btn-sm modern-btn" onclick="bulkAction('replied')" data-original-text="Mark as Replied">
                        <i class="bi bi-reply"></i> Mark as Replied
                    </button>
                    <button class="btn btn-warning btn-sm modern-btn" onclick="bulkAction('new')" data-original-text="Mark as New">
                        <i class="bi bi-arrow-clockwise"></i> Mark as New
                    </button>
                    <button class="btn btn-danger btn-sm modern-btn" onclick="bulkAction('delete')" data-original-text="Delete Selected">
                        <i class="bi bi-trash"></i> Delete Selected
                    </button>
                    <button class="btn btn-outline-secondary btn-sm modern-btn" onclick="clearSelection()">
                        <i class="bi bi-x"></i> Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="col-xl-12">
            <div class="contacts-table">
                <div class="table-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Contact Messages ({{ $contacts->total() }})</h5>
                        <div class="d-flex gap-2">
                            <div class="dropdown export-dropdown">
                                <button class="btn btn-outline-primary modern-btn dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-download"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-excel me-2"></i>Export as Excel</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-text me-2"></i>Export as CSV</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-pdf me-2"></i>Export as PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <input type="checkbox" class="form-check-input" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>Contact Details</th>
                                <th>Service</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Received</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contacts as $contact)
                            <tr class="contact-row {{ $contact->status == 'new' ? 'table-warning' : '' }}">
                                <td>
                                    <input type="checkbox" class="form-check-input contact-checkbox" 
                                           value="{{ $contact->id }}" onchange="updateSelection()">
                                </td>
                                <td>
                                    <div class="contact-profile">
                                        <div class="contact-avatar" style="background: {{ ['#28a745', '#dc3545', '#6f42c1', '#fd7e14', '#20c997'][array_rand(['#28a745', '#dc3545', '#6f42c1', '#fd7e14', '#20c997'])] }};">
                                            {{ strtoupper(substr($contact->name, 0, 2)) }}
                                        </div>
                                        <div class="contact-details">
                                            <div class="contact-name">{{ $contact->name }}</div>
                                            <div class="contact-email">
                                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                                    {{ $contact->email }}
                                                </a>
                                            </div>
                                            <div class="small text-muted">ID: #{{ $contact->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($contact->service)
                                        <span class="service-badge {{ getServiceClass($contact->service) }}">
                                            {{ getServiceLabel($contact->service) }}
                                        </span>
                                    @else
                                        <span class="text-muted small">No service specified</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="subject-preview">
                                        <div class="subject-text">{{ Str::limit($contact->subject, 40) }}</div>
                                        <div class="small text-muted">{{ Str::limit($contact->message, 60) }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-status status-{{ $contact->status }}">
                                        @if($contact->status == 'new')
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                        @elseif($contact->status == 'read')
                                            <i class="bi bi-eye me-1"></i>
                                        @else
                                            <i class="bi bi-reply me-1"></i>
                                        @endif
                                        {{ ucfirst($contact->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="contact-date">{{ $contact->created_at->format('M j, Y') }}</div>
                                    <div class="small text-muted">{{ $contact->created_at->format('g:i A') }}</div>
                                    <div class="small text-muted">{{ $contact->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    @php
                                        $priority = getPriority($contact->service, $contact->created_at);
                                    @endphp
                                    <span class="priority-badge priority-{{ $priority['level'] }}">
                                        <i class="bi bi-{{ $priority['icon'] }} me-1"></i>
                                        {{ $priority['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons d-flex gap-1">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.contacts.show', $contact) }}" 
                                           class="btn btn-outline-primary btn-sm modern-btn" 
                                           title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        <!-- Quick Reply Button -->
                                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}&body=Hello {{ $contact->name }},%0D%0A%0D%0AThank you for your message regarding {{ $contact->subject }}." 
                                           class="btn btn-outline-success btn-sm modern-btn" 
                                           title="Quick Reply">
                                            <i class="bi bi-reply"></i>
                                        </a>
                                        
                                        <!-- Status Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm modern-btn dropdown-toggle" 
                                                    data-bs-toggle="dropdown" title="Change Status">
                                                <i class="bi bi-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{ $contact->id }}, 'new')">
                                                    <i class="bi bi-exclamation-circle me-2"></i>Mark as New
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{ $contact->id }}, 'read')">
                                                    <i class="bi bi-eye me-2"></i>Mark as Read
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{ $contact->id }}, 'replied')">
                                                    <i class="bi bi-reply me-2"></i>Mark as Replied
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteContact({{ $contact->id }})">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <p class="mt-2">No contact messages found</p>
                                        <p class="small">Messages will appear here when clients contact you</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $contacts->firstItem() ?: 0 }} to {{ $contacts->lastItem() ?: 0 }} of {{ $contacts->total() }} entries
                        </div>
                        <nav>
                            {{ $contacts->withQueryString()->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
function getServiceClass($service) {
    if (str_contains(strtolower($service), 'laravel')) return 'service-laravel';
    if (str_contains(strtolower($service), 'api')) return 'service-api';
    if (str_contains(strtolower($service), 'payment')) return 'service-payment';
    if (str_contains(strtolower($service), 'consultation')) return 'service-consultation';
    return 'service-other';
}

function getServiceLabel($service) {
    $service = strtolower($service);
    if (str_contains($service, 'laravel')) return 'Laravel';
    if (str_contains($service, 'api')) return 'API';
    if (str_contains($service, 'payment')) return 'Payment';
    if (str_contains($service, 'consultation')) return 'Consultation';
    return 'Other';
}

function getPriority($service, $createdAt) {
    if (str_contains(strtolower($service ?? ''), 'laravel') || str_contains(strtolower($service ?? ''), 'api')) {
        return ['level' => 'high', 'label' => 'High', 'icon' => 'exclamation-triangle-fill'];
    }
    if ($createdAt->diffInHours(now()) < 2) {
        return ['level' => 'urgent', 'label' => 'Urgent', 'icon' => 'lightning-fill'];
    }
    if (str_contains(strtolower($service ?? ''), 'consultation')) {
        return ['level' => 'medium', 'label' => 'Medium', 'icon' => 'dash-circle-fill'];
    }
    return ['level' => 'normal', 'label' => 'Normal', 'icon' => 'circle-fill'];
}
@endphp

<script>
// Contact management JavaScript
let selectedContacts = [];

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelection();
}

function updateSelection() {
    const checkboxes = document.querySelectorAll('.contact-checkbox:checked');
    selectedContacts = Array.from(checkboxes).map(cb => cb.value);
    
    document.getElementById('selectedCount').textContent = selectedContacts.length;
    
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    if (selectedContacts.length > 0) {
        bulkActionsBar.style.display = 'block';
    } else {
        bulkActionsBar.style.display = 'none';
    }
}

function clearSelection() {
    selectedContacts = [];
    document.querySelectorAll('.contact-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('selectAll').checked = false;
    document.getElementById('bulkActionsBar').style.display = 'none';
}

function changeStatus(contactId, status) {
    const updateUrl = `{{ route('admin.contacts.status', ['contact' => ':id']) }}`;
    let url = updateUrl.replace(':id', contactId);
    
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Status updated successfully!', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast('Error updating status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error updating status', 'error');
    });
}

function bulkAction(action) {
    if (selectedContacts.length === 0) {
        showToast('Please select contacts first', 'warning');
        return;
    }
    
    if (action === 'delete' && !confirm(`Are you sure you want to delete ${selectedContacts.length} selected contact(s)? This action cannot be undone.`)) {
        return;
    }
    
    // Show loading state
    const actionButtons = document.querySelectorAll('#bulkActionsBar .btn');
    actionButtons.forEach(btn => {
        btn.disabled = true;
        if (btn.textContent.toLowerCase().includes(action)) {
            btn.innerHTML = '<i class="bi bi-spinner spinner-border spinner-border-sm me-2"></i>Processing...';
        }
    });
    
    // Perform bulk action
    const url = action === 'delete' 
        ? '{{ route("admin.contacts.bulk-delete") }}' 
        : '{{ route("admin.contacts.bulk-status") }}';
    
    const requestData = {
        contact_ids: selectedContacts,
        ...(action !== 'delete' && { status: action })
    };
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || `Bulk ${action} completed successfully!`, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || `Error performing bulk ${action}`, 'error');
            // Re-enable buttons
            actionButtons.forEach(btn => {
                btn.disabled = false;
                if (btn.textContent.includes('Processing')) {
                    btn.innerHTML = btn.getAttribute('data-original-text') || btn.textContent.replace('Processing...', action);
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(`Error performing bulk ${action}`, 'error');
        // Re-enable buttons
        actionButtons.forEach(btn => {
            btn.disabled = false;
            if (btn.textContent.includes('Processing')) {
                btn.innerHTML = btn.getAttribute('data-original-text') || btn.textContent.replace('Processing...', action);
            }
        });
    });
}

function deleteContact(contactId) {
    if (!confirm('Are you sure you want to delete this contact? This action cannot be undone.')) {
        return;
    }
    
    // Show loading state
    const deleteBtn = document.querySelector(`[onclick="deleteContact(${contactId})"]`);
    if (deleteBtn) {
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="bi bi-spinner spinner-border spinner-border-sm"></i>';
    }
    
    fetch(`{{ route('admin.contacts.destroy', ['contact' => ':id']) }}`.replace(':id', contactId), {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Contact deleted successfully!', 'success');
            // Remove the row with animation
            const row = deleteBtn.closest('tr');
            row.style.opacity = '0.5';
            row.style.transition = 'opacity 0.3s ease';
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Error deleting contact', 'error');
            if (deleteBtn) {
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<i class="bi bi-trash me-2"></i>Delete';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error deleting contact', 'error');
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="bi bi-trash me-2"></i>Delete';
        }
    });
}

function refreshMessages() {
    location.reload();
}

function showToast(message, type) {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="btn-close ms-auto"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}
</script>

<style>
/* Contact-specific styles */
.contacts-table {
    background: var(--bs-body-bg);
    border-radius: 1rem;
    border: 1px solid var(--bs-border-color);
    overflow: hidden;
}

.contact-profile {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.contact-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 0.9rem;
}

.contact-details {
    display: flex;
    flex-direction: column;
}

.contact-name {
    font-weight: 600;
    margin-bottom: 0.125rem;
}

.contact-email {
    font-size: 0.85rem;
    color: var(--bs-secondary-color);
    margin-bottom: 0.125rem;
}

.subject-preview .subject-text {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.service-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.7rem;
    font-weight: 600;
}

.service-laravel { background: #e1f5fe; color: #0277bd; }
.service-api { background: #f3e5f5; color: #7b1fa2; }
.service-payment { background: #e8f5e8; color: #2e7d32; }
.service-consultation { background: #fff3e0; color: #ef6c00; }
.service-other { background: #f5f5f5; color: #616161; }

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.7rem;
    font-weight: 600;
}

.priority-urgent { background: #ffebee; color: #c62828; }
.priority-high { background: #fff3e0; color: #ef6c00; }
.priority-medium { background: #e3f2fd; color: #1976d2; }
.priority-normal { background: #f1f8e9; color: #388e3c; }

.badge-status {
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-new { background: #fff3cd; color: #856404; }
.status-read { background: #cff4fc; color: #055160; }
.status-replied { background: #d1f2eb; color: #0e7245; }

.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 1rem;
    border-radius: 0.5rem;
    color: white;
    z-index: 9999;
    min-width: 300px;
}

.toast-success { background: #28a745; }
.toast-error { background: #dc3545; }
.toast-warning { background: #ffc107; color: #333; }

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

/* Dark theme support */
[data-bs-theme="dark"] .contacts-table {
    background: var(--bs-dark);
}

[data-bs-theme="dark"] .service-laravel { background: #1a237e; color: #90caf9; }
[data-bs-theme="dark"] .service-api { background: #4a148c; color: #ce93d8; }
[data-bs-theme="dark"] .service-payment { background: #1b5e20; color: #a5d6a7; }
[data-bs-theme="dark"] .service-consultation { background: #e65100; color: #ffcc02; }
[data-bs-theme="dark"] .service-other { background: #424242; color: #e0e0e0; }

[data-bs-theme="dark"] .table-warning {
    background-color: rgba(255, 193, 7, 0.2) !important;
}

/* Loading states */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.spinner-border-sm {
    width: 0.8rem;
    height: 0.8rem;
}

/* Bulk actions improvements */
#bulkActionsBar {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Row selection highlight */
.contact-checkbox:checked + td,
.contact-checkbox:checked ~ td {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.contact-row.selected {
    background-color: rgba(13, 110, 253, 0.05) !important;
}

/* Hover effects for action buttons */
.action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* Status transition effects */
.badge-status {
    transition: all 0.3s ease;
}

.badge-status:hover {
    transform: scale(1.05);
}

/* Quick select button */
.btn-link:hover {
    text-decoration: underline !important;
}

/* Improved toast positioning for mobile */
@media (max-width: 768px) {
    .toast-notification {
        left: 10px;
        right: 10px;
        width: auto;
        min-width: auto;
    }
    
    #bulkActionsBar .d-flex {
        flex-direction: column;
        gap: 0.5rem;
        align-items: stretch;
    }
    
    #bulkActionsBar .btn {
        width: 100%;
    }
}

/* Loading overlay for bulk actions */
.bulk-loading {
    position: relative;
    pointer-events: none;
}

.bulk-loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 0.5rem;
    z-index: 10;
}

[data-bs-theme="dark"] .bulk-loading::after {
    background: rgba(0, 0, 0, 0.8);
}
</style>
@endsection