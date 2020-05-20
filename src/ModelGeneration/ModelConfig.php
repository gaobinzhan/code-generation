<?php
/**
 * Created by PhpStorm.
 * User: tioncico
 * Date: 2020-05-20
 * Time: 10:51
 */

namespace CodeGeneration\ModelGeneration;


use CodeGeneration\CodeGeneration\Config;
use EasySwoole\ORM\Utility\Schema\Table;
use EasySwoole\Utility\Str;

class ModelConfig extends Config
{
    public function __construct(Table $schemaInfo,$tablePre='',$nameSpace="App\\Model",$extendClass=\EasySwoole\ORM\AbstractModel::class)
    {
        $this->setTable($schemaInfo);
        $this->setTablePre($tablePre);
        $this->setNamespace($nameSpace);
        $this->setExtendClass($extendClass);

    }

    protected $tablePre = '';//数据表前缀
    /**
     * @var $table Table
     */
    protected $table;//表数据DDL对象
    protected $realTableName;//表(生成的文件)真实名称
    protected $ignoreString = [
        'list',
        'log'
    ];//文件名生成时,忽略的字符串(list,log等)

    /**
     * @return string
     */
    public function getTablePre(): string
    {
        return $this->tablePre;
    }

    /**
     * @param string $tablePre
     */
    public function setTablePre(string $tablePre): void
    {
        $this->tablePre = $tablePre;
    }

    /**
     * @return Table
     */
    public function getTable(): Table
    {
        return $this->table;
    }

    /**
     * @param Table $table
     */
    public function setTable(Table $table): void
    {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getRealTableName()
    {
        if ($this->realTableName) {
            return $this->realTableName;
        }
        //先去除前缀
        $tableName = substr($this->getTable()->getTable(), strlen($this->getTablePre()));
        //去除后缀
        foreach ($this->getIgnoreString() as $string) {
            $tableName = rtrim($tableName, $string);
        }
        //下划线转驼峰,并且首字母大写
        $realTableName = ucfirst(Str::camel($tableName));
        $this->setRealTableName($realTableName);
        return $realTableName;
    }

    /**
     * @param mixed $realTableName
     */
    public function setRealTableName($realTableName): void
    {
        $this->realTableName = $realTableName;
    }

    /**
     * @return array
     */
    public function getIgnoreString(): array
    {
        return $this->ignoreString;
    }

    /**
     * @param array $ignoreString
     */
    public function setIgnoreString(array $ignoreString): void
    {
        $this->ignoreString = $ignoreString;
    }


}