@php
    $showModal = !empty($setting->login_modal_enabled)
        && !empty($setting->login_modal_image)
        && !session('user_login_modal_dismissed');
@endphp
@if($showModal)
<div class="user-login-modal-backdrop" id="userLoginModal" role="dialog" aria-modal="true">
    <div class="user-login-modal-box">
        <button type="button" class="user-login-modal-close" aria-label="Close">&times;</button>
        <div class="user-login-modal-image-wrap">
            <img src="{{ url('/') }}/public/uploads/{{ $setting->login_modal_image }}" alt="Announcement" class="user-login-modal-image">
        </div>
    </div>
</div>
@push('js')
<script>
(function () {
    var $modal = $('#userLoginModal');
    if (!$modal.length) return;
    $('body').addClass('user-login-modal-open');
    $modal.on('click', function (e) {
        if ($(e.target).is('.user-login-modal-backdrop')) {
            closeModal();
        }
    });
    $('.user-login-modal-close').on('click', closeModal);
    function closeModal() {
        $.post('{{ route('user.login_modal.dismiss') }}', {
            _token: $('meta[name="csrf-token"]').attr('content')
        }).always(function () {
            $modal.remove();
            $('body').removeClass('user-login-modal-open');
        });
    }
})();
</script>
@endpush
@endif
