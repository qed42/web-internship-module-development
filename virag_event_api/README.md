# Event API

Built on top of Symfony's Event Dispatcher component and allows modules to subscribe to and dispatch events

## Key Components of Drupal's Event API

Event Dispatcher      |     Event Subscriber       |        Event Object


## WorkFlow

renderButton()  - Creates a button & dispatches event.
    |
    |  dispatches
    |
dispatchButtonClickEvent  -  creates the event, sets the message
    |
    |  dispatch event
    |
ButtonClickEvent 



getSubscribedEvents()  - listens to the subscribed events.
    |
    |
onButtonRender()