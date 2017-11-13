<?php

namespace Room\BookingEngineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Event\DataEvent;

class MultiCityType extends AbstractType
{
	private $catalog;
	
	public function __construct($catalog)
	{
		$this->catalog = $catalog;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	private function getCities()
	{
		$cities = $this->catalogueService->getCities();
		$tempLocations = array();
		foreach ($cities as $city){
		  $tempCities[$city->getId()] = $city->getName();
		}
		return $tempCities;
	}
	
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', 'choice', array(
            		'expanded' => false,
            		'multiple' => false,
            		'choices' => $this->getCities(),
            		'required'    => false,
            		'empty_value'   => 'Select Origin',
                    'attr'   =>  array(
                                        'class'=>'chosen-select',
                                        'data-style'=>'btn-white',
                                        'data-live-search'=>'true',
                                        'data-placeholder'=>'Select Origin'
				            		),
            ))
        
            ->add('date','date',array(
            						'required'    => false,
            						'label' => 'From Date',
                				    'widget'=> 'single_text',
						            'format'=>'d/M/y',
				            		'attr'   =>  array(
				            				'data-date-format'=>'dd/mm/yyyy',
                                            'placeholder'=>'Date'
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
        		'data_class' => 'Room\BookingEngineBundle\DTO\MultiCity',
        		'csrf_protection'   => false,
        		'allow_extra_fields' => true,
                'attr' => array('class' => 'bookform form-inline')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hotel_search_MultiCity';
    }
}