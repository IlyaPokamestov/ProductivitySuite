# Productivity Suite

The **main goal** of this project is to recall the knowledge of the DDD concept I worked on last time in 2018.

This project will represent a simple to-do/task tracker, like Microsoft TODO or Apple Reminders applications.

I'll start this project with an analysis of similar applications and build a domain model based on it and then implement it.

In parallel, I'll try to describe why I choose one approach over another and looking forward to any feedback on the topics! 

## Technical stack

- PHP ^7.4
- Symfony ^5.0
- PostgreSQL ^13.1
- Containerization with Docker ^19.0

## Deliverables

As a result, we should get a RESTful Web API service.

## Table of contents

1) [Analysis of domain](./docs/001-analysis-of-tasks-applications.md)

## Done:
- [x] Setup Symfony 5 project.
- [x] Setup code style checks.
- [x] Setup containerization.
- [x] Setup unit testing and CI.
- [x] Setup CI.
- [x] Implement two bounded contexts with CQRS pattern.
- [x] Add REST presentation layer.
- [x] Add functional tests.
- [x] Add persistence layer.
- [x] Establish synchronous communication between bounded contexts.
- [x] Domain event listeners.
- [x] Apply Saga pattern.

## TODO:
- [ ] Implement remaining REST API endpoints.
- [ ] Fill in documentation gaps.
- [ ] Container publishing.
- [ ] CI: Data fixtures for functional tests.
- [ ] CI: Run functional tests on CI.
- [ ] Find a solution for policy checks on the query layer.
- [ ] I do not see an easy way how to make symfony messenger listed events from other bounded
contexts without explicit use of the domain event classes in the handlers.
- [ ] Bring observability
- [ ] Health checks
