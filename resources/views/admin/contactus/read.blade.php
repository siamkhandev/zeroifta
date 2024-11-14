@extends('layouts.new_main')
@section('content')

<!-- New Form Design Start -->
<div class="contactform-read">
  <div class="sec1-style">
    <!-- Chat Form Header -->
    <div class="form-readInn">
      <div class="user-form">
        <div>
          <img class="uh-img" src="http://zeroifta.test/images/1717919272.png" alt="">
        </div>
        <div>
          <div>
            <h3 class="uh-head head-20">{{ $form->subject }}</h3>
          </div>
          <!-- <div class="uh-spans">
            <span>Online </span>
            <span>- </span>
            <span>Last seen, </span>
            <span>2.02pm</span>
          </div> -->
        </div>
      </div>
    </div>

    <!-- Chat Area -->
    <div class="fchat-inn">
      <!--------------------------------------------------------- 
      User Chat 
      --------------------------------------------------->
      <!-- Chat Tb 1 -->
      <div class="userchat-tab">
        <div class="user-span mb-3">
          <span>{{ $form->description }}</span>
        </div>
        <!-- Chat Tb 1 -->
      
      </div>
      <!--------------------------------------------------------- 
      Admin Reply Chat 
      --------------------------------------------------->
      <div class="admin-rply" id="messages"> 
       
        <!-- Chat Tb 1 -->
        
      </div>
    </div>

    <!-- Chat Input -->
    <div class="formChat-input mt-5">
      <textarea id="message" class="form-control" placeholder="Type your message here" rows="2"></textarea>
      <span class="sendChat-icon">
      <a class="btn btn-primary mt-2" onclick="sendMessage()"> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
          <path d="M3.58594 20V4L22.5859 12L3.58594 20ZM5.58594 17L17.4359 12L5.58594 7V10.5L11.5859 12L5.58594 13.5V17Z" fill="#5F6368" />
        </svg>
        </a>
      </span>
    </div>

  </div>
</div>
<!-- New Form Design End -->






<script>
   window.onload = function() {
    fetchMessages();
}

async function sendMessage() {
    const message = document.getElementById('message').value;

    try {
        const response = await fetch('{{ route('messages.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                contact_id: '{{ $form->id }}',
                message: message,
                sender: '{{ auth()->user()->name }}'
            })
        });

        const data = await response.json();

        if (response.ok) {
            document.getElementById('message').value = '';
            fetchMessages();
        } else {
            console.error('Error sending message:', data);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function fetchMessages() {
    try {
        const response = await fetch(`/messages/{{ $form->id }}`);
        const data = await response.json();

        let messagesHtml = '';
        data.forEach(function(message) {
            const isReadClass = message.is_read ? 'text-muted' : 'text-black';
            const senderClass = message.sender === '{{ auth()->user()->name }}' ? 'text-end' : 'text-start';
            const bubbleClass = message.sender === '{{ auth()->user()->name }}' ? 'bg-primary text-white' : 'bg-light';
            messagesHtml += `
                <div class="admin-span mb-3 ${senderClass}">
                    <div class="p-2 rounded ${bubbleClass}">
                        <strong>${message.sender}:</strong> ${message.message}
                        <small class="d-block text-end ${isReadClass}">${new Date(message.created_at).toLocaleString()}</small>
                    </div>
                </div>`;
        });

        document.getElementById('messages').innerHTML = messagesHtml;
    } catch (error) {
        console.error('Error fetching messages:', error);
    }
}
    
</script>


@endsection