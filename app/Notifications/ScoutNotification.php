<?php

namespace App\Notifications;

interface ScoutNotification
{
    public function getName();

    public function getTitle();

    public function getBody();

    public function getType();
}
