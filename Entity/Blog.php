<?php


namespace CPANA\BasicBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CPANA\BasicBlogBundle\Entity\Repository\BlogRepository")
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks()
 */
class Blog
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
	 * 
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
	 * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
     */
    protected $author;

    /**
     * @ORM\Column(type="text")
	 * @Assert\NotBlank()
     */
    protected $blog;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="text")
	 * @Assert\NotBlank()
     */
    protected $tags;

    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    protected $comments;

    
    
    public function __construct()
 {
        $this->comments = new ArrayCollection();

        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
 }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
* 
* 
     * Get id
     *
     * @return integer 
     
*/
    public function getId()    
    {
        return $this->id;
    
    }

    /**
* 
* 
     * Set title
     *
     * @param  string $title
     * @return Blog
     
*/
    public function setTitle($title)    
    {
        $this->title = $title;

        return $this;
    
    }

    /**
* 
* 
     * Get title
     *
     * @return string 
     
*/
    public function getTitle()    
    {
        return $this->title;
    
    }

    /**
* 
* 
     * Set author
     *
     * @param  string $author
     * @return Blog
     
*/
    public function setAuthor($author)    
    {
        $this->author = $author;

        return $this;
    
    }

    /**
* 
* 
     * Get author
     *
     * @return string 
     
*/
    public function getAuthor()    
    {
        return $this->author;
    
    }

    /**
* 
* 
     * Set blog
     *
     * @param  string $blog
     * @return Blog
     
*/
    public function setBlog($blog)    
    {
        $this->blog = $blog;

        return $this;
    
    }

    /**
* 
* 
     * Get blog
     *
     * @return string 
     
*/
    public function getBlog($length = null)
    {
        if (false === is_null($length) && $length > 0) {
            return substr($this->blog, 0, $length); 
        }
        else {
            return $this->blog; 
        }
    }

    /**
* 
* 
     * Set image
     *
     * @param  string $image
     * @return Blog
     
*/
    public function setImage($image)    
    {
        $this->image = $image;

        return $this;
    
    }

    /**
* 
* 
     * Get image
     *
     * @return string 
     
*/
    public function getImage()    
    {
        return $this->image;
    
    }

    /**
* 
* 
     * Set tags
     *
     * @param  string $tags
     * @return Blog
     
*/
    public function setTags($tags)    
    {
        $this->tags = $tags;

        return $this;
    
    }

    /**
* 
* 
     * Get tags
     *
     * @return string 
     
*/
    public function getTags()    
    {
        return $this->tags;
    
    }

    /**
* 
* 
     * Set created
     *
     * @param  \DateTime $created
     * @return Blog
     
*/
    public function setCreated($created)    
    {
        $this->created = $created;

        return $this;
    
    }

    /**
* 
* 
     * Get created
     *
     * @return \DateTime 
     
*/
    public function getCreated()    
    {
        return $this->created;
    
    }

    /**
* 
* 
     * Set updated
     *
     * @param  \DateTime $updated
     * @return Blog
     
*/
    public function setUpdated($updated)    
    {
        $this->updated = $updated;

        return $this;
    
    }

    /**
* 
* 
     * Get updated
     *
     * @return \DateTime 
     
*/
    public function getUpdated()    
    {
        return $this->updated;
    
    }

    /**
* 
* 
     * Remove comments
     *
     * @param \CPANA\BasicBlogBundle\Entity\Comment $comments
     
*/
    public function removeComment(\CPANA\BasicBlogBundle\Entity\Comment $comments)    
    {
        $this->comments->removeElement($comments);
    
    }

    /**
* 
* 
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     
*/
    public function getComments()    
    {
        return $this->comments;
    
    }
    
        public function __toString()
        {
               return strval($this->id);
        }

}
