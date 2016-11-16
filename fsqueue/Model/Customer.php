<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Queue\Model;
use Queue\Model\ModelAbstract;

class Customer extends ModelAbstract {
    protected $id;
    protected $title;
    protected $firstName;
    protected $lastName;
    protected $organisationName;
    protected $dateArrived;
    protected $serviceId;
    protected $typeId;
    
    protected $serviceName;
    protected $typeName;
    
    /**
     * Set Id
     * @param int $id id
     * @return $this
     */
    public function setId($id)
    {
        $id = (int) $id;

        if ($id < 1) {
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
        if ($this->id && !is_int($this->id)) {
            throw new \InvalidArgumentException('ID only accepts integers.');
        }

        return $this->id;
    }

    /**
     * @param string $title Title
     * @return $this
     */
    public function setTitle($title)
    {
        if (!is_null($title) && !is_string($title)) {
            throw new \InvalidArgumentException('Title can not be empty and must be string.');
        }

        $this->title = $title;
        return $this;
    }

    /**
     * @return string Title
     */
    public function getTitle()
    {
        if (!is_null($this->title) && !is_string($this->title)) {
            throw new \InvalidArgumentException('Title can not be empty and must be string.');
        }

        return $this->title;
    }
    
    /**
     * @param string $firstName FirstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        if (!is_null($firstName) && !is_string($firstName)) {
            throw new \InvalidArgumentException('First name can not be empty and must be string.');
        }

        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string FirstName
     */
    public function getFirstName()
    {
        if (!is_null($this->firstName) && !is_string($this->firstName)) {
            throw new \InvalidArgumentException('first name can not be empty and must be string.');
        }

        return $this->firstName;
    }

    /**
     * @param string $lastName LastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        if (!is_null($lastName) && !is_string($lastName)) {
            throw new \InvalidArgumentException('Last name can not be empty and must be string.');
        }

        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string LastName
     */
    public function getLastName()
    {
        if (!is_null($this->lastName) && !is_string($this->lastName)) {
            throw new \InvalidArgumentException('Last name can not be empty and must be string.');
        }

        return $this->lastName;
    }

     /**
     * @param string $lastName LastName
     * @return $this
     */
    public function setOrganisationName($organisationName)
    {
        if (!is_null($organisationName) && !is_string($organisationName)) {
            throw new \InvalidArgumentException('Organisation name can not be empty and must be string.');
        }

        $this->organisationName = $organisationName;
        return $this;
    }

    /**
     * @return string OrganisationName
     */
    public function getOrganisationName()
    {
        if (!is_null($this->organisationName) && !is_string($this->organisationName)) {
            throw new \InvalidArgumentException('organisation name can not be empty and must be string.');
        }

        return $this->organisationName;
    }

    /**
     * @param string $dateArrived Date Arrived
     * @return $this
     */
    public function setDateArrived($dateArrived)
    {
        $date = new \DateTime($dateArrived);

        $this->dateArrived = $date;
        return $this;
    }

    /**
     * @param string $format Date Format
     * @return string Date Arrived
     */
    public function getDateArrived($format = 'Y-m-d H:i:s')
    {
        if (!$this->dateArrived instanceof \DateTime) {
            throw new \InvalidArgumentException('Date posted has to be instance of Datetime');
        }

        return $this->dateArrived->format($format);
    }

    /**
     * Set Service Id
     * @param int $serviceId serviceId
     * @return $this
     */
    public function setServiceId($serviceId)
    {
        $serviceId = (int) $serviceId;

        if ($serviceId < 1) {
            throw new \InvalidArgumentException('Service Id cannot be empty and only accepts integers.');
        }

        $this->serviceId = $serviceId;
        return $this;
    }

    /**
     * Get Service Id
     * @return int serviceId
     */
    public function getServiceId()
    {
        if ($this->serviceId && !is_int($this->serviceId)) {
            throw new \InvalidArgumentException('Service Id only accepts integers.');
        }

        return $this->serviceId;
    }
    
    /**
     * Set Service Id
     * @param int $serviceId serviceId
     * @return $this
     */
    public function setTypeId($typeId)
    {
        $typeId = (int) $typeId;

        if ($typeId < 1) {
            throw new \InvalidArgumentException('Type Id cannot be empty and only accepts integers.');
        }

        $this->typeId = $typeId;
        return $this;
    }

    /**
     * Get typeid
     * @return int typeId
     */
    public function getTypeId()
    {
        if ($this->typeId && !is_int($this->typeId)) {
            throw new \InvalidArgumentException('Type Id only accepts integers.');
        }

        return $this->typeId;
    }
     /**
     * @param string $serviceName serviceName
     * @return $this
     */
    public function setServiceName($serviceName)
    {
        if (!is_null($serviceName) && !is_string($serviceName)) {
            throw new \InvalidArgumentException('Servicename name can not be empty and must be string.');
        }

        $this->serviceName = $serviceName;
        return $this;
    }

     /**
     * @return string ServiceName
     */
    public function getServiceName()
    {
        if (!is_null($this->serviceName) && !is_string($this->serviceName)) {
            throw new \InvalidArgumentException('Service name can not be empty and must be string.');
        }

        return $this->serviceName;
    }

    
     /**
     * @param string $typeName typeName
     * @return $this
     */
    public function setTypeName($typeName)
    {
        if (!is_null($typeName) && !is_string($typeName)) {
            throw new \InvalidArgumentException('Type name must be string.');
        }

        $this->typeName = $typeName;
        return $this;
    }
    /**
     * @return string TypeName
     */
    public function getTypeName()
    {
        if (!is_null($this->typeName) && !is_string($this->typeName)) {
            throw new \InvalidArgumentException('Type name can not be empty and must be string.');
        }

        return $this->typeName;
    }
    

   
} 
