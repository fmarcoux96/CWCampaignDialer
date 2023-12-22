<?php

namespace App\Livewire;

use App\Models\Campaign;
use App\Models\CampaignEntry;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;
use WireUi\Traits\Actions;

class CampaignEntriesTable extends DataTableComponent
{
    use Actions;

    public Campaign $campaign;

    protected $model = CampaignEntry::class;

    protected string $tableName = 'entries-table';

    protected $listeners = [
        'reload' => '$refresh',
    ];

    public function editEntry(int $id)
    {
        \Gate::authorize('edit');

        $entry = CampaignEntry::findOrFail($id);

        $this->dispatch('openModal', 'campaigns.entry-form', [
            'campaign' => $entry->campaign_id,
            'entry' => $entry->id,
        ]);
    }

    public function deleteEntry(int $id)
    {
        \Gate::authorize('delete');

        $entry = CampaignEntry::findOrFail($id);

        $this->dialog()->confirm([
            'icon' => 'error',
            'title' => __('Delete Entry'),
            'description' => __('Are you sure you want to delete this entry?'),
            'acceptLabel' => __('Delete'),
            'method' => 'actuallyDeleteEntry',
            'params' => $id,
        ]);
    }

    public function actuallyDeleteEntry(int $id)
    {
        try {
            \Gate::authorize('delete');

            $entry = CampaignEntry::findOrFail($id);

            $entry->delete();

            $this->notification()->success(__('Entry deleted successfully.'));
        } catch (\Exception $e) {
            report($e);

            $this->notification()->error(__('There was an error deleting the entry.'));
        }
    }

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setColumnSelectStatus(false)
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(25)
            ->setDefaultSort('created_at', 'asc')
            ->setEmptyMessage(__('No entries found'))
            ->setConfigurableAreas([
                'toolbar-right-end' => 'components.campaigns.add-entry',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'entry_id')
                ->sortable(),
            Column::make(__('Name'), 'entry_name')
                ->sortable()
                ->searchable(),
            Column::make(__('Phone'), 'entry_phone_number')
                ->sortable()
                ->searchable(),
            Column::make(__('Source'), 'entry_source')
                ->sortable()
                ->searchable(),
            /*Column::make(__('Destination'), "entry_destination")
                ->sortable()
                ->searchable(),*/
            Column::make(__('Notes'), 'entry_notes')
                ->sortable()
                ->searchable(),
            Column::make(__('Attempts'), 'id')
                ->sortable()
                ->searchable()
                ->format(fn ($value, CampaignEntry $row, Column $column) => $row->calls_count),
            Column::make(__('Created'), 'created_at')
                ->sortable()
                ->format(fn ($value, CampaignEntry $row, Column $column) => $row->created_at->ago()),
            Column::make(__('Updated'), 'updated_at')
                ->sortable()
                ->format(fn ($value, CampaignEntry $row, Column $column) => $row->updated_at->ago()),
            ComponentColumn::make(__('Actions'), 'id')
                ->component('campaigns.entry-actions')
                ->attributes(fn ($value, CampaignEntry $row, Column $column) => [
                    'entry' => $row,
                ]),
        ];
    }

    public function builder(): Builder
    {
        return CampaignEntry::query()
            ->where('campaign_id', $this->campaign->id);
    }
}
