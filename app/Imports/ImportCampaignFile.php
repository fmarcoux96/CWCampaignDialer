<?php

namespace App\Imports;

use App\Models\Campaign;
use App\Models\CampaignEntry;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportCampaignFile implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public function __construct(private readonly Campaign $campaign)
    {
        //
    }

    public function model(array $row)
    {
        return new CampaignEntry([
            'campaign_id' => $this->campaign->id,
            'entry_id' => $row['id'],
            'entry_name' => $row['name'],
            'entry_phone_number' => $this->formatPhoneNumber($row['number']),
            'entry_source' => $row['source'],
            'entry_notes' => $row['notes'],
            'entry_created_at' => $row['created_at'],
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }


    public function chunkSize(): int
    {
        return 100;
    }

    private function formatPhoneNumber(string $value): string
    {
        // Remove all characters except digits from the value
        return preg_replace('/[^0-9]/', '', $value);
    }
}
