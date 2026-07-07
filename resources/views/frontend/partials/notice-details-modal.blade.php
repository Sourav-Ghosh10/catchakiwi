<div class="notice-modal-templates" hidden>
    @php
        $noticeCategoryTypes = isset($categories)
            ? collect($categories)->mapWithKeys(function ($catInfo) {
                return [$catInfo->id => $catInfo->type];
            })
            : collect();
        $noticeCategorySlugs = isset($categories)
            ? collect($categories)->mapWithKeys(function ($catInfo) {
                return [$catInfo->id => $catInfo->slug ?? Str::slug($catInfo->category)];
            })
            : collect();
    @endphp
    @foreach($modalNotices as $notice)
        @php
            $noticeCategoryType = $noticeCategoryTypes[$notice->category_id] ?? null;
            $noticeCategorySlug = $noticeCategorySlugs[$notice->category_id] ?? Str::slug($notice->category_name ?? '');
            $noticeCardTypeClass = $noticeCategoryType ? 'notice-card-type-' . Str::slug($noticeCategoryType) : '';
            $noticeCardCategoryClass = $noticeCategorySlug ? 'notice-card-category-' . Str::slug($noticeCategorySlug) : '';
        @endphp
        <div id="notice-modal-template-{{ $notice->id }}">
            <div class="notice-modal-shell {{ $noticeCardTypeClass }} {{ $noticeCardCategoryClass }}">
            <div class="notice-modal-gallery">
                @if(isset($noticeImages[$notice->id]) && count($noticeImages[$notice->id]) > 0)
                    @foreach($noticeImages[$notice->id] as $image)
                        <button type="button" class="notice-modal-img-btn" data-lightbox-src="{{ asset($image->img_path) }}" data-lightbox-alt="{{ $notice->heading }}">
                            <img src="{{ asset($image->img_path) }}" alt="{{ $notice->heading }}" class="notice-modal-img">
                        </button>
                    @endforeach
                @else
                    <div class="notice-modal-placeholder">
                        <i class="fa fa-bullhorn"></i>
                    </div>
                @endif
            </div>
            <div class="notice-modal-content">
                <div class="notice-modal-category">
                    @if($notice->category_name == 'Items for Sale or Wanted' && $notice->noticetype == 'standard')
                        FREE
                    @else
                        {{ strtoupper($notice->category_name) }}
                    @endif
                </div>
                <h2 class="notice-modal-title">{{ $notice->heading }}</h2>
                <p class="notice-modal-description">{{ $notice->content }}</p>

                <div class="notice-modal-details">
                    <div>
                        <span>Category</span>
                        <strong>{{ $notice->category_name }}</strong>
                    </div>
                    <div>
                        <span>Type</span>
                        <strong>{{ ucfirst($notice->noticetype ?? 'standard') }}</strong>
                    </div>
                    @if($notice->town_suburb)
                        <div>
                            <span>Location</span>
                            <strong>{{ $notice->town_suburb }}</strong>
                        </div>
                    @endif
                    @if(!empty($notice->looking_for))
                        <div>
                            <span>Looking For</span>
                            <strong>{{ $notice->looking_for }}</strong>
                        </div>
                    @endif
                    @if(!empty($notice->job_location))
                        <div>
                            <span>Job Location</span>
                            <strong>{{ $notice->job_location }}</strong>
                        </div>
                    @endif
                    @if(!empty($notice->start_date))
                        <div>
                            <span>Start Date</span>
                            <strong>{{ $notice->start_date }}</strong>
                        </div>
                    @endif
                    @if(!empty($notice->budget))
                        <div>
                            <span>Budget</span>
                            <strong>{{ $notice->budget }}</strong>
                        </div>
                    @endif
                </div>

                @if(!empty($notice->message_text))
                    <div class="notice-modal-message">
                        <span>Message</span>
                        <p>{{ $notice->message_text }}</p>
                    </div>
                @endif

                <div class="notice-modal-footer">
                    <div class="notice-card-user">
                        <img src="{{ asset('assets/images/notice_logoimg.png')}}" alt="" class="notice-card-user-logo">
                        <span>{{ $notice->user_name ?? 'Catchakiwi' }}</span>
                    </div>
                    <div class="notice-card-meta">
                        <span class="notice-card-views"><i class="fa fa-eye"></i> {{ $notice->views ?? 0 }}</span>
                        <a href="{{ url('/profile#parentHorizontalTab3') }}" class="notice-card-chat-btn" title="Message user">
                            <img src="{{ asset('assets/images/notice_chaticon.png')}}" alt="Message" class="notice-card-chat-icon">
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>

<div class="notice-details-modal" id="noticeDetailsModal" aria-hidden="true">
    <div class="notice-modal-backdrop" data-notice-modal-close></div>
    <div class="notice-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="noticeModalTitle">
        <button type="button" class="notice-modal-close" data-notice-modal-close aria-label="Close notice details">
            <i class="fa fa-times"></i>
        </button>
        <div class="notice-modal-body" id="noticeModalBody"></div>
    </div>
</div>

<div class="notice-image-lightbox" id="noticeImageLightbox" aria-hidden="true">
    <div class="notice-lightbox-backdrop" data-notice-lightbox-close></div>
    <div class="notice-lightbox-dialog" role="dialog" aria-modal="true" aria-label="Notice image preview">
        <button type="button" class="notice-lightbox-close" data-notice-lightbox-close aria-label="Close image preview">
            <i class="fa fa-times"></i>
        </button>
        <img src="" alt="" id="noticeLightboxImage">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('noticeDetailsModal');
    var modalBody = document.getElementById('noticeModalBody');
    var lightbox = document.getElementById('noticeImageLightbox');
    var lightboxImage = document.getElementById('noticeLightboxImage');

    if (!modal || !modalBody || !lightbox || !lightboxImage) {
        return;
    }

    function openNoticeModal(noticeId) {
        var template = document.getElementById('notice-modal-template-' + noticeId);

        if (!template) {
            return;
        }

        modalBody.innerHTML = template.innerHTML;
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('notice-modal-open');

        var title = modalBody.querySelector('.notice-modal-title');
        if (title) {
            title.id = 'noticeModalTitle';
        }
    }

    function closeNoticeModal() {
        modal.setAttribute('aria-hidden', 'true');
        modalBody.innerHTML = '';
        document.body.classList.remove('notice-modal-open');
        closeNoticeLightbox();
    }

    function openNoticeLightbox(src, alt) {
        lightboxImage.setAttribute('src', src);
        lightboxImage.setAttribute('alt', alt || 'Notice image');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.classList.add('notice-lightbox-open');
    }

    function closeNoticeLightbox() {
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImage.setAttribute('src', '');
        lightboxImage.setAttribute('alt', '');
        document.body.classList.remove('notice-lightbox-open');
    }

    document.querySelectorAll('.notice-card[data-notice-id]').forEach(function (card) {
        card.addEventListener('click', function (event) {
            if (event.target.closest('a, button')) {
                return;
            }

            openNoticeModal(card.getAttribute('data-notice-id'));
        });

        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openNoticeModal(card.getAttribute('data-notice-id'));
            }
        });
    });

    modal.querySelectorAll('[data-notice-modal-close]').forEach(function (button) {
        button.addEventListener('click', closeNoticeModal);
    });

    modalBody.addEventListener('click', function (event) {
        var imageButton = event.target.closest('.notice-modal-img-btn');

        if (!imageButton) {
            return;
        }

        openNoticeLightbox(imageButton.getAttribute('data-lightbox-src'), imageButton.getAttribute('data-lightbox-alt'));
    });

    lightbox.querySelectorAll('[data-notice-lightbox-close]').forEach(function (button) {
        button.addEventListener('click', closeNoticeLightbox);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }

        if (lightbox.getAttribute('aria-hidden') === 'false') {
            closeNoticeLightbox();
            return;
        }

        if (modal.getAttribute('aria-hidden') === 'false') {
            closeNoticeModal();
        }
    });
});
</script>
