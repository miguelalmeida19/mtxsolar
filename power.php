<?php

    class Power
    {
        public $solar;
        public $eolic;
        public $pontoInjeccao;
        public $modo;


        public function Total()
        {
            return $this->solar + $this->eolic;
        }

        // Acrescenta aqui mais metodos
        public function PotenciaI()
        {
            if ($this->solar + $this->eolic < 2) {
                return $this->solar + $this->eolic;
            } else {
                return 2;
            }
        }

        public function Excedente()
        {
            if ($this->PotenciaI() < 2) {
                return 0;
            } else {
                return $this->PotenciaI() - 2;
            }
        }

        public function Excedentesolar()
        {
            if ($modo = 2) {
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
            if ($modo = 2) {
                if ($this->Excedente() <= $this->solar) {
                    return 0;
                } else {
                    return $this->Excedente() - $this->solar;
                }
            } else if ($modo = 1) {
                if ($this->Excedente() <= $this->eolic) {
                    return $this->Excedente;
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
