@if(Session::has('success'))
    <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(Session::has('error'))
    <div id="flash-message" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(Session::has('warning'))
    <div id="flash-message" class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ Session::get('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<script>
    setTimeout(function() {
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.transition = "opacity 0.5s ease";
            flashMessage.style.opacity = "0";
            setTimeout(function() {
                flashMessage.remove();
            }, 500); // Wait for the transition to finish before removing
        }
    }, 3000); // 3000ms = 5 seconds
</script>


<!-- for ajax -->
<div id="ajax-flash-message" class="alert alert-dismissible fade d-none" role="alert">
    <span></span>
</div>

<script>
    function showFlashMessage(status, message) {
        const flashMessage = document.getElementById('ajax-flash-message');
        if(flashMessage){
            const messageSpan = flashMessage.querySelector('span');
    
            messageSpan.textContent = message;
    
            flashMessage.classList.remove('alert-success', 'alert-danger');
    
            if (status === 'success') {
                flashMessage.classList.add('alert-success');
            } else if (status === 'error') {
                flashMessage.classList.add('alert-danger');
            }
    
            flashMessage.classList.remove('d-none');
    
            flashMessage.classList.add('show');
    
            setTimeout(() => {
                flashMessage.classList.remove('show');
                flashMessage.classList.add('d-none');
            }, 3000)
        }
    }
</script>