<?php

use Spatie\Flash\Flash;
use Spatie\Flash\Message;

/**
 * @param array|string $text
 * @param array|string $class
 */
function flash($text = null, $class = null): Flash
{
    /** @var \Spatie\Flash\Flash $flash */
    $flash = app(Flash::class);

    if (null === $text) {
        return $flash;
    }

    $message = new Message($text, $class);

    $flash->flash($message);

    return $flash;
}
