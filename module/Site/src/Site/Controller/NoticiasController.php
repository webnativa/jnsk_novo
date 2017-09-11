<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Site\Form\NewsLetterForm;
use Site\Validator\NewsLetterValitador as ValidatorForm;


class NoticiasController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }
    
    public function indexAction() {
        
        $em = $this->getEntityManager();
        $query = $em->getRepository("Institucional\Entity\Noticia")->getAll();
        
        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
          
        return (new ViewModel())
                        ->setVariable('noticias', $paginator);
    }

    public function newsLetterAction() {
        
        $em = $this->getEntityManager();
        $query = $em->getRepository("Institucional\Entity\Noticia")->getAll();
        
        $request = $this->getRequest();

        $email = $this->params()->fromPost('email');
        $nome = $this->params()->fromPost('nome');
                
        $result = $em->getRepository('Marketing\Entity\NewsLetter')->findOneBy(array('email' => $email));
        
        if($result){
            $this->flashMessenger()->addSuccessMessage("e-mail já cadastrado");
        }else{
             $this->flashMessenger()->addSuccessMessage("Cadastro efetuado com sucesso! Confira nossas notícias.");
        }
        
        $dados = array(
            'nome' => $nome,
            'email' => $email,
            'id' => null,
        );
        
        $em->getRepository('Marketing\Entity\NewsLetter')->save($dados);

        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        
        return (new ViewModel())
                                ->setVariable('erro', true)
                                ->setVariable('noticias', $paginator)
                                ->setTemplate('site/noticias/index');
        
    }
    
    public function detalhesAction() {

        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', false);

        $noticia = $em->getRepository("Institucional\Entity\Noticia")->find($id);

        return (new ViewModel())->setVariable('noticia', $noticia);
    }

}
