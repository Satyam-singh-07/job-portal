@extends('layouts.app')

@section('title', 'Post Job')

@section('content')

    <div class="employer-hero">
        <div class="container">
            <div class="employer-hero-content">
                <div>
                    <span class="company-pill">{{ auth()->user()->company_name }}</span>
                    <h1>Create a new opportunity</h1>
                    <p>
                        Share role details, requirements, and perks so the right
                        candidates can find you faster.
                    </p>
                </div>
                <a href="{{ route('employer.dashboard') }}" class="btn btn-outline-primary">Back to Dashboard</a>
            </div>
        </div>
    </div>
    <section class="dashboard-section employer-dashboard post-job-dashboard">
        <div class="container mt-4">
            <div class="dashboard-layout">
                
                @include('employers.partials.sidebar')

                <div class="dashboard-main">
                    <section class="post-job-panel">
                        <div class="panel-heading">
                            <h3>Job overview</h3>
                            <span class="panel-note">Fields marked * are required</span>
                        </div>
                        <form class="post-job-form">
                            <div class="form-section">
                                <h4>Role basics</h4>
                                <div class="form-grid two-col">
                                    <label class="form-field">
                                        <span>Job title *</span>
                                        <input type="text" placeholder="e.g. Senior Product Designer" />
                                    </label>
                                    <label class="form-field">
                                        <span>Department</span>
                                        <input type="text" placeholder="Design Systems" />
                                    </label>
                                    <label class="form-field">
                                        <span>Location *</span>
                                        <input type="text" placeholder="Hybrid · Seattle, USA" />
                                    </label>
                                    <label class="form-field">
                                        <span>Employment type</span>
                                        <select>
                                            <option>Full Time</option>
                                            <option>Part Time</option>
                                            <option>Contract</option>
                                            <option>Freelance</option>
                                        </select>
                                    </label>
                                    <label class="form-field">
                                        <span>Salary range</span>
                                        <input type="text" placeholder="$90k - $120k / year" />
                                    </label>
                                    <label class="form-field">
                                        <span>Seniority</span>
                                        <select>
                                            <option>Lead / Principal</option>
                                            <option>Senior</option>
                                            <option>Mid Level</option>
                                            <option>Entry Level</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4>Candidate preferences</h4>
                                <div class="form-grid three-col">
                                    <label class="form-field">
                                        <span>Experience</span>
                                        <select>
                                            <option>5+ years</option>
                                            <option>3+ years</option>
                                            <option>1-2 years</option>
                                            <option>Graduate</option>
                                        </select>
                                    </label>
                                    <label class="form-field">
                                        <span>Open roles</span>
                                        <input type="number" placeholder="1" />
                                    </label>
                                    <label class="form-field">
                                        <span>Visa sponsorship</span>
                                        <select>
                                            <option>Not available</option>
                                            <option>Available</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4>Role description</h4>
                                <label class="form-field">
                                    <span>Summary *</span>
                                    <textarea rows="4" placeholder="Describe the mission for this role..."></textarea>
                                </label>
                                <div class="form-grid two-col">
                                    <label class="form-field">
                                        <span>Responsibilities</span>
                                        <textarea rows="4" placeholder="Use bullet points or short sentences"></textarea>
                                    </label>
                                    <label class="form-field">
                                        <span>Must-have skills</span>
                                        <textarea rows="4" placeholder="List skills separated by commas"></textarea>
                                    </label>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4>Publishing</h4>
                                <div class="form-grid two-col">
                                    <label class="form-field">
                                        <span>Application email</span>
                                        <input type="email" placeholder="talent@northwind.com" />
                                    </label>
                                    <label class="form-field">
                                        <span>External apply link</span>
                                        <input type="url" placeholder="https://northwind.com/careers/designer" />
                                    </label>
                                </div>
                                <label class="form-field checkbox">
                                    <input type="checkbox" checked />
                                    <span>Allow quick apply inside Jobs Portal</span>
                                </label>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-outline-primary">
                                    Save Draft
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Publish Job
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </section>

@endsection
