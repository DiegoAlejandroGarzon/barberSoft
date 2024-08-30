@extends('../themes/' . $activeTheme . '/' . $activeLayout)
@section('head')
    <title>Ciudades</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css">
@endsection
@section('content')
    <div class="content">
        <div class="card">

            <div class="card-body text-center">
            <h1>{{_('Auto Complete search')}}</h1>

            <h4>{{_('type a county name')}}</h4>
            <input type="text" id="autoComplete"></input>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
<script>
    const autoCompleteJS = new autoComplete({
    selector: "#autoComplete",
    placeHolder: "Search for city...",
    data: {
    src: async (query) => {
      try {
        // Fetch Data from external Source
        const source = await fetch('{{URL("auth-complete-search/search")}}/${query}');
        // Data should be an array of `Objects` or `Strings`
        const data = await source.json();

        return data;
      } catch (error) {
        return error;
      }
    },
    // Data source 'Object' key to be searched
    keys: ["name"]
},
    resultsList: {
        element: (list, data) => {
            if (!data.results.length) {
                // Create "No Results" message element
                const message = document.createElement("div");
                // Add class to the created element
                message.setAttribute("class", "no_result");
                // Add message text content
                message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                // Append message element to the results list
                list.prepend(message);
            }
        },
        noResults: true,
    },
    resultItem: {
        highlight: true,
    }
 });
</script>
@endsection