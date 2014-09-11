<?php

class PaymentsController extends AppController {


    public $helpers = array('Html','Form');
    public $components = array('Session');
    
    public function add() {
        
        if($this->request->is('post')):
            
            $pago = $this->request->data;
            
            $this->loadModel('Credit');
            
            $this->Credit->id = $pago['Payment']['credit_id'];

            $Credito                = $this->Credit->read();
            
            $saldo                  = $Credito['Credit']['financing'];
            
            $cuota                  = $Credito['Credit']['financing'] / $Credito['Credit']['term'];
            
            $residuoPago            = 0;
            
            $residuoPagoAnterior    = 0;
            
            $pagosAdelantados       = 0; 
            
            
            
            if(empty($Credito['Payment'])):
            
                $pago['Payment']['next_payment'] = $this->obtenerFechaSiguientePago($Credito['Credit']['first_payment']);
                
                $pago['Payment']['residue'] = (string)($Credito['Credit']['financing'] - ($Credito['Credit']['financing']/$Credito['Credit']['term']));
                
            else:
                
                $lastPayment = count($Credito['Payment'])-1;
            
                $pago['Payment']['next_payment'] = $this->obtenerFechaSiguientePago($Credito['Payment'][$lastPayment]['next_payment']);
                
                $pago['Payment']['residue'] = (string)($Credito['Payment'][$lastPayment]['residue'] - ($Credito['Credit']['financing']/$Credito['Credit']['term']));
                
                $residuoPagoAnterior = $Credito['Payment'][$lastPayment]['prepayment'];
                $pago['Payment']['next_payment'] = $this->obtenerFechaSiguientePago($Credito['Payment'][$lastPayment]['next_payment']);
                $pago['Payment']['residue'] = (string)$Credito['Payment'][$lastPayment]['residue'] - $pago['Payment']['amount'];
                
            endif;
            
            $cuotaTotal = $cuota + $pago['Payment']['interest'] + $pago['Payment']['fine'];
            
            if($pago['Payment']['exception'] == 1):
                $cuotaTotal = $cuotaTotal - $pago['Payment']['fine'];
            endif;
            
            if($pago['Payment']['amount'] > $cuotaTotal):
                $residuoPago = $pago['Payment']['amount'] - $cuotaTotal;
            endif;
            
            
            if( ($residuoPago / $cuota) >= 1):
                
                $pagosAdelantados = round(($residuoPago / $cuota),0);
                
                $residuoPago = $residuoPago % $cuota;   
                
            endif;
            
            $pago['Payment']['prepayment'] = (string)$residuoPago;
            
            if($this->Payment->save($pago)):
                $this->Session->setFlash('Pago guardado!');
                $this->redirect(array('controller' => 'credits','action'=>'view',$pago['Payment']['credit_id']));
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
        
        $interes = 0;
        
        if($diasTranscurridos > 30):
            
            $diasTranscurridos = 30;
        
        endif;
        
        $interes = $this->calcularInteres($saldo, $diasTranscurridos, $interesCredito);
        
        return $interes;
        
    }
    
    function calcularInteres($saldo, $diasTranscurridos, $interesCredito) {
        
        $interes = ($interesCredito/100) / 30;
        
        $interesPorDia = $interes * $saldo;
        
        $interesTotal = $interesPorDia * $diasTranscurridos;
        
        $interesTotal = round($interesTotal,2);
        
        return ($interesTotal);
        
    }
    
    function obtenerFechaSiguientePago($date) {
        
        return  date("Y-m-d", strtotime($date." + 30 day"));
        
    }
    
}
?>
