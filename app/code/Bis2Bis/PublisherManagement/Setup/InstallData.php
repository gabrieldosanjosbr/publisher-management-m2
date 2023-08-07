<?php

namespace Bis2Bis\PublisherManagement\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function __construct(private readonly EavSetupFactory $eavSetupFactory)
    {
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->insert(
            $setup->getTable('bis2bis_publisher'),
            [
                'name' => 'Companhia da Letras',
                'status' => 1,
                'address' => 'Rua Bandeira Paulista, 702, cj. 32',
                'logo' => null,
                'cnpj' => '55.789.390/0001-12'
            ]
        );

        $setup->getConnection()->insert(
            $setup->getTable('bis2bis_publisher'),
            [
                'name' => 'Aleph',
                'status' => 1,
                'address' => 'Rua Tabapuã, nº 81, Conj. 134, Itaim Bibi, São Paulo/SP',
                'logo' => null,
                'cnpj' => '53.523.551/0001-04'
            ]
        );

        $setup->endSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            'publisher_id',
            [
                'type' => 'int',
                'label' => 'Publisher',
                'input' => 'select',
                'backend' => '',
                'frontend' => '',
                'class' => '',
                'source' => 'Bis2Bis\PublisherManagement\Model\Source\Publishers',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => true,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );
    }

}
