<?php

namespace Room\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Room\HotelBundle\Form\HotelDetailType;
use Room\HotelBundle\Form\HotelRoomType;
use Room\HotelBundle\Entity\Hotel;
use Room\HotelBundle\Entity\HotelAddress;
use Room\HotelBundle\Entity\HotelImage;
use Room\HotelBundle\Entity\HotelRoom;
use Room\HotelBundle\DTO\HotelDto;
use Room\HotelBundle\DTO\HotelRoomDto;
use Doctrine\Common\Collections\ArrayCollection;

class HotelController extends Controller
{
	    public function addHotelAction(Request $request)
	    {
	    	$security = $this->container->get ( 'security.context' );
	    	 
	    	$user = $security->getToken ()->getUser ();
	    	 
	    	if (! $security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
	    		 
	    		return $this->redirect ( $this->generateUrl ('room_security_user_login') );
	    		 
	    	}
	    	
	    	$em = $this->getDoctrine()->getManager();
	    	$hotelDetail = new HotelDto();
	    	$hotelImage = new HotelImage();
	    	$hotelImageList = $hotelDetail->getImageList();
	    	$hotelImageList->add($hotelImage);
			
			//newlyadded 3lines	
			$hotelRoom  =new HotelRoomDto();
			$hotelRoomList = $hotelDetail->getRoomList();
			$hotelRoomList->add($hotelRoom);
			
			
	    	$catalogueService = $this->container->get( 'catalogue.service' );
	    	$form = $this->createForm(new HotelDetailType($catalogueService),$hotelDetail);
	    	$form->add('submit','submit', array('label' => 'Add'));
	    	$form ->handleRequest($request);
	    		
	    	if($form->isValid()) {
	    	
	    		$hotelObj = new Hotel();
		
				$hotelAddressObj = new HotelAddress();
				
				$catalogueService = $this->container->get( 'catalogue.service' );
				$cities = $catalogueService->getCities();
				$cities = $catalogueService->getById($cities);
				
				$selectedCity = $cities[$hotelDetail->getCity()];
		
				$hotelObj->setName($hotelDetail->getName());
				$hotelObj->setOverview($hotelDetail->getOverview());
				$hotelObj->setPropertyType($hotelDetail->getPropertyType());
				$hotelObj->setCategory($hotelDetail->getCategory());
				$hotelObj->setCheckIn($hotelDetail->getCheckIn());
				$hotelObj->setCheckOut($hotelDetail->getCheckOut());
				$hotelObj->setPrice($hotelDetail->getPrice());
				$hotelObj->setCity($selectedCity->getName());
				$hotelObj->setNumRooms($hotelDetail->getNumRooms());
				$hotelObj->setSoldOut($hotelDetail->getSoldOut());
				$hotelObj->setPriority($hotelDetail->getPriority());
				$hotelObj->setCityId($selectedCity->getId());
				$hotelObj->setActive($hotelDetail->getActive());
		
				$hotelAddressObj->setAddressLine1($hotelDetail->getAddressLine1());
				$hotelAddressObj->setAddressLine2($hotelDetail->getAddressLine2());
				$hotelAddressObj->setLocation($hotelDetail->getLocation());
				$hotelAddressObj->setPincode($hotelDetail->getPincode());
				$hotelAddressObj->setCity($selectedCity->getName());
				$hotelAddressObj->setCityId($selectedCity->getId());
		
		
				$hotelObj->setAddress($hotelAddressObj);
				$hotelAddressObj->setHotel($hotelObj);
				//$hotelObj->setImages($hotelDetail->getImages());
				//$hotelObj->setAmenities($hotelDetail->getAmenities());
				
				
				
				$hotelImageList = $hotelDetail->getImageList();
				$hotelImages =$hotelObj->getImages();
				foreach($hotelImageList as $hotelImage){
					$uploadedfile = $hotelImage->getImagePath ();
					if (!is_null($uploadedfile)) {
						$file_name = $uploadedfile->getClientOriginalName ();
						$dir = 'img/Hotels/';
						$uploadedfile->move ( $dir, $file_name );
						$hotelImage->setImagePath ($file_name );
						$hotelImage->setActive (1);
						$hotelImage->setHotel($hotelObj);
						$hotelImages->add($hotelImage);
				
					}
				
					
				}
				
				
				
				$hotelRoomList = $hotelDetail->getRoomList();
				$hotelRooms =$hotelObj->getHotelRooms();
				foreach($hotelRoomList as $hotelRoom){
					$roomType = $hotelRoom->getRoomType();
					$capacity = $hotelRoom->getCapacity();
					$price = $hotelRoom->getPrice();
					$imagePath = $hotelRoom->getImagePath();
					$maxAdult = $hotelRoom->getMaxAdult();
					$maxChild = $hotelRoom->getMaxChild();
					$description = $hotelRoom->getDescription();
					$name = $hotelRoom->getName();
					
					
					
					$hotelRoomObj  =new HotelRoom();
					$hotelRoomObj->setRoomType ($roomType );
					$hotelRoomObj->setCapacity ($capacity );
					$hotelRoomObj->setPrice ($price );
					$hotelRoomObj->setMaxAdult ($maxAdult );
					$hotelRoomObj->setMaxChild ($maxChild );
					$hotelRoomObj->setDescription ($description );
					$hotelRoomObj->setName ($name );
					
					
					$uploadedfile = $hotelRoom->getImagePath ();
					if (!is_null($uploadedfile)) {
						$file_name = $uploadedfile->getClientOriginalName ();
						$dir = 'img/Hotels/';
						$uploadedfile->move ( $dir, $file_name );
						$hotelRoomObj->setImagePath ($file_name );
						//$hotelRoom->setActive (1);
						$hotelRoomObj->setHotel($hotelObj);
							
					}
					
					
					
					
					
					$hotelRooms->add($hotelRoomObj);
						
				
				}
				
				
		
				$em->persist($hotelObj);
				
	    		$em->flush();
	/*     		
	    		$this->addFlash(
	    				'Notice',
	    				'Hotel Detail Added'
	    		); */
	    		
	    		return $this->redirect ( $this->generateUrl ( "room_hotel_add_hotel" ) );
	    	}
	    	
	    	return $this->render('RoomHotelBundle:Default:add-hotel.html.twig',array(
	
		 		'form' => $form->createView(),
		 ));
	    
		}
	
	/**
	 * 
	 * @param Request $request
	 */
	public function searchHotelAction(Request $request)
	{
		$security = $this->container->get ( 'security.context' );
		 
		$user = $security->getToken ()->getUser ();
		 
		if (! $security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
			 
			return $this->redirect ( $this->generateUrl ('room_security_user_login') );
			 
		}
		$em = $this->getDoctrine()->getManager();
		$hotels = $em->getRepository('RoomHotelBundle:Hotel')->findAll();
		return $this->render('RoomHotelBundle:Default:hotel-search.html.twig', array(
				//'form'   => $form->createView(),
				'hotels'=> $hotels
		));
	}
	
	public function editHotelAction(Request $request,$id)
	{
		$security = $this->container->get ( 'security.context' );
		 
		$user = $security->getToken ()->getUser ();
		 
		if (! $security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
			 
			return $this->redirect ( $this->generateUrl ('room_security_user_login') );
			 
		}
		$em = $this->getDoctrine()->getManager();
		$hotelObj = $em->getRepository('RoomHotelBundle:Hotel')->find($id);
		$hotelDetail = new HotelDto();
		$hotelImage = new HotelImage();
		
		$hotelRooms =$hotelObj->getHotelRooms();
		$oldHotelRooms = array();
		foreach($hotelRooms as $hotelRoomObj){
			$hotelRoom  =new HotelRoomDto();
			$hotelRoom->setId ($hotelRoomObj->getId() );
			$hotelRoom->setRoomType ($hotelRoomObj->getRoomType() );
			$hotelRoom->setCapacity ($hotelRoomObj->getCapacity() );
			$hotelRoom->setPrice ($hotelRoomObj->getPrice() );
			$hotelRoom->setMaxAdult ($hotelRoomObj->getMaxAdult() );
			$hotelRoom->setMaxChild ($hotelRoomObj->getMaxChild() );
			$hotelRoom->setDescription ($hotelRoomObj->getDescription() );
			$hotelRoom->setName ($hotelRoomObj->getName() );
			$hotelRoomList = $hotelDetail->getRoomList();
			$hotelRoomList->add($hotelRoom);
			
			$oldHotelRooms[$hotelRoomObj->getId()] = $hotelRoomObj;
		}
		
		$hotelImageList = $hotelDetail->getImageList();
		$hotelImageList->add($hotelImage);
		
		$catalogueService = $this->container->get( 'catalogue.service' );
			
		
		$hotelDetail->setName($hotelObj->getName());
		$hotelDetail->setOverview($hotelObj->getOverview());
		$hotelDetail->setPropertyType($hotelObj->getPropertyType());
		$hotelDetail->setCategory($hotelObj->getCategory());
		$hotelDetail->setCheckIn($hotelObj->getCheckIn());
		$hotelDetail->setCheckOut($hotelObj->getCheckOut());
		$hotelDetail->setPrice($hotelObj->getPrice());
		$hotelDetail->setCity($hotelObj->getCityId());
		$hotelDetail->setNumRooms($hotelObj->getNumRooms());
		$hotelDetail->setSoldOut($hotelObj->getSoldOut());
		$hotelDetail->setPriority($hotelObj->getPriority());
		//$HotelObj->setCityId($hotelObj->getCityId());
		$hotelDetail->setActive($hotelObj->getActive());
		
		$hotelAddressObj = $hotelObj->getAddress();
		
		$hotelDetail->setAddressLine1($hotelAddressObj->getAddressLine1());
		$hotelDetail->setAddressLine2($hotelAddressObj->getAddressLine2());
		$hotelDetail->setLocation($hotelAddressObj->getLocation());
		$hotelDetail->setPincode($hotelAddressObj->getPincode());
		
		 
		$form = $this->createForm(new HotelDetailType($catalogueService),$hotelDetail);
		$form->add('submit','submit', array('label' => 'Update'));
		$form ->handleRequest($request);
		 
		
		
		
		
		if($form->isValid()) {
			 
			
			$cities = $catalogueService->getCities();
			$cities = $catalogueService->getById($cities);
				
			$selectedCity = $cities[$hotelDetail->getCity()];
	
			$hotelObj->setName($hotelDetail->getName());
			$hotelObj->setOverview($hotelDetail->getOverview());
			$hotelObj->setPropertyType($hotelDetail->getPropertyType());
			$hotelObj->setCategory($hotelDetail->getCategory());
			$hotelObj->setCheckIn($hotelDetail->getCheckIn());
			$hotelObj->setCheckOut($hotelDetail->getCheckOut());
			$hotelObj->setPrice($hotelDetail->getPrice());
			$hotelObj->setCity($selectedCity->getName());
			$hotelObj->setNumRooms($hotelDetail->getNumRooms());
			$hotelObj->setSoldOut($hotelDetail->getSoldOut());
			$hotelObj->setPriority($hotelDetail->getPriority());
			$hotelObj->setCityId($selectedCity->getId());
			$hotelObj->setActive($hotelDetail->getActive());
	
			$hotelAddressObj->setAddressLine1($hotelDetail->getAddressLine1());
			$hotelAddressObj->setAddressLine2($hotelDetail->getAddressLine2());
			$hotelAddressObj->setLocation($hotelDetail->getLocation());
			$hotelAddressObj->setPincode($hotelDetail->getPincode());
			$hotelAddressObj->setCity($selectedCity->getName());
			$hotelAddressObj->setCityId($selectedCity->getId());
	
	
			$hotelObj->setAddress($hotelAddressObj);
			$hotelAddressObj->setHotel($hotelObj);
			//$hotelObj->setImages($hotelDetail->getImages());
			//$hotelObj->setAmenities($hotelDetail->getAmenities());
			
			
			
			$hotelImageList = $hotelDetail->getImageList();
			$hotelImages = new ArrayCollection();
			foreach($hotelImageList as $hotelImage){
				$uploadedfile = $hotelImage->getImagePath ();
				if (!is_null($uploadedfile)) {
					$file_name = $uploadedfile->getClientOriginalName ();
					$dir = 'img/Hotels/';
					$uploadedfile->move ( $dir, $file_name );
					$hotelImage->setImagePath ($file_name );
					$hotelImage->setActive (1);
					$hotelImage->setHotel($hotelObj);
					$hotelImages->add($hotelImage);
						
				}
					
			}
			
			$hotelRoomList = $hotelDetail->getRoomList();
			$hotelRooms =$hotelObj->getHotelRooms();
			foreach($hotelRoomList as $hotelRoom){
				$roomType = $hotelRoom->getRoomType();
				$capacity = $hotelRoom->getCapacity();
				$price = $hotelRoom->getPrice();
				$imagePath = $hotelRoom->getImagePath();
				$maxAdult = $hotelRoom->getMaxAdult();
				$maxChild = $hotelRoom->getMaxChild();
				$description = $hotelRoom->getDescription();
				$name = $hotelRoom->getName();
			
				//echo var_dump($hotelRoom->getId());
				$hotelRoomObj  =new HotelRoom();
				if(!is_null($hotelRoom->getId()))
					$hotelRoomObj = $oldHotelRooms[$hotelRoom->getId()];
				$hotelRoomObj->setRoomType ($roomType );
				$hotelRoomObj->setCapacity ($capacity );
				$hotelRoomObj->setPrice ($price );
				$hotelRoomObj->setMaxAdult ($maxAdult );
				$hotelRoomObj->setMaxChild ($maxChild );
				$hotelRoomObj->setDescription ($description );
				$hotelRoomObj->setName ($name );
			//echo var_dump($hotelRoomObj);
				$uploadedfile = $hotelRoom->getImagePath ();
				if (!is_null($uploadedfile)) {
					$file_name = $uploadedfile->getClientOriginalName ();
					$dir = 'img/Hotels/';
					$uploadedfile->move ( $dir, $file_name );
					$hotelRoomObj->setImagePath ($file_name );
					//$hotelRoom->setActive (1);
					$hotelRoomObj->setHotel($hotelObj);
			
				}
				$hotelRooms->add($hotelRoomObj);
			
			}
			
			//exit();
	
			$hotelObj->setImages($hotelImages);
			
	
			$em->merge($hotelObj);
	
			$em->flush();
			/*
			 $this->addFlash(
			 		'Notice',
			 		'Hotel Detail Added'
			 ); */
	
			return $this->redirect ( $this->generateUrl ( "room_hotel_search_hotel" ) );
		}
		 
		return $this->render('RoomHotelBundle:Default:add-hotel.html.twig',array(
	
				'form' => $form->createView(),
		));
	
	}


}
