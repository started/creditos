<?php

class PaymentsController extends AppController {


    public $helpers = array('Html','Form');
    public $components = array('Session');
    
    public function add() {
        
        if($this->request->is('post')):
            
            $pago = $this->request->data;
        
//            debug($pago);
            
            $this->loadModel('Credit');
            
            $this->Credit->id = $pago['Payment']['credit_id'];

            $Credito = $this->Credit->read();
            
            $cuota = $Credito['Credit']['financing'] / $Credito['Credit']['term'];
            $residuoPago = 0;
            $residuoPagoAnterior = 0;
            $pagosAdelantados = 0; 
            
            if(empty($Credito['Payment'])):
                
                $interesTotal =  $this->calcular_interes($Credito['Credit']['date'], $Credito['Credit']['interest'], $Credito['Credit']['financing'],$Credito['Credit']['fine'],$Credito['Credit']['type']);
                
                $pago['Payment']['next_payment'] = $this->siguientePago($Credito['Credit']['first_payment']);
                $pago['Payment']['residue'] = (string)($Credito['Credit']['financing'] - ($Credito['Credit']['financing']/$Credito['Credit']['term']));
            else:
                $lastPayment = count($Credito['Payment'])-1;

                $interesTotal = $this->calcular_interes($Credito['Payment'][$lastPayment]['next_payment'], $Credito['Credit']['interest'] , $Credito['Payment'][$lastPayment]['residue'],$Credito['Credit']['fine'],$Credito['Credit']['type']);
//                
                $residuoPagoAnterior = $Credito['Payment'][$lastPayment]['prepayment'];
                $pago['Payment']['next_payment'] = $this->siguientePago($Credito['Payment'][$lastPayment]['next_payment']);
                $pago['Payment']['residue'] = (string)$Credito['Payment'][$lastPayment]['residue'] - $pago['Payment']['amount'];
            endif;
            
            $cuotaTotal = $cuota + $interesTotal['interes'] + $interesTotal['multa'];
            
            if($pago['Payment']['exception'] == 1):
                $cuotaTotal = $cuotaTotal - $interesTotal['multa'];
            endif;
            
            if($pago['Payment']['amount'] > $cuotaTotal):
                $residuoPago = $pago['Payment']['amount'] - $cuotaTotal;
            endif;
            
            
            if( ($residuoPago / $cuota) >= 1){
                
                $pagosAdelantados = round(($residuoPago / $cuota),0);
                
                $residuoPago = $residuoPago % $cuota;   
                
            }
            
            $pago['Payment']['prepayment'] = (string)$residuoPago;
            
            
            if($this->Payment->save($pago)):
                $this->Session->setFlash('Pago guardado!');
                $this->redirect(array('controller' => 'credits','action'=>'view',$pago['Payment']['credit_id']));
            endif;
        

        endif;
        
    }
    
   /* public function add() {
        
        if($this->request->is('post')):
            
            $pago = $this->request->data;
            
            $this->loadModel('Credit');
            
            $this->Credit->id = $pago['Payment']['credit_id'];

            $Credito = $this->Credit->read();
            
            $cuota = $Credito['Credit']['financing'] / $Credito['Credit']['term'];
            $residuoPago = 0;
            $residuoPagoAnterior = 0;
            $pagosAdelantados = 0; 
            
            if(empty($Credito['Payment'])):
                $interesTotal =  $this->calcular_interes($Credito['Credit']['date'], $Credito['Credit']['interest'], $Credito['Credit']['financing'],$Credito['Credit']['fine']);
                $pago['Payment']['next_payment'] = $this->siguientePago($Credito['Credit']['first_payment']);
                $pago['Payment']['residue'] = (string)($Credito['Credit']['financing'] - ($Credito['Credit']['financing']/$Credito['Credit']['term']));
            else:
                $lastPayment = count($Credito['Payment'])-1;
                $interesTotal = $this->calcular_interes($Credito['Payment'][$lastPayment]['next_payment'], $Credito['Credit']['interest'] , $Credito['Payment'][$lastPayment]['residue'],$Credito['Credit']['fine']);
                $residuoPagoAnterior = $Credito['Payment'][$lastPayment]['prepayment'];
                $pago['Payment']['next_payment'] = $this->siguientePago($Credito['Payment'][$lastPayment]['next_payment']);
                $pago['Payment']['residue'] = (string)($Credito['Payment'][$lastPayment]['residue'] - ($Credito['Credit']['financing']-$Credito['Credit']['term']));
            endif;
            
            $cuotaTotal = $cuota + $interesTotal['interes'] + $interesTotal['multa'];
            
            if($pago['Payment']['exception'] == 1):
                $cuotaTotal = $cuotaTotal - $interesTotal['multa'];
            endif;
            
            if($pago['Payment']['amount'] > $cuotaTotal):
                $residuoPago = $pago['Payment']['amount'] - $cuotaTotal;
            endif;
            
            
            if( ($residuoPago / $cuota) >= 1){
                
                $pagosAdelantados = round(($residuoPago / $cuota),0);
                
                $residuoPago = $residuoPago % $cuota;   
                
            }
            
            $pago['Payment']['prepayment'] = (string)$residuoPago;
            
            
            debug($Credito);
            debug($pago);
            debug($interesTotal);
            debug($cuotaTotal);
            debug($residuoPago);
            debug($pagosAdelantados);
            
            
//            if($this->Payment->save($pago)):
//                $this->Session->setFlash('Pago guardado!');
//                $this->redirect(array('controller' => 'credits','action'=>'view',$pago['Payment']['credit_id']));
//            endif;
        

        endif;
        
    }*/
    /* public function add($creditId = null) {
        
        if($this->request->is('post')):
            if($this->Payment->save($this->request->data)):
                $this->Session->setFlash('Pago guardado!');
                $this->redirect(array('controller' => 'credits','action'=>'view',$this->request->data['Payment']['credit_id']));
            endif;
        else:
            $this->loadModel('Credit');

            $this->set('creditos',$this->Credit->findAllById($creditId, array() ,array('Credit.id' => 'desc')));

            $Credito = $this->Credit->findAllById($creditId, array() ,array('Credit.id' => 'desc'));

            $Pago = $this->Payment->findAllByCreditId($creditId, array() ,array('Payment.id' => 'desc'));

            if(empty($Pago)):

                $interesTotal =  $this->calcular_interes($Credito[0]['Credit']['date'], $Credito[0]['Credit']['interest'], $Credito[0]['Credit']['financing']);

            else:

                $interesTotal = $this->calcular_interes($Pago[0]['Payment']['date'], $Credito[0]['Credit']['interest'] , $Pago[0]['Payment']['residue']);

            endif;

            $this->set('interes',$interesTotal);

        endif;
        
    }*/
    
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
    private function dias_transcurridos($fecha_i,$fecha_f){
        
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias);
        $dias   = floor($dias);	

        return $dias;
    }
    
    public function calcular_interes($fecha, $interesCredito, $financiamiento, $fine, $type){
        
        $dateCurrent = date('Y-m-d');
        
        $intereses = array("interes" => '0', "multa" => '0','dias' => '0', 'dias_multa' => '0');
        
        $interesMulta = 0;
        $diasTranscurridos =0;
        
        if($dateCurrent > $fecha):
        
            $diasTranscurridos = $this->dias_transcurridos($fecha, $dateCurrent);

            if($diasTranscurridos > 30):
                $interesMulta = $this->calcular_multa($diasTranscurridos-30,$fine,$financiamiento);
                $intereses['multa'] = $interesMulta;
                $intereses['dias_multa'] = $diasTranscurridos-30;
                $diasTranscurridos = 30;
            else:
                $interesMulta = $this->calcular_multa($diasTranscurridos,$fine,$financiamiento);
            $intereses['multa'] = $interesMulta;
                $intereses['dias_multa'] = $diasTranscurridos;
            endif;
            
        endif;
        
        $intereses['dias'] = $diasTranscurridos;
        
        $interes = ($interesCredito/100) / 30;
        
        $interesPorDia = $interes * $financiamiento;

        $interesTotal = $interesPorDia * $diasTranscurridos;
        
        $interesTotal = round($interesTotal,2);
        
        if($type == "0"):
            $intereses['interes'] = 0;
        else:
            $intereses['interes'] = $interesTotal;
        endif;
       
        
        return $intereses;
        
    }
    private function calcular_multa($diasTranscurridos,$interesMulta,$financiamiento){
        
        $interes = ($interesMulta/100) / 30;
        
        $interesPorDia = $interes * $financiamiento;

        $interesTotal = $interesPorDia * $diasTranscurridos;
        
        $interesTotal = round($interesTotal,2);
        
        return $interesTotal;
    }
     private function calcularPago(){
         
     }
     private function siguientePago($date) {
//        $dateCurrent = date('Y/m/d');
        return  date("Y-m-d", strtotime($date." + 30 day"));
    }
    
}
?>
