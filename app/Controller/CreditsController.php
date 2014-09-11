<?php
  App::import('Controller', 'Payments');


class CreditsController extends AppController {


    public $helpers = array('Html','Form');
    public $components = array('Session');
    
    public function index() {
        $param = array('order'=>'Credit.id desc');
        $this->set('creditos',$this->Credit->find('all',$param));
    }
    public function add() {

        if($this->request->is('post')):
            $date  = date('Y/m/d');
            $price = $this->request->data["Credit"]["product_price"];
            
//            $sale_price = $this->request->data["Credit"]["sale_price"];
            
            $term  = $this->request->data["Credit"]["term"];
            
            $down_payment = $this->request->data["Credit"]["down_payment"];
            
            $financing = $price - $down_payment;
            
            $this->request->data['Credit']['financing'] = (string)$financing;
            
            $this->request->data['Credit']['date'] = (string)$date;
            
            $this->request->data['Credit']['first_payment'] = (string)$this->primerPago();
            
            $this->request->data['Credit']['sale_price'] = $this->precioVenta($this->request->data['Credit']);
            
            $this->request->data['Credit']['financing'] = $this->request->data['Credit']['product_price'] - $down_payment;
            
            debug($this->request->data);
            
            $guarant = $this->request->data['Guarantor'];

            if($this->Credit->save($this->request->data)):
                
                if (!empty(trim($guarant['name'])) && !empty(trim($guarant['last_name']))):
                    $this->request->data['Guarantor']['credit_id'] = $this->Credit->id;
                    $this->Credit->Guarantor->save($this->request->data);
                endif;
                
                $this->Session->setFlash('Credito guardado!');
                $this->redirect(array('action'=>'view', $this->Credit->id));
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
    
    public function list_credit($clientId = null) {
        
        //Extrayendo Datos de cliente segun ID, incluye creditos
        
        $this->loadModel('Client');
        
        $this->Client->id = $clientId;
        
        $client = $this->Client->read();
        
//        debug($client);
        $this->set('client',$client);
        
        
        //Extrayendo datos de credito segun Id cliente no es necesario 
        
        //$this->set('creditos',$this->Credit->findAllByClientId($clientId, array() ,array('Credit.id' => 'desc')));
    }
    
    /**
     * 
     * @param type $id
     */
    public function view($id = null) {
        
        $payments = new PaymentsController;
        
        $this->Credit->id = $id;
        
        $credit = $this->Credit->read();
        
        $multa = 0;
        
        $diasTranscurridosMulta = 0;
        
        $fechaActual = date('Y-m-d');
        
        if(empty($credit['Payment'])):
            
            $fechaLimite = $credit['Credit']['first_payment'];
        
            $saldo = $credit['Credit']['financing'];
            
            $siguientePago = $payments->obtenerFechaSiguientePago($fechaLimite);
            
            $diasTranscurridos = $payments->diasTranscurridos($credit['Credit']['date'], $fechaActual);
            
            /*if($diasTranscurridos>30):
                
                $diasTranscurridosMulta = $diasTranscurridos - 30;
            
                $diasTranscurridos = 30;
                
                $multa = $payments->obtenerInteres($diasTranscurridosMulta, $saldo, $credit['Credit']['fine']);
            endif;
            
            $interes = $payments->obtenerInteres($diasTranscurridos, $saldo, $credit['Credit']['interest']);*/
        
        else:
            
            $lastPayment = count($credit['Payment'])-1;
        
            $fechaLimite = $credit['Payment'][$lastPayment]['next_payment'];
            
            $saldo = $credit['Payment'][$lastPayment]['residue'];
            
            $siguientePago = $payments->obtenerFechaSiguientePago($fechaLimite);
            
            $diasTranscurridos = $payments->diasTranscurridos($credit['Payment'][$lastPayment]['date_payment'], $fechaActual);
            
        endif;
        
        if($diasTranscurridos>30):
                
            $diasTranscurridosMulta = $diasTranscurridos - 30;

            $diasTranscurridos = 30;

            $multa = $payments->obtenerInteres($diasTranscurridosMulta, $saldo, $credit['Credit']['fine']);
        endif;

        $interes = $payments->obtenerInteres($diasTranscurridos, $saldo, $credit['Credit']['interest']);
        
        
        $this->set('interes',$interes);
        
        $this->set('diasTranscurridos',$diasTranscurridos);
        
        $this->set('multa',$multa);
        
        $this->set('diasTranscurridosMulta',$diasTranscurridosMulta);
        
        $this->set('siguientePago',$siguientePago);
            
        $this->set('credit',$credit);

    }
    /**
     * 
     * @param type $credit
     * @return type
     */
    private function precioVenta($credit){
        
        $saldo          = $credit['financing'];
        $saldo          = round($saldo,1);
        $pagototal      = $credit['down_payment'];
        $pagoPorMes     = $credit['financing'] / $credit['term'];
        $pagoPorMes     = round($pagoPorMes,1);
        $precioVenta    = $credit['down_payment'];
        
        for ($i=1; $i <= $credit['term']; $i++):
            $interesActual  = $saldo * ($credit['interest']/100);
            $interesActual  = round($interesActual,1);
            $saldo          = $saldo - $pagoPorMes;
            $saldo          = round($saldo, 1);
            $pagototal      = $pagototal + ($interesActual + $pagoPorMes);
            $cuotaTotal     = $interesActual + $pagoPorMes;
            $cuotaTotal     = round($cuotaTotal,1);
            $precioVenta    = round($precioVenta + $cuotaTotal);
        endfor;
        
        return (string)$precioVenta;
    }
    
    private function primerPago() {
        $dateCurrent = date('Y/m/d');
        return  date("Y-m-d", strtotime($dateCurrent." + 30 day"));
    }
    
    public function month() {
        
        $month = date('m');
        $year  = date('Y');
        
         if($this->request->is('post')):
            
            $month = $this->request->data["Credit"]["month"];
            $year  = $this->request->data["Credit"]["year"];
            
            $this->set('creditos',$this->getPaymentMonth($month,$year));
        else:
            $this->set('creditos',$this->getPaymentMonth($month,$year));
        endif;
        
        $this->set('month',$month);
        $this->set('year',$year);

        
        
    }
    private function getPaymentMonth($month, $year) {
        
        $credits = $this->Credit->findAllByStatus('1');
        
        $creditosDeudores = array();
        
        foreach ($credits as $key => $credit):
            if(empty($credit['Payment'])):
                
                $firstPaymentMonth = date('m', strtotime($credit['Credit']['first_payment']));
            
                $firstPaymentYear = date('Y', strtotime($credit['Credit']['first_payment']));
                
//                debug($month);
//                debug($year);
//                debug($firstPaymentMonth);
//                debug($firstPaymentYear);
//                
                if($firstPaymentMonth == $month && $firstPaymentYear == $year):
                   array_push($creditosDeudores,$credit);
                endif;
                
            else:
                
                $lastPayment = count($credit['Payment'])-1;
            
                $lastPaymentCreditMonth = date('m', strtotime($credit['Payment'][$lastPayment]['next_payment']));
                
                $lastPaymentCreditYear = date('Y', strtotime($credit['Payment'][$lastPayment]['next_payment']));
                
                if($lastPaymentCreditMonth == $month && $lastPaymentCreditYear == $year):
                   array_push($creditosDeudores,$credit);
                endif;
                
            endif;
            
        endforeach;
       
        return $creditosDeudores;
        
    }
    
    
}
?>
