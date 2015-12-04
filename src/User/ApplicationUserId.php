<?php
namespace MessageApp\User;

use Rhumsaa\Uuid\Uuid;

class ApplicationUserId
{
    /**
     * @var string
     */
    private $id;

    /**
     * Constructor
     *
     * @param string $id
     */
    public function __construct($id = null)
    {
        $this->id = (string) (($id) ?  $id : Uuid::uuid4());
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}
