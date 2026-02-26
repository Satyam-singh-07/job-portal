@extends('layouts.app')
@section('title', 'Messages')
@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-layout">
                @include('candidates.partials.sidebar')
                <div class="dashboard-main">
                    <div class="dashboard-page-header">
                        <div>
                            <h1>Messages</h1>
                            <p>
                                Chat with recruiters and hiring managers directly from your
                                dashboard.
                            </p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#." class="btn btn-outline-primary"><i class="fa-solid fa-check-double"
                                    aria-hidden="true"></i>
                                Mark all read</a>
                            <a href="#." class="btn btn-primary"><i class="fa-solid fa-pen-to-square"
                                    aria-hidden="true"></i>
                                Compose</a>
                        </div>
                    </div>

                    <div class="message-module">
                        <div class="message-layout">
                            <div class="thread-list">
                                <div class="thread-item active" data-thread="alex">
                                    <strong>Alex Chen · Northwind</strong>
                                    <span>Offer review</span>
                                    <small>2m ago</small>
                                </div>
                                <div class="thread-item" data-thread="maya">
                                    <strong>Maya Singh · Bright Labs</strong>
                                    <span>Frontend Lead</span>
                                    <small>1h ago</small>
                                </div>
                                <div class="thread-item" data-thread="skyline">
                                    <strong>Skyline Digital Recruiting</strong>
                                    <span>Interview loop</span>
                                    <small>Yesterday</small>
                                </div>
                                <div class="thread-item" data-thread="atlas">
                                    <strong>Atlas Health People</strong>
                                    <span>Director of UX Research</span>
                                    <small>Mon</small>
                                </div>
                                <div class="thread-item" data-thread="concierge">
                                    <strong>JobsPortal Concierge</strong>
                                    <span>Account updates</span>
                                    <small>Last week</small>
                                </div>
                            </div>
                            <div class="chat-window">
                                <div class="chat-header">
                                    <div class="chat-meta">
                                        <h5 id="chatName">Alex Chen</h5>
                                        <small id="chatSubtitle">Northwind Commerce · Offer Review</small>
                                    </div>
                                    <span class="status-dot" id="chatStatus"><i class="fa-solid fa-circle"
                                            aria-hidden="true"></i>
                                        Active</span>
                                </div>
                                <div class="chat-body" id="chatBody">
                                    <p class="chat-empty">
                                        Select a thread to view the conversation.
                                    </p>
                                </div>
                                <form class="chat-composer" id="chatComposer">
                                    <input type="text" id="chatInput" placeholder="Type your reply…"
                                        autocomplete="off" />
                                    <button class="chat-send-btn" type="submit">
                                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



@section('scripts')

  <script>
      const messageThreads = {
        alex: {
          name: "Alex Chen",
          subtitle: "Northwind Commerce · Offer Review",
          status: "Active",
          messages: [
            {
              from: "them",
              text: "Alex: Hey Jordan! Attaching the updated offer summary with revised equity. Let me know if you’re free for a quick call later today.",
            },
            {
              from: "me",
              text: "Thanks Alex — reviewing now. I can hop on a call at 3pm PT, does that work?",
            },
            {
              from: "them",
              text: "Alex: 3pm PT works! Sending over the invite. Feel free to drop any questions here ahead of time.",
            },
          ],
        },
        maya: {
          name: "Maya Singh",
          subtitle: "Bright Labs · Frontend Lead",
          status: "Responding soon",
          messages: [
            {
              from: "them",
              text: "Maya: Appreciate your interest! Can you share an example of a complex design-to-code handoff you’ve led recently?",
            },
            {
              from: "me",
              text: "Absolutely. I’ll pull together a brief rundown from the MercuryPay redesign and send it over tonight.",
            },
            {
              from: "them",
              text: "Maya: Perfect. Also, feel free to drop any questions about our stack before Friday’s call.",
            },
          ],
        },
        skyline: {
          name: "Skyline Digital Recruiting",
          subtitle: "Interview Loop",
          status: "Scheduling",
          messages: [
            {
              from: "them",
              text: "Recruiting: Loop interview availability for next week? We’re hoping to book Tues/Wed slots.",
            },
            {
              from: "me",
              text: "Tuesday morning PT works best for me. Happy to flex if needed.",
            },
            {
              from: "them",
              text: "Recruiting: Great! Confirming panels now and will send calendar holds shortly.",
            },
          ],
        },
        atlas: {
          name: "Atlas Health People",
          subtitle: "Director of UX Research",
          status: "Awaiting feedback",
          messages: [
            {
              from: "them",
              text: "Atlas Hiring: Thanks for the thorough take-home. Team is reviewing and we’ll circle back early next week.",
            },
            {
              from: "me",
              text: "Sounds good— let me know if any clarifications or deep dives would help.",
            },
          ],
        },
        concierge: {
          name: "JobsPortal Concierge",
          subtitle: "Your talent partner",
          status: "Online",
          messages: [
            {
              from: "them",
              text: "Concierge: Reminder that your Pro plan renews Apr 30. Need help updating payment details?",
            },
            {
              from: "me",
              text: "All set for now, but I may upgrade to Elite if my loop converts. Will ping you.",
            },
            {
              from: "them",
              text: "Concierge: Love to hear it! Good luck with the interviews.",
            },
          ],
        },
      };

      document.addEventListener("DOMContentLoaded", function () {
        const threadItems = document.querySelectorAll(".thread-item");
        const chatName = document.getElementById("chatName");
        const chatSubtitle = document.getElementById("chatSubtitle");
        const chatStatus = document.getElementById("chatStatus");
        const chatBody = document.getElementById("chatBody");
        const chatComposer = document.getElementById("chatComposer");
        const chatInput = document.getElementById("chatInput");

        let activeThread =
          document.querySelector(".thread-item.active")?.dataset.thread ||
          "alex";

        function renderThread(threadId) {
          const thread = messageThreads[threadId];
          if (!thread) return;
          chatName.textContent = thread.name;
          chatSubtitle.textContent = thread.subtitle;
          chatStatus.innerHTML =
            '<i class="fa-solid fa-circle" aria-hidden="true"></i> ' +
            thread.status;
          chatBody.innerHTML = "";
          thread.messages.forEach((msg) => {
            const bubble = document.createElement("div");
            bubble.className = "chat-bubble" + (msg.from === "me" ? " me" : "");
            bubble.textContent = msg.text;
            chatBody.appendChild(bubble);
          });
          chatBody.scrollTop = chatBody.scrollHeight;
        }

        threadItems.forEach((item) => {
          item.addEventListener("click", () => {
            const id = item.dataset.thread;
            if (!id || id === activeThread) return;
            threadItems.forEach((el) => el.classList.remove("active"));
            item.classList.add("active");
            activeThread = id;
            renderThread(id);
          });
        });

        chatComposer.addEventListener("submit", function (e) {
          e.preventDefault();
          const value = chatInput.value.trim();
          if (!value) return;
          messageThreads[activeThread].messages.push({
            from: "me",
            text: value,
          });
          chatInput.value = "";
          renderThread(activeThread);
        });

        renderThread(activeThread);
      });
    </script>

    @endsection