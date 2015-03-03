<?php

namespace UBC\iPeer\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseGroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="UBC\iPeer\CourseBundle\Entity\CourseGroupRepository")
 */
class CourseGroup
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
