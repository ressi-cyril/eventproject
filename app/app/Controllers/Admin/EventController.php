<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\EventService;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class EventController
 * Admin controller for managing Event.
 * It delegates business logic to the EventService.
 */
class EventController extends BaseController
{
    protected EventService $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    /**
     * Displays a list of all Event.
     * @return string
     */
    public function index(): string
    {
        $data['events'] = $this->eventService->getAllEvents();
        return view('admin/events/index', $data);
    }

    /**
     * Displays the form for creating an Event or processes the creation.
     * @return ResponseInterface|string
     */
    public function create(): ResponseInterface|string
    {
        // Form is submit
        if ($this->request->getMethod() === 'POST') {
            $result = $this->eventService->createEvent($this->request->getPost());
            if ($result !== null) {
                return redirect()->to('/admin/events')->with('success', 'Event created successfully.');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to create event.');
        }

        return view('admin/events/create');
    }

    /**
     * Displays the form for editing an Event and processes the update.
     * Uses HTTP PATCH method for updates.
     * 
     * @param int $id
     * @return ResponseInterface|string
     */
    public function edit(int $id): ResponseInterface|string
    {
        $event = $this->eventService->getEventById($id);
        if ($event === null) {
            return redirect()->to('/admin/events')->with('error', 'Event not found.');
        }

        // Form is submit
        if ($this->request->getMethod() === 'PATCH') {
            $result = $this->eventService->updateEvent($id, $this->request->getPost());
            if ($result) {
                return redirect()->to('/admin/events')->with('success', 'Event updated successfully.');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update event.');
        }

        $data['event'] = $event;
        return view('admin/events/edit', $data);
    }

    /**
     * Delete an event.
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        if ($this->eventService->deleteEvent($id)) {
            return redirect()->to('/admin/events')->with('success', 'Event deleted successfully.');
        }
        return redirect()->to('/admin/events')->with('error', 'Failed to delete event.');
    }
}
