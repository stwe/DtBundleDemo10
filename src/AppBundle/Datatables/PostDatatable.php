<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Filter\Select2Filter;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
//use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;

/**
 * Class PostDatatable
 *
 * @package AppBundle\Datatables
 */
class PostDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        $router = $this->router;

        $formatter = function ($line) use ($router) {
            $route = $router->generate('profile_show', array('id' => $line['createdBy']['id']));
            $line['createdBy']['username'] = '<a href="'.$route.'">'.$line['createdBy']['username'].'</a>';

            return $line;
        };

        return $formatter;
    }

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
            'order' => array(array($this->getDefaultOrderCol(), 'asc')),
            'dom' => 'Bfrtip',
        ));

        $this->features->set(array());

        $this->extensions->set(array(
            //'responsive' => true,
            //'buttons' => true,
            'buttons' => array(
                'show_buttons' => array('copy', 'print'),
                'create_buttons' => array(
                    array(
                        'action' => array(
                            'template' => ':extension:alert.js.twig',
                        ),
                        'text' => 'alert',
                    ),
                    array(
                        'extend' => 'csv',
                        'text' => 'custom csv button',
                    ),
                    array(
                        'extend' => 'pdf',
                        'button_options' => array(
                            'exportOptions' => array(
                                'columns' => $this->getPdfColumns(),
                            ),
                        ),
                    ),
                ),
            ),
            'responsive' => array(
                'details' => array(
                    'display' => array(
                        'template' => ':extension:display.js.twig',
                    ),
                    'renderer' => array(
                        'template' => ':extension:renderer.js.twig',
                    ),
                ),
            ),
        ));

        $this->callbacks->set(array(
            'init_complete' => array(
                'template' => ':callback:init.js.twig',
            ),
        ));

        $this->events->set(array(
            'xhr' => array(
                'template' => ':event:event.js.twig',
                'vars' => array('table_name' => $this->getName()),
            ),
        ));

        $this->columnBuilder
            ->add(
                null,
                MultiselectColumn::class,
                array(
                    'start_html' => '<div class="start_checkboxes">',
                    'end_html' => '</div>',
                    'add_if' => function () {
                        return $this->authorizationChecker->isGranted('ROLE_ADMIN');
                    },
                    'value' => 'id',
                    'value_prefix' => true,
                    //'render_actions_to_id' => 'sidebar-multiselect-actions',
                    'actions' => array(
                        array(
                            'route' => 'post_bulk_delete',
                            'icon' => 'glyphicon glyphicon-ok',
                            'label' => 'Delete Postings',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Delete',
                                'class' => 'btn btn-primary btn-xs',
                                'role' => 'button',
                            ),
                            'confirm' => true,
                            'confirm_message' => 'Really?',
                            'start_html' => '<div class="start_delete_action">',
                            'end_html' => '</div>',
                            'render_if' => function () {
                                return $this->authorizationChecker->isGranted('ROLE_ADMIN');
                            },
                        ),
                    ),
                )
            )
            ->add('id', Column::class, array(
                'title' => 'Id',
                'filter' => array(TextFilter::class,
                    array(
                        'cancel_button' => true,
                        'search_type' => 'eq',
                    ),
                ),
            ))
            ->add('title', Column::class, array(
                'title' => 'Title',
                'filter' => array(TextFilter::class,
                    array(
                        'cancel_button' => true,
                    ),
                ),
                'editable' => array(TextEditable::class,
                    array(
                        'placeholder' => 'Edit value',
                        'empty_text' => 'Empty Text',
                        'editable_if' => function ($row) {
                            if ($this->getUser()) {
                                if ($row['createdBy']['id'] == $this->getUser()->getId() or true === $this->isAdmin()) {
                                    return true;
                                };
                            }

                            return false;
                        },
                    ),
                ),
            ))
            ->add('visible', BooleanColumn::class, array(
                'title' => 'Visible',
                'filter' => array(SelectFilter::class,
                    array(
                        'search_type' => 'eq',
                        'multiple' => true,
                        'select_options' => array(
                            '' => 'Any',
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'cancel_button' => true,
                    ),
                ),
                'editable' => array(SelectEditable::class,
                    array(
                        'editable_if' => function ($row) {
                            if ($this->getUser()) {
                                if ($row['createdBy']['id'] == $this->getUser()->getId() or true === $this->isAdmin()) {
                                    return true;
                                };
                            }

                            return false;
                        },
                        'source' => array(
                            array('value' => 1, 'text' => 'Yes'),
                            array('value' => 0, 'text' => 'No'),
                        ),
                        'mode' => 'inline',
                        'empty_text' => '',
                    ),
                ),
            ))
            ->add('rating', Column::class, array(
                'title' => 'Rating',
                'filter' => array(NumberFilter::class,
                    array(
                        'search_type' => 'eq',
                        'cancel_button' => true,
                        'type' => 'number',
                        'min' => '0',
                        'max' => '5',
                        'show_label' => true,
                    ),
                ),
            ))
            ->add('imageName', ImageColumn::class, array(
                'title' => 'Image',
                'imagine_filter' => 'thumbnail_50_x_50',
                'imagine_filter_enlarged' => 'thumbnail_250_x_250',
                'relative_path' => '/uploads/images',
                'holder_url' => 'https://placehold.it',
                'enlarge' => true,
            ))
            ->add('publishedAt', DateTimeColumn::class, array(
                'title' => 'PublishedAt',
                'filter' => array(DateRangeFilter::class,
                    array(
                        'cancel_button' => true,
                    ),
                ),
                'timeago' => true,
            ))
            ->add('createdBy.username', Column::class, array(
                'title' => 'Created by',
                'width' => '100%',
                'filter' => array(Select2Filter::class,
                    array(
                        'search_type' => 'eq',
                        'cancel_button' => true,
                        'url' => 'select2_usernames',
                    ),
                ),
            ))
            ->add('comments.title', Column::class, array(
                'title' => 'Comments',
                'data' => 'comments[, ].title',
            ))
            ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'post_show',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ),
                    ),
                    array(
                        'route' => 'post_edit',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'label' => $this->translator->trans('sg.datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ),
                        'render_if' => function ($row) {
                            if ($this->getUser()) {
                                if ($row['createdBy']['id'] == $this->getUser()->getId() or true === $this->isAdmin()) {
                                    return true;
                                };
                            }

                            return false;
                        },
                    ),
                ),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\Post';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'post_datatable';
    }

    /**
     * Get User.
     *
     * @return mixed|null
     */
    private function getUser()
    {
        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->securityToken->getToken()->getUser();
        } else {
            return null;
        }
    }

    /**
     * Is admin.
     *
     * @return bool
     */
    private function isAdmin()
    {
        return $this->authorizationChecker->isGranted('ROLE_ADMIN');
    }

    /**
     * Get default order col.
     *
     * @return int
     */
    private function getDefaultOrderCol()
    {
        return true === $this->isAdmin()? 1 : 0;
    }

    /**
     * Returns the columns which are to be displayed in a pdf.
     *
     * @return array
     */
    private function getPdfColumns()
    {
        if (true === $this->isAdmin()) {
            return array(
                '1', // id column
                '2', // title column
                '3', // visible column
            );
        } else {
            return array(
                '0', // id column
                '1', // title column
                '2', // visible column
            );
        }
    }
}
