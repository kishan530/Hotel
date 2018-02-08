<?php



namespace Room\BookingEngineBundle\DTO;



use Symfony\Component\Validator\Constraints as Assert;
/**
 * This is a DTO to hold the data of Room
 *
 *
 * Room
 */

class Room
{
/**

	 * @var integer

	 */

	private $numAdult;

	/**

	 * @var integer

	 */

	private $numChildren;
	
	/**

	 *

	 * @return the integer

	 */

	public function getNumAdult() {

		return $this->numAdult;

	}

	

	/**

	 *

	 * @param

	 *        	$numAdult

	 */

	public function setNumAdult($numAdult) {

		$this->numAdult = $numAdult;

		return $this;

	}	

	/**

	 *

	 * @return the integer

	 */

	public function getNumChildren() {

		return $this->numChildren;

	}

	

	/**

	 *

	 * @param

	 *        	$numChildren

	 */

	public function setNumChildren($numChildren) {

		$this->numChildren = $numChildren;

		return $this;

	}


}

?>