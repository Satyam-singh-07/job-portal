<form class="filters-form" method="GET" action="{{ route('admin.candidates.index') }}">
    <input class="input" type="text" name="search" value="{{ $filters['search'] }}" placeholder="Search name, email, username, role, skills">

    <select class="select" name="status">
        <option value="">All account status</option>
        @foreach (['Active', 'Suspended'] as $status)
            <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ $status }}</option>
        @endforeach
    </select>

    <select class="select" name="experience_level">
        <option value="">All experience levels</option>
        @foreach ($experienceLevels as $experienceLevel)
            <option value="{{ $experienceLevel }}" @selected($filters['experience_level'] === $experienceLevel)>{{ $experienceLevel }}</option>
        @endforeach
    </select>

    <select class="select" name="work_preference">
        <option value="">All work preferences</option>
        @foreach ($workPreferences as $workPreference)
            <option value="{{ $workPreference }}" @selected($filters['work_preference'] === $workPreference)>{{ $workPreference }}</option>
        @endforeach
    </select>

    <select class="select" name="open_to_work">
        <option value="">Open to work: all</option>
        <option value="yes" @selected($filters['open_to_work'] === 'yes')>Open to work: yes</option>
        <option value="no" @selected($filters['open_to_work'] === 'no')>Open to work: no</option>
    </select>

    <select class="select" name="sort">
        <option value="latest" @selected($filters['sort'] === 'latest')>Newest first</option>
        <option value="oldest" @selected($filters['sort'] === 'oldest')>Oldest first</option>
        <option value="name_asc" @selected($filters['sort'] === 'name_asc')>Name A-Z</option>
        <option value="name_desc" @selected($filters['sort'] === 'name_desc')>Name Z-A</option>
        <option value="applications_desc" @selected($filters['sort'] === 'applications_desc')>Most applications</option>
        <option value="last_active_desc" @selected($filters['sort'] === 'last_active_desc')>Most recently active</option>
    </select>

    <div class="inline-actions">
        <button type="submit" class="btn primary">Apply</button>
        <a href="{{ route('admin.candidates.index') }}" class="btn">Reset</a>
    </div>
</form>
