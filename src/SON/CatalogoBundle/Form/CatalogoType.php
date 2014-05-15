<?php

namespace SON\CatalogoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('descricao')
            ->add('lancamento')
            ->add('imageName')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SON\CatalogoBundle\Entity\Catalogo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'son_catalogobundle_catalogo';
    }
}
