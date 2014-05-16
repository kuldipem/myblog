<?php

namespace MyBlog\Admin\ManageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Formatter\Pool as FormatterPool;
use Sonata\CoreBundle\Model\ManagerInterface;

use Knp\Menu\ItemInterface as MenuItemInterface;


class BlogAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('title')
                ->add('slug')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('id')
                ->add('title')
                ->add('slug')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('id')
                ->add('title')
                ->add('content', 'sonata_formatter_type', array(
                    'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                    'format_field' => 'contentFormatter',
                    'source_field' => 'rawContent',
                    'source_field_options' => array(
                        'attr' => array('class' => 'span10', 'rows' => 20)
                    ),
                    'target_field' => 'content',
                    'listener' => true,
                ))
                ->add('slug')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('title')
                ->add('content', null, array("safe" => true))
                ->add('slug')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }

    /**
     * @param \Sonata\FormatterBundle\Formatter\Pool $formatterPool
     *
     * @return void
     */
    public function setPoolFormatter(FormatterPool $formatterPool) {
        $this->formatterPool = $formatterPool;
    }

    /**
     * @return \Sonata\FormatterBundle\Formatter\Pool
     */
    public function getPoolFormatter() {
        return $this->formatterPool;
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($post) {
        $post->setContent($this->getPoolFormatter()->transform($post->getContentFormatter(), $post->getRawContent()));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($post) {
        $post->setContent($this->getPoolFormatter()->transform($post->getContentFormatter(), $post->getRawContent()));
    }

}
