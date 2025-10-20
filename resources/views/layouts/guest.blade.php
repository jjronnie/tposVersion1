@extends('layouts.main')
@section('content')
    <main class="flex-grow">
        {{ $slot }}



    </main> 

    @guest
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <div id="g_id_onload"
        data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
        data-context="signin"
        data-ux_mode="popup"
        data-login_uri="{{ route('google.one-tap.handler') }}"
        data-auto_select="false" 
        data-skip_prompt_cookie="g_skip_prompt"
        data-callback="handleOneTapResponse">
    </div>

    <script>
        function handleOneTapResponse(response) {
            // Google posts the token to your data-login_uri, which is handled by your Laravel controller.
            // However, since we want to handle the JSON response for redirecting, we can use a custom callback.
            // **For simplicity and to use the POST route:**
            // The HTML configuration with `data-login_uri` handles the POST request to Laravel.
            // You only need this function if you want a pure AJAX implementation (not necessary here).
            
            // Assuming your Laravel route returns a JSON response:
            fetch("{{ route('google.one-tap.handler') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: "credential=" + response.credential
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    console.error('One Tap Login Failed:', data.error);
                    // You might want to display a standard sign-in button as a fallback
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // NOTE: To use the custom JS callback, you must change data-login_uri to data-callback="handleOneTapResponse" 
        // and remove data-login_uri from the div, and ensure the script is executed after the library loads.
        // The previous approach using `data-login_uri` is simpler: Google posts the credential, Laravel logs the user in, and the browser handles the redirect automatically.
    </script>
@endguest

@endsection

