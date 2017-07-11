<?php

namespace  Room\HotelBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class HotelServices
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
	
	public function getCity(){
		$locations = $this->em->getRepository('RoomHotelBundle:City')->findBy(array(),array('name'=>'ASC'));
		return $locations;
	}
// 	public function getLocation(){
// 		$locations = $this->em->getRepository('RoomHotelBundle:Hotel')->findAll();
// 		return $locations;
// 	}
	
}