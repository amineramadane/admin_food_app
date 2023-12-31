
<div wire:ignore.self class="modal fade" id="delete-{{ $objDelete->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-deleting" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ $action }}" method="POST">

                @method('DELETE')
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-delete">{{ __('Confirm delete') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
               <div class="modal-body">
                    @if($message)
                        <p>{{ $message }}</p>
                    @else
                        <p>{{ __('Are you sure you want to delete this ligne?') }}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger close-modal">{{ __('Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>