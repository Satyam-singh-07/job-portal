<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Candidate</th>
                <th>Profile</th>
                <th>Skills</th>
                <th>Engagement</th>
                <th>Balance</th>
                <th>Account</th>
                <th>Last Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($candidates as $candidate)
            @php
                $fullName = trim(($candidate->first_name ?? '') . ' ' . ($candidate->last_name ?? ''));
                $displayName = $fullName !== '' ? $fullName : $candidate->email;
                $initials = \Illuminate\Support\Str::of($displayName)->explode(' ')->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
                $profile = $candidate->candidateProfile;
                $skills = collect($profile?->skills ?? [])->filter()->take(3)->values();
                $accountStatus = $candidate->account_status ?? 'Active';
                $isSuspended = $accountStatus === 'Suspended';
                $isOpenToWork = (bool) ($profile?->is_searchable ?? false);
            @endphp
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:.7rem;">
                        <div style="width:40px;height:40px;border-radius:999px;background:#e8efff;color:#1f4191;display:flex;align-items:center;justify-content:center;font-weight:700;">
                            {{ $initials !== '' ? $initials : 'U' }}
                        </div>
                        <div>
                            <div style="font-weight:700;">{{ $displayName }}</div>
                            <div class="muted">{{ $candidate->email }} | {{ $candidate->username ?: '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div>{{ $profile?->title ?: 'No title set' }}</div>
                    <div class="muted">{{ $profile?->experience_level ?: '-' }} | {{ $profile?->location ?: '-' }}</div>
                    <div class="muted">{{ $profile?->work_preference ?: 'No work preference' }}</div>
                </td>
                <td>
                    @if ($skills->isNotEmpty())
                        <div style="display:flex;gap:.3rem;flex-wrap:wrap;">
                            @foreach ($skills as $skill)
                                <span class="pill draft">{{ $skill }}</span>
                            @endforeach
                        </div>
                    @else
                        <span class="muted">No skills provided</span>
                    @endif
                </td>
                <td>
                    <div>{{ number_format((int) $candidate->applications_count) }} applications</div>
                    <div class="muted">{{ number_format((int) $candidate->favorite_jobs_count) }} saved jobs | {{ number_format((int) $candidate->following_employers_count) }} followings</div>
                    <div class="muted">Open to work: {{ $isOpenToWork ? 'Yes' : 'No' }}</div>
                </td>
                <td>
                    <span class="pill {{ (int) ($candidate->job_application_balance ?? 0) <= 2 ? 'closed' : 'published' }}">
                        {{ (int) ($candidate->job_application_balance ?? 0) }} credits
                    </span>
                </td>
                <td>
                    <span class="pill {{ $isSuspended ? 'closed' : 'published' }}">
                        {{ $accountStatus }}
                    </span>
                </td>
                <td>
                    @if (!empty($candidate->last_seen_at))
                        <div>{{ \Carbon\Carbon::parse($candidate->last_seen_at)->format('M d, Y H:i') }}</div>
                        <div class="muted">{{ \Carbon\Carbon::parse($candidate->last_seen_at)->diffForHumans() }}</div>
                    @else
                        <span class="muted">No recent activity</span>
                    @endif
                </td>
                <td>
                    <div class="inline-actions">
                        @if ($isSuspended)
                            <form method="POST" action="{{ route('admin.candidates.status', $candidate) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="account_status" value="Active">
                                <button type="submit" class="btn">Activate</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.candidates.status', $candidate) }}" onsubmit="return confirm('Suspend this candidate account?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="account_status" value="Suspended">
                                <button type="submit" class="btn danger">Suspend</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.candidates.open-to-work', $candidate) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="open_to_work" value="{{ $isOpenToWork ? 0 : 1 }}">
                            <button type="submit" class="btn">{{ $isOpenToWork ? 'Close to Work' : 'Open to Work' }}</button>
                        </form>

                        <form method="POST" action="{{ route('admin.candidates.application-balance', $candidate) }}" class="inline-actions" style="align-items:center;">
                            @csrf
                            @method('PATCH')
                            <select name="balance_action" class="select" style="max-width:110px;">
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>
                                <option value="set">Set</option>
                            </select>
                            <input type="number" name="amount" min="0" max="100000" class="input" style="max-width:100px;" value="1" required>
                            <button type="submit" class="btn">Update Credits</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="muted" style="padding:1rem;">No candidates found for current filters.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrap">
    {{ $candidates->links() }}
</div>
