<?php

class PaymentsController extends AppController {


    public $helpers = array('Html','Form');
    public $components = array('Session');
    
    public function add() {
        
        if($this->request->is('post')):
            
            $this->loadModel('Credit');
        
            $pago               = $this->request->data;
            
            $this->Credit->id   = $pago['Payment']['credit_id'];

            $credito            = $this->Credit->read();
            
            $cuota              = $credito['Credit']['financing'] / $credito['Credit']['term'];
            
            $pago               = $this->_actualizarPago($pago, $credito);
           
            debug($pago);
            
            $siguientePago      = $this->_obtenerSiguientePago($pago['Payment']['date_payment'], $pago['Payment']['residue'] ,  $credito['Credit']['interest'], $credito['Credit']['fine'], $cuota);
            
            /*if($pago['Payment']['prepayment'] >= $siguientePago['totalInteresMulta']):
                
                $this->_addPrePayment($credito['Credit']['id'],$siguientePago,$pago['Payment']['prepayment']);
                
            endif;*/
            
            if($this->Payment->save($pago)):
                
               if ($pago['Payment']['residue'] < 1):

                   $credito['Credit']['status'] = "0";

                   $this->Credit->save($credito);

               endif;
               
               if($pago['Payment']['prepayment'] >= $siguientePago['totalInteresMulta']):
                
                    $this->_addPrePayment($credito['Credit']['id'],$siguientePago,$pago['Payment']['prepayment']);

                endif;
                
                $this->Session->setFlash('Pago guardado!');
                
                $this->redirect(array('controller' => 'credits','action'=>'view',$pago['Payment']['credit_id']));
                
            endif;
        
        endif;
        
    }
    
    public function _addPrePayment($idCredit = null,$prePago = null,$pagoCliente =null){
        
        $this->loadModel('Credit');
        
        $paymentInstance = new Payment;
        
        $this->Credit->id   = $idCredit;
        
        $prepayment = $pagoCliente - $prePago['totalInteresMulta'];
        
        $pago = array(
                    'Payment' => array(
                            'exception' => '0',
                            'amount' => (string)$pagoCliente,
                            'credit_id' => (string)$idCredit,
                            'interest' => (string)$prePago['interes'],
                            'days_elapsed' => (string)$prePago['diasTranscurridos'],
                            'residue' => (string)$prePago['nuevoSaldo'],
                            'date' => date("Y-m-d"),
                            'date_payment' => (string)$prePago['fechaLimitePagoActual'],
                            'fine' => (string)$prePago['multa'],
                            'days_elapsed_fine' => (string)$prePago['diasTranscurridosMulta'],
                            'prepayment' => (string)$prepayment,
                            'next_payment' => (string)$prePago['fechaSiguientePago'],
                    )
                );

        $credito            = $this->Credit->read();

        $cuota              = $credito['Credit']['financing'] / $credito['Credit']['term'];

        $siguientePago      = $this->_obtenerSiguientePago($pago['Payment']['date_payment'], $pago['Payment']['residue'] ,  $credito['Credit']['interest'], $credito['Credit']['fine'], $cuota);

        if($paymentInstance->save($pago)):
                
            if ($pago['Payment']['residue'] < 1):

                $credito['Credit']['status'] = "0";

                $this->Credit->save($credito);

            endif;

            if($pago['Payment']['prepayment'] >= $siguientePago['totalInteresMulta']):
                
                $this->_addPrePayment($credito['Credit']['id'],$siguientePago,$pago['Payment']['prepayment']);

            endif;


         endif;
    }
    
    public function edit($id = null) {
        $this->Credit->id = $id;
        if ($this->request->is('get')):
              $this->request->data = $this->Credit->read();
        else:
            $this->add();
        endif;
    }
    
    public function delete($id) {
        if ($this->request->is('get')):
            throw new MethodNotAllowedException();
        else:
            if ($this->Credit->delete($id)):
                $this->Session->setFlash('Credito eliminado');
                $this->redirect(array('action'=>'index'));
            endif;
        endif;
    }
    
    /**
     * 
     * @param type $pago
     * @param type $credito
     * @return type $pago
     * 
     * Actualiza datos del Pago actual
     */
    public function _actualizarPago($pago, $credito) {
        
        $cuota                  = $credito['Credit']['financing'] / $credito['Credit']['term'];
            
        $residuoPago            = 0;

        $residuoPagoAnterior    = 0;
            
        if(empty($credito['Payment'])):
            
            $fechaLimite                        = $credito['Credit']['first_payment'];

            $pago['Payment']['next_payment']    = $this->obtenerFechaSiguientePago($credito['Credit']['first_payment']);

            $pago['Payment']['residue']         = (string)($credito['Credit']['financing'] - ($credito['Credit']['financing']/$credito['Credit']['term']));

        else:

            $lastPayment                        = count($credito['Payment'])-1;
            
            $fechaLimite                        = $credito['Payment'][$lastPayment]['next_payment'];

            $pago['Payment']['next_payment']    = $this->obtenerFechaSiguientePago($credito['Payment'][$lastPayment]['next_payment']);

            $pago['Payment']['residue']         = (string)($credito['Payment'][$lastPayment]['residue'] - $cuota);

            $residuoPagoAnterior                = $credito['Payment'][$lastPayment]['prepayment'];

        endif;

        $cuotaTotal = $cuota + $pago['Payment']['interest'] + $pago['Payment']['fine'];

        if($pago['Payment']['exception'] == 1):
            $cuotaTotal = $cuotaTotal - $pago['Payment']['fine'];
        endif;

        if($pago['Payment']['amount'] > $cuotaTotal):
            $residuoPago = $pago['Payment']['amount'] - $cuotaTotal;
        endif;

        $pago['Payment']['prepayment'] = (string)$residuoPago;
        
        return $pago;
    }
    
  
    public function _verificarSiguientePago($pago, $credito) {
        
        $cuota                  = $credito['Credit']['financing'] / $credito['Credit']['term'];
            
        $residuoPago            = 0;


            
        if(empty($credito['Payment'])):
            $fechaLimite                        = $credito['Credit']['first_payment'];
        
            $saldo                              = $credito['Credit']['financing'];
        
            $saldoSiguiente                     = $saldo - $cuota;

        else:

            $lastPayment                        = count($credito['Payment'])-1;
            
            $fechaLimite                        = $credito['Payment'][$lastPayment]['next_payment'];
            
            $saldo                              = $credito['Payment'][$lastPayment]['residue'];
            
            $saldoSiguiente                     = $saldo - $cuota;

        endif;
        
        $cuotaTotal = $cuota + $pago['Payment']['interest'] + $pago['Payment']['fine'];

        if($pago['Payment']['exception'] == 1):
            $cuotaTotal = $cuotaTotal - $pago['Payment']['fine'];
        endif;
        
        $siguientePagoDatos = $this->_obtenerSiguientePago($fechaLimite, $saldoSiguiente ,  $credito['Credit']['interest'], $credito['Credit']['fine'],$cuota);

        if($pago['Payment']['amount'] > $cuotaTotal):
            $residuoPago = $pago['Payment']['amount'] - $cuotaTotal;
        endif;
        
        if($residuoPago >= $siguientePagoDatos['totalInteresMulta']):
            
        endif;

        $pago['Payment']['prepayment'] = (string)$residuoPago;
        
        return $pago;
    }
    
    public function _obtenerSiguientePago($fechaPagoLimiteAnterior, $saldo, $interesCredito, $multaCredito, $pagoPorMes) {
        
        $siguientePago              = array();
        
        $nuevoSaldo                 = $saldo - $pagoPorMes;
        
        $fechaSiguientePago         = $this->obtenerFechaSiguientePago($this->obtenerFechaSiguientePago($fechaPagoLimiteAnterior));
        
        $fechaLimitePagoActual      = $this->obtenerFechaSiguientePago($fechaPagoLimiteAnterior);
        
        $fechaActual                = date("Y-m-d");
        
        $multa                      = 0;
        
        $diasTranscurridosMulta     = 0;
        
        $diasTranscurridos          = $this->diasTranscurridos($fechaPagoLimiteAnterior,$fechaActual);
        
        if($diasTranscurridos>30):
                
            $diasTranscurridosMulta = $diasTranscurridos - 30;

            $diasTranscurridos      = 30;

            $multa                  = $this->obtenerMulta($diasTranscurridosMulta, $saldo, $multaCredito);
            
        endif;
        
        $interes = $this->obtenerInteres($diasTranscurridos, $saldo, $interesCredito);
        
        $siguientePago['interes']                   = $interes;
        $siguientePago['diasTranscurridos']         = $diasTranscurridos;
        $siguientePago['multa']                     = $multa;
        $siguientePago['diasTranscurridosMulta']    = $diasTranscurridosMulta;
        $siguientePago['saldo']                     = $saldo;
        $siguientePago['nuevoSaldo']                = $nuevoSaldo;
        $siguientePago['fechaPagoLimiteAnterior']   = $fechaPagoLimiteAnterior;
        $siguientePago['fechaLimitePagoActual']     = $fechaLimitePagoActual;
        $siguientePago['fechaSiguientePago']        = $fechaSiguientePago;
        $siguientePago['totalInteres']              = $interes + $pagoPorMes;
        $siguientePago['totalInteresMulta']         = $interes + $pagoPorMes + $multa;
        
        return $siguientePago ;

    }
    
    public function diasTranscurridos($fecha_i,$fecha_f){
        
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias);
        $dias   = floor($dias);	
        
        if (strtotime($fecha_f) < strtotime($fecha_i)) {
            $dias = 0;
        }

        return $dias;
    }
    
    public function obtenerInteres($diasTranscurridos, $saldo, $interesCredito){
        
        if($diasTranscurridos > 30):
            
            $diasTranscurridos = 30;
        
        endif;
        
        $interes = $this->calcularInteres($saldo, $diasTranscurridos, $interesCredito);
        
        return $interes;
        
    }
    
    public function obtenerMulta($diasTranscurridos, $saldo, $multaCredito){
        
        $multa = $this->calcularInteres($saldo, $diasTranscurridos, $multaCredito);
        
        return $multa;
        
    }
    
    function calcularInteres($saldo, $diasTranscurridos, $interesCredito) {
        
        $interes = ($interesCredito/100) / 30;
        
        $interesPorDia = $interes * $saldo;
        
        $interesTotal = round(($interesPorDia * $diasTranscurridos),2);
        
        return ($interesTotal);
        
    }
    
    function obtenerFechaSiguientePago($date) {
        
        return  date("Y-m-d", strtotime($date." + 30 day"));
        
    }
    
}
?>
