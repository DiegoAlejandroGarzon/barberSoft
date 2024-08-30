<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>DevBridge Autocomplete Demo</title>
    <link href="{{asset('/assets/js/autocomplete/devbridge/content/styles.css')}}" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h1>Ajax Autocomplete Demo</h1>

        <h2>Ajax Lookup</h2>
        <p>Type country name in english:</p>
        <div style="position: relative; height: 80px;">
            <input type="text" name="country" id="autocomplete-ajax" style="position: absolute; z-index: 2; background: transparent;"/>
            <input type="text" name="country" id="autocomplete-ajax-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1;"/>
        </div>
        <div id="selction-ajax"></div>


    </div>
    

    <script type="text/javascript" src="{{asset('/assets/js/autocomplete/devbridge/scripts/jquery-1.8.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/js/autocomplete/devbridge/scripts/jquery.mockjax.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/js/autocomplete/devbridge/src/jquery.autocomplete.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/js/autocomplete/devbridge/scripts/demo.js')}}"></script>
  
</body>
</html>