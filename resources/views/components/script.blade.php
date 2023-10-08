<script>
    // for reset filter front end
    function resetFilter(){
        $(".styleSelect2").each(function() {
            $(this).val({!!json_encode($this->ObjectFilter->getOriginal())!!}[$(this)[0]['attributes']['wire:model']['nodeValue'].split('.')[1]]).trigger('change');
        });
    }
    
    // addEventListener for filter to list contains class styleSelect2
    document.addEventListener('livewire:load', function () {
        $(".styleSelect2").each(function() {
            $(this).select2({
                theme: 'bootstrap4',
            }).on('change', function() {
                // @this.set($(this).attr('name'), $(this).val());
                @this.set($(this)[0]['attributes']['wire:model']['nodeValue'], $(this).val());
            });
        });
        // $('[data-toggle="tooltip"]').tooltip('hide');
        // $('[rel="tooltip"]').tooltip('hide');
        // $('[data-toggle="tooltip"]').tooltip();
        // $('[rel="tooltip"]').tooltip();
    });

    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('renderSyncUrl', url => {
            history.pushState(null, null, url);
        });
        Livewire.hook('message.sent', (message, component) => {
            if(message.updateQueue[0].name && message.updateQueue[0].name.match("Object.") != 'ObjectF') return;
            topbar.config({
                autoRun      : true, 
                barThickness : 6,
                barColors    : {
                    '0'      : '#e3342f',
                    '0.3'      : '#bb45ee',
                    '1.0'      : '#bb45ee'
                },
                shadowBlur   : 5,
                shadowColor  : 'rgba(0, 0, 0, 1)',
                className    : 'topbar',
            })
            topbar.show()
        })
        Livewire.hook('message.processed', (message, component) => {topbar.hide()})
    });
</script>