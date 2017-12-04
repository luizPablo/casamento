<?php

/**
 * This is the model class for table "Contribuinte".
 *
 * The followings are the available columns in table 'Contribuinte':
 * @property integer $idContribuinte
 * @property string $nome
 * @property double $valor_contribuicao
 * @property integer $Presente_idPresente
 *
 * The followings are the available model relations:
 * @property Presente $presenteIdPresente
 */
class Contribuinte extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Contribuinte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, valor_contribuicao, Presente_idPresente', 'required'),
			array('Presente_idPresente', 'numerical', 'integerOnly'=>true),
			array('valor_contribuicao', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idContribuinte, nome, valor_contribuicao, Presente_idPresente', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'presenteIdPresente' => array(self::BELONGS_TO, 'Presente', 'Presente_idPresente'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idContribuinte' => 'Id Contribuinte',
			'nome' => 'Nome',
			'valor_contribuicao' => 'Valor Contribuicao',
			'Presente_idPresente' => 'Presente Id Presente',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idContribuinte',$this->idContribuinte);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('valor_contribuicao',$this->valor_contribuicao);
		$criteria->compare('Presente_idPresente',$this->Presente_idPresente);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contribuinte the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
