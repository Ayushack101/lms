<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class TestQuestionsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    protected $testTemplateId;

    public function __construct($testTemplateId)
    {
        $this->testTemplateId = $testTemplateId;
    }

  

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            if (empty($row['question'])) {
                continue;
            }

            Question::create([
                'test_template_id' => $this->testTemplateId,
                'question' => $row['question'],
                'a' => $row['a'] ?? null,
                'b' => $row['b'] ?? null,
                'c' => $row['c'] ?? null,
                'd' => $row['d'] ?? null,
                'answer' => $row['answer'] ?? null,
                'marks' => $row['marks'] ?? 1,
            ]);
        }
    }
}
