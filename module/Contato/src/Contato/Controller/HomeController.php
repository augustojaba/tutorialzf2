<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
// import Zend\Db
use Zend\Db\Sql\Sql,
    Zend\Db\ResultSet\ResultSet;

class HomeController extends AbstractActionController {
//    public function indexAction() {
//        return new ViewModel();
//    }

    /**
     * action index
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        /**
         * função anônima para var_dump estilizado
         */
        $myVarDump = function($nome_linha = "Nome da Linha", $data = null, $caracter = ' - ') {
            echo str_repeat($caracter, 100) . '<br/>' . ucwords($nome_linha) . '<pre><br/>';
            var_dump($data);
            echo '</pre>' . str_repeat($caracter, 100) . '<br/><br/>';
        };

        /**
         * conexão com banco
         */
        $adapter = $this->getServiceLocator()->get('adaptador');

        /**
         * obter nome do sehema do nosso banco
         */
        $myVarDump(
                "Nome Schema", $adapter->getCurrentSchema()
        );

        /**
         * contar quantidade de elementos da nossa tabela
         */
        $myVarDump(
                "Quantidade elementos tabela contatos", $adapter->query("SELECT * FROM `contatos`")->execute()->count()
        );

        /**
         * montar objeto sql e executar
         */
        $sql = new Sql($adapter);
        $select = $sql->select()->from('contatos');
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultsSql = $statement->execute();
        $myVarDump(
                "Objet Sql com Select executado", $resultsSql
        );

        /**
         * motar objeto resultset com objeto sql e mostrar resultado em array
         */
        $resultSet = new ResultSet;
        $resultSet->initialize($resultsSql);
        $myVarDump(
                "Resultado do Objeto Sql para Array ", $resultSet->toArray()
        );
        die();
    }

    public function sobreAction() {
        return new ViewModel();
    }

}
