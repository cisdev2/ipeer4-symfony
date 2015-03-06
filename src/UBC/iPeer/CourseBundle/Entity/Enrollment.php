<?php

namespace UBC\iPeer\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enrollment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="UBC\iPeer\CourseBundle\Entity\EnrollmentRepository")
 */
class Enrollment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="enrollments")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @ORM\ManyToMany(targetEntity="CourseGroup", inversedBy="enrollments")
     * @ORM\JoinTable(name="enrollments_groups")
     */
    private $courseGroups;

    /**
     * @var \UBC\iPeer\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="UBC\iPeer\UserBundle\Entity\User", inversedBy="enrollments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     */
    private $role;



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
     * Set course
     *
     * @param Course $course
     * @return Enrollment
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set user
     *
     * @param \UBC\iPeer\UserBundle\Entity\User $user
     * @return Enrollment
     */
    public function setUser(\UBC\iPeer\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UBC\iPeer\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courseGroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add courseGroups
     *
     * @param \UBC\iPeer\CourseBundle\Entity\CourseGroup $courseGroups
     * @return Enrollment
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

    /**
     * Set role
     *
     * @param \UBC\iPeer\CourseBundle\Entity\Role $role
     * @return Enrollment
     */
    public function setRole(\UBC\iPeer\CourseBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \UBC\iPeer\CourseBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
}
