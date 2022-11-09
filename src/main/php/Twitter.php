<?php

declare(strict_types=1);

namespace SocialNetwork;

use RuntimeException;

require 'IObservable.php';

class Twitter implements IObservable
{
    //region private attributes
    private $observers = [];
    private $twits = [];
    //endregion private attributes

    public function __construct(array $observers = [], $twits = [])
    {
        $this->subscribe($observers);
        $this->twits = $twits;
    }

    public function subscribe(array $observers): void
    {
        foreach ($observers as $observer) {
            if (in_array($observer, $this->observers, true))
                throw new SubscriberAlreadyExistsException;
            $this->observers[] = $observer;
        }
    }

    public function unsubscribe(IObserver $observer): void
    {
        if (empty($this->observers))
            throw new EmptyListOfSubscribersException;

        if (!in_array($observer, $this->observers, true))
            throw new SubscriberNotFoundException;

        unset($this->observers[array_search($observer, $this->observers, true)]);
    }

    public function notifyObservers(): void
    {
        throw new EmptyListOfSubscribersException();
    }

    public function getObservers(): array
    {
        return $this->observers;
    }

    public function getTwits(): array
    {
        return $this->twits;
    }
}

class TwitterException extends RuntimeException
{
}
class EmptyListOfSubscribersException extends TwitterException
{
}
class SubscriberAlreadyExistsException extends TwitterException
{
}
class SubscriberNotFoundException extends TwitterException
{
}
