<?php
namespace Askantech\Threesixty\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /**
         * Add attributes to the eav_attribute
         */
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'image_360_enable');
        for($i=1;$i<37;$i++) {
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'Image_360_position_'.$i);
        }
        $statusOptions = 'Askantech\Threesixty\Model\Config\Source\StatusOptions';
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'image_360_enable',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Enable 360 Image',
                'input' => 'boolean',
                'class' => '',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'unique' => false,
                'apply_to' => ''
            ]
        );

        /**
         * Add attributes to the eav_attribute
         */
        for($i=1;$i<37;$i++) {
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'Image_360_position_'.$i,
                [
                    'type' => 'varchar',
                    'label' => 'Image 360 position '.$i,
                    'input' => 'media_image',
                    'required' => false,
                    'sort_order' => 30,
                    'frontend' => \Magento\Catalog\Model\Product\Attribute\Frontend\Image::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'used_in_product_listing' => false,
                    'user_defined' => false,
                    'visible' => false,
                    'visible_on_front' => false
                ]
            );
            $id = $eavSetup->getAttributeId(
                \Magento\Catalog\Model\Product::ENTITY,
                'Image_360_position_'.$i
            );
    
            $attributeSetId = $eavSetup->getDefaultAttributeSetId(\Magento\Catalog\Model\Product::ENTITY);
            $eavSetup->addAttributeToGroup(\Magento\Catalog\Model\Product::ENTITY, $attributeSetId, 'image-management', $id, 10);
        }
        
    }
}