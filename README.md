# Laravel Skeleton - Domain Driven Design

This project aims to bring some building blocks I've used in other frameworks to apply DDD tactical patterns on top of Laravel.

## Set Up
Clone the repository:

`git clone git@github.com:mgonzalezbaile/laravel-ddd.git`

Build docker containers:

`env UID=$(id -u) GID=$(id -g) docker-compose build`

Install dependencies:

`env UID=$(id -u) GID=$(id -g) docker-compose run laravel composer install`

Run migrations:

`env UID=$(id -u) GID=$(id -g) docker-compose exec laravel php artisan doctrine:migrations:migrate`

## Running The Application
To check that your local environment is working properly you can run the tests and start up the application.

### Tests Execution

`env UID=$(id -u) GID=$(id -g) docker-compose run laravel php artisan test`

### Application Start Up

`env UID=$(id -u) GID=$(id -g) docker-compose up`

Now, with your application running, you can access to the homepage by [clicking here](http://localhost:8080/).

If you want, you can start playing with the API too. The domain implemented in this application is very simple, you can create a new _Resource_ and update it via API.

#### Create a Resource

```shell script
curl -i -X POST \
   -H "Content-Type:application/json" \
   -d \
'{
  "name": "maikel",
  "attr": "aleman"
}' \
 'http://localhost:8080/api/v1/resources'
```

#### Update a Resource

```shell script
curl -i -X PUT \
   -H "Content-Type:application/json" \
   -d \
'{
  "name": "maikel",
  "attr": "aleman"
}' \
 'http://localhost:8080/api/v1/resources/54185adb-f775-4810-b40c-e9f015dab9d3'
```

**NOTE**: Make sure you replace the `id` in the URI with the one returned when the resource was created.

#### Fetch a Resource

```shell script
curl -i -X GET \
 'http://localhost:8080/api/v1/resources/54185adb-f775-4810-b40c-e9f015dab9d3'
```

**NOTE**: Make sure you replace the `id` in the URI with the one returned when the resource was created.

#### Fetch all Resources

```shell script
curl -i -X GET \
 'http://localhost:8080/api/v1/resources'
```

## DDD Tactical Patterns
In this section you will learn about the list of patterns and design decisions applied in the project with concrete examples.

### Use Case
From all the possible tactical patterns you can find in DDD's toolkit, the most important one is the _Use Case_. A use case reflects a capability (feature) that your application provides to the users: place an order, send an invoice, register a new user, ...

Because those features are the ones that define what your application does, it is crucial to make them explicit in your code base so that anyone can take a look at them and get an idea about what your system can do.

Here in the Laravel skeleton you can make use cases explicit by treating them as a first class citizen in your `app/Domain/UseCase` folder. There, you can find two different classes per use case:

#### The Command
Commands reflect the actions that you can perform on your application. They are just a simple Value Object (or DTO) holding primitive values to carry the data that the Use Case requires to be run.

```php
final class CreateResource implements Command
{
    private string $name;
    private string $attr;

    public function __construct(string $name, string $attr)
    {
        $this->name = $name;
        $this->attr = $attr;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attr(): string
    {
        return $this->attr;
    }
}
```

#### The Use Case

Use Cases are responsible for running the business logic that determines whether the input data and the current state of the application satisfy the acceptance criteria defined for that feature.

The design is quite simple, you can inject any dependency via de constructor, and you must implement the `execute` method that receives the Command. In the `execute` method is where you make sure the acceptance criteria is satisfied and, in that case, return a `UseCaseResponse`.

The `UseCaseResponse` contains two different lists:
- A list of Entities that you might create or update within the use case.
- A list of Events to notify about the fact that occurred to other parts in your application.

#### Design Decisions

The reason why both Entities and Events are returned by the Use Case is to avoid the developer to think about infrastructure details such as when to persist/save the entity in the database or when to dispatch the events. This way, you standardize these kind of actions in all your application and prevent common issues such as:
- **How to deal with a database transaction**. Because writing operations against the database block that row until the transaction is committed, this can lead to serious performance issues really hard to spot when _save_ calls are done all around your code. Also, managing other issues such as _Optimistic Concurrency_ becomes transparent for the developer.
- **How to deal with pub/sub pattern**. Dispatching events and listening to them is a powerful pattern to decouple different parts of your application, favoring SRP and OCP principles from SOLID. But, chaining code with this approach can become a hell when you start dispatching events (aka jobs) all over your code. Before you can notice, your endpoints will start becoming slower in a code base where debugging is harder as long as you chain more and morelogic.

```php
final class CreateResourceUseCase implements UseCase
{
    private UuidGenerator $uuidGenerator;

    public function __construct(UuidGenerator $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param CreateResource $command
     */
    public function execute(Command $command): UseCaseResponse
    {
        $resource = Resource::new()
            ->setId($this->uuidGenerator->v4())
            ->setName($command->name())
            ->setAttr($command->attr());

        return UseCaseResponse::new(
            Entities::new($resource),
            DomainEvents::new(new ResourceCreated($resource))
        );
    }
}
```

#### Testing Use Cases
Testing becomes easier when you see a Use Case as something that receives an input (the Command) and returns an output (the Events and Entities).

As explained before, use cases represent the features that your application provides to your users. Therefore, testing them becomes critical and helps with:
- Ensure that your features are covered against changes in your code. In this sense, tests need to be robust and decoupled from the implementation internals to allow developers refactor the code while tests ensure that the behavior of the feature didn't unexpectedly change.
- Act as documentation of your code to let someone understand the different scenarios you might encounter when running the use case.

Let's see how this can be done with an example where we update an existing _Resource_ in a happy path scenario:

```php
    public function testShouldUpdateResource(): void
    {
        $id        = 'some id';
        $aResource = Resource::new()
            ->setId($id)
            ->setName('some name')
            ->setAttr('some attr');

        $newName = 'new name';
        $newAttr    = 'new attr';

        $this
            ->withMockedServices([UuidGenerator::class => FakeUuidGenerator::class]) // This is a helper method to mock the dependencies injected via constructor to the use case
            ->given($aResource) // We want to update a resource that already exists in the database
            ->when(new UpdateResource($id, $newName, $newAttr)) // Here we define the use case we want to test
            ->thenExpectEntities($aResource->setName($newName)->setAttr($newAttr)); // Here we assert the output (entities) returned by the use case. Notice that the state of the Resource has changed. 
    }
```

In the previous test we don't know anything about the internal details of the use case (apart from the explicit dependencies injected in the constructor). We just know that, **given** a resource that already exists, **when** we want to update it, **then** we expect the state of the resource with the new input applied (and possibly the events that will notify about the fact).

Another example to show a failing scenario for the same use case:

```php
    public function testShouldFail_When_ResourceDoesntExist(): void
    {
        $name = 'some name';
        $attr = 'some attr';
        $id = 'some id';

        $this
            ->withMockedServices([UuidGenerator::class => FakeUuidGenerator::class])
            ->when(new UpdateResource($id, $name, $attr))
            ->thenExpectException(new \DomainException("Resource '$id' does not exist"));
    }
``` 

Notice that the `given` method was not called so we didn't provide an existing resource. Therefore, since the resource does not exist yet, **when** we want to update it, **then** we expect an exception telling about the error.

### Policy

Use Cases are a crucial building block to carve out our application, but _Policies_ are also very important. If a use case represents the intention to execute some action on your application, a _Policy_ represents a reaction. They fit very well when domain experts express features such as:

> When a new User is registered, send a welcome email to him.

Given that this kind of behavior is very common in an application, it is again very important to treat it as a first class citizen in your code. This Laravel Skeleton helps you on dealing with this by providing the `Policy` interface. Let's see one in action:

```php
final class ResourceCreatedPolicy implements Policy
{
    /**
     * @param ResourceCreated $event
     */
    public function when(DomainEvent $event): NextCommands
    {
        return NextCommands::new(
            NextCommand::new(new WelcomeResource($event->id())),
            NextCommand::new(new DoSomething()),
        );
    }
}
```

By implementing the previous class, we are creating a listener subscribed to the event `ResourceCreated` that will dispatch two different commands when that event is received. In this case, we are dispatching:
- `WelcomeResource` command which will trigger the `WelcomeResourceUseCase` automatically.
- `DoSomething` command which will trigger the `DoSomethingUseCase` automatically.

This way, we can parallelize the execution of two different commands if we are relying on some asynchronous mechanism such as redis, sqs, rabbitmq, etc. Again, the developer does not need to think about when and how to disptach the commands so all the infrastructure complexity is already managed by the skeleton.

Let's see now how we can test these kind of workflows:

```php
final class CreateResourceProcessTest extends BusinessProcessScenario
{
    public function testHappyPath(): void
    {
        $entities = [];

        $this
            ->given(...$entities) // Again we can provide some entities that need to exist in the database for the first Use Case to run
            ->when(new CreateResource('some name', 'some attr')) // This is the first Use Case that will trigger the workflow
            ->then([
                CreateResource::class => [ // This is the first Use Case that is executed
                    ResourceCreated::class => [ // This is the event returned by the CreateResource use case
                        WelcomeResource::class => [ // This is a Use Case that will be executed when a Resource is created
                            ResourceWelcomed::class => [] // This is the event returned by the WelcomeResource use case. Notice the empty array assignation to define that there are not more use cases chained.
                        ],
                        DoSomething::class     => [ // This is also a Use Case that will be executed when a Resource is created
                            SomethingDone::class => [] // This is the event returned by the DoSomething use case. Notice the empty array assignation to define that there are not more use cases chained.
                        ]
                    ]
                ]
            ]);
    }
}
```

Although the test might look a bit hard to read at first glance, it clearly represents the execution flow of commands and events. Thanks to this test, we have a place where we can clearly see how the execution of different use cases are chained as well as which events trigger which use cases.

### Async Listeners
In order to consume both events and commands asynchronously a worker must be executed:

`env UID=(id -u) GID=(id -g) docker-compose exec laravel php artisan queue:work --queue=laravel-ddd --tries=5 --delay=1` 

- `--queue`: The name of the laravel application (see `APP_NAME` in `.env` file).
- `--tries`: Maximum number of failed attempts to consume a message.
- `--delay`: Time in seconds to wait between attempts.

After the maximum number of attempts is reached the message is stored in the `failed_jobs` database table.

## Hexagonal Architecture

Hexagonal Architecture (aka Clean Architecture, Ports & Adapters Architecture, Onion Architecture, ...) focuses on defining a clear separation between two concepts mainly that involve any given application:
- **The Domain**: The Domain layer is the place where you define the business behavior of your application, that is, the Models, Events, Use Cases and Policies. Here we, as developers, must be focused on capturing the Ubiquitous Language used in the company to explicitly represent the concepts of our business.
- **The Infrastructure**: The Infrastructure layer is responsible for providing the connectors between our domain (business logic) and the exterior. Here we can divide the different components into two groups:
    - Input: Provides mechanisms for an external client to execute a Use Case.
        - Controllers: In order to execute a Use Case, we might need an API to allow a client send a request to our server.
        - CLI Commands: Sometimes we might need to run a use case via a console command.
    - Output: Provides mechanisms for our application to talk to external systems.
        - Persistence: In order to preserve the state of our system we need to store it in some database.
        - Third party systems: We might need from an external application to run a use case, such as a Payment Gateway (i.e. stripe, braintree and so on) to perform a payment.
 
 This Laravel Skeleton provides a directory structure ready to organize your code based on the Hexagonal Architecture principles (see `app/Domain` and `app/Infrastructure` folders).

Find below an example of a Controller that receives an HTTP Request, extracts the content from the payload and dispatchs a command to trigger the execution of its respective Use Case:

```php
final class SomeResourceCollection extends AbstractRestfulResource
{
    public function post(Request $request)
    {
        $result = $this->commandBus->handle(new CreateResource(
            $request->input('name'),
            $request->input('attr'),
        ));

        return new JsonResponse(['id' => $result->entities()->first()->id()]);
    }
}
```
