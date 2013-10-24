<?php

namespace Ramesh\BlogBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Ramesh\BlogBundle\Repository\PostRepository")
 */
class Post {
	
	/**
     * @MongoDB\Id
     */
	protected $id;
	
	/**
     * @MongoDB\String
     */
	protected $title;
	
	/**
     * @MongoDB\String
     */
	protected $body;
	
	/**
     * @MongoDB\Date
     */
	protected $createdAt;
	
	/**
	 * /** @MongoDB\ReferenceOne(targetDocument="User",inversedBy="posts") 
	 */
	protected $user; 


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Get body
     *
     * @return string $body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param Ramesh\BlogBundle\Document\User $user
     * @return self
     */
    public function setUser(\Ramesh\BlogBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return Ramesh\BlogBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
}
