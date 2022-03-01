<?php

namespace App\Form;

use App\Entity\Advertisment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AdvertismentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seuil_hum_high')
            ->add('seuil_hum_low')
            ->add('seuil_light_high')
            ->add('seuil_light_low')
            ->add('seuil_rain_high')
            ->add('seuil_rain_low')
            ->add('seuil_temp_high')
            ->add('seuil_temp_low')
            ->add('image', FileType::class, [
                'label' => 'video_id',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '50000k',
                        'mimeTypes' => [
                            'video/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid video format',
                    ])
                ],
            ])
            ->add('time')
            ->add('user_id')
            ->add('display_time')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advertisment::class,
        ]);
    }
}
