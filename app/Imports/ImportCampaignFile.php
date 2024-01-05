<?php

namespace App\Imports;

use App\Models\Campaign;
use App\Models\CampaignEntry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCampaignFile implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function __construct(private readonly Campaign $campaign)
    {
        //
    }

    public function model(array $row)
    {
        if ($row['number'] === null) {
            return null;
        }

        return new CampaignEntry([
            'campaign_id' => $this->campaign->id,
            'entry_id' => $row['id'] ?? null,
            'entry_name' => $row['name'] ?? null,
            'entry_phone_number' => $this->formatPhoneNumber($row['number']) ?? null,
            'entry_source' => $row['source'] ?? null,
            'entry_notes' => $row['notes'] ?? null,
            'entry_created_at' => $row['created_at'] ?? null,
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

    private function formatPhoneNumber(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        // Remove all characters except digits from the value
        return preg_replace('/[^0-9]/', '', $value);
    }
}
