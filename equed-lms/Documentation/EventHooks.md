# Event Hooks

The LMS dispatches domain events so that external systems can react to important state changes.

## LessonProgressCompletedEvent

Emitted whenever a `LessonProgress` entity is marked as completed. Apps may listen
to this event to synchronise progress with mobile clients. QMS components can
hook into it to trigger quality checks for newly completed lessons.

## SubmissionAnalyzedEvent

Emitted after a `Submission` has been analysed by the GPT evaluation service.
Use this to store analysis data in external systems or to start QMS review
workflows.

Both events are dispatched via the global `EventDispatcherInterface` and can be
subscribed to with TYPO3's `@EventListener` annotation or any PSR-14 compatible
listener registration.
