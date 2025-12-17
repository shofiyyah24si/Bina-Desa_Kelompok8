{{-- resources/views/components/profile-dropdown.blade.php --}}

@php
    $user = Auth::user();
    $avatarUrl = $user->avatar 
        ? asset('storage/avatars/' . $user->avatar)
        : asset('images/default-avatar.png');
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
    <!-- Avatar Button -->
    <button @click="open = !open" 
            class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <img class="h-8 w-8 rounded-full border-2 border-white shadow-sm" 
             src="{{ $avatarUrl }}" 
             alt="{{ $user->name }}">
        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50"
         style="display: none;">
        
        <!-- User Info -->
        <div class="px-4 py-3">
            <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
        </div>

        <!-- Profile Actions -->
        <div class="py-1">
            <a href="{{ route('profile.index') }}" 
               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Data Profil
            </a>
            
            <button type="button" 
                    @click="open = false"
                    data-modal-toggle="changeAvatarModal"
                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Ganti Foto Profil
            </button>
        </div>

        <!-- Avatar Management -->
        <div class="py-1">
            <button type="button" 
                    onclick="confirmDeleteAvatar()"
                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                <svg class="mr-3 h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus Foto Profil
            </button>
        </div>

        <!-- Logout -->
        <div class="py-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Changing Avatar -->
<div id="changeAvatarModal" tabindex="-1" aria-hidden="true" 
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Ganti Foto Profil
                </h3>
                <button type="button" 
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="changeAvatarModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <img id="avatarPreview" 
                             src="{{ $avatarUrl }}" 
                             alt="Preview Avatar"
                             class="h-32 w-32 rounded-full border-4 border-white shadow-lg">
                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white text-sm">Preview</span>
                        </div>
                    </div>
                </div>
                
                <form id="avatarForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900" for="avatarInput">
                            Pilih foto baru
                        </label>
                        <input type="file" 
                               id="avatarInput" 
                               name="avatar"
                               accept="image/jpeg,image/png,image/gif,image/webp"
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500">
                            PNG, JPG, GIF, WEBP (Maks. 2MB)
                        </p>
                    </div>
                </form>
                
                <div id="uploadProgress" class="hidden">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <p id="progressText" class="text-xs text-gray-500 mt-1">Mengupload...</p>
                </div>
                
                <div id="uploadMessage" class="hidden"></div>
            </div>
            
            <!-- Modal footer -->
            <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                <button type="button" 
                        data-modal-toggle="changeAvatarModal"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">
                    Batal
                </button>
                <button type="button" 
                        onclick="uploadAvatar()"
                        id="uploadButton"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Upload
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteAvatarModal" tabindex="-1" aria-hidden="true" 
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Apakah Anda yakin ingin menghapus foto profil?
                </h3>
                <div class="flex justify-center space-x-4">
                    <button type="button" 
                            data-modal-toggle="deleteAvatarModal"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">
                        Batal
                    </button>
                    <button type="button" 
                            onclick="deleteAvatar()"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Alpine.js for dropdown -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
// Preview avatar before upload
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Show delete confirmation modal
function confirmDeleteAvatar() {
    const modal = document.getElementById('deleteAvatarModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Delete avatar function
function deleteAvatar() {
    fetch('{{ route("profile.avatar.delete") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update avatar image
            document.querySelectorAll('.profile-avatar').forEach(img => {
                img.src = data.avatar_url;
            });
            
            // Close modal
            const modal = document.getElementById('deleteAvatarModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // Close dropdown
            const dropdown = document.querySelector('[x-data]');
            if (dropdown && dropdown.__x) {
                dropdown.__x.$data.open = false;
            }
            
            // Show success message
            showNotification('Foto profil berhasil dihapus!', 'success');
        }
    })
    .catch(error => {
        showNotification('Terjadi kesalahan saat menghapus foto', 'error');
    });
}

// Upload avatar function
function uploadAvatar() {
    const fileInput = document.getElementById('avatarInput');
    const formData = new FormData();
    
    if (!fileInput.files[0]) {
        showNotification('Silakan pilih foto terlebih dahulu', 'warning');
        return;
    }
    
    formData.append('avatar', fileInput.files[0]);
    formData.append('_token', '{{ csrf_token() }}');
    
    // Show progress
    const progressDiv = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const uploadButton = document.getElementById('uploadButton');
    
    progressDiv.classList.remove('hidden');
    uploadButton.disabled = true;
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("profile.avatar.update") }}');
    
    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            progressBar.style.width = percentComplete + '%';
            progressText.textContent = `Mengupload... ${Math.round(percentComplete)}%`;
        }
    });
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Update all avatar images
                document.querySelectorAll('.profile-avatar').forEach(img => {
                    img.src = response.avatar_url + '?t=' + new Date().getTime();
                });
                
                // Close modal
                const modal = document.getElementById('changeAvatarModal');
                modal.classList.add('hidden');
                
                // Close dropdown
                const dropdown = document.querySelector('[x-data]');
                if (dropdown && dropdown.__x) {
                    dropdown.__x.$data.open = false;
                }
                
                showNotification(response.message, 'success');
            }
        } else {
            showNotification('Upload gagal. Silakan coba lagi.', 'error');
        }
        
        progressDiv.classList.add('hidden');
        uploadButton.disabled = false;
    };
    
    xhr.onerror = function() {
        showNotification('Terjadi kesalahan jaringan', 'error');
        progressDiv.classList.add('hidden');
        uploadButton.disabled = false;
    };
    
    xhr.send(formData);
}

// Notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg shadow-lg text-white ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Modal toggle functions
document.querySelectorAll('[data-modal-toggle]').forEach(button => {
    button.addEventListener('click', function() {
        const target = this.getAttribute('data-modal-toggle');
        const modal = document.getElementById(target);
        if (modal) {
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    });
});

// Close modal when clicking outside
document.querySelectorAll('.fixed').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            this.classList.remove('flex');
        }
    });
});
</script>

<style>
/* Custom styles for better appearance */
.hidden {
    display: none !important;
}

.flex {
    display: flex !important;
}

.fixed {
    position: fixed;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.ring-1 {
    --tw-ring-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.shadow-lg {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>