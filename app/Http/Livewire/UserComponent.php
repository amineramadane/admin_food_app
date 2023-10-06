<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserComponent extends Component
{
    public $nom = null;
    public $email = null;
    public $status = null;
    public $last_login_at = null;

    public $sortColumn = 'id';
    public $sortDirection = 'ASC';

    public function filters($column) 
    {
        if($this->sortColumn == $column && $this->sortDirection == 'ASC')
            $this->sortDirection = 'DESC';

        else if($this->sortColumn == $column && $this->sortDirection == 'DESC') {
            $this->sortColumn = 'id';
            $this->sortDirection = 'ASC';

        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'ASC';
        }
    }

    public function render()
    {
        $users = User::when(!empty($this->nom), function($query){
                            return $query->where('name', 'like', "%$this->nom%");
                        })
                        ->when(!empty($this->email), function($query){
                            return $query->where('email', 'like', "%$this->email%");
                        })
                        ->when(!empty($this->last_login_at), function($query){
                            return $query->whereDate('last_login_at', $this->last_login_at);
                        })
                        ->when(!is_null($this->status), function($query){
                            return $query->where('banned', $this->status);
                        })
                        ->orderBy($this->sortColumn, $this->sortDirection)
                        ->paginate(20);
        return view('livewire.user-component', compact('users'));
    }

    public function resetAll()
    {
        $this->reset(['nom', 'email', 'status', 'last_login_at']);
    }
}
