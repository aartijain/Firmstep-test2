<?php

namespace Queue\Model;

use Queue\ResultSet\ResultSetAbstract;
use Queue\Model\ModelException;

abstract class ModelAbstract
{
    public function __construct(array $data = array())
    {
        $this->exchangeArray($data);
    }
    
    
    public function __set($name, $value)
    {
        $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
        if (('mapper' === $name) || !in_array($method, get_class_methods($this))) {
            throw new ModelException('Invalid page property method :: ' . $method . ' does not Exist');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (('mapper' === $name) || !in_array($method, get_class_methods($this))) {
            throw new ModelException('Invalid page property method :: ' . $method . ' does not Exist');
        }
        return $this->$method();
    }

    public function exchangeArray(array $options)
    {
        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($this->removeUnderScore($key));
            if (in_array($method, $methods)) {
                if ($value) {
                    $this->$method($value);
                }
            }
        }
        return $this;
    }

    protected function removeUnderScore($column)
    {
        $colArray = explode("_", $column);

        $property = NULL;
        $numWords = count($colArray);
        for ($n = 0; $n < $numWords; $n++) {
            if ($n > 0) {
                $property .= ucwords($colArray[$n]);
            } else {
                $property .= $colArray[$n];
            }
        }
        return $property;
    }

    protected function convertToUnderScore(array $data)
    {
        $newData = array();
        foreach ($data as $key => $value) {
            $newKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));
            $newData[$newKey] = $value;
        }

        return $newData;
    }

    public function toArray()
    {
        $data = array();
        foreach ($this as $key => $property) {
            if ($property instanceof ModelAbstract || $property instanceof ResultSetAbstract) {
                if ($property instanceof ResultSetAbstract) {
                    $property->buffer();
                }
                $data[$key] = $property->toArray();
            } else {
                $method = 'get' . ucfirst($key);
                $data[$key] = $this->$method();
            }
        }
        return $data;
    }

    public function toDataTableArray()
    {
        $data = array();
        foreach ($this as $key => $property) {
            if ($property instanceof ModelAbstract) {
                $data[] = $property->toArray();
            } else {
                $method = 'get' . ucfirst($key);
                $data[] = $this->$method();
            }
        }
        return $data;
    }

    /**
     * Convert date string to given format
     * 
     * @param string $date Date string in one of known formats
     * @param string $format Requested return format
     * @return string Date string
     */
    public function convertDateFormat($date, $format = 'd/m/Y')
    {
        if (strstr($date, '/')) {
            $date = str_replace('/', '-', $date);
        }

        if ($this->isDateValid($date)) {
            $dateTime = new \DateTime($date);
            $formatDate = $dateTime->format($format);
        } else {
            $formatDate = '';
        }

        return $formatDate;
    }

    public function isDateValid($str)
    {
        if (!is_string($str)) {
            return false;
        }

        $stamp = strtotime($str);

        if (!is_numeric($stamp)) {
            return false;
        }

        if (checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp))) {
            return true;
        }
        return false;
    }

}
