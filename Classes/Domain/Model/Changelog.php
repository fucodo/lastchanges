<?php

namespace fucodo\lastchanges\Domain\Model;

class Changelog
{
    protected string $changelogFilePath = '';

    protected string $changelogFileContent = '';

    public function __construct(string $changelogFilePath)
    {
        $this->changelogFilePath = $changelogFilePath;
    }

    public function getContent()
    {
        if ($this->changelogFileContent === '') {
            if (is_file($this->changelogFilePath)) {
                $this->changelogFileContent = file_get_contents($this->changelogFilePath);
            }
        }
        return $this->changelogFileContent;
    }

    public function getHash(): string
    {
        return sha1($this->getContent());
    }
}
