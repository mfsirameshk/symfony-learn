<?php

namespace Ramesh\BlogBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Ramesh\BlogBundle\Document\Group;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass="Ramesh\BlogBundle\Repository\UserRepository")
 */
class User implements UserInterface {

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\String
     */
    protected $password;

    /**
     * @MongoDB\String
     */
    protected $email;
    
    /**
     * @MongoDB\String
     */
    protected $username;
    
    /**
     * @MongoDB\String
     */
    protected $salt;

    /**
     * @MongoDB\int
     */
    protected $age;

    /**
     * @MongoDB\String
     */
    protected $country;

    /**
     * @MongoDB\String
     */
    protected $currency;

    /**
     * @MongoDB\String
     */
    protected $gender;

    /**
     * @MongoDB\Date
     */
    protected $dob;
    
    /**
     * @MongoDB\Date
     */
    protected $ccExp;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Group")
     */
    protected $group;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Post", mappedBy="user") 
     */
    protected $posts;

    /**
     * @MongoDB\String
     */
    protected $imagePath;

    /**
     * @MongoDB\String
     */
    protected $favorite;
    
    /**
     * @MongoDB\String
     */
    protected $lastLogin;
    
     /**
     * @MongoDB\int
     */
    protected $totalLogins;
    
    protected $file;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Get name
     *
     * @return string $name
     */
    public function getSalt() {
        return $this->salt;
    }
    
    /**
     * Get name
     *
     * @return string $name
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set age
     *
     * @param int $age
     * @return self
     */
    public function setAge($age) {
        $this->age = $age;
        return $this;
    }

    /**
     * Get age
     *
     * @return int $age
     */
    public function getAge() {
        return $this->age;
    }

    public function __construct() {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add post
     *
     * @param Ramesh\BlogBundle\Document\Post $post
     */
    public function addPost(\Ramesh\BlogBundle\Document\Post $post) {
        $this->posts[] = $post;
    }

    /**
     * Remove post
     *
     * @param Ramesh\BlogBundle\Document\Post $post
     */
    public function removePost(\Ramesh\BlogBundle\Document\Post $post) {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection $posts
     */
    public function getPosts() {
        return $this->posts;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return self
     */
    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return self
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Get currency
     *
     * @return string $currency
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * Set dob
     *
     * @param date $dob
     * @return self
     */
    public function setDob($dob) {
        $this->dob = $dob;
        return $this;
    }

    /**
     * Get dob
     *
     * @return date $dob
     */
    public function getDob() {
        return $this->dob;
    }

    /**
     * Set group
     *
     * @param Ramesh\BlogBundle\Document\Group $group
     * @return self
     */
    public function setGroup(\Ramesh\BlogBundle\Document\Group $group) {
        $this->group = $group;
        return $this;
    }

    /**
     * Get group
     *
     * @return Ramesh\BlogBundle\Document\Group $group
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     * @return self
     */
    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string $imagePath
     */
    public function getImagePath() {
        return $this->imagePath;
    }

    public function getAbsoluteImagePath() {
        return null === $this->imagePath ? null : $this->getUploadRootDir() . '/' . $this->imagePath;
    }

    public function getWebImagePath() {
        return null === $this->imagePath ? null : $this->getUploadDir() . '/' . $this->imagePath;
    }

    protected function getUploadRootDir() {
// the absolute directory path where uploaded
// documents should be saved
        return '/var/www/Symfony/web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
// get rid of the __DIR__ so it doesn't screw up
// when displaying uploaded doc/image in the view.
        return 'uploads/user/images/';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * function to generate a unique file name
     * @param string $name
     * @return string
     */
    public function generateFileName($name) {
        return uniqid('profile', true) . $name;
    }

    /**
     * Function handle user image uploading
     */
    public function uploadImage() {

        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        $saveToFile = $this->generateFileName($this->getFile()->getClientOriginalName());
        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(), $saveToFile
        );
        // set the path property to the filename where you've saved the file
        $this->setImagePath($saveToFile);

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * Set favorite
     *
     * @param string $favorite
     * @return self
     */
    public function setFavorite($favorite) {
        $this->favorite = $favorite;
        return $this;
    }

    /**
     * Get favorite
     *
     * @return string $favorite
     */
    public function getFavorite() {
        return $this->favorite;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return self
     */
    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    /**
     * Get gender
     *
     * @return string $gender
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize() {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list (
            $this->id,
            ) = unserialize($serialized);
    }


    /**
     * Set lastLogin
     *
     * @param string $lastLogin
     * @return self
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return string $lastLogin
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set totalLogins
     *
     * @param int $totalLogins
     * @return self
     */
    public function setTotalLogins($totalLogins)
    {
        $this->totalLogins = $totalLogins;
        return $this;
    }

    /**
     * Get totalLogins
     *
     * @return int $totalLogins
     */
    public function getTotalLogins()
    {
        return empty($this->totalLogins) ? 0 : $this->totalLogins;
    }

    /**
     * Set ccExp
     *
     * @param date $ccExp
     * @return self
     */
    public function setCcExp($ccExp)
    {
        $this->ccExp = $ccExp;
        return $this;
    }

    /**
     * Get ccExp
     *
     * @return date $ccExp
     */
    public function getCcExp()
    {
        return $this->ccExp;
    }
}
