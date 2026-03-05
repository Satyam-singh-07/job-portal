<div class="panel">
    <div class="panel-header">
        <h3>Default Credits for New Accounts</h3>
    </div>

    <form method="POST" action="{{ route('admin.settings.default-balances') }}" class="filters-form" style="grid-template-columns: 1fr 1fr auto;">
        @csrf
        @method('PATCH')

        <label>
            <div class="muted" style="margin-bottom:.35rem;">Candidate application credits</div>
            <input
                type="number"
                min="0"
                max="100000"
                class="input"
                name="candidate_default_application_balance"
                value="{{ old('candidate_default_application_balance', $defaults['candidate_default_application_balance'] ?? 25) }}"
                required
            >
        </label>

        <label>
            <div class="muted" style="margin-bottom:.35rem;">Employer posting credits</div>
            <input
                type="number"
                min="0"
                max="100000"
                class="input"
                name="employer_default_posting_balance"
                value="{{ old('employer_default_posting_balance', $defaults['employer_default_posting_balance'] ?? 10) }}"
                required
            >
        </label>

        <div style="display:flex;align-items:flex-end;">
            <button type="submit" class="btn primary">Save Defaults</button>
        </div>
    </form>
</div>
