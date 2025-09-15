# fucodo.lastchanges

fucodo.lastchanges is a PHP Package for kaystrobach.backend, which can display the last changes from a Changelog.md file.

## Installation

Use composer to install the package

```bash
composer install fucodo/lastchanges
```

## Usage with typo3/surf

create a task

```php
    $workflow->defineTask(
        'SaveGitHistory',
        'TYPO3\\Surf\\Task\\LocalShellTask',
        array(
            'command' => 'cd {workspacePath}; git log --pretty=format:"* %as - %s" --since="7 days ago" > Changelog.md',
            'logOutput' => TRUE
        )
    );
```

run it after git checkout and updates

```php
    // ...
    $deployment->onInitialize(function() use ($workflow, $application) {
        // ...
        $workflow->beforeTask(
            'TYPO3\Surf\DefinedTask\Composer\LocalInstallTask',
            array(
                'SaveGitHistory'
            )
        );
        // ...
    }
    // ...
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
