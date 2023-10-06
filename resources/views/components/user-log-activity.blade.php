<div>
    @if ($audit->auditable_type == "App\Models\Article" && $audit->event == 'created')
        @if($showName == "true")
          <b>{{ \App\Models\User::where('id', $audit->user_id)->pluck('name')->first() }}</b>
        @endif {{ __('a crée un nouveau article')}} 
        
        <a href="{{ route('articles.show', $audit->auditable_id)}}" title="Voir Article">
            <i class="material-icons md-18 text-grey">remove_red_eye</i>
        </a>
    
    @elseif ($audit->auditable_type == "App\Models\Article" && $audit->event == 'deleted')
        @if($showName == "true")
            <b>{{ \App\Models\User::where('id', $audit->user_id)->pluck('name')->first() }}</b>
        @endif {{ __('a supprimer l\'article Numero : ')}} 
        <b>{{ \App\Models\Article::withTrashed()->where('id', $audit->auditable_id)->pluck('reference')->first() }}</b>
    
    @elseif ($audit->auditable_type == "App\Models\Article" && isset($audit->old_values) && isset($audit->new_values))
        @if($showName == "true")
            <b>{{ \App\Models\User::where('id', $audit->user_id)->pluck('name')->first() }}</b>
        @endif {{ __('à modifier la valeur de ') }}
        
        @foreach ($audit->old_values as $key => $old_val)
            @foreach ($audit->new_values as $index => $new_val)
                @if($key == $index)
                    <b>{{ $index }}</b> {{ $loop->first ? __('from') : 'et'  }}<b> {{ $old_val }} </b> {{ __('to') }} <b>{{ $new_val }}</b> 
                @endif
            @endforeach
        @endforeach

        <a class="ml-2" href="{{ route('articles.show', $audit->auditable_id)}}">
            <i class="material-icons md-18 text-grey">remove_red_eye</i>
        </a>
    @endif
    
    @if ($audit->auditable_type == "App\Models\Nomenclature" && $audit->event == 'created')
        @if($showName == "true")
            <b>{{ \App\Models\User::where('id', $audit->user_id)->pluck('name')->first() }}</b>
        @endif {{ __('a crée un nouvelle nomenclature')}} 
        
        <a href="{{ route('nomenclatures.show', $audit->auditable_id)}}" title="Voir nomenclature">
            <i class="material-icons md-18 text-grey">remove_red_eye</i>
        </a>
    
    @elseif ($audit->auditable_type == "App\Models\Nomenclature" && $audit->event == 'deleted')
        @if($showName == "true")
            <b>{{ \App\Models\User::where('id', $audit->user_id)->pluck('name')->first() }}</b>
        @endif {{ __('a supprimer la nomenclature Numéro : ')}} 
        <b>{{ \App\Models\Nomenclature::withTrashed()->where('id', $audit->auditable_id)->pluck('id')->first() }}</b>
    
    @elseif ($audit->auditable_type == "App\Models\Nomenclature" && isset($audit->old_values) && isset($audit->new_values))
        
        @if($showName == "true")
            <b>{{ \App\Models\User::where('id', $audit->user_id)->pluck('name')->first() }}</b>
        @endif {{ __('à modifier la valeur de ') }}
        
        @foreach ($audit->old_values as $key => $old_val)
            @foreach ($audit->new_values as $index => $new_val)
                @if($key == $index)
                    <b>{{ $index }}</b> {{ $loop->first ? __('from') : 'et'  }}<b> {{ $old_val }} </b> {{ __('to') }} <b>{{ $new_val }}</b> 
                @endif
            @endforeach
        @endforeach
        <a class="ml-2" href="{{ route('articles.show', $audit->auditable_id)}}">
            <i class="material-icons md-18 text-grey">remove_red_eye</i>
        </a>
    @endif
</div>