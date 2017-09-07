<?php

namespace Room\BookingEngineBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * This is a DTO to hold the data of Search
 *
 *
 * Search
 */
class Search
{

	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * @var string
	 */
	private $mobile;
	
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	public function getMobile() {
		return $this->mobile;
	}
	public function setMobile($mobile) {
		$this->mobile = $mobile;
		return $this;
	}
	
	
	
}