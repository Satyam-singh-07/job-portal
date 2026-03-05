@extends('layouts.app')

@php
    $activeFilterCount = collect([
        $filters['search'] ?? null,
        $filters['location'] ?? null,
        $filters['category'] ?? null,
    ])->filter()->count() + count($filters['types'] ?? []) + count($filters['experience'] ?? []);

    $hasQuery = request()->query() !== [];
    $isFiltered = $activeFilterCount > 0;
    $pageTitle = $isFiltered ? 'Filtered Jobs' : 'Job Listings';
    $metaDescription = $isFiltered
        ? 'Explore filtered job openings by keyword, location, category, and experience. Find the best-fit role and apply quickly.'
        : 'Browse the latest verified job openings by location, category, and experience level. Apply online in minutes.';
@endphp

@section('title', $pageTitle.' | '.config('app.name', 'Job Portal'))
@section('meta_description', $metaDescription)
@section('canonical_url', route('jobs.index'))
@section('meta_robots', $hasQuery ? 'noindex,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1' : 'index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1')
@section('og_title', $pageTitle.' | '.config('app.name', 'Job Portal'))
@section('og_description', $metaDescription)
@section('og_url', route('jobs.index'))

@section('head')
    @if($jobs->previousPageUrl())
        <link rel="prev" href="{{ $jobs->previousPageUrl() }}">
    @endif
    @if($jobs->nextPageUrl())
        <link rel="next" href="{{ $jobs->nextPageUrl() }}">
    @endif
@endsection

@push('structured_data')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => $pageTitle,
    'url' => route('jobs.index'),
    'description' => $metaDescription,
    'isPartOf' => [
        '@type' => 'WebSite',
        'name' => config('app.name', 'Job Portal'),
        'url' => url('/'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => 'Job Listings',
    'itemListOrder' => 'https://schema.org/ItemListUnordered',
    'numberOfItems' => $jobs->count(),
    'itemListElement' => $jobs->getCollection()->values()->map(function ($job, $index) {
        return [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'url' => route('jobs.show', ['slug' => $job->slug]),
            'name' => $job->title,
        ];
    })->all(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')

    <!-- Jobs Hero -->
    <section class="jobs-hero">
        <div class="container">
            <div class="jobs-hero-wrapper">
                <span class="jobs-hero-badge">Browse Opportunities</span>
                <h1 class="jobs-hero-title">
                    Find a role that matches your ambition
                </h1>
                <p class="jobs-hero-copy">
                    Search thousands of curated openings across industries, experience
                    levels, and locations.
                </p>
                <form id="filterForm" class="jobs-hero-form">
                    <div class="row g-3">
                        <div class="col-lg-5 col-md-6">
                            <label class="jobs-hero-field">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                <input type="text" name="search" id="searchInput" class="form-control" value="{{ $filters['search'] }}" placeholder="Job title, keyword or company" />
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <select name="location" id="locationSelect" class="form-select">
                                    <option value="Location">Location</option>
                                    @foreach($filterOptions['locations'] as $loc)
                                        <option value="{{ $loc }}" {{ $filters['location'] === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-briefcase" aria-hidden="true"></i>
                                <select name="category" id="categorySelect" class="form-select">
                                    <option value="Category">Category</option>
                                    @foreach($filterOptions['categories'] as $cat)
                                        <option value="{{ $cat }}" {{ $filters['category'] === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="col-lg-1 col-md-6">
                            <button class="btn btn-primary jobs-hero-submit w-100" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="jobs-board">
        <div class="container">
            <div class="row g-4">
                <aside class="col-lg-3">
                    <div class="filter-card">
                        <h5>Job Type</h5>
                        <ul class="filter-list">
                            @foreach($jobTypes as $type)
                                <li>
                                    <label>
                                        <input type="checkbox" name="types[]" value="{{ $type }}" class="filter-checkbox" {{ in_array($type, $filters['types'], true) ? 'checked' : '' }} />
                                        {{ $type }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Experience</h5>
                        <ul class="filter-list">
                            @foreach($experienceLevels as $exp)
                                <li>
                                    <label>
                                        <input type="checkbox" name="experience[]" value="{{ $exp }}" class="filter-checkbox" {{ in_array($exp, $filters['experience'], true) ? 'checked' : '' }} />
                                        {{ $exp }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
                <div class="col-lg-9">
                    <div class="jobs-board-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h2 id="totalFound">{{ $jobs->total() }} Jobs Found</h2>
                            <span class="jobs-count" id="countText">{{ $countText }}</span>
                        </div>
                        <div class="jobs-actions d-flex align-items-center gap-3 flex-wrap">
                            <div class="jobs-sort d-flex align-items-center gap-2">
                                <select name="sort" id="sortSelect" class="form-select filter-select">
                                    <option value="recent" {{ $filters['sort'] === 'recent' ? 'selected' : '' }}>Most recent</option>
                                    <option value="salary_high" {{ $filters['sort'] === 'salary_high' ? 'selected' : '' }}>Salary (High to Low)</option>
                                    <option value="salary_low" {{ $filters['sort'] === 'salary_low' ? 'selected' : '' }}>Salary (Low to High)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div id="jobListContainer">
                        @include('jobs.partials.job-list', ['jobs' => $jobs])
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const $filterForm = $('#filterForm');
    const $jobListContainer = $('#jobListContainer');
    const $totalFound = $('#totalFound');
    const $countText = $('#countText');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    let activeRequest = null;

    function buildQuery(page = null) {
        const params = new URLSearchParams();

        $filterForm.serializeArray().forEach(function(item) {
            const isPlaceholder = (item.name === 'location' && item.value === 'Location')
                || (item.name === 'category' && item.value === 'Category');

            if (isPlaceholder) {
                return;
            }

            if (item.value) {
                params.append(item.name, item.value);
            }
        });

        $('.filter-checkbox:checked').each(function() {
            params.append(this.name, this.value);
        });

        $('.filter-select').each(function() {
            if (this.value) {
                params.set(this.name, this.value);
            }
        });

        if (page && Number(page) > 1) {
            params.set('page', page);
        } else {
            params.delete('page');
        }

        return params.toString();
    }

    function fetchJobs(page = null, shouldScroll = false) {
        const queryString = buildQuery(page);

        if (activeRequest) {
            activeRequest.abort();
        }

        $jobListContainer.css('opacity', '0.5');

        activeRequest = $.ajax({
            url: "{{ route('jobs.index') }}",
            data: queryString,
            success: function(response) {
                $jobListContainer.html(response.html);
                $totalFound.text(response.total_found);
                $countText.text(response.count_text);
                $jobListContainer.css('opacity', '1');

                if (shouldScroll) {
                    $('html, body').animate({ scrollTop: $(".jobs-board").offset().top - 100 }, 200);
                }

                const newUrl = queryString
                    ? window.location.pathname + '?' + queryString
                    : window.location.pathname;

                window.history.pushState({ path: newUrl }, '', newUrl);
            },
            error: function(_, status) {
                if (status !== 'abort') {
                    $jobListContainer.css('opacity', '1');
                }
            },
            complete: function() {
                activeRequest = null;
            }
        });
    }

    // Trigger on form submit
    $filterForm.on('submit', function(e) {
        e.preventDefault();
        fetchJobs();
    });

    // Trigger on checkbox change
    $('.filter-checkbox, .filter-select').on('change', function() {
        fetchJobs();
    });

    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const page = new URL(url).searchParams.get('page');
        fetchJobs(page, true);
    });

    let searchTimer;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchJobs, 500);
    });

    $(document).on('click', '.js-save-job', function() {
        const $btn = $(this);

        @auth
            @if(auth()->user()->isCandidate())
                const isFavorited = $btn.attr('data-is-favorited') === '1';
                const requestUrl = isFavorited ? $btn.data('remove-url') : $btn.data('save-url');
                const requestMethod = isFavorited ? 'DELETE' : 'POST';

                $btn.prop('disabled', true);

                $.ajax({
                    url: requestUrl,
                    method: requestMethod,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        const nowFavorited = !isFavorited;
                        $btn.attr('data-is-favorited', nowFavorited ? '1' : '0');
                        $btn.attr('aria-label', nowFavorited ? 'Remove saved job' : 'Save job');
                        $btn.toggleClass('active', nowFavorited);
                        $btn.html('<i class="' + (nowFavorited ? 'fa-solid' : 'fa-regular') + ' fa-bookmark" aria-hidden="true"></i>');
                        showToast(response?.message || (nowFavorited ? 'Job saved to favourites.' : 'Removed from favourites.'));
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            window.location.href = "{{ route('login') }}?redirect={{ url()->current() }}";
                            return;
                        }

                        showToast(xhr.responseJSON?.message || 'Unable to update favourites right now.', 'error');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            @else
                showToast('Only candidates can save jobs.', 'error');
            @endif
        @else
            window.location.href = "{{ route('login') }}?redirect={{ url()->current() }}";
        @endauth
    });
});

const showToast = (message, type = 'success') => {
    const $toast = $('#liveToast');
    $toast.removeClass('bg-success bg-danger bg-info').addClass('bg-' + (type === 'success' ? 'success' : (type === 'error' ? 'danger' : 'info')));
    $toast.find('.toast-body').text(message);
    const toast = new bootstrap.Toast($toast[0]);
    toast.show();
};
</script>
@endsection
