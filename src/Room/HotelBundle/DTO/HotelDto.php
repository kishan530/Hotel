<?php

namespace Room\HotelBundle\DTO;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hotel
 *
 *
 * 
 */
class HotelDto
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     *
     * 
     */
    private $overview;
    /**
     * @var string
     *
     * 
     */
    private $propertyType;
    /**
     * @var integer
     *
     * 
     */
    private $category;
    /**
     * @var string
     *
     * 
     */
    private $checkIn;
    /**
     * @var string
     *
     * 
     */
    private $checkOut;

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
    private $city;

    /**
     * @var integer
     *
     * 
     */
    private $numRooms;
    /**
     * @var boolean
     *
     *
     */
    private $soldOut;
    /**
     * @var integer
     *
     *
     */
    private $priority;

    /**
     * @var integer
     *
     * 
     */
    private $cityId;
    /**
     * @var boolean
     *
     * 
     */
    private $active;
    
    /**
     * @var string
     *
     * 
     */
    private $addressLine1;
    
    /**
     * @var string
     *
     * 
     */
    private $addressLine2;
    
    /**
     * @var string
     *
     * 
     */
    private $location;
    
    /**
     * @var string
     *
     *
     */
    private $pincode;
    
    
    /**
     * @var boolean
     *
     *
     */
    private $footerDisplay;
    
    /**
     * @var string
     *
     *
     */
    private $url;
    
    /**
     * @var string
     *
     *
     */
    private $metaTitle;
    
    /**
     * @var string
     *
     *
     */
    private $metaKeywords;
    
    /**
     * @var string
     *
     *
     */
    private $metaDescription;
    
    /**
     * @var date
     */
    private $hotelblockStartDate;
    
    /**
     * @var date
     */
    private $hotelblockEndDate;
    
    /**
     * @var date
     */
    private $auditInfocreatedAt;
    
    /**
     * @var string
     *
     *
     */
    private $auditInfocreatedBy;
       
    
    /**
     * @var date
     */
    private $auditInfoupdatedAt;
    
    /**
     * @var string
     *
     *
     */
    private $auditInfoupdatedBy;
    
      
    
    
    /**
     * @var date
     */
    private $promotionStartDate;
    
    /**
     * @var date
     */
    private $promotionEndDate;
    
    /**
     * @var float
     *
     *
     */
    private $promotionPrice;
    
    
    /**
     * @var Collection
     * 
     */
    protected $images;
    
    
    /**
     * @var Collection
     *
     */
    private $imageList;
    /**
     * @var Collection
     * 
     */
    protected $amenities;
    /**
     * @var Collection
     *
     */
  	protected $hotelRooms;
  	/**
  	 * @var Collection
  	 *
  	 */
  	protected $roomList;
  	
  	/**
  	 * @var Collection
  	 *
  	 */
  	protected $availableRooms;
    
    
    /**
     * 
     */
    public function __construct() {
    	$this->images = new ArrayCollection();
    	$this->amenities = new ArrayCollection();
    	$this->imageList = new ArrayCollection();
    	$this->hotelRooms = new ArrayCollection();
    	$this->roomList = new ArrayCollection();
    	$this->availableRooms = new ArrayCollection();
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
	 * @return the string
	 */
	public function getOverview() {
		return $this->overview;
	}
	
	/**
	 *
	 * @param
	 *        	$overview
	 */
	public function setOverview($overview) {
		$this->overview = $overview;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getPropertyType() {
		return $this->propertyType;
	}
	
	/**
	 *
	 * @param
	 *        	$propertyType
	 */
	public function setPropertyType($propertyType) {
		$this->propertyType = $propertyType;
		return $this;
	}
	
	/**
	 *
	 * @return the integer
	 */
	public function getCategory() {
		return $this->category;
	}
	
	/**
	 *
	 * @param
	 *        	$category
	 */
	public function setCategory($category) {
		$this->category = $category;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getCheckIn() {
		return $this->checkIn;
	}
	
	/**
	 *
	 * @param
	 *        	$checkIn
	 */
	public function setCheckIn($checkIn) {
		$this->checkIn = $checkIn;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getCheckOut() {
		return $this->checkOut;
	}
	
	/**
	 *
	 * @param
	 *        	$checkOut
	 */
	public function setCheckOut($checkOut) {
		$this->checkOut = $checkOut;
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
	public function getCity() {
		return $this->city;
	}
	
	/**
	 *
	 * @param
	 *        	$city
	 */
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}
	
	/**
	 *
	 * @return the integer
	 */
	public function getNumRooms() {
		return $this->numRooms;
	}
	
	/**
	 *
	 * @param
	 *        	$numRooms
	 */
	public function setNumRooms($numRooms) {
		$this->numRooms = $numRooms;
		return $this;
	}
	
	/**
	 *
	 * @return the integer
	 */
	public function getCityId() {
		return $this->cityId;
	}
	
	/**
	 *
	 * @param
	 *        	$cityId
	 */
	public function setCityId($cityId) {
		$this->cityId = $cityId;
		return $this;
	}
	
	/**
	 *
	 * @return the boolean
	 */
	public function getActive() {
		return $this->active;
	}
	
	/**
	 *
	 * @param
	 *        	$active
	 */
	public function setActive($active) {
		$this->active = $active;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getAddressLine1() {
		return $this->addressLine1;
	}
	
	/**
	 *
	 * @param
	 *        	$addressLine1
	 */
	public function setAddressLine1($addressLine1) {
		$this->addressLine1 = $addressLine1;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getAddressLine2() {
		return $this->addressLine2;
	}
	
	/**
	 *
	 * @param
	 *        	$addressLine2
	 */
	public function setAddressLine2($addressLine2) {
		$this->addressLine2 = $addressLine2;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getLocation() {
		return $this->location;
	}
	
	/**
	 *
	 * @param
	 *        	$location
	 */
	public function setLocation($location) {
		$this->location = $location;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getPincode() {
		return $this->pincode;
	}
	
	/**
	 *
	 * @param
	 *        	$pincode
	 */
	public function setPincode($pincode) {
		$this->pincode = $pincode;
		return $this;
	}
	
	
	/**
	 *
	 * @return the Collection
	 */
	public function getImages() {
		return $this->images;
	}
	
	/**
	 *
	 * @param
	 *        	$images
	 */
	public function setImages($images) {
		$this->images = $images;
		return $this;
	}
	
	/**
	 *
	 * @return the Collection
	 */
	public function getAmenities() {
		return $this->amenities;
	}
	
	/**
	 *
	 * @param
	 *        	$amenities
	 */
	public function setAmenities($amenities) {
		$this->amenities = $amenities;
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
	 * @return the integer
	 */
	public function getPriority() {
		return $this->priority;
	}
	
	/**
	 *
	 * @param
	 *        	$priority
	 */
	public function setPriority($priority) {
		$this->priority = $priority;
		return $this;
	}
	
	/**
	 *
	 * @return the Collection
	 */
	public function getImageList() {
		return $this->imageList;
	}
	
	/**
	 *
	 * @param
	 *        	$imageList
	 */
	public function setImageList($imageList) {
		$this->imageList = $imageList;
		return $this;
	}
	
	/**
	 *
	 * @return the Collection
	 */
	public function getHotelRooms() {
		return $this->hotelRooms;
	}
	
	/**
	 *
	 * @param
	 *        	$hotelRooms
	 */
	public function setHotelRooms($hotelRooms) {
		$this->hotelRooms = $hotelRooms;
		return $this;
	}
	
	/**
	 *
	 * @return the Collection
	 */
	public function getRoomList() {
		return $this->roomList;
	}
	
	/**
	 *
	 * @param
	 *        	$roomList
	 */
	public function setRoomList($roomList) {
		$this->roomList = $roomList;
		return $this;
	}
	
	/**
	 *
	 * @return the boolean
	 */
	public function getFooterDisplay() {
		return $this->footerDisplay;
	}
	
	/**
	 *
	 * @param
	 *        	$footerDisplay
	 */
	public function setFooterDisplay($footerDisplay) {
		$this->footerDisplay = $footerDisplay;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 *
	 * @param
	 *        	$url
	 */
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getMetaTitle() {
		return $this->metaTitle;
	}
	
	/**
	 *
	 * @param
	 *        	$metaTitle
	 */
	public function setMetaTitle($metaTitle) {
		$this->metaTitle = $metaTitle;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getMetaKeywords() {
		return $this->metaKeywords;
	}
	
	/**
	 *
	 * @param
	 *        	$metaKeywords
	 */
	public function setMetaKeywords($metaKeywords) {
		$this->metaKeywords = $metaKeywords;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getMetaDescription() {
		return $this->metaDescription;
	}
	
	/**
	 *
	 * @param
	 *        	$metaDescription
	 */
	public function setMetaDescription($metaDescription) {
		$this->metaDescription = $metaDescription;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getHotelblockStartDate() {
		return $this->hotelblockStartDate;
	}
	
	/**
	 *
	 * @param
	 *        	$hotelblockStartDate
	 */
	public function setHotelblockStartDate($hotelblockStartDate) {
		$this->hotelblockStartDate = $hotelblockStartDate;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getHotelblockEndDate() {
		return $this->hotelblockEndDate;
	}
	
	/**
	 *
	 * @param
	 *        	$hotelblockEndDate
	 */
	public function setHotelblockEndDate($hotelblockEndDate) {
		$this->hotelblockEndDate = $hotelblockEndDate;
		return $this;
	}
	
	/**
	 *
	 * @return the date
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
	 * @return the date
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
	 * @return the date
	 */
	public function getAuditInfocreatedAt() {
		return $this->auditInfocreatedAt;
	}
	
	/**
	 *
	 * @param
	 *        	$auditInfocreatedAt
	 */
	public function setAuditInfocreatedAt($auditInfocreatedAt) {
		$this->auditInfocreatedAt = $auditInfocreatedAt;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getAuditInfocreatedBy() {
		return $this->auditInfocreatedBy;
	}
	
	/**
	 *
	 * @param
	 *        	$auditInfocreatedBy
	 */
	public function setAuditInfocreatedBy($auditInfocreatedBy) {
		$this->auditInfocreatedBy = $auditInfocreatedBy;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getAuditInfoupdatedAt() {
		return $this->auditInfoupdatedAt;
	}
	
	/**
	 *
	 * @param
	 *        	$auditInfoupdatedAt
	 */
	public function setAuditInfoupdatedAt($auditInfoupdatedAt) {
		$this->auditInfoupdatedAt = $auditInfoupdatedAt;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getAuditInfoupdatedBy() {
		return $this->auditInfoupdatedBy;
	}
	
	/**
	 *
	 * @param
	 *        	$auditInfoupdatedBy
	 */
	public function setAuditInfoupdatedBy($auditInfoupdatedBy) {
		$this->auditInfoupdatedBy = $auditInfoupdatedBy;
		return $this;
	}
	
	/**
	 *
	 * @return the Collection
	 */
	public function getAvailableRooms() {
		return $this->availableRooms;
	}
	
	/**
	 *
	 * @param
	 *        	$availableRooms
	 */
	public function setAvailableRooms($availableRooms) {
		$this->availableRooms = $availableRooms;
		return $this;
	}
	
	
	
	
	
	
	
	
	
	
	
	   

    
}
