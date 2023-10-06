<div>
    <div class="card bg-white">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 my-2">
                    <div class="input-group bg-light">
                        <input wire:model.debounce.300ms="nom" type="text" class="form-control form-control-sm" name="nom" placeholder="{{ __('Nom') }}" />
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="input-group bg-light">
                        <input wire:model.debounce.300ms="email" type="email" class="form-control form-control-sm" name="email" placeholder="{{ __('E-mail') }}" />
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="input-group bg-light">
                        <select wire:model="status" id="status" name="status" class="js-example-basic-multiple form-control form-control-sm">
                            <option value="">{{ __('All...') }}</option>
                            <option value="0">{{ __('Active') }}</option>
                            <option value="1">{{ __('Banned') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 my-2">
                    <div class="input-group bg-light">
                        <input wire:model.debounce.300ms="last_login_at" type="date" class="form-control form-control-sm" name="last_login_at" placeholder="{{ __('Dernière connexion') }}" />
                    </div>
                </div>
                <div class="col-md my-2">
                    <svg wire:click="resetAll()" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th width="1"></th>
                            <th width="1"></th>
                            <th width="1"></th>
                            <th wire:click="filters('name')">
                                {{__('Name')}}
                                
                                @if ($sortColumn == "name" && $sortDirection == 'ASC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                    </svg>
                                @elseif($sortColumn == "name" && $sortDirection == 'DESC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                @endif
                            </th>
                            <th wire:click="filters('email')">
                                {{__('E-mail')}}
                                
                                @if ($sortColumn == "email" && $sortDirection == 'ASC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                    </svg>
                                @elseif($sortColumn == "email" && $sortDirection == 'DESC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                @endif
                            </th>
                            <th>{{__('Role')}}</th>
                            <th wire:click="filters('banned')">
                                {{__('Status')}}
                                
                                @if ($sortColumn == "banned" && $sortDirection == 'ASC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                    </svg>
                                @elseif($sortColumn == "banned" && $sortDirection == 'DESC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                @endif
                            </th>
                            <th width="1" wire:click="filters('last_login_at')">
                                {{__('Last Login')}}
                            
                                @if ($sortColumn == "last_login_at" && $sortDirection == 'ASC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                    </svg>
                                @elseif($sortColumn == "last_login_at" && $sortDirection == 'DESC')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up float-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td width="1">
                                    @can('users_show')
                                        <a href="{{route('users.show', $user->id)}}" data-toggle="tooltip" data-placement="top" title="{{__('View User')}}">
                                            <i class="material-icons md-18 text-grey">remove_red_eye</i>
                                        </a>
                                    @endcan
                                </td>
                                <td width="1">
                                    @can('users_edit')
                                        <a href="{{route('users.edit', $user->id)}}" data-toggle="tooltip" data-placement="top" title="{{__('Edit User')}}">
                                            <i class="material-icons md-18 text-grey">edit</i>
                                        </a>
                                    @endcan
                                </td>
                                <td width="1">
                                    @if(!$user->isSuperAdmin())
                                        @can('users_delete')
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" class="deleteBtn" data-confirm-message="{{__("Are you sure you want to delete this user?")}}" data-toggle="tooltip" data-placement="top" title="{{__('Delete User')}}"><i class="material-icons md-18 text-grey">delete</i></a>
                                            </form>
                                        @endcan
                                    @endif
                                </td>
                                <td>
                                    @if(auth()->user()->can('users_show'))
                                        <a href="{{route('users.show', $user->id)}}">{{$user->name}}</a>
                                    @else
                                        {{$user->name}}
                                    @endif
                                </td>
                                <td>{{$user->email}}</td>
                                <td><span class="badge badge-lg badge-secondary text-white">{{@$user->getRoleNames()[0]}}</span></td>
                                <td>
                                    @if($user->banned)
                                        <span class="badge badge-lg badge-danger text-white">{{__('Banned')}}</span>
                                    @else
                                        @if(setting('auth.email_verification'))
                                            @if($user->email_verified_at == null)
                                                <span class="badge badge-lg badge-dark text-white">{{__('Unconfirmed')}}</span>
                                            @else
                                                <span class="badge badge-lg badge-success text-white">{{__('Active')}}</span>
                                            @endif
                                        @else
                                            <span class="badge badge-lg badge-success text-white">{{__('Active')}}</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="nowrap">{{$user->last_login_at}}</td>
                            </tr>
                        @empty 
                            <tr><td colspan="8" align="center"> {{ __('No results found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="float-left">
                    @if(!empty($term))
                        {{ $users->appends(['s' => $term])->links() }}
                    @else
                        {{ $users->links() }}
                    @endif
                </div>

                <div class="float-right text-muted">
                    {{__('Showing')}} {{ $users->firstItem() }} - {{ $users->lastItem() }} / {{ $users->total() }} ({{__('page')}} {{ $users->currentPage() }} )
                </div>
            </div>
        </div>
    </div>
</div>
