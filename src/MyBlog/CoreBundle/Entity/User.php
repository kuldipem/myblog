<?php

namespace MyBlog\CoreBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="MyBlog\CoreBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email is already taken.")
 * @UniqueEntity(fields="username", message="Username is already used.")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements AdvancedUserInterface, Serializable, EquatableInterface {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @NotBlank(message="Username can't be blank.")
     * 
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @NotBlank(message="Email is blank.")
     * @Email(message="Email is not valid.", checkMX=false, checkHost=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @NotBlank(message="Password is blank.");
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     * @ORM\Column(name="roles", type="array" )
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

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
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->roles = array('ROLE_USER');
    }

    public function __toString() {
        return $this->getUsername();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set basicInfo
     *
     * @param \MyBlog\CoreBundle\Entity\UserBasicInfo $basicInfo
     * @return User
     */
    public function setBasicInfo(\MyBlog\CoreBundle\Entity\UserBasicInfo $basicInfo = null) {
        $this->basicInfo = $basicInfo;

        return $this;
    }

    /**
     * Get basicInfo
     *
     * @return \MyBlog\CoreBundle\Entity\UserBasicInfo 
     */
    public function getBasicInfo() {
        return $this->basicInfo;
    }

    /**
     * Add blogs
     *
     * @param \MyBlog\CoreBundle\Entity\Blog $blogs
     * @return User
     */
    public function addBlog(\MyBlog\CoreBundle\Entity\Blog $blogs) {
        $this->blogs[] = $blogs;

        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \MyBlog\CoreBundle\Entity\Blog $blogs
     */
    public function removeBlog(\MyBlog\CoreBundle\Entity\Blog $blogs) {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs() {
        return $this->blogs;
    }

    /**
     * Add comments
     *
     * @param \MyBlog\CoreBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\MyBlog\CoreBundle\Entity\Comment $comments) {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \MyBlog\CoreBundle\Entity\Comment $comments
     */
    public function removeComment(\MyBlog\CoreBundle\Entity\Comment $comments) {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Add likes
     *
     * @param \MyBlog\CoreBundle\Entity\Like $likes
     * @return User
     */
    public function addLike(\MyBlog\CoreBundle\Entity\Like $likes) {
        $this->likes[] = $likes;

        return $this;
    }

    /**
     * Remove likes
     *
     * @param \MyBlog\CoreBundle\Entity\Like $likes
     */
    public function removeLike(\MyBlog\CoreBundle\Entity\Like $likes) {
        $this->likes->removeElement($likes);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLikes() {
        return $this->likes;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getUsername() {
        return $this->username;
    }

    public function isAccountNonExpired() {
        return true;
    }

    public function isAccountNonLocked() {
        return true;
    }

    public function isCredentialsNonExpired() {
        return true;
    }

    public function isEnabled() {
        return $this->isActive;
    }

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->salt,
            $this->password,
        ));
    }

    public function unserialize($serialized) {
        list (
                $this->id,
                $this->username,
                $this->salt,
                $this->password,
                ) = unserialize($serialized);
    }

    public function getPassword() {
        
    }

    public function isEqualTo(UserInterface $user) {
        
    }


    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
