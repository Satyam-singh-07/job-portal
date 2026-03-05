@extends('layouts.app')

@section('title', 'Company Messages')

@section('content')
<section class="dashboard-section employer-dashboard">
    <div class="container mt-4">
        <div class="dashboard-layout">
            @include('employers.partials.sidebar')

            <div class="dashboard-main">
                <div class="dashboard-page-header">
                    <div>
                        <h1>Company Messages</h1>
                        <p>Communicate with candidates about jobs and applications.</p>
                    </div>
                </div>

                @include('messages.partials.inbox', ['routeName' => $routeName])
            </div>
        </div>
    </div>
</section>
@endsection
