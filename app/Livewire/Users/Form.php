<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class Form extends ModalComponent
{
    use Actions;

    public User $user;

    public ?string $newPassword = null;
    public ?string $newPasswordConfirmation = null;

    protected $rules = [
        'user.name' => 'required|string',
        'user.email' => 'required|email',
        'user.role' => 'required|string|in:superadmin,admin,user',
        'newPassword' => 'nullable|string|min:8',
        'newPasswordConfirmation' => 'nullable|string|min:8|same:newPassword',
    ];

    public function mount(User $user = null)
    {
        $this->user = $user ?? new User();
    }

    public function saveUser()
    {
        $this->validate();

        try {
            if ($this->newPassword) {
                $this->user->password = \Hash::make($this->newPassword);
            }

            $this->user->save();

            $this->notification()->success(__('User saved successfully.'));

            $this->closeModalWithEvents(['reload']);
        } catch (\Exception $e) {
            report($e);

            $this->notification()->error(__('An error occurred while saving the user.'));
        }
    }

    public function render()
    {
        return view('livewire.users.form');
    }
}
