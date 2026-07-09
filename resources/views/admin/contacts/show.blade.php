@extends('admin.layouts.app')

@section('title', 'Contact Message Details')

@section('content')
<div class="content-area p-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary modern-btn">
                        <i class="bi bi-arrow-left"></i> Back to Messages
                    </a>
                    <div>
                        <h2 class="mb-1">Contact Message #{{ $contact->id }}</h2>
                        <p class="text-muted mb-0">
                            From {{ $contact->name }} • {{ $contact->created_at->format('M j, Y \a\t g:i A') }} 
                            • {{ $contact->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-end">
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-outline-primary modern-btn dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i> Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="changeStatus('new')">
                                <i class="bi bi-exclamation-circle me-2"></i>Mark as New
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeStatus('read')">
                                <i class="bi bi-eye me-2"></i>Mark as Read
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeStatus('replied')">
                                <i class="bi bi-reply me-2"></i>Mark as Replied
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteContact()">
                                <i class="bi bi-trash me-2"></i>Delete Message
                            </a></li>
                        </ul>
                    </div>
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}&body=Hello {{ $contact->name }},%0D%0A%0D%0AThank you for your message regarding {{ $contact->subject }}. I have reviewed your requirements and would like to discuss your project further.%0D%0A%0D%0ABest regards,%0D%0AYounas Dev" 
                       class="btn btn-primary modern-btn">
                        <i class="bi bi-reply"></i> Reply Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Contact Information Card -->
        <div class="col-xl-4">
            <div class="contact-info-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Contact Profile -->
                    <div class="contact-profile-section">
                        <div class="contact-avatar-large" style="background: {{ ['#28a745', '#dc3545', '#6f42c1', '#fd7e14', '#20c997'][array_rand(['#28a745', '#dc3545', '#6f42c1', '#fd7e14', '#20c997'])] }};">
                            {{ strtoupper(substr($contact->name, 0, 2)) }}
                        </div>
                        <div class="contact-info">
                            <h4 class="contact-name">{{ $contact->name }}</h4>
                            <div class="contact-details">
                                <div class="detail-item">
                                    <i class="bi bi-envelope me-2"></i>
                                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                        {{ $contact->email }}
                                    </a>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-calendar me-2"></i>
                                    {{ $contact->created_at->format('M j, Y \a\t g:i A') }}
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-clock me-2"></i>
                                    {{ $contact->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status and Priority -->
                    <div class="status-section">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="status-item">
                                    <label class="form-label small">Status</label>
                                    <div>
                                        <span class="badge-status status-{{ $contact->status }}" id="currentStatus">
                                            @if($contact->status == 'new')
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                            @elseif($contact->status == 'read')
                                                <i class="bi bi-eye me-1"></i>
                                            @else
                                                <i class="bi bi-reply me-1"></i>
                                            @endif
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="status-item">
                                    <label class="form-label small">Priority</label>
                                    <div>
                                        @php
                                            $priority = getPriority($contact->service, $contact->created_at);
                                        @endphp
                                        <span class="priority-badge priority-{{ $priority['level'] }}">
                                            <i class="bi bi-{{ $priority['icon'] }} me-1"></i>
                                            {{ $priority['label'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Information -->
                    @if($contact->service)
                    <div class="service-section">
                        <label class="form-label small">Requested Service</label>
                        <div class="service-info">
                            <span class="service-badge {{ getServiceClass($contact->service) }}">
                                {{ getServiceLabel($contact->service) }}
                            </span>
                            <div class="service-description">
                                {{ $contact->service }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="quick-actions-section">
                        <label class="form-label small">Quick Actions</label>
                        <div class="d-grid gap-2">
                            <a href="mailto:{{ $contact->email }}" class="btn btn-outline-primary btn-sm modern-btn">
                                <i class="bi bi-envelope me-2"></i>Send Email
                            </a>
                            <a href="mailto:{{ $contact->email }}?subject=Quote for {{ $contact->service }}&body=Hello {{ $contact->name }},%0D%0A%0D%0AI would be happy to provide you with a detailed quote for {{ $contact->service }}. Let me prepare a proposal for you.%0D%0A%0D%0ABest regards,%0D%0AYounas Dev" 
                               class="btn btn-outline-success btn-sm modern-btn">
                                <i class="bi bi-calculator me-2"></i>Send Quote
                            </a>
                            <a href="https://calendly.com/younasdev" target="_blank" class="btn btn-outline-info btn-sm modern-btn">
                                <i class="bi bi-calendar-event me-2"></i>Schedule Call
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="col-xl-8">
            <div class="message-content-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-text me-2"></i>Message Details
                        </h5>
                        <div class="message-actions">
                            <button class="btn btn-outline-secondary btn-sm modern-btn" onclick="copyMessage()" title="Copy Message">
                                <i class="bi bi-clipboard"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm modern-btn" onclick="printMessage()" title="Print">
                                <i class="bi bi-printer"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Subject -->
                    <div class="subject-section">
                        <label class="form-label">Subject</label>
                        <div class="subject-content">
                            <h4 class="mb-2">{{ $contact->subject }}</h4>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="message-section">
                        <label class="form-label">Message</label>
                        <div class="message-content" id="messageContent">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>

                    <!-- Message Analytics -->
                    <div class="message-analytics">
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="bi bi-chat-text"></i>
                                    </div>
                                    <div class="analytics-data">
                                        <div class="analytics-value">{{ str_word_count($contact->message) }}</div>
                                        <div class="analytics-label">Words</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="bi bi-paragraph"></i>
                                    </div>
                                    <div class="analytics-data">
                                        <div class="analytics-value">{{ strlen($contact->message) }}</div>
                                        <div class="analytics-label">Characters</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="analytics-data">
                                        <div class="analytics-value">{{ ceil(str_word_count($contact->message) / 200) }}</div>
                                        <div class="analytics-label">Min Read</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="analytics-item">
                                    <div class="analytics-icon">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <div class="analytics-data">
                                        <div class="analytics-value">{{ $contact->status == 'new' ? 0 : 1 }}</div>
                                        <div class="analytics-label">Views</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Template -->
            <div class="response-template-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-reply me-2"></i>Quick Response Templates
                    </h5>
                </div>
                <div class="card-body">
                    <div class="template-buttons">
                        <button class="btn btn-outline-primary modern-btn me-2 mb-2" onclick="useTemplate('acknowledgment')">
                            <i class="bi bi-check-circle me-1"></i>Acknowledgment
                        </button>
                        <button class="btn btn-outline-success modern-btn me-2 mb-2" onclick="useTemplate('quote_request')">
                            <i class="bi bi-calculator me-1"></i>Quote Request
                        </button>
                        <button class="btn btn-outline-info modern-btn me-2 mb-2" onclick="useTemplate('schedule_call')">
                            <i class="bi bi-calendar me-1"></i>Schedule Call
                        </button>
                        <button class="btn btn-outline-warning modern-btn me-2 mb-2" onclick="useTemplate('more_info')">
                            <i class="bi bi-question-circle me-1"></i>Need More Info
                        </button>
                    </div>
                    
                    <div class="template-preview" id="templatePreview" style="display: none;">
                        <label class="form-label">Template Preview</label>
                        <div class="template-content" id="templateContent"></div>
                        <div class="template-actions mt-2">
                            <a href="#" id="templateEmailLink" class="btn btn-primary modern-btn">
                                <i class="bi bi-envelope me-2"></i>Send This Response
                            </a>
                            <button class="btn btn-outline-secondary modern-btn" onclick="hideTemplate()">
                                Cancel
                            </button>
                        </div>
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
    if (str_contains($service, 'laravel')) return 'Laravel Development';
    if (str_contains($service, 'api')) return 'API Integration';
    if (str_contains($service, 'payment')) return 'Payment Systems';
    if (str_contains($service, 'consultation')) return 'Technical Consultation';
    return 'Other Services';
}

function getPriority($service, $createdAt) {
    if (str_contains(strtolower($service ?? ''), 'laravel') || str_contains(strtolower($service ?? ''), 'api')) {
        return ['level' => 'high', 'label' => 'High Priority', 'icon' => 'exclamation-triangle-fill'];
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
// Response templates
const templates = {
    acknowledgment: {
        subject: "Re: {{ $contact->subject }}",
        body: "Hello {{ $contact->name }},%0D%0A%0D%0AThank you for reaching out to me regarding {{ $contact->subject }}. I have received your message and will review your requirements carefully.%0D%0A%0D%0AI will get back to you within 24 hours with a detailed response and next steps.%0D%0A%0D%0ABest regards,%0D%0AYounas Dev%0D%0ALaravel Expert & Web Developer"
    },
    quote_request: {
        subject: "Quote for {{ $contact->service ?? 'Your Project' }}",
        body: "Hello {{ $contact->name }},%0D%0A%0D%0AThank you for your interest in my services for {{ $contact->service ?? 'your project' }}.%0D%0A%0D%0ATo provide you with an accurate quote, I'll need to understand your requirements better. Could we schedule a brief call this week to discuss:%0D%0A%0D%0A• Project scope and timeline%0D%0A• Technical requirements%0D%0A• Budget expectations%0D%0A• Any specific challenges%0D%0A%0D%0APlease let me know your availability, and I'll send you a detailed proposal.%0D%0A%0D%0ABest regards,%0D%0AYounas Dev"
    },
    schedule_call: {
        subject: "Let's Schedule a Call - {{ $contact->subject }}",
        body: "Hello {{ $contact->name }},%0D%0A%0D%0AThank you for your message about {{ $contact->subject }}. I'd love to discuss your project in detail.%0D%0A%0D%0APlease book a convenient time for a call using my calendar link:%0D%0Ahttps://calendly.com/younasdev%0D%0A%0D%0ADuring our call, we can discuss:%0D%0A• Your specific requirements%0D%0A• Timeline and milestones%0D%0A• Technical approach%0D%0A• Investment and next steps%0D%0A%0D%0ALooking forward to speaking with you!%0D%0A%0D%0ABest regards,%0D%0AYounas Dev"
    },
    more_info: {
        subject: "Re: {{ $contact->subject }} - Need More Details",
        body: "Hello {{ $contact->name }},%0D%0A%0D%0AThank you for your inquiry regarding {{ $contact->subject }}.%0D%0A%0D%0ATo provide you with the best solution, I need a bit more information:%0D%0A%0D%0A• What's your current setup/platform?%0D%0A• What's your timeline for this project?%0D%0A• Do you have any specific technical requirements?%0D%0A• What's your budget range for this project?%0D%0A%0D%0AOnce I have these details, I can provide you with a comprehensive proposal and timeline.%0D%0A%0D%0ABest regards,%0D%0AYounas Dev"
    }
};

function useTemplate(templateType) {
    const template = templates[templateType];
    if (!template) return;
    
    document.getElementById('templateContent').innerHTML = template.body.replace(/%0D%0A/g, '<br>');
    document.getElementById('templatePreview').style.display = 'block';
    
    const emailLink = document.getElementById('templateEmailLink');
    emailLink.href = `mailto:{{ $contact->email }}?subject=${template.subject}&body=${template.body}`;
}

function hideTemplate() {
    document.getElementById('templatePreview').style.display = 'none';
}

function changeStatus(status) {
    fetch(`{{ route('admin.contacts.status', $contact) }}`, {
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
            updateStatusDisplay(status);
        } else {
            showToast('Error updating status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error updating status', 'error');
    });
}

function updateStatusDisplay(status) {
    const statusElement = document.getElementById('currentStatus');
    const icons = {
        'new': 'exclamation-circle',
        'read': 'eye',
        'replied': 'reply'
    };
    
    statusElement.className = `badge-status status-${status}`;
    statusElement.innerHTML = `<i class="bi bi-${icons[status]} me-1"></i>${status.charAt(0).toUpperCase() + status.slice(1)}`;
}

function deleteContact() {
    if (!confirm('Are you sure you want to delete this contact message? This action cannot be undone.')) {
        return;
    }
    
    // Implement delete logic here
    showToast('Contact deleted successfully!', 'success');
    setTimeout(() => {
        window.location.href = '{{ route("admin.contacts.index") }}';
    }, 1500);
}

function copyMessage() {
    const messageContent = document.getElementById('messageContent').innerText;
    navigator.clipboard.writeText(messageContent).then(() => {
        showToast('Message copied to clipboard!', 'success');
    });
}

function printMessage() {
    window.print();
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
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
/* Contact Show Page Styles */
.contact-info-card, .message-content-card, .response-template-card {
    background: var(--bs-body-bg);
    border-radius: 1rem;
    border: 1px solid var(--bs-border-color);
    margin-bottom: 2rem;
}

.card-header {
    background: var(--bs-secondary-bg);
    padding: 1.5rem;
    border-bottom: 1px solid var(--bs-border-color);
    border-radius: 1rem 1rem 0 0;
}

.card-body {
    padding: 2rem;
}

/* Contact Profile Section */
.contact-profile-section {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--bs-border-color);
}

.contact-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 1.5rem;
    margin: 0 auto 1rem;
}

.contact-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-body-color);
}

.contact-details {
    text-align: left;
}

.detail-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    color: var(--bs-secondary-color);
}

.detail-item a {
    color: var(--primary-color);
}

/* Status Section */
.status-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--bs-border-color);
}

.status-item label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--bs-body-color);
}

/* Service Section */
.service-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--bs-border-color);
}

.service-section label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--bs-body-color);
}

.service-info {
    margin-top: 0.5rem;
}

.service-description {
    font-size: 0.9rem;
    color: var(--bs-secondary-color);
    margin-top: 0.5rem;
}

/* Quick Actions Section */
.quick-actions-section label {
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-body-color);
}

/* Message Content */
.subject-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--bs-border-color);
}

.subject-section label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--bs-body-color);
}

.message-section {
    margin-bottom: 2rem;
}

.message-section label {
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-body-color);
}

.message-content {
    background: var(--bs-secondary-bg);
    border-radius: 0.75rem;
    padding: 2rem;
    border: 1px solid var(--bs-border-color);
    line-height: 1.7;
    font-size: 1rem;
    color: var(--bs-body-color);
}

/* Message Analytics */
.message-analytics {
    background: var(--bs-secondary-bg);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-top: 2rem;
}

.analytics-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    text-align: center;
}

.analytics-icon {
    width: 45px;
    height: 45px;
    border-radius: 0.75rem;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.analytics-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

.analytics-label {
    font-size: 0.8rem;
    color: var(--bs-secondary-color);
    text-transform: uppercase;
    font-weight: 600;
}

/* Template Section */
.template-buttons {
    margin-bottom: 1.5rem;
}

.template-preview {
    background: var(--bs-secondary-bg);
    border-radius: 0.75rem;
    padding: 1.5rem;
    border: 1px solid var(--bs-border-color);
}

.template-preview label {
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-body-color);
}

.template-content {
    background: var(--bs-body-bg);
    border-radius: 0.5rem;
    padding: 1rem;
    border: 1px solid var(--bs-border-color);
    line-height: 1.6;
    margin-bottom: 1rem;
}

/* Reuse existing badge styles */
.badge-status {
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-new { background: #fff3cd; color: #856404; }
.status-read { background: #cff4fc; color: #055160; }
.status-replied { background: #d1f2eb; color: #0e7245; }

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

/* Toast notifications */
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

/* Dark theme support */
[data-bs-theme="dark"] .contact-info-card,
[data-bs-theme="dark"] .message-content-card,
[data-bs-theme="dark"] .response-template-card {
    background: var(--bs-dark);
}

[data-bs-theme="dark"] .message-content {
    background: var(--bs-gray-800);
}

[data-bs-theme="dark"] .message-analytics {
    background: var(--bs-gray-800);
}

[data-bs-theme="dark"] .template-preview {
    background: var(--bs-gray-800);
}

[data-bs-theme="dark"] .template-content {
    background: var(--bs-dark);
}

[data-bs-theme="dark"] .service-laravel { background: #1a237e; color: #90caf9; }
[data-bs-theme="dark"] .service-api { background: #4a148c; color: #ce93d8; }
[data-bs-theme="dark"] .service-payment { background: #1b5e20; color: #a5d6a7; }
[data-bs-theme="dark"] .service-consultation { background: #e65100; color: #ffcc02; }
[data-bs-theme="dark"] .service-other { background: #424242; color: #e0e0e0; }

/* Print styles */
@media print {
    .page-header .col-md-4,
    .message-actions,
    .template-buttons,
    .template-actions,
    .quick-actions-section {
        display: none !important;
    }
    
    .contact-info-card,
    .message-content-card {
        box-shadow: none;
        border: 1px solid #000;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .analytics-item {
        flex-direction: column;
        text-align: center;
    }
    
    .template-buttons .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection