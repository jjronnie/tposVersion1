<?php

    function timezones()
    {
        $timezones = [];
        $identifiers = DateTimeZone::listIdentifiers();

        foreach ($identifiers as $identifier) {
            $tz = new DateTimeZone($identifier);
            $now = new DateTime('now', $tz);
            $offset = $now->format('P');
            $timezones[$identifier] = "(UTC{$offset}) {$identifier}";
        }

        return $timezones;
    }
