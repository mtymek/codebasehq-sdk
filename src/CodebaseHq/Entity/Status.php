<?php

namespace CodebaseHq\Entity;

class Status
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $colour;

    /**
     * @var int
     */
    protected $order;

    /**
     * @var bool
     */
    protected $treatAsClosed;

    /**
     * @param string $colour
     * @return Status provides fluent interface
     */
    public function setColour($colour)
    {
        $this->colour = $colour;
        return $this;
    }

    /**
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * @param int $id
     * @return Status provides fluent interface
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Status provides fluent interface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $order
     * @return Status provides fluent interface
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param boolean $treatAsClosed
     * @return Status provides fluent interface
     */
    public function setTreatAsClosed($treatAsClosed)
    {
        $this->treatAsClosed = $treatAsClosed;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getTreatAsClosed()
    {
        return $this->treatAsClosed;
    }

}
