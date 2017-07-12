<?php

namespace Room\HotelBundle\DTO;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * HotelRoom
 *
 *
 * 
 */
class HotelRoomDto
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     */
    private $roomType;
   
    /**
     * @var string
     *
     * 
     */
    private $capacity;
   
    /**
     * @var float
     *
     *
     */
    private $price;

    /**
     * @var string
     *
     * 
     */
    private $imagePath;

    
    /**
     * @var string
     *
     * 
     */
    private $maxAdult;
    
    /**
     * @var string
     *
     * 
     */
    private $maxChild;
    
    public function __construct() {
    	$this->images = new ArrayCollection();
    	$this->amenities = new ArrayCollection();
    	$this->hotelRoom = new ArrayCollection();
    }
	
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
	

    
}