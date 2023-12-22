<?php

namespace App\Livewire;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;
use WireUi\Traits\Actions;

class UsersTable extends DataTableComponent
{
    use Actions;

    protected $model = User::class;

    protected string $tableName = 'users-table';

    protected $listeners = [
        'reload' => '$refresh',
    ];

    public function editUser(int $id)
    {
        \Gate::authorize('edit');

        $user = User::findOrFail($id);

        $this->dispatch('openModal', 'users.form', [
            'user' => $user->id,
        ]);
    }

    public function deleteUser(int $id)
    {
        \Gate::authorize('delete');

        $user = User::findOrFail($id);

        $this->dialog()->confirm([
            'icon' => 'error',
            'title' => __('Delete User'),
            'description' => __('Are you sure you want to delete this user?'),
            'acceptLabel' => __('Delete'),
            'method' => 'actuallyDeleteUser',
            'params' => $id,
        ]);
    }

    public function actuallyDeleteUser(int $id)
    {
        try {
            \Gate::authorize('delete');

            $user = User::findOrFail($id);

            $user->delete();

            $this->notification()->success(__('User deleted successfully.'));
        } catch (\Exception $e) {
            report($e);

            $this->notification()->error(__('There was an error deleting the user.'));
        }
    }

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setColumnSelectStatus(false)
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(10)
            ->setDefaultSort('name', 'asc')
            ->setEmptyMessage(__('No users found'))
            ->setConfigurableAreas([
                'toolbar-right-end' => 'components.users.add-user',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('Email'), 'email')
                ->sortable()
                ->searchable(),
            Column::make(__('Role'), 'role')
                ->sortable()
                ->format(fn ($value, User $row, Column $column) => $row->role_name),
            Column::make('Updated at', 'updated_at')
                ->sortable()
                ->format(fn ($value, User $row, Column $column) => $row->updated_at->ago()),
            ComponentColumn::make(__('Actions'), 'id')
                ->component('users.actions')
                ->attributes(fn ($value, User $row, Column $column) => [
                    'user' => $row,
                ]),
        ];
    }
}
