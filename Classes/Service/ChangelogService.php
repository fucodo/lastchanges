<?php

namespace fucodo\lastchanges\Service;

use fucodo\lastchanges\Domain\Model\Changelog;
use fucodo\registry\Domain\Repository\RegistryEntryRepository;
use Neos\Flow\Security\Account;
use Neos\Flow\Annotations as Flow;

class ChangelogService {

    /**
     * @Flow\Inject
     * @var RegistryEntryRepository
     */
    protected $registry;

    protected ?Changelog $changelog = null;

    public function getChangelog(): Changelog
    {
        if ($this->changelog === null) {
            $this->changelog = new Changelog(FLOW_PATH_ROOT . '/Changelog.md');
        }
        return $this->changelog;
    }

    public function getChangelogHash()
    {
        return $this->getChangelog()->getHash();
    }

    public function hasUserSeenChangelog(?Account $account, Changelog $changelog)
    {
        if ($account === null) {
            return false;
        }
        $hash = $this->registry->getValue('fucodo.lastchanges.' . $account->getAccountIdentifier(), 'changelog.hash', null);
        if ($hash === null) {
            return false;
        }
        return $hash === $changelog->getHash();
    }

    public function setChangelogSeen(Account $account, Changelog $changelog)
    {
        $this->registry->set('fucodo.lastchanges.' . $account->getAccountIdentifier(), 'changelog.hash', $changelog->getHash());
    }
}
