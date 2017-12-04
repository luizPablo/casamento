<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionSalvarContribuicao(){
        $nome = $_POST['nomec'];
        $valor = $_POST['valorc'];
        $id = $_POST['idp'];
        
        $arrReturn = array(
            "erro"      => true
        );
        
        $c = new Contribuinte;
        $c->Presente_idPresente = $id;
        $c->nome = strtoupper($nome);
        $c->valor_contribuicao = $valor;
        if($c->save()){
            $presente = Presente::model()->findByPk($id);
            $presente->acumulado = $presente->acumulado + $valor;
            if($presente->update()){
                $arrReturn = array(
                    "erro"      => false
                );
            }
        }
        
        echo json_encode($arrReturn);
    }
    
    public function actionConfirmarPresenca(){
        $nome = $_POST['nomec'];
        
        $arrReturn = array(
            "erro"      => true
        );
        
        $c = new Convidado;
        $c->nome = strtoupper($nome);
        
        if($c->save()){
            $arrReturn = array(
                "erro"      => false
            );
        }
        
        echo json_encode($arrReturn);
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionSobreEle() {
        $this->render('sobreele');
    }
    
    public function actionSobreEla() {
        $this->render('sobreela');
    }
    
    public function actionGaleria(){
        $this->render('galeria');
    }
    
    public function actionLocal(){
        $this->render('local');
    }
    
    public function actionHistoria(){
        $this->render('historia');
    }
    
    public function actionMadrinhas(){
        $this->render('madrinhas');
    }
    
    public function actionPadrinhos(){
        $this->render('padrinhos');
    }
    public function actionPresentes(){
        $this->render('presentes');
    }
    
    public function actionPresenca(){
        $this->render('presenca');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
