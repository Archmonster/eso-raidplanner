<?php

/*
 * This file is part of the ESO Raidplanner project.
 * @copyright ESO Raidplanner.
 *
 * For the full license, see the license file distributed with this code.
 */

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $start;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string|null
     */
    private $description;

    /**
     * @ManyToOne(targetEntity="DiscordGuild", inversedBy="events")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var DiscordGuild
     */
    private $guild;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $locked;

    /**
     * @ORM\Column(type="json_array")
     * @var array
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="EventAttendee", mappedBy="event")
     * @var Collection|EventAttendee[]
     */
    private $attendees;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RecurringEvent")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $recurringParent;

    public function __construct()
    {
        $this->locked = false;
        $this->tags = [];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Event
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     * @return Event
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return DiscordGuild
     */
    public function getGuild()
    {
        return $this->guild;
    }

    /**
     * @param mixed $guild
     * @return Event
     */
    public function setGuild($guild)
    {
        $this->guild = $guild;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @param mixed $locked
     * @return Event
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     * @return Event
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return EventAttendee[]
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * @param int $roleId
     * @return Collection|EventAttendee[]
     */
    public function getAttendeesByRole(int $roleId): Collection
    {
        return $this->attendees->filter(static function (EventAttendee $attendee) use ($roleId) {
            return $attendee->getRole() === $roleId;
        });
    }

    /**
     * @param mixed $attendees
     * @return Event
     */
    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;

        return $this;
    }

    public function getRecurringParent(): ?RecurringEvent
    {
        return $this->recurringParent;
    }

    public function setRecurringParent(?RecurringEvent $recurringParent): self
    {
        $this->recurringParent = $recurringParent;

        return $this;
    }
}
