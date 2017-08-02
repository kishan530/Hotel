<?php

namespace Room\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Event\DataEvent;
use Room\HotelBundle\Form\HotelImageType;
use Room\HotelBundle\Form\HotelRoomType;


class HotelDetailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
	
	private $hotelService;
	
	public function __construct($hotelService)
	{
		$this->hotelService= $hotelService;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	private function getCities()
	{
		$cities = $this->hotelService->getCities();
		$tempCities = array();
		foreach ($cities as $city){
			if($city->getActive()){
				$tempCities[$city->getId()] = $city->getName();
			}
		}
		return $tempCities;
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('overview')
            ->add('propertyType', 'choice', array(
            		'expanded' => false,
            		'multiple' => false,
            		'label' => 'Property Type',
            		'choices' => array(
            				'Service Apartments'=>'Service Apartments',
            				'Resort'=>'Resort',
            		),
            		'required'    => true,
            ))
            ->add('category', 'choice', array(
            		'expanded' => false,
            		'multiple' => false,
            		'label' => 'Category',
            		'choices' => array(
            				'3'=>'3 Star',
            				'4'=>'4 Star',
            				'5'=>'5 Star',
            		),
            		'required'    => true,
            ))
            ->add('checkIn')
            ->add('checkOut')
            ->add('price')          
            ->add('numRooms')
            ->add('priority', 'choice', array(
            		'expanded' => false,
            		'multiple' => false,
            		'label' => 'Priority',
            		'choices' => array(          				            				
            				'5'=>'5',
            				'4'=>'4',
            				'3'=>'3',
            				'2'=>'2',
            				'1'=>'1',
            		),
            		'required'    => true,
            ))
            ->add('soldOut', 'choice', array(
            		'expanded' => false,
            		'multiple' => false,
            		'label' => 'Sold Out',
            		'choices' => array(
            				'0'=>'No',
            				'1'=>'Yes',
            				
            		),
            		'required'    => true,
            ))
            ->add('active', 'choice', array(
            		'expanded' => false,
            		'multiple' => false,
            		'label' => 'Status',
            		'choices' => array(
            				'1'=>'Active',
            				'0'=>'InActive',
            		),
            		'required'    => true,
            ))
            ->add('addressLine1')
            ->add('addressLine2')
            //->add('city')
            ->add('city', 'choice', array(
            		'expanded' => false,
            		'multiple' => false,
            		'label' => 'City',
            		'empty_value'   => 'Select',
            		'choices' =>$this->getCities(),
            		'required'    => true,
            ))
//             ->add('location', 'choice', array(
//             		'expanded' => false,
//             		'multiple' => false,
//             		'label' => 'Location',
//             		'empty_value'   => 'Select',
//             		//	'choices' => $this->getLocations(),
//             		'required'    => true,
//             ))
            ->add('location')
            ->add('pincode')
            
            ->add('imageList', 'collection', array(
            		// each entry in the array will be an "PackageItinerary" field
            		'type'   => new HotelImageType(),
            		'allow_add'    => true,
            		'prototype'=>true,
            		'required'    => false,
            		// these options are passed to each "PackageItinerary" type
            		//'entry_options'  => array(
            		//   'attr'      => array('class' => '')
            		//),
            ))
           
            ->add('roomList', 'collection', array(
            		// each entry in the array will be an "PackageItinerary" field
            		'type'   => new HotelRoomType(),
            		'allow_add'    => true,
            		'prototype'=>true,
            		'required'    => false,
            		// these options are passed to each "PackageItinerary" type
            		//'entry_options'  => array(
            		//   'attr'      => array('class' => '')
            		//),
            ))
            
            ->add('footerDisplay', 'checkbox', array(
            		'label'    => 'Display in footer',
            		'required' => false,
            ))
            
            ->add('url')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Room\HotelBundle\DTO\HotelDto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'room_hotelbundle_hoteldetail';
    }
}
