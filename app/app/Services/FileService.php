<?php

declare(strict_types=1);

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;

class FileService
{
    /**
     * Uploads the given file to the target directory and returns the new file name.
     *
     * @param UploadedFile $file The uploaded file instance.
     * @param string $targetDir The directory where the file should be stored.
     * @return ?string Returns the new file name if successful, or an empty string on failure.
     */
    public function uploadFile(UploadedFile $file, string $targetDir): ?string
    {
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0755, true)) {
                // Could not create the directory; handle error as needed.
                exit();
            }
        }
        
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move($targetDir, $newName);

            return $newName;
        }

        // If the file is not valid or has already been moved
        return null;
    }

     /**
     * Deletes a file from the target directory.
     *
     * @param string $targetDir The directory where the file is stored.
     * @param string $fileName The name of the file to delete.
     * @return bool Returns true if the file was successfully deleted, false otherwise.
     */
    public function deleteFile(string $targetDir, string $fileName): bool
    {        
        $filePath = $targetDir . $fileName;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}
