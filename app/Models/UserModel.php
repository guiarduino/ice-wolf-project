<?php

namespace app\Models;

use Helpers\Validate;

final class UserModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function fillEntity(array $args)
    {
        $validations = [
            'name' => [
                'type' => 'string',
                'size' => 150,
                'nullable' => false
            ],
            'age' => [
                'type' => 'int',
                'nullable' => false
            ]
        ];

        Validate::validate($validations, $args);

        $this->setName($args['name'] ?? null);
        $this->setAge($args['age'] ?? null);
        $this->setCreatedAt(isset($args['created_at']) ? new \DateTime($args['created_at']) : null);
        $this->setUpdatedAt(isset($args['updated_at']) ? new \DateTime($args['updated_at']) : null);
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $age;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserModel
     */
    public function setName(string $name): UserModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return UserModel
     */
    public function setAge(int $age): UserModel
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     * @return UserModel
     */
    public function setCreatedAt(?\DateTime $created_at): UserModel
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     * @return UserModel
     */
    public function setUpdatedAt(?\DateTime $updated_at): UserModel
    {
        $this->updated_at = $updated_at;
        return $this;
    }

}