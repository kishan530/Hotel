<?php

namespace Room\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelRoom
 *
 * @ORM\Table(name="hotel_room")
 * @ORM\Entity
 */
class HotelRoom
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
     * @var string
     *
     * @ORM\Column(name="room_type", type="string", length=100)
     */
    private $roomType;
    
    /**
     * @var string
     *
     * @ORM\Column(name="capacity", type="string", length=100)
     */
    private $capacity;
    
    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    
    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=255)
     */
    private $imagePath;
    
    /**
     * @var string
     *
     * @ORM\Column(name="max_Adult", type="string", length=255)
     */
    private $maxAdult;
    
    /**
     * @var string
     *
     * @ORM\Column(name="max_Child", type="string", length=255)
     */
    private $maxChild;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=5000)
     */
    private $description;
   
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Room\HotelBundle\Entity\Hotel", inversedBy="images")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
     */
    protected $hotel;
	
	/**
	 *
	 * @return the integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 *
	 * @param
	 *        	$id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getRoomType() {
		return $this->roomType;
	}
	
	/**
	 *
	 * @param
	 *        	$roomType
	 */
	public function setRoomType($roomType) {
		$this->roomType = $roomType;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getCapacity() {
		return $this->capacity;
	}
	
	/**
	 *
	 * @param
	 *        	$capacity
	 */
	public function setCapacity($capacity) {
		$this->capacity = $capacity;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getPrice() {
		return $this->price;
	}
	
	/**
	 *
	 * @param
	 *        	$price
	 */
	public function setPrice($price) {
		$this->price = $price;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getImagePath() {
		return $this->imagePath;
	}
	
	/**
	 *
	 * @param
	 *        	$imagePath
	 */
	public function setImagePath($imagePath) {
		$this->imagePath = $imagePath;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getMaxAdult() {
		return $this->maxAdult;
	}
	
	/**
	 *
	 * @param
	 *        	$maxAdult
	 */
	public function setMaxAdult($maxAdult) {
		$this->maxAdult = $maxAdult;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getMaxChild() {
		return $this->maxChild;
	}
	
	/**
	 *
	 * @param
	 *        	$maxChild
	 */
	public function setMaxChild($maxChild) {
		$this->maxChild = $maxChild;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 *
	 * @param
	 *        	$description
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 *
	 * @param
	 *        	$name
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 *
	 * @return the unknown_type
	 */
	public function getHotel() {
		return $this->hotel;
	}
	
	/**
	 *
	 * @param unknown_type $hotel        	
	 */
	public function setHotel($hotel) {
		$this->hotel = $hotel;
		return $this;
	}
	
	
	
	
	
	
}
