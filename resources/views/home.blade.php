@extends('layouts.app')

@section('header_title', 'Home')

@section('content')
    <main class="flex-1 overflow-auto p-6 bg-[#F7F8FA]">
        @foreach ($posts as $post)
            <article
                class="bg-white rounded-lg p-6 shadow max-w-4xl mx-auto mb-6"
                aria-label="Post by {{ $post->user->name }}"
            >
                <h4 class="font-semibold text-[#3E3E3E] text-lg mb-2">{{ $post->title }}</h4>
                
                @if (!$post->savedByUsers->contains(auth()->id()))
                    <button onclick="showSaveModal({{ $post->id }})"
                        class="inline-flex items-center gap-2 border border-[#958433] text-[#958433] text-sm font-semibold px-3 py-1.5 rounded hover:bg-[#958433] hover:text-white transition mb-4">
                        <i class="far fa-bookmark"></i> Save to Library
                    </button>
                @else
                    <form action="{{ route('library.unsave', $post) }}" method="POST" class="mb-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="inline-flex items-center gap-2 bg-[#958433] text-white text-sm font-semibold px-3 py-1.5 rounded hover:bg-[#7a6a29] transition">
                            <i class="fas fa-bookmark"></i> Saved to Library
                        </button>
                    </form>
                @endif

                <p class="text-[#7D7D7D] text-sm mb-3">
                    {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                    @if ($post->location)
                        • {{ $post->location }}
                    @endif
                    @if ($post->cp)
                        • {{ $post->cp }}
                    @endif
                </p>

                <p class="text-[#3E3E3E] text-base mb-4">{{ $post->body }}</p>

                @if ($post->image_path)
                    <img
                        src="{{ asset('storage/' . $post->image_path) }}"
                        alt="Post image"
                        class="rounded-lg max-h-[400px] w-full object-cover"
                    />
                @endif

                @if ($post->user_id === auth()->id())
                    <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                        <a href="/edit-post/{{ $post->id }}"
                            class="text-[#958433] hover:text-[#7a6a29] transition-colors p-1.5 rounded-full hover:bg-gray-50"
                            title="Edit Post">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="/delete-post/{{ $post->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-500 hover:text-red-700 transition-colors p-1.5 rounded-full hover:bg-gray-50"
                                title="Delete Post"
                                onclick="return confirm('Are you sure you want to delete this post?')">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </article>
        @endforeach

        @if ($posts->isEmpty())
            <div class="col-span-full bg-white rounded-lg shadow-sm p-6 text-center border border-gray-100">
                <div class="w-12 h-12 bg-[#958433]/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-newspaper text-xl text-[#958433]"></i>
                </div>
                <h3 class="text-lg font-semibold text-[#3E3E3E] mb-1">No Posts Yet</h3>
                <p class="text-sm text-[#7D7D7D]">Be the first one to share something!</p>
            </div>
        @endif
    </main>

    <!-- Save Modal -->
    <div id="saveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-96">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Save to Library</h2>
                <button onclick="closeSaveModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="saveForm" class="space-y-4">
                <div id="categorySelectContainer" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Category</label>
                    <select name="category_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Select a category</option>
                    </select>
                </div>
                <div id="newCategoryContainer">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Create New Category</label>
                    <input type="text" name="new_category" class="w-full border rounded-lg px-3 py-2"
                        placeholder="Enter category name">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeSaveModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit" id="saveButton"
                        class="px-4 py-2 bg-[#958433] text-white rounded-lg hover:bg-[#7a6a29] disabled:opacity-50 disabled:cursor-not-allowed">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-0 text-sm"
            id="notification">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('notification').style.transform = 'translateY(100%)';
            }, 3000);
        </script>
    @endif

    @push('scripts')
        <script>
            let currentPostId = null;
            let isSubmitting = false;

            function showSaveModal(postId) {
                currentPostId = postId;
                document.getElementById('saveModal').classList.remove('hidden');
                loadCategories();
            }

            function closeSaveModal() {
                document.getElementById('saveModal').classList.add('hidden');
                document.getElementById('saveForm').reset();
                currentPostId = null;
                isSubmitting = false;
                document.getElementById('saveButton').disabled = false;
            }

            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-0 text-sm ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.transform = 'translateY(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            async function loadCategories() {
                try {
                    const response = await fetch('/api/categories', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load categories');
                    }

                    const result = await response.json();
                    const categories = result.data || [];
                    const selectContainer = document.getElementById('categorySelectContainer');
                    const newCategoryContainer = document.getElementById('newCategoryContainer');
                    const select = document.querySelector('select[name="category_id"]');
                    
                    if (categories && categories.length > 0) {
                        selectContainer.classList.remove('hidden');
                        newCategoryContainer.classList.add('hidden');
                        
                        select.innerHTML = '<option value="">Select a category</option>' +
                            categories.map(category => 
                                `<option value="${category.id}">${category.name}</option>`
                            ).join('');
                    } else {
                        selectContainer.classList.add('hidden');
                        newCategoryContainer.classList.remove('hidden');
                        select.value = '';
                    }
                } catch (error) {
                    console.error('Error loading categories:', error);
                    showNotification('Error loading categories. Please try again.', 'error');
                    closeSaveModal();
                }
            }

            document.getElementById('saveForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                if (isSubmitting) return;
                isSubmitting = true;
                document.getElementById('saveButton').disabled = true;

                try {
                    const form = e.target;
                    const categoryId = form.querySelector('select[name="category_id"]').value;
                    const newCategory = form.querySelector('input[name="new_category"]').value;

                    let category_id = categoryId;
                    if (!categoryId && newCategory) {
                        // Create new category first
                        const categoryResponse = await fetch('/api/categories', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                name: newCategory
                            })
                        });

                        if (!categoryResponse.ok) {
                            throw new Error('Failed to create category');
                        }

                        const categoryResult = await categoryResponse.json();
                        category_id = categoryResult.data.id;
                    }

                    if (!category_id) {
                        throw new Error('Please select or create a category');
                    }

                    // Save post to library
                    const response = await fetch(`/library/${currentPostId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            category_id
                        })
                    });

                    if (!response.ok) {
                        const error = await response.json();
                        throw new Error(error.message || 'Failed to save post');
                    }

                    showNotification('Post saved successfully');
                    closeSaveModal();
                    window.location.reload();
                } catch (error) {
                    console.error('Error saving post:', error);
                    showNotification(error.message || 'Failed to save post', 'error');
                    document.getElementById('saveButton').disabled = false;
                    isSubmitting = false;
                }
            });
        </script>
    @endpush
@endsection
