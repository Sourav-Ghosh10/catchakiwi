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
        $noticeDisplayLocation = $notice->town_suburb ? trim(Str::before($notice->town_suburb, ',')) : null;
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
    </div>
@empty
    <div class="alert alert-info notice-grid-empty notice-grid-empty-search text-center py-5 w-100">
        <i class="fa fa-info-circle fa-2x mb-3"></i>
        <span class="notice-grid-empty-title">No matching notices found</span>
        <span class="notice-grid-empty-help text-muted">Try adjusting your filters or checking your spelling.</span>
    </div>
@endforelse

@include('frontend.partials.notice-details-modal', ['modalNotices' => $notices, 'noticeImages' => $noticeImages])
