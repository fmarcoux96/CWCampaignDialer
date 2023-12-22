<?php

namespace App\Livewire;

use App\Models\Campaign;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;
use WireUi\Traits\Actions;

class CampaignsTable extends DataTableComponent
{
    use Actions;

    protected $model = Campaign::class;

    protected string $tableName = 'campaigns-table';

    protected $listeners = [
        'reload' => '$refresh',
    ];

    public function editCampaign(int $id)
    {
        \Gate::authorize('edit');

        $campaign = Campaign::findOrFail($id);

        $this->dispatch('openModal', 'campaigns.upload-form', [
            'campaign' => $campaign->id,
        ]);
    }

    public function deleteCampaign(int $id)
    {
        \Gate::authorize('delete');

        $campaign = Campaign::findOrFail($id);

        $this->dialog()->confirm([
            'icon' => 'error',
            'title' => __('Delete Campaign'),
            'description' => __('Are you sure you want to delete this campaign?'),
            'acceptLabel' => __('Delete'),
            'method' => 'actuallyDeleteCampaign',
            'params' => $id,
        ]);
    }

    public function actuallyDeleteCampaign(int $id)
    {
        try {
            \Gate::authorize('delete');

            $campaign = Campaign::findOrFail($id);

            $campaign->delete();

            $this->notification()->success(__('Campaign deleted successfully.'));
        } catch (\Exception $e) {
            report($e);

            $this->notification()->error(__('There was an error deleting the campaign.'));
        }
    }

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setColumnSelectStatus(false)
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(10)
            ->setDefaultSort('campaign_name', 'asc')
            ->setTableRowUrl(fn (Campaign $row) => route('campaigns.show', $row))
            ->setEmptyMessage(__('No campaigns found'))
            ->setConfigurableAreas([
                'toolbar-right-end' => 'components.campaigns.add-campaign',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'campaign_name')
                ->sortable()
                ->searchable(fn ($builder, $term) => $builder
                    ->orWhere('campaign_name', 'like', "%{$term}%")
                    ->orWhere('campaign_description', 'like', "%{$term}%"))
                ->format(fn ($value, Campaign $row, Column $column) => $row->campaign_name.'<br/><small>'.$row->campaign_description.'</small>')
                ->html(),
            Column::make(__('Start Date'), 'start_date')
                ->sortable()
                ->searchable()
                ->format(fn ($value, Campaign $row, Column $column) => $row->start_date->toFormattedDayDateString()),
            Column::make(__('End Date'), 'end_date')
                ->sortable()
                ->searchable()
                ->format(fn ($value, Campaign $row, Column $column) => $row->end_date?->toFormattedDayDateString() ?? __('N/A')),
            BooleanColumn::make(__('Active'), 'active')
                ->sortable(),
            BooleanColumn::make(__('Processed'), 'campaign_file_processed')
                ->sortable(),
            Column::make(__('Created'), 'created_at')
                ->sortable()
                ->format(fn ($value, Campaign $row, Column $column) => $row->created_at->ago()),
            Column::make(__('Updated'), 'updated_at')
                ->sortable()
                ->format(fn ($value, Campaign $row, Column $column) => $row->updated_at->ago()),
            ComponentColumn::make(__('Actions'), 'id')
                ->component('campaigns.actions')
                ->attributes(fn ($value, Campaign $row, Column $column) => [
                    'campaign' => $row,
                ])
                ->unclickable(),
        ];
    }
}
