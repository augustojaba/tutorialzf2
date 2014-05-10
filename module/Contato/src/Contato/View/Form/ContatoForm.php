<?php

namespace Contato\View\Form;

use Zend\Form\Form;

class ContatoForm extends Form {
    
    public function __construct($name = null) {
        parent::__construct('contato');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'
        ));
        $this->add(array(
            'name' => 'nome',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        $this->add(array(
            'name' => 'telefone_principal',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        $this->add(array(
            'name' => 'telefone_secundario',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        $this->add(array(
            'name' => 'salvar_contato',
            'type' => 'Submit',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'id' => 'salvarContatoButton'
            )
        ));
        
    }
}