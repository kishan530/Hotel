<?php

namespace Room\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HotelRoomType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        		
          ->add('roomType', 'choice', array(
            				'expanded' => false,
            				'multiple' => false,
            				'label' => 'RoomType',
            				'choices' => array(
            						'Deluxe Room Double'=>'Deluxe Room Double',
            						'Premium Room Double'=>'Premium Room Double',
            						'Executive Double'=>'Executive Double',
            						'Signature Room Double'=>'Signature Room Double',
            						
            				),
            				'required'    => true,))
            		
            		
            		
        			
        	->add('capacity', null, array(
            		'required'    => true,
            		'label' => 'capacity', ))
            		
       		->add('price', null, array(
            				'required'    => true,
            				'label' => 'price', ))
    ->add('id','hidden', array(
            						'required'    => true,
            						'label' => 'price', ))
             
            ->add('imagePath', 'file',array(
            				'required' => false,
            				'attr'   =>  array(
            						'class'   => 'filestyle',
            						'data-icon'   => 'false',
            						'label' => 'imagePath',
            				),
            		))
            		
            ->add('maxAdult', null, array(
            				'required'    => true,
            				'label' => 'maxAdult', ))
            				
         	 ->add('maxChild', null, array(
            						'required'    => true,
            						'label' => 'maxChild', ))
      		->add('description', null, array(
            				'required'    => true,
            				'label' => 'description', ))
            				
     		->add('name', null, array(
            				'required'    => true,
            				'label' => 'name', ))
           
           
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Room\HotelBundle\DTO\HotelRoomDto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'room_hotelbundle_hotelroom';
    }
}
