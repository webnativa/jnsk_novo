?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Site\Form\NewsLetterForm;
use Site\Validator\NewsLetterValitador as ValidatorForm;

class NewsLetterController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    public function indexAction() {
        
        $this->layout()->setVariable('tela_newsletter', true);
        
        $em = $this->getEntityManager();
        
        $request = $this->getRequest();

        $form = new NewsLetterForm($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('form', $form);

        if ($request->isPost()) {
            
            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                
                $email = $this->params()->fromPost('email');
                
                $result = $em->getRepository('Marketing\Entity\NewsLetter')->findOneBy(array('email' => $email));
                
                if($result){
                    $this->flashMessenger()->addSuccessMessage("e-mail já cadastrado");
                    return $this->redirect()->toRoute('cadastro_newsletter');
                }
                
                $dados = $form->getData();
                $dados['id'] = null;
                
                $em->getRepository('Marketing\Entity\NewsLetter')->save($dados);
                $this->flashMessenger()->addSuccessMessage("Seu cadastro foi efetuado com sucesso!");
                return $this->redirect()->toRoute('cadastro_newsletter');
            } else {
                
                return $ViewModel;
            }
        }

        return $ViewModel;
    }

}
