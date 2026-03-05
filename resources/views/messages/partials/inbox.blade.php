<div class="row g-3">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><strong>Threads</strong></div>
            <div class="list-group list-group-flush">
                @forelse($conversations as $conversation)
                    @php
                        $isCandidate = auth()->user()->isCandidate();
                        $other = $isCandidate ? $conversation->employer : $conversation->candidate;
                        $otherName = trim(($other?->first_name ?? '').' '.($other?->last_name ?? ''));
                        if ($otherName === '') {
                            $otherName = $other?->company_name ?: 'User';
                        }
                        $isActive = $selectedConversation && $selectedConversation->id === $conversation->id;
                    @endphp

                    <a href="{{ route($routeName, ['conversation' => $conversation->id]) }}"
                       class="list-group-item list-group-item-action {{ $isActive ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold">{{ $otherName }}</div>
                                <small class="{{ $isActive ? 'text-white-50' : 'text-muted' }}">
                                    {{ $conversation->job?->title ?: ($conversation->subject ?: 'General conversation') }}
                                </small>
                            </div>
                            @if(($conversation->unread_count ?? 0) > 0)
                                <span class="badge bg-danger">{{ $conversation->unread_count }}</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="list-group-item text-muted">No conversations yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card h-100">
            @if($selectedConversation)
                @php
                    $isCandidate = auth()->user()->isCandidate();
                    $other = $isCandidate ? $selectedConversation->employer : $selectedConversation->candidate;
                    $otherName = trim(($other?->first_name ?? '').' '.($other?->last_name ?? ''));
                    if ($otherName === '') {
                        $otherName = $other?->company_name ?: 'User';
                    }
                @endphp

                <div class="card-header">
                    <strong>{{ $otherName }}</strong>
                    <div class="small text-muted">{{ $selectedConversation->job?->title ?: ($selectedConversation->subject ?: 'General conversation') }}</div>
                </div>

                <div class="card-body" style="max-height: 420px; overflow-y: auto;">
                    @forelse($messages as $message)
                        @php $mine = (int) $message->sender_user_id === (int) auth()->id(); @endphp
                        <div class="mb-3 d-flex {{ $mine ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="p-2 rounded {{ $mine ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 85%;">
                                <div>{{ $message->body }}</div>
                                <div class="small {{ $mine ? 'text-white-50' : 'text-muted' }}">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No messages yet.</p>
                    @endforelse
                </div>

                <div class="card-footer">
                    <form method="POST" action="{{ route(auth()->user()->isEmployer() ? 'employer.messages.send' : 'candidate.messages.send', $selectedConversation->id) }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="body" class="form-control" placeholder="Type your message..." required maxlength="3000">
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="card-body text-muted d-flex align-items-center justify-content-center">
                    No conversation selected yet.
                </div>
            @endif
        </div>
    </div>
</div>
