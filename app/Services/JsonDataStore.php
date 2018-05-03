<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Factory as FileSystemFactoryContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class JsonDataStore
{
    /**
     * @var FileSystemFactoryContract
     */
    protected $fileSystem;

    protected $dir = 'json-store';

    public function __construct(FileSystemFactoryContract $fileSystem)
    {
        $this->fileSystem = $fileSystem->disk('local');
    }

    public function get($file): array
    {
        $filePath = $this->toPath($file);

        if (!$this->fileSystem->exists($filePath)) {
            return [];
        }

        $contents = $this->fileSystem->get($filePath);

        if (!$contents) {
            return [];
        }

        return json_decode($contents, true);
    }

    public function put($file, array $data)
    {
        $data = array_values($data);
        $contents = json_encode($data);
        $filePath = $this->toPath($file);
        return $this->fileSystem->put($filePath, $contents);
    }

    public function find($file, $id)
    {
        $data = $this->get($file);

        foreach ($data as $index => $row) {
            if ($row['id'] == $id) {
                return $row;
            }
        }
    }

    public function create($file, array $row)
    {
        $current = $this->get($file);
        $current[] = $row;

        $this->put($file, $current);
        return $row;
    }

    public function update($file, $id, array $updatedRow)
    {
        $data = $this->get($file);
        $updated = false;
        foreach ($data as $index => $row) {
            if ($row['id'] == $id) {
                $updated = array_merge($row, $updatedRow);
                $data[$index] = $updated;
                break;
            }
        }

        if (!$updated) {
            throw new NotFoundHttpException();
        }

        $this->put($file, $data);

        return $updated;
    }

    public function delete($file, $id)
    {
        $data = $this->get($file);
        $deleted = false;
        foreach ($data as $index => $row) {
            if ($row['id'] == $id) {
                $deleted = $data[$index];
                unset($data[$index]);
                break;
            }
        }

        $this->put($file, $data);

        return $deleted;
    }


    private function toPath($filename): string
    {
        return $this->dir . '/' . $filename . '.json';
    }
}
