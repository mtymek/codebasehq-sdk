<?php

namespace CodebaseHq\Entity;

use DateTime;

class Ticket
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $summary;

    /**
     * @var string
     */
    protected $ticketType;

    /**
     * @var int
     */
    protected $reporterId;

    /**
     * @var string
     */
    protected $reporter;

    /**
     * @var int
     */
    protected $assigneeId;

    /**
     * @var string
     */
    protected $assignee;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Priority
     */
    protected $priority;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var Milestone
     */
    protected $milestone;

    /**
     * @var ?
     */
    protected $deadline;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var ?
     */
    protected $estimatedTime;

    /**
     * @var int
     */
    protected $projectId;
	
	/**
     * @var string
     */
    protected $tags;

    /**
     * @param string $assignee
     * @return Ticket provides fluent interface
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
        return $this;
    }

    /**
     * @return string
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param int $assigneeId
     * @return Ticket provides fluent interface
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
     * @param \CodebaseHq\Entity\Category $category
     * @return Ticket provides fluent interface
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return \CodebaseHq\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param DateTime $createdAt
     * @return Ticket provides fluent interface
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param  $deadline
     * @return Ticket provides fluent interface
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
        return $this;
    }

    /**
     * @return
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param  $estimatedTime
     * @return Ticket provides fluent interface
     */
    public function setEstimatedTime($estimatedTime)
    {
        $this->estimatedTime = $estimatedTime;
        return $this;
    }

    /**
     * @return
     */
    public function getEstimatedTime()
    {
        return $this->estimatedTime;
    }

    /**
     * @param int $id
     * @return Ticket provides fluent interface
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
     * @param \CodebaseHq\Entity\Milestone $milestone
     * @return Ticket provides fluent interface
     */
    public function setMilestone($milestone)
    {
        $this->milestone = $milestone;
        return $this;
    }

    /**
     * @return \CodebaseHq\Entity\Milestone
     */
    public function getMilestone()
    {
        return $this->milestone;
    }

    /**
     * @param \CodebaseHq\Entity\Priority $priority
     * @return Ticket provides fluent interface
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return \CodebaseHq\Entity\Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $projectId
     * @return Ticket provides fluent interface
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
        return $this;
    }

    /**
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param string $reporter
     * @return Ticket provides fluent interface
     */
    public function setReporter($reporter)
    {
        $this->reporter = $reporter;
        return $this;
    }

    /**
     * @return string
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param int $reporterId
     * @return Ticket provides fluent interface
     */
    public function setReporterId($reporterId)
    {
        $this->reporterId = $reporterId;
        return $this;
    }

    /**
     * @return int
     */
    public function getReporterId()
    {
        return $this->reporterId;
    }

    /**
     * @param \CodebaseHq\Entity\Status $status
     * @return Ticket provides fluent interface
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \CodebaseHq\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $summary
     * @return Ticket provides fluent interface
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
     * @param string $tags
     * @return Ticket provides fluent interface
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Ticket provides fluent interface
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $ticketType
     * @return Ticket provides fluent interface
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

}
