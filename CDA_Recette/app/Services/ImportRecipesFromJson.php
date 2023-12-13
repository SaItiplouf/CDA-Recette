<?php

namespace App\Services;


class ImportRecipesFromJson extends ImporterFromFile
{
    public function import($filename) : void
    {
        $data = json_decode($this->getFileData($filename), true);
        $this->pushToDb($data);
    }
}

