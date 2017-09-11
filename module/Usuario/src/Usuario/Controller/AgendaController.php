<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Usuario\Entity\Agenda as Entity;
use Usuario\Form\AgendaForm as FormPadrao;
use Usuario\Validator\AgendaValitador as ValidatorForm;

class AgendaController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'agenda';
    }

    protected function getFolderView() {
        return 'usuario/agenda';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Usuario\Entity\Agenda");
    }

    public function filaAction() {

        $em = $this->getEntityManager();

        $repoFilaAgenda = $em->getRepository("Usuario\Entity\FilaAgenda");

        $fila = $repoFilaAgenda->getAll();
        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $sendgrid = new \SendGrid('chicosilva', 'ledro5478wer');
        
        foreach ($fila as $item) {

            if (!$item->getEnviado()) {

                $item->setEnviado(1);
                $item->setDataEnvio();

                $agenda = $this->getRepository()->find($item->getAgenda());

                $renderer->usuario = $item->getUsuario();
                $renderer->agenda = $this->getRepository()->find($item->getAgenda());

                $content = $renderer->render('usuario/agenda/newsletter');
                
                $users = $repoFilaAgenda->getByUsuario($item->getUsuario()->getId());

                foreach ($users as $user) {

                    $user->setEnviado(1);
                    $user->setDataEnvio();
                    $this->getEntityManager()->persist($user);
                    $this->getEntityManager()->flush();
                }
                
                $email = new \SendGrid\Email();
                
                $email
                        ->addTo($item->getUsuario()->getEmail())
                        ->setFromName('FECOAGRO LEITE MINAS')
                        ->setFrom(_EMAIL_)
                        ->setSubject("{$agenda->getNome()}")
                        ->setText($content)
                        ->setHtml($content);

                try {
                    $sendgrid->send($email);
                } catch (Exception $ex) {
                    
                }
                
            }
        }

        exit;
    }

    public function envioFilaAgendaAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $repoFilaAgenda = $em->getRepository("Usuario\Entity\FilaAgenda");

        $repoUsuario = $em->getRepository("Usuario\Entity\Usuario");

        $dados = array();
        $id = $this->params()->fromPost('agenda');

        $agenda = $this->getRepository()->find($id);

        $perfis = $agenda->getPerfilAgenda();

        $arrPerfis = array();

        foreach ($perfis as $perfil) {
            $arrPerfis[] = $perfil->getPerfil()->getId();
        }

        $perfisIds = implode(',', $arrPerfis);

        $usuarios = $repoUsuario->getUsuarioPorPerfil($perfisIds);

        foreach ($usuarios as $item) {
            $repoFilaAgenda->save($dados = ['usuario' => $item, 'agenda' => $id]);
        }

        $agenda->setEnviado(1);
        $this->getEntityManager()->persist($agenda);
        $this->getEntityManager()->flush();

        $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) a fila de envio com sucesso!");

        return $this->redirect()->toRoute($this->getSegmentRoute());
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

                $agenda = $this->getRepository()->save($form->getData());

                $repositoryNucleoAgenda = $this->getEntityManager()->getRepository("Usuario\Entity\NucleoAgenda");
                $repositoryNucleo = $this->getEntityManager()->getRepository("Projeto\Entity\Nucleo");

                $nucleos = $this->params()->fromPost('nucleo', array());

                foreach ($nucleos as $nucleo_id) {

                    $nucleo = $repositoryNucleo->find($nucleo_id);
                    $repositoryNucleoAgenda->save($agenda, $nucleo);
                }

                //Perfils
                $repositoryPerfilAgenda = $this->getEntityManager()->getRepository("Usuario\Entity\PerfilAgenda");
                $repositoryPerfil = $this->getEntityManager()->getRepository("Usuario\Entity\Perfil");

                $perfils = $this->params()->fromPost('perfil', array());

                foreach ($perfils as $perfil_id) {

                    $nucleo = $repositoryPerfil->find($perfil_id);
                    $repositoryPerfilAgenda->save($agenda, $nucleo);
                }

                $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) com sucesso!");

                return $this->redirect()->toRoute($this->getSegmentRoute());
            } else {

                return (new ViewModel())
                                ->setVariable('form', $form)
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

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $agenda = $this->getRepository()->save($form->getData());

                $repositoryNucleoAgenda = $this->getEntityManager()->getRepository("Usuario\Entity\NucleoAgenda");

                $repositoryNucleo = $this->getEntityManager()->getRepository("Projeto\Entity\Nucleo");

                $repositoryNucleoAgenda->removeNucleoAgenda($agenda->getId());

                $nucleos = $this->params()->fromPost('nucleo', array());

                foreach ($nucleos as $nucleo_id) {

                    $nucleo = $repositoryNucleo->find($nucleo_id);
                    $repositoryNucleoAgenda->save($agenda, $nucleo);
                }


                //Perfis

                $repositoryPerfilAgenda = $this->getEntityManager()->getRepository("Usuario\Entity\PerfilAgenda");

                $repositoryPerfil = $this->getEntityManager()->getRepository("Usuario\Entity\Perfil");

                $repositoryPerfilAgenda->removePerfilAgenda($agenda->getId());

                $perfis = $this->params()->fromPost('perfil', array());

                foreach ($perfis as $perfil_id) {

                    $perfil = $repositoryPerfil->find($perfil_id);
                    $repositoryPerfilAgenda->save($agenda, $perfil);
                }

                $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " editado(a) com sucesso!");

                return $this->redirect()->toRoute($this->getSegmentRoute());
            } else {

                return (new ViewModel())
                                ->setVariable('form', $form)
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
