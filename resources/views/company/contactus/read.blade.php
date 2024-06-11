@extends('layouts.main')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if(Session::has('success'))
                <div class="alert alert-success" style="color:white">{{ Session::get('success') }}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" style="color:white">{{ Session::get('error') }}</div>
            @endif
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $form->company->name }} Contact Form</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $form->subject }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $form->description }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Chat Section -->
                    <div id="messages" class="p-3" style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; margin-top: 20px;">
                        <!-- Messages will be loaded here via AJAX -->
                    </div>

                    <div class="mt-3">
                        <textarea id="message" class="form-control" placeholder="Type your message here"></textarea>
                        <button class="btn btn-primary mt-2" onclick="sendMessage()">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchMessages();

        function fetchMessages() {
            fetch(`/messages/{{ $form->id }}`)
                .then(response => response.json())
                .then(data => {
                    let messagesHtml = '';
                    data.forEach(function(message) {
                        messagesHtml += `<p><strong>${message.sender}:</strong> ${message.message}</p>`;
                    });
                    document.getElementById('messages').innerHTML = messagesHtml;
                });
        }

        window.sendMessage = function() {
            const message = document.getElementById('message').value;
            fetch('{{ route('messages.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    contact_id: '{{ $form->id }}',
                    message: message,
                    sender:'{{auth()->user()->name}}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').value = '';
                    fetchMessages();
                }
            });
        }
    });
</script>
@endsection
