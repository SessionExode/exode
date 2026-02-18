<?php

namespace Exode\Events;

class Event {
    public string $id;
    public string $title;
    public string $content;
    public int $startDate;
    public int $endDate;
    public string $location;

    public function __construct(string $title, string $content, int $startDate, int $endDate, string $location) {
        $this->id = uniqid();
        $this->title = $title;
        $this->content = $content;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->location = $location;
    }
}
