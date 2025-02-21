<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class EventOccurrenceModel extends Model
{
    protected $table = 'event_occurrences';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'event_id',
        'occurrence_date',
        'location',
        'image'
    ];

    /**
     * Get all EventOccurences, join with associated Event.
     * @return array
     */
    public function getEventOccurencesWithEvent()
    {
        $builder = $this->builder();

        $builder
            ->select('event_occurrences.*, events.slug as event_slug, events.id as event_id')
            ->join('events', 'events.id = event_occurrences.event_id');

        return  $builder->get()->getResultArray();
    }
}
