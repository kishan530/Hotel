<?php

namespace Room\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CouponCode
 *
 * @ORM\Table(name="coupon_codes")
 * @ORM\Entity
 */
class CouponCode
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
	 * @ORM\Column(name="couponName", type="string", length=100)
	 */
	private $couponName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="couponCode", type="string", length=100)
	 */
	private $couponCode;
	
	
	/**
	 * @var string
	 * @ORM\Column(name="startDate", type="datetime", nullable=true)
	 * @Assert\Date()
	 */
	private $startDate;
	
	
	/**
	 * @var string
	 * @ORM\Column(name="expireDate", type="datetime", nullable=true)
	 * @Assert\Date()
	 */
	private $expireDate;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="amount", type="string", length=100)
	 */
	private $amount;
	

	/**
	 * @var string
	 *
	 * @ORM\Column(name="createdBy", type="string", length=100)
	 */
	private $createdBy;
	
	/**
	 * @var string
	 * @ORM\Column(name="createdAt", type="datetime", nullable=true)
	 * @Assert\Date()
	 */
	private $createdAt;

	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="updatedBy", type="string", length=5000)
	 */
	private $updatedBy;
	
	/**
	 * @var string
	 * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
	 * @Assert\Date()
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
	 * @return the string
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
	 * @return the string
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
	 * @return the string
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
	 * @return the string
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
