<?php
/**
* (c) 2011-2012 Vespolina Project http://www.vespolina-project.org
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/
namespace Vespolina\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vespolina\ProductBundle\Form\Type\AttributeFormType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 */
class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('options', 'collection', array(
                'type'           => 'vespolina_option_group',
                'allow_add'      => true,
                'allow_delete'   => true,
                'required'       => false,
                'by_reference'   => false,
                'prototype_name' => 'group',
            ))
            ->add('attributes', 'collection', array(
                'required' => false,
                'type' => new AttributeFormType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype_name' => 'attributes',
           ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Vespolina\ProductBundle\Document\Product',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    function getName()
    {
        return 'vespolina_product';
    }
}
