<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\EventModel;
use App\Services\ValidationService;

/**
 * Class EventService
 *
 * This service handles the business logic for managing events.
 * It encapsulates operations for retrieving, creating, updating, and deleting events.
 */
class EventService
{
    private EventModel $eventModel;
    private ValidationService $validationService;

    /**
     * EventService constructor.
     */
    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->validationService = new ValidationService();
    }

    /**
     * Retrieves all events.
     *
     * @return array List of all events.
     */
    public function getAllEvents(): array
    {
        return $this->eventModel->findAll();
    }

    /**
     * Retrieves a single event by its ID.
     *
     * @param int $id The ID of the event.
     * @return array|null Returns the event data as an associative array, or null if not found.
     */
    public function getEventById(int $id): ?array
    {
        return $this->eventModel->find($id);
    }

    /**
     * Creates a new event using the provided data.
     *
     * @param array $datas Data from the form submission.
     * @return int|null Returns the ID of the newly created event, or null if creation failed.
     */
    public function createEvent(array $datas): ?int
    {
        // Prepare the event data from the input array
        $eventData = $this->prepareEventData($datas);

        // Validate the data for a create operation (updating flag is false)
        $this->validateDatas($eventData);

        if ($this->eventModel->insert($eventData)) {
            return (int) $this->eventModel->insertID();
        }

        return null;
    }

    /**
     * Updates an existing event with the given data.
     *
     * Only updates the slug and short URL if the new generated values differ
     * from those already stored.
     *
     * @param int $id The event to update.
     * @param array $datas Data from the form submission.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function updateEvent(int $id, array $datas): bool
    {
        $existingEvent = $this->eventModel->find($id);

        if (!$existingEvent) {
            return false;
        }        

        // Prepare the event data from the input array        
        $eventData['id'] = $id;
        $eventData = $this->prepareEventData($datas);

        // Validate the data for update operation (updating flag is true)
        $this->validateDatas($eventData, true);

        return $this->eventModel->update($id, $eventData);
    }

    /**
     * Deletes an event by its ID.
     *
     * @param int $id The ID of the event to delete.
     * @return bool Returns true if deletion was successful, false otherwise.
     */
    public function deleteEvent(int $id): bool
    {
        return $this->eventModel->delete($id);
    }

    /**
     * Prepares the event data array for creating or updating an event.
     *
     * @param array $datas The raw input data.
     * @return array The formatted event data ready to be inserted or updated.
     */
    private function prepareEventData(array $datas): array
    {
        return [
            'name'                 => $datas['name'] ?? '',
            'description'          => $datas['description'] ?? '',
            'organizer_first_name' => $datas['organizer_first_name'] ?? '',
            'organizer_last_name'  => $datas['organizer_last_name'] ?? '',
            'organizer_phone'      => $datas['organizer_phone'] ?? '',
            'organizer_email'      => $datas['organizer_email'] ?? '',
            'slug'                 => $this->generateSlug($datas['name'], $datas['slug'] ?? null),
            'shorturl'             => $this->generateShorturl($datas['shorturl'] ?? null),
            'qrcode'               => $this->generateQRCode($datas['qrcode'] ?? ''),
            'social_links'         => $datas['social_links'] ?? '',
        ];
    }

    /**
     * Validates the event data.
     *
     * @param array $datas The event data.
     * @param bool|null $updating Indicates if the operation is an update.
     * @return void
     */
    private function validateDatas(array $datas, ?bool $updating = false): void
    {
        $validationRules = [
            'name'                 => 'required|max_length[255]',
            'organizer_first_name' => 'required|max_length[255]',
            'organizer_last_name'  => 'required|max_length[255]',
            'organizer_email'      => 'required|valid_email|max_length[255]',
            'slug'                 => 'required|alpha_dash|max_length[255]|is_unique[events.slug]',
            'shorturl'             => 'required|alpha_numeric|max_length[7]|is_unique[events.shorturl]',
            'qrcode'               => 'max_length[50]',
            'organizer_phone'      => 'permit_empty|exact_length[10]|numeric',
            'social_links'         => 'max_length[10]',
        ];

        // Adjust uniqueness rules for update operations
        if ($updating) {
            $validationRules['slug'] = "required|alpha_dash|max_length[255]|is_unique[events.slug,id,{$datas['id']}]";
            $validationRules['shorturl'] = "required|alpha_numeric|max_length[7]|is_unique[events.shorturl,id,{$datas['id']}]";
        }

        $this->validationService->validate($datas, $validationRules);
    }

    /**
     * Generates a slug for an event.
     *
     * If a custom slug is provided, it sanitizes it by replacing non-alphanumeric characters with hyphens
     * and returns it in lowercase. Otherwise, it generates a slug from the event name.
     *
     * @param string $name The event name.
     * @param string|null $customSlug Optional custom slug.
     * @return string The generated slug in lowercase.
     */
    private function generateSlug(string $name, ?string $customSlug = null): string
    {
        if (!empty($customSlug)) {
            return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $customSlug)));
        }
        
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    /**
     * Generates a unique short URL for an event.
     *
     * If a custom short URL is provided, it is returned directly.
     * Otherwise, a unique alphanumeric code of 7 characters is generated.
     *
     * @param string|null $customShortUrl Optional custom short URL.
     * @return string The unique short URL code.
     */
    private function generateShorturl(?string $customShortUrl = null): string
    {        
        if (!empty($customShortUrl)) {
            return $customShortUrl;
        }
        
        do {
            $code = substr(bin2hex(random_bytes(4)), 0, 7);
        } while ((bool) $this->eventModel->where('shorturl', $code)->first());

        return $code;
    }

    /**
     * Generates a QR code for an event.
     *
     * This method is a placeholder and should be replaced with a proper QR code generation logic.
     *
     * @param string|null $customQRCode Optional custom QR code.
     * @return string Returns the provided QR code if available, or a placeholder string.
     */
    private function generateQRCode(?string $customQRCode = null): string
    {
        if (!empty($customQRCode)) {
            return $customQRCode;
        }
        return 'QR_CODE_PLACEHOLDER';
    }
}
