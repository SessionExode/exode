<?php

namespace Exode\Announcements;

class Announcement {
    public string $id;
    public string $title;
    public string $content;
    public int $date;

    public function __construct(string $title, string $content, int $date) {
        $this->id = uniqid();
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
    }
}
