<?php

namespace Room\BookingEngineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Room\BookingEngineBundle\Entity\Booking;
use Room\CommonBundle\Entity\AuditInformation;

/**
 * This is a Entity to hold the data of hotel payment details in
 * Hotel application.
 *
 * @author 4th Dymension Teknocrats
 * @copyright <a> 4th Dymension Teknocrats India LLP - 2014</a>
 *           
 * @ORM\Table(name="booking_payment_details")
 * @ORM\Entity
 */
class BookingPaymentEntity {
	/**
	 *
	 * @var integer 
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * Cheque cash or online
	 * @var string 
	 * @ORM\Column(name="payment_mode", type="string")
	 */
	private $paymentMode;
	/**
	 * PAyment Amount
	 * @var float 
	 * @ORM\Column(name="paid_amount", type="float")
	 */
	private $paidAmount;
	
	/**
	 * Colelcted By
	 * @var string
	 * @ORM\Column(name="transaction_no", type="string")
	 */
	private $transactionNo;
	
	
	/**
	 *
	 * @var date
	 * @ORM\Column(name="payment_date", type="date")
	 */
	private $paymentDate;
	
    /**
     * check status realized or not
     * @var string
     * @ORM\Column(name="status", type="string")
     */
    private $status;
    /**
     * credited value is 1
     * @var string
     * @ORM\Column(name="is_credited", type="boolean")
     */
    private $credited;
    /**
     * Colelcted By
     * @var string
     * @ORM\Column(name="paid_by", type="string" )
     */
    private $paidBy;
    
    /**
     * @var string
     * @ORM\Column(name="number", type="string")
     */
    private $Mobile;
	
	/**
	 * @var string
	 * @ORM\Column(name="booking_id", type="string")
	 */
	private $bookingId;
	
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
	public function getPaymentMode() {
		return $this->paymentMode;
	}
	
	/**
	 *
	 * @param
	 *        	$paymentMode
	 */
	public function setPaymentMode($paymentMode) {
		$this->paymentMode = $paymentMode;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getPaidAmount() {
		return $this->paidAmount;
	}
	
	/**
	 *
	 * @param
	 *        	$paidAmount
	 */
	public function setPaidAmount($paidAmount) {
		$this->paidAmount = $paidAmount;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getTransactionNo() {
		return $this->transactionNo;
	}
	
	/**
	 *
	 * @param
	 *        	$transactionNo
	 */
	public function setTransactionNo($transactionNo) {
		$this->transactionNo = $transactionNo;
		return $this;
	}
	
	/**
	 *
	 * @return the date
	 */
	public function getPaymentDate() {
		return $this->paymentDate;
	}
	
	/**
	 *
	 * @param
	 *        	$paymentDate
	 */
	public function setPaymentDate($paymentDate) {
		$this->paymentDate = $paymentDate;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 *
	 * @param
	 *        	$status
	 */
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getCredited() {
		return $this->credited;
	}
	
	/**
	 *
	 * @param
	 *        	$credited
	 */
	public function setCredited($credited) {
		$this->credited = $credited;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getPaidBy() {
		return $this->paidBy;
	}
	
	/**
	 *
	 * @param
	 *        	$paidBy
	 */
	public function setPaidBy($paidBy) {
		$this->paidBy = $paidBy;
		return $this;
	}
	
	
	public function getMobile() {
		return $this->Mobile;
	}
	public function setMobile($Mobile) {
		$this->Mobile = $Mobile;
		return $this;
	}
	
	/**
	 *
	 * @return the unknown_type
	 */
	public function getBookingId() {
		return $this->bookingId;
	}
	
	/**
	 *
	 * @param unknown_type $bookingId        	
	 */
	public function setBookingId($bookingId) {
		$this->bookingId = $bookingId;
		return $this;
	}
	
	
	
	
	
	
}
