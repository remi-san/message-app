<?php

namespace MessageApp\User;

class NullApplicationUserId extends ApplicationUserId
{
    /**
     * NullApplicationUserId constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    /**
     * @inheritDoc
     */
    protected function generateId()
    {
        return null;
    }
}
