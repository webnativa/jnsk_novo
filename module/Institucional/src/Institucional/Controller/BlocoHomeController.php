<?php

namespace Institucional\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Institucional\Entity\BlocoHome as Entity;
use Institucional\Form\BlocoHomeForm as FormPadrao;
use Institucional\Validator\BlocoHomeValitador as ValidatorForm;
use Imagine\Image\ImageInterface;

class BlocoHomeController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'bloco-home';
    }

    protected function getFolderView() {
        return 'institucional/bloco-home';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Institucional\Entity\BlocoHome");
    }

    public function indexAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $nome = $this->params()->fromQuery('nome', null);

        $query = $this->getRepository()->getAll($nome);

        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        return (new ViewModel())
                        ->setVariable('titulo', Entity::getPluralName())
                        ->setVariable('registros', $paginator)
                        ->setVariable('paramsQuery', $this->params())
                        ->setVariable('routeController', $this->getSegmentRoute());
    }

    public function novoAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $request = $this->getRequest();

        $form = new FormPadrao($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $request->getPost()->toArray();
                $File = $this->params()->fromFiles('imagem');

                if (!empty($File['name'])) {

                    $path = PUBLIC_PATH;
                    $imagine = new \Imagine\Gd\Imagine();
                    $result = $imagine->open($File['tmp_name'])
                            ->save("$path/uploads/institucional/" . $File['name']);

                    $data['imagem'] = $File['name'];
                }

                $this->getRepository()->save($data);

                $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) com sucesso!");

                return $this->redirect()->toRoute($this->getSegmentRoute());
            } else {

                return (new ViewModel())
                                ->setVariable('form', $form)
                                ->setVariable('erro', true)
                                ->setVariable('routeController', $this->getSegmentRoute())
                                ->setTemplate($this->getFolderView() . '/novo');
            }
        }

        $dados = ['form' => $form,
            'titulo' => 'Adicionar ' . Entity::getVerboseName(),
            'routeController' => $this->getSegmentRoute()
        ];

        return $dados;
    }

    public function editarAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $id = (int) $this->params()->fromRoute('id', false);

        $registro = $this->getRepository()->find($id);

        $request = $this->getRequest();

        $form = new FormPadrao($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('form', $form)
                ->setVariable('registro', $registro)
                ->setVariable('routeController', $this->getSegmentRoute())
                ->setVariable('titulo', 'Editar ' . Entity::getVerboseName())
                ->setTemplate($this->getFolderView() . '/novo');


        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $request->getPost()->toArray();
                $File = $this->params()->fromFiles('imagem');

                if (!empty($File['name'])) {

                    $path = PUBLIC_PATH;
                    $imagine = new \Imagine\Gd\Imagine();
                    $result = $imagine->open($File['tmp_name'])
                            ->save("$path/uploads/institucional/" . $File['name']);

                    $data['imagem'] = $File['name'];
                }

                $this->getRepository()->save($data);

                $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " editado(a) com sucesso!");

                return $this->redirect()->toRoute($this->getSegmentRoute());
            } else {

                return (new ViewModel())
                                ->setVariable('form', $form)
                                ->setVariable('erro', true)
                                ->setVariable('registro', $registro)
                                ->setVariable('routeController', $this->getSegmentRoute())
                                ->setVariable('titulo', 'Editar ' . Entity::getVerboseName())
                                ->setTemplate($this->getFolderView() . '/novo');
            }
        }

        $hydrator = new DoctrineHydrator($this->getEntityManager(), get_class($registro));
        $form->setHydrator($hydrator);
        $form->bind($registro);

        return (new ViewModel())
                        ->setVariable('form', $form)
                        ->setVariable('registro', $registro)
                        ->setVariable('routeController', $this->getSegmentRoute())
                        ->setVariable('titulo', 'Editar ' . Entity::getVerboseName())
                        ->setTemplate($this->getFolderView() . '/novo');
    }

    public function removerAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $id = (int) $this->params()->fromRoute('id', 0);

        $registro = $this->getRepository()->find($id);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $registro->setDataCancelamento();
            $this->getEntityManager()->persist($registro);
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " removido(a) com sucesso!");
            return $this->redirect()->toRoute($this->getSegmentRoute());
        }

        return (new ViewModel())
                        ->setVariable('registro', $registro)
                        ->setVariable('routeController', $this->getSegmentRoute())
                        ->setVariable('titulo', 'Remover ' . Entity::getVerboseName());
    }

    public function imagemAction() {

        $imagine = new \Imagine\Gd\Imagine();

        $imagem = $this->params()->fromQuery('image');
        $x = $this->params()->fromQuery('x');
        $y = $this->params()->fromQuery('y');

        $size = new \Imagine\Image\Box($x, $y);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

        $options = array(
            'resolution-units' => \Imagine\Image\ImageInterface::RESOLUTION_PIXELSPERINCH,
            'resolution-x' => 300,
            'resolution-y' => 300,
            'jpeg_quality' => 100,
            'png_compression_level' => 9,
        );

        $dados_img = explode('.', $imagem);

        $path = PUBLIC_PATH;

        echo $imagine->open("$path/uploads/{$imagem}")
                ->thumbnail($size, $mode)
                ->show(end($dados_img), $options);

        exit;
    }

    public function nucleoAction() {

        $imagine = new \Imagine\Gd\Imagine();

        $imagem = $this->params()->fromQuery('image');
        $x = $this->params()->fromQuery('x');
        $y = $this->params()->fromQuery('y');

        $size = new \Imagine\Image\Box($x, $y);

        $options = array();

        $dados_img = explode('.', $imagem);

        $path = PUBLIC_PATH;

        echo $imagine->open("$path/uploads/{$imagem}")
                ->resize($size)
                ->show(end($dados_img), $options);

        exit;
    }
    
    
    public function centralAction() {

        $imagine = new \Imagine\Gd\Imagine();

        $imagem = $this->params()->fromQuery('image');
        $x = $this->params()->fromQuery('x');
        $y = $this->params()->fromQuery('y');

        $size = new \Imagine\Image\Box($x, $y);

         $options = array(
            'resolution-units' => ImageInterface::RESOLUTION_PIXELSPERINCH,
            'resolution-x' => 300,
            'resolution-y' => 300,
            'jpeg_quality' => 100,
            'png_compression_level' => 9,
        );

        $dados_img = explode('.', $imagem);

        $path = PUBLIC_PATH;

        echo $imagine->open("$path/uploads/{$imagem}")
//                ->resize($size)
                ->show(end($dados_img), $options);

        exit;
    }

}
