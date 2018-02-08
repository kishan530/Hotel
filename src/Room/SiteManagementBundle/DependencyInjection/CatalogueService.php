<?php

namespace  Room\SiteManagementBundle\DependencyInjection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Trip\BookingEngineBundle\DTO\Catalogue;

use Room\HotelBundle\DTO\HotelDto;

/**
 * This is Catalogue Service.    
 *
 */
class CatalogueService
{
	private $container;
	private $em;
	private $session;
	private $logger;
	
	/**
	 * Constructor 
	 * @param EntityManager $entityManager
	 * @param ContainerInterface $container
	 * @param unknown $session
	 */
	public function __construct(EntityManager $entityManager,ContainerInterface $container,$session)
	{
		$this->session = $session;
		$this->container = $container;
        $this->em = $entityManager;
		$this->logger = $this->container->get('logger');
    }
    public function getCities(){
        $locations = $this->em->getRepository('RoomSiteManagementBundle:City')->findAll();
        return $locations;
    }
    public function getAmenities(){
    	$locations = $this->em->getRepository('RoomSiteManagementBundle:Amenities')->findAll();
    	return $locations;
    }
    public function getHotels(){
    	$locations = $this->em->getRepository('RoomHotelBundle:Hotel')->findAll();
    	return $locations;
    }
    public function getBookings(){
    	$locations = $this->em->getRepository('RoomBookingEngineBundle:Booking')->findAll();
    	return $locations;
    }
    public function getCustomers(){
    	$locations = $this->em->getRepository('RoomBookingEngineBundle:Customer')->findAll();
    	return $locations;
    }
    public function getHotelsByCity($city){
    	$hotels = $this->em->getRepository('RoomHotelBundle:Hotel')->findByCityId($city);
    	
    	$tempHotels = array();
    	foreach($hotels as $hotel){
    		$rooms = $hotel->getHotelRooms();
			$propertyType = $hotel->getPropertyType();
			
				if($propertyType!='Service Apartments'){
    		//echo $location;
    		$minPrice = 0;
    		$minPromoPrice = 0;
    		$selectedPromoStartDate = 0;
    		$selectedPromoEndDate = 0;
    		foreach($rooms as $room){    			
    			$roomPrice = $room->getPrice();
    			$promoStartDate = $room->getPromotionStartDate();
    			$promoEndDate = $room->getPromotionEndDate();
    			$promoPrice = $room->getPromotionPrice();
    			 
    			
    			if($minPrice==0){
    				$minPrice = $roomPrice;
    				$minPromoPrice = $promoPrice;
    				$selectedPromoStartDate = $promoStartDate;
    				$selectedPromoEndDate = $promoEndDate;
    			}
    			//	echo $slectedLocation;
    			if ($minPrice>$roomPrice){
    				$minPrice = $roomPrice;
    				$minPromoPrice = $promoPrice;
    				$selectedPromoStartDate = $promoStartDate;
    				$selectedPromoEndDate = $promoEndDate;
    			}
    		}
    		    		
    		
    		$hotelDetail = new HotelDto();
    		$address = $hotel->getAddress();
    		$hotelDetail->setId($address->getId());
    		$hotelDetail->setAddressLine1($address->getAddressLine1());
    		$hotelDetail->setAddressLine2($address->getAddressLine2());
    		$hotelDetail->setLocation($address->getLocation());
    		$hotelDetail->setPincode($address->getPincode());
    		
    		//$hotelDetail->setCity($address->getCity());
    		//$hotelDetail->setCityId($address->getCityId());
    		
    		//$hotelDetail->setHotel($address->getHotel());
    		
    		
    		$hotelDetail->setId($hotel->getId());
    		$hotelDetail->setName($hotel->getName());
    		$hotelDetail->setOverview($hotel->getOverview());
    		//$hotelDetail->setId($hotel->getId());
    		
    		$hotelDetail->setPropertyType($hotel->getPropertyType());
    		$hotelDetail->setCategory($hotel->getCategory());
    		$hotelDetail->setCheckIn($hotel->getCheckIn());
    		$hotelDetail->setCheckOut($hotel->getCheckOut());
    		$hotelDetail->setCity($hotel->getCity());
    		$hotelDetail->setNumRooms($hotel->getNumRooms());
    		$hotelDetail->setCityId($hotel->getCityId());
    		$hotelDetail->setActive($hotel->getActive());
    		
    		$hotelDetail->setSoldOut($hotel->getSoldOut());
    		$hotelDetail->setPriority($hotel->getPriority());
    		
    		$hotelDetail->setFooterDisplay($hotel->getFooterDisplay());
    		$hotelDetail->setUrl($hotel->getUrl());
    		$hotelDetail->setMetaTitle($hotel->getMetaTitle());
    		$hotelDetail->setMetaKeywords($hotel->getMetaKeywords());
    		$hotelDetail->setMetaDescription($hotel->getMetaDescription());
    		$hotelDetail->setHotelblockStartDate($hotel->getHotelblockStartDate());
    		$hotelDetail->setHotelblockEndDate($hotel->getHotelblockEndDate());
    		
    		$hotelDetail->setHotelRooms($hotel->getHotelRooms());
    		//$hotelDetail->setAddress($hotel->getAddress());
    		$hotelDetail->setImages($hotel->getImages());
    		$hotelDetail->setAmenities($hotel->getAmenities());
    		
    		
    		
    		
    		
    		
    		$hotelDetail->setPrice($minPrice);
    		$hotelDetail->setPromotionStartDate($selectedPromoStartDate);
    		$hotelDetail->setPromotionEndDate($selectedPromoEndDate);
    		$hotelDetail->setPromotionPrice($minPromoPrice);
    		
    		$activehotel=$hotel->getActive();
    		if($activehotel=='Active')
    		{//$tempHotels[] = $hotel;
    		$tempHotels[] = $hotelDetail;
    		}
			}
    	}
    	//var_dump($tempHotels);
    	//exit();
    	return $tempHotels;
    }
    
    /**
     * 
     * @param unknown $hotel
     * @return unknown
     */
    public function getMinroom($hotel){
    	$hotel=$hotel[0];
    	
    	$rooms = $hotel->getHotelRooms();
    	//echo $location;
    	$price = 0;
    	$hotel=$this->gethotelinfo($hotel);
    	foreach($rooms as $room){
    		$roomPrice = $room->getPrice();
    		$roompromotionStartDate = $room->getPromotionStartDate();
    		$roompromotionEndDate = $room->getPromotionEndDate();
    		$roompromotionPrice = $room->getPromotionPrice();
    		 
    		if($price==0)
    			$price = $roomPrice;
    		$promotionPrice = $roompromotionPrice;
    		$promotionStartDate = $roompromotionStartDate;
    		$promotionEndDate = $roompromotionEndDate;
    
    		
    		
    		
    		//	echo $slectedLocation;
    		if ($price>$roomPrice)
    			$price = $roomPrice;
    		
    		$promotionStartDate = $roompromotionStartDate;
    		$promotionEndDate = $roompromotionEndDate;
    		$promotionPrice = $roompromotionPrice;
    	}
    	
    	$hotel->setPrice($price);
    	
    	$hotel->setPromotionStartDate($promotionStartDate);
    	$hotel->setPromotionEndDate($promotionEndDate);
    	$hotel->setPromotionPrice($promotionPrice);
    	
    	return $hotel;
    } 
    
    public function gethotelinfo($hotel){
    	$hotelinfo = array();
    	$hotelDetail = new HotelDto();
    	$address = $hotel->getAddress();
    	$hotelDetail->setId($address->getId());
    	$hotelDetail->setAddressLine1($address->getAddressLine1());
    	$hotelDetail->setAddressLine2($address->getAddressLine2());
    	$hotelDetail->setLocation($address->getLocation());
    	$hotelDetail->setPincode($address->getPincode());
    	
    	//$hotelDetail->setCity($address->getCity());
    	//$hotelDetail->setCityId($address->getCityId());
    	
    	//$hotelDetail->setHotel($address->getHotel());
    	
    	
    	$hotelDetail->setId($hotel->getId());
    	$hotelDetail->setName($hotel->getName());
    	$hotelDetail->setOverview($hotel->getOverview());
    	//$hotelDetail->setId($hotel->getId());
    	
    	$hotelDetail->setPropertyType($hotel->getPropertyType());
    	$hotelDetail->setCategory($hotel->getCategory());
    	$hotelDetail->setCheckIn($hotel->getCheckIn());
    	$hotelDetail->setCheckOut($hotel->getCheckOut());
    	$hotelDetail->setCity($hotel->getCity());
    	$hotelDetail->setNumRooms($hotel->getNumRooms());
    	$hotelDetail->setCityId($hotel->getCityId());
    	$hotelDetail->setActive($hotel->getActive());
    	
    	$hotelDetail->setSoldOut($hotel->getSoldOut());
    	$hotelDetail->setPriority($hotel->getPriority());
    	
    	$hotelDetail->setFooterDisplay($hotel->getFooterDisplay());
    	$hotelDetail->setUrl($hotel->getUrl());
    	$hotelDetail->setMetaTitle($hotel->getMetaTitle());
    	$hotelDetail->setMetaKeywords($hotel->getMetaKeywords());
    	$hotelDetail->setMetaDescription($hotel->getMetaDescription());
    	$hotelDetail->setHotelblockStartDate($hotel->getHotelblockStartDate());
    	$hotelDetail->setHotelblockEndDate($hotel->getHotelblockEndDate());
    	
    	$hotelDetail->setHotelRooms($hotel->getHotelRooms());
    	//$hotelDetail->setAddress($hotel->getAddress());
    	$hotelDetail->setImages($hotel->getImages());
    	$hotelDetail->setAmenities($hotel->getAmenities());
    	
    	
    	$hotelDetail->setPrice($hotel->getPrice());
    	//$hotelDetail->setPromotionStartDate();
    	//$hotelDetail->setPromotionEndDate();
    	//$hotelDetail->setPromotionPrice();
    	$hotelinfo = $hotelDetail;
    	return $hotelinfo;
    	
    }
    /**
     *
     * @param unknown $hotel
     * @return unknown
     */
    public function getMinPrice($hotel){
    	$rooms = $hotel->getHotelRooms();
    	//echo $location;
    	$price = 0;
    	foreach($rooms as $room){
    		$roomPrice = $room->getPrice();
    		 
    		if($price==0)
    			$price = $roomPrice;
    		//	echo $slectedLocation;
    		if ($price>$roomPrice)
    			$price = $roomPrice;
    	}
    	 
    	$hotel->setPrice($price);
    	 
    	return $hotel;
    }
    
    
    
    
    
    
    
    
    /**
     * 
     * @param unknown $hotel
     * @return unknown
     */
    public function getRoomsBySequence($hotel){
    	$rooms = $hotel->getHotelRooms();
    	$tempArray=array();
    	//echo $location;
    	$price = 0;
    	$sequence = 0;
    	foreach($rooms as $room){
			$roomSequence = $room->getSequence();
	    		$tempArray[$roomSequence ] = $room;
    	}

    	/*for($i = 0; $i < count($tempArray)-1; $i ++){
    		
    		$room1=$tempArray[$i];
    		$room2=$tempArray[$i+1];
    		$roomPrice1 = $room1->getPrice();
    		$roomSequence1 = $room1->getSequence();
    		$roomPrice2 = $room2->getPrice();
    		$roomSequence2 = $room2->getSequence();

    		if($roomSequence1 > $roomSequence2) {
    			$temp = $room2;
    			$tempArray[$i+1]=$room1;
    			$tempArray[$i]=$temp;
    		}
    		
    		
    	}*/
    	
    	$hotel->setHotelRooms($tempArray);
    	
    	return $hotel;
    }
    
    
    
    
    /**
     * 
     * @param unknown $hotel
     * @param unknown $roomId
     * @return Ambigous <NULL, unknown>
     */
    public function getSelectedRoom($hotel,$roomId){
    	$rooms = $hotel->getHotelRooms();
    	$selectedRoom = null;
    	foreach($rooms as $room){    		 
    		if($room->getId()==$roomId)
    			$selectedRoom = $room;    	
    	}
    	//var_dump($selectedRoom);
    	//exit();
    	return $selectedRoom;
    }
    
    
  public function  getavailablerooms($hotels,$roomCountByHotel){
  	
  	foreach($hotels as $hotel){
  		$totalRooms = $hotel->getNumRooms();
  		$id = $hotel->getId();
  		//if (array_key_exists('first', $search_array))
  		if (array_key_exists($id, $roomCountByHotel))
  			$countofBookedRooms = $roomCountByHotel[$id];
  		else
  			$countofBookedRooms = 0;
  		$totalRooms = $hotel->getNumRooms();
  		$availableRoom = $totalRooms - $countofBookedRooms;
  		//var_dump($id);
  		//var_dump($totalRooms);
  		//var_dump($countofBookedRooms);
  		//var_dump($availableRoom);
  		$hotel->setAvailableRooms($availableRoom);
  		//var_dump($hotel);
  		//exit();
  	}
  //	var_dump($hotels);
  	//exit();
  	return $hotels;
  }
    
    public function getBookingsBySearch($bookingSearch){
    	
    	
    	
    	$bookings = array();
    	$from = $bookingSearch->getFrom();
    	$to   = $bookingSearch->getTo();
    	$bookingId = $bookingSearch->getBookingId();
    	
    	
    	
    	
    	if(!is_null($bookingId)){
    		$bookings = $this->em->getRepository( 'RoomBookingEngineBundle:Booking' )->findBy(array('bookingId'=>$bookingId));
    	}else{
    		
	    	if(!is_null($from)){
	    		$from = new \DateTime($from->format("Y-m-d")." 00:00:00");
	    	
	    			
	    		$to = new \DateTime($to->format("Y-m-d")." 23:59:59");
	    			
	    	
	    	
	    		$qb = $this->em->getRepository ( 'RoomBookingEngineBundle:Booking' )->createQueryBuilder("Booking");
	    	
	    		$qb ->andWhere('Booking.bookedOn BETWEEN :from AND :to ') ->setParameter('from', $from )->setParameter('to', $to) ;
	    	
	    		$bookings = $qb->getQuery()->getResult();
	    	}
	    	else{
	    		$bookings = $this->em->getRepository ( 'RoomBookingEngineBundle:Booking' )->findAll();
	    	}
    	}
    		
    	return $bookings;
    }
    
    
    
    /* public function getBookingsByBookingId($bookingId){
    	$locations = $this->em->getRepository('RoomBookingEngineBundle:Booking')->findById($bookingId);
    	return $locations;
    } */
    
    
    
    public function getAmenitiesById($amenitiesMstr){
    	$amenities = array();
    	foreach($amenitiesMstr as $a){
    		$amenities[$a->getId()] = $a;
    	}
    	return $amenities;
    }
    public function getById($collection){
    	$tempCollection = array();
    	foreach($collection as $a){
    		$tempCollection[$a->getId()] = $a;
    	}
    	return $tempCollection;
    }
    /**
     * 
     * @param unknown $hotels
     * @return multitype:
     */
    public function getFilters($hotels,$amenitiesMstr){
    	$filters = array();
    	$locations = array();
    	$price = array();
    	$amenities = array();
    	$categories = array();
    	$properties = array();
    	$maxPrice = 0;
    	$minPrice = 100000;
    	$amenitiesMstr = $this->getAmenitiesById($amenitiesMstr);
    	foreach($hotels as $hotel){
    		//$address = $hotel->getAddress();
    		$hotelAmenities = $hotel->getAmenities();
    		$category = $hotel->getCategory();
    		
    		$property = $hotel->getPropertyType();
    		
    		$location = $hotel->getLocation();
    		$price = $hotel->getPrice();
    		
    		if($price>$maxPrice)
    		$maxPrice = $price;
    		if($price<$minPrice)
    		$minPrice = $price;
    		
    		if(!is_null($category))
    			$categories[$category] = $category.' Star';
    		$locations[$location] = $location;
    		
    		if(!is_null($property))
    			$properties[$property] = $property;
    		$locations[$location] = $location;
    		
    		
    		foreach($hotelAmenities as $amenity){
    			$mstrAmenity = $amenitiesMstr[$amenity->getAmenity()];
    			$amenities[$mstrAmenity->getId()] = $mstrAmenity->getName();
    		}
    	}
    	
    	$filters['locations'] = $locations;
    	$filters['categories'] = $categories;
    	$filters['properties'] = $properties;
    	$filters['amenities'] = $amenities;
    	$filters['price']=array('maxPrice'=>$maxPrice,'minPrice'=>$minPrice);
    	//echo var_dump($filters);
    	//exit();
    	return $filters;
    }	
    
    /**
     * 
     * @param unknown $search
     * @param unknown $hotels
     * @return multitype:
     */
    public function filterHotels($search,$hotels,$minPrice,$maxPrice){
    	
    	$slectedLocations = $search->getLocation();
    	$slectedCategories = $search->getCategories();
    	$slectedProperties = $search->getProperties();
    	
    	if(count($slectedLocations)>0)
    		$hotels = $this->filterByLocation($slectedLocations,$hotels);
    	
    	$hotels = $this->filterByPrice($search,$hotels,$minPrice,$maxPrice);
    	
    	if(count($slectedCategories)>0)
    		$hotels = $this->filterByCategory($slectedCategories,$hotels);
    	
    	if(count($slectedProperties)>0)
    		$hotels = $this->filterByPropertyType($slectedProperties,$hotels);
    	
    	return $hotels;
    }
    /**
     *
     * @param unknown $search
     * @param unknown $hotels
     * @return multitype:
     */
    public function filterByLocation($slectedLocations,$hotels){
    	$tempHotels = array();
    	foreach($hotels as $hotel){
    		//$address = $hotel->getAddress();
    		$hotelAmenities = $hotel->getAmenities();
    		$category = $hotel->getCategory();
    		$location = $hotel->getLocation();
    		$price = $hotel->getPrice();
    		//echo $location;
    		
    		foreach($slectedLocations as $slectedLocation){
    		//	echo $slectedLocation;
    		if ($location==$slectedLocation)
    			$tempHotels[] = $hotel;
    		}
    	}
    	return $tempHotels;
    }
    /**
     *
     * @param unknown $search
     * @param unknown $hotels
     * @return multitype:
     */
    public function filterByPrice($search,$hotels,$minPrice,$maxPrice){
    	$tempHotels = array();
    	foreach($hotels as $hotel){
    	//	$address = $hotel->getAddress();
    		$hotelAmenities = $hotel->getAmenities();
    		$category = $hotel->getCategory();
    		$location = $hotel->getLocation();
    		$price = $hotel->getPrice();
    		//echo $price;
    		//echo $minPrice;
    		//echo $maxPrice;
    		if ($price>=$minPrice && $price<=$maxPrice)
    			$tempHotels[] = $hotel;
    	}
    	//echo var_dump($tempHotels);
    	//exit();
    	return $tempHotels;
    }
    /**
     *
     * @param unknown $search
     * @param unknown $hotels
     * @return multitype:
     */
    public function filterByCategory($slectedCategories,$hotels){
    	$tempHotels = array();
    	foreach($hotels as $hotel){
    	//	$address = $hotel->getAddress();
    		$hotelAmenities = $hotel->getAmenities();
    		$category = $hotel->getCategory();
    		$location = $hotel->getLocation();
    		$price = $hotel->getPrice();	    		
    		//echo var_dump($slectedCategories);
    		foreach($slectedCategories as $selectedCategory){
    			//echo $category;
    			//echo $selectedCategory;
    			if ($category==$selectedCategory)
    				$tempHotels[] = $hotel;
    		}
    	}
    	//exit();
    	return $tempHotels;
    }
    public function filterByPropertyType($slectedProperties,$hotels){
    	$tempHotels = array();
    	foreach($hotels as $hotel){
    	//	$address = $hotel->getAddress();
    		$hotelAmenities = $hotel->getAmenities();
    		$property = $hotel->getPropertyType();
    		$location = $hotel->getLocation();
    		$price = $hotel->getPrice();
    		//echo var_dump($slectedCategories);
    		foreach($slectedProperties as $slectedProperty){
    			//echo $category;
    			//echo $selectedCategory;
    			if ($property==$slectedProperty)
    				$tempHotels[] = $hotel;
    		}
    	}
    	//exit();
    	return $tempHotels;
    }
    
	
}
