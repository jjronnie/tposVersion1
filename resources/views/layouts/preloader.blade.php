   <!-- Preloader Overlay -->
    <div id="refreshPreloader" class="fixed inset-0 bg-white bg-opacity-95 flex items-center justify-center z-50 hidden">
        <div class="text-center">
            <!-- Spinner -->
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <!-- Loading Text -->
            <p class="text-gray-600 text-sm font-medium">Loading...</p>
        </div>
    </div>



    <script>
        // Show preloader immediately when page starts refreshing
        window.addEventListener('beforeunload', function() {
            document.getElementById('refreshPreloader').classList.remove('hidden');
        });

   
    
    </script>