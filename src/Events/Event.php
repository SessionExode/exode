<?php

namespace Exode\Events;

use DateTimeImmutable;

class Event {
    public string $id;
    public string $title;
    public DateTimeImmutable $start;
    public DateTimeImmutable $end;
    public string $content;
    public string $location;

    public function __construct(string $title, string $content, string $day, string $start_time, string $end_time, string $location) {
        $this->id = uniqid();
        $this->title = $title;
        $this->content = $content;

        $tz = wp_timezone();
        $this->start = new DateTimeImmutable("$day $start_time", $tz);
        $this->end = new DateTimeImmutable("$day $end_time", $tz);

        $this->location = $location;
    }
}
