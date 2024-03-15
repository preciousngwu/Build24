<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterSheet;

class LessonImports implements ToCollection, WithHeadingRow, WithEvents
{
    use Importable, RegistersEventListeners;

    public $event;
    public $sheets = [];
    public function __construct(array $event)
    {
        $this->event = $event;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => $this->event,
        ];
    }

    // public $rows = [];
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            foreach ($row as $key => $each) {
                if (gettype($key) == "string") {
                    $this->sheets[$key][] = $each ?? "";
                }
            }
        }
    }
}
