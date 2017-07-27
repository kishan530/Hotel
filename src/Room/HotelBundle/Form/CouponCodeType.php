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
            		
       		->add('expireDate','date',array(
            		'widget'=> 'single_text',
            		'format'=>'d/M/y',
            		'required'    => false,
            		'label'     => 'expire Date',
            		'attr' => array('data-date-format' => 'dd/mm/yyyy')
            		
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
