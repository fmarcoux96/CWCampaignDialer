<?php

namespace App\Livewire;

use App\Models\CallAttempt;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use WireUi\Traits\Actions;

class CallAttemptsTable extends DataTableComponent
{
    use Actions;

    public string $scope = 'campaign';

    public ?Campaign $campaign = null;

    public bool $slim = false;

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
            ->setEmptyMessage(__('No calls found'))
            ->setDefaultSort('call_attempts.created_at', 'desc');

        if ($this->slim) {
            $this
                ->setRefreshVisible()
                ->setPaginationStatus(false)
                ->setSearchStatus(false)
                ->setPerPageVisibilityStatus(false)
                ->setPaginationVisibilityStatus(false)
                ->setFooterStatus(false);
        }
    }

    public function columns(): array
    {
        return [
            Column::make(__('Campaign'), 'entry.campaign.campaign_name')
                ->sortable()
                ->searchable()
                ->hideIf($this->campaign != null),
            Column::make(__('Entry ID'), 'entry.entry_id')
                ->sortable()
                ->searchable(),
            Column::make(__('Number'), 'entry.entry_phone_number')
                ->sortable()
                ->searchable(),
            Column::make(__('Start'), 'call_attempt_start')
                ->sortable()
                ->format(fn ($value, CallAttempt $row, Column $column) => $row->call_attempt_start->toDayDateTimeString()),
            Column::make(__('End'), 'call_attempt_end')
                ->sortable()
                ->format(fn ($value, CallAttempt $row, Column $column) => $row->call_attempt_end?->toDayDateTimeString() ?? __('N/A')),
            BooleanColumn::make(__('Successful'), 'successful')
                ->sortable(),
            Column::make(__('Updated'), 'updated_at')
                ->sortable()
                ->format(fn ($value, CallAttempt $row, Column $column) => $row->updated_at->ago()),
        ];
    }

    public function builder(): Builder
    {
        return CallAttempt::query()
            ->when($this->campaign, fn (Builder $query) => $query->whereHas('entry', function (Builder $query) {
                $query->where('campaign_id', $this->campaign->id);
            }))
            ->when($this->scope == 'active', fn (Builder $query) => $query->whereNull('call_attempt_end'))
            ->when($this->scope == 'latest', fn (Builder $query) => $query->whereNotNull('call_attempt_end')->orderBy('call_attempts.created_at', 'desc')->limit(10));
    }
}
