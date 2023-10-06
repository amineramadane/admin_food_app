<table class="table table-hover" style="position:relative">
    <tbody wire:sortable="updateQuestionPosition" style="position:relative">
        @foreach ($questions as $question)
            <tr class="{{ $question->status == 1 ? 'text-danger' : 'text-success' }}" style="cursor:move;" wire:sortable.item="{{ $question->id }}" wire:key="question-{{ $question->id }}" wire:sortable.handle >
                <td>
                    <span style="display:inline-block;font-size:.5rem;" class="text-secondary mr-3">
                        <i class="material-icons">open_with</i>
                    </span>
                    {{ $question->title }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<style>
    .draggable-mirror
    {
        background-color:white;
        width:75%;
        display:flex;
        justify-content:space-between;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

</style>