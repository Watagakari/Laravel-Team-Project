@extends('layouts.app')

@section('header_title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto w-full">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex items-center gap-6">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&size=128" alt="Profile picture" class="w-32 h-32 rounded-full">
                <div>
                    <h1 class="text-2xl font-bold text-[#3E3E3E] mb-2">{{ $user->name }}</h1>
                    <p class="text-[#7D7D7D]">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Actions -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 flex justify-between items-center">
            <div class="flex gap-4">
                <!-- Edit Button triggers modal -->
                <button onclick="document.getElementById('editProfileModal').classList.remove('hidden')" 
                    class="bg-[#958433] text-white px-4 py-2 rounded hover:bg-[#7a6a29] transition">
                    Edit Profile
                </button>

                <!-- Delete Button with confirmation -->
                <form action="{{ route('profile.delete') }}" method="POST" 
                    onsubmit="return confirm('Are you sure you want to delete your account?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Stats -->
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h3 class="text-2xl font-bold text-[#958433] mb-1">{{ $posts->count() }}</h3>
            <p class="text-[#7D7D7D]">Posts</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h3 class="text-2xl font-bold text-[#958433] mb-1">0</h3>
            <p class="text-[#7D7D7D]">Followers</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h3 class="text-2xl font-bold text-[#958433] mb-1">0</h3>
            <p class="text-[#7D7D7D]">Following</p>
        </div>
    </div>

    <!-- User Posts -->
    <div class="space-y-6">
        @foreach($posts as $post)
        <article class="bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ $post->user->name }}" alt="User avatar" class="w-10 h-10 rounded-full">
                        <div>
                            <h3 class="font-semibold text-[#3E3E3E]">{{ $post->user->name }}</h3>
                            <p class="text-sm text-[#7D7D7D]">
                                {{ $post->created_at->diffForHumans() }} • {{ $post->location }} • {{ $post->cp }}
                            </p>
                        </div>
                    </div>
                    @if($post->user_id === auth()->id())
                    <div class="flex items-center gap-2">
                        <a href="/edit-post/{{ $post->id }}" class="text-[#958433] hover:text-[#7a6a29]">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/delete-post/{{ $post->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-[#3E3E3E] mb-2">{{ $post->title }}</h2>
                <p class="text-[#3E3E3E] mb-4">{{ $post->body }}</p>
                @if($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="rounded-lg max-h-[400px] w-full object-cover mb-4">
                @endif
                <div class="flex items-center gap-4">
                    <button class="flex items-center gap-2 text-[#7D7D7D] hover:text-[#958433] transition">
                        <i class="far fa-heart"></i>
                        <span>Like</span>
                    </button>
                    <button class="flex items-center gap-2 text-[#7D7D7D] hover:text-[#958433] transition">
                        <i class="far fa-comment"></i>
                        <span>Comment</span>
                    </button>
                    <button class="flex items-center gap-2 text-[#7D7D7D] hover:text-[#958433] transition">
                        <i class="far fa-bookmark"></i>
                        <span>Save</span>
                    </button>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <!-- Close Button -->
        <button onclick="document.getElementById('editProfileModal').classList.add('hidden')" 
            class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-xl font-bold">
            &times;
        </button>

        <h2 class="text-xl font-bold text-[#3E3E3E] mb-4">Edit Profile</h2>
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#958433]">
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">New Password (optional)</label>
                <input type="password" name="password" placeholder="Leave blank to keep current"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#958433]">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" 
                    onclick="document.getElementById('editProfileModal').classList.add('hidden')"
                    class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" 
                    class="bg-[#958433] text-white px-6 py-2 rounded hover:bg-[#7a6a29] transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
