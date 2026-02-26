@extends('layouts.app')

@section('title', 'Build Resume')

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-layout">

                @include('candidates.partials.sidebar')

                <div class="dashboard-main">

                    <div class="dashboard-page-header">
                        <div>
                            <h1>Build Your Resume</h1>
                            <p>
                                Craft a polished CV with guided sections, ATS-friendly
                                formatting, and reusable snippets.
                            </p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#." class="btn btn-outline-primary">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i> Preview current
                            </a>
                            <a href="#." class="btn btn-primary">
                                <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                                Start builder
                            </a>
                        </div>
                    </div>

                    <!-- Attached CV Section -->
                    <div class="dashboard-panel mt-4">
                        <div class="panel-header d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0">Attached CV</h3>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addCvModal">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table resume-table">
                                <thead>
                                    <tr>
                                        <th>CV Title</th>
                                        <th>Default CV</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#." class="text-primary">My Resume</a></td>
                                        <td><span class="badge bg-success">Default</span></td>
                                        <td>2025-03-09 06:19:47</td>
                                        <td>
                                            <div class="action-icons">
                                                <a href="#." class="text-primary" title="Download">
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>
                                                <a href="#." class="text-dark" title="Edit" data-bs-toggle="modal"
                                                    data-bs-target="#editCvModal">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="#." class="text-danger" title="Delete">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Projects Section -->
                    <div class="dashboard-panel mt-4">
                        <div class="panel-header d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0">Projects</h3>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addProjectModal">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="projects-grid">

                            <div class="project-card">
                                <div class="project-image">
                                    <img src="{{ asset('images/blog/1.jpg') }}" alt="Jobs Portal" />
                                </div>
                                <div class="project-content">
                                    <h4>Jobs Portal</h4>
                                    <p class="project-date">31 Jan, 2025 - 31 Jan, 2025</p>
                                    <p class="project-description">This is just for testing</p>
                                    <div class="project-actions">
                                        <a href="#." class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#editProjectModal">Edit</a>
                                        <a href="#." class="text-danger">Delete</a>
                                    </div>
                                </div>
                            </div>

                            <div class="project-card">
                                <div class="project-image">
                                    <img src="{{ asset('images/blog/2.jpg') }}" alt="Burger Point" />
                                </div>
                                <div class="project-content">
                                    <h4>Burger Point</h4>
                                    <p class="project-date">31 Jan, 2025 - 31 Jan, 2025</p>
                                    <p class="project-description">
                                        This is just for testing project
                                    </p>
                                    <div class="project-actions">
                                        <a href="#." class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#editProjectModal">Edit</a>
                                        <a href="#." class="text-danger">Delete</a>
                                    </div>
                                </div>
                            </div>

                            <div class="project-card">
                                <div class="project-image">
                                    <img src="{{ asset('images/blog/1.jpg') }}" alt="Frontend Develope" />
                                </div>
                                <div class="project-content">
                                    <h4>Frontend Develope</h4>
                                    <p class="project-date">01 Nov, 2025 - Currently ongoing</p>
                                    <p class="project-description">
                                        Frontend Developer with I bring innovation a...
                                    </p>
                                    <div class="project-actions">
                                        <a href="#." class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#editProjectModal">Edit</a>
                                        <a href="#." class="text-danger">Delete</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
