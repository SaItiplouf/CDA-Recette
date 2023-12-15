<?php

namespace App\Services\Importer;

use App\Repositories\RecipesRepository;
use Exception;
use RuntimeException;

abstract class ImporterClass {

    public function __construct(private RecipesRepository $recipesRepository) {}
    abstract public function import($filename): void;

    protected function getFileData(string $filename): false|string
    {
        return file_get_contents($filename);
    }

    protected function pushToDb(array $data): void {
        try {
            foreach ($data['recipes'] as $recipeData) {
                $this->recipesRepository->persist($recipeData);
            }
        } catch (Exception $e) {
            throw new RuntimeException($e);
        }
    }
}
