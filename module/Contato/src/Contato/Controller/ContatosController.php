<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

class ContatosController extends AbstractActionController {
    
    protected $contatoTable;

    //GET /contatos
    public function indexAction() {
        return new ViewModel(array('contatos' => $this->getContatoTable()->fetchAll()));
    }

    //GET /contatos/novo
    public function novoAction() {
        
    }

    //POST /contatos/adicionar
    public function adicionarAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost()->toArray();
            $formularioValido = true;

            if ($formularioValido) {

                // lógica para inserção dos dados no banco de dados
                
                $this->flashMessenger()->addSuccessMessage("Contato criado com sucesso.");
                return $this->redirect()->toRoute('contatos', array('action' => 'detalhes', 'id' => 1));
            } else {
                $this->flashMessenger()->addErrorMessage("Erro ao criar contato.");

                return $this->redirect()->toRoute('contatos', array('action' => 'novo'));
            }
        }
    }

    //GET /contatos/detalhes/id
    public function detalhesAction() {

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            $this->flashMessenger()->addMessage("Contato não encontrado");

            return $this->redirect()->toRoute('contatos');
        }

        try {
            //return new ViewModel(array('contato' => $this->getContatoTable()->find($id)));
            return array('contato' => $this->getContatoTable()->find($id));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('contatos');
        }
    }

    //GET /contatos/editar/id
    public function editarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // aqui vai a lógica para pegar os dados referente ao contato
        // 1 - solicitar serviço para pegar o model responsável pelo find
        // 2 - solicitar form com dados desse contato encontrado
        // formulário com dados preenchidos
        try {
            return array('contato' => $this->getContatoTable()->find($id));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('contatos');
        }

    }

    // PUT /contatos/editar/id
    public function atualizarAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;

            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                // aqui vai a lógica para editar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela atualização
                // 2 - editar dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato editado com sucesso");
                
                // redirecionar para action detalhes
                return $this->redirect()->toRoute('contatos', array("action" => "detalhes", "id" => $postData['id']));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar contato");

                // redirecionar para action editar
                return $this->redirect()->toRoute('contatos', array('action' => 'editar', "id" => $postData['id'],));
            }
        }
    }

    //DELETE /contatos/deletar/id
    public function deletarAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encotrado");
        } else {
            // aqui vai a lógica para deletar o contato no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta contato
            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Contato de ID $id deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('contatos');
    }
    
    public function getContatoTable() {
        
        if(!$this->contatoTable) {
            $this->contatoTable = $this->getServiceLocator()->get('ModelContato');
        }
        
        return $this->contatoTable;
    }

}
