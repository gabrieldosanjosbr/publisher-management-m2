<?php

namespace Bis2Bis\PublisherManagement\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $publisherTable = $setup->getConnection()->newTable(
            $setup->getTable('bis2bis_publisher')
        )->addColumn(
            'publisher_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            200,
            ['nullable' => false]
        )->addColumn(
            'status',
            Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false]
        )->addColumn(
            'address',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false]
        )->addColumn(
            'logo',
            Table::TYPE_TEXT
        )->addColumn(
            'cnpj',
            Table::TYPE_TEXT
        )->addIndex(
            $setup->getIdxName('bis2bis_publisher', ['name']),
            ['name']
        )->setComment('Book Publishers');

        $setup->getConnection()->createTable($publisherTable);

        $setup->endSetup();
    }

}
