<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\GalleryModel;
use App\Services\FileService;
use App\Services\ValidationService;

/**
 * Class Gallerieservice
 *
 * This service handles the business logic for managing Galleries.
 * It encapsulates operations for retrieving, creating, updating, and deleting Galleries.
 */
class GalleryService
{
    private GalleryModel $galleryModel;
    private ValidationService $validationService;
    private FileService $fileService;

    /**
     * Gallerieservice constructor.
     */
    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
        $this->validationService = new ValidationService();
        $this->fileService = new FileService();
    }

    public function getAllGalleries()
    {
        return $this->galleryModel->findAll();
    }

    /**
     * Returns the gallery record for a given event ID (and occurrence_id is null).
     *
     * @param int $eventId
     * @return array|null
     */
    public function getGalleryByEvent(int $eventId): ?array
    {
        return $this->galleryModel
            ->where('event_id', $eventId)
            ->where('occurrence_id', null)
            ->first();
    }

    /**
     * Returns the gallery record for a given occurrence ID.
     *
     * @param int $occurrenceId
     * @return array|null
     */
    public function getGalleryByOccurrence(int $occurrenceId): ?array
    {
        return $this->galleryModel
            ->where('occurrence_id', $occurrenceId)
            ->first();
    }

    /**
     * Creates a new Gallery using the provided data.
     *
     * @param array $datas Data from the form submission.
     * @param array $images
     * @return int|null Returns the ID of the newly created Gallery, or null if creation failed.
     */
    public function createGallery(array $datas, array $images): ?int
    {
        // Prepare the Gallery data from the input array    
        $galleryData = $this->prepareGalleryData($datas);

        $imageNames = [];
        foreach ($images['images'] as $image) {
            $imageName = $this->fileService->uploadFile($image, FCPATH  . 'uploads/gallery/');
            if (!empty($imageName)) {
                $imageNames[] = $imageName;
            }
        }

        $galleryData['images'] = json_encode($imageNames);

        // Validate the data for a create operation (updating flag is false)
        $this->validateDatas($galleryData);

        if ($this->galleryModel->insert($galleryData)) {
            return (int) $this->galleryModel->insertID();
        }

        return null;
    }

    /**
     * Updates an existing Gallery with the given data.
     *
     * Only updates the slug and short URL if the new generated values differ
     * from those already stored.
     *
     * @param int $id The Gallery to update.
     * @param array $datas Data from the form submission.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function updateGallery(int $id, array $datas): bool
    {
        //todo
        return false;
    }

    /**
     * Deletes an Gallery by its ID.
     *
     * @param int $id The ID of the Gallery to delete.
     * @return bool Returns true if deletion was successful, false otherwise.
     */
    public function deleteGallery(int $id): bool
    {
        //todo
        return $this->galleryModel->delete($id);
    }

    /**
     * Prepares the Gallery data array for creating or updating an Gallery.
     *
     * @param array $datas The raw input data.
     * @return array The formatted Gallery data ready to be inserted or updated.
     */
    private function prepareGalleryData(array $datas): array
    {
        if ((int) $datas['occurrence_id'] === 0) {
            $datas['occurrence_id'] = null;
        }

        if ((int) $datas['event_id'] === 0) {
            $datas['event_id'] = null;
        }

        return [
            'event_id'       =>  $datas['event_id'] ?? null,
            'occurrence_id'  =>  $datas['occurrence_id'] ?? null,
            'images'         =>  $datas['images'] ?? null,
            'gallery_type'   => $datas['gallery_type'] ?? '',
        ];
    }

    /**
     * Validates the Gallery data.
     *
     * @param array $datas The Gallery data.
     * @return void
     */
    private function validateDatas(array $datas): void
    {
        $validationRules = [
            'event_id'          => 'max_length[255]',
            'occurrence_id'     => 'max_length[255]',
            'gallery_type'      => 'required|max_length[255]',
            'images'            => 'required|max_length[1000]',
        ];

        $this->validationService->validate($datas, $validationRules);
    }
}
