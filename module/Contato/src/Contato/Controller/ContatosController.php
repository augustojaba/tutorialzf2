<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ContatosController extends AbstractActionController {

    //GET /contatos
    public function indexAction() {
        
    }

    //GET /contatos/novo
    public function novoAction() {
        
    }

    //POST /contatos/adicionar
    public function adicionarAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost()->toArray();
            $formularioValido = false;

            if ($formularioValido) {

                // lógica para inserção dos dados no banco de dados

                $this->flashMessenger()->addSuccessMessage("Contato criado com sucesso.");
                return $this->redirect()->toRoute('contatos');
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

            return $this->redirect()->toRoute('route');
        }

        $form = array(
            'nome' => 'Augusto Alves',
            "telefone_principal" => "(085) 8888-8888",
            "telefone_secundario" => "(085) 9999-9999",
            "data_criacao" => "16/04/2014",
            "data_atualizacao" => "16/04/2014",
        );

        return array('id' => $id, 'form' => $form);
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
        $form = array(
            'nome' => 'Augusto Alves',
            "telefone_principal" => "(085) 8888-8888",
            "telefone_secundario" => "(085) 8585-8585",
        );

        // dados eviados para editar.phtml
        return array('id' => $id, 'form' => $form);
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
                return $this->redirect()->toRoute('contatos', array("action" => "detalhes", "id" => $postData['id'],));
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

}