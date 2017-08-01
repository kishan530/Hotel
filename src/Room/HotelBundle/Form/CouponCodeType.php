<?php

namespace Room\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CouponCodeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        		
        		
        	->add('couponName', null, array(
            		'required'    => true,
            		'label' => 'couponName', ))
            		
        	->add('couponCode', null, array(
            				'required'    => true,
            				'label' => 'couponCode', ))
            		
       		->add('expireDate','datetime',array(
            		'widget'=> 'single_text',
            		'format'=>'m/d/y hh:mm',
            		'required'    => false,
            		'label'     => 'expire Date',
            		'attr' => array('data-date-format' => 'yyyy-MM-dd HH:mm')
            		
            				))
    
            		
            ->add('amount', null, array(
            				'required'    => true,
            				'label' => 'amount', ))
            				
         	
           
           
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Room\HotelBundle\DTO\CouponCodeDto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'room_hotelbundle_couponcode';
    }
}
