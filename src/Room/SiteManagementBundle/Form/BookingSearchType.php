<?php

namespace Room\SiteManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Event\DataEvent;
/**
 * This is a Form to Search the booking data
 */
class BookingSearchType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from','date',array(
            						'required'    => false,
            						'label' => 'From Date',
									'widget'=> 'single_text',
									'format'=>'d/M/y',
            						//'data'  =>new \Date(),
            						'attr'=>array('class'=>'calendar')
            				))
            ->add('to','date',array(
            						'required'    => false,
            						'label' => 'To Date',
									'widget'=> 'single_text',
									'format'=>'d/M/y',
            						//'data'  =>new \Date(),
            						'attr'=>array('class'=>'calendar')
            				))
            				
            ->add('bookingId', null ,array(
            				
            						'required'    => false,
            						'label' => '',
            						'attr'   =>  array(
            								'placeholder'=>'Booking Id'
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
            'data_class' => 'Room\SiteManagementBundle\DTO\BookingSearch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'room_booking_search';
    }
}