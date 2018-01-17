<?php

namespace Room\BookingEngineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Room\BookingEngineBundle\Form\SearchType;
use Room\BookingEngineBundle\Form\FilterType;
use Room\BookingEngineBundle\Form\CustomerType;
use Room\BookingEngineBundle\DTO\Search;
use Room\BookingEngineBundle\Entity\Customer;
use Room\BookingEngineBundle\Entity\Booking;
use Room\HotelBundle\Entity\Hotel;
use Room\HotelBundle\Entity\HotelRoom;
use Room\BookingEngineBundle\Entity\BookingPaymentEntity;
class BookingController extends Controller
{ 

	/**
	 *
	 * @param Search $entity
	 * @return unknown
	 */
	private function createSearchForm(Search $dto){
		$catalogueService = $this->container->get( 'catalogue.service' );
		$form = $this->createForm(new SearchType($catalogueService), $dto, array(
				'action' => $this->generateUrl('room_booking_engine_search'),
				'method' => 'GET',
		));
		 
		return $form;
	}
	/**
	 *
	 * @param Search $entity
	 * @return unknown
	 */
	private function createFilterForm(Search $dto,$filters){
		$form = $this->createForm(new FilterType($filters), $dto, array(
				'action' => $this->generateUrl('room_booking_engine_filter'),
				'method' => 'GET',
		));
			
		return $form;
	}
	/**
	 * 
	 */
	public function indexAction()
	{
		//$mailService = $this->container->get( 'mail.services' );
		//$mailService->mail('mmshivukumar@gmail.com','Just Trip:Booking Confirmation','this is test');
			//$mailService = $this->container->get( 'mail.services' );
    		
    		//$mailService->mail('kishan.kish530@gmail.com','kishan test','this is kishan test');
		$footerDisplay=1;
		$serviceApartment = $this->getDoctrine()
		->getRepository('RoomHotelBundle:Hotel')
		->findBy( array('footerDisplay' => $footerDisplay));
		
		
		
		$search = new Search();
		$search->setNumAdult(1);
		$search->setNumRooms(1);
		$form   = $this->createSearchForm($search);
		return $this->render('RoomBookingEngineBundle:Default:index.html.twig', array(
                'form'   => $form->createView(),
				'serviceApartments' =>$serviceApartment,
				'search'=>$search               
            ));
	}
	/**
	 * 
	 */
	public function addRoomAction(Request $request){
		
		$room = new Room;
		return $this->render('RoomBookingEngineBundle:Default:index.html.twig', array(
				'form'   => $form->createView(),
				'search'=>$search
		));
	}
	/**
	 * 
	 * @param Request $request
	 */
    public function searchAction(Request $request)
    {
    	
    	
    	$hotels = array();
    	$search = new Search();    	
    	$form   = $this->createSearchForm($search);
    	$form->handleRequest($request);
    	
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$hotels = $catalogueService->getHotelsByCity($search->getCity());
    	
    	
    	$amenities = $catalogueService->getAmenities();
    	
    	
    	
    	
    	$from = $search->getCheckIn();
    	
    	//$numAdult = $search->getNumAdult();
    	//$numRooms = $search->getNumRooms();
    	//$numChildren = $search->getNumChildren();
    	
    	
    	$to = $search->getCheckOut();
    	//echo var_dump($search->getCheckIn());
    	//exit();
    		
    	$numDays = $from->diff($to);
    	
    	if($from==$to){
    		
    		$numDay = 1;
    		//echo var_dump($numDay);
    		//exit();
    	}
    	else{
    	$numDay = (int)$numDays->format('%a');
    	}
    	$numRoom = $search->getNumRooms();
    	
    	//echo var_dump($numRoom);
    	//exit();
    	
    	$filters = $catalogueService->getFilters($hotels,$amenities);
    	
    	
    	
    	//var_dump($filters);
    	//exit();
    	//echo var_dump($filters);
    	//exit();
    	$search->setMinPrice($filters['price']['minPrice']);
    	$search->setMaxPrice($filters['price']['maxPrice']);
    	$search->setMin($filters['price']['minPrice']);
    	$search->setMax($filters['price']['maxPrice']);
    	$session = $request->getSession();
    	$session->set('search',$search);
    	$session->set('hotels',$hotels);
    	$session->set('filters',$filters);
    	
    	$session->set('numDay',$numDay);
    	
    	
    	$session->set('numRoom',$numRoom);
    //	$session->set('numAdult',$numAdult);
    	//$session->set('numChildren',$numChildren);
    	$today = new \DateTime();
    	//$today = $today->format('Y-m-d');
    	
    	
    	//echo var_dump($search);
    	//exit();
    	//me
    	$em = $this->getDoctrine ()->getManager ();
    	$qb = $em->getRepository ( 'RoomBookingEngineBundle:Booking' )->createQueryBuilder("Booking");
    	$qb ->select('Booking.hotelId','count(Booking.hotelId) as bookedroom')
    	->andWhere('(:from BETWEEN Booking.chekIn AND Booking.chekOut OR :to BETWEEN Booking.chekIn AND Booking.chekOut)' ) ->setParameter('from', $from ) ->setParameter('to', $to)
    	->groupBy('Booking.hotelId');
    	$Booking_hotel = $qb->getQuery()->getResult();
    	
    	//echo var_dump($numRoom);
    	//echo var_dump($Booking_hotel);
    	//exit();
    	
    	$roomCountByHotel = array();
    	
    	foreach ( $Booking_hotel as $bookedHotel ) {
    		
    		//echo var_dump([$bookedHotel['hotelId']]);
    		
    		$roomCountByHotel[$bookedHotel['hotelId']]=$bookedHotel['bookedroom'];

    	}
    	
    	$hotels = $catalogueService->getavailablerooms($hotels,$roomCountByHotel);
    	//echo var_dump($hotels);
    	//exit();
    	
    	
    	
    	
    	$filterForm   = $this->createFilterForm($search,$filters);
    		   		
    	return $this->render('RoomBookingEngineBundle:Default:search.html.twig', array(
                'form'   => $form->createView(),     
    			'filterForm'   => $filterForm->createView(),
    			'hotels'=>$hotels,
    			'roomCountByHotel'=>$roomCountByHotel,
    			'numDay'=>$numDay,
    			'Booking_hotel'=>$Booking_hotel,
    			'today'=>$today,    			
    			'search'=>$search,
    			'numRoom'=>$numRoom,
         ));
            
    }
    /**
     *
     * @param Request $request
     */
    public function filterAction(Request $request)
    {
    	$session = $request->getSession();
    	$hotels = array();
    	$search = $session->get('search');
    	$form   = $this->createSearchForm($search);
    	
    	$hotels = $session->get('hotels');
    	$filters = $session->get('filters');
    	$numRoom = $session->get('numRoom');
    	
    	$filterForm   = $this->createFilterForm($search,$filters);   	
    	$filterForm->handleRequest($request);
    	
    	$price = $search->getPrice();
    	$minMaxPrice = explode ( ";", $price );
    	$minPrice = ( float ) $minMaxPrice [0];
    	$maxPrice = ( float ) $minMaxPrice [1];
    	$search->setMinPrice($minPrice);
    	$search->setMaxPrice($maxPrice);
    	
    	$today = new \DateTime();
    	
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$hotels = $catalogueService->filterHotels($search,$hotels,$minPrice,$maxPrice);
    		
    	return $this->render('RoomBookingEngineBundle:Default:search.html.twig', array(
    			'form'   => $form->createView(),
    			'filterForm'   => $filterForm->createView(),
    			'hotels'=>$hotels,
    			'search'=>$search,
    			'today'=>$today,
    			'numRoom'=>$numRoom,
    	));
    
    }
    /**
     * 
     * @param Request $request
     * @param unknown $id
     */
    public function viewMoreAction(Request $request,$id)
    {
    	$session = $request->getSession();
    	$search = $session->get('search');
    	$promotionPrice = $request->get('promotionprice');
    	$promotionStartDate  = $request->get('promotionStartDate ');
    	$promotionEndDate = $request->get('promotionEndDate ');
    	//$numRooms = $session->get('search');
    	//echo var_dump($promotionPrice);
    	//exit();
    	
    	//echo var_dump($search->getCheckIn());
    	//exit();
    	if($search==null){
    		
    		$search = new Search();
    		$search->setNumAdult(2);
    		$search->setNumRooms(1);
    		
    		$fromDate = new \DateTime();
    		$toDate = new \DateTime();
    		$fromDate = $fromDate->modify('+5 day');
    		$toDate = $toDate->modify('+6 day');
    	
    		//$from = $search->setCheckIn($fromDate+ '5day');
    		//$to = $search->setCheckOut($toDate+ '6day');
    		
    	
    		$from = $search->setCheckIn($fromDate);
    		$to = $search->setCheckOut($toDate);
    		$numRoom='1';
    		$hotels = $search->setCity('Bangalore');
    		//echo var_dump($search);
    		//exit();
    		$session->set('numRoom',$numRoom);
    		$session->set('search',$search);
    		$session->set('hotels',$hotels);
    		
    	}else{
    	$numRoom=$search->getNumRooms();
    	//$form   = $this->createSearchForm($search);
    //	$search = new Search();
    	}
    	$form   = $this->createSearchForm($search);
    	$em = $this->getDoctrine()->getManager();
    	$hotel = $em->getRepository('RoomHotelBundle:Hotel')->find($id);
    	
    	//var_dump($hotel);
    	//exit();
    	
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$hotel = $catalogueService->getMinPrice($hotel);
    	$hotel = $catalogueService->getRoomsBySequence($hotel);
    	$roomPrice=$hotel->getPrice();
    	$hotel->setPrice($roomPrice*$numRoom);
    	$today = new \DateTime();
    	//$today = $today->format('d/m/Y');
    	
    	    	
    	
    	$viewMore=0;
    	return $this->render('RoomBookingEngineBundle:Default:view-more.html.twig', array(
    			'form'   => $form->createView(),
    			'hotel'=> $hotel,
    			'viewMore'=> $viewMore,
    			'search'=>$search,
    			'today'=>$today,
    			'promotionPrice'=>$promotionPrice,
    			'promotionStartDate'=>$promotionStartDate,
    			'promotionEndDate'=>$promotionEndDate,
    	));
    }
    
    
    /**
     * 
     * @param Customer $dto
     * @return unknown
     */
    private function createBookingForm(Customer $dto){
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$form = $this->createForm(new CustomerType($catalogueService), $dto, array(
    			'action' => $this->generateUrl('room_booking_engine_booking_submit'),
    			'method' => 'POST',
    	));
    		
    	return $form;
    }
    
    /**
     *
     * @param Request $request
     */
    public function ConfirmAction(Request $request)
    {
    	 
    	
    	
    	$id = $request->get('id');
    	$room = $request->get('room');
    	$session = $request->getSession();
    	
    	$numDay = $session->get('numDay');
    	$numRoom = $session->get('numRoom');
    	if($numDay==null && $numRoom==null){
    		$numDay=1;
    		$numRoom = 1;
    	}
    	
    	
    	
  // var_dump($numDay);
    	//exit();
    //	 var_dump($numRoom);
    	//exit();
    	
    	$search = $session->get('search');
    	//var_dump($search);
    	//exit();
    	
    	$customer = new Customer();
    	$form   = $this->createBookingForm($customer);
    	$em = $this->getDoctrine()->getManager();
    	$hotel = $em->getRepository('RoomHotelBundle:Hotel')->find($id);
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$selectedRoom = $catalogueService->getSelectedRoom($hotel,$room);
    	$booking = new Booking();
    	$price = $selectedRoom->getPrice();
    	
    	$promotionStartDate = $selectedRoom->getPromotionStartDate();
    	$promotionEndDate = $selectedRoom->getPromotionEndDate();
    	$rooomPromoprice = $selectedRoom->getPromotionPrice();
    	$roomType = $selectedRoom->getRoomType();
    	$today = new \DateTime();
    	//$today = $today->format('d/m/Y');
    	if(($promotionStartDate<=$today) && ($today<=$promotionEndDate) )
    	{	
    	
    	$newtotalprice = $rooomPromoprice*$numDay*$numRoom;
    	}
    	else
    	{
    		$newtotalprice = $price*$numDay*$numRoom;
    	}
    	
    	//$hotel->setPromotionPrice($rooomPromoprice*$numRoom);
    	//var_dump($newtotalprice);
    	//exit();
    	//me
    	
    	
    	$serviceTax = 0;
    	$taxPercentage = 0;
    	/*if($price>999 && $price<2500){
    		$taxPercentage = 12;
    	}elseif($price>2499 && $price<5000){
    		$taxPercentage = 18;
    	}elseif($price>4999){
    		$taxPercentage = 28;
    	}*/
    	
    	if($newtotalprice>999 && $newtotalprice<2500){
    		$taxPercentage = 12;
    	}elseif($newtotalprice>2499 && $newtotalprice<5000){
    		$taxPercentage = 18;
    	}elseif($newtotalprice>4999){
    		$taxPercentage = 28;
    	}
    
    	//$serviceTax = round(($price*$numDay*$taxPercentage/100),2);
    	$serviceTax = round(($newtotalprice*$taxPercentage/100),2);
    //	$serviceTax = round($price*($taxPercentage/100),2);
    	//$swachBharthCess = round($finalPrice*(0.9/100),2);
    	//$krishiKalyanCess = round($finalPrice*(0.9/100),2);
    	$totalTax = $serviceTax;
    	//$finalPrice = $price+$totalTax;
    	$finalPrice = $newtotalprice+$totalTax;
    //me	$booking->setTotalPrice($price);
    
    	$booking->setTotalPrice($newtotalprice);
    	$booking->setServiceTax($serviceTax);
    	$booking->setDiscount(0);
    	$booking->setCouponApplyed(0);
    	$booking->setFinalPrice($finalPrice);
    	
    	//echo var_dump($booking);
    	//exit();
    	
    	$session->set('taxPercentage',$taxPercentage);
    	$session->set('booking',$booking);
    	
    	return $this->render('RoomBookingEngineBundle:Default:confirm.html.twig', array(
    			'form'   => $form->createView(),
    			'customer'=> $customer,
    			'hotel'=> $hotel,
    			'room'=>$room,
    			'booking'=> $booking,
    			'search'=>$search,
    			'step'=> 'review',
    			 'numDay'=>$numDay,
    			 'numRoom'=>$numRoom,
    			'price'=>$price,
    			'today'=>$today,
    			'rooomPromoprice'=>$rooomPromoprice,
    			'promotionStartDate'=>$promotionStartDate,
    			'promotionEndDate'=>$promotionEndDate,
    			'taxPercentage'=>$taxPercentage,
    			'roomType'=>$roomType,
    		
    	));
    }
    /**
     * 
     * @param Request $request
     */
    public function bookingAction(Request $request)
    {
    	
    	$id = $request->get('id');
    	$room = $request->get('room');
    	$taxPercentage = $request->get('taxPercentage');
    	$session = $request->getSession();
    	$search = $session->get('search');
    	
    	$numDay = $session->get('numDay');
    	$numRoom = $session->get('numRoom');
    	
    	//echo var_dump($numRoom);
    	//exit();
    	
    	$customer = new Customer();
    	$form   = $this->createBookingForm($customer);
    	$em = $this->getDoctrine()->getManager();
    	$hotel = $em->getRepository('RoomHotelBundle:Hotel')->find($id);
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$selectedRoom = $catalogueService->getSelectedRoom($hotel,$room);
    	
    	
    	
    	
    	
    	$session->set('selected',$hotel);
    	
    	$session->set('selectedRoom',$selectedRoom);
    	$booking = $session->get('booking');
    	
    	
    	//echo var_dump($booking);
    	//exit();
    	
    	$price = $selectedRoom->getPrice();
    	$promotionStartDate = $selectedRoom->getPromotionStartDate();
    	$promotionEndDate = $selectedRoom->getPromotionEndDate();
    	$rooomPromoprice = $selectedRoom->getPromotionPrice();
    	$roomType = $selectedRoom->getRoomType();
    	$today  = new \DateTime();
    	return $this->render('RoomBookingEngineBundle:Default:booking.html.twig', array(
    			'form'   => $form->createView(),
    			'customer'=> $customer,
    			'hotel'=> $hotel,
    			'booking'=> $booking,
    			'search'=>$search,
    			'step'=> 'review',
    			'numDay'=>$numDay,
    			'numRoom'=>$numRoom,
    			'today'=>$today,
    			'price'=>$price,
    			'rooomPromoprice'=>$rooomPromoprice,
    			'promotionStartDate'=>$promotionStartDate,
    			'promotionEndDate'=>$promotionEndDate,
    			'taxPercentage'=>$taxPercentage,
    			'roomType'=>$roomType,
    	));
    }
    public function bookingSubmitAction(Request $request)
    {
    
    	//return $this->redirect ( $this->generateUrl ( "room_booking_engine_success" ) );
    	$session = $request->getSession();
    	$resultSet = $session->get('resultSet');
    	$searchFilter = $session->get('search');
    	$selectedService = $session->get('selected');
    	$selectedRoom = $session->get('selectedRoom');
    	$bookingOld = $session->get('booking');
    	$taxPercentage = $session->get('taxPercentage');
    	
    	
    	//booking details values
    	$bookingDetails = $session->get('bookingDetails');
    
    
    	$customer = new Customer();
    	$form   = $this->createBookingForm($customer);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		//$couponCode = $customer->getCouponCode();
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($customer);
    		$em->flush();
    		$session->set('customer',$customer);

    		$price = $selectedService->getPrice();
    		$finalPrice = $price;
    		
    		$booking = new Booking();
    		$booking->setCustomerId($customer->getId());
    		$booking->setBookingId($this->getBookingId());
    		$booking->setTotalPrice($price);
    		$booking->setFinalPrice($finalPrice);
    		$booking->setStatus('pending');
    		$booking->setJobStatus('Open');
    		$booking->setBookedOn(new \DateTime());
    		//$booking->setNumDays($searchFilter->getNumDays());
    		$booking->setNumAdult($searchFilter->getNumAdult());
    		
    		//$child = $searchFilter->getNumChildren();
    		//var_dump($child);
    		//exit();
    		
    		$booking->setNumChildren($searchFilter->getNumChildren());
    		
    		
    		
    		$booking->setChekIn($searchFilter->getCheckIn());
    		$booking->setChekOut($searchFilter->getCheckOut());
    		
    		$booking->setNumRooms($searchFilter->getNumRooms());
    		
    		$address = $selectedService->getAddress();
    		$booking->setHotelId($selectedService->getId());
    		$booking->setRoomId($selectedRoom->getId());
    		$booking->setHotelName($selectedService->getName());
    		$booking->setLocation($address->getLocation());
    		//$booking->setNumRooms(0);
    		
    		$booking->setTotalPrice($bookingOld->getTotalPrice());
    		$booking->setDiscount($bookingOld->getDiscount());
    		$booking->setServiceTax($bookingOld->getServiceTax());
    		$booking->setFinalPrice($bookingOld->getFinalPrice());
    		$booking->setCouponApplyed($bookingOld->getCouponApplyed());
    		$booking->setCouponCode($bookingOld->getCouponCode());
    		$booking->setAdminCoupon($bookingOld->getAdminCoupon());
    		
    		//echo var_dump($searchFilter->getNumRooms());
    	//	echo var_dump($taxPercentage);
    		//exit();
    		
    		
    		$em->persist($booking);
    		$em->flush();
    		

    		//$selectedService->setNumRooms($selectedService->getNumRooms() - 1);
    		
    		//echo var_dump($selectedService);
    		//exit();
    		 
    		
    		//echo var_dump($searchFilter);
    			//exit();
    		
    		//$em->merge($selectedService);
    		//$em->flush();
    		$amountToPay = $booking->getFinalPrice();
    		$session->set('bookingObj',$booking);
    		$session->set('amountToPay',$amountToPay);
    		
    		//$redirectUrl = $this->generateUrl ( 'drive_booking_engine_payment_success' );
    		//$redirectUrl = $this->generateUrl ( 'room_booking_engine_payment_confirmation' );
    		
    		$redirectUrl = $this->generateUrl( 'room_booking_engine_payment_confirmation' );
    		$paymentLink = $this->getPaymentLink($request,$amountToPay,$customer,$booking,$redirectUrl);
    		
    		
    		
    		//echo var_dump($paymentLink);
    		//exit();
    		
    		
    		//$paymentLink = "https://www.instamojo.com/Waseemsyed/tirupati-caars-services-cb8a4/";
    //m	 $paymentLink.="?data_name=".$customer->getName()."&data_email=".$customer->getEmail()."&data_phone=".$customer->getMobile()."&embed=form";
    		//$paymentLink = $this->generateUrl ( 'room_booking_engine_payment_payu' );
    		//$paymentLink = $this->getPaymentLink($amountToPay,$redirectUrl);
    		
    		$payuLink = $this->generateUrl ( 'room_booking_engine_payment_payu' );
    		


    		$security = $this->container->get ( 'security.context' );
    		 
    		$user = $security->getToken ()->getUser ();
    		 
    		if ($security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
    		
    			$mailer = $this->renderView(
    					'RoomBookingEngineBundle:Mail:pending_invoice.html.twig',array(
    							'booking' => $booking,
    							'customer' => $customer,
    							'searchFilter'=>$searchFilter,
    							'selectedRoom'=>$selectedRoom,
    							'selectedService'=>$selectedService,
    							'address'=>$address
    								
    					)
    			);
    			$subject = "Booking has been placed -".$booking->getBookingId();
    			$adminSubject = "New Booking From Sterling-".$booking->getBookingId();
    			$mailService = $this->container->get( 'mail.services' );
    			$email=$customer->getEmail();
    			$mailService->mail($email,$subject,$mailer);
    			$mailService->mail('info@sterlingsuites.in',$adminSubject,$mailer);
    		
    		}

    		
    		
    		return $this->render('RoomBookingEngineBundle:Default:payment.html.twig', array(
    				'customer'   => $customer,
    				'booking'   => $booking,
    				'service'=>$selectedService,
    				'filter'=>$searchFilter,
    				'paymentLink'   => $paymentLink,
    				'taxPercentage'=>$taxPercentage,
    				'payuLink'=>$payuLink,
    				
    				'bookingDetails' =>$bookingDetails,
    				'form'   => $form->createView(),
    				
    		));
    	}

    	return $this->render('RoomBookingEngineBundle:Default:booking.html.twig', array(
    			'form'   => $form->createView(),
    			'customer'=> $customer,
    			
    	));
    
    }
    
    /**
     *
     */
    public function payOnlineAction(Request $request,$bookingId){
    	
    	//$session = $request->getSession();
    	//$resultSet = $session->get('resultSet');
    	//$searchFilter = $session->get('search');
    	//$selectedService = $session->get('selected');
    	//$selectedRoom = $session->get('selectedRoom');
    	//$booking = $session->get('booking');
    	//$customer = $session->get('customer');
    	
    	//$bookingDetails = $session->get('bookingDetails');
    	$session = $request->getSession();
    	$em = $this->getDoctrine()->getManager();
    	$bookingEntity = $em->getRepository('RoomBookingEngineBundle:Booking')->findBy( array('bookingId' => $bookingId));
    	$booking=$bookingEntity[0];
    	
    	//var_dump($booking);
    //	var_dump($bookingEntity->getFinalPrice());
    	
    	
    	$amountToPay = $booking->getFinalPrice();
    	$customerId = $booking->getCustomerId();
    	$customer = $em->getRepository('RoomBookingEngineBundle:Customer')->findBy( array('id' => $customerId));
    	//var_dump($customer);
    	//exit();
    	$customer=$customer[0];
    	$redirectUrl = $this->generateUrl( 'room_booking_engine_customer_payment_confirmation' );
    	$paymentLink = $this->getPaymentLink($request,$amountToPay,$customer,$booking,$redirectUrl);
    	
    	$session->set('booking',$booking);
    	$session->set('customer',$customer);
    	//$session->set('booking',$booking);
    	//var_dump($paymentLink);
    	//exit();
    	
    //	$security = $this->container->get ( 'security.context' );
    	 
    //	$user = $security->getToken ()->getUser ();
    	
    	return $this->render('RoomBookingEngineBundle:Default:payment.html.twig', array(
    			'customer'   => $customer,
    			'booking'   => $booking,
    			
    			
    			'paymentLink'   => $paymentLink,
    	   			
    	
    			
    			
    	
    	));
    	
    }
   
    /**
     *
     */
    public function successAction()
    {
    	$error = null;
    	return $this->render('RoomBookingEngineBundle:Default:success.html.twig',
    	array('error' =>$error));
    }
    private function getBookingId(){
    	$characters = 'A5B0CD9EFG1HIJ3KLM46NOPQR7STUV8WXYZ';
    	$bookingId = 'SH';
    	date_default_timezone_set('Asia/Kolkata');
    	$current=date('d/m/Y');
    	list ( $d, $m, $y ) = explode ( '/', $current );
    	$bookingId.=$d.$m.substr($y,2);
    	for ($i = 0; $i < 4; $i++) {
    		$bookingId .= $characters[rand(0,strlen($characters)-1)];
    	}
    	return $bookingId;
    }
    
    
    
    
    public function applyCouponAction() 
    
    {
    	$request = $this->container->get ( 'request' );
    	$session = $request->getSession ();
    	$booking = $session->get('booking');
    	
    	
    	$newcoupon = $request->get ( "coupon" );
    	//$newcoupon='FREE100';
    	$searchcoupon = array();
    	//$searchcoupon = $this->getDoctrine()
    	//->getRepository('RoomHotelBundle:CouponCode')
    	//->findBy( array('couponCode' => $newcoupon));
    	
    	date_default_timezone_set('Asia/Kolkata');
    	
    	$today = new \DateTime();
    	$em = $this->getDoctrine ()->getManager();
    	$qb = $em->getRepository ('RoomHotelBundle:CouponCode')->createQueryBuilder("c");
    	$qb 
    	->Where(':today between c.startDate and c.expireDate')
    	->andWhere('c.couponCode = :couponCode')
    	->setParameter('today', $today )
    	->setParameter('couponCode', $newcoupon) ;
    	$searchcoupon = $qb->getQuery()->getResult();
    	
    
    $response = array();
    $bookingDetails = array();
    $response['success'] = 'false';
    $response['message'] = '';
	  if(count($searchcoupon)>0)
	  {
	  	
	  	$response['success'] = 'true';
    	foreach ($searchcoupon as $coupan)
    	{
    	$discount=$coupan->getAmount();	
    	}
    	$oldDiscount = $booking->getDiscount();
    	$finalPrice = $booking->getFinalPrice()+$oldDiscount-$discount;
    	$booking->setFinalPrice($finalPrice);
    	$booking->setDiscount($discount);
    	$booking->setCouponApplyed(1);
    	$booking->setCouponCode($newcoupon);
    	$bookingDetails['finalPrice'] = $finalPrice;
    	$bookingDetails['discount'] = $discount;
	  }
	  else
	  {
	  	$response['message'] = 'coupon code '.$newcoupon.' doesnt exist ';
	  
	  }

	  
	  $response['bookingDetails'] = $bookingDetails;
	  $session->set('bookingDetails',$bookingDetails);
	  		
	  return new Response (json_encode($response));
    	
    
    }
    
    
    
    public function adminapplyCouponAction()
    
    {
    	$request = $this->container->get ( 'request' );
    	$session = $request->getSession ();
    	$booking = $session->get('booking');
    	 
    	 
    	$newcoupon = $request->get ( "admincoupon" );
    	//$newcoupon='FREE100';
    	$searchcoupon = array();
    	//$searchcoupon = $this->getDoctrine()
    	//->getRepository('RoomHotelBundle:CouponCode')
    	//->findBy( array('couponCode' => $newcoupon));
    	 
    	date_default_timezone_set('Asia/Kolkata');
    	 
    	$today = new \DateTime();
    	$em = $this->getDoctrine ()->getManager();
    	/*$qb = $em->getRepository ('RoomHotelBundle:CouponCode')->createQueryBuilder("c");
    	$qb
    	->Where(':today between c.startDate and c.expireDate')
    	->andWhere('c.couponCode = :couponCode')
    	->setParameter('today', $today )
    	->setParameter('couponCode', $newcoupon) ;
    	$searchcoupon = $qb->getQuery()->getResult(); */
    	 
    
    	$response = array();
    	$bookingDetails = array();
    	$response['success'] = 'false';
    	$response['message'] = '';
    	//if(count($searchcoupon)>0)
    	//{
    
    		$response['success'] = 'true';
    		//foreach ($searchcoupon as $coupan)
    		//{
    		//$discount=$coupan->getAmount();
    			$discount=$newcoupon;
    		//}
    		$oldDiscount = $booking->getDiscount();
    		
    		
    		$finalPrice = $booking->getFinalPrice()+$oldDiscount-$discount;
    		
    		$booking->setFinalPrice($finalPrice);
    		$booking->setDiscount($discount);
    		$booking->setCouponApplyed(1);
    		$booking->setAdminCoupon($newcoupon);
    		$bookingDetails['finalPrice'] = $finalPrice;
    		$bookingDetails['discount'] = $discount;
    		
    	//}
    	//else
    	//{
    		//$response['message'] = 'coupon code '.$newcoupon.' doesnt exist ';
    		 
    	//}
    
    	 
    	$response['bookingDetails'] = $bookingDetails;
    	$session->set('bookingDetails',$bookingDetails);
    	 
    	return new Response (json_encode($response));
    	 
    
    }
    
    
    
    
    
    
public function serviceDetailAction(Request $request,$url)
    {
    	$numRoom=1;
    	$session = $request->getSession();
    	$search = $session->get('search');
    	
    	if($search!==null)
    	{
    		$numRoom=$search->getNumRooms();
    	}else{
    		
    		  		
    			$search = new Search();
    			$search->setNumAdult(2);
    			$search->setNumRooms(1);
    		
    			$fromDate = new \DateTime();
    			$toDate = new \DateTime();
    			$fromDate = $fromDate->modify('+5 day');
    			$toDate = $toDate->modify('+6 day');
    			 
    			//$from = $search->setCheckIn($fromDate+ '5day');
    			//$to = $search->setCheckOut($toDate+ '6day');
    		
    			 
    			$from = $search->setCheckIn($fromDate);
    			$to = $search->setCheckOut($toDate);
    			$numRoom='1';
    			$hotels = $search->setCity('Bangalore');
    			$session->set('search',$search);
    			$session->set('hotels',$hotels);
    		
    		
    	}
    //	$numRoom=$search->getNumRooms();
    //	$search = new Search();
    	
   // 	$form   = $this->createSearchForm($search);
    	$em = $this->getDoctrine()->getManager();
    	//$hotel = $em->getRepository('RoomHotelBundle:Hotel')->findby($url);
    	
    	$hotel = $em->getRepository('RoomHotelBundle:Hotel')->findBy( array('url' => $url));
    	
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$hotel = $catalogueService->getMinroom($hotel);
    	//echo var_dump($hotel);
    	//exit();
    	$promotionStartDate = $hotel->getPromotionStartDate();
    	$promotionEndDate = $hotel->getPromotionEndDate();
    	$promotionPrice = $hotel->getPromotionPrice();
    	//$hotel = $hotel[0];
    	
    	//echo var_dump($promotionStartDate);
    	//echo var_dump($promotionEndDate);
    	//echo var_dump($promotionPrice);
    	
    	//exit();
    	
    	$roomId = $hotel->getId();
    	$selectedRoom = $em->getRepository('RoomHotelBundle:HotelRoom')->findBy( array('id' => $roomId));
    	//$selectedRoom=$selectedRoom[0];
    	//echo var_dump($selectedRoom);
    	//exit();
    	
    	//findBy( array('footerDisplay' => $footerDisplay));
    	$today = new \DateTime();
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$hotel = $catalogueService->getMinPrice($hotel);
    	$roomPrice=$hotel->getPrice();
    	$hotel->setPrice($roomPrice*$numRoom);
    	$viewMore=1;
    	    //	echo var_dump($hotel->getAddressLine1());
    	    //	exit();
    	return $this->render('RoomBookingEngineBundle:Default:view-more.html.twig', array(
    //			'form'   => $form->createView(),
    			'hotel'=> $hotel,
    			'viewMore'=> $viewMore,
    			'search'=>$search,
    			'today'=>$today,
    			'promotionPrice'=>$promotionPrice,
    			'promotionStartDate'=>$promotionStartDate,
    			'promotionEndDate'=>$promotionEndDate,
    			
    			
    	));
    }
    
    
    
    
    
    public function payuAction(Request $request){
    	$session = $request->getSession ();
    	$customer = $session->get ( 'customer');
    	$booking = $session->get ( 'booking' );
    	$redirectUrl = $this->generateUrl( 'room_booking_engine_payment_confirmation' );
    	//$total = $booking->getFinalAmount();
    	
    	$finalPrice =$booking->getFinalPrice();
    	$bookingId = $booking->getBookingId();
    
    	
    	$data = $this->getData($request,$finalPrice,$bookingId,$customer,$redirectUrl);
    	$info = $this->curlCall($data);
    	
    	return $this->redirect($info['redirect_url']);
    }
    
    public function getPaymentLink($request,$amountToPay,$customer,$booking,$redirectUrl){
    	 
    	$session = $request->getSession ();
    	 
    	$bookingOld = $session->get('booking');
    	 
    	 
    	 
    //	$redirectUrl = $this->generateUrl ( 'room_booking_engine_payment_confirmation' );
    	$redirectUrl=$redirectUrl;
    	
    	$bookingId = $booking->getBookingId();
    	 
    	//echo var_dump($redirectUrl);
    	//exit();
    
    	 
    	$data = $this->getData($request,$amountToPay,$bookingId,$customer,$redirectUrl);
    	//echo var_dump($data);
    	//exit();
    	 
    	$info = $this->curlCall($data);
    	 
    	
    	
    	
    	 return  $data;
    	
    	
    	
    	$info['redirect_url']='https://test.payu.in/_payment';
    	
    	return $this->redirect($info['redirect_url']);
    	
    	//return $info['redirect_url'];
    }

   private function getData($request,$finalPrice,$bookingId,$customer,$redirectUrl){
	// Merchant key here as provided by Payu
	$MERCHANT_KEY = "rjQUPktU";

	//$MERCHANT_KEY = "OwPbxU2k";
	//$SALT = "aa70fUA5Hh";

	$SALT = "e5iIg1jwi8";

	// End point - change to https://secure.payu.in for LIVE mode
	//$PAYU_BASE_URL = "https://secure.payu.in";
	
	//testing Mode
	$PAYU_BASE_URL = "https://test.payu.in";
	 
	$action = $PAYU_BASE_URL . '/_payment';
	//$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
	$txnid = 'PAYU'.$bookingId;
	$mobile = $customer->getMobile ();
	$name = $customer->getName ();
	$email = $customer->getEmail ();
	$host = $request->getHost ();
	 
	$sUrl = 'http://' . $host . $redirectUrl.'?payment_id='.$txnid.'&status=success';
	$fUrl = 'http://' . $host . $redirectUrl.'?status=fail';
	 
	 
	$data = array();
	$data['key']= $MERCHANT_KEY;
	$data['txnid']= $txnid;
	$data['amount']= $finalPrice;
	$data['firstname']= $name;
	$data['email']= $email;
	$data['phone']= $mobile;
	$data['productinfo']= 'SterlingSuit services';
	$data['surl']= $sUrl;
	$data['furl']= $fUrl;
	$data['service_provider']= 'payu_paisa';
	$hash = $this->getHash($data,$SALT);
	$data['hash']= $hash;
	$data['action']= $action;
	
	
	return $data;
	
	
}


public function curlCall($data){
	$headers = array("application/x-www-form-urlencoded");
	$url = $data['action'];
	$postData = http_build_query($data);
	
	$curl = curl_init($data['action']);
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_exec($curl);
	$info = curl_getinfo($curl);
	
	if($errno = curl_errno($curl)) {
		$error_message = curl_strerror($errno);
		echo "cURL error ({$errno}):\n {$error_message}";
	}
	
	
	$errno = curl_errno($curl);
	//echo var_dump($errno);
	//echo var_dump(curl_strerror($errno));
	
	//echo var_dump($info);
	//exit();
	
	return $info;
}

private function getHash($data,$SALT){
	$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

	$hashVarsSeq = explode('|', $hashSequence);
	$hash_string = '';
	foreach($hashVarsSeq as $hash_var) {
		$hash_string .= isset($data[$hash_var]) ? $data[$hash_var] : '';
		$hash_string .= '|';
	}

	$hash_string .= $SALT;


	$hash = strtolower(hash('sha512', $hash_string));
	return $hash;
}


public function paymentconfirmationAction(Request $request)
{
	$session = $request->getSession();
	$booking = $session->get ( 'booking' );
	
	
	$bookingobj = $session->get ( 'bookingObj' );
	
	$selectedService = $session->get('selected');
	//echo var_dump($booking);
	//exit();
	
	//echo var_dump($bookingobj);
	//exit();
	$address = $selectedService->getAddress();
	//echo var_dump($selectedService);
	//exit();
	$customer = $session->get ( 'customer' );
	$payment_id = $request->get ( 'payment_id' );
	$paidAmount=$booking->getFinalPrice();
	$status = $request->get ( 'status' );
	
	$selectedRoom = $session->get('selectedRoom');
	$searchFilter = $session->get('search');
	
	//echo var_dump($searchFilter);
	//exit();
	
	
	
	
	
	//$numRooms = $selectedRoom->getNumRooms();
	
	//echo var_dump($numRooms);
	//exit();
	
	
	$bookingPaymentEntity =  null;
	
	
	
	/*if ($status == 'success'){
		
		$bookingobj->setStatus('booked');
	}else { 
		$bookingobj->setStatus('pending');
	}*/
	
	
	
	
	
	
	
	//echo var_dump($selectedRoom);
	//exit();
	
	$number=$customer->getMobile();
	
	$paymentErrors = array();
	$error = null;
	
	//$checksum = $request->get('CHECKSUMHASH');
	if ($status == 'success')
	{
		$bookingId = $bookingobj->getbookingId();
		$paymentDoneDate = new \DateTime();
		
		$bookingobj->setPaymentDoneDate($paymentDoneDate);
		$bookingobj->setPaymentMode('online');
		$bookingobj->setAmountPaid($paidAmount);
		$bookingobj->setStatus('booked');
		
		$bookingobj->setPaymentId($payment_id);
		
		$bookingPaymentEntity = new BookingPaymentEntity();
			
		//$paymentMode->setStatus ( 'online' );
		//$credited->setCredited('1');
		$paidby = $customer->getName();
		
		$bookingPaymentEntity->setStatus ( 'success' );
		$bookingPaymentEntity->setPaymentMode ( 'online' );
		$bookingPaymentEntity->setCredited('1');
		$bookingPaymentEntity->setPaidBy($paidby);
		date_default_timezone_set('Asia/Kolkata');
		$paymentDate = new \DateTime();
		$bookingPaymentEntity->setPaymentDate($paymentDate);
		
		$bookingPaymentEntity->setTransactionNo($payment_id);
		$bookingPaymentEntity->setPaidBy($paidby);
		$bookingPaymentEntity->setPaidAmount($paidAmount);
		
		$bookingPaymentEntity->setMobile($number);
		
		//$bookingPay = new Booking();
		
		//$bookingPay->setId($bookingobj->getId());
		
		//$bookingPaymentEntity->setBookingId($booking);
		$bookingPaymentEntity->setBookingId($bookingId);
		
		//echo var_dump($bookingPaymentEntity);
		//exit();
		
		//$booking=setBookingPayment($bookingPaymentEntity);
		//$booking=setBookingPayment($bookingPaymentEntity);
		
		//$bookingPayments = $booking->getBookingPayments();
		
		//$bookingPayments->add($bookingPaymentEntity);
		
		
		//echo var_dump($bookingobj);
		//exit();
		
	//	$selectedService->setNumRooms($selectedService->getNumRooms() - $searchFilter->getNumRooms());
		
		//echo var_dump($selectedService);
		//exit();
		 
		
		//echo var_dump($searchFilter);
		//exit();
		
	
		
		
		
		
		
		$em = $this->getDoctrine()->getManager();
		
		$em->merge($selectedService);
		
		$em->merge($bookingobj);
		
		$em->persist($bookingPaymentEntity);
		
		//echo var_dump($bookingPaymentEntity);
		//exit();
		
		$em->flush();
		
		$this->addFlash(
				'Notice',
				'paymentdetails Added'
		);
		
		$mailer = $this->renderView(
				'RoomBookingEngineBundle:Mail:new_invoice.html.twig',array(
						'booking' => $bookingobj,
						'customer' => $customer,
						'selectedRoom'=>$selectedRoom,
						'searchFilter'=>$searchFilter,
						'selectedService'=>$selectedService,
						'address'=>$address
				)
		);
		$subject = "Booking Confirmed -".$booking->getBookingId();
		$adminSubject = "New Booking From Sterling-".$booking->getBookingId();
		$mailService = $this->container->get( 'mail.services' );
		$email=$customer->getEmail();
		$mailService->mail($email,$subject,$mailer);
		//$mailService->mail('mailwaseemsyed@gmail.com',$adminSubject,$mailer);
	//	$mailService->mail('mmshivukumar@gmail.com',$adminSubject,$mailer);
		
		
		
		
		
	}else{
		
		$bookingobj->setStatus('pending');
		$paymentErrors[] = "Transaction status is failure";
		$error = $paymentErrors;
		
	}
	/*echo var_dump($checksum);
	echo var_dump($status);
	echo var_dump($payment_id);
	echo var_dump($customer);
	echo var_dump($booking);
	exit();*/
	
	
	
	
	
	
	
	
	
	
	return $this->render('RoomBookingEngineBundle:Default:success.html.twig',array(
			'bookingPaymentEntity' => $bookingPaymentEntity,
			'customer' => $customer,
			'error' =>$error
	) );

}


public function adminpaymentSuccessAction(Request $request){
	
	$session = $request->getSession();
	$booking = $session->get ( 'booking' );
		
	//$selectedService = $session->get('selected');
	//echo var_dump($booking);
	//exit();
	
	//echo var_dump($bookingobj);
	//exit();
	//$address = $selectedService->getAddress();
	//echo var_dump($selectedService);
	//exit();
	$customer = $session->get ( 'customer' );
	$payment_id = $request->get ( 'payment_id' );
	$paidAmount=$booking->getFinalPrice();
	$status = $request->get ( 'status' );
	
	//$selectedRoom = $session->get('selectedRoom');
	//$searchFilter = $session->get('search');
	
	
	
	$number=$customer->getMobile();
	$hotelId = $booking->getHotelId();
	$roomId = $booking->getHotelId();
	
	
	$em = $this->getDoctrine()->getManager();
	$selectedService = $em->getRepository('RoomHotelBundle:Hotel')->findBy( array('id' => $hotelId));
	$selectedService=$selectedService[0];
	$address = $selectedService->getAddress();
	//var_dump($roomId);
	$selectedRoom = $em->getRepository('RoomHotelBundle:HotelRoom')->findBy( array('id' => $roomId));
	
	
	//var_dump($selectedRoom);
	//exit();
	$selectedRoom=$selectedRoom[0];
	$paymentErrors = array();
	$error = null;
	
	
	if ($status == 'success')
	{
		$bookingId = $booking->getbookingId();
		$paymentDoneDate = new \DateTime();
		
		$booking->setPaymentDoneDate($paymentDoneDate);
		$booking->setPaymentMode('online');
		$booking->setAmountPaid($paidAmount);
		$booking->setStatus('booked');
	
		$booking->setPaymentId($payment_id);
	
		$bookingPaymentEntity = new BookingPaymentEntity();
			
		
		//echo var_dump($booking);
		//exit();
		//$paymentMode->setStatus ( 'online' );
		//$credited->setCredited('1');
		$paidby = $customer->getName();
	
		$bookingPaymentEntity->setStatus ( 'success' );
		$bookingPaymentEntity->setPaymentMode ( 'online' );
		$bookingPaymentEntity->setCredited('1');
		$bookingPaymentEntity->setPaidBy($paidby);
		date_default_timezone_set('Asia/Kolkata');
		$paymentDate = new \DateTime();
		$bookingPaymentEntity->setPaymentDate($paymentDate);
	
		$bookingPaymentEntity->setTransactionNo($payment_id);
		$bookingPaymentEntity->setPaidBy($paidby);
		$bookingPaymentEntity->setPaidAmount($paidAmount);
	
		$bookingPaymentEntity->setMobile($number);
	
	
		$em = $this->getDoctrine()->getManager();
	
		//$em->merge($selectedService);
	
		$em->merge($booking);
	
		$em->persist($bookingPaymentEntity);
	
		//echo var_dump($bookingPaymentEntity);
		//exit();
	
		$em->flush();
	
		$this->addFlash(
				'Notice',
				'paymentdetails Added'
		);
	
		$mailer = $this->renderView(
				'RoomBookingEngineBundle:Mail:invoice.html.twig',array(
						'booking' => $booking,
						'customer' => $customer,
						'selectedRoom'=>$selectedRoom,
						//'searchFilter'=>$searchFilter,
						'selectedService'=>$selectedService,
					'address'=>$address
						
				)
		);
		$subject = "Booking Confirmed -".$booking->getBookingId();
		$adminSubject = "New Booking From Sterling-".$booking->getBookingId();
		$mailService = $this->container->get( 'mail.services' );
		$email=$customer->getEmail();
		$mailService->mail($email,$subject,$mailer);
	//	$mailService->mail('mailwaseemsyed@gmail.com',$adminSubject,$mailer);
	
	
	
	
	
	}else{
	
		$booking->setStatus('pending');
		$paymentErrors[] = "Transaction status is failure";
		$error = $paymentErrors;
	
	}
	
	
	return $this->render('RoomBookingEngineBundle:Default:success.html.twig',array(
			'bookingPaymentEntity' => $bookingPaymentEntity,
			'customer' => $customer,
			'error' =>$error
	) );
	
	
	
	
}



	public function paymentDetailsAction(Request $request)
{
	/*$em = $this->getDoctrine()->getManager();
	
	$paymentDetails = new PaymentDetailsDto();
	
	if($form->isValid()) {
		
	$paymentDetailsObj = new PaymentDetailsDto();
	
	$MERCHANT_KEY = "rjQUPktU";
	$SALT = "e5iIg1jwi8";
	
	$mobile = $customer->getMobile ();
	$name = $customer->getName ();
	$email = $customer->getEmail ();
	
	$PAYU_BASE_URL = "https://secure.payu.in";
	
	$action = $PAYU_BASE_URL . '/_payment';
	
	$sUrl = 'http://' . $host . $redirectUrl.'?payment_id='.$txnid.'&status=success';
	$fUrl = 'http://' . $host . $redirectUrl.'?status=fail';
	$txnid = 'PAYU'.$bookingId;
	
	Return $this->redirectToRoute(' ');
	
	}*/
	$data = $this->getData($request,$finalPrice,$bookingId,$customer,$redirectUrl);
	//return $this->redirect($info['redirect_url']);
	Return $this->redirectToRoute($info['redirect_url']);
}

public function removeTrailingSlashAction(Request $request)
{
	$pathInfo = $request->getPathInfo();
	$requestUri = $request->getRequestUri();

	$url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

	return $this->redirect($url, 301);
}



}