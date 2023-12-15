<?php

namespace App\Services\Importer;

class ImportRecipesFromJson extends ImporterClass
{
    public function import($filename) : void
    {
        $data = json_decode($this->getFileData($filename), true);
        $this->pushToDb($data);
    }
}

