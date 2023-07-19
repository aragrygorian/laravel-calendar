@if (session()->has('success'))
<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session()->get('success') }}
</div>
@endif
@if (session()->has('error'))
<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
  {{ session()->get('success') }}

</div>
@endif

<script>
  setTimeout(function(){
    let successAlert = document.getElementById('successAlert');
    if(successAlert){
      successAlert.remove();
    }
  },3000)

  setTimeout(function(){
    let errorAlert = document.getElementById('errorAlert');
    if(errorAlert){
      errorAlert.remove();
    }
  },3000)
</script>