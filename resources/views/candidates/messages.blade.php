@extends('layouts.app')

@section('title', 'My Messages')

@section('content')
<section class="dashboard-section">
    <div class="container">
        <div class="dashboard-layout">
            @include('candidates.partials.sidebar')

            <div class="dashboard-main">
                <div class="dashboard-page-header">
                    <div>
                        <h1>My Messages</h1>
                        <p>Chat with employers in real-time about your applications.</p>
                    </div>
                </div>

                @include('messages.partials.inbox', ['routeName' => $routeName])
            </div>
        </div>
    </div>
</section>
@endsection
