<?php

namespace UBC\iPeer\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="UBC\iPeer\CourseBundle\Entity\CourseRepository")
 */
class Course
{
    /**
     * @var integer
     *
     * Unique id for the course
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * Name of the course
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     *
     *
     * @ORM\OneToMany(targetEntity="Enrollment", mappedBy="course")
     *
     */
    private $enrollments;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="CourseGroup", mappedBy="course")
     */
    private $courseGroups;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enrollments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add enrollments
     *
     * @param \UBC\iPeer\CourseBundle\Entity\Enrollment $enrollments
     * @return Course
     */
    public function addEnrollment(\UBC\iPeer\CourseBundle\Entity\Enrollment $enrollments)
    {
        $this->enrollments[] = $enrollments;

        return $this;
    }

    /**
     * Remove enrollments
     *
     * @param \UBC\iPeer\CourseBundle\Entity\Enrollment $enrollments
     */
    public function removeEnrollment(\UBC\iPeer\CourseBundle\Entity\Enrollment $enrollments)
    {
        $this->enrollments->removeElement($enrollments);
    }

    /**
     * Get enrollments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEnrollments()
    {
        return $this->enrollments;
    }

    /**
     * Add courseGroups
     *
     * @param \UBC\iPeer\CourseBundle\Entity\CourseGroup $courseGroups
     * @return Course
     */
    public function addCourseGroup(\UBC\iPeer\CourseBundle\Entity\CourseGroup $courseGroups)
    {
        $this->courseGroups[] = $courseGroups;

        return $this;
    }

    /**
     * Remove courseGroups
     *
     * @param \UBC\iPeer\CourseBundle\Entity\CourseGroup $courseGroups
     */
    public function removeCourseGroup(\UBC\iPeer\CourseBundle\Entity\CourseGroup $courseGroups)
    {
        $this->courseGroups->removeElement($courseGroups);
    }

    /**
     * Get courseGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourseGroups()
    {
        return $this->courseGroups;
    }
}
