{{-- Review Section Component --}}
@props([
    'reviewableType' => 'catalog', // 'catalog' or 'promotion'
    'reviewableId',
    'reviews',
    'stats'
])

<div class="bg-white rounded-xl sm:rounded-2xl shadow-md p-4 sm:p-6 lg:p-8" x-data="reviewSystem()">
    {{-- Section Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
            Ulasan & Rating
        </h2>
        <button @click="showForm = !showForm" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors text-sm sm:text-base">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tulis Ulasan
        </button>
    </div>
    
    {{-- Rating Summary --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 p-4 sm:p-6 bg-gray-50 rounded-xl">
        {{-- Average Rating --}}
        <div class="text-center lg:border-r lg:border-gray-200">
            <div class="text-4xl sm:text-5xl font-bold text-gray-900 mb-2">
                {{ number_format($stats['average_rating'], 1) }}
            </div>
            <div class="flex items-center justify-center gap-1 mb-2">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($stats['average_rating']))
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    @endif
                @endfor
            </div>
            <p class="text-sm text-gray-500">{{ $stats['total_reviews'] }} ulasan</p>
        </div>
        
        {{-- Rating Distribution --}}
        <div class="lg:col-span-2 space-y-2">
            @for($i = 5; $i >= 1; $i--)
                <div class="flex items-center gap-2 sm:gap-3">
                    <span class="text-sm font-medium text-gray-600 w-6">{{ $i }}</span>
                    <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                    <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400 rounded-full transition-all duration-500" 
                             style="width: {{ $stats['rating_percentages'][$i] ?? 0 }}%"></div>
                    </div>
                    <span class="text-sm text-gray-500 w-8 text-right">{{ $stats['rating_distribution'][$i] ?? 0 }}</span>
                </div>
            @endfor
        </div>
    </div>
    
    {{-- Review Form --}}
    <div x-show="showForm" x-collapse class="mb-8">
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tulis Ulasan Anda</h3>
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="reviewable_type" value="{{ $reviewableType }}">
                <input type="hidden" name="reviewable_id" value="{{ $reviewableId }}">
                
                {{-- Rating Selection --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-1" x-data="{ rating: {{ old('rating', 5) }}, hoverRating: 0 }">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    @click="rating = {{ $i }}"
                                    @mouseenter="hoverRating = {{ $i }}"
                                    @mouseleave="hoverRating = 0"
                                    class="focus:outline-none transition-transform hover:scale-110">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 transition-colors" 
                                     :class="(hoverRating >= {{ $i }} || (!hoverRating && rating >= {{ $i }})) ? 'text-yellow-400' : 'text-gray-300'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            </button>
                        @endfor
                        <input type="hidden" name="rating" x-model="rating">
                        <span class="ml-2 text-sm text-gray-600" x-text="rating + ' Bintang'"></span>
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Name --}}
                <div class="mb-4">
                    <label for="reviewer_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="reviewer_name" id="reviewer_name" value="{{ old('reviewer_name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                           placeholder="Masukkan nama Anda" required>
                    @error('reviewer_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Email (Optional) --}}
                <div class="mb-4">
                    <label for="reviewer_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <input type="email" name="reviewer_email" id="reviewer_email" value="{{ old('reviewer_email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                           placeholder="email@contoh.com">
                    @error('reviewer_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Comment --}}
                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        Komentar <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <textarea name="comment" id="comment" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-none"
                              placeholder="Ceritakan pengalaman Anda..."
                              maxlength="1000">{{ old('comment') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Submit --}}
                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-3 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>
    
    {{-- Reviews List --}}
    <div class="space-y-6">
        @forelse($reviews as $review)
            <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                <div class="flex items-start gap-4">
                    {{-- Avatar --}}
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-sm sm:text-base">{{ strtoupper(substr($review->reviewer_name, 0, 2)) }}</span>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        {{-- Header --}}
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="font-semibold text-gray-900">{{ $review->reviewer_name }}</span>
                            @if($review->is_verified_purchase)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terverifikasi
                                </span>
                            @endif
                        </div>
                        
                        {{-- Rating & Date --}}
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        
                        {{-- Comment --}}
                        @if($review->comment)
                            <p class="text-gray-700 text-sm sm:text-base">{{ $review->comment }}</p>
                        @endif
                        
                        {{-- Helpful Button --}}
                        <div class="mt-3 flex items-center gap-4">
                            <button type="button" 
                                    onclick="markHelpful({{ $review->id }}, this)"
                                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-amber-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                                <span>Membantu (<span class="helpful-count">{{ $review->helpful_count }}</span>)</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <p class="text-gray-500 mb-2">Belum ada ulasan</p>
                <p class="text-sm text-gray-400">Jadilah yang pertama memberikan ulasan!</p>
                <button @click="showForm = true" class="mt-4 text-amber-600 hover:text-amber-700 font-medium">
                    Tulis Ulasan Pertama
                </button>
            </div>
        @endforelse
    </div>
    
    {{-- Pagination --}}
    @if($reviews instanceof \Illuminate\Pagination\AbstractPaginator && $reviews->hasPages())
        <div class="mt-6 pt-6 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    function reviewSystem() {
        return {
            showForm: {{ $errors->any() ? 'true' : 'false' }}
        }
    }
    
    function markHelpful(reviewId, button) {
        fetch(`/reviews/${reviewId}/helpful`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const countEl = button.querySelector('.helpful-count');
                countEl.textContent = data.count;
                button.classList.add('text-amber-600');
                button.disabled = true;
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
@endpush
