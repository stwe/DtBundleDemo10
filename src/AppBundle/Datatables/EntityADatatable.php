<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;

/**
 * Class EntityADatatable
 *
 * @package AppBundle\Datatables
 */
class EntityADatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->language->set(array(
            'cdn_language_by_locale' => true,
        ));

        $this->ajax->set(array());

        $this->options->set(array(
            'classes' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
        ));

        $this->features->set(array());

        $this->columnBuilder
            ->add('id', Column::class, array(
                'title' => 'Id',
            ))
            ->add('name', Column::class, array(
                'title' => 'Name',
            ))
            ->add('entityB.name', Column::class, array(
                'title' => 'EntityB',
            ))
            ->add('entityB.entityC.name', Column::class, array(
                'title' => 'EntityC',
            ))
            ->add('entityB.entityC.entityD.name', Column::class, array(
                'title' => 'EntityD',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\EntityA';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'entitya_datatable';
    }
}
