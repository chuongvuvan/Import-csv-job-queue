<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CsvImportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public string $filePath;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        DB::beginTransaction();

        try {
            $file = fopen($this->filePath, 'r');
            $data = [];

            while (($line = fgetcsv($file)) !== false) {
                // Kiểm tra dữ liệu rỗng
                if ($this->isEmptyRow($line)) {
                    dd($line);
                } else {
                    // Kiểm tra dữ liệu trùng lặp
                    if ($this->isDuplicateData($line)) {
                        // Xử lý dữ liệu trùng lặp
                        // ...
                    } else {
                        // Xử lý dữ liệu từng hàng
                        // ...
                        DB::table('m_groups')->insert($line);
                    }
                }

                $data[] = $line;
            }

            Log::info($data);
            DB::table('m_groups')->insert($data);

            fclose($file);

            // Xử lý dữ liệu đã được import
            // ...

            // Hoàn thành transaction
            DB::commit();
        } catch (\Exception $e) {
            // Xảy ra lỗi trong quá trình import
            // Hủy bỏ transaction
            dd($e);
            DB::rollback();
        }
    }

    private function isEmptyRow($row)
    {
        // Kiểm tra logic để xác định hàng có dữ liệu rỗng hay không
        // Trong trường hợp này, ví dụ kiểm tra nếu tất cả các cột đều trống
        foreach ($row as $cell) {
            if (!empty($cell)) {
                return false;
            }
        }

        return true;
    }

    private function isDuplicateData($row)
    {
        // Kiểm tra logic để xác định dữ liệu trùng lặp
        // ...

        return false;
    }
}
