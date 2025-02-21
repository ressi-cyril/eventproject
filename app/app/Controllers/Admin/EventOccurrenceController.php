<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\EventOccurrenceService;
use App\Services\EventService;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class EventOccurrenceController
 *
 * Admin controller for managing event occurrences.
 * It delegates business logic to the EventOccurrenceService.
 */
class EventOccurrenceController extends BaseController
{
    protected EventOccurrenceService $occurrenceService;
    protected EventService $eventService;

    public function __construct()
    {
        $this->occurrenceService = new EventOccurrenceService();
        $this->eventService = new EventService();
    }

    /**
     * Displays a list of all event occurrences.
     *
     * @return string
     */
    public function index(): string
    {
        $data['occurrences'] = $this->occurrenceService->getAllOccurrences();
        return view('admin/event_occurrences/index', $data);
    }

    /**
     * Displays all occurrences for the given event ID
     */
    public function listByEvent(int $eventId): string
    {
        $data['occurrences'] = $this->occurrenceService->getOccurrencesByEventId($eventId);
        $data['eventId'] = $eventId;

        return view('admin/event_occurrences/list_by_event', $data);
    }


    /**
     * Displays the form for creating an event occurrence or processes the creation.
     * @param int $eventId attached Event
     * @return ResponseInterface|string
     */
    public function create(int $eventId = null): ResponseInterface|string
    {
        // Form is submit
        if ($this->request->getMethod() === 'POST') {
            $id = $this->occurrenceService->createOccurrenceForEvent($this->request->getPost(), $eventId, $this->request->getFile('image'));

            if ($id !== null) {
                return redirect()->to('/admin/event-occurrences/by-event/' . $eventId)
                    ->with('success', 'Occurrence created successfully.');
            }

            return redirect()->back()->withInput()
                ->with('error', 'Failed to create occurrence.');
        }

        $data['eventIdParam'] = $eventId;
        $data['eventId'] = $eventId;

        return view('admin/event_occurrences/create', $data);
    }

    /**
     * Displays the form for editing an event occurrence and processes the update.
     * Uses HTTP PATCH method for updates.
     *
     * @param int $id The ID of the occurrence.
     * @return ResponseInterface|string
     */
    public function edit(int $id): ResponseInterface|string
    {
        $occurrence = $this->occurrenceService->getOccurrenceById($id);

        if ($occurrence === null) {
            return redirect()->to('/admin/event-occurrences')
                ->with('error', 'Occurrence not found.');
        }

        // Form is submit
        if ($this->request->getMethod() === 'PATCH') {
            $result = $this->occurrenceService->updateOccurrence($id, $this->request->getPost(), $this->request->getFile('image'));
            if ($result) {
                return redirect()->to('/admin/event-occurrences/by-occurrence/' . $id)
                    ->with('success', 'Occurrence updated successfully.');
            }
            return redirect()->back()->withInput()
                ->with('error', 'Failed to update occurrence.');
        }

        $data['occurrence'] = $occurrence;

        return view('admin/event_occurrences/edit', $data);
    }

    /**
     * Deletes an event occurrence.
     *
     * @param int $id The ID of the occurrence to delete.
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        if ($this->occurrenceService->deleteOccurrence($id)) {
            return redirect()->to('/admin/event-occurrences')
                ->with('success', 'Occurrence deleted successfully.');
        }
        
        return redirect()->to('/admin/event-occurrences')
            ->with('error', 'Failed to delete occurrence.');
    }
}
