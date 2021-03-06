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
namespace Magento\Core\App\Request;

class RewriteService
{
    /**
     * @var \Magento\Core\Model\Url\RewriteFactory
     */
    protected $_rewriteFactory;

    /**
     * @var \Magento\App\ConfigInterface
     */
    protected $_config;

    /**
     * @var \Magento\App\RouterList
     */
    protected $_routerList;

    /**
     * @param \Magento\App\RouterList $routerList
     * @param \Magento\Core\Model\Url\RewriteFactory $rewriteFactory
     * @param \Magento\App\ConfigInterface $config
     */
    public function __construct(
        \Magento\App\RouterList $routerList,
        \Magento\Core\Model\Url\RewriteFactory $rewriteFactory,
        \Magento\App\ConfigInterface $config
    ) {
        $this->_rewriteFactory = $rewriteFactory;
        $this->_config = $config;
        $this->_routerList = $routerList;
    }

    /**
     * Apply rewrites to current request
     *
     * @param \Magento\App\RequestInterface $request
     * @return void
     */
    public function applyRewrites(\Magento\App\RequestInterface $request)
    {
        // URL rewrite
        if (!$request->isStraight()) {
            \Magento\Profiler::start('db_url_rewrite');
            /** @var $urlRewrite \Magento\Core\Model\Url\Rewrite */
            $urlRewrite = $this->_rewriteFactory->create();
            $urlRewrite->rewrite($request);
            \Magento\Profiler::stop('db_url_rewrite');
        }
    }
}
