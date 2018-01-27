<?php

namespace Room\SiteManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Room\SiteManagementBundle\Form\ContactType;
use Room\SiteManagementBundle\Entity\Contact;
use Room\SiteManagementBundle\Form\BookingSearchType;
use Room\SiteManagementBundle\DTO\BookingSearch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteManagementController extends Controller
{
    /**
     * 
     */
    public function aboutAction()
    {
    	return $this->render('RoomSiteManagementBundle:Default:about-us.html.twig');
    }
    
    
    
    
    /**
     *
     * @param Contact $entity
     * @return unknown
     */
    private function createContactForm(Contact $dto){
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$form = $this->createForm(new ContactType($catalogueService), $dto, array(
    			'action' => $this->generateUrl('room_site_management_contact_us'),
    			'method' => 'POST',
    	));
    		
    	return $form;
    }
    
    /**
     *
     * @param Contact $entity
     * @return unknown
     */
    private function createBookingSearchForm(BookingSearch $dto){
    	$catalogueService = $this->container->get( 'catalogue.service' );
    	$form = $this->createForm(new BookingSearchType($catalogueService), $dto, array(
    			'action' => $this->generateUrl('room_site_management_booking_search'),
    			'method' => 'GET',
    	));
    	
    	$form->add ( 'submit', 'submit', array (
    			'label' => 'Search'
    	) );
    
    	return $form;
    }
    
    
    /**
     *
     * @param Request $request
     */
    public function bookingSearchAction(Request $request)
    {
    	$security = $this->container->get ( 'security.context' );
    	
    	$user = $security->getToken ()->getUser ();
    	
    	if (! $security->isGranted ( 'ROLE_SUPER_ADMIN' )) {
    	
    		return $this->redirect ( $this->generateUrl ('room_security_user_login') );
    	
    	}
    	
    	//$bookingIdDetails = array(); 
    	
    	$bookings = array();
    	$bookingSearch = new BookingSearch();
    	
    	//$bookingId = new BookingSearch();
    	
    	$form   = $this->createBookingSearchForm($bookingSearch);
    	$form->handleRequest($request);
    	if ($form->isValid()) {
    		
    		$catalogueService = $this->container->get( 'catalogue.service' ); 
    		$bookings = $catalogueService->getBookingsBySearch($bookingSearch);
    		
    		//$bookingIdDetails = $catalogueService->getBookingsByBookingId($bookingId);
    		
    		
    		$customers = $catalogueService->getCustomers();
    		$customers = $catalogueService->getById($customers);
    		//$hotels = $catalogueService->getHotels();
    		//$hotels = $catalogueService->getById($hotels);
    		
    		return $this->render('RoomSiteManagementBundle:Default:booking-search.html.twig', array(
    				'form'   => $form->createView(),
    				'bookings'=>$bookings,
    				'customers'=>$customers,
    				
    			//'bookingIdDetails'=>$bookingIdDetails,
    				//'hotels'=>$hotels
    		));
    	}
    	return $this->render('RoomSiteManagementBundle:Default:booking-search.html.twig', array(
    			'form'   => $form->createView(),
    			'bookings'=>$bookings
    			
    			//'bookingIdDetails'=>$bookingIdDetails
    	));
    }
    
    
    
    public function contactAction(Request $request)
    
    {
    
    	$contact = new Contact();
    
    	$form   = $this->createContactForm($contact);
    
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    
    		$em = $this->getDoctrine()->getManager();
    
    		$em->persist($contact);
    
    		$em->flush();
    		$email = $contact->getEmail();
    
    		$body="<br>";
    		$body.="<label>Name:</label>".$contact->getName()."<br>";
    		$body.="<label>Email:</label>".$contact->getEmail()."<br>";
    		$body.="<label>Contact Number:</label>".$contact->getEmail()."<br>";
    		$body.="<label>Subject:</label>".$contact->getSubject()."<br>";
    		$body.="<label>Message:</label>".$contact->getMessage()."<br>";
    		$Mailer='<table>
            <TR><TD>Dear Admin , bellow person has some query.Please do response to '.$contact->getName().' on the earliest. </TD></TR>
            <tr style="background-color:#f2f2f2" width="100%">
              <td valign="top" align="center" colspan="2">
                <p style="margin:0 0 8px 0;font-size:14px;line-height:22px;text-align:left">
                    <b style="padding:20px;">
                       '.$body.'
                    </b></p>
    
                <tr><td>Thank you</td></tr>
                <tr><td>Best Regards, <br>
    
                        Sterling Suites Team <br><br></td></tr>
              </td>
            </tr>
    
              </table>';
    
    		$message="Dear ".$contact->getName()."<br>
                            Greetings from Sterling Suites!<br>
                            Your request has been lodged successfully. We will contact you through call/mail within next 48 working hours.<br><br>
    
    
                            Best Regards,<br>
                            Sterling Suites Team ";
    		$subject = "Contact Us: Request";
    		$adminSubject = "Contact Us: Request from ".$contact->getName();
    		$mailService = $this->container->get( 'mail.services' );
    		$mailService->mail($email,$subject,$message);
    		//$mailService->mail('kishan.kish530@gmail.com',$adminSubject,$Mailer);
    		$mailService->mail('info@sterlingsuites.in',$adminSubject,$Mailer);
    		$mailService->mail('reservation@sterlingsuites.in',$adminSubject,$Mailer);
    		return $this->redirect($this->generateUrl('room_site_management_contact_us'));
    
    
    
    		return $this->render('RoomSiteManagementBundle:Default:contact-us.html.twig', array(
    
    				'form'   => $form->createView(),
    
    		));
    
    	}
    
    	return $this->render('RoomSiteManagementBundle:Default:contact-us.html.twig', array(
    
    			'form'   => $form->createView(),
    
    	));
    
    }
    
    }
    
    
   
    
    
    /**
     * 
     * @param Request $request
     */
    /*
    public function contactAction(Request $request)
    {
    	$contact = new Contact();
    	$form   = $this->createContactForm($contact);
    	$form->handleRequest($request);
    	if ($form->isValid()) {    	
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($contact);
    		$em->flush();
    		
    		return $this->render('RoomSiteManagementBundle:Default:contact-us.html.twig', array(
    				'form'   => $form->createView(),
    		));
    	}
    	return $this->render('RoomSiteManagementBundle:Default:contact-us.html.twig', array(
    			'form'   => $form->createView(),
    	));
    }
}*/