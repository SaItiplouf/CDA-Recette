<?php

namespace App\Services\Importer;
use Illuminate\Support\Facades\File;

class ImportFileFactory
{

    public function chooseImportService(string $filename)
    {
        if (File::exists($filename)) {
            $extension = File::extension($filename);
            $importerClassName = config("importer.$extension");
            if($importerClassName) {
                return app($importerClassName);
            } else {
                throw new \InvalidArgumentException("Unsupported file extension: $extension");
            }
        } else {
            throw new \InvalidArgumentException("File not found: $filename");
        }
    }
}


