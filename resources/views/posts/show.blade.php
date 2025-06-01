@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <article class="bg-white rounded-lg p-6 shadow">
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-2xl font-bold">{{ $post->title }}</h1>
                <div class="flex items-center gap-2">
                    <button id="bookmarkBtn" class="text-gray-600 hover:text-blue-500">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
            </div>

            <!-- Bookmark Modal -->
            <div id="bookmarkModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg w-96">
                    <h2 class="text-xl font-bold mb-4">Save to Collection</h2>
                    <div id="categoriesList" class="mb-4">
                        <!-- Categories will be loaded here -->
                    </div>
                    <div class="mb-4">
                        <button id="createNewCategoryBtn" class="text-blue-500 hover:text-blue-700">
                            + Create New Category
                        </button>
                    </div>
                    <!-- Create Category Form -->
                    <div id="createCategoryForm" class="hidden">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="categoryName">
                                Category Name
                            </label>
                            <input type="text" id="categoryName" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="cancelCreateCategory" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Cancel</button>
                            <button type="button" id="submitCreateCategory" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Create</button>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button id="closeBookmarkModal" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Close</button>
                    </div>
                </div>
            </div>

            <p class="text-gray-600 mb-4">
                {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }} • {{ $post->location }} • {{ $post->cp }}
            </p>
            <p class="text-gray-800 mb-6">{{ $post->body }}</p>
            @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="rounded-lg max-h-[400px] w-full object-cover mb-6">
            @endif
        </article>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookmarkBtn = document.getElementById('bookmarkBtn');
    const bookmarkModal = document.getElementById('bookmarkModal');
    const closeBookmarkModal = document.getElementById('closeBookmarkModal');
    const createNewCategoryBtn = document.getElementById('createNewCategoryBtn');
    const createCategoryForm = document.getElementById('createCategoryForm');
    const cancelCreateCategory = document.getElementById('cancelCreateCategory');
    const submitCreateCategory = document.getElementById('submitCreateCategory');
    const categoriesList = document.getElementById('categoriesList');

    // Show bookmark modal
    bookmarkBtn.addEventListener('click', () => {
        bookmarkModal.classList.remove('hidden');
        loadCategories();
    });

    // Hide bookmark modal
    closeBookmarkModal.addEventListener('click', () => {
        bookmarkModal.classList.add('hidden');
    });

    // Show create category form
    createNewCategoryBtn.addEventListener('click', () => {
        createCategoryForm.classList.remove('hidden');
        createNewCategoryBtn.classList.add('hidden');
    });

    // Hide create category form
    cancelCreateCategory.addEventListener('click', () => {
        createCategoryForm.classList.add('hidden');
        createNewCategoryBtn.classList.remove('hidden');
    });

    // Create new category
    submitCreateCategory.addEventListener('click', async () => {
        const categoryName = document.getElementById('categoryName').value;
        
        try {
            const response = await fetch('/api/bookmark-categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: categoryName
                })
            });

            if (response.ok) {
                createCategoryForm.classList.add('hidden');
                createNewCategoryBtn.classList.remove('hidden');
                document.getElementById('categoryName').value = '';
                loadCategories();
            }
        } catch (error) {
            console.error('Error creating category:', error);
        }
    });

    // Load categories
    async function loadCategories() {
        try {
            const response = await fetch('/api/bookmark-categories');
            const categories = await response.json();
            
            categoriesList.innerHTML = categories.map(category => `
                <button onclick="saveToCategory(${category.id})" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    ${category.name}
                </button>
            `).join('');
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    // Save to category
    window.saveToCategory = async (categoryId) => {
        try {
            const response = await fetch(`/api/bookmarks/{{ $post->id }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    category_id: categoryId
                })
            });

            if (response.ok) {
                bookmarkModal.classList.add('hidden');
                // Show success message or update UI
            }
        } catch (error) {
            console.error('Error saving bookmark:', error);
        }
    };
});
</script>
@endpush
@endsection 