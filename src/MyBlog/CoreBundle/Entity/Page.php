<?php

namespace MyBlog\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="MyBlog\CoreBundle\Repository\PageRepository")
 * @UniqueEntity(fields="name", message="Page name is already created.")
 */
class Page {

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
     * @ORM\Column(name="name", type="string", length=255)
     * @NotBlank(message="Page name shouldn't blank.")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="abstract", type="string", length=255)
     */
    private $abstract;

    /**
     * @ORM\Column(name="content", type="text" )
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="childPages" )
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $parentPage;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parentPage", cascade={"persist", "remove"} )
     */
    private $childPages;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    public function __construct() {
        $this->isActive = true;
        $this->childPages=new ArrayCollection();
    }
    
    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Page
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Page
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Page
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Page
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
     * @return Page
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
     * Set parentPage
     *
     * @param \MyBlog\CoreBundle\Entity\Page $parentPage
     * @return Page
     */
    public function setParentPage(\MyBlog\CoreBundle\Entity\Page $parentPage = null) {
        $this->parentPage = $parentPage;

        return $this;
    }

    /**
     * Get parentPage
     *
     * @return \MyBlog\CoreBundle\Entity\Page 
     */
    public function getParentPage() {
        return $this->parentPage;
    }

    /**
     * Add childPages
     *
     * @param \MyBlog\CoreBundle\Entity\Page $childPages
     * @return Page
     */
    public function addChildPage(\MyBlog\CoreBundle\Entity\Page $childPages) {
        $this->childPages[] = $childPages;

        return $this;
    }

    /**
     * Remove childPages
     *
     * @param \MyBlog\CoreBundle\Entity\Page $childPages
     */
    public function removeChildPage(\MyBlog\CoreBundle\Entity\Page $childPages) {
        $this->childPages->removeElement($childPages);
    }

    /**
     * Get childPages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildPages() {
        return $this->childPages;
    }


    /**
     * Set abstract
     *
     * @param string $abstract
     * @return Page
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string 
     */
    public function getAbstract()
    {
        return $this->abstract;
    }
}
