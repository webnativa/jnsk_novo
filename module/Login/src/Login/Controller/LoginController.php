<?php

namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Form\LoginForm;
use Login\Validator\LoginValitador as ValidatorForm;
use Zend\Authentication\Storage\Session as SessionStorage;

use Usuario\Form\RecuperarSenhaForm;
use Usuario\Form\RedefinirSenhaForm;
use Usuario\Validator\RedefinirValidator;
use Usuario\Validator\RecuperarSenhaValitador;

class LoginController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'login';
    }

    protected function getFolderView() {
        return 'login/login';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Admin\Entity\Admin");
    }

    public function indexAction() {
        
        $em = $this->getEntityManager();
        
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('admin'));
        
        $request = $this->getRequest();
        
        $form = new LoginForm($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());
            
            $email = $form->get('email')->getValue();
            $senha = $form->get('senha')->getValue();
            
            $adapter = $authService->getAdapter();

            $options = new \DoctrineModule\Options\Authentication;
            $options->setObjectManager($em);
            $options->setIdentityProperty('email');
            $options->setCredentialProperty('senha');
            $options->setIdentityClass('\Admin\Entity\Admin');
            $options->setCredentialCallable(function (\Admin\Entity\Admin $user, $passwordGiven) {
                return (new \Admin\Entity\Admin())->hashPassword($user, $passwordGiven);
            });
            $adapter->setIdentityValue($email);
            $adapter->setCredentialValue($senha);
            
            $adapter->setOptions($options);
            
            $authResult = $authService->authenticate();
            
            if ($form->isValid() && $authResult->isValid()) {
                
                $user = $em->getRepository("Admin\Entity\Admin")->find($authResult->getIdentity()->getId());
               
                return $this->redirect()->toRoute('noticias');
                
            } else {
                
                return (new ViewModel())
                                ->setVariable('form', $form)
                                ->setVariable('erro', true)
                                ->setTerminal(true);
            }
        }

        return (new ViewModel())
                        ->setVariable('form', $form)
                        ->setTerminal(true);
    }
    
    public function recuperarSenhaAction() {

        $em = $this->getEntityManager();

        $request = $this->getRequest();
        $form = new RecuperarSenhaForm($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('form', $form)
                ->setTerminal(true);

        if ($request->isPost()) {

            $validadeForm = new RecuperarSenhaValitador();
            $validadeForm->setEm($em);

            $form->setInputFilter($validadeForm->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $email = $form->get('email')->getValue();

                $usuario = $em->getRepository('Admin\Entity\Admin')->findOneBy(array('email' => $email));

                $usuario->setToken();
                $em->persist($usuario);
                $em->flush();

                $renderer = $this->getServiceLocator()->get('ViewRenderer');
                $renderer->usuario = $usuario;
                $content = $renderer->render('login/login/email-recuperar-senha', null);

                $this->getServiceLocator()->get('KeepMail')
                        ->send($email, 'Redefinir Senha', $content);

                $this->flashMessenger()->addSuccessMessage("Para redefinir sua senha, siga as instruções enviadas para seu e-mail.");
                return $this->redirect()->toRoute('login', array('action' => 'recuperar-senha'));
                
            } else {

                return $ViewModel;
            }
        }

        return $ViewModel;
    }

    public function redefinirAction() {

        $token = $this->params()->fromQuery('token');

        $em = $this->getEntityManager();

        $request = $this->getRequest();

        $form = new RedefinirSenhaForm($this->getEntityManager());
        
        $ViewModel = (new ViewModel())
                ->setVariable('form', $form)
                ->setTerminal(true)
                ->setVariable('token', $token);

        if ($request->isPost()) {

            $validadeForm = new RedefinirValidator();

            $form->setInputFilter($validadeForm->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                
                $usuario = $em->getRepository('Admin\Entity\Admin')->findOneBy(array('token' => $token));
                
                if($usuario){
                    
                    $senha = $form->get('senha')->getValue();
                
                    $usuario->setTokenNull();
                    $usuario->setSenha($senha);
                    $em->persist($usuario);
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage("Senha alterada com sucesso!");
                    return $this->redirect()->toUrl('/gestao/login');
                }
                return $this->redirect()->toUrl('/gestao/login');
                
            } else {
                
                return $ViewModel;
            }
        }

        return $ViewModel;
    }
    
    public function sairAction() {
        
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('admin'));
        
        if($this->identity()){
            $authService->clearIdentity();
        }
        
        return $this->redirect()->toRoute('login');
    }

}
