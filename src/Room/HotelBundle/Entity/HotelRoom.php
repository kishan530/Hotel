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
  	     * @var float
   	     *
   	     * @ORM\Column(name="rack_rate", type="float")
   	     */
   	    private $rackRate;
  	    /**
  	     * @var float
  	     *
   	     * @ORM\Column(name="weekly_price", type="float")
 	     */
       private $weeklyPrice;
  	    /**
   	     * @var float
   	     *
  	     * @ORM\Column(name="monthly_price", type="float")
      */
     private $monthlyPrice;
    
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
     * @var boolean
     *
     * @ORM\Column(name="sold_out", type="boolean")
     */
    private $soldOut;
    
    /**
     * @var string
     * @ORM\Column(name="block_start_date", type="date")
     */
    private $blockStartDate; 
    
    /**
     * @var string
     * @ORM\Column(name="block_end_date", type="date")
     */
     private $blockEndDate; 
     
     /**
      * @var integer
      *
      * @ORM\Column(name="sequence", type="integer")
      */
     private $sequence;
     
     /**
      * @var string
      * @ORM\Column(name="promotion_start_date", type="date")
      */
     private $promotionStartDate ;
     
     /**
      * @var string
      * @ORM\Column(name="promotion_end_date", type="date")
      */
     private $promotionEndDate;
     
     /**
      * @var float
      *
      * @ORM\Column(name="promotion_price", type="float")
      */
     private $promotionPrice;
     
     
    

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
	
	/**
	 *
	 * @return the boolean
	 */
	public function getSoldOut() {
		return $this->soldOut;
	}
	
	/**
	 *
	 * @param
	 *        	$soldOut
	 */
	public function setSoldOut($soldOut) {
		$this->soldOut = $soldOut;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getBlockStartDate() {
		return $this->blockStartDate;
	}
	
	/**
	 *
	 * @param
	 *        	$blockStartDate
	 */
	public function setBlockStartDate($blockStartDate) {
		$this->blockStartDate = $blockStartDate;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getBlockEndDate() {
		return $this->blockEndDate;
	}
	
	/**
	 *
	 * @param
	 *        	$blockEndDate
	 */
	public function setBlockEndDate($blockEndDate) {
		$this->blockEndDate = $blockEndDate;
		return $this;
	}
	
	/**
	 *
	 * @return the integer
	 */
	public function getSequence() {
		return $this->sequence;
	}
	
	/**
	 *
	 * @param
	 *        	$sequence
	 */
	public function setSequence($sequence) {
		$this->sequence = $sequence;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getPromotionStartDate() {
		return $this->promotionStartDate;
	}
	
	/**
	 *
	 * @param
	 *        	$promotionStartDate
	 */
	public function setPromotionStartDate($promotionStartDate) {
		$this->promotionStartDate = $promotionStartDate;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getPromotionEndDate() {
		return $this->promotionEndDate;
	}
	
	/**
	 *
	 * @param
	 *        	$promotionEndDate
	 */
	public function setPromotionEndDate($promotionEndDate) {
		$this->promotionEndDate = $promotionEndDate;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getPromotionPrice() {
		return $this->promotionPrice;
	}
	
	/**
	 *
	 * @param
	 *        	$promotionPrice
	 */
	public function setPromotionPrice($promotionPrice) {
		$this->promotionPrice = $promotionPrice;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getRackRate() {
		return $this->rackRate;
	}
	
	/**
	 *
	 * @param
	 *        	$rackRate
	 */
	public function setRackRate($rackRate) {
		$this->rackRate = $rackRate;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getWeeklyPrice() {
		return $this->weeklyPrice;
	}
	
	/**
	 *
	 * @param
	 *        	$weeklyPrice
	 */
	public function setWeeklyPrice($weeklyPrice) {
		$this->weeklyPrice = $weeklyPrice;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getMonthlyPrice() {
		return $this->monthlyPrice;
	}
	
	/**
	 *
	 * @param
	 *        	$monthlyPrice
	 */
	public function setMonthlyPrice($monthlyPrice) {
		$this->monthlyPrice = $monthlyPrice;
		return $this;
	}
	
	
	
	
	
	

	
}
