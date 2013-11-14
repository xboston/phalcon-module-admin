<?php

namespace MiniAdmin\Controllers {

    use \MiniAdmin\Helpers\EntityForm as AutoForm;
    use Phalcon\Paginator\Adapter\NativeArray as Paginator;
    use Phalcon\Paginator\Pager;

    class IndexController extends BaseController
    {

        public function _onConstruct()
        {
            $this->assets->collection('styles')->setTargetPath('final.css')->setTargetUri('assets/css/final.css')->addCss('assets/css/normalize.css')->addCss('assets/css/style.css')->addCss(
                    'assets/css/profile.css'
                );
            /**
             * for production add :
             *       ->join(true)
             *       ->addFilter(new \Phalcon\Assets\Filters\Cssmin());
             *
             */
        }

        public function indexAction()
        {

            $currentPage = abs($this->request->getQuery('page', 'int', 1));
            if ($currentPage == 0) {
                $currentPage = 1;
            }

            $pager = new Pager(
                new Paginator(array(
                                   'data'  => range(1, 200),
                                   'limit' => 10,
                                   'page'  => $currentPage,
                              )),
                array(
                     // We will use Bootstrap framework styles
                     'layoutClass' => 'Phalcon\Paginator\Pager\Layout\Bootstrap',
                     // Range window will be 5 pages
                     'rangeLength' => 5,
                     // Just a string with URL mask
                     'urlMask'     => '?page={%page_number}',
                     // Or something like this
                     // 'urlMask'     => sprintf(
                     //     '%s?page={%%page_number}',
                     //     $this->url->get(array(
                     //         'for'        => 'index:posts',
                     //         'controller' => 'index',
                     //         'action'     => 'index'
                     //     ))
                     // ),
                )
            );

            $this->view->setVar('pager', $pager);

        }

        public function createAction()
        {

            $entity = new \Posts();
            $createForm = new AutoForm($entity);

            if( $this->request->isPost() ){

                $created = $entity->create($this->request->getPost());

                if(!$created){

                    foreach ($entity->getMessages() as $message) {

                        $this->flashSession->error($message);
                    }
                }

                return $this->dispatcher->forward(['action'=>'index']);
            }

            $this->view->setVars(
                [
                'testForm' => $createForm ,
                ]
            );

        }

        public function editAction($id = 0)
        {

            $editForm = new AutoForm( \Posts::findFirst($id),'save');

            $this->view->setVars(
                [
                'testForm' => $editForm ,
                ]
            );

        }

        public function saveAction()
        {

        }

        public function deleteAction($id)
        {

        }

    }
}
