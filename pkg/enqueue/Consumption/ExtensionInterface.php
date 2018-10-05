<?php

namespace Enqueue\Consumption;

use Enqueue\Consumption\Context\PreConsume;
use Enqueue\Consumption\Context\PreSubscribe;
use Enqueue\Consumption\Context\Start;

interface ExtensionInterface
{
    /**
     * Executed only once at the very beginning of the QueueConsumer::consume method call.
     */
    public function onStart(Start $context): void;

    /**
     * The method is called for each BoundProcessor before calling SubscriptionConsumer::subscribe method.
     */
    public function onPreSubscribe(PreSubscribe $context): void;

    /**
     * Executed at every new cycle before calling SubscriptionConsumer::consume method.
     * The consumption could be interrupted at this step.
     */
    public function onPreConsume(PreConsume $context): void;

    /**
     * Executed when a new message is received from a broker but before it was passed to processor
     * The context contains a message.
     * The extension may set a status. If the status is set the exception is thrown
     * The consumption could be interrupted at this step but it exits after the message is processed.
     *
     * @param Context $context
     */
    public function onPreReceived(Context $context);

    /**
     * Executed when a message is processed by a processor or a result was set in onPreReceived method.
     * BUT before the message status was sent to the broker
     * The consumption could be interrupted at this step but it exits after the message is processed.
     *
     * @param Context $context
     */
    public function onResult(Context $context);

    /**
     * Executed when a message is processed by a processor.
     * The context contains a status, which could not be changed.
     * The consumption could be interrupted at this step but it exits after the message is processed.
     *
     * @param Context $context
     */
    public function onPostReceived(Context $context);

    /**
     * Called each time at the end of the cycle if nothing was done.
     *
     * @param Context $context
     */
    public function onIdle(Context $context);

    /**
     * Called when the consumption was interrupted by an extension or exception
     * In case of exception it will be present in the context.
     *
     * @param Context $context
     */
    public function onInterrupted(Context $context);
}
