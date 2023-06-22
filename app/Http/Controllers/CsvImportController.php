<?php

namespace App\Http\Controllers;

use App\Jobs\CsvImportJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CsvImportController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function import(Request $request): RedirectResponse|null
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->store('csv-imports');

            // Kiểm tra validate file sai định dạng
//            if (!$this->isValidCsvFile($path)) {
//                Storage::delete($path);
//                return back()->with('error', 'File không đúng định dạng CSV.');
//            }

            // Dispatch job để xử lý import CSV
            dispatch(new CsvImportJob($path));

            return back()->with('success', 'File CSV đã được import thành công.');
        }
    }

    /**
     * @param $path
     * @return bool
     */
    private function isValidCsvFile($path): bool
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $path);
        finfo_close($fileInfo);

        return $mimeType === 'text/csv';
    }
}
