<?php

namespace App\Filament\Exports;

use App\Models\Member;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MemberExporter extends Exporter
{
    protected static ?string $model = Member::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')->label('Nama'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('birthdate')->label('Tanggal Lahir'),
            ExportColumn::make('religion_id')->label('Agama'),
            ExportColumn::make('ethnic_id')->label('Suku'),
            ExportColumn::make('address')->label('Alamat'),
            ExportColumn::make('institution_id')->label('Institusi'),
            ExportColumn::make('education_id')->label('Pendidikan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your member export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
