<?php

namespace Contato\Model;

// import Zend\Db
use //Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class ContatoTable {

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     * 
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Recuperar todos os elementos da tabela contatos
     * 
     * @return ResultSet
     */
    public function fetchAll() {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela contatos
     * 
     * @param type $id
     * @return \Model\Contato
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id = {$id}");
        }

        return $row;
    }
    
    public function save(Contato $contato) {
        $data = array(
            'nome' => $contato->nome,
            'telefone_principal' => $contato->telefone_principal,
            'telefone_secundario' => $contato->telefone_secundario,
            'data_criacao' => $contato->data_criacao,
            'data_atualizacao' => $contato->data_atualizacao
        );
        
        $id = (int) $contato->id;
        
        if($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
            return $id;
        } else {
            if($this->find($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Não existe contato com id: '.$id);
            }
        }
    }
    
    public function deleteContato($id) {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

}
