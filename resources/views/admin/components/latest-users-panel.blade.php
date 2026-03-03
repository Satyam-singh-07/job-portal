<div class="panel users-panel">
    <div class="panel-header" style="margin-bottom: 0.6rem;">
        <h3>Latest users</h3>
        <a href="{{ route('admin.dashboard') }}">Refresh <i class="fas fa-sync-alt"></i></a>
    </div>

    @forelse ($latestUsers as $user)
        @php
            $name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
            $name = $name !== '' ? $name : $user->email;
            $roleName = $user->role->name ?? 'user';
        @endphp

        <div class="user-row">
            <div>
                <div style="font-weight:700; color:#121f3f;">{{ $name }}</div>
                <div class="user-meta">{{ $user->email }}</div>
            </div>
            <div class="badge" style="text-transform: capitalize;">{{ $roleName }}</div>
        </div>
    @empty
        <div class="user-row">
            <div class="user-meta">No recent users.</div>
        </div>
    @endforelse
</div>
