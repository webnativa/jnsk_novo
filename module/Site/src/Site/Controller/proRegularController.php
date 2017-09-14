<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Site\Form\ContatoForm;
use Site\Validator\ContatoValitador as ValidatorForm;

class proRegularController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    public function indexAction() {

        $em = $this->getEntityManager();

        $request = $this->getRequest();

        $form = new ContatoForm($this->getEntityManager());

        $nucleos = $em->getRepository("Projeto\Entity\Nucleo")->listagemFormContato();
        $setores = $em->getRepository("Projeto\Entity\Projeto")->listagemComboContato();

        $ViewModel = (new ViewModel())
                ->setVariable('nucleos', $nucleos)
                ->setVariable('setores', $setores)
                ->setVariable('em', $em)
                ->setVariable('form', $form);

        if ($request->isPost()) {

            $validadeForm = new ValidatorForm();
            $validadeForm->setEm($em);

            $form->setInputFilter($validadeForm->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $renderer = $this->getServiceLocator()->get('ViewRenderer');

                $dados = $form->getData();
                $dados['estado'] = $this->params()->fromPost('estado');

                $nucleo = $em->getRepository("Projeto\Entity\Nucleo")->find($this->params()->fromPost('nucleo'));

                $renderer->dados = $dados;
                $content = $renderer->render('site/pro-regular/email-contato');

                $this->getServiceLocator()->get('KeepMail')
                        ->send($nucleo->getEmail(), 'Contato CCGC', $content, $form->get('email')->getValue());

                $this->getServiceLocator()->get('KeepMail')
                        ->send($nucleo->getCoorporativo(), 'Contato CCGC', $content, $form->get('email')->getValue());

                $this->flashMessenger()->addSuccessMessage("Seu contato foi enviado com sucesso!");

                return $this->redirect()->toRoute('contato', array('action' => 'index'));
            } else {

                return $ViewModel;
            }
        }

        return $ViewModel;
    }

}
