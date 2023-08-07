<?php
namespace Vendor\Module\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class UninstallData implements UninstallInterface
{
    public function __construct(private readonly EavSetupFactory $eavSetupFactory)
    {
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Remove the custom attribute
        $eavSetup->removeAttribute(Product::ENTITY, 'publisher_id');
    }
}
