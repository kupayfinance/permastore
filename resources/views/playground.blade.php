<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Blockchain Playground</title>
	<meta name="description" content="Blockchain Playground">
	<link rel="stylesheet" href="{{ url('js/react/bundle.min.css')}}">
</head>
<body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    
    <div id="root">Loading...</div>
    
    <script>
        window.PlaygroundConfig = {
            api_root: '{{ url('api/v1/messages/') }}',
            headers: {
                '{{ config('api_keys.header') }}' : '{{ $apiKey->key }}'
            },
            api_key_id : '{{$apiKey->id}}'
        }
    </script>
    @include('includes.react.scripts')
</body>

</html>