@extends('layouts.app')

@section('header_title', 'Personal Posts')

@section('content')
<div class="max-w-4xl mx-auto w-full">
    <!-- Create Post Form -->
    <div class="bg-white rounded-lg shadow mb-6">
        <form action="/create-post" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                <input type="text" name="title" placeholder="Title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#958433]" required>
            </div>
            <div class="mb-4">
                <textarea name="body" placeholder="What's on your mind?" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#958433] h-32" required></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <input type="text" name="location" placeholder="Location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#958433]">
                </div>
                <div>
                    <input type="text" name="cp" placeholder="Contact Person" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#958433]">
                </div>
            </div>
            <div class="mb-4">
                <input type="file" name="image" class="w-full" accept="image/*">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-[#958433] text-white px-6 py-2 rounded-full hover:bg-[#7a6a29] transition">
                    Post
                </button>
            </div>
        </form>
    </div>

    <!-- Personal Posts -->
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
@endsection
