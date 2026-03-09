<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportPdfAction
{
    public static function make(string $view, array $data = []): Action
    {
        return Action::make('exportPdf')
            ->label('Export PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(function () use ($view, $data) {
                $pdf = Pdf::loadView($view, $data);
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, 'laporan-' . date('Y-m-d') . '.pdf');
            });
    }
}
