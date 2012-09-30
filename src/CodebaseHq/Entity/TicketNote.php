<?php

namespace CodebaseHq\Entity;

class TicketNote
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $timeAdded;

    /**
     * @var array
     */
    protected $changes = array();

    /**
     * @var string
     */
    protected $summary;

    /**
     * @param int $assigneeId
     * @return TicketNote provides fluent interface
     */
    public function setAssigneeId($assigneeId)
    {
        $this->assigneeId = $assigneeId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAssigneeId()
    {
        return $this->assigneeId;
    }

    /**
     * @param string $content
     * @return TicketNote provides fluent interface
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param int $id
     * @return TicketNote provides fluent interface
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
     * @param string $summary
     * @return TicketNote provides fluent interface
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $timeAdded
     * @return TicketNote provides fluent interface
     */
    public function setTimeAdded($timeAdded)
    {
        $this->timeAdded = $timeAdded;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeAdded()
    {
        return $this->timeAdded;
    }

    /**
     * @param array $changes
     * @return TicketNote provides fluent interface
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;
        return $this;
    }

    /**
     * @return array
     */
    public function getChanges()
    {
        return $this->changes;
    }


}
