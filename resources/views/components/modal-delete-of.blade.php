
<div wire:ignore.self class="modal fade" id="delete-{{ $objDelete->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-deleting" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-delete">{{ __('Confirm cancel') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{__('Motif')}} :

                    <select required wire:model="Object.of_motif_id" class="styleSelect2">
                        <option value=""> {{ __('Motif') }}...</option>
                        @foreach (App\Models\OfMotif::get() as $item)
                            <option value="{{$item->id}}">{{$item->motif}}</option>
                        @endforeach
                    </select>

                    <p class="mt-2">{{ __('Are you sure you want to cancel this ligne?') }}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" wire:click="annuler" class="btn btn-danger close-modal" data-dismiss="modal">{{ __('Confirm') }}</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
