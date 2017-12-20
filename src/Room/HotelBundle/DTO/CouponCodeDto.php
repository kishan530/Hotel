<?php

namespace Room\HotelBundle\DTO;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CouponCode
 *
 *
 * 
 */
class CouponCodeDto
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     */
    private $couponName;
   
    /**
     * @var string
     *
     * 
     */
    private $couponCode;
   
   
    /**
     * @var date
     */
    private $startDate;
   
   /**
	 * @var date
	 */
	private $expireDate;

	/**
     * @var string
     *
     * 
     */
    private $amount;

    
    /**
     * @var string
     *
     * 
     */
    private $createdBy;
    
    /**
	 * @var date
	 */
	private $createdAt;
    
    /**
     * @var string
     *
     *
     */
    private $updatedBy; 
    
    /**
	 * @var date
	 */
	private $updatedAt;
	
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
	public function getCouponName() {
		return $this->couponName;
	}
	
	/**
	 *
	 * @param
	 *        	$couponName
	 */
	public function setCouponName($couponName) {
		$this->couponName = $couponName;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getCouponCode() {
		return $this->couponCode;
	}
	
	/**
	 *
	 * @param
	 *        	$couponCode
	 */
	public function setCouponCode($couponCode) {
		$this->couponCode = $couponCode;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getExpireDate() {
		return $this->expireDate;
	}
	
	/**
	 *
	 * @param
	 *        	$expireDate
	 */
	public function setExpireDate($expireDate) {
		$this->expireDate = $expireDate;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getAmount() {
		return $this->amount;
	}
	
	/**
	 *
	 * @param
	 *        	$amount
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	/**
	 *
	 * @param
	 *        	$createdBy
	 */
	public function setCreatedBy($createdBy) {
		$this->createdBy = $createdBy;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	/**
	 *
	 * @param
	 *        	$createdAt
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
	
	/**
	 *
	 * @param
	 *        	$updatedBy
	 */
	public function setUpdatedBy($updatedBy) {
		$this->updatedBy = $updatedBy;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	/**
	 *
	 * @param
	 *        	$updatedAt
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getStartDate() {
		return $this->startDate;
	}
	
	/**
	 *
	 * @param
	 *        	$startDate
	 */
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
		return $this;
	}
	
	

	
	

    
}