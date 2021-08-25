<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class UserDatatable extends Component
{
    #Majority of code taken with gratitude from 
    # https://github.com/davidgrzyb/laravel-livewire-datatable-example
    use WithPagination;
    public $message = '';
    public $perPage = 15;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {
        return view('livewire.user-datatable', [
            'users' => User::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->Paginate($this->perPage),
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('super-admin')) {
            session()->flash('warning', 'Super-admin user can\'t be deleted :(');
            return false;
        }
        $user->delete($id);
        session()->flash('success', 'User Deleted successfully!');
    }
}
