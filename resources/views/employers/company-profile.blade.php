@extends('layouts.app')

@section('title', 'Company Profile')

@section('content')

<section class="dashboard-section profile-settings">
    <div class="container">
        <div class="dashboard-layout">

            @include('employers.partials.sidebar')

            <div class="dashboard-main">
                {{-- HEADER --}}
                <div class="settings-header">

                    <div class="avatar-upload text-center">

                        <img id="companyLogo"
                             src="{{ $employer->logo_url }}"
                             alt="{{ $employer->company_name }} logo"
                             class="rounded-circle shadow"
                             width="150"
                             height="150"
                             loading="lazy">

                        <label class="upload-label mt-2">
                            <input type="file"
                                   id="logoInput"
                                   class="d-none"
                                   accept="image/*">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            Update Logo
                        </label>

                        <div id="logoLoader" class="small text-muted mt-2 d-none">
                            Uploading...
                        </div>
                    </div>

                    <div class="settings-header-content">
                        <span>Company Profile</span>
                        <h2>{{ $employer->company_name }}</h2>

                        {{-- Rating --}}
                        @php
                            $rating = $employer->rating ?? 0;
                        @endphp

                        @for ($i = 0; $i < floor($rating); $i++)
                            <i class="fa-solid fa-star text-warning"></i>
                        @endfor

                        @if ($rating - floor($rating) >= 0.5)
                            <i class="fa-solid fa-star-half-stroke text-warning"></i>
                        @endif

                        <span class="rating-value">
                            {{ number_format($rating, 1) }}
                        </span>

                        <div class="settings-header-meta mt-2">
                            @if ($employer->team_size)
                                <span>
                                    <i class="fa-solid fa-users"></i>
                                    {{ $employer->team_size }}
                                </span>
                            @endif

                            @if ($employer->industry)
                                <span>
                                    <i class="fa-solid fa-briefcase"></i>
                                    {{ $employer->industry }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- FORM --}}
                <form action="{{ route('employer.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="settings-form">

                    @csrf
                    @method('PUT')

                    <div class="settings-card">

                        <div class="settings-card-header">
                            <h3>Company Information</h3>
                        </div>

                        <div class="settings-grid">

                            {{-- Company Name --}}
                            <div>
                                <label class="form-label">Company Name</label>
                                <input type="text"
                                       name="company_name"
                                       value="{{ old('company_name', $employer->company_name) }}"
                                       class="form-control @error('company_name') is-invalid @enderror">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Industry --}}
                            <div>
                                <label class="form-label">Industry</label>
                                <select name="industry"
                                        class="form-select @error('industry') is-invalid @enderror">
                                    <option value="">-- Select Industry --</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry }}"
                                            @selected(old('industry', $employer->industry) === $industry)>
                                            {{ $industry }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('industry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $employer->email) }}"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div>
                                <label class="form-label">Website</label>
                                <input type="url"
                                       name="website"
                                       value="{{ old('website', $employer->website) }}"
                                       class="form-control">
                            </div>

                            {{-- Tagline --}}
                            <div>
                                <label class="form-label">Tagline</label>
                                <input type="text"
                                       name="tagline"
                                       value="{{ old('tagline', $employer->tagline) }}"
                                       class="form-control">
                            </div>

                            {{-- Company Size --}}
                            <div>
                                <label class="form-label">Company Size</label>
                                <input type="text"
                                       name="team_size"
                                       value="{{ old('team_size', $employer->team_size) }}"
                                       class="form-control">
                            </div>

                            {{-- Summary --}}
                            <div class="grid-span-2">
                                <label class="form-label">About Company</label>
                                <textarea name="summary"
                                          rows="5"
                                          class="form-control">{{ old('summary', $employer->summary) }}</textarea>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions mt-4">
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('logoInput');
    const logo = document.getElementById('companyLogo');
    const loader = document.getElementById('logoLoader');

    input.addEventListener('change', async function () {

        if (!this.files.length) return;

        const formData = new FormData();
        formData.append('logo', this.files[0]);

        loader.classList.remove('d-none');

        try {
            const response = await fetch("{{ route('employer.profile.logo') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const data = await response.json();

            loader.classList.add('d-none');

            if (data.status) {
                logo.src = data.logo_url + '?' + Date.now();
            }

        } catch (error) {
            loader.classList.add('d-none');
        }
    });
});
</script>
@endsection