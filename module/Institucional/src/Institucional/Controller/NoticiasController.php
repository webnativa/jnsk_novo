<?php

namespace Institucional\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Institucional\Entity\Noticia as Entity;
use Institucional\Form\NoticiaForm as FormPadrao;
use Institucional\Validator\NoticiaValitador as ValidatorForm;

class NoticiasController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'noticias';
    }

    protected function getFolderView() {
        return 'institucional/noticias';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Institucional\Entity\Noticia");
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

    public function filaAction() {
        
        $em = $this->getEntityManager();
        
        if(!isset($_POST['item'])){
            $this->flashMessenger()->addSuccessMessage("Escolha uma notícia");
            return $this->redirect()->toRoute($this->getSegmentRoute());
        }
        
        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $sendgrid = new \SendGrid('chicosilva', 'ledro5478wer');
        
        $usuarios = $this->getEntityManager()->getRepository("Marketing\Entity\NewsLetter")->lista();

        $itens = $_POST['item'];
        
        $noticias = $this->getRepository()->noticiasPorId($itens);

        foreach($noticias as $noticia){
            $noticia->setEnviado(1);
            $this->getEntityManager()->persist($noticia);
            $this->getEntityManager()->flush();
        }

        $renderer->noticias = $noticias;

        foreach($usuarios as $usuario){
            
            $renderer->usuario = $usuario;
            $content = $renderer->render('institucional/noticias/newsletter');

            $email = new \SendGrid\Email();
            $email->addTo($usuario->getEmail())
                    ->setFromName('FECOAGRO LEITE MINAS')
                    ->setFrom(_EMAIL_)
                    ->setSubject("Informativo")
                    ->setText($content)
                    ->setHtml($content);

            try {
                $sendgrid->send($email);
            } catch (Exception $ex) {

            }

        }

        // usuário da intranet
        $usuarios = $this->getEntityManager()->getRepository("Usuario\Entity\Usuario")->findAll();

        foreach($usuarios as $usuario){
            
            $renderer->usuario = $usuario;
            $content = $renderer->render('institucional/noticias/newsletter');

            $email = new \SendGrid\Email();
            $email->addTo($usuario->getEmail())
                    ->setFromName('FECOAGRO LEITE MINAS')
                    ->setFrom(_EMAIL_)
                    ->setSubject("Informativo")
                    ->setText($content)
                    ->setHtml($content);

            try {
                $sendgrid->send($email);
            } catch (Exception $ex) {

            }

        }
        
        $this->flashMessenger()->addSuccessMessage("Notícias enviadas com sucesso!");
        return $this->redirect()->toRoute($this->getSegmentRoute());

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
                
                if(!empty($File['name'])){
                    
                    $path = PUBLIC_PATH;
                    $imagine = new \Imagine\Gd\Imagine();
                    $result = $imagine->open($File['tmp_name'])
                       ->save("$path/uploads/noticias/". $File['name']);
                    
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
                
                if(!empty($File['name'])){
                    
                    $path = PUBLIC_PATH;
                    $imagine = new \Imagine\Gd\Imagine();
                    $result = $imagine->open($File['tmp_name'])
                       ->save("$path/uploads/noticias/". $File['name']);
                    
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

   

}
