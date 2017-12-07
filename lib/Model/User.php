<?php

namespace DCG\Cinema\Model;

class User
{
    private $id;
    private $firstName;
    private $surname;
    private $email;

    /**
     * @param string $id
     * @param string $firstName
     * @param string $surname
     * @param string $email
     */
    public function __construct(
        $id,
        $firstName,
        $surname,
        $email
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->email = $email;
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
