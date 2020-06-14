<?php

namespace AshAllenDesign\LaravelExecutor\Traits;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use ReflectionClass;

trait DesktopNotifications
{
    /**
     * The path to the Laravel Executor logo. This can be
     * used to display the logo in the notifications.
     *
     * @var string
     */
    private $logoPath = __DIR__.'/../../resources/img/logo.png';

    /**
     * Add a desktop notification to the Executor queue.
     *
     * @param  Notification  $notification
     * @return $this
     */
    public function desktopNotification(Notification $notification): self
    {
        $notifier = NotifierFactory::create();

        $notifier->send($notification);

        return $this;
    }

    /**
     * Build a simple notification using just a title and
     * a body. Then add it to the Executor queue for
     * running.
     *
     * @param  string  $title
     * @param  string  $body
     * @return $this
     */
    public function simpleDesktopNotification(string $title, string $body): self
    {
        $notification = (new Notification())
            ->setTitle($title)
            ->setBody($body)
            ->setIcon($this->logoPath);

        return $this->desktopNotification($notification);
    }

    /**
     * A notification that can be displayed once the entire
     * executor has been run.
     *
     * @return DesktopNotifications
     * @throws \ReflectionException
     */
    public function completeNotification(): self
    {
        $executorName = (new ReflectionClass($this))->getShortName();

        return $this->desktopNotification(
            (new Notification())
                ->setTitle('Executor complete!')
                ->setBody('The '.$executorName.' executor has been run successfully.')
                ->setIcon($this->logoPath)
        );
    }
}
