<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Job;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function candidateIndex(Request $request): View
    {
        $user = $request->user();
        abort_unless($user && $user->isCandidate(), 403);

        return $this->renderInbox($user, 'candidate.messages', 'candidates.messages');
    }

    public function employerIndex(Request $request): View
    {
        $user = $request->user();
        abort_unless($user && $user->isEmployer(), 403);

        return $this->renderInbox($user, 'employer.messages', 'employer.messages');
    }

    public function send(Request $request, Conversation $conversation): RedirectResponse
    {
        $user = $request->user();
        $this->authorizeParticipant($conversation, (int) $user->id);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:3000'],
        ]);

        $message = trim($validated['body']);
        if ($message === '') {
            return back()->with('error', 'Message cannot be empty.');
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_user_id' => $user->id,
            'body' => $message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        $routeName = $user->isEmployer() ? 'employer.messages' : 'candidate.messages';

        return redirect()
            ->route($routeName, ['conversation' => $conversation->id])
            ->with('success', 'Message sent successfully.');
    }

    public function contactEmployer(Request $request, Job $job): JsonResponse
    {
        $user = $request->user();
        if (! $user || ! $user->isCandidate()) {
            return response()->json([
                'success' => false,
                'message' => 'Only candidates can send messages.',
            ], 403);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:3000'],
        ]);

        if ($job->status !== 'Published') {
            return response()->json([
                'success' => false,
                'message' => 'This job is not available for messaging.',
            ], 404);
        }

        $conversation = Conversation::firstOrCreate(
            [
                'candidate_user_id' => $user->id,
                'employer_user_id' => $job->user_id,
                'job_id' => $job->id,
            ],
            [
                'subject' => 'Regarding: '.$job->title,
                'last_message_at' => now(),
            ]
        );

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_user_id' => $user->id,
            'body' => trim($validated['message']),
        ]);

        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent to employer.',
            'redirect' => route('candidate.messages', ['conversation' => $conversation->id]),
        ]);
    }

    public function startWithCandidate(Request $request, User $candidate): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user && $user->isEmployer(), 403);

        if (! $candidate->isCandidate()) {
            abort(404);
        }

        $validated = $request->validate([
            'body' => ['nullable', 'string', 'max:3000'],
        ]);

        $conversation = Conversation::firstOrCreate(
            [
                'candidate_user_id' => $candidate->id,
                'employer_user_id' => $user->id,
                'job_id' => null,
            ],
            [
                'subject' => 'Candidate outreach',
                'last_message_at' => now(),
            ]
        );

        $messageBody = trim((string) ($validated['body'] ?? ''));
        if ($messageBody !== '') {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_user_id' => $user->id,
                'body' => $messageBody,
            ]);

            $conversation->update(['last_message_at' => now()]);
        }

        return redirect()
            ->route('employer.messages', ['conversation' => $conversation->id])
            ->with('success', $messageBody !== '' ? 'Message sent to candidate.' : 'Conversation opened successfully.');
    }

    protected function renderInbox(User $user, string $routeName, string $view): View
    {
        $query = Conversation::query()
            ->with(['candidate:id,first_name,last_name,company_name', 'employer:id,first_name,last_name,company_name,username', 'job:id,title,slug', 'latestMessage.sender:id,first_name,last_name,company_name'])
            ->withCount([
                'messages as unread_count' => function ($q) use ($user) {
                    $q->whereNull('read_at')->where('sender_user_id', '!=', $user->id);
                },
            ])
            ->orderByDesc('last_message_at')
            ->orderByDesc('id');

        if ($user->isCandidate()) {
            $query->where('candidate_user_id', $user->id);
        } else {
            $query->where('employer_user_id', $user->id);
        }

        $conversations = $query->get();

        $selectedId = (int) request('conversation', $conversations->first()->id ?? 0);
        $selectedConversation = $conversations->firstWhere('id', $selectedId) ?: $conversations->first();

        $messages = collect();
        if ($selectedConversation) {
            $this->authorizeParticipant($selectedConversation, $user->id);

            $messages = $selectedConversation->messages()
                ->with('sender:id,first_name,last_name,company_name')
                ->oldest()
                ->get();

            $selectedConversation->messages()
                ->whereNull('read_at')
                ->where('sender_user_id', '!=', $user->id)
                ->update(['read_at' => now()]);
        }

        return view($view, [
            'routeName' => $routeName,
            'conversations' => $conversations,
            'selectedConversation' => $selectedConversation,
            'messages' => $messages,
        ]);
    }

    protected function authorizeParticipant(Conversation $conversation, int $userId): void
    {
        if ((int) $conversation->candidate_user_id !== $userId && (int) $conversation->employer_user_id !== $userId) {
            abort(403);
        }
    }
}
