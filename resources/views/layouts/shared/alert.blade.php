
    @if(!is_null(session('msg')))
    
    @php
      $message=session('msg');
      $myalert=session('alert');
    @endphp
   <div class="alert-msg text-center text-dark mt-lg-0 py-1 py-lg-0">
      <div class="alert alert-{{ session('alert') }} alert-dismissible fade show mt-lg-3  mt-5" role="alert">
        <?= session('msg') ?>
      </div>
    </div>

   
    @php
      session()->forget('msg');
      session()->forget('alert');
      @endphp

  <script>
    window.addEventListener('load', function() {
        setTimeout(() => {
          document.querySelector('.alert-msg').innerHTML = "";
          document.querySelector('.alert-msg').classList.remove("py-4");
        }, 5000);
    })
    
    
  </script>
   
  @endif 
  
  