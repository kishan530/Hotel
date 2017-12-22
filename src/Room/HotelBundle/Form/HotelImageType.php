<?php

namespace Room\HotelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;
/**
 * This is a Form to collect the data of BulkFileUpload in
 * Drivekool application.
 */
class HotelImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('imagePath', 'file',array(
        		'required' => true,
        		'data_class' => null,
        		'label'=>'Image',
        		'attr'   =>  array(
        				'class'   => 'filestyle',
        		),
        ))
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'Room\HotelBundle\Entity\HotelImage'
    	));
    }
    
 
    /**
     * @return string
     */
    public function getName()
    {
        return 'room_hotelbundle_hotel_image';
    }
}
