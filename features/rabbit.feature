Feature: Whatever

  Scenario: Whatever
    Given .......
    And the queue associated to "order_create" producer is empty
    And .....
    And ..... # Assume that one of these steps publishes 2 messages in symfony application
    And .....
    And the queue associated to "order_create" producer has messages below:
      | 1 | {"id":"123","url":"http:\/\/www.a.com\/123.png","created_at":"2016-08-03T09:45:38+01:00"} |
      | 2 | {"id":"321","url":"http:\/\/www.a.com\/321.png","created_at":"2016-08-03T09:45:38+01:00"} |