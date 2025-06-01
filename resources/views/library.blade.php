@extends('layouts.app')

@section('header_title', 'My Library')

@section('content')
    <div class="max-w-6xl mx-auto w-full px-4">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <div class="inline-block p-4 bg-[#958433]/10 rounded-full mb-4">
                <i class="fas fa-bookmark text-4xl text-[#958433]"></i>
            </div>
            <h1 class="text-3xl font-bold text-[#3E3E3E] mb-2">My Library</h1>
            <p class="text-[#7D7D7D]">Organize and access your saved posts easily</p>
        </div>

        <!-- Saved Posts Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#3E3E3E] flex items-center gap-2">
                    <i class="fas fa-star text-[#958433]"></i>
                    Saved Posts
                </h2>
                <div class="flex items-center gap-2">
                    <button onclick="toggleViewMode('grid')"
                        class="p-2 text-[#7D7D7D] hover:text-[#958433] transition-colors">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button onclick="toggleViewMode('list')"
                        class="p-2 text-[#7D7D7D] hover:text-[#958433] transition-colors">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="savedPosts">
                <!-- Posts will be loaded here dynamically -->
            </div>

            <div id="noPosts" class="hidden col-span-full">
                <div class="bg-white rounded-lg shadow-sm p-8 text-center border border-gray-100">
                    <div class="w-16 h-16 bg-[#958433]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bookmark text-2xl text-[#958433]"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-[#3E3E3E] mb-2">No Saved Posts Yet</h3>
                    <p class="text-[#7D7D7D] mb-4">Start saving posts to build your personal library!</p>
                    <a href="/home"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-[#958433] text-white rounded-lg hover:bg-[#7a6a29] transition-colors">
                        <i class="fas fa-plus"></i>
                        Browse Posts
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#3E3E3E] flex items-center gap-2">
                    <i class="fas fa-folder text-[#958433]"></i>
                    My Categories
                </h2>
                <button onclick="showAddCategoryModal()"
                    class="flex items-center gap-2 px-4 py-2 bg-[#958433] text-white rounded-lg hover:bg-[#7a6a29] transition-colors">
                    <i class="fas fa-plus"></i>
                    Add Category
                </button>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#958433]/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-folder text-[#958433]"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-[#3E3E3E]">{{ $category->name }}</h3>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="showEditCategoryModal({{ $category->id }}, '{{ $category->name }}')"
                                    class="text-[#958433] hover:text-[#7a6a29] transition-colors p-1.5 rounded-full hover:bg-gray-50"
                                    title="Edit Category">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="showDeleteCategoryModal({{ $category->id }})"
                                    class="text-red-500 hover:text-red-700 transition-colors p-1.5 rounded-full hover:bg-gray-50"
                                    title="Delete Category">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-sm text-[#7D7D7D] mb-4">{{ $category->libraryPosts->count() }} posts</p>

                        <!-- Posts in Category -->
                        <div class="space-y-3">
                            @foreach ($category->libraryPosts as $library)
                                @php $post = $library->post; @endphp
                                @if ($post)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center gap-3">
                                            @if ($post->image_path)
                                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post thumbnail"
                                                    class="w-12 h-12 rounded-lg object-cover">
                                            @else
                                                <div class="w-12 h-12 bg-[#958433]/10 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-[#958433]"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="text-sm font-medium text-[#3E3E3E]">{{ $post->title }}</h4>
                                                <p class="text-xs text-[#7D7D7D]">by {{ $post->user->name }}</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('library.unsave', ['post' => $post->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 transition-colors p-1.5 rounded-full hover:bg-gray-50"
                                                title="Remove from category">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @if ($categories->isEmpty())
                    <div class="col-span-full bg-white rounded-lg shadow-sm p-8 text-center border border-gray-100">
                        <div class="w-16 h-16 bg-[#958433]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-folder text-2xl text-[#958433]"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#3E3E3E] mb-2">No Categories Yet</h3>
                        <p class="text-[#7D7D7D] mb-4">Create your first category to organize your saved posts!</p>
                        <button onclick="showAddCategoryModal()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-[#958433] text-white rounded-lg hover:bg-[#7a6a29] transition-colors">
                            <i class="fas fa-plus"></i>
                            Create Category
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-96">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Add New Category</h2>
                <button onclick="closeAddCategoryModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addCategoryForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeAddCategoryModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#958433] text-white rounded-lg hover:bg-[#7a6a29]">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-96">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Edit Category</h2>
                <button onclick="closeEditCategoryModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editCategoryForm" class="space-y-4">
                <input type="hidden" name="category_id">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditCategoryModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#958433] text-white rounded-lg hover:bg-[#7a6a29]">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div id="deleteCategoryModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-96">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Delete Category</h2>
                <button onclick="closeDeleteCategoryModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-gray-600 mb-4">Are you sure you want to delete this category? This action cannot be undone.</p>
            <form id="deleteCategoryForm" class="space-y-4">
                <input type="hidden" name="category_id">
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeDeleteCategoryModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentViewMode = 'grid';

            function toggleViewMode(mode) {
                currentViewMode = mode;
                const savedPostsContainer = document.getElementById('savedPosts');
                savedPostsContainer.className = mode === 'grid' ?
                    'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' :
                    'space-y-4';
                loadSavedPosts();
            }

            // Load saved posts
            async function loadSavedPosts() {
                try {
                    const response = await fetch('/library', {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load saved posts');
                    }

                    const posts = await response.json();
                    const savedPostsContainer = document.getElementById('savedPosts');
                    const noPostsMessage = document.getElementById('noPosts');

                    if (posts.length === 0) {
                        savedPostsContainer.classList.add('hidden');
                        noPostsMessage.classList.remove('hidden');
                        return;
                    }

                    savedPostsContainer.classList.remove('hidden');
                    noPostsMessage.classList.add('hidden');

                    savedPostsContainer.innerHTML = posts.map(post => `
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    ${post.image_path ? `
                                                <img src="/storage/${post.image_path}" alt="Post thumbnail"
                                                    class="w-12 h-12 rounded-lg object-cover">
                                            ` : `
                                                <div class="w-12 h-12 bg-[#958433]/10 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-[#958433]"></i>
                                                </div>
                                            `}
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#3E3E3E]">${post.title}</h3>
                                        <p class="text-sm text-[#7D7D7D]">by ${post.user.name}</p>
                                    </div>
                                </div>
                                <form action="/library/${post.id}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 transition-colors p-1.5 rounded-full hover:bg-gray-50"
                                        title="Remove from library">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="space-y-3">
                                <p class="text-sm text-[#7D7D7D]">${post.body}</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="flex items-center gap-1 text-xs text-[#7D7D7D] bg-gray-50 px-2 py-1 rounded-full">
                                        <i class="fas fa-map-marker-alt"></i>
                                        ${post.location}
                                    </span>
                                    <span class="flex items-center gap-1 text-xs text-[#7D7D7D] bg-gray-50 px-2 py-1 rounded-full">
                                        <i class="fas fa-phone"></i>
                                        ${post.cp}
                                    </span>
                                </div>
                            </div>
                            ${post.image_path ? `
                                        <div class="mt-4">
                                            <img src="/storage/${post.image_path}" alt="Post image" class="w-full h-48 object-cover rounded-lg">
                                        </div>
                                    ` : ''}
                        </div>
                    `).join('');
                } catch (error) {
                    console.error('Error loading saved posts:', error);
                    showNotification('Failed to load saved posts', 'error');
                }
            }

            // Load saved posts when page loads
            document.addEventListener('DOMContentLoaded', loadSavedPosts);

            // Add Category
            function showAddCategoryModal() {
                document.getElementById('addCategoryModal').classList.remove('hidden');
            }

            function closeAddCategoryModal() {
                document.getElementById('addCategoryModal').classList.add('hidden');
                document.getElementById('addCategoryForm').reset();
            }

            document.getElementById('addCategoryForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const form = e.target;
                const name = form.querySelector('input[name="name"]').value;

                try {
                    const response = await fetch('/api/categories', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            name
                        })
                    });

                    if (!response.ok) {
                        const error = await response.json();
                        throw new Error(error.message || 'Failed to create category');
                    }

                    showNotification('Category created successfully');
                    closeAddCategoryModal();
                    window.location.reload();
                } catch (error) {
                    console.error('Error creating category:', error);
                    showNotification(error.message || 'Failed to create category', 'error');
                }
            });

            // Edit Category
            function showEditCategoryModal(categoryId, categoryName) {
                const modal = document.getElementById('editCategoryModal');
                const form = document.getElementById('editCategoryForm');
                form.querySelector('input[name="category_id"]').value = categoryId;
                form.querySelector('input[name="name"]').value = categoryName;
                modal.classList.remove('hidden');
            }

            function closeEditCategoryModal() {
                document.getElementById('editCategoryModal').classList.add('hidden');
                document.getElementById('editCategoryForm').reset();
            }

            document.getElementById('editCategoryForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const form = e.target;
                const categoryId = form.querySelector('input[name="category_id"]').value;
                const name = form.querySelector('input[name="name"]').value;

                try {
                    const response = await fetch(`/categories/${categoryId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            name
                        })
                    });

                    if (!response.ok) {
                        const error = await response.json();
                        throw new Error(error.message || 'Failed to update category');
                    }

                    showNotification('Category updated successfully');
                    closeEditCategoryModal();
                    window.location.reload();
                } catch (error) {
                    console.error('Error updating category:', error);
                    showNotification(error.message || 'Failed to update category', 'error');
                }
            });

            // Delete Category
            function showDeleteCategoryModal(categoryId) {
                const modal = document.getElementById('deleteCategoryModal');
                const form = document.getElementById('deleteCategoryForm');
                form.querySelector('input[name="category_id"]').value = categoryId;
                modal.classList.remove('hidden');
            }

            function closeDeleteCategoryModal() {
                document.getElementById('deleteCategoryModal').classList.add('hidden');
                document.getElementById('deleteCategoryForm').reset();
            }

            document.getElementById('deleteCategoryForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const form = e.target;
                const categoryId = form.querySelector('input[name="category_id"]').value;

                try {
                    const response = await fetch(`/categories/${categoryId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        const error = await response.json();
                        throw new Error(error.message || 'Failed to delete category');
                    }

                    showNotification('Category deleted successfully');
                    closeDeleteCategoryModal();
                    window.location.reload();
                } catch (error) {
                    console.error('Error deleting category:', error);
                    showNotification(error.message || 'Failed to delete category', 'error');
                }
            });

            // Notification
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
        </script>
    @endpush
@endsection
