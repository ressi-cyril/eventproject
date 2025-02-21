<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EventModel;
use App\Models\EventOccurrenceModel;
use App\Services\FileService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\Files\UploadedFile;
use Exception;

/**
 * Class EventOccurrenceService
 *
 * This service handles the business logic for managing event occurrences.
 * It encapsulates operations for retrieving, creating, updating, and deleting occurrences.
 */
class EventOccurrenceService
{
    private EventOccurrenceModel $occurrenceModel;
    private EventModel $eventModel;
    private ValidationService $validationService;
    private FileService $fileService;

    public function __construct()
    {
        $this->occurrenceModel = new EventOccurrenceModel();
        $this->eventModel = new EventModel();
        $this->validationService = new ValidationService();
        $this->fileService = new FileService();
    }

    /**
     * Retrieves all event occurrences.
     *
     * @return array List of all event occurrences.
     */
    public function getAllOccurrences(): array
    {
        return $this->occurrenceModel->getEventOccurencesWithEvent();
    }

    /**
     * Retrieve occurences from given event Id
     * @param int $id
     * @return array
     */
    public function getOccurrencesByEventId(int $eventId): array
    {
        return $this->occurrenceModel
            ->where('event_id', $eventId)
            ->findAll();
    }

    /**
     * Retrieves a single event occurrence by its ID.
     *
     * @param int $id The ID of the occurrence.
     * @return array|null Returns the occurrence data as an associative array, or null if not found.
     */
    public function getOccurrenceById(int $id): ?array
    {
        return $this->occurrenceModel->find($id);
    }

    /**
     * Creates a new event occurrence using the provided data.
     *
     * @param array $datas Data from the form submission.
     * @param ?UploadedFile $image uploaded
     * @return int|null Returns the ID of the newly created occurrence, or null if creation failed.
     */
    public function createOccurrenceForEvent(array $datas, int $eventId, ?UploadedFile $image = null): ?int
    {
        $event = $this->eventModel->find($eventId);

        if (null === $event) {
            throw new Exception('Event with id: ' . $eventId . ' not found', 404);
        }

        // Prepare the Occurence data from the input array 
        $occurrenceData = $this->prepareOccurenceData($datas);

        // Upload given image
        $imageName = $this->fileService->uploadFile($image, FCPATH  . 'uploads/event_occurrences/');
        $occurrenceData['image'] = $imageName;

        // Validate the data for a create operation
        $this->validateDatas($occurrenceData);

        if ($this->occurrenceModel->insert($occurrenceData)) {
            return (int) $this->occurrenceModel->insertID();
        }

        return null;
    }

    /**
     * Updates an existing event occurrence with the given data.
     *
     * @param int $id The ID of the occurrence to update.
     * @param array $datas Data from the form submission.
     * @param ?UploadedFile $image uploaded
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function updateOccurrence(int $id, array $datas, ?UploadedFile $image = null): bool
    {
        $existingOccurence = $this->occurrenceModel->find($id);

        if (!$existingOccurence) {
            throw new Exception('existingOccurence with id: ' . $id . ' not found', 404);
        }

        // Prepare the event data from the input array 
        $occurrenceData = $this->prepareOccurenceData($datas);


        // Upload image if changed
        $imageName = $this->fileService->uploadFile($image, FCPATH  . 'uploads/event_occurrences/');
        if(null !== $imageName) {
            $occurrenceData['image'] = $imageName;
        }

        // Validate the data for a create operation
        $this->validateDatas($occurrenceData, true);

        return $this->occurrenceModel->update($id, $occurrenceData);
    }

    /**
     * Deletes an event occurrence by its ID.
     *
     * @param int $id The ID of the occurrence to delete.
     * @return bool Returns true if deletion was successful, false otherwise.
     */
    public function deleteOccurrence(int $id): bool
    {
        $occurrence = $this->occurrenceModel->find($id);
        if ($occurrence) {
            $targetDir = FCPATH . 'uploads/event_occurrences/';
            $this->fileService->deleteFile($targetDir, $occurrence['image']);
        }

        return $this->occurrenceModel->delete($id);
    }

    /**
     * Prepares the Occurence data array for creating or updating an occurence.
     *
     * @param array $datas The raw input data.
     * @return array The formatted event data ready to be inserted or updated.
     */
    private function prepareOccurenceData(array $datas): array
    {
        return [
            'event_id' =>     $datas['event_id'] ?? null,
            'occurrence_date' => $datas['occurrence_date'] ?? null,
            'location'        => $datas['location'] ?? null,
        ];
    }

    /**
     * Validates the Occurence data.
     *
     * @param array $datas The Occurence data.
     * @param bool|null $updating Indicates if the operation is an update.
     * @return void
     */
    private function validateDatas(array $datas, ?bool $updating = false): void
    {
        $validationRules = [
            'event_id'         => 'required|integer',
            'occurrence_date'  => 'required|valid_date',
            'location'         => 'required|max_length[20]',
            'image'            => 'required|max_length[100]',
        ];

        // Image is not required on update
        if ($updating) {
            $validationRules['image'] = 'max_length[100]';
        }

        $this->validationService->validate($datas, $validationRules);
    }
}
