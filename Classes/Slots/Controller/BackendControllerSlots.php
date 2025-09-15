<?php

namespace fucodo\lastchanges\Slots\Controller;

use fucodo\lastchanges\Service\ChangelogService;
use KayStrobach\Backend\Domain\Model\TopNavigation;
use Neos\Flow\Annotations as Flow;

class BackendControllerSlots
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

    public function beforeTopNavigationIsRendered(TopNavigation $topNavigation)
    {
        $changelog = $this->changelogService->getChangelog();
        $account = $this->authenticationManager->getSecurityContext()->getAccount();

        $entry = new TopNavigation\Entry(
            '
            <f:security.ifAuthenticated>
                <f:then>
                    <f:link.action action="index" controller="Changelog" package="fucodo.lastchanges" target="_top" class="{cssClass}">
                        <span class="icon">
                            <i:icon name="bootstrap-file-diff" size="16" />
                            Änderungen
                        </span>
                    </f:link.action>
                </f:then>
            </f:security.ifAuthenticated>
            ',
            'start',
            'changes'
        );

        if (!$this->changelogService->hasUserSeenChangelog($account, $changelog)) {
            $entry->assign('cssClass', 'text-bg-success');
        }
        $topNavigation->addEntryObject($entry);
    }
}
