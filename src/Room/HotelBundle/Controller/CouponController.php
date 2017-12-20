<?php

namespace Room\HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Room\HotelBundle\Form\CouponCodeType;
use Room\HotelBundle\Entity\CouponCode;
use Room\HotelBundle\DTO\CouponCodeDto;
use Doctrine\Common\Collections\ArrayCollection;

class CouponController extends Controller
{
	public function couponListAction(Request $request)
	{
			$security = $this->container->get ( 'security.context' );
	    	 
	    	$user = $security->getToken ()->getUser ();
	    	 
	    	if (! $security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
	    		 
	    		return $this->redirect ( $this->generateUrl ('room_security_user_login') );
	    		 
	    	}
	    	
		$coupon = $this->getDoctrine()
		->getRepository('RoomHotelBundle:CouponCode')
		->findAll();
		// 		echo var_dump($coupon);
		// replace this example code with whatever you need
		return $this->render('RoomHotelBundle:Default:coupon_list.html.twig', array(
				'coupons' => $coupon
	
		));
	}

	
	public function addCouponAction(Request $request)
	    {
	    	$security = $this->container->get ( 'security.context' );
	    	 
	    	$user = $security->getToken ()->getUser ();
	    	 
	    	if (! $security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
	    	
	    		return $this->redirect ( $this->generateUrl ('room_security_user_login') );
	    	
	    	}
	    	
	    	$em = $this->getDoctrine()->getManager();
	    	
	    	$coupon = new CouponCodeDto();
	    	
	    	$form = $this->createForm(new CouponCodeType(), $coupon);
	    	$form->add('submit','submit', array('label' => 'Add Coupon'));
	    	$form ->handleRequest($request);
	    	
	    	if($form->isValid()) {
	    		 
	    		//echo var_dump($media);
	    	
	    		$couponObj = new CouponCode();
	    		$couponObj->setCouponName($coupon->getCouponName());
	    		$couponObj->setCouponCode($coupon->getCouponCode());
	    		
	    		date_default_timezone_set('Asia/Kolkata');
	    		$date = new \DateTime();
	    		//$entity->setDate($date);
	    		//echo var_dump($coupon->getExpireDate());
	    	//	exit();
	    		
	    		$couponObj->setStartDate($coupon->getStartDate());
	    		
	    		$couponObj->setExpireDate($coupon->getExpireDate());
	    		//$couponObj->setExpireDate(new \DateTime());
	    		$couponObj->setAmount($coupon->getAmount());
	    		$couponObj->setCreatedBy($user->getEmail());
	    		
	    		$couponObj->setCreatedAt($date);
	    		//$couponObj->setCreatedAt(new \DateTime());
	    		$couponObj->setUpdatedBy($user->getEmail());
	    		$couponObj->setUpdatedAt($date);
	    		
	    		//var_dump($date);
	    		//exit();
	 
	    		//$couponObj->setUpdatedAt(new \DateTime());
	    		
	    		
	    		$em->persist($couponObj);
	    	
	    		$em->flush();
	    	
	    		$this->addFlash(
	    				'Notice',
	    				'Coupon Added'
	    		);
	    		Return $this->redirectToRoute('room_hotel_list_coupon_code');
	    	}
	    	// replace this example code with whatever you need
	    	return $this->render('RoomHotelBundle:Default:add-coupon.html.twig', array(
	    	
	    			'form' => $form->createView(),
	    	));
	    	
	    	
		}
	
	
	
	public function couponEditAction(Request $request,$id)
	{
		$security = $this->container->get ( 'security.context' );
		 
		$user = $security->getToken ()->getUser ();
		 
		if (! $security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
		
			return $this->redirect ( $this->generateUrl ('room_security_user_login') );
		
		}
		
		$CouponCodeDto = new CouponCodeDto();
		
		$em = $this->getDoctrine()->getManager();
		$couponObj = $em
		->getRepository('RoomHotelBundle:CouponCode')
		->find($id);
		// 		echo var_dump($media);
		
		$CouponCodeDto->setCouponName($couponObj->getCouponName());
		$CouponCodeDto->setCouponCode($couponObj->getCouponCode());
		
		$CouponCodeDto->setStartDate($couponObj->getStartDate());
		
		$CouponCodeDto->setExpireDate($couponObj->getExpireDate());
		$CouponCodeDto->setAmount($couponObj->getAmount());
		
		
		$form = $this->createForm(new CouponCodeType(), $CouponCodeDto);
		$form->add('submit','submit', array('label' => 'Update'));
		$form ->handleRequest($request);
		
		if($form->isValid()) {
			$CouponCodeDto = $form->getData();
			/* echo var_dump($client->getMediaLogo());
				exit(); */
				
			$couponObj->setCouponName($CouponCodeDto->getCouponName());
			$couponObj->setCouponCode($CouponCodeDto->getCouponCode());
			
			$couponObj->setStartDate($CouponCodeDto->getStartDate());
			
			$couponObj->setExpireDate($CouponCodeDto->getExpireDate());
			$couponObj->setAmount($CouponCodeDto->getAmount());

			
			
			$date = new \DateTime();
			$couponObj->setUpdatedBy($user->getEmail());
			$couponObj->setUpdatedAt($date);
			
				
			//$clientObj->setClientImage($ourClientDto->getClientImage());
			
				
			$em->merge($couponObj);
		
			$em->flush();
		
			$this->addFlash(
					'Notice',
					'coupon Added'
			);
			Return $this->redirectToRoute('room_hotel_list_coupon_code');
		}
		// replace this example code with  whatever you need
		return $this->render('RoomHotelBundle:Default:add-coupon.html.twig', array(
				'coupon' => $couponObj,
				'form' =>$form->createView()
		));
		
	}
	
	public function couponDeleteAction($id)
	{
		$coupon = $this->getDoctrine()
		->getRepository('RoomHotelBundle:CouponCode')
		->find($id);
	
		$em = $this->getDoctrine()->getManager();
		$em->remove($coupon);
		$em->flush();
		return $this->redirect($this->generateUrl('room_hotel_list_coupon_code'));
	}


}
