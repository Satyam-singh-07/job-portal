<form class="filters-form" method="GET" action="{{ route('admin.companies.index') }}">
    <input class="input" type="text" name="search" value="{{ $filters['search'] }}" placeholder="Search company, email, username, industry">

    <select class="select" name="status">
        <option value="">All account status</option>
        @foreach (['Active', 'Suspended'] as $status)
            <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ $status }}</option>
        @endforeach
    </select>

    <select class="select" name="industry">
        <option value="">All industries</option>
        @foreach ($industries as $industry)
            <option value="{{ $industry }}" @selected($filters['industry'] === $industry)>{{ $industry }}</option>
        @endforeach
    </select>

    <select class="select" name="sort">
        <option value="latest" @selected($filters['sort'] === 'latest')>Newest first</option>
        <option value="oldest" @selected($filters['sort'] === 'oldest')>Oldest first</option>
        <option value="name_asc" @selected($filters['sort'] === 'name_asc')>Name A-Z</option>
        <option value="name_desc" @selected($filters['sort'] === 'name_desc')>Name Z-A</option>
        <option value="jobs_desc" @selected($filters['sort'] === 'jobs_desc')>Most jobs</option>
        <option value="applications_desc" @selected($filters['sort'] === 'applications_desc')>Most applicants</option>
        <option value="rating_desc" @selected($filters['sort'] === 'rating_desc')>Highest rating</option>
        <option value="rating_asc" @selected($filters['sort'] === 'rating_asc')>Lowest rating</option>
    </select>

    <div></div>

    <div class="inline-actions">
        <button type="submit" class="btn primary">Apply</button>
        <a href="{{ route('admin.companies.index') }}" class="btn">Reset</a>
    </div>
</form>
