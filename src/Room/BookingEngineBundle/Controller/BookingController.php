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
    		
    		//$mailService->mail('kishan.kish530@gmail.com','kishan test','this is kishan test');
		$search = new Search();
		$search->setNumAdult(2);
		$search->setNumRooms(1);
		$form   = $this->createSearchForm($search);
		return $this->render('RoomBookingEngineBundle:Default:index.html.twig', array(
                'form'   => $form->createView(),
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
    	$filters = $catalogueService->getFilters($hotels,$amenities);
    	$search->setMinPrice($filters['price']['minPrice']);
    	$search->setMaxPrice($filters['price']['maxPrice']);
    	$search->setMin($filters['price']['minPrice']);
    	$search->setMax($filters['price']['maxPrice']);
    	$session = $request->getSession();
    	$session->set('search',$search);
    	$session->set('hotels',$hotels);
    	$session->set('filters',$filters);
    	
    	$filterForm   = $this->createFilterForm($search,$filters);
    		   		
    	return $this->render('RoomBookingEngineBundle:Default:search.html.twig', array(
                'form'   => $form->createView(),     
    			'filterForm'   => $filterForm->createView(),
    			'hotels'=>$hotels,
    			'search'=>$search
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

    	$filterForm   = $this->createFilterForm($search,$filters);   	
    	$filterForm->handleRequest($request);
    	
    	$price = $search->getPrice();
    	$minMaxPrice = explode ( ";", $price );
    	$minPrice = ( float ) $minMaxPrice [0];
    	$maxPrice = ( float ) $minMaxPrice [1];
    	$search->setMinPrice($minPrice);
    	$search->setMaxPrice($maxPrice);
    	
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$hotels = $catalogueService->filterHotels($search,$hotels,$minPrice,$maxPrice);
    		
    	return $this->render('RoomBookingEngineBundle:Default:search.html.twig', array(
    			'form'   => $form->createView(),
    			'filterForm'   => $filterForm->createView(),
    			'hotels'=>$hotels,
    			'search'=>$search,
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
    	$numRoom=$search->getNumRooms();
    //	$search = new Search();
    	
    	$form   = $this->createSearchForm($search);
    	$em = $this->getDoctrine()->getManager();
    	$hotel = $em->getRepository('RoomHotelBundle:Hotel')->find($id);
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$hotel = $catalogueService->getMinPrice($hotel);
    	$roomPrice=$hotel->getPrice();
    	$hotel->setPrice($roomPrice*$numRoom);
    	return $this->render('RoomBookingEngineBundle:Default:view-more.html.twig', array(
    			'form'   => $form->createView(),
    			'hotel'=> $hotel,
    			
    			
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
    	$search = $session->get('search');
    	$customer = new Customer();
    	$form   = $this->createBookingForm($customer);
    	$em = $this->getDoctrine()->getManager();
    	$hotel = $em->getRepository('RoomHotelBundle:Hotel')->find($id);
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$selectedRoom = $catalogueService->getSelectedRoom($hotel,$room);
    	$booking = new Booking();
    	$price = $selectedRoom->getPrice();
    	$serviceTax = 0;
    	$taxPercentage = 0;
    	if($price>999 && $price<2500){
    		$taxPercentage = 12;
    	}elseif($price>2499 && $price<5000){
    		$taxPercentage = 18;
    	}elseif($price>4999){
    		$taxPercentage = 28;
    	}
    	$serviceTax = round($price*($taxPercentage/100),2);
    	//$swachBharthCess = round($finalPrice*(0.9/100),2);
    	//$krishiKalyanCess = round($finalPrice*(0.9/100),2);
    	$totalTax = $serviceTax;
    	$finalPrice = $price+$totalTax;
    	$booking->setTotalPrice($price);
    	$booking->setServiceTax($serviceTax);
    	$booking->setDiscount(0);
    	$booking->setCouponApplyed(0);
    	$booking->setFinalPrice($finalPrice);
    	
    	$session->set ('booking',$booking);
    	return $this->render('RoomBookingEngineBundle:Default:confirm.html.twig', array(
    			'form'   => $form->createView(),
    			'customer'=> $customer,
    			'hotel'=> $hotel,
    			'room'=>$room,
    			'booking'=> $booking,
    			'search'=>$search,
    			'step'=> 'review'
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
    	$session = $request->getSession();
    	$search = $session->get('search');
    	$customer = new Customer();
    	$form   = $this->createBookingForm($customer);
    	$em = $this->getDoctrine()->getManager();
    	$hotel = $em->getRepository('RoomHotelBundle:Hotel')->find($id);
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$selectedRoom = $catalogueService->getSelectedRoom($hotel,$room);
    	$session->set('selected',$hotel);
    	$session->set('selectedRoom',$selectedRoom);
    	$booking = $session->get('booking');
    	return $this->render('RoomBookingEngineBundle:Default:booking.html.twig', array(
    			'form'   => $form->createView(),
    			'customer'=> $customer,
    			'hotel'=> $hotel,
    			'booking'=> $booking,
    			'search'=>$search,
    			'step'=> 'review'
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
    		$booking->setStatus('booked');
    		$booking->setJobStatus('Open');
    		$booking->setBookedOn(new \DateTime());
    		//$booking->setNumDays($searchFilter->getNumDays());
    		$booking->setNumAdult($searchFilter->getNumAdult());
    		$booking->setChekIn($searchFilter->getCheckIn());
    		$booking->setChekOut($searchFilter->getCheckOut());
    		
    		
    		$address = $selectedService->getAddress();
    		$booking->setHotelId($selectedService->getId());
    		$booking->setRoomId($selectedRoom->getId());
    		$booking->setHotelName($selectedService->getName());
    		$booking->setLocation($address->getLocation());
    		$booking->setNumRooms(0);
    		
    		$booking->setTotalPrice($bookingOld->getTotalPrice());
    		$booking->setDiscount($bookingOld->getDiscount());
    		$booking->setServiceTax($bookingOld->getServiceTax());
    		$booking->setFinalPrice($bookingOld->getFinalPrice());
    		$booking->setCouponApplyed($bookingOld->getCouponApplyed());
    		$booking->setCouponCode($bookingOld->getCouponCode());
    		$em->persist($booking);
    		$em->flush();
    		

    		$selectedService->setNumRooms($selectedService->getNumRooms()-1);
    		$em->merge($selectedService);
    		$em->flush();
    		$amountToPay = $booking->getFinalPrice();
    		$session->set('bookingObj',$booking);
    		$session->set('amountToPay',$amountToPay);
    		$paymentLink = $this->getPaymentLink($amountToPay);
    		//$paymentLink = "https://www.instamojo.com/Waseemsyed/tirupati-caars-services-cb8a4/";
    		$paymentLink.="?data_name=".$customer->getName()."&data_email=".$customer->getEmail()."&data_phone=".$customer->getMobile()."&embed=form";
    		
    		
    		
    		$mailer = $this->renderView(
    				'RoomBookingEngineBundle:Mail:invoice.html.twig',array(
    						'booking' => $booking,
    						'customer' => $customer,
    						'selectedRoom'=>$selectedRoom
    						 
    				)
    		);
    		$subject = "Booking Confirmed -".$booking->getBookingId();
			$adminSubject = "New Booking From Sterling-".$booking->getBookingId();
    		$mailService = $this->container->get( 'mail.services' );
    		$email=$customer->getEmail();
    		$mailService->mail($email,$subject,$mailer);
			//$mailService->mail('mailwaseemsyed@gmail.com',$adminSubject,$mailer);
    		
    		$security = $this->container->get ( 'security.context' );
    		 
    		$user = $security->getToken ()->getUser ();
    		 
    		if ($security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
    		
    			return $this->redirect ( $this->generateUrl ('room_security_user_login') );
    		
    		}else{
    		return $this->redirect ( $this->generateUrl ( "room_booking_engine_success" ) );
    		}
    		return $this->render('RoomBookingEngineBundle:Default:payment.html.twig', array(
    				'customer'   => $customer,
    				'booking'   => $booking,
    				'service'=>$selectedService,
    				'filter'=>$searchFilter,
    				'paymentLink'   => $paymentLink,
    		));
    	}

    	return $this->render('RoomBookingEngineBundle:Default:booking.html.twig', array(
    			'form'   => $form->createView(),
    			'customer'=> $customer
    	));
    
    }
    
    public function getPaymentLink($amountToPay){
    	return '';
    }
    /**
     *
     */
    public function successAction()
    {

    	return $this->render('RoomBookingEngineBundle:Default:success.html.twig');
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
    	->Where('c.expireDate > :today')
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
	  		
	  return new Response (json_encode($response));
    	
    
    }
    
}
