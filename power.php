<?php

    class Power
    {
        public $solar;
        public $eolic;
        public $pontoInjeccao;
        public $modo;

        function __construct() {
            if ($this->solar<0){
                $this->solar=0;
            }
            if ($this->eolic<0){
                $this->eolic=0;
            }
        }


        public function Total()
        {
            return $this->solar + $this->eolic;
        }

        // Acrescenta aqui mais metodos
        public function PotenciaI()
        {
            if ($this->Total()<$this->pontoInjeccao){
                return $this->Total();
            }else {
                return $this->pontoInjeccao;
            }
        }

        public function Excedente()
        {
            if ($this->Total()<$this->pontoInjeccao){
                return 0;
            }else {
                return $this->Total()-$this->pontoInjeccao;
            }
        }

        public function Excedentesolar()
        {
            if ($this->modo == 2) {
                if ($this->Excedente() <= $this->solar) {
                    return $this->Excedente();
                } else {
                    return $this->solar;
                }
            } else {
                if ($this->Excedente() <= $this->eolic) {
                    return 0;
                } else {
                    return $this->Excedente() - $this->eolic;
                }
            }
        }

        public function Excedenteeolic()
        {
            if ($this->modo == 2) {
                if ($this->Excedente() <= $this->solar) {
                    return 0;
                } else {
                    return $this->Excedente() - $this->solar;
                }
            } else if ($this->modo == 1) {
                if ($this->Excedente() <= $this->eolic) {
                    return $this->Excedente();
                } else {
                    return $this->eolic;
                }
            }
        }

        public function Excedenteper()
        {
            if ($this->PotenciaI() == 0) {
                return 0;
            } else {
                return ($this->Excedente() / $this->Total()) * 100;
            }
        }

        public function Excedentepersolar()
        {
            if ($this->solar == 0) {
                return 0;
            } else {
                return ($this->Excedentesolar() / $this->solar) * 100;
            }
        }

        public function Excedentepereolic()
        {
            if ($this->eolic == 0) {
                return 0;
            } else {
                return ($this->Excedenteeolic() / $this->eolic) * 100;
            }
        }

    }
