<?php

namespace Media\models;

use System\Model;
use System\Query;

class MediaCategory extends Model
{
    protected $permittedColumns = array(
        'code',
        'label'
    );

    public static function getTableName()
    {
        return 'mediacategories';
    }

    public function getValidations()
    {
        $validations = parent::getValidations();

        $validations = array_merge($validations, array(
            'code' => array(
                'type' => 'required',
                'error' => 'Code obligatoire'
            ),
            'label' => array(
                'type' => 'required',
                'error' => 'Nom obligatoire'
            )
        ));

        return $validations;
    }

    public static function getOptions($where = null)
    {
        $options = array(
            0 => array(
                'value' => '',
                'label' => '---'
            )
        );

        $mediaCategories = self::findAll();

        foreach ($mediaCategories as $mediaCategory) {
            $options[$mediaCategory->id] = array(
                'value' => $mediaCategory->id,
                'label' => $mediaCategory->label
            );
        }

        return $options;
    }

    /**
     * Get a media category by code
     * @param string $code
     *
     * @return \Media\models\MediaCategory
     */
    public static function findByCode($code)
    {
        $class = get_called_class();

        $query = new Query();
        $query->select('*');
        $query->where('code = :code');
        $query->from($class::getTableName());

        $row = $query->executeAndFetch(array('code' => $code));
        
        $res = new $class($row);

        return $res;
    }
}