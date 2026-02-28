@extends('layouts.app')

@section('title', 'Job Listing')

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
                                <input type="text" name="search" id="searchInput" class="form-control" value="{{ request('search') }}" placeholder="Job title, keyword or company" />
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <select name="location" id="locationSelect" class="form-select">
                                    <option value="Location">Location</option>
                                    @foreach($jobs->pluck('location')->unique() as $loc)
                                        <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="jobs-hero-field select-field">
                                <i class="fa fa-briefcase" aria-hidden="true"></i>
                                <select name="category" id="categorySelect" class="form-select">
                                    <option value="Category">Category</option>
                                    @foreach($jobs->pluck('department')->unique()->filter() as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
                            @php
                                $types = ['Full Time', 'Part Time', 'Contract', 'Freelance', 'Internship'];
                            @endphp
                            @foreach($types as $type)
                                <li>
                                    <label>
                                        <input type="checkbox" name="types[]" value="{{ $type }}" class="filter-checkbox" {{ is_array(request('types')) && in_array($type, request('types')) ? 'checked' : '' }} /> 
                                        {{ $type }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="filter-card">
                        <h5>Experience</h5>
                        <ul class="filter-list">
                            @php
                                $experiences = ['Graduate', '1-2 years', '3+ years', '5+ years'];
                            @endphp
                            @foreach($experiences as $exp)
                                <li>
                                    <label>
                                        <input type="checkbox" name="experience[]" value="{{ $exp }}" class="filter-checkbox" {{ is_array(request('experience')) && in_array($exp, request('experience')) ? 'checked' : '' }} /> 
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
                            <span class="jobs-count" id="countText">Showing {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }} of {{ $jobs->total() }} results</span>
                        </div>
                        <div class="jobs-actions d-flex align-items-center gap-3 flex-wrap">
                            <div class="jobs-sort d-flex align-items-center gap-2">
                                <select name="sort" id="sortSelect" class="form-select filter-select">
                                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most recent</option>
                                    <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Salary (High to Low)</option>
                                    <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Salary (Low to High)</option>
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

    function fetchJobs() {
        const formData = $filterForm.serialize() + '&' + $('.filter-checkbox:checked').serialize() + '&' + $('.filter-select').serialize();
        
        $jobListContainer.css('opacity', '0.5');

        $.ajax({
            url: "{{ route('jobs.index') }}",
            data: formData,
            success: function(response) {
                $jobListContainer.html(response.html);
                $totalFound.text(response.total_found);
                $countText.text(response.count_text);
                $jobListContainer.css('opacity', '1');
                
                // Update URL without refreshing
                const newUrl = window.location.pathname + '?' + formData;
                window.history.pushState({ path: newUrl }, '', newUrl);
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
        
        const formData = $filterForm.serialize() + '&' + $('.filter-checkbox:checked').serialize() + '&' + $('.filter-select').serialize() + '&page=' + page;

        $jobListContainer.css('opacity', '0.5');

        $.ajax({
            url: "{{ route('jobs.index') }}",
            data: formData,
            success: function(response) {
                $jobListContainer.html(response.html);
                $totalFound.text(response.total_found);
                $countText.text(response.count_text);
                $jobListContainer.css('opacity', '1');
                
                $('html, body').animate({ scrollTop: $(".jobs-board").offset().top - 100 }, 200);

                const newUrl = window.location.pathname + '?' + formData;
                window.history.pushState({ path: newUrl }, '', newUrl);
            }
        });
    });

    // Real-time search with debounce
    let searchTimer;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchJobs, 500);
    });
});
</script>
@endsection
