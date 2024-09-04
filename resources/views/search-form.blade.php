<!DOCTYPE html>
<html>

<head>
<title>Laravel 11 jQuery UI AJAX Autocomplete Search Example - Tutsmake.com</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery UI CSS -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    var siteUrl = "{{url('/')}}";
</script>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            <h2>Laravel 11 jQuery UI AJAX Autocomplete Search Example - Tutsmake.com</h2>
        </div>
        <div class="card-body">
            <form name="autocomplete-textbox" id="autocomplete-textbox" method="post" action="#">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Search Task</label>
                    <input type="text" id="name" name="name" class="form-control">
                </div>
            </form>
        </div>
    </div>   

</div>
<script type="text/javascript">
    
     $(document).ready(function() {
        
    $( "#name" ).autocomplete({
            source: function(request, response) {
            $.ajax({
            url: siteUrl + '/' +"search-Autocomplete",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){
                    return obj.name;
               });
               response(resp);
            }
        });
    },
    minLength: 2
 });
});

</script>
<body>
</html}