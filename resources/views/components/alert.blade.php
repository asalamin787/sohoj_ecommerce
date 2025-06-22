<?php $i = 0; ?>
@if (!empty($errors) && count($errors) > 0 && !in_array(url()->current(),$exclude))
    @foreach ($errors->all() as $error)
        <div class="toast bg-danger mt-2 mr-2"
            style="z-index:999999999999!important;position: absolute; top: <?php echo $i; ?>px	; right: 0;"
            data-delay="6000">
            <div class="toast-header bg-danger">
                <strong class="mr-auto text-white">Error</strong>
                <button type="button" class="btn-close ms-auto toast_close" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body text-white">
                {{ $error }}
            </div>
        </div>
        <?php $i = $i + 80; ?>
    @endforeach
@endif
@if (session()->has('success_msg') || session('status'))
    <div class="toast showing bg-info mt-2 mr-2" style="position: absolute; top: 0; right: 0;z-index:11"
        data-delay="6000">
            <div class="toast-header bg-info">
                <strong class="mr-auto text-white">Success</strong>
                <button type="button" class="btn-close ms-auto toast_close" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body text-white">
                {{ session()->get('success_msg') }}{{ session('status') }}
            </div>
    </div>
@endif
