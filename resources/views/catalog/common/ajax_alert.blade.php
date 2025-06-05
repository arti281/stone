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