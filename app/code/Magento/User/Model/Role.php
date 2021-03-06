<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\User\Model;

/**
 * Admin Role Model
 *
 * @method \Magento\User\Model\Resource\Role _getResource()
 * @method \Magento\User\Model\Resource\Role getResource()
 * @method int getParentId()
 * @method \Magento\User\Model\Role setParentId(int $value)
 * @method int getTreeLevel()
 * @method \Magento\User\Model\Role setTreeLevel(int $value)
 * @method int getSortOrder()
 * @method \Magento\User\Model\Role setSortOrder(int $value)
 * @method string getRoleType()
 * @method \Magento\User\Model\Role setRoleType(string $value)
 * @method int getUserId()
 * @method \Magento\User\Model\Role setUserId(int $value)
 * @method string getUserType()
 * @method \Magento\User\Model\Role setUserType(string $value)
 * @method string getRoleName()
 * @method \Magento\User\Model\Role setRoleName(string $value)
 */
class Role extends \Magento\Model\AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'admin_roles';

    /**
     * @var \Magento\User\Model\Resource\Role\User\CollectionFactory
     */
    protected $_userRolesFactory;

    /**
     * @param \Magento\Model\Context $context
     * @param \Magento\Registry $registry
     * @param Resource\Role\User\CollectionFactory $userRolesFactory
     * @param Resource\Role $resource
     * @param Resource\Role\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Model\Context $context,
        \Magento\Registry $registry,
        \Magento\User\Model\Resource\Role\User\CollectionFactory $userRolesFactory,
        \Magento\User\Model\Resource\Role $resource,
        \Magento\User\Model\Resource\Role\Collection $resourceCollection,
        array $data = array()
    ) {
        $this->_userRolesFactory = $userRolesFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        $properties = parent::__sleep();
        return array_diff($properties, array('_userRolesFactory', '_resource', '_resourceCollection'));
    }

    /**
     * {@inheritdoc}
     */
    public function __wakeup()
    {
        parent::__wakeup();
        $objectManager = \Magento\App\ObjectManager::getInstance();
        $this->_userRolesFactory = $objectManager->get('Magento\User\Model\Resource\Role\User\CollectionFactory');
        $this->_resource = $objectManager->get('Magento\User\Model\Resource\Role');
        $this->_resourceCollection = $objectManager->get('Magento\User\Model\Resource\Role\Collection');
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\User\Model\Resource\Role');
    }

    /**
     * Update object into database
     *
     * @return $this
     */
    public function update()
    {
        $this->getResource()->update($this);
        return $this;
    }

    /**
     * Retrieve users collection
     *
     * @return \Magento\User\Model\Resource\Role\User\Collection
     */
    public function getUsersCollection()
    {
        return $this->_userRolesFactory->create();
    }

    /**
     * Return users for role
     *
     * @return array
     */
    public function getRoleUsers()
    {
        return $this->getResource()->getRoleUsers($this);
    }
}
