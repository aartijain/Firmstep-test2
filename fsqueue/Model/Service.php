<?php

/**
 * Service data model
 * Database table: services
 */
namespace Queue\Model;
use Queue\Model\ModelAbstract;

class Service extends ModelAbstract
{
    protected $id;
    protected $name;

    /**
     * statuses
     * 1 - Enabled
     * 2 - Disabled
     */
    protected $status;
   
    /**
     * Set Id
     * @param int $id id
     * @return $this
     */
    public function setId($id)
    {
        $id = (int) $id;

        if (!$id || !is_int($id)) {
            throw new \InvalidArgumentException('ID cannot be empty and only accepts integers.');
        }

        $this->id = $id;

        return $this;
    }

    /**
     * Get Id
     * @return int id
     */
    public function getId()
    {
        if (!$this->id || !is_int($this->id)) {
            throw new \InvalidArgumentException('ID cannot be empty and only accepts integers.');
        }

        return $this->id;
    }

    /**
     * Set Name
     * @param string $name Name
     * @return $this
     */
    public function setName($name)
    {
        if (!$name || !is_string($name)) {
            throw new \InvalidArgumentException('Name can not be empty and must be string.');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     * @return string Name
     */
    public function getName()
    {
        if (!$this->name || !is_string($this->name)) {
            throw new \InvalidArgumentException('Name can not be empty and must be string.');
        }

        return $this->name;
    }
    
    /**
     * Set Status
     * @param int Status
     * @return $this
     */
    public function setStatus($status)
    {
        $status = (int) $status;

        if ($status < 1) {
            throw new \InvalidArgumentException('Status can not be empty and only accepts integers.');
        }

        $this->status = $status;
        return $this;
    }

    /**
     * Get Status
     * @return int Status
     */
    public function getStatus()
    {
        if ($this->status && !is_int($this->status)) {
            throw new \InvalidArgumentException('Status only accepts integers.');
        }

        return $this->status;
    }

}