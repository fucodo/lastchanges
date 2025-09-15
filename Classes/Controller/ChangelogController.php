<?php
namespace fucodo\lastchanges\Controller;

/*
 * This file is part of the fucodo.lastchanges package.
 */

use fucodo\lastchanges\Service\ChangelogService;
use KayStrobach\Backend\Controller\AbstractPageRendererController;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class ChangelogController extends AbstractpageRendererController
{
    /**
     * @Flow\Inject
     * @var ChangelogService
     */
    protected $changelogService;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Security\Authentication\AuthenticationManagerInterface
     */
    protected $authenticationManager;

    /**
     * @return void
     */
    public function indexAction()
    {
        $changelog = $this->changelogService->getChangelog();
        $account = $this->authenticationManager->getSecurityContext()->getAccount();
        $this->view->assign('changelog', $changelog);
        if ($account !== null) {
            $this->changelogService->setChangelogSeen($account, $changelog);
        }
    }
}
