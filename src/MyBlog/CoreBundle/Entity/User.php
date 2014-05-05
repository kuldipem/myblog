<?php

namespace MyBlog\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="MyBlog\CoreBundle\Repository\UserRepository")
 * 
 */
class User extends BaseUser {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBasicInfo",  mappedBy="user" )
     */
    private $basicInfo;
    
    /**
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="user", cascade={"persist", "remove"} )
     */
    private $blogs;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"persist", "remove"} )
     */
    private $comments;
    
    /**
     * @ORM\OneToMany(targetEntity="Like", mappedBy="user", cascade={"persist", "remove"} )
     */
    private $likes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    public function __construct() {
        parent::__construct();
    }


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set basicInfo
     *
     * @param \MyBlog\CoreBundle\Entity\UserBasicInfo $basicInfo
     * @return User
     */
    public function setBasicInfo(\MyBlog\CoreBundle\Entity\UserBasicInfo $basicInfo = null)
    {
        $this->basicInfo = $basicInfo;

        return $this;
    }

    /**
     * Get basicInfo
     *
     * @return \MyBlog\CoreBundle\Entity\UserBasicInfo 
     */
    public function getBasicInfo()
    {
        return $this->basicInfo;
    }

    /**
     * Add blogs
     *
     * @param \MyBlog\CoreBundle\Entity\Blog $blogs
     * @return User
     */
    public function addBlog(\MyBlog\CoreBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;

        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \MyBlog\CoreBundle\Entity\Blog $blogs
     */
    public function removeBlog(\MyBlog\CoreBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    /**
     * Add comments
     *
     * @param \MyBlog\CoreBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\MyBlog\CoreBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \MyBlog\CoreBundle\Entity\Comment $comments
     */
    public function removeComment(\MyBlog\CoreBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add likes
     *
     * @param \MyBlog\CoreBundle\Entity\Like $likes
     * @return User
     */
    public function addLike(\MyBlog\CoreBundle\Entity\Like $likes)
    {
        $this->likes[] = $likes;

        return $this;
    }

    /**
     * Remove likes
     *
     * @param \MyBlog\CoreBundle\Entity\Like $likes
     */
    public function removeLike(\MyBlog\CoreBundle\Entity\Like $likes)
    {
        $this->likes->removeElement($likes);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLikes()
    {
        return $this->likes;
    }
}
