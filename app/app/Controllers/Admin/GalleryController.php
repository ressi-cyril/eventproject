<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Services\GalleryService;
use App\Controllers\BaseController;
use App\Services\EventService;
use CodeIgniter\HTTP\ResponseInterface;

class GalleryController extends BaseController
{
    private GalleryService $galleryService;
    private EventService $eventService;

    public function __construct()
    {
        $this->galleryService = new GalleryService();
        $this->eventService = new EventService();
    }

    /**
     * Display gallery for a given event.
     *
     * @param int $eventId
     * @return string
     */
    public function getGalleryEvent(int $eventId): string
    {
        $gallery = $this->galleryService->getGalleryByEvent($eventId);
        $data['gallery'] = $gallery;
        $data['eventId'] = $eventId;
        return view('admin/gallery/detail', $data);
    }

    /**
     * Display gallery for a given occurrence.
     *
     * @param int $occurrenceId
     * @return string
     */
    public function getGalleryOccurrence(int $occurrenceId): string
    {
        $gallery = $this->galleryService->getGalleryByOccurrence($occurrenceId);
        $data['gallery'] = $gallery;
        $data['occurrenceId'] = $occurrenceId;
        return view('admin/gallery/detail', $data);
    }

    /**
     *
     * @param int $eventId
     * @param int $occurenceId
     * @return ResponseInterface|string
     */
    public function create(int $eventId, int $occurenceId): ResponseInterface|string
    {
        if ($this->request->getMethod() === 'POST') {

            $result = $this->galleryService->createGallery($this->request->getPost(), $this->request->getFiles() ?? []);

            if ($result) {
                return redirect()->to("/admin/events")->with('success', 'Gallery images added successfully.');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to add gallery images.');
        }

        if ($eventId > 0) {
            $event = $this->eventService->getEventById($eventId);
            $data['eventSlug'] = $event['slug'] ?? '';            
            $data['eventId'] = $eventId;
        } else {
            $data['eventSlug'] = '';
        }
        
        $data['occurenceId'] = $occurenceId;

        return view('admin/gallery/create', $data);
    }
}