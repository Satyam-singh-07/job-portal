@extends('layouts.app')

@section('title', 'Job Alerts')

@section('content')
<section class="dashboard-section">
    <div class="container">
        <div class="dashboard-layout">
            @include('candidates.partials.sidebar')

            <div class="dashboard-main">
                <div class="dashboard-page-header">
                    <div>
                        <h1>Job Alerts</h1>
                        <p>Create targeted notifications by role, location, and compensation so you never miss a fit.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @if(($stats['active'] ?? 0) > 0)
                            <form action="{{ route('candidate.alerts.pause-all') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-bell-slash" aria-hidden="true"></i> Pause all
                                </button>
                            </form>
                        @endif
                        <a href="#newAlert" class="btn btn-primary">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i> New alert
                        </a>
                    </div>
                </div>

                <div class="list-card">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h3 class="mb-0">Active Alerts</h3>
                        <div class="d-flex align-items-center gap-2 small text-muted">
                            <span>Total: {{ $stats['total'] ?? 0 }}</span>
                            <span>Active: {{ $stats['active'] ?? 0 }}</span>
                            <span>Paused: {{ $stats['paused'] ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('candidate.alerts', ['status' => 'all']) }}"
                            class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
                        <a href="{{ route('candidate.alerts', ['status' => 'active']) }}"
                            class="btn btn-sm {{ $status === 'active' ? 'btn-primary' : 'btn-outline-secondary' }}">Active</a>
                        <a href="{{ route('candidate.alerts', ['status' => 'paused']) }}"
                            class="btn btn-sm {{ $status === 'paused' ? 'btn-primary' : 'btn-outline-secondary' }}">Paused</a>
                    </div>

                    @php
                        $jobTypeLabels = [
                            'any' => 'Any',
                            'full_time' => 'Full-time',
                            'contract' => 'Contract',
                            'freelance' => 'Freelance',
                            'internship' => 'Internship',
                        ];

                        $frequencyLabels = [
                            'instant' => 'Instant',
                            'daily' => 'Daily',
                            'weekly' => 'Weekly',
                        ];

                        $deliveryLabels = [
                            'email' => 'Email',
                            'in_app' => 'In-app',
                            'sms' => 'SMS',
                        ];
                    @endphp

                    @if($alerts->isEmpty())
                        <div class="empty-state text-center py-5 bg-white rounded-4 shadow-sm">
                            <i class="fa-solid fa-bell fa-3x mb-3 text-muted"></i>
                            <h3>No Alerts Yet</h3>
                            <p>Create your first alert to get matched jobs delivered automatically.</p>
                        </div>
                    @else
                        <ul>
                            @foreach($alerts as $alert)
                                <li data-alert-id="{{ $alert->id }}">
                                    <div>
                                        <strong>
                                            {{ $alert->role_keywords }}
                                            @if($alert->locations)
                                                · {{ $alert->locations }}
                                            @endif
                                        </strong>
                                        <p class="mb-0 text-muted">
                                            {{ $jobTypeLabels[$alert->job_type] ?? ucfirst($alert->job_type) }} ·
                                            {{ $frequencyLabels[$alert->frequency] ?? ucfirst($alert->frequency) }} ·
                                            {{ $deliveryLabels[$alert->delivery_channel] ?? ucfirst($alert->delivery_channel) }}
                                            @if($alert->min_salary)
                                                · Min ${{ number_format($alert->min_salary) }}
                                            @endif
                                        </p>
                                        @if($alert->notes)
                                            <p class="mb-0 text-muted">{{ $alert->notes }}</p>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('candidate.alerts.destroy', $alert->id) }}" method="POST" class="m-0"
                                            onsubmit="return confirm('Delete this alert permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>

                                        <label class="toggle-switch" title="Toggle alert status">
                                            <input
                                                type="checkbox"
                                                class="js-alert-toggle"
                                                data-alert-id="{{ $alert->id }}"
                                                {{ $alert->is_active ? 'checked' : '' }}
                                            />
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        @if($alerts->hasPages())
                            <div class="mt-3">
                                {{ $alerts->links() }}
                            </div>
                        @endif
                    @endif
                </div>

                <div id="newAlert" class="settings-card mt-4">
                    <div class="settings-card-header">
                        <div>
                            <p class="text-uppercase text-muted small fw-semibold mb-1">Create Alert</p>
                            <h3>Alert Builder</h3>
                            <p>Combine filters to match the exact opportunities you want in your inbox.</p>
                        </div>
                    </div>

                    <form action="{{ route('candidate.alerts.store') }}" method="POST">
                        @csrf
                        <div class="settings-grid">
                            <div>
                                <label class="form-label" for="role_keywords">Role keywords</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="role_keywords"
                                    name="role_keywords"
                                    value="{{ old('role_keywords') }}"
                                    placeholder="Product Designer, UX Lead"
                                    required
                                />
                            </div>
                            <div>
                                <label class="form-label" for="locations">Locations</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="locations"
                                    name="locations"
                                    value="{{ old('locations') }}"
                                    placeholder="Remote · Seattle · Berlin"
                                />
                            </div>
                            <div>
                                <label class="form-label" for="job_type">Job type</label>
                                <select class="form-select" id="job_type" name="job_type" required>
                                    <option value="any" {{ old('job_type', 'any') === 'any' ? 'selected' : '' }}>Any</option>
                                    <option value="full_time" {{ old('job_type') === 'full_time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="contract" {{ old('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="freelance" {{ old('job_type') === 'freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="internship" {{ old('job_type') === 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" for="frequency">Frequency</label>
                                <select class="form-select" id="frequency" name="frequency" required>
                                    <option value="daily" {{ old('frequency', 'daily') === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('frequency') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="instant" {{ old('frequency') === 'instant' ? 'selected' : '' }}>Instant</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" for="min_salary">Minimum salary</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="min_salary"
                                    name="min_salary"
                                    value="{{ old('min_salary') }}"
                                    placeholder="USD 140000"
                                />
                            </div>
                            <div>
                                <label class="form-label" for="delivery_channel">Delivery</label>
                                <select class="form-select" id="delivery_channel" name="delivery_channel" required>
                                    <option value="email" {{ old('delivery_channel', 'email') === 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="in_app" {{ old('delivery_channel') === 'in_app' ? 'selected' : '' }}>In-app</option>
                                    <option value="sms" {{ old('delivery_channel') === 'sms' ? 'selected' : '' }}>SMS</option>
                                </select>
                            </div>
                            <div class="grid-span-2">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea
                                    class="form-control"
                                    id="notes"
                                    name="notes"
                                    placeholder="Add reminder about contract preferences, companies to exclude, etc."
                                >{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        <div class="form-actions mt-3">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Save alert</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
(() => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const showToast = (message, type = 'success') => {
        const toastElement = document.getElementById('liveToast');
        if (!toastElement || !window.bootstrap) {
            return;
        }

        toastElement.classList.remove('bg-success', 'bg-danger');
        toastElement.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');

        const body = toastElement.querySelector('.toast-body');
        if (body) {
            body.textContent = message;
        }

        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    };

    document.querySelectorAll('.js-alert-toggle').forEach((toggle) => {
        toggle.addEventListener('change', async (event) => {
            const checkbox = event.target;
            const alertId = checkbox.dataset.alertId;
            const isActive = checkbox.checked;

            try {
                const response = await fetch(`/candidate/alerts/${alertId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ is_active: isActive ? 1 : 0 }),
                });

                const payload = await response.json();

                if (!response.ok || !payload.success) {
                    throw new Error(payload.message || 'Could not update alert status.');
                }

                showToast(payload.message, 'success');
            } catch (error) {
                checkbox.checked = !isActive;
                showToast(error.message || 'Something went wrong.', 'error');
            }
        });
    });
})();
</script>
@endsection
