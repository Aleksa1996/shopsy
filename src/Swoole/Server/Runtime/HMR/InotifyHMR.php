<?php

namespace App\Swoole\Server\Runtime\HMR;

use Swoole\Server;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;
use K911\Swoole\Server\Runtime\BootableInterface;
use K911\Swoole\Server\Runtime\HMR\HotModuleReloaderInterface;

final class InotifyHMR implements HotModuleReloaderInterface, BootableInterface
{
    /**
     * @var array file path => true map
     */
    private $nonReloadableFiles = [];

    /**
     * @var array file path => true map
     */
    private $watchedFiles;

    /**
     * @var resource returned by \inotify_init
     */
    private $inotify;

    /**
     * @var int \IN_ATRIB
     */
    private $watchMask;

    /**
     * @var string[]
     */
    private $directoriesToWatch = [
        '/var/www/html/src/Shopsy/',
        // '/var/www/html/src/DataPersister',
        // '/var/www/html/src/DataProvider',
        // '/var/www/html/src/DataTransformer',
        // '/var/www/html/src/Dto',
        // '/var/www/html/src/Entity',
        // '/var/www/html/src/EventSubscriber',
        // '/var/www/html/src/Migrations',
        // '/var/www/html/src/Repository'
    ];

    /**
     * @var HotModuleReloaderInterface
     */
    private $decorated;

    /**
     * Construct object
     *
     * @param HotModuleReloaderInterface $decorated
     * @throws AssertionFailedException
     */
    public function __construct(HotModuleReloaderInterface $decorated)
    {
        Assertion::extensionLoaded('inotify', 'Swoole HMR requires "inotify" PHP Extension present and loaded in the system.');
        $this->watchMask = IN_MOVE | IN_MOVE_SELF | IN_DELETE | IN_DELETE_SELF | IN_MODIFY;
        $this->decorated = $decorated;
    }

    /**
     * Destruct object
     */
    public function __destruct()
    {
        if (null !== $this->inotify) {
            \fclose($this->inotify);
        }
    }

    /**
     * Get non reloadable files
     *
     * @return array
     */
    public function getNonReloadableFiles(): array
    {
        return \array_keys($this->nonReloadableFiles);
    }

    /**
     * Set non reloadable files
     *
     * @param array $nonReloadableFiles
     * @throws AssertionFailedException
     */
    private function setNonReloadableFiles(array $nonReloadableFiles): void
    {
        foreach ($nonReloadableFiles as $nonReloadableFile) {
            Assertion::file($nonReloadableFile);
            $this->nonReloadableFiles[$nonReloadableFile] = true;
        }
    }

    /**
     * Initialize inotify
     */
    private function initializeInotify(): void
    {
        $this->inotify = \inotify_init();
        \stream_set_blocking($this->inotify, false);
    }

    /**
     * @inheritDoc
     *
     * @throws AssertionFailedException
     */
    public function boot(array $runtimeConfiguration = []): void
    {
        if (!empty($runtimeConfiguration['nonReloadableFiles'])) {
            $this->setNonReloadableFiles($runtimeConfiguration['nonReloadableFiles']);
        }

        // Files included before server start cannot be reloaded due to PHP limitations
        $this->setNonReloadableFiles(\get_included_files());
        var_dump(
            array_filter(get_included_files(),function($v){
                return strpos($v,'Test') !== false;
            })
        );
        $this->initializeInotify();
    }

    /**
     * @inheritDoc
     */
    public function tick(Server $server): void
    {
        $events = \inotify_read($this->inotify);
        if (false !== $events) {
            var_dump('should reload');
            // posix_kill($server->manager_pid, SIGUSR1);
            // posix_kill($server->master_pid, SIGUSR1);
            // $server->reload();
//            \Swoole\Process::kill($server->manager_pid, SIGUSR1);
        }

        $this->watchFiles(\get_included_files());
    }

    /**
     * Getting additional files for watch
     */
    private function getAdditionalFiles()
    {
        $finder = new Finder();
        $finder->files()->in($this->directoriesToWatch);

        $files = [];

        foreach ($finder->files() as $file) {
            $files[] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * Getting additional files for watch
     */
    private function getAdditionalDirectories()
    {
        $finder = new Finder();
        $finder->files()->in($this->directoriesToWatch);

        $directories = [];

        foreach ($finder->directories() as $dir) {
            $directories[] = $dir->getRealPath();
        }

        return $directories;
    }

    /**
     * Set inotify watch on files and directories
     *
     * @param array $files
     */
    private function watchFiles(array $files): void
    {
        $files = array_merge($this->getAdditionalFiles(), $this->getAdditionalDirectories());

        foreach ($files as $file) {
            if (!isset($this->nonReloadableFiles[$file]) && !isset($this->watchedFiles[$file])) {
                $this->watchedFiles[$file] = \inotify_add_watch($this->inotify, $file, $this->watchMask);
            }
        }
    }
}
