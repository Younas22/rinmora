<?php

namespace App\Exceptions;

use Exception;

class CheckoutUnavailableItemsException extends Exception
{
    /**
     * @param array<int, array<string, mixed>> $items
     */
    public function __construct(public array $items)
    {
        parent::__construct('Some items in your cart are no longer available.');
    }
}
