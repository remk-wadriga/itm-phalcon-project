<?php

namespace models;

use abstracts\ModelAbstract;
use Phalcon\Mvc\Model\Validator\StringLength;

/**
 * Class Note
 * @package models
 * @property \models\User $user
 */
class Note extends ModelAbstract
{
    const TYPE_NOTE = 0;
    const TYPE_REMINDER = 1;

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $text;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var integer
     */
    public $position;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('user_id', User::className(), 'id', ['alias' => 'user']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'note';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Note[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Note
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function validation()
    {
        $this->validate(new StringLength([
            'field' => 'name',
            'required' => true,
            'max' => 128,
        ]))->validate(new StringLength([
            'field' => 'text',
            'required' => true,
        ]));

        return !$this->validationHasFailed();
    }

    // Events

    public function beforeValidation()
    {
        if($this->user_id === null){
            $this->user_id = $this->user()->getID();
        }
        if($this->type === null){
            $this->type = self::TYPE_NOTE;
        }
        if($this->date === null){
            $this->date = $this->timeService()->currentDateTime();
        }
        if($this->position === null){
            $this->position = 0;
        }

        return parent::beforeValidation();
    }

    // END Events
}
