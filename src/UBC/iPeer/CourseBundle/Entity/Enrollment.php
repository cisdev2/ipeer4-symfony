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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
