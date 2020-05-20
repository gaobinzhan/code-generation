<?php
/**
 * Created by PhpStorm.
 * User: tioncico
 * Date: 2020-05-20
 * Time: 10:49
 */

namespace CodeGeneration\ModelGeneration;

use CodeGeneration\CodeGeneration\ClassGeneration;
use CodeGeneration\ModelGeneration\Method\GetList;
use CodeGeneration\Unity\Unity;
use Nette\PhpGenerator\ClassType;

class ModelClassGeneration extends ClassGeneration
{
    /**
     * @var $config ModelConfig
     */
    protected $config;

    function addClassData()
    {
        $this->addClassBaseContent();
        $this->addGenerationMethod(new GetList($this));
    }

    /**
     * 新增基础类内容
     * addClassBaseContent
     * @author Tioncico
     * Time: 21:38
     */
    protected function addClassBaseContent(): ClassType
    {
        $table = $this->config->getTable();
        $phpClass = $this->phpClass;
        //配置表名属性
        $phpClass->addProperty('tableName', $table->getTable())
            ->setVisibility('protected');
        foreach ($table->getColumns() as $column) {
            $name = $column->getColumnName();
            $comment = $column->getColumnComment();
            $columnType = Unity::convertDbTypeToDocType($column->getColumnType());
            $phpClass->addComment("@property {$columnType} \${$name} // {$comment}");
        }
        return $phpClass;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        $className = $this->config->getRealTableName() . 'Model';
        return $className;
    }

}