<?php

namespace Exode\Events;

use DateTimeImmutable;

class Event {
    private DateTimeImmutable $start;
    private ?DateTimeImmutable $end;

    /**
     * @param string $id Optional ID to preserve identity during updates.
     */
    function __construct(
        private string $title,
        private string $content,
        private string $location,
        string $day,
        string $start_time,
        ?string $end_time,
        private ?string $pageId,
        private ?string $id
    ) {
        $tz = wp_timezone();
        $this->start = new DateTimeImmutable("$day $start_time", $tz);
        $this->end = empty($end_time) ? null : new DateTimeImmutable("$day $end_time", $tz);

        $this->id = $id ?: uniqid();
    }

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
    }

    function getLocation() {
        return $this->location;
    }

    function getStart() {
        return $this->start;
    }

    function getEnd() {
        return $this->end;
    }
    function getPageId() {
        return $this->pageId;
    }
    function getId() {
        return $this->id;
    }
}
