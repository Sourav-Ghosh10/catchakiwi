@forelse($notices as $notice)
    @php
        $noticeCategoryType = $noticeCategoryTypes[$notice->category_id] ?? null;
        $noticeCategorySlug = $noticeCategorySlugs[$notice->category_id] ?? null;
        $noticeCardTypeClass = $noticeCategoryType ? 'notice-card-type-' . Str::slug($noticeCategoryType) : '';
        $noticeCardCategoryClass = $noticeCategorySlug ? 'notice-card-category-' . Str::slug($noticeCategorySlug) : '';
        $noticeLookingFor = Str::lower(trim($notice->looking_for ?? ''));
        $isWantedNotice = Str::contains($noticeLookingFor, 'wanted');
        $isItemsCategory = in_array($noticeCategorySlug, ['items-for-sale', 'items-for-sale-or-wanted'])
            || in_array(Str::lower($notice->category_name ?? ''), ['items for sale', 'items for sale or wanted']);
        $noticeDisplayCategory = $notice->category_name;
        if ($isItemsCategory && $noticeLookingFor !== '') {
            $noticeDisplayCategory = $isWantedNotice ? 'Items Wanted' : 'Items for Sale';
        }
        $parts = $notice->town_suburb ? array_map('trim', explode(',', $notice->town_suburb)) : [];
        $noticeDisplayLocation = count($parts) >= 2 ? $parts[1] : ($parts[0] ?? null);
    @endphp
    <div class="notice-card {{ $notice->noticetype == 'feature' ? 'featured-card' : '' }} {{ $noticeCardTypeClass }} {{ $noticeCardCategoryClass }}" data-notice-id="{{ $notice->id }}" role="button" tabindex="0">
        <div class="notice-card-image-wrapper">
            @if($notice->noticetype == 'feature')
                <div class="featured-badge">Featured listing</div>
            @endif
            @if($isWantedNotice)
                <div class="wanted-badge">Wanted</div>
            @endif
            
            @if(isset($noticeImages[$notice->id]) && count($noticeImages[$notice->id]) > 0)
                <img src="{{ asset($noticeImages[$notice->id][0]->img_path) }}" alt="{{ $notice->heading }}" class="notice-card-img">
            @else
                <div class="notice-card-placeholder">
                    <i class="fa fa-bullhorn"></i>
                </div>
            @endif
        </div>
        <div class="notice-card-body">
            <div class="notice-card-category">
                {{ strtoupper($noticeDisplayCategory) }}
            </div>
            <h4 class="notice-card-heading">{{ $notice->heading }}</h4>
            @if($noticeDisplayLocation)
                <div class="notice-card-location">
                    <i class="fa fa-map-marker"></i> {{ $noticeDisplayLocation }}
                </div>
            @endif
        </div>
        <div class="notice-card-footer">
            <div class="notice-card-user">
                <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice-card-user-logo">
                <span>{{ $notice->user_name ?? 'Catchakiwi' }}</span>
            </div>
            <div class="notice-card-meta">
                <span class="notice-card-views"><i class="fa fa-eye"></i> {{ $notice->views ?? 0 }}</span>
                <a href="{{ url('/profile#parentHorizontalTab3') }}" class="notice-card-chat-btn"
                    title="Message user" onclick="event.stopPropagation();">
                    <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="Message"
                        class="notice-card-chat-icon">
                </a>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info notice-grid-empty notice-grid-empty-search text-center py-5 w-100">
        <i class="fa fa-info-circle fa-2x mb-3"></i>
        <span class="notice-grid-empty-title">No matching notices found</span>
        <span class="notice-grid-empty-help text-muted">Try adjusting your filters or checking your spelling.</span>
    </div>
@endforelse

@include('frontend.partials.notice-details-modal', ['modalNotices' => $notices, 'noticeImages' => $noticeImages])
