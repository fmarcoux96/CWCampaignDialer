<?php

namespace App\Livewire;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CallAttempt;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use WireUi\Traits\Actions;

class CallAttemptsTable extends DataTableComponent
{
    use Actions;

    public Campaign $campaign;

    protected $model = CallAttempt::class;

    protected string $tableName = 'calls-table';

    protected $listeners = [
        'reload' => '$refresh',
    ];

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setColumnSelectStatus(false)
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(25)
            ->setDefaultSort('call_attempts.created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make(__('Entry ID'), "entry.entry_id")
                ->sortable()
                ->searchable(),
            Column::make(__('Number'), "entry.entry_phone_number")
                ->sortable()
                ->searchable(),
            Column::make(__('Call ID'), "call_id")
                ->sortable(),
            Column::make(__('Start'), "call_attempt_start")
                ->sortable()
                ->format(fn ($value, CallAttempt $row, Column $column) => $row->call_attempt_start->toDayDateTimeString()),
            Column::make(__('End'), "call_attempt_end")
                ->sortable()
                ->format(fn ($value, CallAttempt $row, Column $column) => $row->call_attempt_end?->toDayDateTimeString() ?? __('N/A')),
            BooleanColumn::make(__('Successful'), "successful")
                ->sortable(),
            Column::make(__('Updated'), "updated_at")
                ->sortable()
                ->format(fn ($value, CallAttempt $row, Column $column) => $row->updated_at->ago()),
        ];
    }

    public function builder(): Builder
    {
        return CallAttempt::query()
            ->whereHas('entry', function (Builder $query) {
                $query->where('campaign_id', $this->campaign->id);
            });
    }
}
